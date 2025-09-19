<?php
namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $surats = Surat::with('kategori')
            ->when($search, function($query, $search) {
                $query->where('nomor_surat', 'like', "%$search%")
                      ->orWhere('judul_surat', 'like', "%$search%")
                      ->orWhereHas('kategori', function($q) use ($search) {
                          $q->where('nama_kategori', 'like', "%$search%") ;
                      });
            })
            ->orderByDesc('created_at')
            ->get();
        return view('arsip.index', compact('surats'));
    }
    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('arsip.create', compact('kategoris'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'judul_surat' => 'required|string|max:255',
            // hanya file PDF, maksimal 5MB
            'file_path'  => 'required|file|mimes:pdf|max:5120',
        ], [
            'file_path.mimes' => 'File yang diupload harus berformat PDF.',
        ]);

        if (! $request->hasFile('file_path')) {
            return back()->with('error', 'Tidak ada file dikirim.');
        }

        $file = $request->file('file_path');

        if (! $file->isValid()) {
            $errCode = $file->getError();
            \Log::error('Upload error code: '.$errCode);
            return back()->with('error', 'Upload gagal. Kode error: '.$errCode.' — '. $this->uploadErrorMessage($errCode));
        }

    // Nama file: slug judul_surat + ekstensi
    $judul = $validated['judul_surat'];
    $ext = $file->getClientOriginalExtension();
    $fileName = Str::slug($judul) . '.' . $ext;

        try {
            // simpan ke disk 'public' di folder 'surat' -> hasil 'surat/slug-judul.pdf'
            $filePath = $file->storeAs('surat', $fileName, 'public');

            // cek file benar-benar tersimpan
            if (! \Storage::disk('public')->exists($filePath)) {
                \Log::error('File tidak ditemukan setelah store: '.$filePath);
                return back()->with('error', 'Gagal menyimpan file ke storage.');
            }
        } catch (\Exception $e) {
            \Log::error('Exception saat menyimpan file: '.$e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan file: '.$e->getMessage());
        }

        // simpan record ke DB
        $surat = Surat::create([
            'nomor_surat' => $validated['nomor_surat'],
            'id_kategori' => $validated['id_kategori'],
            'judul_surat' => $validated['judul_surat'],
            'file_path'   => $filePath, // "surat/xxxx.pdf"
        ]);

        return redirect()->route('arsip.index')->with('success', 'Surat berhasil diarsipkan!');
    }

    /**
     * Helper untuk menerjemahkan kode error upload ke pesan manusia.
     */
    private function uploadErrorMessage($code)
    {
        $map = [
            1 => 'File melebihi upload_max_filesize pada php.ini',
            2 => 'File melebihi MAX_FILE_SIZE pada form HTML',
            3 => 'File hanya terupload sebagian',
            4 => 'Tidak ada file yang dikirim',
            6 => 'Folder temporary hilang di server',
            7 => 'Gagal menulis ke disk',
            8 => 'Upload dihentikan oleh ekstensi PHP',
        ];
        return $map[$code] ?? 'Unknown upload error';
    }

    // Tambahkan fungsi lain (create, store, show, edit, update, destroy, download) sesuai kebutuhan
        public function show($id)
        {
            $surat = Surat::with('kategori')->findOrFail($id);
            return view('arsip.show', compact('surat'));
        }
            public function edit($id)
            {
                $surat = Surat::findOrFail($id);
                $kategoris = Kategori::orderBy('nama_kategori')->get();
                return view('arsip.edit', compact('surat', 'kategoris'));
            }

            public function update(Request $request, $id)
            {
                $validated = $request->validate([
                    'nomor_surat' => 'required|string|max:255',
                    'id_kategori' => 'required|exists:kategori,id_kategori',
                    'judul_surat' => 'required|string|max:255',
                    // hanya file PDF
                    'file_path' => 'nullable|file|mimes:pdf',
                ], [
                    'file_path.mimes' => 'File yang diupload harus berformat PDF.',
                ]);

                $surat = Surat::findOrFail($id);
                $surat->nomor_surat = $validated['nomor_surat'];
                $surat->id_kategori = $validated['id_kategori'];
                $surat->judul_surat = $validated['judul_surat'];

                if ($request->hasFile('file_path')) {
                    $file = $request->file('file_path');
                    if (! $file->isValid()) {
                        $errCode = $file->getError();
                        \Log::error('Upload error code: '.$errCode);
                        return back()->with('error', 'Upload gagal. Kode error: '.$errCode);
                    }
                    // Nama file: slug judul_surat + ekstensi
                    $judul = $validated['judul_surat'];
                    $ext = $file->getClientOriginalExtension();
                    $fileName = Str::slug($judul) . '.' . $ext;
                    try {
                        $filePath = $file->storeAs('surat', $fileName, 'public');
                        if (! \Storage::disk('public')->exists($filePath)) {
                            \Log::error('File tidak ditemukan setelah store: '.$filePath);
                            return back()->with('error', 'Gagal menyimpan file ke storage.');
                        }
                        // Hapus file lama setelah file baru berhasil di-upload
                        if ($surat->file_path && \Storage::disk('public')->exists($surat->file_path)) {
                            \Storage::disk('public')->delete($surat->file_path);
                        }
                        $surat->file_path = $filePath;
                    } catch (\Exception $e) {
                        \Log::error('Exception saat menyimpan file: '.$e->getMessage());
                        return back()->with('error', 'Terjadi kesalahan saat menyimpan file: '.$e->getMessage());
                    }
                }

                $surat->save();
                return redirect()->route('arsip.show', $surat->id_surat)->with('success', 'Surat berhasil diupdate!');
            }
        public function download($id)
        {
            $surat = Surat::findOrFail($id);
            $filePath = $surat->file_path;
            if (!$filePath || !\Storage::disk('public')->exists($filePath)) {
                return redirect()->back()->with('error', 'File surat tidak ditemukan!');
            }
            return \Storage::disk('public')->download($filePath);
        }
        public function destroy($id)
        {
            $surat = Surat::findOrFail($id);
            // Hapus file dari storage jika ada
            if ($surat->file_path && \Storage::disk('public')->exists($surat->file_path)) {
                \Storage::disk('public')->delete($surat->file_path);
            }
            $surat->delete();
            return redirect()->route('arsip.index')->with('success', 'Surat berhasil dihapus!');
        }
}

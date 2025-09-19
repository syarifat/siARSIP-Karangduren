<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $search = request('search');
        $kategoris = Kategori::when($search, function($query, $search) {
            $query->where('nama_kategori', 'like', "%$search%");
        })->orderBy('id_kategori', 'asc')->get();
        return view('kategori.index', compact('kategoris'));
    }
    public function create()
    {
        // Ambil id terakhir, jika ada
        $last = Kategori::orderByDesc('id_kategori')->first();
        $nextId = $last ? $last->id_kategori + 1 : 1;
        return view('kategori.create', compact('nextId'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'keterangan_kategori' => 'nullable|string',
        ]);
        $kategori = new Kategori();
        $kategori->nama_kategori = $validated['nama_kategori'];
        $kategori->keterangan_kategori = $validated['keterangan_kategori'] ?? null;
        $kategori->save();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'keterangan_kategori' => 'nullable|string',
        ]);
        $kategori = Kategori::findOrFail($id);
        $kategori->nama_kategori = $validated['nama_kategori'];
        $kategori->keterangan_kategori = $validated['keterangan_kategori'] ?? null;
        $kategori->save();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }
    // Tambahkan fungsi lain (create, store, edit, update, destroy) sesuai kebutuhan
}

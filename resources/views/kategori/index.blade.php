@extends('layout.sidebar')
@section('content')
<h2>Kategori Surat</h2>
<p>Berikut ini adalah daftar kategori yang bisa digunakan untuk melabeli surat.<br>
Klik "Edit" atau "Hapus" pada kolom aksi untuk mengelola kategori.</p>
<br>

<form method="GET" action="{{ route('kategori.index') }}" style="margin-bottom:18px;display:flex;gap:0;max-width:420px;">
    <input type="text" name="search" placeholder="Cari nama kategori" value="{{ request('search') }}" 
        style="padding:10px 14px;border-radius:8px 0 0 8px;border:1px solid #b6c2e1;background:#f6faff;
        font-size:1rem;flex:1;min-width:0;height:42px;box-sizing:border-box;">
    <button type="submit" 
        style="background:#1976d2;color:#fff;border:none;border-radius:0 8px 8px 0;
        padding:0 16px;font-size:1.1rem;display:flex;align-items:center;justify-content:center;
        height:42px;min-width:42px;max-width:48px;box-sizing:border-box;">
        <span style="display:inline-block;">
            <!-- Search Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7" stroke="#fff" stroke-width="2"/>
                <line x1="17" y1="17" x2="21" y2="21" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </span>
    </button>
</form>

<div style="width:100%;padding-left:32px;padding-right:32px;box-sizing:border-box;">
    <table style="width:100%;background:#fff;border-radius:16px;box-shadow:0 2px 12px #0001;
        border-collapse:collapse;overflow:hidden;padding:18px;margin-bottom:12px;">
        <thead>
            <tr>
                <th style="background:#e3eefe;font-weight:600;color:#1a237e;
                    padding:12px 16px;text-align:center;vertical-align:middle;">ID Kategori</th>
                <th style="background:#e3eefe;font-weight:600;color:#1a237e;
                    padding:12px 16px;text-align:center;vertical-align:middle;">Nama Kategori</th>
                <th style="background:#e3eefe;font-weight:600;color:#1a237e;
                    padding:12px 16px;text-align:center;vertical-align:middle;">Keterangan</th>
                <th style="background:#e3eefe;font-weight:600;color:#1a237e;
                    padding:12px 16px;text-align:center;vertical-align:middle;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $kategori)
            <tr style="border-bottom:1px solid #e3e3e3;">
                <td style="padding:12px 16px;text-align:center;vertical-align:middle;">
                    {{ $kategori->id_kategori }}
                </td>
                <td style="padding:12px 16px;text-align:center;vertical-align:middle;">
                    {{ $kategori->nama_kategori }}
                </td>
                <td style="padding:12px 16px;text-align:center;vertical-align:middle;">
                    {{ $kategori->keterangan_kategori }}
                </td>
                <td style="padding:12px 16px;display:flex;gap:8px;justify-content:center;text-align:center;vertical-align:middle;">
                    <form action="{{ route('kategori.destroy', $kategori->id_kategori) }}" method="POST" style="display:inline;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-hapus" 
                            style="background:#f33;color:#fff;border:none;border-radius:8px;
                            padding:8px 20px;font-size:1rem;font-weight:500;">Hapus</button>
                    </form>
                    <a href="{{ route('kategori.edit', $kategori->id_kategori) }}" 
                        style="background:#007bff;color:#fff;padding:8px 20px;text-decoration:none;
                        border-radius:8px;font-weight:500;">Edit</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="padding:16px;text-align:center;">Tidak ada data kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<br>
<div style="display:flex;justify-content:flex-start;align-items:center;margin-bottom:24px;">
    <a href="{{ route('kategori.create') }}">
        <button style="background:#1976d2;color:#fff;border:none;border-radius:8px;
            padding:12px 32px;font-size:1.1rem;font-weight:500;box-shadow:0 2px 8px #1976d233;">
            Tambah Kategori
        </button>
    </a>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="modal-confirm-kategori" 
    style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;
    background:rgba(0,0,0,0.2);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:18px 16px 14px 16px;border-radius:10px;
        box-shadow:0 2px 16px #0002;max-width:320px;margin:auto;text-align:center;">
        <h3 style="margin-bottom:8px;color:#1a237e;font-size:1.15rem;">Konfirmasi Hapus</h3>
        <p id="modal-message-kategori" style="margin-bottom:10px;font-size:1rem;">
            Apakah Anda yakin ingin menghapus kategori ini?
        </p>
        <div style="margin-top:8px;display:flex;justify-content:center;gap:12px;">
            <button id="modal-cancel-kategori" 
                style="padding:7px 18px;background:#eee;border:none;border-radius:6px;color:#222;font-size:1rem;">
                Batal
            </button>
            <button id="modal-yes-kategori" 
                style="padding:7px 18px;background:#1976d2;color:#fff;border:none;border-radius:6px;font-size:1rem;">
                Ya!
            </button>
        </div>
    </div>
</div>

<script>
    let kategoriFormToSubmit = null;
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function(e) {
            kategoriFormToSubmit = btn.closest('form');
            document.getElementById('modal-confirm-kategori').style.display = 'flex';
        });
    });
    document.getElementById('modal-cancel-kategori').onclick = function() {
        document.getElementById('modal-confirm-kategori').style.display = 'none';
        kategoriFormToSubmit = null;
    };
    document.getElementById('modal-yes-kategori').onclick = function() {
        if(kategoriFormToSubmit) kategoriFormToSubmit.submit();
        document.getElementById('modal-confirm-kategori').style.display = 'none';
    };
</script>
@endsection

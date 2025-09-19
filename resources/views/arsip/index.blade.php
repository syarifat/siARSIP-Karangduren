@extends('layout.sidebar')
@section('content')
<h2>Arsip Surat</h2>
<p>Berikut ini adalah surat-surat yang telah terbit dan diarsipkan.<br>Klik "Lihat" pada kolom aksi untuk menampilkan surat.</p>
<br>
<form method="GET" action="{{ route('arsip.index') }}" style="margin-bottom:18px;display:flex;gap:0;max-width:420px;">
  <input type="text" name="search" placeholder="Cari berdasarkan nama" value="{{ request('search') }}" style="padding:10px 14px;border-radius:8px 0 0 8px;border:1px solid #b6c2e1;background:#f6faff;font-size:1rem;flex:1;min-width:0;height:42px;box-sizing:border-box;">
  <button type="submit" style="background:#1976d2;color:#fff;border:none;border-radius:0 8px 8px 0;padding:0 16px;font-size:1.1rem;display:flex;align-items:center;justify-content:center;height:42px;min-width:42px;max-width:48px;box-sizing:border-box;">
    <span style="display:inline-block;">
      <!-- Search Icon SVG -->
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7" stroke="#fff" stroke-width="2"/><line x1="17" y1="17" x2="21" y2="21" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
    </span>
  </button>
</form>
<div style="width:100%;padding-left:32px;padding-right:32px;box-sizing:border-box;">
<table style="width:100%;background:#fff;border-radius:16px;box-shadow:0 2px 12px #0001;border-collapse:collapse;overflow:hidden;padding:18px;margin-bottom:12px;">
    <thead>
        <tr>
            <th style="background:#e3eefe;font-weight:600;color:#1a237e;padding:12px 16px;text-align:center;vertical-align:middle;">Nomor Surat</th>
            <th style="background:#e3eefe;font-weight:600;color:#1a237e;padding:12px 16px;text-align:center;vertical-align:middle;">Kategori</th>
            <th style="background:#e3eefe;font-weight:600;color:#1a237e;padding:12px 16px;text-align:center;vertical-align:middle;">Judul</th>
            <th style="background:#e3eefe;font-weight:600;color:#1a237e;padding:12px 16px;text-align:center;vertical-align:middle;">Waktu Pengarsipan</th>
            <th style="background:#e3eefe;font-weight:600;color:#1a237e;padding:12px 16px;text-align:center;vertical-align:middle;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($surats as $surat)
    <tr style="border-bottom:1px solid #e3e3e3;">
      <td style="padding:12px 16px;text-align:center;vertical-align:middle;">{{ $surat->nomor_surat }}</td>
      <td style="padding:12px 16px;text-align:center;vertical-align:middle;">{{ $surat->kategori->nama_kategori ?? '-' }}</td>
      <td style="padding:12px 16px;text-align:center;vertical-align:middle;">{{ $surat->judul_surat }}</td>
      <td style="padding:12px 16px;text-align:center;vertical-align:middle;">{{ $surat->created_at }}</td>
      <td style="padding:12px 16px;display:flex;gap:8px;justify-content:center;text-align:center;vertical-align:middle;">
                <form action="{{ route('arsip.destroy', $surat->id_surat) }}" method="POST" style="display:inline;" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-hapus" style="background:#f33;color:#fff;border:none;border-radius:8px;padding:8px 20px;font-size:1rem;font-weight:500;">Hapus</button>
                </form>
                <a href="{{ route('arsip.download', $surat->id_surat) }}" style="background:#ffc107;color:#222;padding:8px 20px;text-decoration:none;border-radius:8px;font-weight:500;">Unduh</a>
                <a href="{{ route('arsip.show', $surat->id_surat) }}" style="background:#007bff;color:#fff;padding:8px 20px;text-decoration:none;border-radius:8px;font-weight:500;">Lihat &gt;&gt;</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" style="padding:16px;text-align:center;">Tidak ada data surat.</td></tr>
        @endforelse
    </tbody>

  </table>
</div>
<br>
<div style="display:flex;justify-content:flex-start;align-items:center;margin-bottom:24px;">
  <a href="{{ route('arsip.create') }}">
    <button style="background:#1976d2;color:#fff;border:none;border-radius:8px;padding:12px 32px;font-size:1.1rem;font-weight:500;box-shadow:0 2px 8px #1976d233;">Arsipkan Surat</button>
  </a>
</div>


<!-- Modal Konfirmasi Hapus -->

<div id="modal-confirm" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.2);z-index:9999;align-items:center;justify-content:center;">
  <div style="background:#fff;padding:18px 16px 14px 16px;border-radius:10px;box-shadow:0 2px 16px #0002;max-width:320px;margin:auto;text-align:center;">
    <h3 style="margin-bottom:8px;color:#1a237e;font-size:1.15rem;">Konfirmasi Hapus</h3>
    <p id="modal-message" style="margin-bottom:10px;font-size:1rem;">Apakah Anda yakin ingin menghapus arsip surat ini?</p>
    <div style="margin-top:8px;display:flex;justify-content:center;gap:12px;">
      <button id="modal-cancel" style="padding:7px 18px;background:#eee;border:none;border-radius:6px;color:#222;font-size:1rem;">Batal</button>
      <button id="modal-yes" style="padding:7px 18px;background:#1976d2;color:#fff;border:none;border-radius:6px;font-size:1rem;">Ya!</button>
    </div>
  </div>
</div>

<script>
  let formToSubmit = null;
  document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function(e) {
      formToSubmit = btn.closest('form');
      document.getElementById('modal-confirm').style.display = 'flex';
    });
  });
  document.getElementById('modal-cancel').onclick = function() {
    document.getElementById('modal-confirm').style.display = 'none';
    formToSubmit = null;
  };
  document.getElementById('modal-yes').onclick = function() {
    if(formToSubmit) formToSubmit.submit();
    document.getElementById('modal-confirm').style.display = 'none';
  };
</script>
@endsection

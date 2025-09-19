@extends('layout.sidebar')
@section('content')
<h2 style="font-size:1.35rem;color:#1a237e;font-weight:600;margin-bottom:8px;">Arsip Surat <span style="color:#1976d2;font-weight:400;">&raquo;&raquo;</span> <span style="color:#1976d2;font-weight:500;">Edit</span></h2>
<div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px #0001;max-width:650px;width:100%;padding:32px 36px 28px 36px;margin-bottom:24px;">
<form action="{{ route('arsip.update', $surat->id_surat) }}" method="POST" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:18px;">
    @csrf
    @method('PUT')
    <div style="display:flex;flex-direction:column;gap:6px;">
        <label for="nomor_surat" style="font-weight:500;color:#1a237e;">Nomor Surat</label>
        <input type="text" name="nomor_surat" id="nomor_surat" value="{{ $surat->nomor_surat }}" required style="padding:10px 14px;border-radius:8px;border:1px solid #b6c2e1;background:#f6faff;font-size:1rem;">
    </div>
    <div style="display:flex;flex-direction:column;gap:6px;">
        <label for="id_kategori" style="font-weight:500;color:#1a237e;">Kategori</label>
        <select name="id_kategori" id="id_kategori" required style="padding:10px 14px;border-radius:8px;border:1px solid #b6c2e1;background:#f6faff;font-size:1rem;">
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id_kategori }}" @if($kategori->id_kategori == $surat->id_kategori) selected @endif>{{ $kategori->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div style="display:flex;flex-direction:column;gap:6px;">
        <label for="judul_surat" style="font-weight:500;color:#1a237e;">Judul Surat</label>
        <input type="text" name="judul_surat" id="judul_surat" value="{{ $surat->judul_surat }}" required style="padding:10px 14px;border-radius:8px;border:1px solid #b6c2e1;background:#f6faff;font-size:1rem;">
    </div>
    <div style="display:flex;flex-direction:column;gap:6px;">
        <label for="file_path" style="font-weight:500;color:#1a237e;">File Surat</label>
        <div style="display:flex;gap:10px;align-items:center;">
            <input type="text" id="file-name" placeholder="{{ basename($surat->file_path) }}" readonly style="flex:1;padding:8px 12px;border-radius:8px;border:1px solid #b6c2e1;background:#f6faff;font-size:1rem;">
            <label for="file_path" style="margin:0;">
                <span style="background:#1976d2;color:#fff;border:none;border-radius:8px;padding:8px 18px;font-size:1rem;font-weight:500;cursor:pointer;display:inline-block;box-shadow:0 2px 8px #1976d233;">Pilih File</span>
                <input type="file" name="file_path" id="file_path" style="display:none;">
            </label>
        </div>
        <small style="color:#1976d2;margin-top:4px;">File lama: <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank" style="color:#1976d2;text-decoration:underline;">{{ basename($surat->file_path) }}</a></small>
    </div>
    <div style="display:flex;gap:12px;align-items:center;">
        <a href="{{ route('arsip.show', $surat->id_surat) }}" style="color:#1976d2;text-decoration:none;font-weight:500;">&laquo; Kembali</a>
        <button type="submit" style="background:#1976d2;color:#fff;border:none;border-radius:8px;padding:10px 32px;font-size:1.08rem;font-weight:500;box-shadow:0 2px 8px #1976d233;">Update Surat</button>
    </div>
</form>
<script>
  const fileInput = document.getElementById('file_path');
  const fileName = document.getElementById('file-name');
  fileInput.addEventListener('change', function() {
    fileName.value = fileInput.files.length ? fileInput.files[0].name : '{{ basename($surat->file_path) }}';
  });
</script>
</div>
@endsection

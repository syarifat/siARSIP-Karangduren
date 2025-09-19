@extends('layout.sidebar')
@section('content')
<h2>Kategori Surat &gt;&gt; Edit</h2>
<div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px #0001;max-width:650px;width:100%;padding:32px 36px 28px 36px;margin-bottom:24px;">
<form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST" style="display:flex;flex-direction:column;gap:18px;">
    @csrf
    @method('PUT')
    <div style="display:flex;flex-direction:column;gap:6px;">
        <label for="id_kategori" style="font-weight:500;color:#1a237e;">ID Kategori</label>
        <input type="text" id="id_kategori" value="{{ $kategori->id_kategori }}" readonly style="padding:10px 14px;border-radius:8px;border:1px solid #b6c2e1;background:#eee;font-size:1rem;">
    </div>
    <div style="display:flex;flex-direction:column;gap:6px;">
        <label for="nama_kategori" style="font-weight:500;color:#1a237e;">Nama Kategori</label>
        <input type="text" name="nama_kategori" id="nama_kategori" value="{{ $kategori->nama_kategori }}" required style="padding:10px 14px;border-radius:8px;border:1px solid #b6c2e1;background:#f6faff;font-size:1rem;">
    </div>
    <div style="display:flex;flex-direction:column;gap:6px;">
        <label for="keterangan_kategori" style="font-weight:500;color:#1a237e;">Keterangan</label>
        <textarea name="keterangan_kategori" id="keterangan_kategori" rows="3" style="padding:10px 14px;border-radius:8px;border:1px solid #b6c2e1;background:#f6faff;font-size:1rem;">{{ $kategori->keterangan_kategori }}</textarea>
    </div>
    <div style="display:flex;gap:12px;align-items:center;">
        <a href="{{ route('kategori.index') }}" style="color:#1976d2;text-decoration:none;font-weight:500;">&laquo; Kembali</a>
        <button type="submit" style="background:#1976d2;color:#fff;border:none;border-radius:8px;padding:10px 32px;font-size:1.08rem;font-weight:500;box-shadow:0 2px 8px #1976d233;">Update</button>
    </div>
</form>
</div>
@endsection

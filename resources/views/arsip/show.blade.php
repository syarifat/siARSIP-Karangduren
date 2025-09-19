@extends('layout.sidebar')
@section('content')
<h2>Arsip Surat &gt;&gt; Lihat</h2>
<p>
    <b>Nomor:</b> {{ $surat->nomor_surat }}<br>
    <b>Kategori:</b> {{ $surat->kategori->nama_kategori ?? '-' }}<br>
    <b>Judul:</b> {{ $surat->judul_surat }}<br>
    <b>Waktu Unggah:</b> {{ $surat->created_at }}
</p>
<div style="border:1px solid #aaa; margin:20px 0; padding:0; height:350px; overflow:auto; background:#eee; display:flex; justify-content:center; align-items:center;">
    @if(Str::endsWith($surat->file_path, ['.pdf']))
        <iframe src="{{ asset('storage/' . $surat->file_path) }}" width="80%" height="340px"></iframe>
    @else
        <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank">Lihat File</a>
    @endif
</div>
<div>
    <a href="{{ route('arsip.index') }}"><button>&lt;&lt; Kembali</button></a>
    <a href="{{ route('arsip.download', $surat->id_surat) }}"><button>Unduh</button></a>
    <a href="{{ route('arsip.edit', $surat->id_surat) }}"><button>Edit/Ganti File</button></a>
</div>
@endsection

@extends('layout.sidebar')
@section('content')
<h2>About</h2>
<div style="display:flex;align-items:flex-start;gap:32px;margin-top:16px;">
  <div>
  <img src="{{ asset('img/me.jpg') }}" alt="Profile" style="width:150px;height:200px;background:#fff;border-radius:18px;border:7px solid #000;object-fit:cover;box-shadow:0 2px 12px #0002;" />
  </div>
  <div style="font-size:18px;line-height:1.6;">
    <b>Aplikasi ini dibuat oleh:</b><br>
    Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Syarif Ahsani Taqwim<br>
    Prodi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: D3-MI PSDKU Kediri<br>
    NIM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 2331730019<br>
    Tanggal : 18 September 2025<br><br>
  </div>
</div>
@endsection

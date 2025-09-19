<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>siARSIP</title>
    @vite('resources/css/app.css')
</head>
<body style="display:flex;min-height:100vh;">
    <div class="sidebar shadow-lg">
    <h3 class="sidebar-title" style="line-height:1.15;margin-bottom:2px;font-size:1.08rem;letter-spacing:0.5px;">siARSIP<br>KARANGDUREN</h3>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('arsip.index') }}" class="sidebar-link {{ request()->routeIs('arsip.index') ? 'active' : '' }}">
                    <span class="sidebar-icon">📁</span> Arsip
                </a>
            </li>
            <li>
                <a href="{{ route('kategori.index') }}" class="sidebar-link {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                    <span class="sidebar-icon">🗂️</span> Kategori Surat
                </a>
            </li>
            <li>
                <a href="{{ route('about') }}" class="sidebar-link {{ request()->routeIs('about') ? 'active' : '' }}">
                    <span class="sidebar-icon">ℹ️</span> About
                </a>
            </li>
        </ul>
    </div>
    <div class="content" style="flex:1; padding:40px 48px;">
        @yield('content')
    </div>
</body>
</html>

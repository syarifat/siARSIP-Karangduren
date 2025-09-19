
# siARSIP Karangduren

Sistem Arsip Surat Digital untuk Desa Karangduren, Kecamatan Pakisaji. Aplikasi ini membantu perangkat desa mengarsipkan, mencari, dan mengunduh surat-surat resmi secara mudah dan aman.

---

## Tujuan
Menyediakan solusi digital untuk pengarsipan surat resmi di Desa Karangduren. Surat yang diterbitkan akan dipindai dalam format PDF, diunggah ke sistem, dan dapat dicari serta diunduh kembali kapan saja.

## Fitur Utama
- Upload surat resmi (PDF)
- Pencarian surat berdasarkan judul
- Download surat yang sudah diarsipkan
- Kategori surat
- Manajemen surat & kategori (tambah, edit, hapus)
- Otomatis rename file sesuai judul surat
- Tampilan modern & responsif

---

## Cara Menjalankan
Clone repository:
```bash
git clone https://github.com/syarifat/siARSIP-Karangduren.git
```

Masuk ke folder project:
```bash
cd siARSIP-Karangduren
```

Install dependency PHP:
```bash
composer update
```

Install dependency frontend:
```bash
npm install
```

Buat tabel session:
```bash
php artisan session:table
```

Migrasi database:
```bash
php artisan migrate
```

Buat link storage:
```bash
php artisan storage:link
```

Generate app key:
```bash
php artisan key:generate
```

Jalankan server Laravel:
```bash
php artisan serve
```

Jalankan frontend (Vite):
```bash
npm run dev
```

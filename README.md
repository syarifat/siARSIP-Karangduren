# siARSIP Karangduren

## Tujuan
Pada suatu ketika, sebuah kelurahan yaitu desa Karangduren yang berada di kecamatan Pakisaji membutuhkan sebuah aplikasi yang dapat mengarsipkan surat-surat resmi yang pernah dibuat oleh petugas di kelurahan tersebut. Pak Syaiful selaku pejabat sekdes ingin agar aplikasi ini nantinya bisa menyimpan dan menampilkan kembali surat-surat resmi yang dientrikan dalam bentuk PDF.

Jadi setiap kali perangkat desa menerbitkan sebuah surat, maka nantinya surat tersebut akan terlebih dahulu dipindai (scan) dalam format PDF. Setelah itu, petugas akan meng-upload file hasil scan tersebut ke sistem. Di kemudian hari, Ketika surat tersebut dibutuhkan, maka perangkat desa tinggal membuka aplikasi, lalu melakukan pencarian berdasarkan judul surat tersebut. Jika surat yang dicari memang pernah disimpan di sistem, maka pengguna akan dapat mengunduh file tersebut.

## Fitur
- Upload surat resmi dalam format PDF
- Pencarian surat berdasarkan judul
- Download surat yang sudah diarsipkan
- Kategori surat
- Manajemen surat dan kategori (tambah, edit, hapus)
- Otomatis rename file sesuai judul surat
- Tampilan modern dan responsif

## Cara Menjalankan
```bash
git clone https://github.com/syarifat/siARSIP-Karangduren.git
cd siARSIP-Karangduren
composer update
npm install
php artisan session:table
php artisan migrate
php artisan storage:link
php artisan key:generate

php artisan serve
npm run dev
```

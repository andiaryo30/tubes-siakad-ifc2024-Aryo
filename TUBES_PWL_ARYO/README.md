# SIAKAD Laravel

SIAKAD Laravel adalah aplikasi Sistem Informasi Akademik sederhana untuk tugas besar Web II IF53413. Aplikasi ini mengelola data dosen, mahasiswa, mata kuliah, jadwal perkuliahan, dan Kartu Rencana Studi (KRS) dengan autentikasi berbasis role.

## Fitur

- Login dan logout menggunakan autentikasi Laravel.
- Role `admin` untuk mengelola data master dosen, mahasiswa, mata kuliah, jadwal, dan melihat KRS.
- Role `mahasiswa` untuk melihat jadwal, mengambil mata kuliah, melihat KRS sendiri, dan drop mata kuliah.
- CRUD data dosen.
- CRUD data mahasiswa sekaligus pembuatan akun login mahasiswa.
- CRUD data mata kuliah.
- CRUD data jadwal dengan relasi ke dosen dan mata kuliah.
- KRS dengan relasi mahasiswa ke jadwal perkuliahan.
- Validasi Laravel pada setiap form.
- Pencarian data pada daftar dosen, mahasiswa, mata kuliah, dan jadwal.
- Dashboard statistik jumlah data.

## Halaman

- `/login`: halaman masuk aplikasi.
- `/dashboard`: ringkasan jumlah dosen, mahasiswa, mata kuliah, jadwal, dan KRS.
- `/dosens`: pengelolaan data dosen untuk admin.
- `/mahasiswas`: pengelolaan data mahasiswa dan akun login mahasiswa untuk admin.
- `/mata-kuliahs`: pengelolaan data mata kuliah untuk admin.
- `/jadwals`: daftar jadwal untuk admin dan mahasiswa. Admin dapat tambah, edit, dan hapus jadwal.
- `/krs`: daftar KRS. Admin melihat semua data, mahasiswa hanya melihat KRS miliknya.
- `/krs/create`: form pengambilan mata kuliah.

## Struktur Data

- `users`: akun login dan role pengguna.
- `dosens`: data dosen pengajar.
- `mahasiswas`: data mahasiswa.
- `mata_kuliahs`: data mata kuliah.
- `jadwals`: jadwal perkuliahan yang terhubung ke dosen dan mata kuliah.
- `krs`: data pengambilan jadwal oleh mahasiswa.

## Akun Demo

- Admin: `admin@siakad.test`
- Password: `password`
- Mahasiswa: `budi@siakad.test`
- Password: `password`

## Cara Menjalankan

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Aplikasi berjalan di `http://127.0.0.1:8000`.

## Screenshot

Folder `screenshots` disediakan untuk menyimpan gambar setiap halaman sesuai ketentuan pengumpulan tugas.

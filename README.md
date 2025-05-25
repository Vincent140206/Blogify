
# 📘 Blogify - Laravel Blogging App

Sebuah platform blogging sederhana berbasis Laravel. Cocok untuk belajar CRUD, upload gambar, dan autentikasi pengguna.

---
## Instal Laravel (Disarankan versi 12)
Laravel Documentation : https://laravel.com/docs/12.x/installation, https://laravel.com/docs/12.x  
Link Youtube :  https://youtu.be/pZqk57Xvujs?si=ArP0a-kI2w9mJYXA (Versi 8)  
Link Youtube :  https://youtu.be/nW60yGRoUrs?si=J8QRgD8vLZrcDEqy (Versi 11)
Link Youtube :  https://www.youtube.com/watch?v=upOxC-rVJsU&list=PLPqeNG7ba3a_Sz3tJ1YukfqHE5jZGBmHn (Versi 12)
Atau Referensi lain yang menurut kalian lebih mudah dipahami

## Instal Composer
Link Composer : https://getcomposer.org/  

## 🚀 Cara Clone & Jalankan Project

### 1. Clone Repositori
```bash
git clone https://github.com/Vincent140206/Blogify.git
cd Blogify
```

---

### 2. Install Dependency Composer
Pastikan sudah install **Composer**. Jalankan:
```bash
composer install
```

---

### 3. Copy File `.env`
```bash
cp .env.example .env
```

---

### 4. Generate App Key
```bash
php artisan key:generate
```

---

### 5. Buat Database
Buka **DBeaver**, **phpMyAdmin**, atau tools lainnya dan buat database baru, contoh:

```
Nama database: blogify
```

---

### 6. Atur `.env`
Edit file `.env` untuk disesuaikan dengan konfigurasi lokal kamu:
(Hanya Contoh)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blogify
DB_USERNAME=root
DB_PASSWORD=
```

---

### 7. Migrasi dan Seed Database
```bash
php artisan migrate --seed
```

---

### 8. Jalankan Server Laravel
```bash
php artisan serve
```

Buka browser dan akses:
```
http://127.0.0.1:8000
```

---

## 🧰 Teknologi yang Digunakan

- **Laravel** (PHP Framework)
- **MySQL** via DBeaver
- **HTML, CSS, JavaScript**
- **GitHub** (Version Control)
- **VSCode** (Code Editor)

---

## 📌 Catatan

- Gunakan `git pull` secara berkala untuk menarik update terbaru dari repo.
- Pastikan semua fitur bekerja sebelum melakukan `push`.
- File `.env`, `vendor/`, dan `node_modules/` sudah diabaikan lewat `.gitignore`.

---

Semangat gesss! 🚀

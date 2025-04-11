
# 📘 Blogify - Laravel Blogging App

Sebuah platform blogging sederhana berbasis Laravel. Cocok untuk belajar CRUD, upload gambar, dan autentikasi pengguna.

---

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
Nama database: blogify_db
```

---

### 6. Atur `.env`
Edit file `.env` untuk disesuaikan dengan konfigurasi lokal kamu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blogify_db
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
- Pastikan semua fitur kamu bekerja sebelum melakukan `push`.
- File `.env`, `vendor/`, dan `node_modules/` sudah diabaikan lewat `.gitignore`.

---

Selamat ngoding! 🚀

# Catgram - Social Network untuk Owner Kucing

**Catgram** adalah platform social network yang dirancang khusus untuk para pecinta kucing di seluruh dunia. Aplikasi ini memungkinkan pengguna untuk membagikan momen-momen berharga kucing kesayangan mereka, berinteraksi dengan komunitas, dan membangun jaringan dengan sesama pecinta kucing.

## 📋 Daftar Fitur

- ✅ **Autentikasi Pengguna** - Register dan Login
- ✅ **Profil Pengguna** - Lihat profil dan bio pengguna
- ✅ **Postingan** - Buat, lihat, dan hapus postingan dengan foto
- ✅ **Timeline Feed** - Feed berisi postingan dari user yang Anda ikuti
- ✅ **Followers/Following** - Ikuti dan berhenti mengikuti pengguna
- ✅ **Likes** - Sukai postingan favorit Anda
- ✅ **Comments** - Komentar pada postingan dan lihat semua komentar
- ✅ **Responsive UI** - Interface yang user-friendly dengan Tailwind CSS

## 🛠 Teknologi yang Digunakan

- **Backend:** Laravel 12
- **Database:** SQLite (default, dapat diubah ke MySQL)
- **Frontend:** Blade Templates + Tailwind CSS
- **Icons:** Font Awesome 6
- **Authentication:** Built-in Laravel Authentication

## 📦 Struktur Project

```
catgram/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php
│   │       ├── PostController.php
│   │       ├── LikeController.php
│   │       ├── CommentController.php
│   │       └── FollowController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Post.php
│   │   ├── Comment.php
│   │   ├── Like.php
│   │   └── Follow.php
│   ├── Policies/
│   │   ├── PostPolicy.php
│   │   └── CommentPolicy.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   └── migrations/
│       ├── *_create_users_table.php
│       ├── *_create_posts_table.php
│       ├── *_create_comments_table.php
│       ├── *_create_likes_table.php
│       └── *_create_follows_table.php
├── resources/
│   └── views/
│       ├── layout.blade.php
│       ├── welcome.blade.php
│       ├── dashboard.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── posts/
│       │   ├── create.blade.php
│       │   └── show.blade.php
│       └── profile/
│           └── show.blade.php
└── routes/
    └── web.php
```

## 🔐 Model dan Relasi Eloquent

### User Model
```php
// Relasi
- hasMany('posts')        // Postingan pengguna
- hasMany('comments')     // Komentar pengguna
- hasMany('likes')        // Suka pengguna
- belongsToMany('following')  // User yang diikuti
- belongsToMany('followers')  // Pengikut pengguna
```

### Post Model
```php
// Relasi
- belongsTo('user')           // Pemilik postingan
- hasMany('comments')         // Komentar pada postingan
- hasMany('likes')            // Suka pada postingan
- belongsToMany('likedByUsers')  // User yang menyukai
```

### Comment Model
```php
// Relasi
- belongsTo('post')           // Postingan terkait
- belongsTo('user')           // Pembuat komentar
```

### Like Model
```php
// Relasi
- belongsTo('post')           // Postingan yang disukai
- belongsTo('user')           // User yang menyukai
```

### Follow Model
```php
// Relasi
- belongsTo('follower', 'follower_id')        // User yang follow
- belongsTo('following', 'following_id')      // User yang diikuti
```

## 🗄 Database Schema

### Users Table
```
id (bigint, primary key)
name (string)
username (string, unique)
email (string, unique)
email_verified_at (timestamp)
password (string, hashed)
bio (text, nullable)
profile_photo_path (string, nullable)
remember_token (string)
created_at, updated_at (timestamps)
```

### Posts Table
```
id (bigint, primary key)
user_id (foreign key → users)
caption (text, nullable)
image_path (string)
likes_count (integer)
comments_count (integer)
created_at, updated_at (timestamps)
```

### Comments Table
```
id (bigint, primary key)
post_id (foreign key → posts)
user_id (foreign key → users)
body (text)
created_at, updated_at (timestamps)
```

### Likes Table
```
id (bigint, primary key)
post_id (foreign key → posts)
user_id (foreign key → users)
created_at, updated_at (timestamps)
unique(post_id, user_id)
```

### Follows Table
```
id (bigint, primary key)
follower_id (foreign key → users)
following_id (foreign key → users)
created_at, updated_at (timestamps)
unique(follower_id, following_id)
```

## 🚀 Instalasi dan Setup

### 1. Clone atau Setup Project

```bash
# Jika sudah ada folder catgram
cd catgram
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment

```bash
# Copy .env
cp .env.example .env

# Generate APP_KEY
php artisan key:generate
```

### 4. Setup Database

```bash
# Jalankan migrations
php artisan migrate

# (Opsional) Seed data untuk testing
php artisan db:seed
```

### 5. Link Storage

```bash
# Untuk menyimpan uploaded images
php artisan storage:link
```

### 6. Jalankan Server

```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

## 📝 Routes

### Public Routes
```
GET /                              # Homepage
GET /login                         # Login page
POST /login                        # Handle login
GET /register                      # Register page
POST /register                     # Handle registration
GET /profile/{user}                # View user profile
```

### Authenticated Routes
```
POST /logout                       # Logout

# Dashboard & Feed
GET /dashboard                     # Timeline feed

# Posts
GET /posts/create                  # Create post form
POST /posts                        # Store new post
GET /posts/{post}                  # View post detail
DELETE /posts/{post}               # Delete post

# Likes
POST /posts/{post}/likes           # Like a post
DELETE /posts/{post}/likes         # Unlike a post

# Comments
POST /posts/{post}/comments        # Create comment
DELETE /comments/{comment}         # Delete comment

# Follow
POST /users/{user}/follow          # Follow user
DELETE /users/{user}/follow        # Unfollow user
```

## 🎨 Controllers

### AuthController
- `showLogin()` - Tampilkan form login
- `showRegister()` - Tampilkan form register
- `login()` - Handle login request
- `register()` - Handle registration request
- `logout()` - Handle logout

### PostController
- `dashboard()` - Tampilkan timeline feed
- `create()` - Tampilkan form create post
- `store()` - Simpan postingan baru
- `show()` - Lihat detail postingan
- `destroy()` - Hapus postingan
- `profile()` - Lihat profil pengguna

### LikeController
- `store()` - Tambah like pada postingan
- `destroy()` - Hapus like dari postingan

### CommentController
- `store()` - Tambah komentar pada postingan
- `destroy()` - Hapus komentar

### FollowController
- `store()` - Follow pengguna
- `destroy()` - Unfollow pengguna

## 🔒 Authorization Policies

### PostPolicy
- **delete** - Hanya pemilik postingan yang dapat menghapus

### CommentPolicy
- **delete** - Pemilik komentar atau pemilik postingan dapat menghapus

## 📱 Views dan Pages

### Authentication Pages
- **login.blade.php** - Halaman login
- **register.blade.php** - Halaman registrasi

### Main Pages
- **welcome.blade.php** - Homepage
- **dashboard.blade.php** - Timeline feed dengan postingan
- **layout.blade.php** - Master layout dengan navbar

### Posts Pages
- **posts/create.blade.php** - Form membuat postingan baru
- **posts/show.blade.php** - Detail postingan dengan komentar

### Profile Pages
- **profile/show.blade.php** - Profil pengguna dan galeri postingan

## 💡 Contoh Implementasi UI

### Navbar
- Logo Catgram
- Links navigasi (Dashboard, Posting, Profil)
- Logout button
- Login/Register buttons (untuk guest)

### Timeline Feed
- Grid postingan dari user yang diikuti
- Setiap postingan menampilkan:
  - Nama dan username pemilik
  - Foto kucing
  - Tombol Like/Unlike
  - Tombol Comment
  - Caption postingan

### Profil Pengguna
- Gradient header
- Avatar dan info pengguna
- Stats (postingan, followers, following)
- Follow/Unfollow button
- Grid postingan pengguna

## 🎯 Panduan Penggunaan

### Untuk Pengguna Baru

1. **Daftar Akun**
   - Klik tombol "Daftar"
   - Isi form dengan nama, username, email, dan password
   - Klik "Daftar"

2. **Login**
   - Klik tombol "Login"
   - Masukkan email dan password
   - Klik "Login"

3. **Membuat Postingan**
   - Klik "Posting" di navbar
   - Unggah foto kucing Anda
   - Tambahkan caption (opsional)
   - Klik "Posting"

4. **Berinteraksi**
   - Jelajahi timeline untuk melihat postingan orang lain
   - Klik hati untuk menyukai postingan
   - Tulis komentar untuk berinteraksi
   - Kunjungi profil pengguna dan klik follow untuk mengikuti

## 🧪 Testing Akun Demo

Setelah menjalankan `php artisan migrate`, Anda dapat:
1. Membuat akun baru melalui halaman register
2. Atau membuat seeder untuk demo data

## 🛠 Troubleshooting

### "Cannot find composer"
```bash
# Pastikan Composer terinstall
composer --version
```

### "ERROR: SQLSTATE[HY000]: General error"
```bash
# Hapus database dan jalankan migrate ulang
php artisan migrate:fresh
```

### "Uploaded file not showing"
```bash
# Pastikan storage link sudah dibuat
php artisan storage:link

# Set FILESYSTEM_DISK=public di .env
```

### "Auth tidak bekerja"
```bash
# Pastikan session driver di .env adalah 'database'
# Jalankan: php artisan migrate
```

## 📚 Dokumentasi Referensi

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com)
- [Font Awesome Icons](https://fontawesome.com)
- [Eloquent ORM](https://laravel.com/docs/eloquent)

## 📄 Lisensi

Project ini adalah bagian dari pembelajaran dan dapat digunakan secara bebas.

---

**Dibuat dengan ❤️ untuk pecinta kucing di seluruh dunia!** 🐱

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

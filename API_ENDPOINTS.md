# 📚 API Endpoints Catgram

Dokumentasi lengkap semua endpoints dan cara penggunaannya.

## 🔐 Authentication Endpoints

### Register
```
POST /register
Content-Type: application/x-www-form-urlencoded

Parameters:
- name (required, string): Nama lengkap pengguna
- username (required, string, unique): Username unik
- email (required, email, unique): Email unik
- password (required, string, min:8): Password minimal 8 karakter
- password_confirmation (required, same as password): Konfirmasi password

Response: Redirect ke /dashboard
```

**Contoh:**
```html
<form method="POST" action="/register">
    @csrf
    <input type="text" name="name" placeholder="Nama Lengkap" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
    <button type="submit">Daftar</button>
</form>
```

### Login
```
POST /login
Content-Type: application/x-www-form-urlencoded

Parameters:
- email (required, email): Email pengguna
- password (required, string): Password pengguna

Response: Redirect ke /dashboard atau /login?failed
```

**Contoh:**
```html
<form method="POST" action="/login">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
```

### Logout
```
POST /logout
Authentication: Required

Response: Redirect ke /
```

---

## 📰 Post Endpoints

### Get Dashboard Feed
```
GET /dashboard
Authentication: Required

Response: HTML page dengan timeline feed

Query Parameters:
- page (optional, integer): Halaman pagination (default: 1)
```

**Contoh di Controller:**
```php
// PostController@dashboard
$posts = Post::whereIn('user_id', $following_ids)->paginate(10);
```

### Create Post Form
```
GET /posts/create
Authentication: Required

Response: HTML form untuk membuat postingan baru
```

### Store New Post
```
POST /posts
Content-Type: multipart/form-data
Authentication: Required

Parameters:
- image (required, file): File gambar (jpeg, png, jpg, gif, max 2MB)
- caption (optional, string, max 2000): Keterangan postingan

Response: Redirect ke /dashboard
```

**Contoh:**
```html
<form method="POST" action="/posts" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" accept="image/*" required>
    <textarea name="caption" maxlength="2000" placeholder="Caption..."></textarea>
    <button type="submit">Posting</button>
</form>
```

### View Post Details
```
GET /posts/{id}
Authentication: Optional

Response: HTML page dengan detail postingan dan komentar

URL Parameters:
- id (required, integer): Post ID

Example:
GET /posts/1
```

### Delete Post
```
DELETE /posts/{id}
Authentication: Required
Authorization: User must be post owner

Response: Redirect dengan success message

URL Parameters:
- id (required, integer): Post ID

Example:
DELETE /posts/1
```

**Contoh:**
```html
<form method="POST" action="/posts/1">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Hapus?')">Hapus</button>
</form>
```

---

## ❤️ Like Endpoints

### Like a Post
```
POST /posts/{id}/likes
Authentication: Required

Response: Redirect ke halaman sebelumnya

URL Parameters:
- id (required, integer): Post ID

Example:
POST /posts/1/likes
```

**Contoh:**
```html
<form method="POST" action="/posts/1/likes" style="display:inline;">
    @csrf
    <button type="submit" class="btn-like">❤️ Sukai</button>
</form>
```

### Unlike a Post
```
DELETE /posts/{id}/likes
Authentication: Required

Response: Redirect ke halaman sebelumnya

URL Parameters:
- id (required, integer): Post ID

Example:
DELETE /posts/1/likes
```

**Contoh:**
```html
<form method="POST" action="/posts/1/likes" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-like active">❤️ Batal Sukai</button>
</form>
```

---

## 💬 Comment Endpoints

### Create Comment
```
POST /posts/{id}/comments
Content-Type: application/x-www-form-urlencoded
Authentication: Required

Parameters:
- body (required, string, max 500): Isi komentar

Response: Redirect ke halaman sebelumnya dengan success message

URL Parameters:
- id (required, integer): Post ID

Example:
POST /posts/1/comments
```

**Contoh:**
```html
<form method="POST" action="/posts/1/comments">
    @csrf
    <textarea name="body" maxlength="500" placeholder="Tambah komentar..." required></textarea>
    <button type="submit">Posting</button>
</form>
```

### Delete Comment
```
DELETE /comments/{id}
Authentication: Required
Authorization: User must be comment owner or post owner

Response: Redirect ke halaman sebelumnya dengan success message

URL Parameters:
- id (required, integer): Comment ID

Example:
DELETE /comments/1
```

**Contoh:**
```html
<form method="POST" action="/comments/1">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-delete">🗑️</button>
</form>
```

---

## 👥 Follow Endpoints

### Follow User
```
POST /users/{id}/follow
Authentication: Required

Response: Redirect ke halaman sebelumnya dengan success message

URL Parameters:
- id (required, integer): User ID yang akan diikuti

Example:
POST /users/2/follow
```

**Contoh:**
```html
<form method="POST" action="/users/2/follow" style="display:inline;">
    @csrf
    <button type="submit" class="btn-follow">👥 Ikuti</button>
</form>
```

### Unfollow User
```
DELETE /users/{id}/follow
Authentication: Required

Response: Redirect ke halaman sebelumnya dengan success message

URL Parameters:
- id (required, integer): User ID yang akan dihenti-ikuti

Example:
DELETE /users/2/follow
```

**Contoh:**
```html
<form method="POST" action="/users/2/follow" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-follow active">👥 Mengikuti</button>
</form>
```

---

## 👤 Profile Endpoints

### View User Profile
```
GET /profile/{username}
Authentication: Optional

Response: HTML page dengan profil pengguna dan postingannya

URL Parameters:
- username (required, string): Username pengguna

Example:
GET /profile/johndoe
```

**Returned Data:**
```php
[
    'user' => User Object,
    'posts' => Paginated Post Collection,
    'followers_count' => integer,
    'following_count' => integer,
    'is_following' => boolean // null jika guest
]
```

---

## 📊 Response Examples

### Success Response

**Login Success:**
```
Status: 302 (Redirect)
Location: /dashboard
Session: 'auth_user' set
```

**Create Post Success:**
```
Status: 302 (Redirect)
Location: /dashboard
Session Flash: 'success' => 'Postingan berhasil dibuat!'
```

### Error Response

**Validation Error:**
```
Status: 302 (Redirect)
Location: /register (with back)
Session Flash Errors:
{
    'name' => ['Nama wajib diisi'],
    'email' => ['Email sudah terdaftar']
}
```

**Authentication Error:**
```
Status: 302 (Redirect)
Location: /login
Session Flash Errors:
{
    'email' => ['Email atau password tidak valid']
}
```

**Authorization Error:**
```
Status: 403 Forbidden
Response: This action is unauthorized
```

---

## 🔑 Error Codes

| Code | Description | Action |
|------|-------------|--------|
| 200 | OK | Request berhasil |
| 302 | Redirect | Redirect ke URL lain |
| 400 | Bad Request | Validasi error |
| 403 | Forbidden | Tidak diizinkan |
| 404 | Not Found | Resource tidak ditemukan |
| 419 | CSRF Error | Token tidak valid |
| 422 | Unprocessable | Validasi gagal |
| 500 | Server Error | Error di server |

---

## 📝 Validation Rules

### Register
```php
[
    'name' => 'required|string|max:255',
    'username' => 'required|string|max:255|unique:users',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|string|min:8|confirmed',
]
```

### Create Post
```php
[
    'caption' => 'nullable|string|max:2000',
    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
]
```

### Create Comment
```php
[
    'body' => 'required|string|max:500',
]
```

---

## 🧪 Testing dengan Postman/cURL

### Register User
```bash
curl -X POST http://localhost:8000/register \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "name=John&username=john&email=john@test.com&password=password123&password_confirmation=password123"
```

### Login User
```bash
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=john@test.com&password=password123"
```

### Create Post (dengan image)
```bash
curl -X POST http://localhost:8000/posts \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "caption=Ini kucing saya!" \
  -F "image=@/path/to/image.jpg"
```

### Like Post
```bash
curl -X POST http://localhost:8000/posts/1/likes \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Follow User
```bash
curl -X POST http://localhost:8000/users/2/follow \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🔒 Authentication Flow

1. User mengakses form register di `/register`
2. User submit form dengan POST ke `/register`
3. Server validate data dan create user
4. User auto-login dan redirect ke `/dashboard`
5. User dapat logout dengan POST ke `/logout`

---

## 📱 Response Formats

Semua response adalah HTML (Blade Template), bukan JSON.

Untuk AJAX atau API JSON, tambahkan middleware custom atau gunakan format:

```javascript
// JavaScript example
fetch('/posts/1/likes', {
    method: 'POST',
    headers: {
        'X-CSRF-Token': document.querySelector('[name="_token"]').value,
        'Content-Type': 'application/json'
    }
}).then(r => location.reload())
```

---

**📌 Catatan Penting:**

- Semua endpoint authenticated memerlukan user login
- Semua POST/PUT/DELETE memerlukan CSRF token
- Response default adalah redirect (302)
- Flash messages ditampilkan di next page
- Pagination default 10 items per page

---

**🎯 Quick Reference:**

```
Auth:        GET /login, POST /login, GET /register, POST /register, POST /logout
Posts:       GET /dashboard, GET /posts/create, POST /posts, GET /posts/{id}, DELETE /posts/{id}
Likes:       POST /posts/{id}/likes, DELETE /posts/{id}/likes
Comments:    POST /posts/{id}/comments, DELETE /comments/{id}
Follow:      POST /users/{id}/follow, DELETE /users/{id}/follow
Profile:     GET /profile/{user}
```

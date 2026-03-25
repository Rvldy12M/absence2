# Settings Page Documentation

## Fitur yang Tersedia

### 1. **Informasi Profil**
   - Mengubah nama lengkap
   - Mengubah email
   - Melihat role (admin/siswa)
   - Validasi email unique

### 2. **Ganti Password**
   - Verifikasi password lama
   - Mengubah password dengan minimum 8 karakter
   - Validasi konfirmasi password

### 3. **Informasi Siswa** (Read-only)
   - ID Pengguna
   - Email
   - Kelas terdaftar
   - Tanggal pendaftaran
   - Status verifikasi email

### 4. **Riwayat Kehadiran** (Khusus Siswa)
   - Menampilkan 5 riwayat kehadiran terakhir
   - Status kehadiran (Hadir, Telat, Izin, Sakit)
   - Tanggal dan waktu
   - Link ke riwayat lengkap

### 5. **Zona Bahaya**
   - Opsi untuk menghapus akun secara permanen
   - Memerlukan verifikasi password
   - Tidak dapat dibatalkan

## File yang Dibuat/Diubah

### Files Dibuat:
1. `app/Http/Controllers/SettingsController.php` - Controller untuk settings
2. `resources/views/attendance/settings.blade.php` - View settings

### Files Diubah:
1. `routes/web.php` - Menambah import SettingsController dan 4 routes baru
2. `resources/views/layouts/app.blade.php` - Menambah link "Pengaturan" di navigation

## Routes yang Ditambahkan

```
GET|HEAD  /settings                   → settings.index
PUT       /settings/profile           → settings.update.profile
PUT       /settings/password          → settings.update.password
DELETE    /settings/account           → settings.delete.account
```

## Validasi & Error Handling

### Update Profile:
- Name: required, max 255 karakter
- Email: required, email format, unique (kecuali user sendiri)

### Update Password:
- Current Password: required, harus sama dengan password user
- Password: required, min 8 karakter
- Confirmation: required, harus sama dengan password

### Delete Account:
- Password: required, harus sama dengan password user

## UI/UX Features

- **Responsive Design** - Mobile-friendly dengan sidebar navigation
- **Smooth Scrolling** - Link navigasi scroll smoothly ke section
- **Status Messages** - Alert success/error yang jelas
- **Modal Confirmation** - Untuk delete account action
- **Color-coded Sections** - Setiap section punya warna berbeda (blue, yellow, green, purple)
- **Tailwind CSS** - Modern design menggunakan Tailwind

## Cara Menggunakan

1. Login dengan akun siswa atau admin
2. Klik tombol "Pengaturan" di navbar
3. Pilih section yang ingin diubah:
   - Informasi Profil: Edit nama/email
   - Ganti Password: Ubah password
   - Informasi Siswa: Lihat info profil
   - Riwayat Kehadiran: Lihat riwayat (siswa saja)
   - Zona Bahaya: Hapus akun

## Catatan Penting

- Semua perubahan memerlukan konfirmasi form submission
- Password harus minimal 8 karakter
- Email harus unique di database
- Penghapusan akun tidak dapat dibatalkan
- Semua field menggunakan server-side validation

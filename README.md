# Laravel Filament Training & Shipment Management

## 📌 Pendahuluan
Proyek ini adalah aplikasi manajemen training dan shipment permit berbasis Laravel menggunakan **Filament** sebagai admin panel. Admin dapat mengelola training dan shipment permit, sedangkan driver hanya dapat melihat data yang terkait dengan dirinya.

---
## 🚀 Fitur Utama
### 🔹 **Manajemen Training**
- Admin dapat menambah, mengedit, dan menghapus training.
- Admin dapat meng-assign banyak driver ke satu training.
- Status kehadiran driver pada training dapat diperbarui (Pending, Attendance, Completed, Failed).
- Validasi untuk mencegah duplikasi driver dalam training.

### 🔹 **Manajemen Shipment Permit**
- Admin dapat mengubah status shipment.
- Jika file path tidak kosong, status otomatis diubah menjadi **Approved**.
- Hanya admin yang dapat mengedit shipment permit.
- Shipment permit hanya bisa diedit jika statusnya **Pending** atau **Rejected**.

### 🔹 **Akses Panel**
- **Admin** dapat mengakses semua panel.
- **Driver** hanya bisa melihat shipment permit dan training yang terkait dengan dirinya.

---
## 🛠 Instalasi
### 1️⃣ **Clone Repository**
```sh
git clone https://github.com/abyanardiatama/Coal_Hauling.git
cd repository
```

### 2️⃣ **Instal Dependensi**
```sh
composer install
npm install && npm run build
php artisan filament:install
```

### 3️⃣ **Buat File `.env` & Generate Key**
```sh
cp .env.example .env
php artisan key:generate
```

### 4️⃣ **Konfigurasi Database**
Edit file `.env` dan sesuaikan dengan database Anda:
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=hauling_coal
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5️⃣ **Jalankan Migrasi & Seeder**
```sh
php artisan migrate:fresh --seed
```

### 6️⃣ **Jalankan Server**
```sh
php artisan serve
```

---
## 🔑 **Akses Login**
| Role  | Email             | Password |
|--------|------------------|----------|
| Admin  | admin@admin.com  | password |
| Driver | driver@admin.com | password |

---
## 📄 **Kebijakan Akses**
```php
public function canAccessPanel(\Filament\Panel $panel): bool
{
    return $this->role === 'admin' || $this->role === 'driver';
}
```
- Admin dapat mengakses semua fitur.
- Driver hanya bisa melihat training & shipment permit yang terkait dengan dirinya.

---
## 📌 **Catatan Tambahan**
- Pastikan menggunakan Laravel versi **11+** dan Filament **3+**.

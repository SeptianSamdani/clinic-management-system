# 🏥 Sistem Manajemen Klinik - Vulnerable Version

> **⚠️ WARNING**: Aplikasi ini sengaja dibuat vulnerable untuk keperluan praktikum forensika digital. **JANGAN GUNAKAN DI PRODUCTION!**

## 📖 Tentang Project

Ini adalah sistem manajemen klinik kesehatan yang dibuat menggunakan Laravel 11 dengan **sengaja dimasukkan vulnerability** untuk pembelajaran forensika digital dan keamanan aplikasi web.

### Fitur Utama
- ✅ Multi-role system (Admin, Dokter, Pasien)
- ✅ Manajemen rekam medis
- ✅ Sistem appointment/janji temu
- ✅ Forensic logging (untuk investigasi)
- ⚠️ Vulnerability: SQL Injection
- ⚠️ Vulnerability: XSS (Cross-Site Scripting)
- ⚠️ Vulnerability: Broken Access Control
- ⚠️ Vulnerability: No CSRF Protection

---

## 🛠️ Tech Stack

- **Framework**: Laravel 11+
- **Database**: MySQL 8.0+
- **Frontend**: Tailwind CSS + Alpine.js
- **Template Engine**: Blade

---

## 📦 Instalasi

### Requirement
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & NPM

### Langkah Install

```bash
# 1. Clone repository
git clone https://github.com/your-username/clinic-management.git
cd clinic-management

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
DB_DATABASE=clinic_forensic
DB_USERNAME=root
DB_PASSWORD=

# 5. Buat database
# Buka MySQL dan jalankan:
# CREATE DATABASE clinic_forensic;

# 6. Migrasi & Seeding
php artisan migrate:fresh --seed

# 7. Build assets
npm run build

# 8. Jalankan server
php artisan serve
```

Akses: http://localhost:8000

---

## 👥 Default Users

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@klinik.com | password |
| Dokter | budi.santoso@klinik.com | password |
| Pasien | (lihat di seeder) | password |

---

## 🎭 Skenario Vulnerability

### 1. SQL Injection
**Location**: Patient search, Medical records search  
**How to exploit**:
```
/admin/patients?search=' OR 1=1 --
/doctor/medical-records?search=' UNION SELECT * FROM users --
```

### 2. XSS (Cross-Site Scripting)
**Location**: Medical record notes field  
**How to exploit**:
```html
<script>alert('XSS')</script>
<img src=x onerror="alert('XSS')">
```

### 3. Broken Access Control
**Location**: Medical records detail  
**How to exploit**:
```
Login sebagai Doctor A
Akses: /doctor/medical-records/1 (miliknya) ✅
Ubah: /doctor/medical-records/20 (milik Doctor B) ❌
System tetap menampilkan! (VULNERABILITY)
```

### 4. No CSRF Protection
**Impact**: Semua form vulnerable terhadap CSRF attack

---

## 🔍 Forensic Investigation

### Simulasi Attack
```bash
# Jalankan simulasi serangan otomatis
php artisan forensic:simulate-balanced-attack
```

### Investigasi
```bash
# Investigate unauthorized access
php artisan forensic:investigate --doctor=budi.santoso@klinik.com
```

### Manual Investigation
```bash
php artisan tinker

# Cek security events
DB::table('security_events')->where('event_type', 'unauthorized_medical_record_access')->get();

# Cek audit trails
DB::table('audit_trails')->where('action', 'unauthorized_view')->get();

# Lihat request logs
DB::table('request_logs')->where('user_id', $userId)->orderBy('created_at')->get();
```

---

## 📊 Database Tables untuk Forensik

| Table | Purpose |
|-------|---------|
| `request_logs` | Semua HTTP request |
| `sql_logs` | Semua SQL query yang dieksekusi |
| `audit_trails` | Perubahan data (create, update, delete) |
| `security_events` | Suspicious activities terdeteksi |

---

## 🎓 Untuk Praktikum

### Langkah Mahasiswa:

1. **Setup Environment**
   ```bash
   git clone [repository]
   composer install && npm install
   php artisan migrate:fresh --seed
   ```

2. **Manual Attack**
   - Login sebagai doctor
   - Akses medical record yang bukan miliknya
   - Dokumentasikan prosesnya

3. **Investigation**
   - Gunakan command `forensic:investigate`
   - Query database untuk evidence
   - Buat timeline serangan

4. **Laporan**
   - Gunakan template yang disediakan
   - Include screenshots
   - Berikan rekomendasi fix

### Template Laporan
Lihat: `docs/LAPORAN_TEMPLATE.md`

---

## 🔐 How to Fix (Secure Version)

### Fix Broken Access Control
```php
// BEFORE (Vulnerable)
public function show($id) {
    $record = MedicalRecord::findOrFail($id);
    return view('show', compact('record'));
}

// AFTER (Secure)
public function show($id) {
    $record = MedicalRecord::findOrFail($id);
    
    // CHECK OWNERSHIP
    if ($record->doctor_id !== auth()->user()->doctor->id) {
        abort(403, 'Unauthorized');
    }
    
    return view('show', compact('record'));
}
```

### Fix SQL Injection
```php
// BEFORE (Vulnerable)
$query = "SELECT * FROM patients WHERE name LIKE '%{$search}%'";
$results = DB::select($query);

// AFTER (Secure)
$results = Patient::where('name', 'like', "%{$search}%")->get();
// Or use parameter binding
```

### Fix XSS
```blade
{{-- BEFORE (Vulnerable) --}}
{!! $record->notes !!}

{{-- AFTER (Secure) --}}
{{ $record->notes }}
```

---

## 📁 Struktur Project

```
clinic-management/
├── app/
│   ├── Console/Commands/         # Forensic commands
│   ├── Http/
│   │   ├── Controllers/          # Controllers (Vulnerable)
│   │   └── Middleware/           # Forensic logging
│   ├── Models/                   # Eloquent models
│   └── Observers/                # Audit trail observer
├── database/
│   ├── migrations/               # Database schema
│   └── seeders/                  # Data dummy
├── resources/
│   └── views/                    # Blade templates
├── routes/
│   └── web.php                   # Routes definition
└── README.md
```

---

## 🐛 Known Issues (Intentional)

- ❌ No CSRF protection
- ❌ SQL Injection vulnerable
- ❌ XSS vulnerable
- ❌ Broken Access Control
- ❌ No rate limiting
- ❌ Debug mode ON
- ❌ Verbose error messages

**Ini semua SENGAJA untuk pembelajaran!**

---

## 📚 References

- [OWASP Top 10](https://owasp.org/Top10/)
- [Laravel Security Best Practices](https://laravel.com/docs/11.x/security)
- [Digital Forensics Process](https://www.nist.gov/publications)

---

## 📝 License

Untuk keperluan edukasi saja. Tidak untuk penggunaan komersial atau production.

---

## 👨‍💻 Author

**Nama**: [Nama Anda]  
**NIM**: [NIM Anda]  
**Mata Kuliah**: Forensika Digital  
**Dosen**: [Nama Dosen]  
**Tahun**: 2024

---

## 🤝 Contributing

Pull requests welcome untuk perbaikan dokumentasi atau penambahan skenario vulnerability baru.

---

## ⚠️ Disclaimer

Aplikasi ini dibuat untuk keperluan edukasi dan praktikum. Jangan gunakan kode ini di aplikasi production atau environment nyata. Author tidak bertanggung jawab atas penyalahgunaan kode ini.

---

**Happy Learning! 🎓🔍**
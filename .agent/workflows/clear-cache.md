---
description: Membersihkan semua cache aplikasi untuk memperbaiki error OPcache atau sinkronisasi data
---

Langkah-langkah untuk membersihkan cache di server (via SSH):

1. Masuk ke folder root aplikasi Anda di server:
```bash
cd /path/to/your/project
```

2. Jalankan perintah pembersihan cache Laravel:
// turbo
```bash
php artisan optimize:clear
```

3. Jika error OPcache masih berlanjut, hapus file cache bootstrap secara manual:
// turbo
```bash
rm -f bootstrap/cache/*.php
```

4. Pastikan folder storage memiliki izin yang benar:
// turbo
```bash
chmod -R 775 storage bootstrap/cache
```

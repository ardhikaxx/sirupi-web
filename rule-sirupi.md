# RULE-SIRUPI.md
## Blueprint Arsitektur & PRD Sistem Informasi Rencana Umum Pengadaan Internal (SIRUPI)

---

## 1. IDENTITAS PROYEK

| Atribut | Detail |
|---|---|
| Nama Sistem | Sistem Informasi Rencana Umum Pengadaan Internal (SIRUPI) |
| Jenis Aplikasi | Web Application (Internal Instansi + Portal Publik) |
| Backend Framework | Laravel 12 |
| Database | MySQL 8.x |
| Frontend Framework | Bootstrap 5 (CDN) |
| Ikon | Font Awesome 6 (CDN) |
| Notifikasi/Konfirmasi | SweetAlert2 (CDN) |
| Visualisasi Data | Chart.js (CDN) |
| Tabel Data | DataTables (CDN) — dengan ekstensi Buttons (Excel, PDF, CSV, Print), Responsive |
| Font UI | Plus Jakarta Sans |
| Font Numerik/Anggaran | JetBrains Mono |
| Bahasa UI | Bahasa Indonesia (istilah teknis boleh Inggris) |
| Filosofi Aset | 100% CDN — tidak menggunakan NPM/Vite/build tools |
| Multi-tenancy | Single instansi, multi unit kerja (bukan multi-tenant SaaS) |

---

## 2. GAMBARAN UMUM SISTEM

SIRUPI adalah aplikasi berbasis web untuk mengelola seluruh siklus hidup Rencana Umum Pengadaan (RUP) pada suatu instansi — mulai dari **penyusunan usulan paket pengadaan** oleh unit kerja, **verifikasi** oleh verifikator, **persetujuan** oleh pimpinan (PA/KPA), hingga **publikasi** kepada publik.

Sistem ini menggantikan pencatatan manual berbasis Excel/dokumen cetak dengan basis data terpusat, tervalidasi, dan dapat diaudit penuh (full audit trail). Sistem mendukung multi-tahun-anggaran, sehingga data historis dari tahun-tahun sebelumnya tetap tersimpan dan dapat dijadikan pembanding/analisis tren.

### 2.1 Tujuan Sistem

1. Transparansi proses perencanaan pengadaan antar unit kerja, verifikator, dan pimpinan.
2. Akurasi data — validasi otomatis terhadap pagu anggaran, duplikasi kode paket, dan kelengkapan dokumen.
3. Efisiensi proses persetujuan berjenjang dengan notifikasi dan tracking status real-time.
4. Pelaporan otomatis (PDF/Excel) yang sebelumnya disusun manual.
5. Audit trail menyeluruh — setiap perubahan data tercatat: siapa, kapan, apa yang diubah.
6. Portal publik yang menyajikan data RUP yang telah dipublikasikan, selaras dengan prinsip keterbukaan informasi pengadaan (semangat SIRUP LKPP), namun sebagai sistem **internal pendamping**, bukan pengganti SIRUP resmi LKPP.

### 2.2 Ruang Lingkup

**Termasuk dalam ruang lingkup:**
- Manajemen data master pengadaan
- Penyusunan, revisi, dan pengajuan paket RUP oleh unit kerja
- Alur verifikasi dan persetujuan berjenjang (multi-level approval)
- Manajemen dokumen pendukung paket (KAK, RAB, spesifikasi teknis, dll)
- Publikasi RUP ke portal publik
- Dashboard analitik dan pelaporan
- Activity log & audit trail
- Manajemen pengguna dan RBAC

**Di luar ruang lingkup (fase awal):**
- Integrasi langsung API ke SIRUP LKPP / SPSE (disediakan sebagai modul ekspor data terstruktur untuk input manual/semi-otomatis, bukan integrasi API real-time)
- Proses pengadaan pasca-RUP (tender, kontrak, SPK) — sistem ini hanya mencakup tahap **perencanaan**
- Manajemen e-katalog

---

## 3. ARSITEKTUR TEKNIS

### 3.1 Pola Arsitektur

Sistem menggunakan pola **MVC (Model-View-Controller)** bawaan Laravel 12, dengan pendekatan sebagai berikut:

```
sirupi/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Controller area super admin & admin
│   │   │   ├── Operator/           # Controller area operator unit kerja
│   │   │   ├── Verifikator/        # Controller area verifikator
│   │   │   ├── Pimpinan/           # Controller area pimpinan/PA/KPA
│   │   │   ├── Auditor/            # Controller area auditor (read-only)
│   │   │   ├── Public/             # Controller portal publik
│   │   │   ├── Auth/               # Login, logout, forgot password
│   │   │   └── Api/                # Endpoint AJAX internal (DataTables server-side, dsb)
│   │   ├── Middleware/
│   │   │   ├── CheckRole.php
│   │   │   ├── CheckUnitKerja.php
│   │   │   ├── CheckTahunAnggaranAktif.php
│   │   │   └── LogActivity.php
│   │   ├── Requests/               # Form Request validation per modul
│   │   └── Resources/              # API Resource (untuk endpoint AJAX/publik)
│   ├── Models/
│   ├── Services/                   # Business logic layer (mis. PaketPengadaanService, ApprovalService)
│   ├── Observers/                  # Model observer untuk auto-logging activity
│   ├── Policies/                   # Otorisasi per-model (Laravel Policy)
│   ├── Exports/                    # Kelas Laravel Excel (jika dipakai) untuk export
│   ├── Notifications/              # Notifikasi in-app & email (status usulan berubah)
│   └── Helpers/                    # Helper format rupiah, kode paket, dsb
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   └── views/
│       ├── layouts/                # Layout master (sidebar, navbar, footer) per role
│       ├── components/             # Blade component (card statistik, badge status, dsb)
│       ├── admin/
│       ├── operator/
│       ├── verifikator/
│       ├── pimpinan/
│       ├── auditor/
│       ├── public/
│       └── auth/
├── routes/
│   ├── web.php
│   ├── admin.php
│   ├── operator.php
│   ├── verifikator.php
│   ├── pimpinan.php
│   ├── auditor.php
│   └── public.php
└── storage/
    └── app/
        └── dokumen_paket/           # Penyimpanan dokumen pendukung per paket
```

### 3.2 Prinsip Arsitektur

1. **Fat Model / Thin Controller dengan Service Layer** — logika bisnis kompleks (validasi pagu, alur approval, generate kode paket) ditempatkan di `Services/`, bukan langsung di controller.
2. **Form Request Validation** — setiap input pengguna divalidasi melalui kelas `FormRequest` khusus, pesan error dalam Bahasa Indonesia.
3. **Policy-based Authorization** — setiap aksi (lihat, ubah, hapus, verifikasi, setujui) diverifikasi melalui Laravel Policy berdasarkan role dan kepemilikan data (unit kerja).
4. **Observer Pattern untuk Activity Log** — model `PaketPengadaan`, `User`, `Persetujuan`, `Dokumen` memiliki Observer yang otomatis mencatat setiap create/update/delete ke tabel `activity_logs`.
5. **Soft Delete** — seluruh tabel transaksional menggunakan `SoftDeletes` agar data tidak hilang permanen dan dapat dipulihkan oleh Super Admin.
6. **Database Transaction** — seluruh proses multi-tabel (submit usulan, approval, publikasi) dibungkus `DB::transaction()` untuk menjaga konsistensi data.
7. **UUID untuk Kode Paket** — kode paket pengadaan menggunakan format terstruktur yang dapat dilacak (lihat 6.2), bukan auto-increment murni, agar aman dipublikasikan ke publik.

### 3.3 Implementasi Teknologi Frontend (CDN-based)

| Library | Fungsi | Catatan Implementasi |
|---|---|---|
| Bootstrap 5 | Layout, grid, komponen UI dasar | Sidebar collapsible, navbar sticky, card, modal, badge |
| Font Awesome 6 | Ikon seluruh sistem | Solid untuk aksi, Regular untuk status netral |
| SweetAlert2 | Notifikasi toast & dialog konfirmasi | Wrapper JS global `sirupiAlert.js` (lihat 12) |
| Chart.js | Grafik dashboard & laporan | Bar, Pie, Doughnut, Line chart |
| DataTables | Semua tabel listing | Server-side processing untuk tabel paket pengadaan (potensi ribuan baris) |
| Select2 (CDN) | Dropdown pencarian (unit kerja, program, penyedia) | Dibutuhkan karena jumlah opsi referensi bisa besar |
| Flatpickr / Bootstrap Datepicker (CDN) | Input tanggal jadwal pelaksanaan | Format tanggal Indonesia (dd-mm-yyyy) |

Seluruh library dimuat via CDN pada `layouts/app.blade.php`, tidak ada proses build (`npm run build`/`vite`). File custom CSS/JS ditempatkan di `public/assets/css/` dan `public/assets/js/` dan dimuat langsung sebagai static file.

---

## 4. ROLE-BASED ACCESS CONTROL (RBAC)

Sistem menggunakan **7 role**. Implementasi RBAC menggunakan kolom `role` pada tabel `users` (enum) dikombinasikan dengan Laravel Policy + Middleware `CheckRole`. Untuk kebutuhan granular (mis. Administrator yang bisa mengelola sebagian data master saja), digunakan tabel `permissions` opsional di fase 2 — **fase 1 menggunakan role-based sederhana** sesuai kebutuhan awal.

### 4.1 Matriks Hak Akses Ringkas

| Modul / Aksi | Super Admin | Admin | Operator | Verifikator | Pimpinan | Auditor | Publik |
|---|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| Kelola konfigurasi aplikasi | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Kelola pengguna & reset password | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Kelola data master (penuh) | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ | ❌ |
| Backup database | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Buat usulan paket pengadaan | ✅ | ✅ | ✅ (unit sendiri) | ❌ | ❌ | ❌ | ❌ |
| Edit paket sebelum diverifikasi | ✅ | ✅ | ✅ (unit sendiri) | ❌ | ❌ | ❌ | ❌ |
| Verifikasi usulan | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ |
| Persetujuan akhir | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| Publikasi RUP | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Lihat seluruh data (semua unit) | ✅ | ✅ | ❌ | ✅ | ✅ | ✅ | Hanya terpublikasi |
| Hapus data (soft delete) | ✅ | ✅** | ✅ (draft milik sendiri) | ❌ | ❌ | ❌ | ❌ |
| Hapus permanen / restore | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Lihat Activity Log | ✅ | ✅ (terbatas) | ❌ | ❌ | ❌ | ✅ | ❌ |
| Unduh laporan | ✅ | ✅ | ✅ (unit sendiri) | ✅ | ✅ | ✅ | ❌ (hanya data publik) |
| Cari data publik RUP | ❌ (login internal) | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ |

\* Admin dapat mengelola data master operasional (program, kegiatan, penyedia, dsb) tetapi tidak data master sistem inti (role, tahun anggaran aktif).
\*\* Admin tidak dapat menghapus data audit/log.

### 4.2 Detail Peran

#### 4.2.1 Super Administrator
Kontrol penuh sistem. Akses: konfigurasi aplikasi (nama instansi, logo, identitas visual), manajemen seluruh pengguna (CRUD, reset password, aktif/nonaktif), manajemen tahun anggaran (buka/tutup periode), manajemen unit kerja, seluruh data master, backup & restore database, monitoring seluruh proses RUP lintas unit kerja, publikasi data, restore data yang dihapus (soft-deleted), serta akses penuh ke seluruh laporan dan Activity Log tanpa batasan.

#### 4.2.2 Administrator
Operasional harian: mengelola sebagian data master (program, kegiatan, sub kegiatan, penyedia, kategori — bukan role/tahun anggaran), memverifikasi data (peran ganda dengan verifikator bila diperlukan pada instansi kecil), memperbaiki data bermasalah atas permintaan unit kerja, monitoring seluruh paket pengadaan, mengelola dokumen pendukung, mencetak laporan, mengelola status publikasi. **Tidak dapat**: mengubah konfigurasi utama sistem, menghapus data Activity Log, mengelola akun Super Admin.

#### 4.2.3 Operator Unit Kerja
Terikat pada satu `unit_kerja_id` (disimpan di tabel `users`). Semua query data operator di-scope otomatis via **Global Scope** Eloquent berdasarkan `unit_kerja_id` miliknya. Operator dapat: membuat paket pengadaan baru (status awal `draft`), mengedit paket selama status masih `draft` atau `dikembalikan`, mengunggah dokumen pendukung, mengirim usulan untuk verifikasi (`draft` → `diajukan`), melihat status & riwayat pengajuan miliknya, membaca catatan revisi dari verifikator/pimpinan, mencetak draft usulan (belum resmi), menghapus paket **hanya** yang berstatus `draft` (belum diajukan).

#### 4.2.4 Verifikator
Melihat seluruh paket berstatus `diajukan` dari **semua unit kerja** (atau unit kerja yang menjadi tanggung jawabnya bila sistem dikonfigurasi per-bidang di fase 2). Dapat: memeriksa detail paket & dokumen, memberi catatan revisi dan mengembalikan ke operator (`diajukan` → `dikembalikan`), atau menyetujui dan meneruskan ke pimpinan (`diajukan` → `diverifikasi`). Tidak dapat mengubah data paket secara langsung (hanya beri catatan), dan tidak dapat mengubah data yang sudah berstatus `disetujui` atau lebih lanjut.

#### 4.2.5 Pimpinan / PA / KPA
Berwenang memberikan **persetujuan akhir**. Melihat dashboard ringkasan (total pagu, jumlah paket per status, statistik per unit kerja, grafik progres). Aksi utama: menyetujui (`diverifikasi` → `disetujui`) atau menolak dengan catatan (`diverifikasi` → `ditolak`) paket pengadaan. Tidak melakukan input/edit data operasional.

#### 4.2.6 Auditor
Akses **read-only** penuh lintas unit kerja: seluruh data paket pengadaan di semua status, histori perubahan (versioning), Activity Log lengkap, laporan anggaran, laporan revisi, seluruh dokumen pendukung. Tidak memiliki tombol aksi ubah/hapus di UI manapun (Policy menolak seluruh method `update`, `delete`, `create` untuk role ini).

#### 4.2.7 Pengunjung (Publik)
Tanpa login. Mengakses halaman publik yang menampilkan **hanya** paket berstatus `dipublikasikan`. Dapat mencari/filter berdasarkan tahun anggaran, unit kerja, jenis pengadaan, metode pemilihan, kata kunci nama paket. Tidak dapat melihat data internal seperti catatan revisi, riwayat approval detail, atau dokumen internal (kecuali dokumen yang ditandai `is_public = true`, mis. ringkasan KAK bila instansi mengizinkan).

---

## 5. ALUR BISNIS UTAMA (STATE MACHINE)

### 5.1 Status Paket Pengadaan (Lifecycle)

```
   [draft] ──submit──▶ [diajukan] ──verifikasi ok──▶ [diverifikasi] ──setuju──▶ [disetujui] ──publikasi──▶ [dipublikasikan]
      ▲                     │                              │
      │                     │ dikembalikan                 │ ditolak
      │                     ▼                              ▼
      └──────────────── [dikembalikan]              [ditolak] ──revisi ulang──▶ [draft]
```

| Status | Kode | Deskripsi | Dapat diedit oleh |
|---|---|---|---|
| Draft | `draft` | Baru dibuat operator, belum diajukan | Operator (pemilik) |
| Diajukan | `diajukan` | Menunggu verifikasi | Tidak ada (read-only, terkunci) |
| Dikembalikan | `dikembalikan` | Verifikator menemukan masalah, wajib catatan revisi | Operator (pemilik) — untuk perbaikan |
| Diverifikasi | `diverifikasi` | Lolos verifikasi, menunggu persetujuan pimpinan | Tidak ada (read-only, terkunci) |
| Ditolak | `ditolak` | Pimpinan menolak, wajib catatan alasan | Operator (pemilik) — dapat direvisi menjadi draft baru |
| Disetujui | `disetujui` | Disetujui pimpinan, siap dipublikasikan | Tidak ada (terkunci penuh, hanya Super Admin dapat "buka kunci" via prosedur khusus dengan log) |
| Dipublikasikan | `dipublikasikan` | Tampil di portal publik | Tidak ada (perubahan harus melalui revisi RUP resmi / addendum) |

**Aturan penting:**
- Perubahan status hanya dapat terjadi melalui action resmi (submit, verifikasi, approve, reject, publish) — **tidak pernah** melalui edit langsung field `status`.
- Setiap transisi status wajib tercatat di tabel `riwayat_persetujuan` dengan `user_id`, `status_dari`, `status_ke`, `catatan`, `created_at`.
- Paket yang sudah `disetujui` atau `dipublikasikan` bersifat **immutable** kecuali melalui mekanisme **Revisi RUP** (lihat 5.3) yang menghasilkan versi baru dan mencatat histori.

### 5.2 Alur Detail Langkah-demi-Langkah

1. **Setup Data Master** (Super Admin/Admin) — tahun anggaran, unit kerja, program, kegiatan, sub kegiatan, sumber dana, metode pengadaan, jenis pengadaan, pejabat pengadaan, penyedia, kategori, satuan.
2. **Pembukaan Periode RUP** (Super Admin) — mengaktifkan tahun anggaran tertentu sehingga operator dapat mulai input usulan. Sistem hanya mengizinkan input pada tahun anggaran berstatus `aktif`.
3. **Input Usulan Paket** (Operator) — mengisi form multi-section: Informasi Umum, Anggaran & Sumber Dana, Jadwal, Lokasi, Uraian Pekerjaan, Dokumen Pendukung. Disimpan sebagai `draft` (dapat auto-save/simpan sebagian).
4. **Validasi Otomatis** — sistem mengecek: kelengkapan field wajib, total pagu paket tidak melebihi pagu program/kegiatan induk (jika dikonfigurasi), format tanggal jadwal logis (mulai < selesai), duplikasi nama paket dalam unit & tahun yang sama (warning, bukan blocking).
5. **Submit Usulan** (Operator) — tombol "Ajukan Verifikasi" dengan konfirmasi SweetAlert2; status → `diajukan`; sistem mengunci field edit dan mengirim notifikasi in-app ke seluruh Verifikator.
6. **Verifikasi** (Verifikator) — memeriksa detail & dokumen. Dua opsi:
   - **Kembalikan**: wajib isi catatan revisi (textarea, min 10 karakter) → status `dikembalikan`, notifikasi ke operator pemilik.
   - **Setujui/Teruskan**: status → `diverifikasi`, notifikasi ke seluruh Pimpinan.
7. **Perbaikan oleh Operator** (jika dikembalikan) — operator melihat catatan revisi, memperbaiki data, submit ulang → status kembali `diajukan`. Riwayat revisi sebelumnya tetap tersimpan (tidak ditimpa).
8. **Persetujuan Akhir** (Pimpinan) — dua opsi:
   - **Tolak**: wajib catatan alasan → status `ditolak`, notifikasi ke operator; operator dapat mengajukan revisi RUP baru dari data ini.
   - **Setujui**: status → `disetujui`, dicatat tanggal & nomor persetujuan (opsional generate nomor SK otomatis), notifikasi ke Admin/Super Admin bahwa paket siap dipublikasikan.
9. **Publikasi** (Admin/Super Admin) — memilih satu atau banyak paket berstatus `disetujui` (bulk action tersedia via DataTables checkbox), konfirmasi SweetAlert2, status → `dipublikasikan`, `published_at` dicatat, data langsung tampil di portal publik.
10. **Pencatatan Activity Log** — setiap langkah 3–9 otomatis tercatat via Observer ke tabel `activity_logs`.

### 5.3 Mekanisme Revisi RUP Pasca-Persetujuan

Paket yang sudah `disetujui`/`dipublikasikan` namun perlu diubah (mis. perubahan pagu akibat kebijakan anggaran) tidak diedit langsung. Operator mengajukan **"Revisi Paket"** yang:
- Membuat baris baru di `paket_pengadaan` dengan `parent_paket_id` mengacu ke paket asal dan `versi` bertambah (v1 → v2).
- Paket versi lama ditandai `is_revised = true` namun tetap tampil di publik dengan label "Direvisi menjadi versi terbaru" (transparansi).
- Paket versi baru melalui **alur persetujuan penuh dari awal** (draft → diajukan → diverifikasi → disetujui → dipublikasikan).
- Riwayat lengkap seluruh versi dapat dilihat Auditor dan Super Admin dalam satu timeline.


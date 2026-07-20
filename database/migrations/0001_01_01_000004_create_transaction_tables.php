<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_pengadaans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_paket', 50)->unique();
            $table->string('nama_paket', 500);
            $table->text('uraian_pekerjaan')->nullable();
            $table->decimal('pagu_anggaran', 20, 2)->default(0);
            $table->decimal('hps', 20, 2)->nullable();
            $table->string('status', 30)->default('draft');
            $table->foreignId('unit_kerja_id')->constrained('unit_kerjas');
            $table->foreignId('tahun_anggaran_id')->constrained('tahun_anggarans');
            $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->foreignId('kegiatan_id')->nullable()->constrained('kegiatans')->nullOnDelete();
            $table->foreignId('sub_kegiatan_id')->nullable()->constrained('sub_kegiatans')->nullOnDelete();
            $table->foreignId('sumber_dana_id')->nullable()->constrained('sumber_danas')->nullOnDelete();
            $table->foreignId('jenis_pengadaan_id')->nullable()->constrained('jenis_pengadaans')->nullOnDelete();
            $table->foreignId('metode_pengadaan_id')->nullable()->constrained('metode_pengadaans')->nullOnDelete();
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->nullOnDelete();
            $table->foreignId('satuan_id')->nullable()->constrained('satuans')->nullOnDelete();
            $table->foreignId('penyedia_id')->nullable()->constrained('penyedias')->nullOnDelete();
            $table->foreignId('pptk_id')->nullable()->constrained('pejabats')->nullOnDelete();
            $table->foreignId('pp_id')->nullable()->constrained('pejabats')->nullOnDelete();
            $table->foreignId('pa_kpa_id')->nullable()->constrained('pejabats')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('parent_paket_id')->nullable()->constrained('paket_pengadaans')->nullOnDelete();
            $table->integer('versi')->default(1);
            $table->boolean('is_revised')->default(false);
            $table->text('catatan_revisi')->nullable();
            $table->boolean('is_published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('paket_anggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_pengadaan_id')->constrained('paket_pengadaans')->cascadeOnDelete();
            $table->string('nama_item', 500);
            $table->integer('volume')->default(1);
            $table->foreignId('satuan_id')->nullable()->constrained('satuans')->nullOnDelete();
            $table->decimal('harga_satuan', 20, 2)->default(0);
            $table->decimal('total', 20, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('paket_jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_pengadaan_id')->constrained('paket_pengadaans')->cascadeOnDelete();
            $table->string('tahapan', 255);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('paket_lokasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_pengadaan_id')->constrained('paket_pengadaans')->cascadeOnDelete();
            $table->string('provinsi', 100)->nullable();
            $table->string('kabupaten_kota', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kelurahan_desa', 100)->nullable();
            $table->text('detail_alamat')->nullable();
            $table->timestamps();
        });

        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_pengadaan_id')->constrained('paket_pengadaans')->cascadeOnDelete();
            $table->string('nama_dokumen', 255);
            $table->string('tipe_dokumen', 100)->nullable();
            $table->string('file_path', 500);
            $table->string('file_size', 50)->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->boolean('is_public')->default(false);
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('riwayat_persetujuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_pengadaan_id')->constrained('paket_pengadaans')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->string('aksi', 30)->comment('submit, verifikasi_setuju, verifikasi_kembali, approve_setuju, approve_tolak, publikasi, revisi');
            $table->string('status_dari', 30)->nullable();
            $table->string('status_ke', 30)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tipe', 50)->comment('create, update, delete, restore, login, logout');
            $table->string('model', 100)->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('data_lama')->nullable();
            $table->text('data_baru')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('riwayat_persetujuans');
        Schema::dropIfExists('dokumens');
        Schema::dropIfExists('paket_lokasis');
        Schema::dropIfExists('paket_jadwals');
        Schema::dropIfExists('paket_anggarans');
        Schema::dropIfExists('paket_pengadaans');
    }
};

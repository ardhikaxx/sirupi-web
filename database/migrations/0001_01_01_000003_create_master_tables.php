<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahun_anggarans', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('nama', 100);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->string('nama', 500);
            $table->foreignId('tahun_anggaran_id')->constrained('tahun_anggarans')->cascadeOnDelete();
            $table->decimal('pagu_anggaran', 20, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->string('nama', 500);
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->decimal('pagu_anggaran', 20, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sub_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->string('nama', 500);
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->cascadeOnDelete();
            $table->decimal('pagu_anggaran', 20, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sumber_danas', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->string('nama', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('jenis_pengadaans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->string('nama', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('metode_pengadaans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->string('nama', 255);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->string('nama', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('satuans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 100);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('penyedias', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('npwp', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('jenis', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pejabats', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('nip', 30)->nullable();
            $table->string('jabatan', 255);
            $table->string('tipe', 50)->comment('pptk, pp, pa_kpa, etc');
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerjas')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pejabats');
        Schema::dropIfExists('penyedias');
        Schema::dropIfExists('satuans');
        Schema::dropIfExists('kategoris');
        Schema::dropIfExists('metode_pengadaans');
        Schema::dropIfExists('jenis_pengadaans');
        Schema::dropIfExists('sumber_danas');
        Schema::dropIfExists('sub_kegiatans');
        Schema::dropIfExists('kegiatans');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('tahun_anggarans');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLowonganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (perusahaan pemberi lowongan)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Informasi umum lowongan
            $table->string('judul'); // Contoh: SPB/SPG / Merchandiser
            $table->string('slug')->unique(); // Contoh: spb-spg-merchandiser-bantul
            $table->string('lokasi'); // Contoh: Kab. Bantul, Daerah Istimewa Yogyakarta, Indonesia
            $table->string('bidang_pekerjaan')->nullable(); // Operasi Ritel
            $table->string('jenis_pekerjaan')->nullable(); // Full time
            $table->string('tipe_pekerjaan')->nullable(); // Lowongan dalam negeri
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan','Laki-laki/Perempuan'])->nullable(); // Pilihan jenis kelamin
            $table->string('rentang_gaji')->nullable(); // Dirahasiakan
            $table->date('batas_lamaran')->nullable(); // 24 November 2025
            $table->boolean('status')->default(true); // true: aktif, false: nonaktif
            $table->integer('jumlah_lowongan')->default(0);
            // Deskripsi pekerjaan & persyaratan
            $table->text('deskripsi_pekerjaan')->nullable(); // Deskripsi pekerjaan
            $table->text('persyaratan_khusus')->nullable(); // Satu kolom untuk semua syarat khusus

            // Persyaratan umum
            $table->enum('pendidikan_minimal', [
                'SD',
                'SMP',
                'SMA',
                'D1',
                'D2',
                'D3',
                'S1/D4',
                'S2',
                'S3'
            ])->nullable(); // Pilihan pendidikan
            $table->enum('status_pernikahan', ['Nikah', 'Belum','Tidak Ada Preferensi'])->nullable(); // Status pernikahan
            $table->integer('pengalaman_minimal')->nullable(); // 1 tahun
            $table->enum('kondisi_fisik', ['Non Disabilitas', 'Disabilitas'])->nullable(); // Kondisi fisik
            $table->text('keterampilan')->nullable(); // Keterampilan yang dibutuhkan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lowongan');
    }
}

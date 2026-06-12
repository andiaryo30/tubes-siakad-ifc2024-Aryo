<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('mahasiswa')->after('password');
        });

        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nidn')->unique();
            $table->string('nama');
            $table->string('email')->nullable()->unique();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });

        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->unsignedSmallInteger('angkatan');
            $table->string('kelas');
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->nullable()->after('role')->constrained()->nullOnDelete();
        });

        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->unsignedTinyInteger('sks');
            $table->unsignedTinyInteger('semester');
            $table->timestamps();
        });

        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_kuliah_id')->constrained()->cascadeOnDelete();
            $table->foreignId('dosen_id')->constrained('dosens')->cascadeOnDelete();
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('kelas');
            $table->string('ruang');
            $table->timestamps();
        });

        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jadwal_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['mahasiswa_id', 'jadwal_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('krs');
        Schema::dropIfExists('jadwals');
        Schema::dropIfExists('mata_kuliahs');

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('mahasiswa_id');
        });

        Schema::dropIfExists('mahasiswas');
        Schema::dropIfExists('dosens');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};

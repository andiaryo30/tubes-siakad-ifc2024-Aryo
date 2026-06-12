<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@siakad.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'mahasiswa_id' => null,
            ]
        );

        $mahasiswa = Mahasiswa::updateOrCreate(
            ['nim' => '230001'],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@siakad.test',
                'angkatan' => 2024,
                'kelas' => 'IF-A',
                'no_hp' => '081234567890',
                'alamat' => 'Bandung',
            ]
        );

        User::updateOrCreate(
            ['email' => $mahasiswa->email],
            [
                'name' => $mahasiswa->nama,
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'mahasiswa_id' => $mahasiswa->id,
            ]
        );

        $dosenA = Dosen::updateOrCreate(
            ['nidn' => '0401019001'],
            ['nama' => 'Dr. Andi Pratama', 'email' => 'andi@kampus.test', 'no_hp' => '081111111111', 'alamat' => 'Jakarta']
        );

        $dosenB = Dosen::updateOrCreate(
            ['nidn' => '0402029102'],
            ['nama' => 'Siti Rahma, M.Kom.', 'email' => 'siti@kampus.test', 'no_hp' => '082222222222', 'alamat' => 'Depok']
        );

        $mkA = MataKuliah::updateOrCreate(
            ['kode' => 'IF53413'],
            ['nama' => 'Pemrograman Web II', 'sks' => 3, 'semester' => 6]
        );

        $mkB = MataKuliah::updateOrCreate(
            ['kode' => 'IF53210'],
            ['nama' => 'Basis Data Lanjut', 'sks' => 3, 'semester' => 6]
        );

        $jadwalA = Jadwal::updateOrCreate(
            ['mata_kuliah_id' => $mkA->id, 'kelas' => 'IF-A'],
            ['dosen_id' => $dosenA->id, 'hari' => 'Selasa', 'jam_mulai' => '08:00', 'jam_selesai' => '10:30', 'ruang' => 'Lab 1']
        );

        Jadwal::updateOrCreate(
            ['mata_kuliah_id' => $mkB->id, 'kelas' => 'IF-A'],
            ['dosen_id' => $dosenB->id, 'hari' => 'Kamis', 'jam_mulai' => '13:00', 'jam_selesai' => '15:30', 'ruang' => 'Ruang 204']
        );

        Krs::firstOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'jadwal_id' => $jadwalA->id,
        ]);
    }
}

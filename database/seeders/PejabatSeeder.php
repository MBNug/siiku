<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PejabatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $signaturePath = 'tandatangan/demo-ttd.png';
        $tinyPng = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg=='
        );
        Storage::disk('public')->put($signaturePath, $tinyPng);

        $now = now();
        $records = [
            [
                'kode' => '0099',
                'departemen' => 'Fakultas',
                'jabatan' => 'Dekan',
                'nama' => 'Prof. Dr. Hendra Wijaya, M.Si.',
                'nip' => '197205141998021001',
                'tandatangan' => $signaturePath,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode' => '0098',
                'departemen' => 'Fakultas',
                'jabatan' => 'Wakil Dekan 1',
                'nama' => 'Dr. Ratna Sari, M.Kom.',
                'nip' => '197808212003122002',
                'tandatangan' => $signaturePath,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode' => '0101',
                'departemen' => 'Matematika',
                'jabatan' => 'Kepala Departemen Matematika',
                'nama' => 'Dr. Bambang Sutrisno, M.Si.',
                'nip' => '197503112000031001',
                'tandatangan' => $signaturePath,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode' => '0201',
                'departemen' => 'Biologi',
                'jabatan' => 'Kepala Departemen Biologi',
                'nama' => 'Dr. Lestari Handayani, M.Si.',
                'nip' => '197611092001122001',
                'tandatangan' => $signaturePath,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode' => '0301',
                'departemen' => 'Kimia',
                'jabatan' => 'Kepala Departemen Kimia',
                'nama' => 'Dr. Agus Kurniawan, M.Si.',
                'nip' => '197409151999031002',
                'tandatangan' => $signaturePath,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode' => '0401',
                'departemen' => 'Fisika',
                'jabatan' => 'Kepala Departemen Fisika',
                'nama' => 'Dr. Eko Prasetyo, M.Si.',
                'nip' => '197704232002121001',
                'tandatangan' => $signaturePath,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode' => '0501',
                'departemen' => 'Statistika',
                'jabatan' => 'Kepala Departemen Statistika',
                'nama' => 'Dr. Dwi Rahmawati, M.Stat.',
                'nip' => '197906172005012003',
                'tandatangan' => $signaturePath,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode' => '0601',
                'departemen' => 'Informatika',
                'jabatan' => 'Kepala Departemen Informatika',
                'nama' => 'Dr. Aris Wibowo, S.Kom., M.Cs.',
                'nip' => '198002102006041002',
                'tandatangan' => $signaturePath,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('pejabats')->insert($records);
    }
}

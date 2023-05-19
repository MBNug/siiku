<?php

namespace Database\Seeders;

use App\Models\Indikator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $indikators = [
            [
                'kode' => "0101", 
                'strategi' => "Meningkatkan Siklus dan Kualitas Penjaminan Mutu Akademik",
                'indikator_kinerja' => "Akreditasi Institusi", 
                'satuan' => "Unggul (nilai)",
                'keterangan' => null, 
                'definisi' => "Peringkat APT Universitas Diponegoro dan nilai", 
                'cara_perhitungan' => "Peringkat akreditasi",
            ],
            [
                'kode' => "0102", 
                'strategi' => "Meningkatkan Siklus dan Kualitas Penjaminan Mutu Akademik",
                'indikator_kinerja' => "Jumlah prodi terakreditasi Unggul", 
                'satuan' => "Persentase",
                'keterangan' => "Komulatif", 
                'definisi' => "Program studi (prodi) terakreditasi unggul merupakan indikator untuk mengukur kinerja prodi yang telah terakreditasi Unggul sesuai dengan standar mutu yang ditetapkan oleh BAN PT dan Lembaga Akreditasi Mandiri lainnya dengan merujuk pada Standar Nasional Pendidikan Tinggi.", 
                'cara_perhitungan' => "Jumlah prodi terakreditasi Unggul (ditunjukkan dengan sertifikat akreditasi yang masih berlaku pada tahun berjalan) dibagi jumlah seluruh prodi dikalikan 100%",
            ],
            [
                'kode' => "0103", 
                'strategi' => "Meningkatkan Siklus dan Kualitas Penjaminan Mutu Akademik",
                'indikator_kinerja' => "Jumlah prodi terakreditasi internasional", 
                'satuan' => "Persentase",
                'keterangan' => "Komulatif", 
                'definisi' => "Prodi terakreditasi internasional seperti AUN, ABEE, ABEST dan lainnya (satu prodi hanya diakui satu capaian walaupun terakreditasi lebih dari satu lembaga akreditasi)", 
                'cara_perhitungan' => "Jumlah prodi terakreditasi internasional (ditunjukkan dengan sertifikat akreditasi yang masih berlaku pada tahun berjalan) dibagi jumlah seluruh prodi dikalikan 100%",
            ],
            [
                'kode' => "0104", 
                'strategi' => "Meningkatkan Siklus dan Kualitas Penjaminan Mutu Akademik",
                'indikator_kinerja' => "Jumlah Prodi yang menawarkan program internasional", 
                'satuan' => "Persentase",
                'keterangan' => "Komulatif", 
                'definisi' => "Prodi yang menawarkan program internasional adalah indikator untuk mengukur jumlah Prodi yang membuka kelas/program internasional baik S1,S2,S3 ", 
                'cara_perhitungan' => "Jumlah prodi yang menawarkan program internasional (ditunjukkan dengan SK penyelenggaraan) dibagi jumlah seluruh prodi dikalikan 100%",
            ],
            [
                'kode' => "0205", 
                'strategi' => "Meningkatkan Kompetensi Mahasiswa yang Relevan dengan Revolusi Industri 4.0", 
                'indikator_kinerja' => "Jumlah Mahasiswa berwirausaha", 
                'satuan' => "Persentase",
                'keterangan' => "Nominal", 
                'definisi' => "Mahasiswa berwirausaha merupakan indikator untuk mengukur minat dan jiwa mahasiswa dalam berwirausaha dengan mengembangkan wirausaha secara mandiri, agar menjadi kelompok yang menciptakan lapangan pekerjaan (job creator) dan bukan hanya sekedar pencari pekerjaan (job seeker ). ", 
                'cara_perhitungan' => "Jumlah mahasiswa yang berwirausaha (daftar nama mahasiswa, NIM, jenis kegiatan wirausaha, foto produk wirausaha)",
            ],
            [
                'kode' => "0310", 
                'strategi' => "Meningkatkan Reputasi Undip Skala Nasional dan Internasional", 
                'indikator_kinerja' => "Jumlah prestasi mahasiswa juara pertama tingkat nasional ", 
                'satuan' => "prestasi per tahun ",
                'keterangan' => "Nominal", 
                'definisi' => "Prestasi mahasiswa juara pertama tingkat nasional pada tahun berjalan, kategori lomba tingkat nasional sesuai dengan ketentuan bidang kemahasiswaan. ", 
                'cara_perhitungan' => "Jumlah mahasiswa juara pertama tingkat nasional yang sudah terverifikasi, data terekam dalam aplikasi prestasi mahasiswa Undip. ",
            ],
            [
                'kode' => "0311", 
                'strategi' => "Meningkatkan Reputasi Undip Skala Nasional dan Internasional", 
                'indikator_kinerja' => "Jumlah prestasi mahasiswa juara pertama tingkat internasional ", 
                'satuan' => "prestasi per tahun",
                'keterangan' => "Nominal", 
                'definisi' => "Prestasi mahasiswa juara pertama tingkat internasional pada tahun berjalan, kategori lomba tingkat internasional sesuai dengan ketentuan bidang kemahasiswaan. ", 
                'cara_perhitungan' => "Jumlah prestasi mahasiswa juara pertama tingkat internasional 	prestasi per tahun 	nominal 	Prestasi mahasiswa juara pertama tingkat internasional pada tahun berjalan, kategori lomba tingkat internasional sesuai dengan ketentuan bidang kemahasiswaan. 	Jumlah mahasiswa juara pertama tingkat internasional yang sudah terverifikasi, data terekam dalam aplikasi prestasi mahasiswa Undip. ",
            ],
            
        ];
        foreach($indikators as $key => $value){
            Indikator::create($value);
        }
    }
}

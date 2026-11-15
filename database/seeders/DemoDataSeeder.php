<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    /**
     * Seed realistic indicators, targets, realizations, and quarter records for Renstra & PTNBH.
     *
     * @return void
     */
    public function run()
    {
        $year = (string) (DB::table('configs')->where('status', '1')->value('tahun') ?? date('Y'));
        $now = now();

        $renstraIndicators = [
            [
                'short' => '01',
                'strategi' => 'Meningkatkan Kualitas Lulusan & Daya Saing',
                'indikator_kinerja' => 'Persentase Lulusan Bersertifikat Kompetensi',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase lulusan tahun berjalan yang memperoleh sertifikat kompetensi profesi atau industri.',
                'cara_perhitungan' => 'Jumlah lulusan bersertifikat dibagi total lulusan dikalikan 100%.',
                'target' => '65',
            ],
            [
                'short' => '02',
                'strategi' => 'Meningkatkan Kompetensi & Prestasi Mahasiswa',
                'indikator_kinerja' => 'Persentase Mahasiswa Berprestasi Nasional/Internasional',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase mahasiswa aktif yang meraih prestasi minimal juara tingkat nasional atau internasional.',
                'cara_perhitungan' => 'Jumlah mahasiswa berprestasi dibagi total mahasiswa aktif dikalikan 100%.',
                'target' => '12',
            ],
            [
                'short' => '03',
                'strategi' => 'Mengakselerasi Riset & Publikasi Bereputasi',
                'indikator_kinerja' => 'Jumlah Publikasi Ilmiah Terindeks Scopus',
                'satuan' => 'Dokumen',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah artikel ilmiah dosen dan mahasiswa yang terbit pada jurnal terindeks Scopus.',
                'cara_perhitungan' => 'Akumulasi dokumen terpublikasi sepanjang tahun berjalan.',
                'target' => '40',
            ],
            [
                'short' => '04',
                'strategi' => 'Meningkatkan Siklus Penjaminan Mutu Akademik',
                'indikator_kinerja' => 'Persentase Program Studi Terakreditasi Unggul',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase program studi aktif dengan peringkat akreditasi Unggul atau setara internasional.',
                'cara_perhitungan' => 'Jumlah prodi Unggul dibagi total prodi di departemen dikalikan 100%.',
                'target' => '80',
            ],
            [
                'short' => '05',
                'strategi' => 'Memperluas Kemitraan Industri & Global',
                'indikator_kinerja' => 'Jumlah Kerja Sama Riset & Industri Aktif',
                'satuan' => 'Mitra',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah perjanjian kerja sama aktif yang menghasilkan luaran riset, magang, atau pendanaan.',
                'cara_perhitungan' => 'Jumlah MoA/PKS aktif dengan mitra industri atau universitas luar negeri.',
                'target' => '10',
            ],
        ];

        $ptnbhIndicators = [
            [
                'short' => '01',
                'strategi' => 'Penguatan Keterserapan Lulusan di Dunia Kerja',
                'indikator_kinerja' => 'Persentase Lulusan Bekerja/Studi Lanjut (< 6 Bulan)',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase lulusan S1 yang memperoleh pekerjaan layak, berwirausaha, atau studi lanjut.',
                'cara_perhitungan' => 'Hasil tracer study lulusan yang memenuhi kriteria IKU 1.',
                'target' => '80',
            ],
            [
                'short' => '02',
                'strategi' => 'Mobilitas & Pengalaman Dosen di Luar Kampus',
                'indikator_kinerja' => 'Persentase Dosen Berkegiatan Tridharma di Luar Kampus',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase dosen tetap yang melaksanakan tridharma di kampus QS100 atau industri.',
                'cara_perhitungan' => 'Jumlah dosen berkegiatan di luar kampus dibagi total dosen tetap dikalikan 100%.',
                'target' => '25',
            ],
            [
                'short' => '03',
                'strategi' => 'Transformasi Pembelajaran Berbasis Kasus & Proyek',
                'indikator_kinerja' => 'Persentase Mata Kuliah Case Method / Team-Based Project',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase mata kuliah yang menggunakan evaluasi minimal 50% berbasis pemecahan kasus atau proyek.',
                'cara_perhitungan' => 'Jumlah kelas berbasis proyek dibagi total kelas mata kuliah dikalikan 100%.',
                'target' => '60',
            ],
            [
                'short' => '04',
                'strategi' => 'Hilirisasi Inovasi & Kekayaan Intelektual',
                'indikator_kinerja' => 'Jumlah Luaran Penelitian & Paten Terimplementasi',
                'satuan' => 'Karya',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah paten, hak cipta, dan prototipe riset yang dimanfaatkan masyarakat atau industri.',
                'cara_perhitungan' => 'Total karya tervalidasi LPPM pada tahun berjalan.',
                'target' => '15',
            ],
            [
                'short' => '05',
                'strategi' => 'Internasionalisasi Program Studi',
                'indikator_kinerja' => 'Persentase Program Studi S1 Berstandar Internasional',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase prodi S1 yang memperoleh akreditasi atau sertifikasi internasional.',
                'cara_perhitungan' => 'Jumlah prodi berakreditasi internasional dibagi total prodi S1 dikalikan 100%.',
                'target' => '50',
            ],
        ];

        $this->seedTrack(
            $renstraIndicators,
            $year,
            $now,
            'indikators',
            'targets',
            'realisasis',
            'triwulan1s',
            'triwulan2s',
            1.0
        );

        $this->seedTrack(
            $ptnbhIndicators,
            $year,
            $now,
            'indikator_p_t_n_b_h_s',
            'target_p_t_n_b_h_s',
            'realisasi_p_t_n_b_h_s',
            'triwulan1_p_t_n_b_h_s',
            'triwulan2_p_t_n_b_h_s',
            0.9
        );
    }

    private function seedTrack(
        array $indicators,
        string $year,
        $now,
        string $indikatorTable,
        string $targetTable,
        string $realisasiTable,
        string $triwulan1Table,
        string $triwulan2Table,
        float $factor
    ): void {
        $indikatorRows = [];
        foreach ($indicators as $ind) {
            $indikatorRows[] = [
                'kode' => $ind['short'] . $year,
                'strategi' => $ind['strategi'],
                'indikator_kinerja' => $ind['indikator_kinerja'],
                'satuan' => $ind['satuan'],
                'keterangan' => $ind['keterangan'],
                'definisi' => $ind['definisi'],
                'cara_perhitungan' => $ind['cara_perhitungan'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table($indikatorTable)->insert($indikatorRows);

        $departments = ['01', '02', '03', '04', '05', '06'];
        $q1Statuses = ['Melampaui Target', 'Tercapai', 'Tercapai', 'Tidak Tercapai', 'Tercapai'];
        $q2Statuses = ['Melampaui Target', 'Tercapai', 'Tidak Tercapai', 'Sedang Diproses', 'Belum Diupdate'];

        $targetRows = [];
        $realisasiRows = [];
        $tw1Rows = [];
        $tw2Rows = [];

        foreach ($departments as $dIdx => $deptKode) {
            foreach ($indicators as $iIdx => $ind) {
                $kode = $deptKode . $ind['short'] . $year;
                $targetVal = (int) round(((int) $ind['target']) * $factor);
                if ($targetVal < 1) {
                    $targetVal = 1;
                }

                $q1Status = $q1Statuses[($dIdx + $iIdx) % count($q1Statuses)];
                $q2Status = $q2Statuses[($dIdx + $iIdx) % count($q2Statuses)];

                $q1Val = $this->valueForStatus($targetVal, $q1Status);
                $q2Val = $this->valueForStatus($targetVal, $q2Status);

                $base = [
                    'kode' => $kode,
                    'strategi' => $ind['strategi'],
                    'indikator_kinerja' => $ind['indikator_kinerja'],
                    'satuan' => $ind['satuan'],
                    'keterangan' => $ind['keterangan'],
                    'definisi' => $ind['definisi'],
                    'cara_perhitungan' => $ind['cara_perhitungan'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $targetRows[] = $base + [
                    'target' => (string) $targetVal,
                    'status' => '1',
                ];

                $realBase = $base + [
                    'target' => (string) $targetVal,
                    'bukti1' => null,
                    'bukti2' => null,
                    'bukti3' => null,
                    'bukti4' => null,
                    'bukti5' => null,
                ];

                $tw1Rows[] = $realBase + [
                    'nilai' => $q1Val,
                    'nilaireal' => $q1Val,
                    'status' => $q1Status,
                ];

                $tw2Rows[] = $realBase + [
                    'nilai' => $q2Val,
                    'nilaireal' => $q2Val,
                    'status' => $q2Status,
                    'statusterakhir' => $q1Status,
                ];

                $realisasiRows[] = $realBase + [
                    'nilai' => $q2Val,
                    'nilaireal' => $q2Val,
                    'status' => $q2Status,
                ];
            }
        }

        DB::table($targetTable)->insert($targetRows);
        DB::table($triwulan1Table)->insert($tw1Rows);
        DB::table($triwulan2Table)->insert($tw2Rows);
        DB::table($realisasiTable)->insert($realisasiRows);
    }

    private function valueForStatus(int $target, string $status): ?string
    {
        return match ($status) {
            'Melampaui Target' => (string) ((int) ceil($target * 1.15)),
            'Tercapai' => (string) $target,
            'Tidak Tercapai' => (string) max(1, (int) floor($target * 0.65)),
            'Sedang Diproses' => (string) max(1, (int) floor($target * 0.85)),
            default => '0',
        };
    }
}

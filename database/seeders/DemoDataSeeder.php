<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    /**
     * Seed rich indicators, targets, realizations, and multi-year quarter records for Renstra & PTN-BH.
     *
     * @return void
     */
    public function run()
    {
        $activeYear = (int) (DB::table('configs')->where('status', '1')->value('tahun') ?? date('Y'));
        $priorYear = max(2000, $activeYear - 1);
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
                'target' => '68',
            ],
            [
                'short' => '02',
                'strategi' => 'Meningkatkan Kualitas Lulusan & Daya Saing',
                'indikator_kinerja' => 'Persentase Lulusan Tepat Waktu (<= 4 Tahun)',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase lulusan program sarjana yang menyelesaikan studi dalam masa 8 semester.',
                'cara_perhitungan' => 'Jumlah lulusan tepat waktu dibagi jumlah total lulusan tahun berjalan dikalikan 100%.',
                'target' => '75',
            ],
            [
                'short' => '03',
                'strategi' => 'Meningkatkan Kompetensi & Prestasi Mahasiswa',
                'indikator_kinerja' => 'Persentase Mahasiswa Berprestasi Nasional/Internasional',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase mahasiswa aktif yang meraih prestasi minimal juara tingkat nasional atau internasional.',
                'cara_perhitungan' => 'Jumlah mahasiswa berprestasi dibagi total mahasiswa aktif dikalikan 100%.',
                'target' => '14',
            ],
            [
                'short' => '04',
                'strategi' => 'Meningkatkan Kompetensi & Prestasi Mahasiswa',
                'indikator_kinerja' => 'Jumlah Mahasiswa Penerima Hibah PKM & Kewirausahaan',
                'satuan' => 'Mahasiswa',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah mahasiswa aktif yang lolos pendanaan PKM, P2MW, atau program kewirausahaan nasional.',
                'cara_perhitungan' => 'Total mahasiswa penerima hibah pada tahun berjalan per departemen.',
                'target' => '32',
            ],
            [
                'short' => '05',
                'strategi' => 'Mengakselerasi Riset & Publikasi Bereputasi',
                'indikator_kinerja' => 'Jumlah Publikasi Ilmiah Terindeks Scopus',
                'satuan' => 'Dokumen',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah artikel ilmiah dosen dan mahasiswa yang terbit pada jurnal terindeks Scopus.',
                'cara_perhitungan' => 'Akumulasi dokumen terpublikasi sepanjang tahun berjalan.',
                'target' => '45',
            ],
            [
                'short' => '06',
                'strategi' => 'Mengakselerasi Riset & Publikasi Bereputasi',
                'indikator_kinerja' => 'Jumlah Sitasi Karya Ilmiah Dosen pada Jurnal Bereputasi',
                'satuan' => 'Sitasi',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah sitasi terhadap artikel terindeks Scopus atau Web of Science milik dosen tetap.',
                'cara_perhitungan' => 'Akumulasi sitasi baru yang tercatat selama periode evaluasi.',
                'target' => '180',
            ],
            [
                'short' => '07',
                'strategi' => 'Mengakselerasi Riset & Publikasi Bereputasi',
                'indikator_kinerja' => 'Jumlah Judul Penelitian Kompetitif Nasional & Internasional',
                'satuan' => 'Judul',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah proposal penelitian dosen yang memperoleh pendanaan eksternal atau hibah internasional.',
                'cara_perhitungan' => 'Total kontrak penelitian aktif pada tahun anggaran berjalan.',
                'target' => '16',
            ],
            [
                'short' => '08',
                'strategi' => 'Menguatkan Pengabdian & Hilirisasi Kepakaran',
                'indikator_kinerja' => 'Jumlah Program Pengabdian Masyarakat Berdampak Nyata',
                'satuan' => 'Kegiatan',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah program pengabdian masyarakat berbasis hasil riset yang bermitra dengan pemerintah atau UMKM.',
                'cara_perhitungan' => 'Total laporan kegiatan pengabdian yang disahkan LPPM.',
                'target' => '18',
            ],
            [
                'short' => '09',
                'strategi' => 'Meningkatkan Kualitas SDM Akademik',
                'indikator_kinerja' => 'Persentase Dosen Tetap Berkualifikasi Doktor (S3)',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase dosen tetap ber-NIDN yang telah menyelesaikan pendidikan jenjang doktor.',
                'cara_perhitungan' => 'Jumlah dosen bergelar S3 dibagi total dosen tetap dikalikan 100%.',
                'target' => '64',
            ],
            [
                'short' => '10',
                'strategi' => 'Meningkatkan Kualitas SDM Akademik',
                'indikator_kinerja' => 'Persentase Dosen Bersertifikat Pendidik & Jabatan Lektor Kepala+',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase dosen tetap yang memiliki jabatan fungsional Lektor Kepala atau Guru Besar.',
                'cara_perhitungan' => 'Jumlah Lektor Kepala dan Guru Besar dibagi total dosen tetap dikalikan 100%.',
                'target' => '42',
            ],
            [
                'short' => '11',
                'strategi' => 'Meningkatkan Siklus Penjaminan Mutu Akademik',
                'indikator_kinerja' => 'Persentase Program Studi Terakreditasi Unggul',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase program studi aktif dengan peringkat akreditasi Unggul atau setara internasional.',
                'cara_perhitungan' => 'Jumlah prodi Unggul dibagi total prodi di departemen dikalikan 100%.',
                'target' => '85',
            ],
            [
                'short' => '12',
                'strategi' => 'Meningkatkan Siklus Penjaminan Mutu Akademik',
                'indikator_kinerja' => 'Persentase Mata Kuliah dengan RPS Mutakhir & OBE',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase mata kuliah aktif yang memiliki Rencana Pembelajaran Semester berbasis Outcome-Based Education.',
                'cara_perhitungan' => 'Jumlah MK ber-RPS OBE dibagi total MK ditawarkan dikalikan 100%.',
                'target' => '95',
            ],
            [
                'short' => '13',
                'strategi' => 'Memperluas Kemitraan Industri & Global',
                'indikator_kinerja' => 'Jumlah Kerja Sama Riset & Industri Aktif',
                'satuan' => 'Mitra',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah perjanjian kerja sama aktif yang menghasilkan luaran riset, magang, atau pendanaan.',
                'cara_perhitungan' => 'Jumlah MoA/PKS aktif dengan mitra industri atau universitas luar negeri.',
                'target' => '12',
            ],
            [
                'short' => '14',
                'strategi' => 'Memperluas Kemitraan Industri & Global',
                'indikator_kinerja' => 'Jumlah Mahasiswa Inbound & Outbound Pertukaran Internasional',
                'satuan' => 'Mahasiswa',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah mahasiswa asing masuk maupun mahasiswa departemen yang mengikuti program mobilitas luar negeri.',
                'cara_perhitungan' => 'Akumulasi peserta student exchange atau summer course minimal 14 hari.',
                'target' => '10',
            ],
            [
                'short' => '15',
                'strategi' => 'Modernisasi Tata Kelola & Digitalisasi Layanan',
                'indikator_kinerja' => 'Persentase Layanan Akademik Terintegrasi Digital',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase layanan administrasi akademik mahasiswa yang diproses tanpa berkas fisik.',
                'cara_perhitungan' => 'Jumlah layanan digital aktif dibagi total layanan departemen dikalikan 100%.',
                'target' => '90',
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
                'target' => '82',
            ],
            [
                'short' => '02',
                'strategi' => 'Penguatan Keterserapan Lulusan di Dunia Kerja',
                'indikator_kinerja' => 'Persentase Lulusan Bergaji >= 1.2x UMP pada Tahun Pertama',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase lulusan bekerja yang memperoleh penghasilan minimal 1.2 kali UMP wilayah kerja.',
                'cara_perhitungan' => 'Jumlah lulusan memenuhi batas gaji dibagi total responden tracer study dikalikan 100%.',
                'target' => '65',
            ],
            [
                'short' => '03',
                'strategi' => 'Pengalaman Mahasiswa di Luar Kampus',
                'indikator_kinerja' => 'Persentase Mahasiswa Mengikuti Program MBKM Minimal 20 SKS',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase mahasiswa S1 yang menyelesaikan kegiatan magang industri, riset, atau KKN tematik >= 20 SKS.',
                'cara_perhitungan' => 'Jumlah peserta MBKM dikonversi SKS dibagi total mahasiswa eligible dikalikan 100%.',
                'target' => '38',
            ],
            [
                'short' => '04',
                'strategi' => 'Mobilitas & Pengalaman Dosen di Luar Kampus',
                'indikator_kinerja' => 'Persentase Dosen Berkegiatan Tridharma di Luar Kampus',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase dosen tetap yang melaksanakan tridharma di kampus QS100 atau industri.',
                'cara_perhitungan' => 'Jumlah dosen berkegiatan di luar kampus dibagi total dosen tetap dikalikan 100%.',
                'target' => '28',
            ],
            [
                'short' => '05',
                'strategi' => 'Mobilitas & Pengalaman Dosen di Luar Kampus',
                'indikator_kinerja' => 'Persentase Dosen Praktisi Mengajar di Program Studi',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase mata kuliah inti yang menghadirkan praktisi industri atau profesional minimal 4 pertemuan.',
                'cara_perhitungan' => 'Jumlah kelas melibatkan praktisi dibagi total kelas mata kuliah inti dikalikan 100%.',
                'target' => '30',
            ],
            [
                'short' => '06',
                'strategi' => 'Transformasi Pembelajaran Berbasis Kasus & Proyek',
                'indikator_kinerja' => 'Persentase Mata Kuliah Case Method / Team-Based Project',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase mata kuliah yang menggunakan evaluasi minimal 50% berbasis pemecahan kasus atau proyek.',
                'cara_perhitungan' => 'Jumlah kelas berbasis proyek dibagi total kelas mata kuliah dikalikan 100%.',
                'target' => '64',
            ],
            [
                'short' => '07',
                'strategi' => 'Transformasi Pembelajaran Berbasis Kasus & Proyek',
                'indikator_kinerja' => 'Jumlah Modul Pembelajaran Digital & Micro-Credentials',
                'satuan' => 'Modul',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah paket pembelajaran daring terbuka atau modul sertifikasi mikro yang diterbitkan departemen.',
                'cara_perhitungan' => 'Total modul terverifikasi pada platform pembelajaran fakultas.',
                'target' => '14',
            ],
            [
                'short' => '08',
                'strategi' => 'Hilirisasi Inovasi & Kekayaan Intelektual',
                'indikator_kinerja' => 'Jumlah Luaran Penelitian & Paten Terimplementasi',
                'satuan' => 'Karya',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah paten, hak cipta, dan prototipe riset yang dimanfaatkan masyarakat atau industri.',
                'cara_perhitungan' => 'Total karya tervalidasi LPPM pada tahun berjalan.',
                'target' => '18',
            ],
            [
                'short' => '09',
                'strategi' => 'Hilirisasi Inovasi & Kekayaan Intelektual',
                'indikator_kinerja' => 'Jumlah Produk Inovasi Hasil Kerja Sama Industri (TKT >= 6)',
                'satuan' => 'Produk',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah purwarupa atau teknologi teruji di lingkungan relevan bersama mitra industri.',
                'cara_perhitungan' => 'Total produk berstatus TKT >= 6 dengan berita acara uji.',
                'target' => '6',
            ],
            [
                'short' => '10',
                'strategi' => 'Internasionalisasi Program Studi',
                'indikator_kinerja' => 'Persentase Program Studi S1 Berstandar Internasional',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase prodi S1 yang memperoleh akreditasi atau sertifikasi internasional.',
                'cara_perhitungan' => 'Jumlah prodi berakreditasi internasional dibagi total prodi S1 dikalikan 100%.',
                'target' => '55',
            ],
            [
                'short' => '11',
                'strategi' => 'Internasionalisasi Program Studi',
                'indikator_kinerja' => 'Jumlah Joint Research & Co-Authorship dengan Kampus QS100',
                'satuan' => 'Publikasi',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah publikasi bersama peneliti dari universitas peringkat 100 dunia versi QS WUR.',
                'cara_perhitungan' => 'Total artikel terbit dengan afiliasi co-author QS100.',
                'target' => '12',
            ],
            [
                'short' => '12',
                'strategi' => 'Penguatan Sumber Pendanaan Mandiri PTN-BH',
                'indikator_kinerja' => 'Jumlah Proyek Konsultansi, Pengujian Lab, & Income Generating',
                'satuan' => 'Kontrak',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah kontrak jasa kepakaran, pengujian laboratorium, atau pelatihan profesional berbayar.',
                'cara_perhitungan' => 'Total kontrak kerjasama komersial tercatat di unit usaha departemen.',
                'target' => '20',
            ],
            [
                'short' => '13',
                'strategi' => 'Penguatan Sumber Pendanaan Mandiri PTN-BH',
                'indikator_kinerja' => 'Persentase Peningkatan Dana Riset Non-APBN per Dosen',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Pertumbuhan perolehan pendanaan riset dari sponsor swasta, lembaga filantropi, atau hibah luar negeri.',
                'cara_perhitungan' => 'Selisih dana riset non-APBN tahun berjalan dibanding tahun dasar dikalikan 100%.',
                'target' => '25',
            ],
            [
                'short' => '14',
                'strategi' => 'Kinerja Kepemimpinan & Reputasi Akademik',
                'indikator_kinerja' => 'Jumlah Dosen Menjadi Reviewer/Editor Jurnal Bereputasi Q1–Q2',
                'satuan' => 'Orang',
                'keterangan' => 'Nominal',
                'definisi' => 'Jumlah dosen aktif yang tercatat sebagai editor atau mitra bestari jurnal internasional Q1–Q2.',
                'cara_perhitungan' => 'Jumlah surat tugas atau bukti pengakuan resmi penerbit internasional.',
                'target' => '16',
            ],
            [
                'short' => '15',
                'strategi' => 'Keberlanjutan Kampus & Tata Kelola Hijau',
                'indikator_kinerja' => 'Persentase Efisiensi Energi & Digitalisasi Arsip Departemen',
                'satuan' => 'Persentase',
                'keterangan' => 'Komulatif',
                'definisi' => 'Persentase dokumen administrasi terarsip digital disertai program pengurangan kertas departemen.',
                'cara_perhitungan' => 'Rasio arsip terdigitalisasi dibagi total arsip operasional dikalikan 100%.',
                'target' => '88',
            ],
        ];

        // Seed archived prior year (complete TW 1-4) and active current year (TW 1-2)
        $years = [
            ['year' => (string) $priorYear, 'includeAllQuarters' => true],
            ['year' => (string) $activeYear, 'includeAllQuarters' => false],
        ];

        foreach ($years as $yearMeta) {
            $this->seedTrack(
                $renstraIndicators,
                $yearMeta['year'],
                $now,
                'indikators',
                'targets',
                'realisasis',
                'triwulan1s',
                'triwulan2s',
                'triwulan3s',
                'triwulan4s',
                1.0,
                $yearMeta['includeAllQuarters']
            );

            $this->seedTrack(
                $ptnbhIndicators,
                $yearMeta['year'],
                $now,
                'indikator_p_t_n_b_h_s',
                'target_p_t_n_b_h_s',
                'realisasi_p_t_n_b_h_s',
                'triwulan1_p_t_n_b_h_s',
                'triwulan2_p_t_n_b_h_s',
                'triwulan3_p_t_n_b_h_s',
                'triwulan4_p_t_n_b_h_s',
                0.9,
                $yearMeta['includeAllQuarters']
            );
        }
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
        string $triwulan3Table,
        string $triwulan4Table,
        float $factor,
        bool $includeAllQuarters
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
        $this->chunkInsert($indikatorTable, $indikatorRows);

        $departments = ['01', '02', '03', '04', '05', '06'];
        $q1Statuses = ['Melampaui Target', 'Tercapai', 'Tercapai', 'Tidak Tercapai', 'Tercapai'];
        $q2Statuses = ['Melampaui Target', 'Tercapai', 'Tidak Tercapai', 'Sedang Diproses', 'Belum Diupdate'];
        $q3Statuses = ['Tercapai', 'Melampaui Target', 'Tercapai', 'Tidak Tercapai', 'Tercapai'];
        $q4Statuses = ['Melampaui Target', 'Tercapai', 'Tercapai', 'Melampaui Target', 'Tidak Tercapai'];

        $targetRows = [];
        $realisasiRows = [];
        $tw1Rows = [];
        $tw2Rows = [];
        $tw3Rows = [];
        $tw4Rows = [];

        foreach ($departments as $dIdx => $deptKode) {
            foreach ($indicators as $iIdx => $ind) {
                $kode = $deptKode . $ind['short'] . $year;
                $targetVal = (int) round(((int) $ind['target']) * $factor);
                if ($targetVal < 1) {
                    $targetVal = 1;
                }

                $q1Status = $q1Statuses[($dIdx + $iIdx) % count($q1Statuses)];
                $q2Status = $includeAllQuarters
                    ? $q3Statuses[($dIdx + $iIdx) % count($q3Statuses)]
                    : $q2Statuses[($dIdx + $iIdx) % count($q2Statuses)];
                $q3Status = $q3Statuses[($dIdx + $iIdx + 1) % count($q3Statuses)];
                $q4Status = $q4Statuses[($dIdx + $iIdx) % count($q4Statuses)];

                $q1Val = $this->valueForStatus($targetVal, $q1Status);
                $q2Val = $this->valueForStatus($targetVal, $q2Status);
                $q3Val = $this->valueForStatus($targetVal, $q3Status);
                $q4Val = $this->valueForStatus($targetVal, $q4Status);

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

                if ($includeAllQuarters) {
                    $tw3Rows[] = $realBase + [
                        'nilai' => $q3Val,
                        'nilaireal' => $q3Val,
                        'status' => $q3Status,
                        'statusterakhir' => $q2Status,
                    ];

                    $tw4Rows[] = $realBase + [
                        'nilai' => $q4Val,
                        'nilaireal' => $q4Val,
                        'status' => $q4Status,
                        'statusterakhir' => $q3Status,
                    ];

                    $realisasiRows[] = $realBase + [
                        'nilai' => $q4Val,
                        'nilaireal' => $q4Val,
                        'status' => $q4Status,
                    ];
                } else {
                    $realisasiRows[] = $realBase + [
                        'nilai' => $q2Val,
                        'nilaireal' => $q2Val,
                        'status' => $q2Status,
                    ];
                }
            }
        }

        $this->chunkInsert($targetTable, $targetRows);
        $this->chunkInsert($triwulan1Table, $tw1Rows);
        $this->chunkInsert($triwulan2Table, $tw2Rows);
        if ($includeAllQuarters) {
            $this->chunkInsert($triwulan3Table, $tw3Rows);
            $this->chunkInsert($triwulan4Table, $tw4Rows);
        }
        $this->chunkInsert($realisasiTable, $realisasiRows);
    }

    private function chunkInsert(string $table, array $rows): void
    {
        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table($table)->insert($chunk);
        }
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

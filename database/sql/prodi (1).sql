-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 04 Nov 2025 pada 10.41
-- Versi server: 10.9.8-MariaDB-1:10.9.8+maria~ubu2204
-- Versi PHP: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opensimka-production`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` varchar(10) NOT NULL COMMENT 'Identitas unik Prodi',
  `kode_reg_prodi` varchar(3) NOT NULL,
  `kode_fak` varchar(10) NOT NULL COMMENT 'Identitas unik fakultas',
  `id_jenj_didik` int(2) UNSIGNED NOT NULL COMMENT 'Identitas unik jenjang pendidikan. Contoh nilai: bilangan integer dimulai dari 1',
  `nm_prodi` varchar(100) NOT NULL COMMENT 'Nama resmi prodi dalam bahasa Indonesia',
  `nm_sing_prodi` varchar(20) NOT NULL COMMENT 'Nama singkatan prodi',
  `nm_intl_prodi` varchar(100) NOT NULL COMMENT 'Nama internasional prodi dalam bahasa inggris',
  `bendera_warna_bg` varchar(7) NOT NULL,
  `bendera_warna_teks` varchar(7) NOT NULL,
  `target_smt_jadwal_krs` varchar(5) NOT NULL COMMENT 'target semester berlakunya jadwal pengisian KRS',
  `isi_krs_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'jadwal mulai pengisian KRS Reguler mahasiswa lama',
  `isi_krs_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'jadwal akhir pengisian KRS Reguler mahasiswa lama',
  `isi_krs_start_maba` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'jadwal mulai pengisian KRS Reguler mahasiswa baru',
  `isi_krs_stop_maba` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'jadwal akhir pengisian KRS Reguler mahasiswa baru',
  `isi_krs_ekstensi_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'jadwal mulai pengisian KRS Ekstensi mahasiswa baru dan lama',
  `isi_krs_ekstensi_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'jadwal akhir pengisian KRS Ekstensi mahasiswa baru dan lama',
  `tgl_start_revisi_krs` date NOT NULL DEFAULT '0000-00-00' COMMENT 'jadwal mulai revisi KRS',
  `tgl_stop_revisi_krs` date NOT NULL DEFAULT '0000-00-00' COMMENT 'jadwal akhir revisi KRS',
  `allow_konversi_nilai` int(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'perbolehkan akses konversi nilai mahasiswa',
  `email` varchar(50) NOT NULL COMMENT 'Alamat email yang masih aktif',
  `website` varchar(100) NOT NULL COMMENT 'Alamat website',
  `nm_jurnal` varchar(100) NOT NULL,
  `cover_jurnal` varchar(100) NOT NULL,
  `link_jurnal` varchar(100) NOT NULL,
  `tgl_berdiri` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Tanggal pendirian Prodi',
  `sk_selenggara` varchar(100) NOT NULL,
  `no_sk_selenggara` varchar(50) NOT NULL COMMENT 'Nomor SK diselenggarakannya Prodi',
  `tgl_sk_selenggara` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Tanggal dikeluarkannya surat keputusan tentang penyelenggaran Prodi',
  `gelar_lulusan` varchar(10) NOT NULL COMMENT 'Gelar yang diterima oleh lulusan program studi',
  `stat_prodi` varchar(1) NOT NULL COMMENT 'Keterangan keaktifan program studi. Contoh nilai: A = Aktif B = Alih bentuk K = Alih kelola N = Non aktif H = Dihapus'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='data prodi';

--
-- Dumping data untuk tabel `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `kode_reg_prodi`, `kode_fak`, `id_jenj_didik`, `nm_prodi`, `nm_sing_prodi`, `nm_intl_prodi`, `bendera_warna_bg`, `bendera_warna_teks`, `target_smt_jadwal_krs`, `isi_krs_start`, `isi_krs_stop`, `isi_krs_start_maba`, `isi_krs_stop_maba`, `isi_krs_ekstensi_start`, `isi_krs_ekstensi_stop`, `tgl_start_revisi_krs`, `tgl_stop_revisi_krs`, `allow_konversi_nilai`, `email`, `website`, `nm_jurnal`, `cover_jurnal`, `link_jurnal`, `tgl_berdiri`, `sk_selenggara`, `no_sk_selenggara`, `tgl_sk_selenggara`, `gelar_lulusan`, `stat_prodi`) VALUES
('-', '', '-', 99, 'Tidak Terikat Prodi', 'N/A', 'Not Available', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', 0, '', '', '', '', '', '0000-00-00', '', '', '0000-00-00', '', ''),
('11111', '99', 'FLPT', 92, 'Pertukaran Mahasiswa', 'PM', 'Student Exchange', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', 0, '', '', '', '', '', '0000-00-00', '', '', '0000-00-00', '', 'N'),
('14201', '12', 'FSTIK', 30, 'Keperawatan', 'KEPERAWATAN', 'Nursing', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-10-13 00:00:01', '2025-10-24 23:59:59', '2025-08-29', '2025-08-29', 0, 'ners@bbg.ac.id', 'https://ners.bbg.ac.id', 'Getsempena Health Science Journal', 'ghsj.jpg', 'https://ejournal.bbg.ac.id/ghsj', '2021-04-09', 'SK-Pendirian-S1-KEPERAWATAN-703.pdf', '128/E/O/2021', '2021-04-09', 'S.Kep', 'A'),
('14901', '11', 'FSTIK', 31, 'Pendidikan Profesi Ners', 'PPN', 'Nurse Professional Education', '', '', '20251', '2025-10-13 00:00:01', '2025-10-24 23:59:59', '2025-10-13 00:00:01', '2025-10-24 23:59:59', '2025-10-13 00:00:01', '2025-10-24 23:59:59', '2025-08-29', '2025-08-29', 0, 'ners@bbg.ac.id', 'https://ners.bbg.ac.id', 'Getsempena Health Science Journal', 'ghsj.jpg', 'https://ejournal.bbg.ac.id/ghsj', '2021-04-09', 'SK-Pendirian--PPN-398.pdf', '128/E/O/2021', '2021-04-09', 'Ns', 'A'),
('15201', '15', 'FSTIK', 30, 'Kebidanan', 'KEBIDANAN', 'Midwifery', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-10-13 00:00:01', '2025-10-24 23:59:59', '2025-08-29', '2025-08-29', 0, 'bidan@bbg.ac.id', 'https://bidan.bbg.ac.id', 'Getsempena Health Science Journal', 'ghsj.jpg', 'https://ejournal.bbg.ac.id/ghsj', '2021-04-09', 'SK-Pendirian-S1-KEBIDANAN-435.pdf', '128/E/O/2021', '2021-04-09', 'S.Keb', 'A'),
('15401', '13', 'FSTIK', 22, 'Kebidanan', 'KEBID', 'Midwifery', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', 0, 'bidan@bbg.ac.id', 'https://bidan.bbg.ac.id', 'Getsempena Health Science Journal', 'ghsj.jpg', 'https://ejournal.bbg.ac.id/ghsj', '2021-04-09', '', '', '0000-00-00', '', 'N'),
('15901', '14', 'FSTIK', 31, 'Pendidikan Profesi Bidan', 'PPB', 'Midwife Professional Education', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-10-13 00:00:01', '2025-10-24 23:59:59', '2025-08-29', '2025-08-29', 0, 'bidan@bbg.ac.id', 'https://bidan.bbg.ac.id', 'Getsempena Health Science Journal', 'ghsj.jpg', 'https://ejournal.bbg.ac.id/ghsj', '2021-04-09', 'SK-Pendirian--PPB-135.pdf', '128/E/O/2021', '2021-04-09', 'Bd', 'A'),
('55201', '10', 'FSTIK', 30, 'Ilmu Komputer', 'ILKOM', 'Computer Science', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-08-11 00:00:01', '2025-08-16 23:59:59', '2025-08-29', '2025-08-29', 0, 'ilkom@bbg.ac.id', 'https://ilkom.bbg.ac.id', 'Getsempena Health Science Journal', 'ghsj.jpg', 'https://ejournal.bbg.ac.id/ghsj', '2021-04-09', 'SK-Pendirian-S1-ILKOM-165.pdf', '128/E/O/2021', '2021-04-09', 'S.Kom', 'A'),
('79219', '20', 'FKIP', 30, 'Pendidikan Bahasa dan Sastra Aceh', 'PBSA', 'Acehnese Language and Literature Education', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-08-11 00:00:01', '2025-08-16 23:59:59', '2025-08-29', '2025-08-29', 0, 'pbsa@bbg.ac.id', 'https://pbsa.bbg.ac.id', '', '', '', '2025-08-19', 'SK-Pendirian-S1-PBSA-969.pdf', '2662/B1/HK.03.00/2025', '2025-08-19', 'S.Pd', 'A'),
('84202', '05', 'FKIP', 30, 'Pendidikan Matematika', 'PMAT', 'Mathematics Education', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-08-11 00:00:01', '2025-08-16 23:59:59', '2025-08-29', '2025-08-29', 0, 'pmat@bbg.ac.id', 'https://pmat.bbg.ac.id', 'Numeracy Journal', 'numeracy.jpg', 'https://ejournal.bbg.ac.id/numeracy', '2008-09-22', 'SK-Pendirian-S1-PMAT-504.pdf', '3404/D/T/2008', '2008-09-22', 'S.Pd', 'A'),
('84208', '18', 'FKIP', 30, 'Pendidikan Ilmu Pengetahuan Alam', 'PENIPA', 'Natural Science Education', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-08-11 00:00:01', '2025-08-16 23:59:59', '2025-08-29', '2025-08-29', 0, 'penipa@bbg.ac.id', 'https://penipa.bbg.ac.id', '', '', '', '2023-06-06', 'SK-Pendirian-S1-PIPA-508.pdf', '498//E/O/2023', '2023-06-06', 'S.Pd', 'A'),
('85201', '04', 'FKIP', 30, 'Pendidikan Jasmani', 'PENJAS', 'Physical Education', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-10-13 00:00:01', '2025-10-24 23:59:59', '2025-08-29', '2025-08-29', 0, 'penjas@bbg.ac.id', 'https://penjas.bbg.ac.id', 'Penjaskesrek Journal', 'penjaskesrek.jpg', 'https://ejournal.bbg.ac.id/penjaskesrek', '2008-05-19', 'SK-Pendirian-S1-PENJAS-839.pdf', '1638/D/T/2008', '2008-05-19', 'S.Pd', 'A'),
('86109', '16', 'SPs', 35, 'Penjaminan Mutu Pendidikan', 'PMP', 'Education Quality Assurance', '', '', '20251', '2025-10-01 00:00:01', '2025-10-30 23:59:59', '2025-10-01 00:00:01', '2025-10-30 23:59:59', '1970-01-01 00:00:01', '1970-01-01 23:59:59', '0000-00-00', '0000-00-00', 0, 'pmp@bbg.ac.id', 'https://pmp.bbg.ac.id', '', '', '', '2022-02-17', 'SK-Pendirian-S2-PMP-238.pdf', '97/E/O/2022', '2022-02-17', 'M.Pd', 'A'),
('86122', '17', 'SPs', 35, 'Pendidikan Dasar', 'PENDAS', 'Basic Education', '', '', '20251', '2025-10-01 00:00:01', '2025-10-30 23:59:59', '2025-10-01 00:00:01', '2025-10-30 23:59:59', '1970-01-01 00:00:01', '1970-01-01 23:59:59', '0000-00-00', '0000-00-00', 0, 'pendas@bbg.ac.id', 'https://pendas.bbg.ac.id', '', '', '', '2022-06-07', 'SK-Pendirian-S2-PENDAS-699.pdf', '393/E/O2022', '2022-06-07', 'M.Pd', 'A'),
('86206', '08', 'FKIP', 30, 'Pendidikan Guru Sekolah Dasar', 'PGSD', 'Primary Teacher Education', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-10-13 00:00:01', '2025-10-24 23:59:59', '2025-08-29', '2025-08-29', 0, 'pgsd@bbg.ac.id', 'https://pgsd.bbg.ac.id', 'Tunas Bangsa Journal', 'tunasbangsa.jpg', 'https://ejournal.bbg.ac.id/tunasbangsa', '2009-11-24', 'SK-Pendirian-S1-PGSD-818.pdf', '2065/D/T/2009', '2009-11-24', 'S.Pd', 'A'),
('86207', '07', 'FKIP', 30, 'Pendidikan Guru Pendidikan Anak Usia Dini', 'PGPAUD', 'Teacher Education Early Childhood Education', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-10-13 00:00:01', '2025-10-24 23:59:59', '2025-08-29', '2025-08-29', 0, 'pgpaud@bbg.ac.id', 'https://pgpaud.bbg.ac.id', 'Buah Hati Journal', 'buahhati.jpg', 'https://ejournal.bbg.ac.id/buahhati', '2009-08-31', 'SK-Pendirian-S1-PGPAUD-330.pdf', '1580/D/T/2009', '2009-08-31', 'S.Pd', 'A'),
('86904', '09', 'FKIP', 31, 'Pendidikan Profesi Guru', 'PPG', 'Teacher Professional Education', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-10-13 00:00:01', '2025-10-24 23:59:59', '2025-08-29', '2025-08-29', 0, 'ppg@bbg.ac.id', 'https://ppg.bbg.ac.id', '', '', '', '2020-04-14', 'SK-Pendirian--PPG-248.pdf', '40549/A5/HK/2020', '2020-04-14', 'Gr', 'A'),
('88201', '01', 'FKIP', 30, 'Pendidikan Bahasa Indonesia', 'PENBI', 'Indonesia Language Education', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-08-11 00:00:01', '2025-08-16 23:59:59', '2025-08-29', '2025-08-29', 0, 'penbi@bbg.ac.id', 'https://penbi.bbg.ac.id', 'Metamorfosa Journal', 'metamorfosa.jpg', 'https://ejournal.bbg.ac.id/metamorfosa', '2003-09-05', 'SK-Pendirian-S1-PENBI-145.pdf', '138/D/O/2003', '2003-09-05', 'S.Pd', 'A'),
('88203', '06', 'FKIP', 30, 'Pendidikan Bahasa Inggris', 'PBI', 'English Language Education', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-08-11 00:00:01', '2025-08-16 23:59:59', '2025-08-29', '2025-08-29', 0, 'pbi@bbg.ac.id', 'https://pbi.bbg.ac.id', 'Getsempena English Education Journal (GEEJ)', 'geej.jpg', 'https://ejournal.bbg.ac.id/geej', '2008-09-22', 'SK-Pendirian-S1-PBI-818.pdf', '3404/D/T/2008', '2008-09-22', 'S.Pd', 'A'),
('88217', '19', 'FKIP', 30, 'Pendidikan Seni Pertunjukan', 'PSENI', 'Performing Arts Education', '', '', '20251', '2025-08-07 00:00:01', '2025-08-29 23:59:59', '2025-09-01 00:00:01', '2025-09-04 23:59:59', '2025-08-11 00:00:01', '2025-08-16 23:59:59', '2025-08-29', '2025-08-29', 0, 'pseni@bbg.ac.id', 'https://pseni.bbg.ac.id', '', '', '', '2023-06-16', 'SK-Pendirian-S1-PSENI-286.pdf', '532/E/O/2023', '2023-06-16', 'S.Pd', 'A');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`),
  ADD UNIQUE KEY `kode_reg_prodi` (`kode_reg_prodi`),
  ADD KEY `nm_prodi` (`nm_prodi`,`kode_fak`,`id_jenj_didik`),
  ADD KEY `nm_sing_prodi` (`nm_sing_prodi`),
  ADD KEY `nm_intl_prodi` (`nm_intl_prodi`),
  ADD KEY `bendera_warna_bg` (`bendera_warna_bg`),
  ADD KEY `bendera_warna_teks` (`bendera_warna_teks`),
  ADD KEY `target_smt_jadwal_krs` (`target_smt_jadwal_krs`),
  ADD KEY `isi_krs_start` (`isi_krs_start`),
  ADD KEY `isi_krs_stop` (`isi_krs_stop`),
  ADD KEY `isi_krs_start_maba` (`isi_krs_start_maba`),
  ADD KEY `isi_krs_stop_maba` (`isi_krs_stop_maba`),
  ADD KEY `isi_krs_ekstensi_start` (`isi_krs_ekstensi_start`),
  ADD KEY `isi_krs_ekstensi_stop` (`isi_krs_ekstensi_stop`),
  ADD KEY `tgl_start_revisi_krs` (`tgl_start_revisi_krs`),
  ADD KEY `tgl_stop_revisi_krs` (`tgl_stop_revisi_krs`),
  ADD KEY `allow_konversi_nilai` (`allow_konversi_nilai`),
  ADD KEY `email` (`email`),
  ADD KEY `website` (`website`),
  ADD KEY `stat_prodi` (`stat_prodi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

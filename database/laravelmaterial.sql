/*
 Navicat Premium Data Transfer

 Source Server         : GGMA
 Source Server Type    : MySQL
 Source Server Version : 80030
 Source Host           : 127.0.0.1:3306
 Source Schema         : laravelmaterial

 Target Server Type    : MySQL
 Target Server Version : 80030
 File Encoding         : 65001

 Date: 26/01/2023 17:29:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for approve_kertas_kerja
-- ----------------------------
DROP TABLE IF EXISTS `approve_kertas_kerja`;
CREATE TABLE `approve_kertas_kerja`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pkpt` int NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `status` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of approve_kertas_kerja
-- ----------------------------
INSERT INTO `approve_kertas_kerja` VALUES (1, 2, '20221209191857.pdf', 3);
INSERT INTO `approve_kertas_kerja` VALUES (2, 2, '20221209191907.pdf', 1);
INSERT INTO `approve_kertas_kerja` VALUES (3, 4, '20221209191917.pdf', 2);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for header_pkpt
-- ----------------------------
DROP TABLE IF EXISTS `header_pkpt`;
CREATE TABLE `header_pkpt`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomor_pkpt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `getClientOriginalName` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of header_pkpt
-- ----------------------------
INSERT INTO `header_pkpt` VALUES (1, 'PKPT01', NULL, NULL);
INSERT INTO `header_pkpt` VALUES (2, 'PKPT02', NULL, NULL);
INSERT INTO `header_pkpt` VALUES (3, 'PKPT03', NULL, NULL);
INSERT INTO `header_pkpt` VALUES (4, 'PKPT04', '10695228061. Perhit Beban Kerja ada Non PKPT.xlsx', '1. Perhit Beban Kerja ada Non PKPT.xlsx');
INSERT INTO `header_pkpt` VALUES (5, 'PKPT05', '936258045pkpt.xlsx', 'pkpt.xlsx');
INSERT INTO `header_pkpt` VALUES (6, 'PKPT06', '685948262pkpt1.xlsx', 'pkpt1.xlsx');
INSERT INTO `header_pkpt` VALUES (7, 'PKPT07', '561802889Book1.xlsx', 'Book1.xlsx');
INSERT INTO `header_pkpt` VALUES (8, 'PKPT08', '1609138707Book2.xlsx', 'Book2.xlsx');
INSERT INTO `header_pkpt` VALUES (9, 'PKPT09', '1829879228Book3.xlsx', 'Book3.xlsx');

-- ----------------------------
-- Table structure for kebutuhan_hp
-- ----------------------------
DROP TABLE IF EXISTS `kebutuhan_hp`;
CREATE TABLE `kebutuhan_hp`  (
  `id_kh` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `jumlah` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_kh`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kebutuhan_hp
-- ----------------------------

-- ----------------------------
-- Table structure for kertas_kerja
-- ----------------------------
DROP TABLE IF EXISTS `kertas_kerja`;
CREATE TABLE `kertas_kerja`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pkpt` int NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `status` int NULL DEFAULT NULL,
  `ext` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `pesan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kertas_kerja
-- ----------------------------
INSERT INTO `kertas_kerja` VALUES (1, 1, '20230118112232.pdf', 1, 'pdf', 'oke');
INSERT INTO `kertas_kerja` VALUES (2, 3, '20230118113118.pdf', 2, 'pdf', 'ok');
INSERT INTO `kertas_kerja` VALUES (3, 2, '20230118134147.pdf', 2, 'pdf', 'ok');

-- ----------------------------
-- Table structure for lhp
-- ----------------------------
DROP TABLE IF EXISTS `lhp`;
CREATE TABLE `lhp`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_program_kerja` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `uraian_temuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `uraian_penyebab` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `uraian_rekomendasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `file_lhp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lhp
-- ----------------------------
INSERT INTO `lhp` VALUES (1, '38', 'Test', 'test', 'test', NULL, NULL);
INSERT INTO `lhp` VALUES (2, '33', 'oke', 'oke', 'oke', '1', NULL);
INSERT INTO `lhp` VALUES (3, '33', 'ya', 'ya', 'tidak', '1', NULL);
INSERT INTO `lhp` VALUES (4, '37', 'oke', 'baik', 'ok', '1', NULL);
INSERT INTO `lhp` VALUES (5, '30', '1.2', '1.2', '1.2', '1', NULL);
INSERT INTO `lhp` VALUES (6, '30', '1.2', '1.2', '1.3', '1', NULL);
INSERT INTO `lhp` VALUES (7, '1', 'uraina', 'aaaa', 'ssssss', '1', '1674706999.pdf');
INSERT INTO `lhp` VALUES (8, '1', 'ffff', 'fffff', 'fffff', '1', '1674707026.pdf');
INSERT INTO `lhp` VALUES (9, '1', 'ok', 'ok', 'ok', '1', '1674707142.pdf');
INSERT INTO `lhp` VALUES (10, '1', 'ok', 'ok', 'ok', '1', '1674707184.pdf');
INSERT INTO `lhp` VALUES (11, NULL, NULL, NULL, 'ddddddd', NULL, NULL);
INSERT INTO `lhp` VALUES (12, '7', 'uraina', 'aaaa', 'ok', '1', NULL);

-- ----------------------------
-- Table structure for lhp_doc
-- ----------------------------
DROP TABLE IF EXISTS `lhp_doc`;
CREATE TABLE `lhp_doc`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pkpt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lhp_doc
-- ----------------------------

-- ----------------------------
-- Table structure for m_bulan
-- ----------------------------
DROP TABLE IF EXISTS `m_bulan`;
CREATE TABLE `m_bulan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `no` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bulan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_bulan
-- ----------------------------
INSERT INTO `m_bulan` VALUES (1, '01', 'Januari');
INSERT INTO `m_bulan` VALUES (2, '02', 'Februari');
INSERT INTO `m_bulan` VALUES (3, '03', 'Maret');
INSERT INTO `m_bulan` VALUES (4, '04', 'April');
INSERT INTO `m_bulan` VALUES (5, '05', 'Mei');
INSERT INTO `m_bulan` VALUES (6, '06', 'Juni');
INSERT INTO `m_bulan` VALUES (7, '07', 'Juli');
INSERT INTO `m_bulan` VALUES (8, '08', 'Agustus');
INSERT INTO `m_bulan` VALUES (9, '09', 'September');
INSERT INTO `m_bulan` VALUES (10, '10', 'Oktober');
INSERT INTO `m_bulan` VALUES (11, '11', 'November');
INSERT INTO `m_bulan` VALUES (12, '12', 'Desember');

-- ----------------------------
-- Table structure for m_button
-- ----------------------------
DROP TABLE IF EXISTS `m_button`;
CREATE TABLE `m_button`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `button` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `role_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_button
-- ----------------------------
INSERT INTO `m_button` VALUES (1, '\'<span class=\"btn btn-ghost-warning waves-effect waves-light btn-sm\" onclick=\"edit(\' . $row[\'id\'] . \')\">Edit</span>\r\n                    <span class=\"btn btn-ghost-danger waves-effect waves-light btn-sm\"  onclick=\"hapus(\' . $row[\'id\'] . \')\">Delete</span>\'', 2);
INSERT INTO `m_button` VALUES (2, '\'<span class=\"btn btn-ghost-success waves-effect waves-light btn-sm\" onclick=\"approved(\' . $row[\'id\'] . \')\">Approved</span>\r\n                    <span class=\"btn btn-ghost-danger waves-effect waves-light btn-sm\"  onclick=\"refused(\' . $row[\'id\'] . \')\">Refused</span>\'', 3);
INSERT INTO `m_button` VALUES (3, '\'<span class=\"btn btn-ghost-success waves-effect waves-light btn-sm\" onclick=\"approved(\' . $row[\'id\'] . \')\">Approved</span>\r\n                    <span class=\"btn btn-ghost-danger waves-effect waves-light btn-sm\"  onclick=\"refused(\' . $row[\'id\'] . \')\">Refused</span>\'', 4);
INSERT INTO `m_button` VALUES (4, '\'<span class=\"btn btn-ghost-success waves-effect waves-light btn-sm\" onclick=\"approved(\' . $row[\'id\'] . \')\">Approved</span>\r\n                    <span class=\"btn btn-ghost-danger waves-effect waves-light btn-sm\"  onclick=\"refused(\' . $row[\'id\'] . \')\">Refused</span>\'', 5);
INSERT INTO `m_button` VALUES (5, '\'<span class=\"btn btn-ghost-success waves-effect waves-light btn-sm\" onclick=\"approved(\' . $row[\'id\'] . \')\">Approved</span>\r\n                    <span class=\"btn btn-ghost-danger waves-effect waves-light btn-sm\"  onclick=\"refused(\' . $row[\'id\'] . \')\">Refused</span>\'', 6);

-- ----------------------------
-- Table structure for m_jenis_pengawasan
-- ----------------------------
DROP TABLE IF EXISTS `m_jenis_pengawasan`;
CREATE TABLE `m_jenis_pengawasan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `jenis` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `aktif` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_jenis_pengawasan
-- ----------------------------
INSERT INTO `m_jenis_pengawasan` VALUES (1, 'Peer Reviu', 1);
INSERT INTO `m_jenis_pengawasan` VALUES (2, 'Monitoring', 1);
INSERT INTO `m_jenis_pengawasan` VALUES (3, 'Audit', 1);
INSERT INTO `m_jenis_pengawasan` VALUES (4, 'Audit Vaksinasi', 0);
INSERT INTO `m_jenis_pengawasan` VALUES (5, 'Test', 0);
INSERT INTO `m_jenis_pengawasan` VALUES (6, 'Test', 0);
INSERT INTO `m_jenis_pengawasan` VALUES (7, 'Konstruksi', 0);

-- ----------------------------
-- Table structure for m_opd
-- ----------------------------
DROP TABLE IF EXISTS `m_opd`;
CREATE TABLE `m_opd`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `aktif` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_opd
-- ----------------------------
INSERT INTO `m_opd` VALUES (1, 'Inspektorat', 1);
INSERT INTO `m_opd` VALUES (2, 'BPRS', 1);
INSERT INTO `m_opd` VALUES (3, 'PDAM', 1);
INSERT INTO `m_opd` VALUES (4, 'Dinkes', 1);
INSERT INTO `m_opd` VALUES (5, 'Fasyankes', 1);
INSERT INTO `m_opd` VALUES (6, 'test', 0);
INSERT INTO `m_opd` VALUES (7, 'test', 0);
INSERT INTO `m_opd` VALUES (8, 'Riski Ramadhan', 0);

-- ----------------------------
-- Table structure for m_role
-- ----------------------------
DROP TABLE IF EXISTS `m_role`;
CREATE TABLE `m_role`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `aktif` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `sts` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_role
-- ----------------------------
INSERT INTO `m_role` VALUES (1, 'Super Admin', '1', 0);
INSERT INTO `m_role` VALUES (2, 'Inspektur', '1', 0);
INSERT INTO `m_role` VALUES (3, 'Sekretariat', '1', 0);
INSERT INTO `m_role` VALUES (4, 'Ketua Team I', '1', 1);
INSERT INTO `m_role` VALUES (5, 'Ketua Team II', '1', 2);
INSERT INTO `m_role` VALUES (6, 'Ketua Team III', '1', 3);
INSERT INTO `m_role` VALUES (7, 'Ketua Team IV', '1', 4);
INSERT INTO `m_role` VALUES (8, 'Dalnis I', '1', 1);
INSERT INTO `m_role` VALUES (9, 'Dalnis II', '1', 2);
INSERT INTO `m_role` VALUES (10, 'Dalnis III', '1', 3);
INSERT INTO `m_role` VALUES (11, 'Dalnis IV', '1', 4);
INSERT INTO `m_role` VALUES (12, 'Irban I', '1', 1);
INSERT INTO `m_role` VALUES (13, 'Irban II', '1', 2);
INSERT INTO `m_role` VALUES (14, 'Irban III', '1', 3);
INSERT INTO `m_role` VALUES (15, 'Irban IV', '1', 4);

-- ----------------------------
-- Table structure for m_status
-- ----------------------------
DROP TABLE IF EXISTS `m_status`;
CREATE TABLE `m_status`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `sts_keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_status
-- ----------------------------
INSERT INTO `m_status` VALUES (1, 'Pending', 'text-danger', 'Menunggu Persetujuan Ketua Team');
INSERT INTO `m_status` VALUES (2, 'Approve Ketua Team', 'text-warning', 'Menunggu Persetujuan dalnis');
INSERT INTO `m_status` VALUES (3, 'Approve Dalnis', 'text-info', 'Menunggu Persetujuan Irban');
INSERT INTO `m_status` VALUES (4, 'Approve Irban', 'text-secondary', 'Menunggu Persetujuan Sekretariat');
INSERT INTO `m_status` VALUES (5, 'Approve Sekretaris', 'text-success', 'Menunggu Persetujuan Inspektur');
INSERT INTO `m_status` VALUES (6, 'Approve Inspektur', 'test-primary', 'Selesai');

-- ----------------------------
-- Table structure for m_status_lhp
-- ----------------------------
DROP TABLE IF EXISTS `m_status_lhp`;
CREATE TABLE `m_status_lhp`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `ip_address` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `useragent` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `kode`(`kode`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_status_lhp
-- ----------------------------
INSERT INTO `m_status_lhp` VALUES (1, 'BT', 'Belum Ditindaklanjuti', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `m_status_lhp` VALUES (2, 'TT', 'Tidak Dapat Ditindaklanjuti', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `m_status_lhp` VALUES (3, 'S', 'Sesuai', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `m_status_lhp` VALUES (4, 'BS', 'Belum Sesuai', NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for m_tahun
-- ----------------------------
DROP TABLE IF EXISTS `m_tahun`;
CREATE TABLE `m_tahun`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tahun` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of m_tahun
-- ----------------------------
INSERT INTO `m_tahun` VALUES (1, '2022');
INSERT INTO `m_tahun` VALUES (2, '2023');
INSERT INTO `m_tahun` VALUES (3, '2024');
INSERT INTO `m_tahun` VALUES (4, '2025');
INSERT INTO `m_tahun` VALUES (5, '2026');
INSERT INTO `m_tahun` VALUES (6, '2027');
INSERT INTO `m_tahun` VALUES (7, '2028');
INSERT INTO `m_tahun` VALUES (8, '2029');
INSERT INTO `m_tahun` VALUES (9, '2030');

-- ----------------------------
-- Table structure for m_tingkat_resiko
-- ----------------------------
DROP TABLE IF EXISTS `m_tingkat_resiko`;
CREATE TABLE `m_tingkat_resiko`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_tingkat_resiko
-- ----------------------------
INSERT INTO `m_tingkat_resiko` VALUES (1, 'Tinggi');
INSERT INTO `m_tingkat_resiko` VALUES (2, 'Sedang');
INSERT INTO `m_tingkat_resiko` VALUES (3, 'Rendah');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for pkpt
-- ----------------------------
DROP TABLE IF EXISTS `pkpt`;
CREATE TABLE `pkpt`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `jenis` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `area_pengawasan` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `jenis_pengawasan` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `opd` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `rmp` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `rpl` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `sarana_prasarana` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `tingkat_resiko` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `tujuan` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `koorwas` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `pt` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `kt` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `at` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `jumlah` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `jumlah_laporan` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `tahun` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 72 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pkpt
-- ----------------------------
INSERT INTO `pkpt` VALUES (1, 'PKPT01', 'Melaksanakan Peny Stok Opname Vaksin Covid-19 \nPer 31 Desember 2021', 'Audit Stock Vaksin C0vid-19', 'Dinkes dan Fasyankes', 'Januari', 'Januari', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memberikan keyakinan bahwa pelaksanaan Opname vaksin Covid-19 sesuai ketentuan', '1.25', '1', '3', '6', '11.25', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (2, 'PKPT01', 'Melaksanakan Reviu Laporan Keuangan Pemerintah Daerah (LKPD) TA.2021', 'Reviu', 'BPKAD', 'Februari', 'Maret', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memberikan keyakinan yang memadai laporan keuangan sesuai dengan Prosedur dan SPI', '2.5', '3.3333333333333', '10', '10', '25.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (3, 'PKPT01', 'Melaksanakan Evaluasi atas Penyerapan Anggaran dan Pengadaan Barang dan Jasa Triwulan 2 Tahun .2022 ', 'Reviu', 'Barjas', 'Mei', 'Mei', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memperoleh gambaran\npostur APBD, realisasi\npendapatan dan\npenyerapan anggaranl\n', '2.5', '3.3333333333333', '10', '40', '55.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (4, 'PKPT01', 'Melaksanakan Evaluasi atas Penyerapan Anggaran dan Pengadaan Barang dan Jasa Triwulan 4 Tahun .2022 ', 'Reviu', 'Barjas', 'Nopember', 'Nopember', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memperoleh gambaran\npostur APBD, realisasi\npendapatan dan\npenyerapan anggaranl\n', '2.5', '3.3333333333333', '10', '40', '55.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (5, 'PKPT01', 'Melaksanakan Rapat Monitoring evaluasi Tindak Lanjut Internal dan Eksternal', 'Monitoring', 'BPKAD, Dishub, Dinsos', 'Juli', 'Juli', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan pelaksanaan TL hasil pengawasan', '0.75', '1', '3', '24', '28.75', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (6, 'PKPT01', 'Melaksanakan Monitoring Administrasi Tindak Lanjut Laporan Hasil Pemeriksaan  APIP dan BPK Perwakilan Provinsi banten', 'Monitoring', 'BPKAD, Dishub, Dinsos', 'Juli', 'Juli', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan melalui pembandingan atas capaian kinerja sesuai yg diperjanjikan', '1.25', '1.6666666666667', '5', '20', '27.916666666667', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (7, 'PKPT01', 'Melaksanakan Monitoring Pengelolaan Vaksin Covid-19  rusak dan/ kadaluarsa Tahun 2022', 'Monitoring', 'Dinkes Fasyankes', 'September', 'September', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan pelaksanaan Pengelolaan Vaksin Covid-19  rusak/ kadaluarsa', '1.25', '1.6666666666667', '5', '15', '22.916666666667', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (8, 'PKPT01', 'Melaksanakan Probity audit atas paket pekerjaan pengadaan dan Pemasangan lampu field of play (FOP) Stadio Geger Cilegon', 'Probity', 'Dispora', 'September', 'Desember', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan pelaksanaan kegiatan sesuai ketentuan', '5', '6.6666666666667', '20', '160', '191.66666666667', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (9, 'PKPT01', 'Melaksanakan Evaluasi LKj OPD TA 2021 TESTING', 'Evaluasi', 'OPD', 'Maret', 'Matret', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan LAKIP OPD Sesuai ketentuan', '2.5', '3.3333333333333', '10', '80', '95.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (29, 'PKPT01', 'pppp', 'Evaluasi', 'OPD', 'Maret', 'Matret', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan LAKIP OPD Sesuai ketentuan', '2.5', '3.3333333333333', '10', '80', '95.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (30, 'PKPT02', 'Melaksanakan Peny Stok Opname Vaksin Covid-19 \nPer 31 Desember 2021', 'Audit Stock Vaksin C0vid-19', 'Dinkes dan Fasyankes', 'Januari', 'Januari', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memberikan keyakinan bahwa pelaksanaan Opname vaksin Covid-19 sesuai ketentuan', '1.25', '1', '3', '6', '11.25', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (31, 'PKPT02', 'Melaksanakan Reviu Laporan Keuangan Pemerintah Daerah (LKPD) TA.2021', 'Reviu', 'BPKAD', 'Februari', 'Maret', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memberikan keyakinan yang memadai laporan keuangan sesuai dengan Prosedur dan SPI', '2.5', '3.3333333333333', '10', '10', '25.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (32, 'PKPT02', 'Melaksanakan Evaluasi atas Penyerapan Anggaran dan Pengadaan Barang dan Jasa Triwulan 2 Tahun .2022 ', 'Reviu', 'Barjas', 'Mei', 'Mei', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memperoleh gambaran\npostur APBD, realisasi\npendapatan dan\npenyerapan anggaranl\n', '2.5', '3.3333333333333', '10', '40', '55.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (33, 'PKPT02', 'Melaksanakan Evaluasi atas Penyerapan Anggaran dan Pengadaan Barang dan Jasa Triwulan 4 Tahun .2022 ', 'Reviu', 'Barjas', 'Nopember', 'Nopember', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memperoleh gambaran\npostur APBD, realisasi\npendapatan dan\npenyerapan anggaranl\n', '2.5', '3.3333333333333', '10', '40', '55.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (34, 'PKPT02', 'Melaksanakan Rapat Monitoring evaluasi Tindak Lanjut Internal dan Eksternal', 'Monitoring', 'BPKAD, Dishub, Dinsos', 'Juli', 'Juli', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan pelaksanaan TL hasil pengawasan', '0.75', '1', '3', '24', '28.75', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (35, 'PKPT03', 'Melaksanakan Peny Stok Opname Vaksin Covid-19 \nPer 31 Desember 2021', 'Audit Stock Vaksin C0vid-19', 'Dinkes dan Fasyankes', 'Januari', 'Januari', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memberikan keyakinan bahwa pelaksanaan Opname vaksin Covid-19 sesuai ketentuan', '1.25', '1', '3', '6', '11.25', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (36, 'PKPT03', 'Melaksanakan Reviu Laporan Keuangan Pemerintah Daerah (LKPD) TA.2021', 'Reviu', 'BPKAD', 'Februari', 'Maret', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memberikan keyakinan yang memadai laporan keuangan sesuai dengan Prosedur dan SPI', '2.5', '3.3333333333333', '10', '10', '25.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (37, 'PKPT03', 'Melaksanakan Evaluasi atas Penyerapan Anggaran dan Pengadaan Barang dan Jasa Triwulan 2 Tahun .2022 ', 'Reviu', 'Barjas', 'Mei', 'Mei', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memperoleh gambaran\npostur APBD, realisasi\npendapatan dan\npenyerapan anggaranl\n', '2.5', '3.3333333333333', '10', '40', '55.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (38, 'PKPT03', 'Melaksanakan Evaluasi atas Penyerapan Anggaran dan Pengadaan Barang dan Jasa Triwulan 4 Tahun .2022 ', 'Reviu', 'Barjas', 'Nopember', 'Nopember', 'Laptop, ATK', 'Tinggi', 'Koorwas Irban II', 'Memperoleh gambaran\npostur APBD, realisasi\npendapatan dan\npenyerapan anggaranl\n', '2.5', '3.3333333333333', '10', '40', '55.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (39, 'PKPT03', 'Melaksanakan Rapat Monitoring evaluasi Tindak Lanjut Internal dan Eksternal', 'Monitoring', 'BPKAD, Dishub, Dinsos', 'Juli', 'Juli', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan pelaksanaan TL hasil pengawasan', '0.75', '1', '3', '24', '28.75', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (45, 'PKPT05', 'Melaksanakan Rapat Monitoring evaluasi Tindak Lanjut Internal dan Eksternal', 'Monitoring', 'BPKAD, Dishub, Dinsos', 'Juli', 'Juli', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan pelaksanaan TL hasil pengawasan', '0.75', '1', '3', '24', '28.75', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (46, 'PKPT05', 'Melaksanakan Monitoring Administrasi Tindak Lanjut Laporan Hasil Pemeriksaan  APIP dan BPK Perwakilan Provinsi banten', 'Monitoring', 'BPKAD, Dishub, Dinsos', 'Juli', 'Juli', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan melalui pembandingan atas capaian kinerja sesuai yg diperjanjikan', '1.25', '1.6666666666667', '5', '20', '27.916666666667', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (47, 'PKPT05', 'Melaksanakan Monitoring Pengelolaan Vaksin Covid-19  rusak dan/ kadaluarsa Tahun 2022', 'Monitoring', 'Dinkes Fasyankes', 'September', 'September', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan pelaksanaan Pengelolaan Vaksin Covid-19  rusak/ kadaluarsa', '1.25', '1.6666666666667', '5', '15', '22.916666666667', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (48, 'PKPT05', 'Melaksanakan Probity audit atas paket pekerjaan pengadaan dan Pemasangan lampu field of play (FOP) Stadio Geger Cilegon', 'Probity', 'Dispora', 'September', 'Desember', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan pelaksanaan kegiatan sesuai ketentuan', '5', '6.6666666666667', '20', '160', '191.66666666667', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (49, 'PKPT05', 'Melaksanakan Evaluasi LKj OPD TA 2021', 'Evaluasi', 'OPD', 'Maret', 'Matret', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan LAKIP OPD Sesuai ketentuan', '2.5', '3.3333333333333', '10', '80', '95.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (50, 'PKPT06', 'Melaksanakan Rapat Monitoring evaluasi Tindak Lanjut Internal dan Eksternal', 'Monitoring', 'BPKAD, Dishub, Dinsos', 'Juli', 'Juli', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan pelaksanaan TL hasil pengawasan', '0.75', '1', '3', '24', '28.75', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (51, 'PKPT06', 'Melaksanakan Monitoring Administrasi Tindak Lanjut Laporan Hasil Pemeriksaan  APIP dan BPK Perwakilan Provinsi banten', 'Monitoring', 'BPKAD, Dishub, Dinsos', 'Juli', 'Juli', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan melalui pembandingan atas capaian kinerja sesuai yg diperjanjikan', '1.25', '1.6666666666667', '5', '20', '27.916666666667', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (52, 'PKPT06', 'Melaksanakan Monitoring Pengelolaan Vaksin Covid-19  rusak dan/ kadaluarsa Tahun 2022', 'Monitoring', 'Dinkes Fasyankes', 'September', 'September', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan pelaksanaan Pengelolaan Vaksin Covid-19  rusak/ kadaluarsa', '1.25', '1.6666666666667', '5', '15', '22.916666666667', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (53, 'PKPT06', 'Melaksanakan Probity audit atas paket pekerjaan pengadaan dan Pemasangan lampu field of play (FOP) Stadio Geger Cilegon', 'Probity', 'Dispora', 'September', 'Desember', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan pelaksanaan kegiatan sesuai ketentuan', '5', '6.6666666666667', '20', '160', '191.66666666667', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (54, 'PKPT06', 'Melaksanakan Evaluasi LKj OPD TA 2021', 'Evaluasi', 'OPD', 'Maret', 'Matret', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan LAKIP OPD Sesuai ketentuan', '2.5', '3.3333333333333', '10', '80', '95.833333333333', '1', '2022', 'Laporan');
INSERT INTO `pkpt` VALUES (55, 'PKPT07', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis I)', 'Audit  Vaksinasi', 'Fasyankes', '1 Okt', '14 Okt', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis I)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (56, 'PKPT07', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis 2)', 'Audit  Vaksinasi', 'Fasyankes', '21 Okt', '3 Nop', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis 2)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (57, 'PKPT07', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis I)', 'Audit  Vaksinasi', 'Fasyankes', '15 Nop', '26 Nop', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis I)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (58, 'PKPT07', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis 2)', 'Audit  Vaksinasi', 'Fasyankes', '29 Nop', '9 Des', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis 2)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (59, 'PKPT08', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis I)', 'Audit  Vaksinasi', 'Fasyankes', '1 Okt', '14 Okt', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis I)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (60, 'PKPT08', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis 2)', 'Audit  Vaksinasi', 'Fasyankes', '21 Okt', '3 Nop', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis 2)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (61, 'PKPT08', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis I)', 'Audit  Vaksinasi', 'Fasyankes', '15 Nop', '26 Nop', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis I)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (62, 'PKPT08', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis 2)', 'Audit  Vaksinasi', 'Fasyankes', '29 Nop', '9 Des', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis 2)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (63, 'PKPT09', 'Melaksanakan Melaksanakan Peer Reviu APIP Inspektorat Kota Cilegon Tahun 2021', 'Peer reviu', 'Inspektorat', 'Oktober', 'Oktober', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Evaluasi Internal', '1', '1', '3', '6', '11', '1', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (64, 'PKPT09', 'Pengawasan Tata Kelola BUMD (BPRS)', 'Monitoring', 'BPRS', 'Juni', 'Juni', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan Tata kelola BUMD (BPRS) telah dilakukan dengan memadai', '1.25', '1.6666666666667', '10', '30', '42.916666666667', '1', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (65, 'PKPT09', 'Pengawasan Tata Kelola BUMD (PDAM)', 'Monitoring', 'PDAM', 'Juni', 'Juni', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan Tata kelola BUMD (PDAM) telah dilakukan dengan memadai', '1.25', '1.6666666666667', '10', '30', '42.916666666667', '1', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (66, 'PKPT09', '\nAudit  Pelaksanaan Distribusi dan Pengelolaan Persediaan Vaksin Covid-19', 'Audit', 'Dinkes', 'September', 'September', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Memberikan keyakinan melalui pembandingan atas capaian kinerja sesuai yg diperjanjikan', '3.75', '5', '30', '90', '128.75', '1', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (67, 'PKPT09', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis I)', 'Audit  Vaksinasi', 'Fasyankes', '1 Okt', '14 Okt', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis I)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (68, 'PKPT09', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis 2)', 'Audit  Vaksinasi', 'Fasyankes', '21 Okt', '3 Nop', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 3 (Dosis 2)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (69, 'PKPT09', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis I)', 'Audit  Vaksinasi', 'Fasyankes', '15 Nop', '26 Nop', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis I)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (70, 'PKPT09', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis 2)', 'Audit  Vaksinasi', 'Fasyankes', '29 Nop', '9 Des', 'Laptop, ATK', 'Tinggi', 'Irban II', 'Pelaksanaan Vaksinasi Tahap 4 (Dosis 2)', '3', '9.3333333333333', '14', '42', '68.333333333333', '2', '2023', 'Laporan');
INSERT INTO `pkpt` VALUES (71, 'PKPT09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '556.25', NULL, '2023', NULL);

-- ----------------------------
-- Table structure for program_kerja
-- ----------------------------
DROP TABLE IF EXISTS `program_kerja`;
CREATE TABLE `program_kerja`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pkpt` int NULL DEFAULT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `pkp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `nota_dinas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `status` int NULL DEFAULT NULL,
  `pesan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `status_lhp` int NULL DEFAULT NULL,
  `no_sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `file_sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `pesan_lhp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `status_tindak_lanjut` int NULL DEFAULT NULL,
  `pesan_tindak_lanjut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `role_id` int NULL DEFAULT NULL,
  `grouping` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of program_kerja
-- ----------------------------
INSERT INTO `program_kerja` VALUES (1, 63, 'PKPT09', 'PKP20230126093114.pdf', 'NotaDinas20230126093114.pdf', 3, 'ok', 2, '12321', '2023-01-26', 'SP20230126095203.pdf', 'oke', NULL, NULL, 17, 1);

-- ----------------------------
-- Table structure for riwayat_approve
-- ----------------------------
DROP TABLE IF EXISTS `riwayat_approve`;
CREATE TABLE `riwayat_approve`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `program_kerja_id` int NULL DEFAULT NULL,
  `role_id` int NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `tanggal` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of riwayat_approve
-- ----------------------------

-- ----------------------------
-- Table structure for surat_perintah
-- ----------------------------
DROP TABLE IF EXISTS `surat_perintah`;
CREATE TABLE `surat_perintah`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_program_kerja` int NULL DEFAULT NULL,
  `id_pkpt` int NULL DEFAULT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `pkp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `nota_dinas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of surat_perintah
-- ----------------------------
INSERT INTO `surat_perintah` VALUES (1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `surat_perintah` VALUES (2, 4, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tindak_lanjut
-- ----------------------------
DROP TABLE IF EXISTS `tindak_lanjut`;
CREATE TABLE `tindak_lanjut`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_program_kerja` int NULL DEFAULT NULL,
  `uraian_tindak_lanjut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tindak_lanjut
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `role_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (4, 'Bagus Sanjaya Pratama', 'bagus@gmail.com', 'admin', '$2y$10$UEykamBaUB7K9E5TnXnW/.ZrWZT0a/duqnwZ/Uk285aJHwvObKdT2', NULL, '2022-11-26 20:51:00', '2023-01-24 20:23:32', 1);
INSERT INTO `users` VALUES (5, 'Galang', 'galang@gmail.com', 'Inspektur', '$2y$10$QjIP199U/MB/x1PgNkOvOeWrKwMZTR0AqdMpALhE1ASOqsnEHCQzS', NULL, '2022-11-28 10:14:53', '2023-01-24 20:23:17', 2);
INSERT INTO `users` VALUES (8, 'Nanang', 'nanang@gmail.com', 'sekretariat', '$2y$10$L/bpnEC3G.ptpONMeLa2KOOMWFOFaM590eHE9FTJfxn1QftXCbR6y', NULL, '2022-12-09 22:07:13', '2023-01-24 20:22:56', 3);
INSERT INTO `users` VALUES (9, 'Nugroho', 'coba@gmail.com', 'ketua team 1', '$2y$10$HBBGtoWn3w0XtH.4sTjHCeiaUUwXAdhNVjeUneio9dIxaQ7doqV/m', NULL, '2022-12-10 12:19:44', '2023-01-24 20:22:42', 4);
INSERT INTO `users` VALUES (10, 'Ketua Team II', 'ketuateam@gmail.com', 'ketua team 2', '$2y$10$rt0V.D0TvYc7qnXZRHB4.OaadKLrI7hogSMOjWHt6CjhsGQtlc.Ra', NULL, '2022-12-13 13:42:00', '2023-01-24 20:22:26', 5);
INSERT INTO `users` VALUES (11, 'Ketua Team III', 'sekretariat@gmail.com', 'ketua team 3', '$2y$10$xxaNgWTRbnLtZ//ttQKHNOcWAezI12/TUS7uSuzy0JAXMqIORDIsO', NULL, '2022-12-13 13:42:31', '2023-01-24 20:22:10', 6);
INSERT INTO `users` VALUES (12, 'Ketua Team IV', 'nu@gmail.com', 'ketua team 4', '$2y$10$HzXFuc8mHkKunIAYhs5u1eg93E0UmKDCsoXy9oiTgj6LPU1KjAiWW', NULL, '2023-01-13 14:57:08', '2023-01-24 20:21:49', 7);
INSERT INTO `users` VALUES (13, 'Dalnis I', 'dalnis1@gmail.com', 'dalnis 1', '$2y$10$LnEqpickGXPQuiQdX.TvJ.PcaJl.ze8t7yzEG0MZXcG66qHEpHfei', NULL, '2023-01-24 20:20:23', '2023-01-24 20:20:23', 8);
INSERT INTO `users` VALUES (14, 'Dalnis II', 'dalnis2@gmail.com', 'dalnis 2', '$2y$10$FHTutHA2vcwOnBOxNCoqFuVDmw0tY0ZHeWNbUeekYfkn02a7zMgaK', NULL, '2023-01-24 20:21:10', '2023-01-24 20:21:10', 9);
INSERT INTO `users` VALUES (15, 'Dalnis III', 'dalnis3@gmail.com', 'dalnis 3', '$2y$10$KQpd/qPnIPjv2uCX3HMZEOucD0PvV91gPCJxNaa3v2cDz9HI1kwIu', NULL, '2023-01-24 21:56:25', '2023-01-24 21:56:47', 10);
INSERT INTO `users` VALUES (16, 'Dalnis IV', 'dalnis4@gmail.com', 'dalnis 4', '$2y$10$yT1k2/HVtomxcUrZUsWJbe7V0RcnU6neSf35b0Pn4QBm4Cc04FT7m', NULL, '2023-01-24 21:57:32', '2023-01-24 21:57:32', 11);
INSERT INTO `users` VALUES (17, 'Irban I', 'irban1@gmail.com', 'irban 1', '$2y$10$WcEwgjexFKqgESddGFan.u1BVwx9UP8Lc1xe9xPKLB5X7T8YFF3B2', NULL, '2023-01-24 21:58:13', '2023-01-24 21:58:13', 12);
INSERT INTO `users` VALUES (18, 'Irban II', 'irban2@gmail.com', 'irban 2', '$2y$10$aVCu3tlCNwQHFvTqmdQiZOCW3BZV.xvQxxCk7uHebs.NzEtU24qNC', NULL, '2023-01-24 21:58:47', '2023-01-24 21:58:47', 13);
INSERT INTO `users` VALUES (19, 'Irban III', 'irban3@gmail.com', 'irban 3', '$2y$10$3imitSEw4fC..1yUNUWbyunkqzxyYM3JgiCxTVypiEdbydJC7ZBxC', NULL, '2023-01-24 21:59:23', '2023-01-24 21:59:23', 14);
INSERT INTO `users` VALUES (20, 'Irban IV', 'irban4@gmail.com', 'irban 4', '$2y$10$1pQxRpIa9xt7OwkIkAhPyuidoEhEkvlIaLT7KW.Ua24KdyewHKikq', NULL, '2023-01-24 22:00:12', '2023-01-24 22:00:12', 15);

-- ----------------------------
-- View structure for view_program_kerja
-- ----------------------------
DROP VIEW IF EXISTS `view_program_kerja`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_program_kerja` AS select `program_kerja`.`id` AS `id`,`program_kerja`.`id_pkpt` AS `id_pkpt`,`program_kerja`.`jenis` AS `jenis`,`program_kerja`.`pkp` AS `pkp`,`program_kerja`.`nota_dinas` AS `nota_dinas`,`program_kerja`.`status` AS `status`,`program_kerja`.`pesan` AS `pesan`,`pkpt`.`area_pengawasan` AS `area_pengawasan` from (`program_kerja` join `pkpt` on((`program_kerja`.`id_pkpt` = `pkpt`.`id`)));

SET FOREIGN_KEY_CHECKS = 1;

-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: mbm
-- ------------------------------------------------------
-- Server version	5.7.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `master_dept`
--

DROP TABLE IF EXISTS `master_dept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_dept` (
  `id_dept` char(6) NOT NULL,
  `nama_dept` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_dept`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_dept`
--

LOCK TABLES `master_dept` WRITE;
/*!40000 ALTER TABLE `master_dept` DISABLE KEYS */;
INSERT INTO `master_dept` VALUES ('000001','Gudang'),('000002','Distribusi'),('000003','Sales'),('000004','GA'),('005','QC');
/*!40000 ALTER TABLE `master_dept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_karyawan`
--

DROP TABLE IF EXISTS `master_karyawan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_karyawan` (
  `id_kyw` char(6) NOT NULL,
  `nama_kyw` char(50) DEFAULT '0',
  `dept_kyw` char(50) DEFAULT '0',
  `nama_akun_bank` char(50) DEFAULT '',
  `no_akun_bank` char(50) DEFAULT '',
  `nama_bank` char(50) DEFAULT '',
  `kode_perk` char(50) DEFAULT '',
  PRIMARY KEY (`id_kyw`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_karyawan`
--

LOCK TABLES `master_karyawan` WRITE;
/*!40000 ALTER TABLE `master_karyawan` DISABLE KEYS */;
INSERT INTO `master_karyawan` VALUES ('000001','Anggy Nida S','','','','','201030401'),('000002','Mahyati','','','','','201030402'),('000003','Novi','','','','','201030403'),('000004','Ibu','','','','','201030404'),('000005','Indah','','','','','201030405');
/*!40000 ALTER TABLE `master_karyawan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_gol_user`
--

DROP TABLE IF EXISTS `sec_gol_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sec_gol_user` (
  `goluser_id` varchar(6) NOT NULL DEFAULT '',
  `goluser_desc` varchar(25) DEFAULT '',
  PRIMARY KEY (`goluser_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_gol_user`
--

LOCK TABLES `sec_gol_user` WRITE;
/*!40000 ALTER TABLE `sec_gol_user` DISABLE KEYS */;
INSERT INTO `sec_gol_user` VALUES ('A','Administrator'),('I','Inputer'),('S','Supervisor'),('V','Viewer');
/*!40000 ALTER TABLE `sec_gol_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_menu`
--

DROP TABLE IF EXISTS `sec_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sec_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_nama` varchar(250) NOT NULL DEFAULT '',
  `menu_uri` varchar(250) NOT NULL DEFAULT '',
  `menu_header` varchar(250) NOT NULL DEFAULT '',
  `menu_allowed` varchar(100) NOT NULL DEFAULT '',
  `menu_seq` int(11) NOT NULL DEFAULT '0',
  `parent` int(11) DEFAULT '0',
  `lvl` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_menu`
--

LOCK TABLES `sec_menu` WRITE;
/*!40000 ALTER TABLE `sec_menu` DISABLE KEYS */;
INSERT INTO `sec_menu` VALUES (1,'Konfigurasi','#','','+2+1',6,0,0),(2,'Group User','admin/sec_group_user/home','Konfigurasi Group User','+2+1',1,1,1),(3,'Group Menu','admin/konfigurasi_menu_status_user/home','Konfigurasi Group Menu','+2+1',2,1,1),(4,'Menu','admin/sec_menu_user/home','Konfigurasi Menu','+2+1',3,1,1),(5,'User','admin/sec_user/home','Konfigurasi User','+2+1',4,1,1),(63,'Karyawan','master_karyawan/home','Master Karyawan','+2+1',8,1,1),(64,'Data master','#','','+4+5+3+2+1+8',7,0,0),(85,'Departement','master_dept/home','Data Master Departement','+2+1',16,1,1),(97,'Laporan','#','','+4+5+6+3+2+1',14,0,0),(126,'Transaksi','#','','+7+4+5+6+3+2+1',8,0,0),(142,'Agen','master/master_agen/home','Data Master Agen','+3+2+1+8',7,64,1),(144,'Laba Rugi','laporan/laporan_laba_rugi/home','Laporan Laba Rugi','+0+4+5+6+2+1',5,97,1),(145,'Utilitas','#','','+2+1',16,0,0),(146,'Backup DB','utility/utility_db/home','Proses Backup DB','+2+1',1,145,1),(147,'Restore DB','utility/restore_db/home','Proses Restore DB','+1',2,145,1),(153,'Supplier','master/master_supplier/home','Data Master Supplier','+3+2+1+8',6,64,1),(155,'Pengeluaran produk','transaksi/trans_keluar/home','Data pengeluaran produk ke customer','',19,126,1),(156,'Pencampuran produk','transaksi/trans_campur/home','Data pencampuran produk','+1',20,126,1),(157,'Posisi Keuangan','laporan/laporan_neraca_c/home','Laporan Posisi Keuangan','+2+1',4,97,1),(158,'Cucian Masuk','transaksi/trans_po/home','Transaksi Penerimaan Cucian','+7+3+2+1',4,126,1),(159,'Biaya Operasional','transaksi/trans_biaya/home','Form Input Biaya Transaksi Operasional','+3+2+1',6,126,1),(160,'Hapus Transaksi','transaksi/hapus_trans/home','Form Hapus Transaksi','+2+1',7,126,1),(161,'Cucian -','transaksi/sales_order/home','Transaksi Penerimaan Cucian','+1',8,126,1),(162,'Packaging Pengiriman','transaksi/packaging/home','Packaging Pengiriman','+1',17,126,1),(163,'Approval Pengiriman','transaksi/trans_app_kirim/home','Approval Pengiriman','+1',18,126,1),(165,'Customer','master/master_cust/home','Data Master Customer','+4+3+2+1+8',7,64,1),(166,'Produk','master/master_produk/home','Data Master Jasa Satuan','+4+5+3+2+1+8',8,64,1),(167,'Perkiraan','master/master_perkiraan/home','Data Master Perkiraan','+2+1+8',9,64,1),(168,'Dashboard','#','','+7+4+5+6+2+1+8+8+9+9',5,0,0),(169,'Stok Akhir','main/index','Dashboard ketersediaan produk','+7+4+5+6+2+1+8+9',6,168,1),(170,'Stok Available','main/avl','Dashboard ketersediaan pengiriman','+7+4+5+6+2+1+8+9',7,168,1),(171,'GA Cukai','transaksi/ganocukai/home','Form Input No Cukai','+4+1',9,126,1),(172,'Batch Input','transaksi/labnobatch/home','Form Input No Batch','+6+1',10,126,1),(173,'Distribusi','transaksi/distribusi/home','Distribusi','+5+1',12,126,1),(181,'Outsource','master/master_outsource/home','Data Master Eksternal','+3+2+1+8',13,64,1),(182,'Integrasi Jurnal','admin/integrasi_jurnal/home','Konfigurasi Integrasi Jurnal','+2+1',18,1,1),(183,'Form Cukai','#','','',13,0,0),(184,'Kedatangan','cukai/trans_masuk/home','Form Kedatangan Barang (Cukai)','',5,183,1),(185,'Pengeluaran produk','cukai/trans_keluar/home','Form Pengeluaran Produk (Cukai)','',6,183,1),(186,'Stok Cukai','main/stokcukai','Dashboard Stok Cukai','+1+8+9',8,168,1),(187,'Keuangan','#','','+2+1',12,0,0),(188,'Koreksi Jurnal','akuntansi/koreksi_jurnal/home','Koreksi Jurnal','+2+1',6,187,1),(189,'Agen','laporan/lap_piutang_agen/home','Laporan Piutang Agen','+4+5+6+3+2+1',8,97,1),(190,'Outsource','laporan/lap_hutang_outsource/home','Laporan Hutang Outsource','+4+5+6+3+2+1',8,97,1),(191,'Jasa Karyawan','laporan/lap_jasa_kyw/home','Laporan Jasa Karyawan','+4+5+3+2+1',9,97,1),(192,'Biaya Transaksi','laporan/lap_biaya_trans/home','Laporan Biaya Transaksi','+2+1',10,97,1),(193,'Kedatangan','laporan/kedatangan/home','Laporan Kedatangan Barang','+1',11,97,1),(194,'Pengambilan','laporan/lap_trans_ambil/home','Laporan Transaksi Pengambilan','+3+2+1',6,97,1),(195,'Mutasi Gudang','transaksi/mutgudang/home','Form Mutasi Gudang','+1',21,126,1),(196,'Adjustment Produk','transaksi/adjustment/home','Adjustment Pengeluaran Barang','+1',22,126,1),(197,'Jurnal','akuntansi/akuntansi/home','Penjurnalan','+2+1',5,187,1),(198,'Jenis Transaksi','admin/jns_trans/home','Form Input Jenis Transaksi','+2',19,1,1),(199,'abc','#','','',19,0,0),(200,'fdsafd','fdsa','fdas','',0,199,1),(201,'ujijuji','fda','fdsa','',0,200,2),(202,'terakhir','fdsa','fdsa','',0,201,2);
/*!40000 ALTER TABLE `sec_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_menu_old`
--

DROP TABLE IF EXISTS `sec_menu_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sec_menu_old` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_nama` varchar(250) NOT NULL DEFAULT '',
  `menu_uri` varchar(250) NOT NULL DEFAULT '',
  `menu_header` varchar(250) NOT NULL DEFAULT '',
  `menu_allowed` varchar(100) NOT NULL DEFAULT '',
  `menu_seq` int(11) NOT NULL DEFAULT '0',
  `parent` int(11) DEFAULT '0',
  `lvl` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_menu_old`
--

LOCK TABLES `sec_menu_old` WRITE;
/*!40000 ALTER TABLE `sec_menu_old` DISABLE KEYS */;
INSERT INTO `sec_menu_old` VALUES (1,'Konfigurasi','#','','+1+2',6,0,0),(2,'Group User','admin/sec_group_user/home','Konfigurasi Group User','+1+2',1,1,0),(3,'Group Menu','admin/konfigurasi_menu_status_user/home','Konfigurasi Group Menu','+1+2',2,1,0),(4,'Menu','admin/sec_menu_user/home','Konfigurasi Menu','+1+2',3,1,0),(5,'User','sec_user/home','Konfigurasi User','+1+2',4,1,0),(63,'Karyawan','master_karyawan/home','Master Karyawan','+1+2',8,1,0),(64,'Data master','#','','+4+5+1+2+3',7,0,0),(85,'Departement','master_dept/home','Data Master Departement','+1+2',16,1,0),(97,'Laporan','#','','+4+5+6+1+2+3',14,0,0),(126,'Transaksi','#','','+7+4+5+6+1+2+3',8,0,0),(142,'Agen','master/master_agen/home','Data Master Agen','+1+2+3',7,64,0),(144,'Laba Rugi','laporan/laporan_laba_rugi/home','Laporan Laba Rugi','0+4+5+6+1+2',5,97,0),(145,'Utilitas','#','','+1+2',16,0,0),(146,'Backup DB','utility/utility_db/home','Proses Backup DB','+1+2',1,145,0),(147,'Restore DB','utility/restore_db/home','Proses Restore DB','+1',2,145,0),(153,'Supplier','master/master_supplier/home','Data Master Supplier','+1+2+3',6,64,0),(155,'Pengeluaran produk','transaksi/trans_keluar/home','Data pengeluaran produk ke customer','',19,126,0),(156,'Pencampuran produk','transaksi/trans_campur/home','Data pencampuran produk','+1',20,126,0),(157,'Posisi Keuangan','laporan/laporan_neraca_c/home','Laporan Posisi Keuangan','+1+2',4,97,0),(158,'Cucian Masuk','transaksi/trans_po/home','Transaksi Penerimaan Cucian','+7+1+2+3',4,126,0),(159,'Biaya Operasional','transaksi/trans_biaya/home','Form Input Biaya Transaksi Operasional','+1+2+3',6,126,0),(160,'Kedatangan tanpa PO','transaksi/trans_masuk_unpo/home','Kedatangan barang tanpa PO','+1',7,126,0),(161,'Cucian -','transaksi/sales_order/home','Transaksi Penerimaan Cucian','+1',8,126,0),(162,'Packaging Pengiriman','transaksi/packaging/home','Packaging Pengiriman','+1',17,126,0),(163,'Approval Pengiriman','transaksi/trans_app_kirim/home','Approval Pengiriman','+1',18,126,0),(165,'Customer','master/master_cust/home','Data Master Customer','+4+1+2+3',7,64,0),(166,'Produk','master/master_produk/home','Data Master Jasa Satuan','+4+5+1+2+3',8,64,0),(167,'Perkiraan','master/master_perkiraan/home','Data Master Perkiraan','+1+2',9,64,0),(168,'Dashboard','#','','+7+4+5+6+1+2',5,0,0),(169,'Stok Akhir','main/index','Dashboard ketersediaan produk','+7+4+5+6+1+2',6,168,0),(170,'Stok Available','main/avl','Dashboard ketersediaan pengiriman','+7+4+5+6+1+2',7,168,0),(171,'GA Cukai','transaksi/ganocukai/home','Form Input No Cukai','+4+1',9,126,0),(172,'Batch Input','transaksi/labnobatch/home','Form Input No Batch','+6+1',10,126,0),(173,'Distribusi','transaksi/distribusi/home','Distribusi','+5+1',12,126,0),(181,'Outsource','master/master_outsource/home','Data Master Eksternal','+1+2+3',13,64,0),(182,'Integrasi Jurnal','admin/integrasi_jurnal/home','Konfigurasi Integrasi Jurnal','+1+2',18,1,0),(183,'Form Cukai','#','','',13,0,0),(184,'Kedatangan','cukai/trans_masuk/home','Form Kedatangan Barang (Cukai)','',5,183,0),(185,'Pengeluaran produk','cukai/trans_keluar/home','Form Pengeluaran Produk (Cukai)','',6,183,0),(186,'Stok Cukai','main/stokcukai','Dashboard Stok Cukai','+1',8,168,0),(187,'Keuangan','#','','+1+2',12,0,0),(188,'Koreksi Jurnal','akuntansi/koreksi_jurnal/home','Koreksi Jurnal','+1+2',6,187,0),(189,'Agen','laporan/lap_piutang_agen/home','Laporan Piutang Agen','+4+5+6+1+2+3',8,97,0),(190,'Outsource','laporan/lap_hutang_outsource/home','Laporan Hutang Outsource','+4+5+6+1+2+3',8,97,0),(191,'Jasa Karyawan','laporan/lap_jasa_kyw/home','Laporan Jasa Karyawan','+4+5+1+2+3',9,97,0),(192,'PO','laporan/po/home','Laporan PO','+1',10,97,0),(193,'Kedatangan','laporan/kedatangan/home','Laporan Kedatangan Barang','+1',11,97,0),(194,'Pengambilan','laporan/lap_trans_ambil/home','Laporan Transaksi Pengambilan','+1+2+3',6,97,0),(195,'Mutasi Gudang','transaksi/mutgudang/home','Form Mutasi Gudang','+1',21,126,0),(196,'Adjustment Produk','transaksi/adjustment/home','Adjustment Pengeluaran Barang','+1',22,126,0),(197,'Jurnal','akuntansi/akuntansi/home','Penjurnalan','+1+2',5,187,0);
/*!40000 ALTER TABLE `sec_menu_old` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_passwd`
--

DROP TABLE IF EXISTS `sec_passwd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sec_passwd` (
  `userid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL DEFAULT '0',
  `id_kyw` char(6) NOT NULL DEFAULT '0',
  `password` char(40) NOT NULL DEFAULT '0',
  `status_password` tinyint(2) DEFAULT '0',
  `tgl_password` date NOT NULL,
  `usergroup` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `USERNAME` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_passwd`
--

LOCK TABLES `sec_passwd` WRITE;
/*!40000 ALTER TABLE `sec_passwd` DISABLE KEYS */;
INSERT INTO `sec_passwd` VALUES (17,'enji','000001','ZW5qaTg4',0,'1970-01-01',2),(40,'melisah','000002','MDYxMjA4',0,'1970-01-01',3),(41,'indri','000003','ZGFuaXN0aGE=',0,'1970-01-01',4),(42,'adi','000004','YWRpMTIz',0,'1970-01-01',5),(43,'quality','000007','cXVhbGl0eTY=',0,'1970-01-01',6),(44,'aji','000006','YWppMTIz',0,'1970-01-01',2),(45,'yeni','000008','eWVuaTEyMw==',0,'1970-01-01',2),(46,'chandra','000009','Y2hhbmRyYTEyMw==',0,'1970-01-01',7),(47,'indah','000005','aW5kYWgxMQ==',0,'1970-01-01',3),(48,'fasfdsa','000004','MTIzNDU2',0,'1970-01-01',8),(49,'fdsafdsa','000003','amlrb2F6',0,'1970-01-01',8),(50,'ibundah','000005','aWJ1bmRhaA==',0,'1970-01-01',8),(51,'fdsa','000004','ZmQ=',0,'2017-09-19',3);
/*!40000 ALTER TABLE `sec_passwd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_status_user`
--

DROP TABLE IF EXISTS `sec_status_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sec_status_user` (
  `statususer_id` tinyint(1) NOT NULL,
  `statususer_desc` char(25) DEFAULT '',
  PRIMARY KEY (`statususer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_status_user`
--

LOCK TABLES `sec_status_user` WRITE;
/*!40000 ALTER TABLE `sec_status_user` DISABLE KEYS */;
INSERT INTO `sec_status_user` VALUES (0,'Aktif'),(1,'Tidak Aktif');
/*!40000 ALTER TABLE `sec_status_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_usergroup`
--

DROP TABLE IF EXISTS `sec_usergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sec_usergroup` (
  `usergroup_id` int(3) NOT NULL DEFAULT '0',
  `usergroup_desc` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`usergroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_usergroup`
--

LOCK TABLES `sec_usergroup` WRITE;
/*!40000 ALTER TABLE `sec_usergroup` DISABLE KEYS */;
INSERT INTO `sec_usergroup` VALUES (1,'Administrator'),(2,'Adm laundry'),(3,'Opr laundry'),(4,'GA'),(5,'Distribusi'),(6,'QC'),(7,'PO Maker'),(8,'User group 3'),(9,'User group 4');
/*!40000 ALTER TABLE `sec_usergroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting_laporan`
--

DROP TABLE IF EXISTS `setting_laporan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting_laporan` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `pt` char(50) DEFAULT '"',
  `kantor` varchar(100) DEFAULT '"',
  `alamat` varchar(200) DEFAULT '"',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_laporan`
--

LOCK TABLES `setting_laporan` WRITE;
/*!40000 ALTER TABLE `setting_laporan` DISABLE KEYS */;
INSERT INTO `setting_laporan` VALUES (1,'MEGA JAYA LAUNDRY','Taman Wisma Asri 2','Jl. Hidrida Raya Blok DD 25 No. 11 - Bekasi Utara');
/*!40000 ALTER TABLE `setting_laporan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utility_db`
--

DROP TABLE IF EXISTS `utility_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utility_db` (
  `id_utility` int(11) NOT NULL AUTO_INCREMENT,
  `nama_file` char(50) NOT NULL DEFAULT '',
  `direktori` text NOT NULL,
  `tgl_backup` date NOT NULL DEFAULT '0000-00-00',
  `time_backup` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`id_utility`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utility_db`
--

LOCK TABLES `utility_db` WRITE;
/*!40000 ALTER TABLE `utility_db` DISABLE KEYS */;
INSERT INTO `utility_db` VALUES (1,'backup-on-2016-06-25-07-03.sql','backup_db/backup-on-2016-06-25-07-03.sql','2016-06-25','07:03:30'),(2,'backup-on-2016-08-10-05-48.sql','backup_db/backup-on-2016-08-10-05-48.sql','2016-08-10','05:48:10'),(3,'backup-on-2016-08-15-11-25.sql','backup_db/backup-on-2016-08-15-11-25.sql','2016-08-15','11:25:41'),(4,'backup-on-2016-08-15-23-16.sql','backup_db/backup-on-2016-08-15-23-16.sql','2016-08-15','23:16:13'),(5,'backup-on-2016-08-21-05-46.sql','backup_db/backup-on-2016-08-21-05-46.sql','2016-08-21','05:46:22'),(6,'backup-on-2016-08-27-16-30.sql','backup_db/backup-on-2016-08-27-16-30.sql','2016-08-27','16:30:16'),(7,'backup-on-2016-09-04-18-58.sql','backup_db/backup-on-2016-09-04-18-58.sql','2016-09-04','18:58:26'),(8,'backup-on-2016-09-05-17-46.sql','backup_db/backup-on-2016-09-05-17-46.sql','2016-09-05','17:46:27'),(9,'backup-on-2016-09-06-09-18.sql','backup_db/backup-on-2016-09-06-09-18.sql','2016-09-06','09:18:42'),(10,'backup-on-2016-09-12-08-56.sql','backup_db/backup-on-2016-09-12-08-56.sql','2016-09-12','08:56:39'),(11,'backup-on-2016-09-13-23-23.sql','backup_db/backup-on-2016-09-13-23-23.sql','2016-09-13','23:23:07'),(12,'backup-on-2016-09-21-11-10.sql','backup_db/backup-on-2016-09-21-11-10.sql','2016-09-21','11:10:26'),(13,'backup-on-2016-09-23-08-37.sql','backup_db/backup-on-2016-09-23-08-37.sql','2016-09-23','08:37:10'),(14,'backup-on-2016-09-23-11-55.sql','backup_db/backup-on-2016-09-23-11-55.sql','2016-09-23','16:55:36'),(15,'backup-on-2016-09-23-11-58.sql','backup_db/backup-on-2016-09-23-11-58.sql','2016-09-23','16:58:52'),(16,'backup-on-2016-09-26-05-31.sql','backup_db/backup-on-2016-09-26-05-31.sql','2016-09-26','10:31:14'),(17,'backup-on-2017-03-23-17-46.sql','backup_db/backup-on-2017-03-23-17-46.sql','2017-03-23','23:46:32'),(18,'backup-on-2017-03-24-04-11.sql','backup_db/backup-on-2017-03-24-04-11.sql','2017-03-24','10:11:13'),(19,'backup-on-2017-04-12-11-39.sql','backup_db/backup-on-2017-04-12-11-39.sql','2017-04-12','16:39:45'),(20,'backup-on-2017-05-15-11-30.sql','backup_db/backup-on-2017-05-15-11-30.sql','2017-04-26','16:30:57'),(21,'backup-on-2017-05-16-21-14.sql','backup_db/backup-on-2017-05-16-21-14.sql','2017-05-16','21:14:33'),(22,'backup-on-2017-06-29-11-17.sql','backup_db/backup-on-2017-06-29-11-17.sql','2017-06-29','11:17:21'),(23,'backup-on-2017-06-29-21-22.sql','backup_db/backup-on-2017-06-29-21-22.sql','2017-06-29','21:22:14'),(24,'backup-on-2017-06-30-08-53.sql','backup_db/backup-on-2017-06-30-08-53.sql','2017-06-30','08:53:15'),(25,'backup-on-2017-07-10-05-22.sql','backup_db/backup-on-2017-07-10-05-22.sql','2017-07-10','10:22:52');
/*!40000 ALTER TABLE `utility_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `web_log`
--

DROP TABLE IF EXISTS `web_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web_log` (
  `id_log` char(20) NOT NULL,
  `waktu` datetime DEFAULT NULL,
  `user_id` char(10) DEFAULT '0',
  `menu_id` bigint(20) DEFAULT '0',
  `action` char(20) DEFAULT '',
  `keterangan` varchar(200) DEFAULT '',
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `web_log`
--

LOCK TABLES `web_log` WRITE;
/*!40000 ALTER TABLE `web_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `web_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `web_sysid`
--

DROP TABLE IF EXISTS `web_sysid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web_sysid` (
  `id_sysid` int(11) NOT NULL AUTO_INCREMENT,
  `keyname` char(80) NOT NULL DEFAULT '',
  `value` char(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_sysid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `web_sysid`
--

LOCK TABLES `web_sysid` WRITE;
/*!40000 ALTER TABLE `web_sysid` DISABLE KEYS */;
INSERT INTO `web_sysid` VALUES (1,'web_copyright_year','2016'),(2,'web_copyright_content','ANG@ Solution'),(3,'web_copyright_auth','ang'),(4,'web_lembaga_nama1','PT. MEGA JAYA'),(5,'web_lembaga_nama2',''),(6,'web_lembaga_nama3',''),(7,'web_aplikasi_nama',''),(8,'web_tanggal_hari_ini','2016-06-02'),(9,'web_proses_denda','2016-05-10'),(10,'web_proses_tunggakan','2016-05-10'),(11,'usergroup_proses21','7');
/*!40000 ALTER TABLE `web_sysid` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-20 10:41:34

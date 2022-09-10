/*
SQLyog Ultimate
MySQL - 10.4.21-MariaDB : Database - db_sim-plut
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_sim-plut` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `db_sim-plut`;

/*Table structure for table `autoinc` */

CREATE TABLE `autoinc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tbl_asset` */

CREATE TABLE `tbl_asset` (
  `kode_asset` char(13) DEFAULT NULL,
  `Tahun` varchar(6) DEFAULT NULL,
  `asset` varchar(255) NOT NULL DEFAULT '0',
  `omzet` varchar(255) NOT NULL DEFAULT '0',
  `tenagaKerja` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tbl_jadwalkegiatan` */

CREATE TABLE `tbl_jadwalkegiatan` (
  `id_jadwalkegiatan` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pgn` char(13) DEFAULT NULL,
  `StatusNotif` int(11) DEFAULT 0,
  `NamaKegiatan` varchar(255) DEFAULT NULL,
  `NamaUMKM` varchar(255) DEFAULT NULL,
  `TanggalJadwal` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_jadwalkegiatan`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tbl_kegiatan` */

CREATE TABLE `tbl_kegiatan` (
  `kode_kegiatan` char(13) NOT NULL,
  `kode_pgn` char(13) NOT NULL,
  `namaUKM` varchar(100) NOT NULL,
  `permasalahan` varchar(255) NOT NULL,
  `programKerja` varchar(255) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `materi` varchar(255) NOT NULL,
  `tindakan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tbl_level` */

CREATE TABLE `tbl_level` (
  `id_lvl` int(11) NOT NULL,
  `satus` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_lvl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tbl_log` */

CREATE TABLE `tbl_log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_log` varchar(255) DEFAULT NULL,
  `kode_pgn` char(13) DEFAULT NULL,
  `aktivitas_log` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tbl_pengguna` */

CREATE TABLE `tbl_pengguna` (
  `id_pgn` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pgn` char(13) NOT NULL,
  `email_pgn` varchar(80) NOT NULL,
  `password_pgn` varchar(18) NOT NULL,
  `is_active` int(1) DEFAULT NULL,
  `lvl_pgn` int(11) DEFAULT NULL,
  `date_created` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pgn`,`email_pgn`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tbl_profil` */

CREATE TABLE `tbl_profil` (
  `kode_pgn` char(13) NOT NULL,
  `nama_dtl` varchar(50) DEFAULT NULL,
  `alamat_dtl` varchar(50) DEFAULT NULL,
  `nohp_dtl` varchar(15) DEFAULT NULL,
  `jabatan_dtl` varchar(255) DEFAULT NULL,
  `foto_dtl` varchar(255) DEFAULT 'default.png',
  PRIMARY KEY (`kode_pgn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tbl_umkm` */

CREATE TABLE `tbl_umkm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(255) DEFAULT NULL,
  `namaUMKM` varchar(100) DEFAULT NULL,
  `namaOwner` varchar(100) DEFAULT NULL,
  `nik` varchar(100) DEFAULT NULL,
  `alamatRumah` varchar(255) DEFAULT NULL,
  `noHP` varchar(25) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `alamatUsaha` varchar(255) DEFAULT NULL,
  `tahunBerdiri` varchar(255) DEFAULT NULL,
  `jenisUsaha` varchar(255) DEFAULT NULL,
  `legalitas` varchar(255) DEFAULT NULL,
  `kode_asset` char(13) DEFAULT NULL,
  `pemodalanMandiri` varchar(100) DEFAULT NULL,
  `pemodalanLuar` varchar(100) DEFAULT NULL,
  `pemasaranOnline` varchar(255) DEFAULT NULL,
  `pemasaranOffline` varchar(255) DEFAULT NULL,
  `mitra` varchar(100) DEFAULT NULL,
  `kegiatanUsaha` varchar(255) DEFAULT NULL,
  `nib` varchar(100) DEFAULT NULL,
  `tahunBinaan` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8mb4;

/* Trigger structure for table `tbl_umkm` */

DELIMITER $$

/*!50003 CREATE */ /*!50003 TRIGGER `addKodeAsset` BEFORE INSERT ON `tbl_umkm` FOR EACH ROW BEGIN
    INSERT INTO AutoInc VALUES (NULL);
    SET NEW.kode_asset = CONCAT('UKM-', LPAD(LAST_INSERT_ID(), 5, '0'));
    END */$$


DELIMITER ;

/* Procedure structure for procedure `AddAssetUMKM` */

DELIMITER $$

/*!50003 CREATE PROCEDURE `AddAssetUMKM`(kode char(13), tahun VARCHAR(6),assetUP VARCHAR(255), omzetUP varchar(255), tenaga varchar(255))
BEGIN
	insert into tbl_asset (`kode_asset`, `Tahun`, asset, omzet, tenagaKerja )values(kode,tahun,assetUP,omzetUP,tenaga );
	END */$$
DELIMITER ;

/* Procedure structure for procedure `CheckEmail` */

DELIMITER $$

/*!50003 CREATE PROCEDURE `CheckEmail`(kode char(13), emailnew VARCHAR(80))
BEGIN
	SELECT email_pgn FROM tbl_pengguna WHERE email_pgn != (SELECT
  `email_pgn`
FROM
  `tbl_pengguna` WHERE kode_pgn = kode
) AND email_pgn = emailnew;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `getDataCount` */

DELIMITER $$

/*!50003 CREATE PROCEDURE `getDataCount`( kode char(13))
BEGIN
	SELECT 
	(SELECT COUNT(*) FROM tbl_umkm) AS dataUMKM, 
	(SELECT COUNT(*) FROM tbl_kegiatan WHERE MONTH(`tanggal`) = MONTH(NOW()) and kode_pgn = kode) AS dataKegiatanBulan, 
	(SELECT COUNT(*) FROM tbl_kegiatan WHERE kode_pgn = kode) AS dataKegiatanSeluruh;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `GetDataUMKM` */

DELIMITER $$

/*!50003 CREATE PROCEDURE `GetDataUMKM`(tahunAwl varchar(4), tahunAkhr VARCHAR(4))
BEGIN
	
SELECT
	  `tbl_umkm`.`namaOwner`,
	  `tbl_umkm`.`nik`,
	  `tbl_umkm`.`namaUMKM`,
	  `tbl_umkm`.`nib`,
	  `tbl_umkm`.`noHP`,
	  `tbl_umkm`.`email`,
	  `tbl_umkm`.`pemasaranOnline`,
	  `tbl_umkm`.`legalitas`,
	  `tbl_umkm`.`jenisUsaha`,
	  `tbl_umkm`.`tahunBerdiri`,
	  `tbl_umkm`.`tahunBinaan`,
	  `tbl_umkm`.`kode_asset`,
	  (SELECT asset FROM tbl_asset WHERE tahun = tahunAwl AND `tbl_asset`.`kode_asset` = `tbl_umkm`.`kode_asset`) AS asset1,
	  (SELECT asset FROM tbl_asset WHERE tahun = tahunAkhr AND `tbl_asset`.`kode_asset` = `tbl_umkm`.`kode_asset`) AS asset2,
	  
	  (SELECT omzet FROM tbl_asset WHERE tahun = tahunAwl AND `tbl_asset`.`kode_asset` = `tbl_umkm`.`kode_asset`) AS omzet1,
	  (SELECT omzet FROM tbl_asset WHERE tahun = tahunAkhr AND `tbl_asset`.`kode_asset` = `tbl_umkm`.`kode_asset`) AS omzet2,
	  
	  (SELECT tenagaKerja FROM tbl_asset WHERE tahun = tahunAwl AND `tbl_asset`.`kode_asset` = `tbl_umkm`.`kode_asset`) AS pekerja1,
	  (SELECT tenagaKerja FROM tbl_asset WHERE tahun = tahunAkhr AND `tbl_asset`.`kode_asset` = `tbl_umkm`.`kode_asset`) AS pekerja2
	  
	FROM
	  `tbl_asset`
	  INNER JOIN `tbl_umkm`
	    ON (
	      `tbl_asset`.`kode_asset` = `tbl_umkm`.`kode_asset`
	    )    
	GROUP BY kode_asset	
	ORDER BY `tbl_umkm`.`kode_asset` ASC,
	`tbl_asset`.`Tahun` ASC;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `setDataLog` */

DELIMITER $$

/*!50003 CREATE PROCEDURE `setDataLog`(kode char(13), sts varchar(255))
BEGIN
	insert into tbl_log (`tanggal_log`, kode_pgn, `aktivitas_log`) values ((select now()), kode, sts);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `UpdateBiodataPemilik` */

DELIMITER $$

/*!50003 CREATE PROCEDURE `UpdateBiodataPemilik`(kode char(13), nama varchar(100), niks varchar(100), emails varchar(150), telp varchar(25), alamat varchar(255),times varchar(50) )
BEGIN
	UPDATE tbl_umkm SET
	namaOwner = nama,
	nik = niks,
	email = emails,
	noHP = telp,
	alamatRumah = alamat,
	`tbl_umkm`.`time` = times 
	WHERE kode_asset = kode;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `UpdatePengguna` */

DELIMITER $$

/*!50003 CREATE PROCEDURE `UpdatePengguna`(kode char(13), email VARCHAR(80),pw VARCHAR(18), actv int, lvl int)
BEGIN
	update tbl_pengguna set
	email_pgn = email,
	`password_pgn` = pw,
	is_active = actv,
	lvl_pgn = lvl
	where kode_pgn = kode;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `UpdateProfil` */

DELIMITER $$

/*!50003 CREATE PROCEDURE `UpdateProfil`(nama varchar(50), alamat varchar(50),jabatan varchar(255), hp varchar(15), foto varchar(255), email varchar(80))
BEGIN
		UPDATE `tbl_profil` SET 
		nama_dtl = nama,
		alamat_dtl = alamat,
		nohp_dtl = hp,
		jabatan_dtl = jabatan,
		foto_dtl = foto
		WHERE kode_pgn = (SELECT kode_pgn FROM tbl_pengguna WHERE email_pgn = email  );
	END */$$
DELIMITER ;

/* Procedure structure for procedure `UpdateTentangUMKM` */

DELIMITER $$

/*!50003 CREATE PROCEDURE `UpdateTentangUMKM`(kode CHAR(13), namaUMKMs varchar(100), nibs varchar(100), alamatUsahas varchar(255), tahunBerdiris varchar(255),
    jenisUsahas varchar(255), legalitass varchar(255), pemodalanMandiris varchar(100), pemodalanLuars varchar(100), pemasaranOnlines varchar(255),
    pemasaranOfflines  varchar(255), mitras varchar(100), tahunBinaans varchar(10), kegiatanUsahas varchar(255), times varchar(50))
BEGIN
	UPDATE tbl_umkm SET
	namaUMKM = namaUMKMs,
	nib = nibs,
	alamatUsaha = alamatUsahas,
	tahunBerdiri = tahunBerdiris,
	jenisUsaha = jenisUsahas,
	legalitas = legalitass,
	pemodalanMandiri = pemodalanMandiris,
	pemodalanLuar = pemodalanLuars,
	pemasaranOnline = pemasaranOnlines,
	pemasaranOffline = pemasaranOfflines,
	mitra = mitras,
	tahunBinaan = tahunBinaans,
	kegiatanUsaha = kegiatanUsahas,
	`tbl_umkm`.`time` = times
	WHERE kode_asset = kode;
	END */$$
DELIMITER ;

/*Table structure for table `profil_detail` */

DROP TABLE IF EXISTS `profil_detail`;

/*!50001 CREATE TABLE  `profil_detail`(
 `kode_dtl` char(13) ,
 `nama_dtl` varchar(50) ,
 `email_dtl` varchar(80) ,
 `password_dtl` varchar(18) ,
 `nohp_dtl` varchar(15) ,
 `status_dtl` int(1) ,
 `jabatan_dtl` varchar(255) ,
 `alamat_dtl` varchar(50) ,
 `foto_dtl` varchar(255) ,
 `role_dtl` int(11) ,
 `DateCreated` varchar(255) 
)*/;

/*Table structure for table `table_kegiatan` */

DROP TABLE IF EXISTS `table_kegiatan`;

/*!50001 CREATE TABLE  `table_kegiatan`(
 `kode_kegiatan` char(13) 
)*/;

/*Table structure for table `table_umkm` */

DROP TABLE IF EXISTS `table_umkm`;

/*!50001 CREATE TABLE  `table_umkm`(
 `times` varchar(255) ,
 `namaOwner` varchar(100) ,
 `namaUMKM` varchar(100) ,
 `alamatUsaha` varchar(255) ,
 `noHP` varchar(25) ,
 `kode_asset` char(13) 
)*/;

/*Table structure for table `v_log` */

DROP TABLE IF EXISTS `v_log`;

/*!50001 CREATE TABLE  `v_log`(
 `kode_pgn` char(13) ,
 `nama_dtl` varchar(50) ,
 `tanggal_log` varchar(255) ,
 `aktivitas_log` varchar(255) 
)*/;

/*View structure for view profil_detail */

/*!50001 DROP TABLE IF EXISTS `profil_detail` */;
/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `profil_detail` AS (select `tbl_profil`.`kode_pgn` AS `kode_dtl`,`tbl_profil`.`nama_dtl` AS `nama_dtl`,`tbl_pengguna`.`email_pgn` AS `email_dtl`,`tbl_pengguna`.`password_pgn` AS `password_dtl`,`tbl_profil`.`nohp_dtl` AS `nohp_dtl`,`tbl_pengguna`.`is_active` AS `status_dtl`,`tbl_profil`.`jabatan_dtl` AS `jabatan_dtl`,`tbl_profil`.`alamat_dtl` AS `alamat_dtl`,`tbl_profil`.`foto_dtl` AS `foto_dtl`,`tbl_level`.`id_lvl` AS `role_dtl`,`tbl_pengguna`.`date_created` AS `DateCreated` from ((`tbl_pengguna` join `tbl_profil` on(`tbl_pengguna`.`kode_pgn` = `tbl_profil`.`kode_pgn`)) join `tbl_level` on(`tbl_pengguna`.`lvl_pgn` = `tbl_level`.`id_lvl`))) */;

/*View structure for view table_kegiatan */

/*!50001 DROP TABLE IF EXISTS `table_kegiatan` */;
/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `table_kegiatan` AS (select `tbl_kegiatan`.`kode_kegiatan` AS `kode_kegiatan` from `tbl_kegiatan`) */;

/*View structure for view table_umkm */

/*!50001 DROP TABLE IF EXISTS `table_umkm` */;
/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `table_umkm` AS (select `tbl_umkm`.`time` AS `times`,`tbl_umkm`.`namaOwner` AS `namaOwner`,`tbl_umkm`.`namaUMKM` AS `namaUMKM`,`tbl_umkm`.`alamatUsaha` AS `alamatUsaha`,`tbl_umkm`.`noHP` AS `noHP`,`tbl_umkm`.`kode_asset` AS `kode_asset` from `tbl_umkm`) */;

/*View structure for view v_log */

/*!50001 DROP TABLE IF EXISTS `v_log` */;
/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_log` AS (select `tbl_log`.`kode_pgn` AS `kode_pgn`,`tbl_profil`.`nama_dtl` AS `nama_dtl`,`tbl_log`.`tanggal_log` AS `tanggal_log`,`tbl_log`.`aktivitas_log` AS `aktivitas_log` from ((`tbl_pengguna` join `tbl_log` on(`tbl_pengguna`.`kode_pgn` = `tbl_log`.`kode_pgn`)) join `tbl_profil` on(`tbl_profil`.`kode_pgn` = `tbl_log`.`kode_pgn`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

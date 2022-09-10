<?php

class M_User extends CI_Model
{
    public function getUsers($email, $password)
    {
        // return $this->db->get_where('tbl_pengguna', ['email_pgn' => $email, 'password_pgn' => $password])->result_array();
        $this->db->from("tbl_pengguna");
        $this->db->where("email_pgn = '$email' AND password_pgn = '$password'");
        return $this->db->get()->result();
        
    }

    public function CheckEmail($kode, $emailnew)
    {
        // return $this->db->get_where('tbl_pengguna', ['email_pgn' => $email, 'password_pgn' => $password])->result_array();
        $sql = "call CheckEmail (?,?);";
        $this->db->query($sql, array($kode, $emailnew));
        return $this->db->affected_rows();
    }

    public function CheckPass($kode, $oldPw)
    {
        $sql = "select * from tbl_pengguna where kode_pgn =  ? and password_pgn = ?;";
        $this->db->query($sql, array($kode, $oldPw));
        return $this->db->affected_rows();
    }

    public function GetCounts($kode)
    {
        // return $this->db->get_where('tbl_pengguna', ['email_pgn' => $email, 'password_pgn' => $password])->result_array();
        $sql = "call getDataCount (?);";
        return $this->db->query($sql, array($kode))->result();

    }
    
    public function CheckUMKM($nama)
    {
        
        $this->db->from("tbl_umkm");
        $this->db->where("namaUMKM = '$nama'");
        return $this->db->get()->result();
    }
    //ambil data umkm berdasarkan kode
    public function getDataUMKM($kode)
    {
        $this->db->from("tbl_umkm");
        $this->db->where("kode_asset = '$kode'");
        return $this->db->get()->result();
    }

    public function GetDetail($kode)
    {
        $this->db->from("profil_detail");
        $this->db->where("kode_dtl = '$kode'");
        return $this->db->get()->result();
    }
    
    public function GetNamaUser()
    {
        $this->db->from("tbl_profil");
        return $this->db->get()->result();
    }
    
    public function GetLogUser($kode, $bulan, $tahun)
    {
        $sql = "select * FROM v_log WHERE kode_pgn = '".$kode."' and MONTH(`tanggal_log`) = '".$bulan."' and YEAR(`tanggal_log`) = '".$tahun."'";
        return $this->db->query($sql)->result();
    }

    public function GetTableUMKM()
    {
        $this->db->from("table_umkm");
        $this->db->order_by("times", "asc");
        return $this->db->get()->result();
    }


    public function GetAllData()
    {
        $this->db->from("profil_detail");
        return $this->db->get()->result();
    }

    public function GetAssetUKM()
    {
        $this->db->from("tbl_umkm");
        return $this->db->get()->result();
    }

    public function GetAssetData($kode,$tahun)
    {
        $this->db->from("tbl_asset");
        $this->db->where("kode_asset = '$kode' and Tahun = '$tahun'");
        return $this->db->get()->result();
    }
    public function GetKegiatanDetl($kode)
    {
        $this->db->from("tbl_kegiatan");
        $this->db->where("kode_kegiatan = '$kode'");
        return $this->db->get()->result();
    }

    public function GetDataKegiatanDetail($kodeP,$tahun, $bulan)
    {
        $this->db->from("tbl_kegiatan");
        $this->db->where("kode_pgn = '$kodeP'");
        $this->db->where("MONTH(tanggal) = '$tahun' and YEAR(tanggal) = '$bulan'");
        $this->db->order_by("tanggal", "asc");
        return $this->db->get()->result();
    }
    public function GetLaporanKegiatanDetail($kodeP,$tahun, $bulan)
    {
        $this->db->from("tbl_kegiatan");
        $this->db->where("kode_pgn = '$kodeP'");
        $this->db->where("MONTH(tanggal) = '$bulan' and YEAR(tanggal) = '$tahun'");

        $this->db->order_by("tanggal", "asc");
        return $this->db->get()->result();
    }

    public function GetKegiatan()
    {
        $this->db->from("tbl_kegiatan");
        return $this->db->get()->result();
    }

    public function GetDataLaporanUMKM($tahunAwl, $tahunAkr)
    {
        $sql = "call GetDataUMKM (?,?);";
        return $this->db->query($sql, array($tahunAwl, $tahunAkr))->result();
        // return $this->db->result();
    }

    public function GetCariUKM($Owner, $UKM)
    {
        $sql = "select * FROM tbl_umkm WHERE namaOwner LIKE '%".$Owner."%' OR namaUMKM LIKE '%".$UKM."%' ";
        return $this->db->query($sql)->result();
        // return $this->db->result();
    }

    public function GetJadwalAktif($kode)
    {
        $sql = "sELECT * FROM tbl_jadwalkegiatan WHERE StatusNotif = TRUE and kode_pgn = '".$kode."' ORDER BY TanggalJadwal ASC;";
        return $this->db->query($sql)->result();
        // return $this->db->result();
    }


    public function GetKAssetUKM($nama, $owner)
    {
        $this->db->from("tbl_UMKM");
        $this->db->where("namaUMKM = '$nama' and namaOwner = '$owner'");
        return $this->db->get()->result();
    }

    public function createLog($kode, $aktivitas)
    {
        $sql = "call setDataLog (?,?);";
        $this->db->query($sql, array($kode,  $aktivitas));
        return $this->db->affected_rows();

    }

    public function createSchedule($kodeP, $status, $namKeg, $namUKM, $tgl)
    {
        $sql = "insert INTO tbl_jadwalkegiatan (kode_pgn, StatusNotif, NamaKegiatan, NamaUMKM,TanggalJadwal) values(?,?,?,?,?);";
        $this->db->query($sql, array($kodeP, $status, $namKeg, $namUKM, $tgl));
        return $this->db->affected_rows();

    }

    public function createPengguna($kode, $email, $password, $active, $lvl, $date)
    {
        $sql = "insert INTO tbl_pengguna (kode_pgn, email_pgn, password_pgn, is_active,lvl_pgn, date_created) values(?,?,?,?,?,?);";
        $this->db->query($sql, array($kode, $email, $password, $active, $lvl, $date));
        $sql = "insert INTO tbl_profil (kode_pgn) VALUES(?);";
        $this->db->query($sql, array($kode));
        
        return $this->db->affected_rows();
    }
    
    public function createdUMKM($time, $nama, $owener,$nik, $alamatRumah, $noHP, $email, 
                    $alamatUsaha,$tahunBerdiri, $jenis, $legal, $pemodalanM, $pemodalanL, $pemasaranON, 
                    $pemasaranOFF, $mitra, $kegiatan, $nib, $tahunBinaan)
    {
        $sql = "insert INTO tbl_umkm    (time, namaUMKM, namaOwner, nik, alamatRumah, noHP, email, alamatUsaha, tahunBerdiri, jenisUsaha, legalitas,
                                         pemodalanMandiri,pemodalanLuar, pemasaranOnline, pemasaranOffline,
                                        mitra, kegiatanUsaha, nib, tahunBinaan) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $this->db->query($sql, array($time, $nama, $owener,$nik, $alamatRumah, $noHP, $email, 
                    $alamatUsaha,$tahunBerdiri, $jenis, $legal, $pemodalanM, $pemodalanL, $pemasaranON, 
                    $pemasaranOFF, $mitra, $kegiatan, $nib, $tahunBinaan));
        return $this->db->affected_rows();
    }

    public function CreateDataUMKM($time,$nama, $email, $nohp, $namaukm, $alamat, $kegaiatan)
    {
        $sql = "insert INTO tbl_umkm (tbl_umkm.`time`, namaOwner, email, noHP, `namaUMKM`,alamatUsaha, kegiatanUsaha ) VALUES (?,?,?,?,?,?,?);";
        $this->db->query($sql, array($time,$nama, $email, $nohp, $namaukm, $alamat, $kegaiatan));
        return $this->db->affected_rows();
    }
    public function CreateAssetUMKM($kodeAset,$tahun, $aset, $omzet, $tenagaK)
    {
        $sql = "call AddAssetUMKM (?,?,?,?,?);";
        $this->db->query($sql, array($kodeAset,$tahun, $aset, $omzet, $tenagaK));
        return $this->db->affected_rows();
    }

    public function CreateKegiatanPendamping($kode,$kodePgn, $namaUKM, $permasalahan, $programKerja, $tanggal, $materi, $tindakan)
    {
        $sql = "insert into tbl_kegiatan (kode_kegiatan, kode_pgn, namaUKM, permasalahan, programKerja, tanggal, materi, tindakan )values(?,?,?,?,?,?,?,?);";
        $this->db->query($sql, array($kode,$kodePgn, $namaUKM, $permasalahan, $programKerja, $tanggal, $materi, $tindakan));
        return $this->db->affected_rows();
    }
    
    public function UpdateProfil($nama, $alamat, $jabatan, $telp, $foto, $email)
    {
        $sql = "call UpdateProfil (?,?,?,?,?,?);";
        $this->db->query($sql, array($nama, $alamat, $jabatan, $telp, $foto, $email));

        return $this->db->affected_rows();

    }

    public function UpdatePengguna($kode, $email, $password, $active, $lvl)
    {
        $sql = "call UpdatePengguna (?,?,?,?,?);";
        $this->db->query($sql, array($kode, $email, $password, $active, $lvl));

        return $this->db->affected_rows();
    }

    public function UpdatePassword($kode,$password)
    {
        $sql = "update tbl_pengguna SET password_pgn = ? WHERE kode_pgn = ?;";
        $this->db->query($sql, array($password , $kode));

        return $this->db->affected_rows();
    }

    public function UpdateBiodataPemilik($kode,$nama, $email, $nik, $telp, $alamat,$time)
    {
        $sql = "call UpdateBiodataPemilik (?,?,?,?,?,?,?);";
        $this->db->query($sql, array($kode, $nama, $nik, $email, $telp, $alamat,$time));

        return $this->db->affected_rows();
    }

    public function UpdateTentangUKM($kode, $nama,$nib, $alamatUsaha,$tahunBerdiri, $jenis, $legal, 
                    $pemodalanM, $pemodalanL, $pemasaranON, $pemasaranOFF, $mitra, $tahunBinaan,$kegiatan, $time)
    {
        $sql = "call UpdateTentangUMKM (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $this->db->query($sql, array($kode, $nama,$nib, $alamatUsaha,$tahunBerdiri, $jenis, $legal, 
                    $pemodalanM, $pemodalanL, $pemasaranON, $pemasaranOFF, $mitra, $tahunBinaan,$kegiatan, $time));

        return $this->db->affected_rows();
    }
    
    public function UpdateUMKM($time, $nama, $owener,$nik, $alamatRumah, $noHP, $email, 
                    $alamatUsaha,$tahunBerdiri, $jenis, $legal, $pemodalanM, $pemodalanL, $pemasaranON, 
                    $pemasaranOFF, $mitra, $kegiatan, $nib, $tahunBinaan)
    {
        $sql = "update tbl_umkm SET  time  = ?, namaOwner  = ?, nik  = ?, alamatRumah  = ?, noHP  = ?, email  = ?, 
                alamatUsaha  = ?, tahunBerdiri  = ?, jenisUsaha  = ?, legalitas  = ?,  
                pemodalanMandiri  = ?, pemodalanLuar  = ?, pemasaranOnline  = ?, pemasaranOffline  = ?, 
                mitra  = ?, kegiatanUsaha  = ?, nib  = ?, tahunBinaan = ? where namaUMKM  = ?;";
        $this->db->query($sql, array($time, $owener,$nik, $alamatRumah, $noHP, $email, 
                    $alamatUsaha,$tahunBerdiri, $jenis, $legal, $pemodalanM, $pemodalanL, $pemasaranON, 
                    $pemasaranOFF, $mitra, $kegiatan, $nib, $tahunBinaan, $nama));
        return $this->db->affected_rows();
    }

    public function UpdateAssetUMKM($kodeAset,$tahun, $aset, $omzet, $tenagaK)
    {
        $sql = "update tbl_asset SET  asset = ?, omzet = ?, tenagaKerja = ? WHERE kode_asset = ? and Tahun = ?;";
        $this->db->query($sql, array( $aset, $omzet, $tenagaK,$kodeAset,$tahun));
        return $this->db->affected_rows();
    }

    public function UpdateKegiatanDetail($kode, $namaUKM, $permasalahan, $programKerja, $tanggal, $materi, $tindakan)
    {
        $sql = "update tbl_kegiatan SET  namaUKM = ?, permasalahan = ?, programKerja = ?, tanggal = ?, materi = ?, tindakan = ? WHERE kode_kegiatan = ? ;";
        $this->db->query($sql, array( $namaUKM, $permasalahan, $programKerja, $tanggal, $materi, $tindakan,$kode));
        return $this->db->affected_rows();
    }

    public function DeletedPengguna($kode, $email)
    {
        $this->db->where("kode_pgn", $kode);
        $this->db->where("email_pgn", $email);
        $this->db->delete('tbl_pengguna');
        $this->db->where("kode_pgn", $kode);
        $this->db->delete('tbl_profil');
        return $this->db->affected_rows();

    }

    public function DeletedUKM($kode)
    {
        $this->db->where("kode_asset", $kode);
        $this->db->delete('tbl_asset');
        $this->db->where("kode_asset", $kode);
        $this->db->delete('tbl_umkm');
        return $this->db->affected_rows();

    }
    public function DeletedKegiatan($kode)
    {
        $this->db->where("kode_kegiatan", $kode);
        $this->db->delete('tbl_kegiatan');
        return $this->db->affected_rows();

    }
    public function DeletedJadwalKegiatan($kodeP, $kodeJ)
    {
        $this->db->where("id_jadwalkegiatan", $kodeJ);
        $this->db->where("kode_pgn", $kodeP);
        $this->db->delete('tbl_jadwalkegiatan');
        return $this->db->affected_rows();

    }

}

<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/Format.php';
require_once APPPATH . 'libraries/RestController.php';

class UMKM extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User', 'MU');
    }

    public function index_get()
    {
        // untuk mengambil kode data asset
        if($this->get('get')=="getKodeAsset"){
            $data = $this->MU->GetAssetUKM();
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'data not found',
                ], RestController::HTTP_OK);
            }
        //untuk mengamil kode aset berdasarkan nama pemilik dan nama usaha
        }elseif($this->get('get')=="getKodeAsetUKM"){
            $nama = $this->get('namaUMKM');
            $owner = $this->get('namaOwner');
            $data = $this->MU->GetKAssetUKM($nama,$owner);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'data not found',
                ], RestController::HTTP_OK);
            }

        //mencari nama UMKM
        }elseif ($this->get('get')=="getNamaUMKM") {
            $nama = $this->get('namaUMKM');
            $data = $this->MU->CheckUMKM($nama);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'data not found',
                ], RestController::HTTP_OK);
            }
        //mengambil data table umkm
        }elseif ($this->get('get')=="table_umkm") {  
            $data = $this->MU->GetTableUMKM();
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'data not found',
                ], RestController::HTTP_OK);
            }
        // mengambil data umkm berdasarkan kode
        }elseif ($this->get('get')=="dataUMKM") {
            $kode = $this->get('kodeAset');
            $data = $this->MU->getDataUMKM($kode);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'data not found',
                ], RestController::HTTP_OK);
            }
        }elseif ($this->get('get')=="getAssetData"){
            $kode = $this->get('kode');
            $tahun = $this->get('tahun');
            $data = $this->MU->GetAssetData($kode,$tahun);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'data not found',
                ], RestController::HTTP_OK);
            }
        }elseif ($this->get('get')=="getSearchUMKM"){
            $Owner = $this->get('namaOwner');
            $Ukm = $this->get('namaUKM');
            $data = $this->MU->GetCariUKM($Owner,$Ukm);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'data not found',
                ], RestController::HTTP_OK);
            }
        }
    }

    public function index_post()
    {
        if($this->post('post') == "importCSV"){
            $time = $this->post('time');
            $nama = $this->post('namaUMKM');
            $owener = $this->post('namaOwner');
            $nik = $this->post('nik');
            $alamatRumah = $this->post('alamatRumah');
            $noHP = $this->post('noHP');
            $email = $this->post('email');
            $alamatUsaha = $this->post('alamatUsaha');
            $tahunBerdiri = $this->post('tahunBerdiri');
            $jenis = $this->post('jenisUsaha');
            $legal = $this->post('legalitas');
            // $kodeAset = $this->post('kode_asset');
            $pemodalanM = $this->post('pemodalanMandiri');
            $pemodalanL = $this->post('pemodalanLuar');
            $pemasaranON = $this->post('pemasaranOnline');
            $pemasaranOFF = $this->post('pemasaranOffline');
            $mitra = $this->post('mitra');
            $kegiatan = $this->post('kegiatan');
            $nib = $this->post('nib');
            $tahunBinaan = $this->post('tahunBinaan');

            $data = $this->MU->createdUMKM($time, $nama, $owener,$nik, $alamatRumah, $noHP, $email, 
                    $alamatUsaha,$tahunBerdiri,  $jenis, $legal, $pemodalanM, $pemodalanL, $pemasaranON, 
                    $pemasaranOFF, $mitra, $kegiatan, $nib, $tahunBinaan);
                    if ($data) {
                        $this->response([
                            'status' => true,
                            'data' => $data,
                        ], RestController::HTTP_OK);
                    } else {
                    $this->response([
                        'status' => false,
                        'data' => 'Data gagal Ditambahkan',
                    ], RestController::HTTP_OK);
                    }
        }else if($this->post('post') == "ImportAssetCSV"){
            $kodeAset = $this->post('kode');
            $aset2020 = $this->post('aset2020');
            $tenagaK2020 = $this->post('tenagaKerja2020');
            $omzet2020 = $this->post('omzet2020');
            $aset2021 = $this->post('aset2021');
            $omzet2021 = $this->post('omzet2021');
            $tenagaK2021 = $this->post('tenagaKerja2021');
            $data = $this->MU->CreateAssetUMKM($kodeAset,'2020', $aset2020, $omzet2020, $tenagaK2020);
            $data3 = $this->MU->CreateAssetUMKM($kodeAset,'2021', $aset2021, $omzet2021, $tenagaK2021);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => "Berhasil",
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'Data gagal Ditambahkan',
                ], RestController::HTTP_OK);
            }
        }else if($this->post('post') == "insertDataAsset"){
            $kode = $this->post('kode');
            $tahun = $this->post('tahun');
            $aset = $this->post('aset');
            $omzet = $this->post('omzet');
            $pekerja = $this->post('pekerja');
            $aktivitas = "Menambahkan Data Asset Pada kode UMKM ".$kode;
            $data = $this->MU->createLog($kodeP,$aktivitas);
            $data = $this->MU->CreateAssetUMKM($kode,$tahun,$aset,$omzet,$pekerja);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => "Berhasil",
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'Data gagal Ditambah',
                ], RestController::HTTP_OK);
            }

        }else if($this->post('post') == "AddDataUKM"){
            $kodeP = $this->post('kodeP');
            $time = $this->post('time');
            $namaOwner = $this->post('nama');
            $email = $this->post('email');
            $nohp = $this->post('nohp');
            $namaUMKM = $this->post('namaUMKM');
            $alamat = $this->post('alamat');
            $kegiatan = $this->post('kegiatan');
            $aktivitas = "Menambahkan Data UMKM ".$namaUMKM;
            $data = $this->MU->createLog($kodeP,$aktivitas);
            $data = $this->MU->CreateDataUMKM($time, $namaOwner, $email, $nohp, $namaUMKM,$alamat,$kegiatan);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => "Berhasil",
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'Data gagal Ditambah',
                ], RestController::HTTP_OK);
            }
        }

    }

    public function index_put()
    {
            if($this->put('put') == "UpdateFromUMKMCSV"){
                $time = $this->put('time');
                $nama = $this->put('namaUMKM');
                $owener = $this->put('namaOwner');
                $nik = $this->put('nik');
                $alamatRumah = $this->put('alamatRumah');
                $noHP = $this->put('noHP');
                $email = $this->put('email');
                $alamatUsaha = $this->put('alamatUsaha');
                $tahunBerdiri = $this->put('tahunBerdiri');
                $jenis = $this->put('jenisUsaha');
                $legal = $this->put('legalitas');
                $pemodalanM = $this->put('pemodalanMandiri');
                $pemodalanL = $this->put('pemodalanLuar');
                $pemasaranON = $this->put('pemasaranOnline');
                $pemasaranOFF = $this->put('pemasaranOffline');
                $mitra = $this->put('mitra');
                $kegiatan = $this->put('kegiatan');
                $nib = $this->put('nib');
                $tahunBinaan = $this->put('tahunBinaan');

                $data = $this->MU->UpdateUMKM($time, $nama, $owener, $nik, $alamatRumah, $noHP, $email,
                    $alamatUsaha, $tahunBerdiri, $jenis, $legal, $pemodalanM, $pemodalanL, $pemasaranON,
                    $pemasaranOFF, $mitra, $kegiatan, $nib, $tahunBinaan);
                if ($data) {
                    $this->response([
                        'status' => true,
                        'data' => $data,
                    ], RestController::HTTP_OK);
                } else {
                    $this->response([
                        'status' => false,
                        'data' => 'Data gagal Diupdate',
                    ], RestController::HTTP_OK);
                }
        }elseif ($this->put('put') == "UpdateAssetCSV") {
            $kodeAset = $this->put('kode');
            $aset2020 = $this->put('aset2020');
            $tenagaK2020 = $this->put('tenagaKerja2020');
            $omzet2020 = $this->put('omzet2020');
            $aset2021 = $this->put('aset2021');
            $omzet2021 = $this->put('omzet2021');
            $tenagaK2021 = $this->put('tenagaKerja2021');
            $data = $this->MU->UpdateAssetUMKM($kodeAset, '2020', $aset2020, $omzet2020, $tenagaK2020);
            $data3 = $this->MU->UpdateAssetUMKM($kodeAset, '2021', $aset2021, $omzet2021, $tenagaK2021);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => "Berhasil",
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'Data gagal Diupdate',
                ], RestController::HTTP_OK);
            }
        }elseif ($this->put('put') == "UpdateBiodataPemilik") {
            $kode = $this->put('kode');
            $kodeP = $this->put('kodeP');
            $owener = $this->put('namaOwner');
            $nik = $this->put('nik');
            $alamatRumah = $this->put('alamatRumah');
            $noHP = $this->put('noHP');
            $email = $this->put('email');
            $times = $this->put('time');
            $aktivitas = "Mengubah Biodata Pemilik pada kode UMKM ".$kode;
            $data = $this->MU->createLog($kodeP,$aktivitas);
            $data = $this->MU->UpdateBiodataPemilik($kode, $owener, $email, $nik, $noHP, $alamatRumah,$times);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => "Berhasil",
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'Data gagal Diupdate',
                ], RestController::HTTP_OK);
            }
        }elseif ($this->put('put') == "UpdateTentangUKM") {
                $time = $this->put('time');
                $nama = $this->put('namaUMKM');
                $alamatUsaha = $this->put('alamatUsaha');
                $tahunBerdiri = $this->put('tahunBerdiri');
                $jenis = $this->put('jenisUsaha');
                $legal = $this->put('legalitas');
                $pemodalanM = $this->put('pemodalanMandiri');
                $pemodalanL = $this->put('pemodalanLuar');
                $pemasaranON = $this->put('pemasaranOnline');
                $pemasaranOFF = $this->put('pemasaranOffline');
                $mitra = $this->put('mitra');
                $kegiatan = $this->put('kegiatan');
                $tahunBinaan = $this->put('tahunBinaan');
                $nib = $this->put('nib');
                $kode = $this->put('kode');
                $kodeP = $this->put('kodeP');
                $aktivitas = "Mengubah Data UMKM ".$nama;
            $data = $this->MU->createLog($kodeP,$aktivitas);
            $data = $this->MU->UpdateTentangUKM($kode, $nama,$nib, $alamatUsaha,$tahunBerdiri, $jenis, $legal, 
                    $pemodalanM, $pemodalanL, $pemasaranON, $pemasaranOFF, $mitra, $tahunBinaan,$kegiatan, $time);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => "Berhasil",
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'Data gagal Diupdate',
                ], RestController::HTTP_OK);
            }
        }elseif ($this->put('put') == "UpdateAssetUKM") {
                $kode = $this->put('kode');
                $tahun = $this->put('tahun');
                $aset = $this->put('aset');
                $omzet = $this->put('omzet');
                $pekerja = $this->put('pekerja');
                $kodeP = $this->put('kodeP');
                $aktivitas = "Mengubah Data Asset Pada kode UMKM ".$kode;
            $data = $this->MU->createLog($kodeP,$aktivitas);
            $data = $this->MU->UpdateAssetUMKM($kode,$tahun,$aset,$omzet,$pekerja);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => "Berhasil",
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'Data gagal Diupdate',
                ], RestController::HTTP_OK);
            }
        }else{
            $this->response(['status' => "Fungsi Tidak DI Temukan",],RestController::HTTP_OK);
        }
    }

    public function index_delete()
    {
        if($this->delete('delete')=="hapusUKM"){
            $kode = $this->delete('kode');
            $kodeP = $this->delete('kodeP');
            $aktivitas = "Menghapus Data UMKM Pada kode UMKM ".$kode;
            $data = $this->MU->createLog($kodeP,$aktivitas);
            $data = $this->MU->DeletedUKM($kode);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => "Berhasil",
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'Data Dihapus',
                ], RestController::HTTP_OK);
            }
        }
    }
}

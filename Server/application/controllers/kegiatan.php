<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/Format.php';
require_once APPPATH . 'libraries/RestController.php';

class kegiatan extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User', 'MU');
    }

    public function index_post()
    {
        if($this->post('post') == "TambahKegiatan"){
            $kodeK = $this->post('kodeK'); 
            $kodeP = $this->post('kodeP'); 
            $namaUkm = $this->post('namaUMKM'); 
            $masalah = $this->post('permasalahan'); 
            $program = $this->post('programKegiatan'); 
            $tanggal = $this->post('tanggal'); 
            $materi = $this->post('materi'); 
            $tindakan = $this->post('tindakan'); 


            $aktivitas = "Menambahkan Kegiatan Laporan Baru Pada UMKM ".$namaUkm;
            $data = $this->MU->createLog($kodeP,$aktivitas);
            $data = $this->MU->CreateKegiatanPendamping($kodeK,$kodeP,$namaUkm,$masalah,$program,$tanggal,$materi,$tindakan);
            if($data){
                $this->response([
                    'status' => true,
                    'data' => "Data Berhasil Di simpan",
                ], RestController::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'data' => "Data Gagal Di Tambahkan",
                ], RestController::HTTP_OK);
            }
        }else if($this->post('post') == "TambahJadwalKegiatan"){
            $kodeP = $this->post('kodeP');
            $statusNotif = "1";
            $namaKegiatan = $this->post('namaKeg');
            $NamaUMKM = $this->post('namaUKM');
            $Tanggal = $this->post('tgl');
            $aktivitas = "Menambahkan Jadwal Kegiatan Baru Untuk ".$namaKegiatan;
            $data = $this->MU->createLog($kodeP,$aktivitas);
            $data = $this->MU->createSchedule($kodeP, $statusNotif, $namaKegiatan, $NamaUMKM, $Tanggal);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => "Data Berhasil Di simpan",
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => "Data Gagal Di Tambahkan",
                ], RestController::HTTP_OK);
            }

        }
    }

    public function index_get()
    {
        if($this->get('get') == "getDataKegiatanDetail"){
            $kodep = $this->get('kodeP');
            $tahun = $this->get('tahun');
            $bulan = $this->get('bulan');
            // $nama = $this->get('namaUKM');
            $data = $this->MU->GetDataKegiatanDetail($kodep,$bulan,$tahun);
            if($data){
                $this->response([
                    'status' => true,
                    'data' => $data,
                ], RestController::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'data' => "Data Tidak Ada",
                ], RestController::HTTP_OK);
            }
        }else if($this->get('get') == "getKegiatan"){
            $data = $this->MU->GetKegiatan();
            if($data){
                $this->response([
                    'status' => true,
                    'data' => $data,
                ], RestController::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'data' => "Data Tidak Ada",
                ], RestController::HTTP_OK);
            }
        }else if($this->get('get') == "getDetailKegiatan"){
            $kode = $this->get('kode');
            $data = $this->MU->GetKegiatanDetl($kode);
            if($data){
                $this->response([
                    'status' => true,
                    'data' => $data,
                ], RestController::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'data' => "Data Tidak Ada",
                ], RestController::HTTP_OK);
            }
        }else if($this->get('get') == "getJadwalAktifPengguna"){
            $kodeP = $this->get('kodeP');
            $data = $this->MU->getJadwalAktif($kodeP);
            if($data){
                $this->response([
                    'status' => true,
                    'data' => $data,
                ], RestController::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'data' => "Data Tidak Ada",
                ], RestController::HTTP_OK);
            }
        }
    }

    public function index_delete()
    {
        if($this->delete('delete')=="hapusKegiatan"){
            $kodeP = $this->delete('kodeP');
            $kode = $this->delete('kodeK');
            $aktivitas = "Menghapus Data Kegiatan ".$kode;
            $data = $this->MU->createLog($kodeP,$aktivitas);
            $data = $this->MU->DeletedKegiatan($kode);
            if($data){
                $this->response([
                    'status' => true,
                    'data' => "Data Berhasil Di Hapus",
                ], RestController::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'data' => "Data Gagal Di hapus",
                ], RestController::HTTP_OK);
            }
        }else if($this->delete('delete')=="hapusJadwal"){
            $kodeP = $this->delete('kodeP');
            $kodeJ = $this->delete('kodeJ');
            $aktivitas = "Menghapus Data Jadwal Kegiatan ".$kodeP;
            $data = $this->MU->createLog($kodeP,$aktivitas);
            $data = $this->MU->DeletedJadwalKegiatan($kodeP, $kodeJ);
            if($data){
                $this->response([
                    'status' => true,
                    'data' => "Data Berhasil Di Hapus",
                ], RestController::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'data' => "Data Gagal Di hapus",
                ], RestController::HTTP_OK);
            }
        }
    }

    public function index_put()
    {
        if($this->put('put')=="UpdateKegiatan"){
            $kodeP = $this->put('kodeP');
            $kode = $this->put('kodeK');
            $namaUkm = $this->put('namaUMKM'); 
            $masalah = $this->put('permasalahan'); 
            $program = $this->put('programKegiatan'); 
            $tanggal = $this->put('tanggal'); 
            $materi = $this->put('materi'); 
            $tindakan = $this->put('tindakan');
            $aktivitas = "Mengubah Kegiatan Laporan Pada UMKM ".$namaUkm;
            $data = $this->MU->createLog($kodeP,$aktivitas);
            $data = $this->MU->UpdateKegiatanDetail($kode,$namaUkm,$masalah,$program,$tanggal,$materi,$tindakan);
            if($data){
                $this->response([
                    'status' => true,
                    'data' => "Data Berhasil Di Update",
                ], RestController::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'data' => "Data Gagal Di Update",
                ], RestController::HTTP_OK);
            }
        }
    }
}
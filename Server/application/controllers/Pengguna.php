<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/Format.php';
require_once APPPATH . 'libraries/RestController.php';

class Pengguna extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User', 'MU');
    }

    public function index_get()
    {
        $data = $this->MU->GetAllData();
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
    public function index_put()
    {
        //memanggil id yang ada di view
        $kode = $this->put('kodePengguna');
        $kodepk = $this->put('kode');
        $email = $this->put('emailPengguna');
        $password = $this->put('passwordPengguna');
        $active = $this->put('statusPengguna');
        $lvl = $this->put('levelPengguna');
        $aktivitas = "Mengupdate Data Pengguna ".$kode;
        $data = $this->MU->createLog($kodepk,$aktivitas);
        $data = $this->MU->UpdatePengguna($kode, $email, $password, $active, $lvl);
        if ($data) {
            $this->response([
                'status' => true,
                'data' => 'Data Berhasil Di Update',
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'data Tidak Ada Yang Terupdate',
            ], RestController::HTTP_OK);

        }
    }

    public function index_delete()
    {
        $kodeP = $this->delete('kodeP');
        $kode = $this->delete('kodePengguna');
        $email = $this->delete('emailPengguna');
        $aktivitas = "Menghapus Data Pengguna " . $email;
        $data = $this->MU->createLog($kodeP, $aktivitas);

        $data = $this->MU->DeletedPengguna($kode, $email);
        if ($data) {
            $this->response([
                'status' => true,
                'data' => 'Data Berhasil Di Hapus',
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'Gagal Terhapus',
            ], RestController::HTTP_OK);

        }

    }

    public function index_post()
    {
        $kode = $this->post('kodePengguna');
        $kodeP = $this->post('kodeP');
        $email = $this->post('emailPengguna');
        $password = $this->post('passwordPengguna');
        $active = $this->post('statusPengguna');
        $lvl = $this->post('levelPengguna');
        $date = $this->post('date_created');
        $aktivitas = "Menambahkan Pengguna Baru " . $email;
        $data = $this->MU->createLog($kodeP, $aktivitas);

        $data = $this->MU->createPengguna($kode, $email, $password, $active, $lvl, $date, $kode);
        if ($data) {
            $this->response([
                'status' => true,
                'data' => 'Data Berhasil Ditambahkan',
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'Data gagal Ditambahkan',
            ], RestController::HTTP_OK);

        }

    }

}

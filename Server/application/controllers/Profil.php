<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/Format.php';
require_once APPPATH . 'libraries/RestController.php';

class Profil extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User', 'MU');
    }

    public function index_post()
    {
        //memanggil id yang ada di view
        $kodeP = $this->post('kodeP');
        $nama = $this->post('nama_pgn');
        $telp = $this->post('tlp_pgn');
        $jabatan = $this->post('jabatan_pgn');
        $alamat = $this->post('alamat_pgn');
        $foto = $this->post('photo_pgn');
        $email = $this->post('email_pgn');

        $aktivitas = "Mengubah Profil ".$nama;
        $data = $this->MU->createLog($kodeP, $aktivitas);
        $data = $this->MU->UpdateProfil($nama, $alamat, $jabatan, $telp, $foto, $email);
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

    public function index_put()
    {
        if($this->put('put') == "UpdatePass"){
            $kode = $this->put("kode");
            $Pw = $this->put("newPW");
            $data = $this->MU->UpdatePassword($kode,$Pw);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => 'Berhasil Di Update',
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'Gagal Di Update',
                ], RestController::HTTP_OK);
    
            }
    
        }
        
    }

    public function index_get()
    {
        if($this->get("get") == "checkOldPass"){
            $kode = $this->get("kode");
            $oldPass = $this->get("oldPw");
            $data = $this->MU->CheckPass($kode,$oldPass);
            if ($data) {
                $this->response([
                    'status' => true,
                    'data' => 'Ditemukan',
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'Kosong',
                ], RestController::HTTP_OK);

            }

        }
    }

}

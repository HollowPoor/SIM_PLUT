<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/Format.php';
require_once APPPATH . 'libraries/RestController.php';

class Validasi extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User', 'MU');
    }

    public function index_post()
    {
        $kode = $this->post('kode');
        $emails = $this->post('emailbaru');
        $data = $this->MU->CheckEmail($kode, $emails);
        if ($data) {
            $this->response([
                'status' => false,
                'data' => "Email Sudah Digunakan, Silahkan Coba Email Lain",
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => true,
                'data' => 'Email Dapat Digunakan',
            ], RestController::HTTP_OK);

        }

    }
}

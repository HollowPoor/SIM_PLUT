<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/Format.php';
require_once APPPATH . 'libraries/RestController.php';

class C_User extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User', 'MU');
    }

    public function index_post()
    {
        //ambil data get
        $email = $this->post('email');
        $password = $this->post('password');

        $data = $this->MU->getUsers($email, $password);

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

    public function index_get()
    {
        $kode = $this->get('kode');

        $data = $this->MU->GetDetail($kode);

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

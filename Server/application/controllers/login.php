<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/Format.php';
require_once APPPATH . 'libraries/RestController.php';

class login extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User', 'MU');

        //untuk menambah limit penggunaan metod ban 1 jam
        //liat di dalam rest.php aktifin limit ada di 'membuat limit fungsi ada disni'
        //$this->methods['index_get']['limit'] = [1];

        //rambahan kalo ingin buat key pas login bisa pakai ini pada rest.php 'membuat keys fungsi ada disni'
    }

    public function index_get()
    {
        $email = $this->get('email');
        //contoh
        //var_dump($data);
        if ($username === null) {
            $data = $this->MU->getUsers($username);
        } else {
            $data = $this->MU->getUsers($username);
        }

        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data,
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'data not found',
            ], RestController::HTTP_NOT_FOUND);

        }
    }

    public function index_delete()
    {
        $username = $this->delete('username');
        if ($username === null) {
            $this->response([
                'status' => false,
                'data' => 'Key Tidak Ada',
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            //DeleteUser dari model
            if ($this->MU->DeleteUser($username) > 0) {
                //kalau data ada
                $this->response([
                    'status' => true,
                    //   'kode' => $username,
                    'data' => 'data terhapus',
                ], RestController::HTTP_OK);

            } else {
                //kalau tidak ada
                $this->response([
                    'status' => false,
                    'data' => 'data tidak ada',
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {
        $data = [
            //'id_user' => $this->post('id'),
            'kode_user' => $this->post('kode'),
            'username' => $this->post('username'),
            'password' => $this->post('password'),
        ];
        //createUser dari model
        if ($this->MU->createUser($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'User Berhasil DiBuat',
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'User Gagal DiBuat',
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'kode_user' => $this->put('kode'),
            'username' => $this->put('username'),
            'password' => $this->put('password'),
        ];

        if ($this->MU->UpdateUser($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'User Berhasil Diubah',
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'User Gagal Diubah',
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}

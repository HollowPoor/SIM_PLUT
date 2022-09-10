<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library(array("client"));
        $this->load->model('MLogin');

    }

    public function index()
    {
        //buat validasi session

        if (isset($_SESSION['email'])) {
            redirect("Dashboard");
        } else {
            $this->load->view('Login/index');
        }

    }

    public function Auth()
    {

        $this->form_validation->set_rules('emailpgn', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('passwordpgn', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {

            $this->load->view("Login/index");
        } else {
            $email = $this->input->post("emailpgn", true);
            $password = $this->input->post("passwordpgn", true);
            // $hasil = $this->MLogin->AuthLogin($email, $password);
            $hasil2 = json_decode($this->client->simple_post(API_User, array("email" => $email, "password" => $password)));

            if ($hasil2->status == 1) {
                //set session
                foreach ($hasil2->data as $data) {
                    $tampil['kode'] = $data->kode_pgn;
                    $tampil['email'] = $data->email_pgn;
                    $tampil['password'] = $data->password_pgn;
                    $tampil['is_active'] = $data->is_active;
                    $tampil['level'] = $data->lvl_pgn;
                };
                $set = [
                    'email' => $tampil['email'],
                    'kode' => $tampil['kode'],
                    'level' => $tampil['level'],
                ];
                $this->session->set_userdata($set);
                redirect('Dashboard');
            } else {
                //buat data flash jika user tidak di temukan
                $this->session->set_flashdata('login', 'Silahkan Periksa Akun Anda Kembali');
                $this->load->view("Login/index");
            }
        }
        # code...
    }
}

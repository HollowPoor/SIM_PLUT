<?php
defined('BASEPATH') or exit('No direct script access allowed');


class DataLog extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library(array("client"));
        $this->load->model('MLogin');
        $this->load->helper(array("url"));

    }

    public function index()
    {
        if (isset($_SESSION['kode'])) {

            $kode = $_SESSION['kode'];
            $tampil = json_decode($this->client->simple_get(API_User, array("kode" => $kode)));
            $tampilPengguna = json_decode($this->client->simple_get(API_Pengguna));
            foreach ($tampil->data as $data) {

                $detail['NamaPengguna'] = $data->nama_dtl;
                $detail['FotoPengguna'] = $data->foto_dtl;
                $detail['Judul'] = "Data Log Pengguna";
            };
            $dataS["pengguna"] = $tampilPengguna->data;
            $detail['administrator'] = $_SESSION['level'];
            $this->load->view('Template/header', $detail);
            $this->load->view('Main/LogAktivitas', $dataS);
            $this->load->view('Template/footer');
        } else {
            redirect("Login");
        }

    }

    public function getLogAktivitas()
    {
        $kode = $_SESSION['kode'];
        $dataAwal['get'] = "getLogAktivitas";
        $dataAwal['kode'] = $this->input->post('kodeP');
        $tanggals = $this->input->post('tanggals');
        $dataAwal['tahun'] = date("Y", strtotime($tanggals));
        $dataAwal['bulan'] = date("m", strtotime($tanggals));
        $getData = json_decode($this->client->simple_get(API_Log, $dataAwal));
        if(isset($getData)){
            echo json_encode($getData);
        }else{
            echo "false";
        }

    }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');


class DataLaporan extends CI_Controller
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
            foreach ($tampil->data as $data) {
                $detail['NamaPengguna'] = $data->nama_dtl;
                $detail['FotoPengguna'] = $data->foto_dtl;
                $detail['Jabatan'] = $data->jabatan_dtl;
                $detail['Judul'] = "Data Kegiatan Pendamping";
            };
            $get['get'] = "table_umkm";
            $tampilUMKM = json_decode($this->client->simple_get(API_UMKM,$get));
            $detail["umkm"] = $tampilUMKM->data;
            $detail['administrator'] = $_SESSION['level'];
            $this->load->view('Template/header', $detail);
            $this->load->view('Main/LaporanSIM');
            $this->load->view('Template/footer');
        } else {
            redirect("Login");
        }
    }

    public function GetNamaPendamping()
    {
        $tampil = json_decode($this->client->simple_get(API_Laporan, array("get" => "getNamaPendamping")));
        echo json_encode($tampil);

    }
    public function getKegiatanLaporan()
    {
        $kode = $_SESSION['kode'];
        $dataAwal['get'] = "getDataKegiatanDetail";
        $dataAwal['kodeP'] = $this->input->post('kodeP');
        $tanggals = $this->input->post('tanggals');
        $dataAwal['tahun'] = date("Y", strtotime($tanggals));
        $dataAwal['bulan'] = date("m", strtotime($tanggals));
        $getData = json_decode($this->client->simple_get(API_Kegiatan, $dataAwal));
        if(isset($getData)){
            echo json_encode($getData);
        }else{
            echo "false";
        }

    }
}
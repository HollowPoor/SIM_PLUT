<?php
defined('BASEPATH') or exit('No direct script access allowed');


class KelolaJadwal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library(array("client"));
        $this->load->model('MLogin');
        $this->load->helper(array("url"));
        $this->load->library('Csvimport');


    }
    public function index()
    {
        if (isset($_SESSION['kode'])) {

            $kode = $_SESSION['kode'];
            $tampil = json_decode($this->client->simple_get(API_User, array("kode" => $kode)));
            foreach ($tampil->data as $data) {
                $detail['NamaPengguna'] = $data->nama_dtl;
                $detail['FotoPengguna'] = $data->foto_dtl;
                $detail['Judul'] = "Kelola Jadwal Pendampingan";
            };
            $dataAwal['get'] = "getLogAktivitas";
            $detail['administrator'] = $_SESSION['level'];
            $dataAwal['kode'] = $kode;
            $dataAwal['tahun'] = date("Y");
            $dataAwal['bulan'] = date("m");
            $getData = json_decode($this->client->simple_get(API_Log, $dataAwal));
            $detail['Logs'] = $getData->data;
            $detail['status'] = $getData->status;
            $dataAwal['get'] = "getCount";
            $getDatas = json_decode($this->client->simple_get(API_Log, $dataAwal));
            foreach ($getDatas->data as $data) {
                $detail['hasilUMKM'] = $data->dataUMKM;
                $detail['hasilKegiatanBulan'] = $data->dataKegiatanBulan;
                $detail['hasilKegiatanSeluruh'] = $data->dataKegiatanSeluruh;
            };
            $this->load->view('Template/header', $detail);
            $this->load->view('Main/KelolaJadwal');
            $this->load->view('Template/footer');
        } else {
            redirect("Login");
        }

    }

    public function HapusJadwal()
    {
        $data = array(
            "kodeP" => $this->input->post("kodePengguna"),
            "kodeJ" => $this->input->post("kodeJadwal"),
            "delete" => "hapusJadwal",
        );
        $respon = json_decode($this->client->simple_delete(API_Kegiatan, $data));
        if ($respon->status == true) {
            // $this->session->set_flashdata('deleteJadwal', 'Data Berhasil Dihapus');
            echo "sukses";
        } else {
            echo "gagal";
            // $this->session->set_flashdata('deleteJadwal', 'Data Gagal Dihapus');
        }
    }

    public function AmbilDataJadwal()
    {
        $dataJadwal['get'] = "getJadwalAktifPengguna";
        $dataJadwal['kodeP'] = $this->input->post("kodeP");
        $getDataJadwal = json_decode($this->client->simple_get(API_Kegiatan,$dataJadwal));
        if(isset($getDataJadwal)){
            echo json_encode($getDataJadwal);
        }else{
            echo false;
        }
    }

    public function TambahJadwalKeg()
    {
        $kodeP = $_SESSION['kode'];
        $addData['kodeP'] = $this->input->post('kodeP');;
        $addData['tgl'] = $this->input->post('tgl');
        $addData['namaKeg'] = $this->input->post('namaKegiatan');
        $addData['namaUKM'] = $this->input->post('namaUMKM');
        $addData['post'] = "TambahJadwalKegiatan";
        $hasil = json_decode($this->client->simple_post(API_Kegiatan, $addData));
        if(isset($hasil)){
                if($hasil->status == true){
                    echo "sukses";
                }else{
                    echo "gagal";
                }
            }
    }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');


class DataKegiatan extends CI_Controller
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
                $detail['email'] = $data->email_dtl;
                $detail['Jabatan'] = $data->jabatan_dtl;
                $detail['Judul'] = "Data Kegiatan Pendamping";
            };
            $dataAwal['get'] = "getDataKegiatanDetail";
            $dataAwal['kodeP'] = $kode;
            $dataAwal['tahun'] = date("Y", time());
            $dataAwal['bulan'] = date("m", time());
            $getData = json_decode($this->client->simple_get(API_Kegiatan,$dataAwal));
            $kirim['kegiatan'] = $getData->data;
            $kirim['status'] = $getData->status;
            $dataJadwal['get'] = "getJadwalAktifPengguna";
            $dataJadwal['kodeP'] = $kode;
            $getDataJadwal = json_decode($this->client->simple_get(API_Kegiatan,$dataJadwal));
            $detail['administrator'] = $_SESSION['level'];
            $detail['Jadwal'] = $getDataJadwal->data;
            $detail['jadwalSts'] = $getDataJadwal->status;
            $this->load->view('Template/header', $detail);
            $this->load->view('Main/KegiatanPendamping',$kirim);
            $this->load->view('Template/footer');
        } else {
            redirect("Login");
        }

    }
    
    public function getKegiatanBulan()
    {
        $kode = $_SESSION['kode'];
        $dataAwal['get'] = "getDataKegiatanDetail";
        $dataAwal['kodeP'] = $kode;
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

    public function TambahKegiatan()
    {
        $kirim['kodeK'] = $this->GetKodeKegiatan();
        $kirim['kodeP'] = $_SESSION['kode'];
        $kirim['namaUMKM'] = $this->input->post('nama_ukm');
        $kirim['permasalahan'] = $this->input->post('permasalahan');
        $kirim['programKegiatan'] = $this->input->post('programKerja');
        $kirim['tanggal'] = $this->input->post('tglKegiatan');
        $kirim['materi'] = $this->input->post('materi');
        $kirim['tindakan'] = $this->input->post('skema');
        $kirim['post'] = 'TambahKegiatan';
        // echo $kirim['tanggal'];
        $postData = json_decode($this->client->simple_post(API_Kegiatan, $kirim));
        if($postData->status){
            $this->session->set_flashdata('statusKegiatan', 'sukses');
            $this->session->set_flashdata('dataUpdate', "Kegiatan Berhasil Di Tambahkan.");
            redirect('DataKegiatan');
        }else{
            $this->session->set_flashdata('statusKegiatan', 'gagal');
            $this->session->set_flashdata('dataUpdate', "Kegiatan Gagal Di Tambahkan.");
            redirect('DataKegiatan');

        }
    }

    public function GetKodeKegiatan()
    {
        $i = 1;
        $x = 1;
        $kirim['get'] = "getKegiatan";

        $tampilKegiatan = json_decode($this->client->simple_get(API_Kegiatan,$kirim));
        foreach ($tampilKegiatan->data as $data) {
            $str = $data->kode_kegiatan;
            $num = (explode("-", $str));
            $int = (int) $num[1];
            if ($i != $int) {
                $x = $i;
            }
            $x = $i;
            $i++;
        }
        ;
        $num = (explode("-", $str));
        $int = (int) $num[1];
        if ($i - 1 == $int) {
            $x = $i;
        }
        return "KEG-" . str_pad($x, 5, "0", STR_PAD_LEFT);
    }

    public function GetDetailKegiatan()
    {
        $kirim['kode'] = $this->input->post('kodeK');
        $kirim['get'] = "getDetailKegiatan";
        $getData = json_decode($this->client->simple_get(API_Kegiatan, $kirim));
        if($getData->status){
            $this->session->set_userdata('kodeK', $kirim['kode']);
            echo json_encode($getData->data);
        }else{
            echo "false";
        }

    }

    public function HapusKegiatan()
    {
        $kirim['delete'] = 'hapusKegiatan';
        $kirim['kodeK'] = $_SESSION['kodeK'];
        $kode = $_SESSION['kode'];
        $kirim['kodeP'] = $kode;
        $deleteData = json_decode($this->client->simple_delete(API_Kegiatan, $kirim));
        if($deleteData->status){
            $this->session->set_flashdata('statusKegiatan', 'sukses');
            $this->session->set_flashdata('dataUpdate', "Kegiatan Berhasil Di Hapus.");
            redirect('DataKegiatan');
        }else{
            $this->session->set_flashdata('statusKegiatan', 'gagal');
            $this->session->set_flashdata('dataUpdate', "Kegiatan Gagal Di Hapus.");
            redirect('DataKegiatan');

        }
    }
    public function UpdateKegiatan()
    {
        $kode = $_SESSION['kode'];
        $kirim['kodeP'] = $kode;
        $kirim['put'] = 'UpdateKegiatan';
        $kirim['kodeK'] = $_SESSION['kodeK'];
        $kirim['namaUMKM'] = $this->input->post('nama_ukm');
        $kirim['permasalahan'] = $this->input->post('permasalahan');
        $kirim['programKegiatan'] = $this->input->post('programKerja');
        $kirim['tanggal'] = $this->input->post('tglKegiatan');
        $kirim['materi'] = $this->input->post('materi');
        $kirim['tindakan'] = $this->input->post('skema');
        $putData = json_decode($this->client->simple_put(API_Kegiatan, $kirim));
        if($putData->status){
            $this->session->set_flashdata('statusKegiatan', 'sukses');
            $this->session->set_flashdata('dataUpdate', "Kegiatan Berhasil Di Perbarui.");
            redirect('DataKegiatan');
        }else{
            $this->session->set_flashdata('statusKegiatan', 'gagal');
            $this->session->set_flashdata('dataUpdate', "Kegiatan Gagal Di Perbarui.");
            redirect('DataKegiatan');

        }
    }
    public function TambahJadwalKegiatan()
    {
        $kodeP = $_SESSION['kode'];
        $addData['kodeP'] = $kodeP;
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
<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if (isset($_SESSION['kode'])) {

            $kode = $_SESSION['kode'];
            $tampil = json_decode($this->client->simple_get(API_User, array("kode" => $kode)));
            foreach ($tampil->data as $data) {
                $detail['NamaPengguna'] = $data->nama_dtl;
                $detail['FotoPengguna'] = $data->foto_dtl;
                $detail['Judul'] = "Dashboard";
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
            $this->load->view('Main/index',$detail);
            $this->load->view('Template/footer');
        } else {
            redirect("Login");
        }

    }

    public function DeleteSession()
    {
        $array_items = array('email','kode','level');
        $this->session->unset_userdata($array_items);

        redirect("Login");
    }

    public function Profil()
    {
        if (isset($_SESSION['kode'])) {

            $kode = $_SESSION['kode'];
            $tampil = json_decode($this->client->simple_get(API_User, array("kode" => $kode)));
            foreach ($tampil->data as $data) {
                $detail['NamaPengguna'] = $data->nama_dtl;
                $detail['Email'] = $data->email_dtl;
                $detail['NoTelphone'] = $data->nohp_dtl;
                $detail['Jabatan'] = $data->jabatan_dtl;
                $detail['Alamat'] = $data->alamat_dtl;
                $detail['FotoPengguna'] = $data->foto_dtl;
                $detail['Tanggal'] = $data->DateCreated;
                $detail['Judul'] = "Profil Pengguna";
            };
            $detail['administrator'] = $_SESSION['level'];
            $this->session->set_userdata('Kode_Pengguna', "");
            $this->load->view('Template/header', $detail);
            $this->load->view('Main/Profil', $detail);
            $this->load->view('Template/footer');
        } else {
            redirect("Login");
        }

    }

    public function CheckPassword()
    {
        $oldPassword = $this->input->post('oldPass');
        $kodeP = $_SESSION['Kode_Pengguna'];
        $kode = $_SESSION['kode'];

        if($kodeP != ""){
             $k = $kodeP ;
        }else{
             $k = $kode ;
        }
        $hasil = json_decode($this->client->simple_get(API_Profil, array("get"=> "checkOldPass","kode" => $k, "oldPw"=>$oldPassword)));
        echo $hasil->data;
    }

    public function UpdatePassword()
    {
        $oldPassword = $this->input->post('newPass');
        $kodeP = $_SESSION['Kode_Pengguna'];
        $kode = $_SESSION['kode'];

        if($kodeP != ""){
             $k = $kodeP ;
        }else{
             $k = $kode ;
        }
        $hasil = json_decode($this->client->simple_put(API_Profil, array("put"=> "UpdatePass","kode" => $k, "newPW"=>$oldPassword)));
        echo $hasil->data;
    }

    public function ProfilUpdate()
    {
        if (isset($_SESSION['kode'])) {
            $kodeP = $_SESSION['kode'];
            if ($_SESSION['Kode_Pengguna'] != "") {
                $kode = $_SESSION['Kode_Pengguna'];
                //validation
                $this->form_validation->set_rules('NamaPengguna', 'Nama Pengguna', 'trim|required');
                $this->form_validation->set_rules('TelphonePengguna', 'No Handphone', 'trim|required');
                $this->form_validation->set_rules('JabatanPengguna', 'Jabatan', 'trim|required');
                $this->form_validation->set_rules('AlamatPengguna', 'Alamat', 'trim|required');

                $tampilP = json_decode($this->client->simple_get(API_User, array("kode" => $_SESSION['kode'])));
                foreach ($tampilP->data as $data) {
                    $detailP['NamaPengguna'] = $this->input->post('NamaPengguna');
                    $detailP['Email'] = $this->input->post('EmailPengguna');
                    $detailP['NoTelphone'] = $this->input->post('TelphonePengguna');
                    $detailP['Jabatan'] = $this->input->post('JabatanPengguna');
                    $detailP['Alamat'] = $this->input->post('AlamatPengguna');
                    $detailP['FotoPengguna'] = $this->input->post('foto_dtl');
                    $detailP['Tanggal'] = $data->DateCreated;
                    $detailP['Judul'] = "Profil Pengguna";
                };
                $tampil = json_decode($this->client->simple_get(API_User, array("kode" => $kode)));
                foreach ($tampil->data as $data) {
                    $detail['NamaPengguna'] = $this->input->post('NamaPengguna');
                    $detail['Email'] = $this->input->post('EmailPengguna');
                    $detail['NoTelphone'] = $this->input->post('TelphonePengguna');
                    $detail['Jabatan'] = $this->input->post('JabatanPengguna');
                    $detail['Alamat'] = $this->input->post('AlamatPengguna');
                    if ($this->input->post('foto_dtl') == false) {
                        $foto = $data->foto_dtl;
                    } else {
                        $foto = $this->input->post('foto_dtl');

                    }
                    $detail['FotoPengguna'] = $foto;
                    $detail['Tanggal'] = $data->DateCreated;
                    $detail['Judul'] = "Profil Pengguna";
                };

                if ($this->form_validation->run() == false) {
                    //jika data kosong
                    $detailP['administrator'] = $_SESSION['level'];
                    $this->session->set_flashdata('profil', 'Profil Belum Tersimpan');
                    $this->load->view('Template/header', $detailP);
                    $this->load->view('Main/Profil', $detail);
                    $this->load->view('Template/footer');
                } else {
                    //jika data terisi
                    $kodeP = $_SESSION['kode'];

                    $upload = $_FILES['foto_dtl']['name'];
                    if ($upload) {
                        $config['allowed_types'] = 'jpg|png';
                        $config['max_size'] = '2048';
                        $config['upload_path'] = './assets/img/profil_img/';
                        $this->load->library('upload', $config);

                        if ($this->upload->do_upload('foto_dtl')) {
                            //jika benar dan profil di perbarui
                            $kirim = array(
                                "kodeP" => $kodeP,
                                "nama_pgn" => $detail['NamaPengguna'],
                                "tlp_pgn" => $detail['NoTelphone'],
                                "jabatan_pgn" => $detail['Jabatan'],
                                "alamat_pgn" => $detail['Alamat'],
                                "photo_pgn" => $upload,
                                "email_pgn" => $detail['Email'],
                            );
                            $simpan = json_decode($this->client->simple_post(API_Profil, $kirim));
                            //menghapus foto yang lama jika upload yang baru
                            if ($foto != "default.png") {
                                unlink(FCPATH . 'assets/img/profil_img/' . $foto);
                            }
                            $this->session->set_flashdata('deletedPengguna', 'Profil Berhasil Di Update');
                            unset($_SESSION['Kode_Pengguna']);
                            redirect('DataPengguna');
                        } else {
                            //jika file gambar salah
                            //echo $this->upload->display_errors();
                            $this->session->set_flashdata('profil', 'Format Gambar Yang Di Upload Tidak Di Dukung');
                            $detailP['administrator'] = $_SESSION['level'];
                            $this->load->view('Template/header', $detailP);
                            $this->load->view('Main/Profil', $detail);
                            $this->load->view('Template/footer');
                        }
                    } else {
                        //jika update tanpa ada foto yang di upload
                        $kirim = array(
                            "kodeP" => $kodeP,
                            "nama_pgn" => $detail['NamaPengguna'],
                            "tlp_pgn" => $detail['NoTelphone'],
                            "jabatan_pgn" => $detail['Jabatan'],
                            "alamat_pgn" => $detail['Alamat'],
                            "photo_pgn" => $foto,
                            "email_pgn" => $detail['Email'],
                        );
                        $simpan = json_decode($this->client->simple_post(API_Profil, $kirim));
                        
                        $this->session->set_flashdata('deletedPengguna', 'Profil Berhasil Di Update');
                        $this->session->set_userdata('Kode_Pengguna', "");

                        redirect('DataPengguna');

                    }

                }

            } else {
                $kode = $_SESSION['kode'];
                $kodeP = $_SESSION['kode'];
                //validation
                $this->form_validation->set_rules('NamaPengguna', 'Nama Pengguna', 'trim|required');
                $this->form_validation->set_rules('TelphonePengguna', 'No Handphone', 'trim|required');
                $this->form_validation->set_rules('JabatanPengguna', 'Jabatan', 'trim|required');
                $this->form_validation->set_rules('AlamatPengguna', 'Alamat', 'trim|required');

                $tampil = json_decode($this->client->simple_get(API_User, array("kode" => $kode)));
                foreach ($tampil->data as $data) {
                    $detail['NamaPengguna'] = $this->input->post('NamaPengguna');
                    $detail['Email'] = $this->input->post('EmailPengguna');
                    $detail['NoTelphone'] = $this->input->post('TelphonePengguna');
                    $detail['Jabatan'] = $this->input->post('JabatanPengguna');
                    $detail['Alamat'] = $this->input->post('AlamatPengguna');
                    if ($this->input->post('foto_dtl') == false) {
                        $foto = $data->foto_dtl;
                    } else {
                        $foto = $this->input->post('foto_dtl');

                    }
                    $detail['FotoPengguna'] = $foto;
                    $detail['Tanggal'] = $data->DateCreated;
                    $detail['Judul'] = "Profil Pengguna";
                };

                if ($this->form_validation->run() == false) {
                    //jika data kosong
                    $this->session->set_flashdata('profil', 'Profil Belum Tersimpan');
                    $detail['administrator'] = $_SESSION['level'];
                    $this->load->view('Template/header', $detail);
                    $this->load->view('Main/Profil', $detail);
                    $this->load->view('Template/footer');
                } else {
                    //jika data terisi

                    $upload = $_FILES['foto_dtl']['name'];
                    if ($upload) {
                        $config['allowed_types'] = 'jpg|png';
                        $config['max_size'] = '2048';
                        $config['upload_path'] = './assets/img/profil_img/';
                        $this->load->library('upload', $config);

                        if ($this->upload->do_upload('foto_dtl')) {
                            //jika benar dan profil di perbarui
                            $kirim = array(
                                "kodeP" => $kodeP,
                                "nama_pgn" => $detail['NamaPengguna'],
                                "tlp_pgn" => $detail['NoTelphone'],
                                "jabatan_pgn" => $detail['Jabatan'],
                                "alamat_pgn" => $detail['Alamat'],
                                "photo_pgn" => $upload,
                                "email_pgn" => $detail['Email'],
                            );
                            $simpan = json_decode($this->client->simple_post(API_Profil, $kirim));
                            //menghapus foto yang lama jika upload yang baru
                            if ($foto != "default.png") {
                                unlink(FCPATH . 'assets/img/profil_img/' . $foto);
                            }
                            $this->session->set_flashdata('profil', 'Profil Berhasil Di Update');
                            redirect('Dashboard/Profil');
                        } else {
                            //jika file gambar salah
                            //echo $this->upload->display_errors();
                            $this->session->set_flashdata('profil', 'Format Gambar Yang Di Upload Tidak Di Dukung');
                            $detail['administrator'] = $_SESSION['level'];
                            $this->load->view('Template/header', $detail);
                            $this->load->view('Main/Profil', $detail);
                            $this->load->view('Template/footer');
                        }
                    } else {
                        //jika update tanpa ada foto yang di upload
                        $kirim = array(
                            "kodeP" => $kodeP,
                            "nama_pgn" => $detail['NamaPengguna'],
                            "tlp_pgn" => $detail['NoTelphone'],
                            "jabatan_pgn" => $detail['Jabatan'],
                            "alamat_pgn" => $detail['Alamat'],
                            "photo_pgn" => $foto,
                            "email_pgn" => $detail['Email'],
                        );
                        $simpan = json_decode($this->client->simple_post(API_Profil, $kirim));

                        $this->session->set_flashdata('profil', 'Profil Berhasil Di Update');
                        $detail['administrator'] = $_SESSION['level'];
                        $this->load->view('Template/header', $detail);
                        $this->load->view('Main/Profil', $detail);
                        $this->load->view('Template/footer');
                    }

                }
            }
        } else {
            redirect("Login");
        }

    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');


class DataPengguna extends CI_Controller
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
                $detail['Judul'] = "Data Pengguna";
            };
            $dataS["pengguna"] = $tampilPengguna->data;
            $detail['administrator'] = $_SESSION['level'];

            $this->load->view('Template/header', $detail);
            $this->load->view('Main/DataPengguna', $dataS);
            $this->load->view('Template/footer');
        } else {
            redirect("Login");
        }

    }
    public function UpdatePengguna()
    {

        $kode = $this->input->post('kodePengguna');
        $email = $this->input->post('emailPengguna');
        $password = $this->input->post('passwordPengguna');
        $statusP = $this->input->post('statusPengguna');
        $level = $this->input->post('levelPengguna');
        $kodeP = $_SESSION['kode'];
        $data = array(
            "kode" => $_SESSION['kode'],
            "kodeP" => $kodeP,
            "kodePengguna" => $kode,
            "emailPengguna" => $email,
            "passwordPengguna" => $password,
            "statusPengguna" => $statusP,
            "levelPengguna" => $level,
        );
        $respon = json_decode($this->client->simple_put(API_Pengguna, $data));
        if ($respon->status == true) {
            echo "Berhasil Update Data Pengguna";
        } else {
            echo "Gagal Update Data Pengguna";
        }

    }
    public function DeletePengguna()
    {
        $kode = $this->input->post('kodePengguna');
        $email = $this->input->post('emailPengguna');
        $kodeP = $_SESSION['kode'];
        $data = array(
            "kodeP" => $kodeP,
            "kodePengguna" => $kode,
            "emailPengguna" => $email,
        );
        $respon = json_decode($this->client->simple_delete(API_Pengguna, $data));
        if ($respon->status == true) {
            $this->session->set_flashdata('deletedPengguna', 'Data Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('deletedPengguna', 'Data Gagal Dihapus');
        }

    }
    public function CheckEmail()
    {
        $kode = $this->input->post('kode');
        $emailnew = $this->input->post('emailnew');
        $data = array(
            "kode" => $kode,
            "emailbaru" => $emailnew,
        );
        $respon = json_decode($this->client->simple_post(API_Check, $data));
        if ($respon->status == true) {
            echo "Email Dapat Digunakan";
        } else {
            echo "Email Sudah Digunakan";
        }
    }

    public function AddDataPengguna()
    {
        $kode = $this->input->post('kodePengguna');
        $email = $this->input->post('emailPengguna');
        $password = $this->input->post('passwordPengguna');
        $statusP = $this->input->post('statusPengguna');
        $level = $this->input->post('levelPengguna');
        $date = date("Y-m-d H:i:s", time());
        $kodeP = $_SESSION['kode'];
        $data = array(
            "kodeP" => $kodeP,
            "kodePengguna" => $kode,
            "emailPengguna" => $email,
            "passwordPengguna" => $password,
            "statusPengguna" => $statusP,
            "levelPengguna" => $level,
            "date_created" => $date,
            "kodePengguna" => $kode,
        );
        $respon = json_decode($this->client->simple_post(API_Pengguna, $data));
        if ($respon->status == true) {
            $this->session->set_userdata('Kode_Pengguna', $kode);
            echo "Pengguna Berhasil Ditambahkan";
        } else {
            echo "Pengguna gagal Ditambahkan";
        }

    }

    public function GetKodePengguna()
    {
        $i = 1;
        $x = 1;
        $tampilPengguna = json_decode($this->client->simple_get(API_Pengguna));
        foreach ($tampilPengguna->data as $data) {
            $str = $data->kode_dtl;
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
        echo "PGN-" . str_pad($x, 3, "0", STR_PAD_LEFT);
    }

    public function ProfilPengguna()
    {
        if (isset($_SESSION['kode'])) {
            $kode = $_SESSION['kode'];
            $kodeP = $_SESSION['Kode_Pengguna'];
            $tampil = json_decode($this->client->simple_get(API_User, array("kode" => $kode)));
            foreach ($tampil->data as $data) {
                $detail['NamaPengguna'] = $data->nama_dtl;
                $detail['Email'] = $data->email_dtl;
                $detail['NoTelphone'] = $data->nohp_dtl;
                $detail['Jabatan'] = $data->jabatan_dtl;
                $detail['Alamat'] = $data->alamat_dtl;
                $detail['FotoPengguna'] = $data->foto_dtl;
                $detail['Tanggal'] = date("d-M-Y H:i:s",strtotime($data->DateCreated));
                $detail['Judul'] = "Profil Pengguna";
            };
            $tampilP = json_decode($this->client->simple_get(API_User, array("kode" => $kodeP)));
            foreach ($tampilP->data as $data) {
                $detailP['NamaPengguna'] = $data->nama_dtl;
                $detailP['Email'] = $data->email_dtl;
                $detailP['NoTelphone'] = $data->nohp_dtl;
                $detailP['Jabatan'] = $data->jabatan_dtl;
                $detailP['Alamat'] = $data->alamat_dtl;
                $detailP['FotoPengguna'] = $data->foto_dtl;
                $detailP['Tanggal'] = date("d-M-Y H:i:s",strtotime($data->DateCreated));
                $detailP['Judul'] = "Profil Pengguna";
            };
            $detail['administrator'] = $_SESSION['level'];

            $this->load->view('Template/header', $detail);
            $this->load->view('Main/Profil', $detailP);
            $this->load->view('Template/footer');
        } else {
            redirect("Login");
        }

    }

    public function ProfilUpdate()
    {
        if (isset($_SESSION['kode'])) {
            $kode = $_SESSION['kode'];
            $kodePs = $_SESSION['kode'];
            if ($_SESSION['Kode_Pengguna'] != $kodeP) {
                $kodeP = $_SESSION['Kode_Pengguna'];
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
                    $detail['Tanggal'] = date("d-M-Y H:i:s",strtotime($data->DateCreated));
                    $detail['Judul'] = "Profil Pengguna";
                };
                
                $tampilP = json_decode($this->client->simple_get(API_User, array("kode" => $kodeP)));
                foreach ($tampilP->data as $data) {
                    $detailP['NamaPengguna'] = $data->nama_dtl;
                    $detailP['Email'] = $data->email_dtl;
                    $detailP['NoTelphone'] = $data->nohp_dtl;
                    $detailP['Jabatan'] = $data->jabatan_dtl;
                    $detailP['Alamat'] = $data->alamat_dtl;
                    if ($this->input->post('foto_dtl') == false) {
                        $foto = $data->foto_dtl;
                    } else {
                        $foto = $this->input->post('foto_dtl');
                    }
                    $detailP['FotoPengguna'] = $data->foto_dtl;
                    $detailP['Tanggal'] = date("d-M-Y H:i:s",strtotime($data->DateCreated));
                    $detailP['Judul'] = "Profil Pengguna";
                }
                ;
    
                if ($this->form_validation->run() == false) {
                    //jika data kosong
                    $this->session->set_flashdata('profil', 'Silahkan Update Profil Pengguna');
                    $detail['administrator'] = $_SESSION['level'];

                    $this->load->view('Template/header', $detail);
                    $this->load->view('Main/Profil', $detailP);
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
                                "kodeP" => $kodePs,
                                "nama_pgn" => $detailP['NamaPengguna'],
                                "tlp_pgn" => $detailP['NoTelphone'],
                                "jabatan_pgn" => $detailP['Jabatan'],
                                "alamat_pgn" => $detail['Alamat'],
                                "photo_pgn" => $upload,
                                "email_pgn" => $detailP['Email'],
                            );
                            $simpan = json_decode($this->client->simple_post(API_Profil, $kirim));
                            //menghapus foto yang lama jika upload yang baru
                            if ($foto != "default.png") {
                                unlink(FCPATH . 'assets/img/profil_img/' . $foto);
                            }
                            $this->session->set_flashdata('profil', 'Profil Berhasil Di Update');
                            redirect('DataPengguna');
                        } else {
                            //jika file gambar salah
                            //echo $this->upload->display_errors();
                            $this->session->set_flashdata('profil', 'Format Gambar Yang Di Upload Tidak Di Dukung');
                            $detail['administrator'] = $_SESSION['level'];

                            $this->load->view('Template/header', $detail);
                            $this->load->view('Main/Profil', $detailP);
                            $this->load->view('Template/footer');
                        }
                    } else {
                        //jika update tanpa ada foto yang di upload
                        $kirim = array(
                            "kodeP" => $kodePs,
                            "nama_pgn" => $detailP['NamaPengguna'],
                            "tlp_pgn" => $detailP['NoTelphone'],
                            "jabatan_pgn" => $detailP['Jabatan'],
                            "alamat_pgn" => $detailP['Alamat'],
                            "photo_pgn" => $foto,
                            "email_pgn" => $detailP['Email'],
                        );
                        $simpan = json_decode($this->client->simple_post(API_Profil, $kirim));
    
                        $this->session->set_flashdata('profil', 'Profil Berhasil Di Update');
                        $detail['administrator'] = $_SESSION['level'];

                        $this->load->view('Template/header', $detail);
                        $this->load->view('Main/Profil', $detailP);
                        $this->load->view('Template/footer');
                    }
    
                }
            
            }

        } else {
            redirect("Login");
        }

    }

    //set session
    public function SetSession()
    {
        $kode = $this->input->post("kodePengguna");
        $this->session->set_userdata('Kode_Pengguna', $kode);
        redirect("DataPengguna/ProfilUpdate");
    }
}

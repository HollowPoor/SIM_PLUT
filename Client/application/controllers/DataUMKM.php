<?php
defined('BASEPATH') or exit('No direct script access allowed');


class DataUMKM extends CI_Controller
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
            $tampilPengguna = json_decode($this->client->simple_get(API_Pengguna));
            foreach ($tampil->data as $data) {

                $detail['NamaPengguna'] = $data->nama_dtl;
                $detail['FotoPengguna'] = $data->foto_dtl;
                $detail['Judul'] = "Data UMKM";
            };
            $get['get'] = "table_umkm";
            $tampilUMKM = json_decode($this->client->simple_get(API_UMKM,$get));
            foreach ($tampilUMKM->data as $data) {

                $dataS['NamaOwner'] = $data->namaOwner;
                $dataS['NamaUMKM'] = $data->namaUMKM;
                $dataS['Alamat'] = $data->alamatUsaha;
                $dataS['noHP'] = $data->noHP;
                $dataS['kodeAset'] = $data->kode_asset;

            };
            $dataS["umkm"] = $tampilUMKM->data;
            $detail['administrator'] = $_SESSION['level'];

            $this->load->view('Template/header', $detail);
            $this->load->view('Main/DataUmkm', $dataS);
            $this->load->view('Template/footer');
        } else {
            redirect("Login");
        }

    }

    public function importCSV()
    {
        // echo strtotime("2/15/2022 10:49:55"), "\n";
        // echo date("d-m-Y H:i:s", strtotime("2/15/2022 10:49:55")) . "\n";

        $data['error'] = ''; //initialize image upload error array to empty

        $upload = $_FILES['csvUMKM']['name'];

        $config['upload_path'] = './Data/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('csvUMKM')){
            $insert = 0;
            $update = 0;
            $date;
            $file_data = $this->upload->data();
            $file_path =  './Data/'.$file_data['file_name'];
            
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                foreach ($csv_array as $row) {
                        if($row['Asset (Dalam Angka Rupiah) [Row 1]'] == ""){
                            $asset = $row['Asset Tahun 2020 (Dalam Angka Rupiah)'];
                        }else{
                            $asset = $row['Asset (Dalam Angka Rupiah) [Row 1]'];
                        }
                        $times = date("Y-m-d H:i:s", strtotime($row['Timestamp']));
                    $insert_data = array(
                        'time'=> $times ,
                        'namaUMKM'=>$row['Nama UMKM/Merk Usaha'],
                        'namaOwner'=>$row['Nama Owner Sesuai E-KTP'],
                        'nik'=>$row['NIK'],
                        'alamatRumah'=>$row['Alamat Rumah (Sesuai KTP)'],
                        'noHP'=>$row['Nomor Handphone'],
                        'email'=>$row['Email Aktif'],
                        'alamatUsaha'=>$row['Alamat Usaha'],
                        'tahunBerdiri'=>$row['Tahun Berdiri/ Mulai Usaha'],
                        'jenisUsaha'=>$row['JENIS / BIDANG USAHA (Contoh : Catering, Kerajinan, Fashion,Kuliner)'],
                        'legalitas'=>$row['LEGALITAS (SURAT YANG DI MILIKI)'],
                        'pemodalanMandiri'=>$row['Permodalan (Modal Sendiri Dalam Angka  (Rp))'],
                        'pemodalanLuar'=>$row['Permodalan (Modal Luar Dalam Angka (Rp))'],
                        'pemasaranOnline'=>$row['Pemasaran Produk Secara Online (SOSIAL MEDIA)'],
                        'pemasaranOffline'=>$row['PEMASARAN PRODUK SECARA OFFLINE'],
                        'mitra'=>$row['KERJASAMA / BERMITRA'],
                        'kegiatan'=>$row['Kegiatan Usaha'],
                        'nib'=>$row['NOMOR INDUK BERUSAHA(NIB)'],
                        'tahunBinaan'=>$row['Tahun menjadi Binaan PLUT'],

                        'aset2020'=>$asset,
                        'omzet2020'=>$row['Omzet Tahun 2020 (Dalam Angka Rupiah)'],
                        'tenagaKerja2020'=>$row['Tenaga Kerja Tahun 2020'],
                        'aset2021'=>$row['Asset Tahun 2021 (Dalam Angka Rupiah)'],
                        'omzet2021'=>$row['Omzet Tahun 2021 (Dalam Angka Rupiah)'],
                        'tenagaKerja2021'=>$row['Tenaga Kerja Tahun 2021'],
                    );
                    $insert_data['get'] = "getNamaUMKM";
                    $CheckUMKM = json_decode($this->client->simple_get(API_UMKM, $insert_data));
                    if(isset($CheckUMKM)){
                        if($CheckUMKM->status == false){
                            $insert = $insert + 1;
                            //simpan data ke csv
                            $insert_data['post'] = "importCSV";
                            json_decode($this->client->simple_post(API_UMKM, $insert_data));
                            
                            //ambil kode dari data yang sudah di simpan diatas
                            $insert_data['get'] = "getKodeAsetUKM";
                            $tampil = json_decode($this->client->simple_get(API_UMKM, $insert_data));
                            if(isset($tampil)){
                                if($tampil->status == true){
                                    foreach($tampil->data as $data){
                                        $kode =  $data->kode_asset;
                                        $insert_data['post'] = "ImportAssetCSV";
                                        
                                    }
                                    $insert_data['kode'] = $kode;
                                    $tampil = json_decode($this->client->simple_post(API_UMKM, $insert_data));
                                    
                                }else{
                                    echo "Data Kosong";
                                }
                            }
                            //jika data umkm sudah ada
                        }else{
                            //update data UMKM 
                            $insert_data['put'] = "UpdateFromUMKMCSV";
                            json_decode($this->client->simple_put(API_UMKM, $insert_data));
                            
                            $tampil = json_decode($this->client->simple_get(API_UMKM, $insert_data));
                            if(isset($tampil)){
                                if($tampil->status == true){
                                    foreach($tampil->data as $data){
                                        $kode =  $data->kode_asset;
                                        $insert_data['put'] = "UpdateAssetCSV";
                                        
                                    }
                                    $insert_data['kode'] = $kode;
                                    $tampil = json_decode($this->client->simple_put(API_UMKM, $insert_data));
                                    
                                    $update = $update + 1;
                                }else{
                                    echo "Data Kosong";
                                }
                            }
                            
                        }
                    }
                    
                }
                

                unlink(FCPATH . 'Data/' . $file_data['file_name']);
                $this->session->set_flashdata('statusUMKM', 'sukses');
                $this->session->set_flashdata('dataHasilUMKM', 'Berhasil Upload CSV, '.$insert." Data UMKM Tersimpan dan ".$update." Data Terupdate.");
                redirect('DataUMKM');
            } else{
                $this->session->set_flashdata('statusUMKM', 'gagal');
                $this->session->set_flashdata('dataHasilUMKM', "Data CSV Gagal Terupload.");
                redirect('DataUMKM');
            }
        }else{
            $this->session->set_flashdata('statusUMKM', 'gagal');
            $this->session->set_flashdata('dataHasilUMKM', "File CSV yang dimasukan salah.");
            redirect('DataUMKM');
        }
    }


    public function DetailUMKM()
    {
        if (isset($_SESSION['kode'])) {
            if (isset($_SESSION['kodeUMKM'])){
                $kode = $_SESSION['kode'];
                $tampil = json_decode($this->client->simple_get(API_User, array("kode" => $kode)));
                foreach ($tampil->data as $data) {
                    $detail['NamaPengguna'] = $data->nama_dtl;
                    $detail['FotoPengguna'] = $data->foto_dtl;
                    $detail['Judul'] = "Informasi UMKM";
                };
                $kodeAset['kodeAset'] = $_SESSION['kodeUMKM'];
                $kodeAset['get'] = "dataUMKM";
                $detailUMKM = json_decode($this->client->simple_get(API_UMKM, $kodeAset));
                foreach ($detailUMKM->data as $data) {
                    $tampilUMKM['time'] =  date("d-M-Y H:i:s",strtotime($data->time));
                    $tampilUMKM['namaOwner'] =  $data->namaOwner;
                    $tampilUMKM['nik'] =  $data->nik;
                    $tampilUMKM['email'] =  $data->email;
                    $tampilUMKM['nohp'] =  $data->noHP;
                    $tampilUMKM['alamatPemilik'] =  $data->alamatRumah;
                    $tampilUMKM['namaUMKM'] =  $data->namaUMKM;
                    $tampilUMKM['nib'] =  $data->nib;
                    $tampilUMKM['alamatUsaha'] =  $data->alamatUsaha;
                    $tampilUMKM['tahunBerdiri'] =  $data->tahunBerdiri;
                    $tampilUMKM['jenis'] =  $data->jenisUsaha;
                    $tampilUMKM['legalitas'] =  $data->legalitas;
                    $tampilUMKM['modalMandiri'] =  $data->pemodalanMandiri;
                    $tampilUMKM['modalLuar'] =  $data->pemodalanLuar;
                    $tampilUMKM['pemasaranOn'] =  $data->pemasaranOnline;
                    $tampilUMKM['pemasaranOff'] =  $data->pemasaranOffline;
                    $tampilUMKM['mitra'] =  $data->mitra;
                    $tampilUMKM['tahunBinaan'] =  $data->tahunBinaan;
                    $tampilUMKM['kegiatan'] =  $data->kegiatanUsaha;
                };

                $detail['administrator'] = $_SESSION['level'];

                $this->load->view('Template/header', $detail);
                $this->load->view('Main/DetailUMKM',$tampilUMKM);
                $this->load->view('Template/footer');
            }else{
                redirect("DataUMKM");
            }
        } else {
            redirect("Login");
        }
    }

    //set session umkm
    public function SetSessionUMKM()
    {
        $kode = $this->input->post("kodeAset");
        $this->session->set_userdata('kodeUMKM', $kode);
        redirect("DataUMKM/DetailUMKM");
    }
    
    //update bagian biodata pemilik
    public function UpdateBiodata()
    {
        if (isset($_SESSION['kodeUMKM'])){
            $updateData['kode'] = $_SESSION['kodeUMKM'];
            $updateData['namaOwner'] = $this->input->post('inputNamaOwner');
            $updateData['nik'] = $this->input->post('inputNik');
            $updateData['alamatRumah'] = $this->input->post('textAreaAlamatPemilik');
            $updateData['noHP'] = $this->input->post('inputNohp');
            $updateData['email'] = $this->input->post('inputemail');
            $updateData['time'] = date("Y-m-d H:i:s", time());
            $updateData['put'] = 'UpdateBiodataPemilik';
            $kodeP = $_SESSION['kode'];
            $updateData['kodeP'] = $kodeP;

            $hasil = json_decode($this->client->simple_put(API_UMKM, $updateData));
            if(isset($hasil)){
                if ($hasil->status == true){
                    $this->session->set_flashdata('statusUpdateUmkm', 'sukses');
                    $this->session->set_flashdata('dataUpdate', "Biodata Owner Berhasil Di Perbarui");
                    redirect('DataUMKM/DetailUMKM');
                }else{
                    $this->session->set_flashdata('statusUpdateUmkm', 'gagal');
                    $this->session->set_flashdata('dataUpdate', "Biodata Owner Tidak ada yang Di Perbarui.");
                    redirect('DataUMKM/DetailUMKM');
                }
            }
        }else{
            redirect("DataUMKM");
        }
    }

    //update bagian Tentang UMKM
    public function UpdateUMKM()
    {
        if (isset($_SESSION['kodeUMKM'])){
            $kodeP = $_SESSION['kode'];
            $updateData['kodeP'] = $kodeP;
            $updateData['kode'] = $_SESSION['kodeUMKM'];
            $updateData['namaUMKM'] = $this->input->post('inputNamaUmkm');
            $updateData['nib'] = $this->input->post('inputNIB');
            $updateData['alamatUsaha'] = $this->input->post('textAreaAlamatUkm');
            $updateData['tahunBerdiri'] = $this->input->post('inputTahunBerdiri');
            $updateData['jenisUsaha'] = $this->input->post('inputJenis');
            $updateData['legalitas'] = $this->input->post('textAreaLegal');
            $updateData['pemodalanMandiri'] = $this->input->post('inputModalMandiri');
            $updateData['pemodalanLuar'] = $this->input->post('inputModalLuar');
            $updateData['pemasaranOnline'] = $this->input->post('inputPemasaranOn');
            $updateData['pemasaranOffline'] = $this->input->post('inputPemasaranOff');
            $updateData['mitra'] = $this->input->post('inputMitra');
            $updateData['tahunBinaan'] = $this->input->post('inputTahunBinaan');
            $updateData['kegiatan'] = $this->input->post('textAreaKegiatan');
            $updateData['time'] = date("Y-m-d H:i:s", time());
            $updateData['put'] = "UpdateTentangUKM";
            $hasil = json_decode($this->client->simple_put(API_UMKM, $updateData));
            if(isset($hasil)){
                if ($hasil->status == true){
                    $this->session->set_flashdata('statusUpdateUmkm', 'sukses');
                    $this->session->set_flashdata('dataUpdate', "Data UMKM Berhasil Di Perbarui");
                    redirect('DataUMKM/DetailUMKM');
                }else{
                    $this->session->set_flashdata('statusUpdateUmkm', 'gagal');
                    $this->session->set_flashdata('dataUpdate', "Data UMKM Tidak ada yang Di Perbarui.");
                    redirect('DataUMKM/DetailUMKM');
                }
            }
        }else{
            redirect("DataUMKM");
        }
    }

    public function UpdateAsset()
    {
        if (isset($_SESSION['kodeUMKM'])){
            $kodeP = $_SESSION['kode'];
            $UpdateAsset['kodeP'] = $kodeP;
            $UpdateAsset['kode'] = $_SESSION['kodeUMKM'];
            $UpdateAsset['tahun'] = $this->input->post('inputtahunAsset');
            $UpdateAsset['aset'] = $this->input->post('inputAset');
            $UpdateAsset['omzet'] = $this->input->post('inputOmzet');
            $UpdateAsset['pekerja'] = $this->input->post('inputPekerja');
            $UpdateAsset['get'] ="getAssetData";
            $ambilData = json_decode($this->client->simple_get(API_UMKM, $UpdateAsset));
                if($ambilData->status == false){
                    $UpdateAsset['post'] = "insertDataAsset";
                    $tambahData = json_decode($this->client->simple_post(API_UMKM, $UpdateAsset));
                    if ($tambahData->status == true){
                            $this->session->set_flashdata('statusUpdateUmkm', 'sukses');
                            $this->session->set_flashdata('dataUpdate', "Data Asset UMKM Berhasil Di Tambah");
                            redirect('DataUMKM/DetailUMKM');
                        }else{
                            $this->session->set_flashdata('statusUpdateUmkm', 'gagal');
                            $this->session->set_flashdata('dataUpdate', "Data Asset UMKM Tidak ada yang Di Tambah.");
                            redirect('DataUMKM/DetailUMKM');
                        }
                }else{
                    $UpdateAsset['put'] = "UpdateAssetUKM";
                    $hasil = json_decode($this->client->simple_put(API_UMKM, $UpdateAsset));
                    if(isset($hasil)){
                        if ($hasil->status == true){
                            $this->session->set_flashdata('statusUpdateUmkm', 'sukses');
                            $this->session->set_flashdata('dataUpdate', "Data Asset UMKM Berhasil Di Perbarui");
                            redirect('DataUMKM/DetailUMKM');
                        }else{
                            $this->session->set_flashdata('statusUpdateUmkm', 'gagal');
                            $this->session->set_flashdata('dataUpdate', "Data Asset UMKM Tidak ada yang Di Perbarui.");
                            redirect('DataUMKM/DetailUMKM');
                        }
                    }
                }
        }else{
            redirect("DataUMKM");
        }
    }

    public function GetAsset()
    {
        $kirim['tahun'] = $this->input->post('tahun');
        $kirim['get'] = 'getAssetData';
        $kirim['kode'] = $_SESSION['kodeUMKM'];
        $asset = json_decode($this->client->simple_get(API_UMKM, $kirim));
        if(isset($asset)){
            if($asset->status==false){
                $tampilAset['status'] = false;
                echo json_encode($tampilAset);
            }else{
                foreach ($asset->data as $data) {
                $tampilAset['aset'] = $data->asset;
                $tampilAset['omzet'] = $data->omzet;
                $tampilAset['pekerja'] = $data->tenagaKerja;
                }
                $tampilAset['status'] = true;
                echo json_encode($tampilAset);
            }
        }else{
            $tampilAset['status'] = false;
            echo json_encode($tampilAset);
        }
    }

    public function tambahDataUMKM()
    {
        $kodeP = $_SESSION['kode'];
        $addData['kodeP'] = $kodeP;
        $addData['time'] = date("Y-m-d H:i:s", time());
        $addData['nama'] = $this->input->post('namaOwner');
        $addData['email'] = $this->input->post('email');
        $addData['nohp'] = $this->input->post('nohp');
        $addData['namaUMKM'] = $this->input->post('namaUKM');
        $addData['alamat'] = $this->input->post('alamat');
        $addData['kegiatan'] = $this->input->post('kegiatan');
        $addData['get'] = "getNamaUMKM";
        $cek = json_decode($this->client->simple_get(API_UMKM, $addData));
        if($cek->status == true){
            echo "gagal";
        }else{
            $addData['post'] = "AddDataUKM";
            $hasil = json_decode($this->client->simple_post(API_UMKM, $addData));
            if(isset($hasil)){
                if($hasil->status == true){
                    echo "sukses";
                }else{
                    echo "gagal";
                }
            }
        }
    }

    public function DeleteUKM()
    {
        if (isset($_SESSION['kodeUMKM'])){
            $hapusData['kode'] = $_SESSION['kodeUMKM'];
            $hapusData['delete'] = "hapusUKM";
            $kodeP = $_SESSION['kode'];
            $hapusData['kodeP'] = $kodeP;

            $respon = json_decode($this->client->simple_delete(API_UMKM, $hapusData));
            if($respon->status == true){
                $this->session->set_flashdata('statusUMKM', 'sukses');
                $this->session->set_flashdata('dataHasilUMKM', 'Berhasil Menghapus Data UKM.');
                redirect('DataUMKM');
            }else{
                $this->session->set_flashdata('statusUpdateUmkm', 'gagal');
                $this->session->set_flashdata('dataUpdate', "Data UMKM gagal Di Hapus.");
                redirect('DataUMKM/DetailUMKM');
            }
        }
    }

    public function SearchUMKM()
    {
        $kirim['get'] = "getSearchUMKM";
        $kirim['namaOwner'] = $this->input->POST('search');
        $kirim['namaUKM'] = $this->input->POST('search');

        $hasil = json_decode($this->client->simple_get(API_UMKM, $kirim));
        if($hasil->status == false){
            echo false;
        }else{
            echo json_encode($hasil);
        }
        
    }
    
}


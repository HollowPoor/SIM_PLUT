<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/Format.php';
require_once APPPATH . 'libraries/RestController.php';

class laporan extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User', 'MU');
    }

    public function index_get()
    {
        if($this->get('get')== "getNamaPendamping"){
            $data = $this->MU->GetNamaUser();
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
        }else if ($this->get('get')=="getDetailKegiatan") {
            $kode = $this->get('kodeP');
            $tahun = $this->get('tahun');
            $bulan = $this->get('bulan');
            $data = $this->MU->GetLaporanKegiatanDetail($kode,$tahun,$bulan);
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
            
        }else if ($this->get('get')=="getLaporan") {
            $awl = $this->get('tahunAwl');
            $akr = $this->get('tahunAkhr');
            $data = $this->MU->GetDataLaporanUMKM($awl,$akr);
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
}
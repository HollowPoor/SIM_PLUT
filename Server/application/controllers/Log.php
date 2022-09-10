<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/Format.php';
require_once APPPATH . 'libraries/RestController.php';

class log extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User', 'MU');
    }

    public function index_get()
    {
        if($this->get('get')== "getLogAktivitas"){
            $kode = $this->get('kode');
            $tahun = $this->get('tahun');
            $bulan = $this->get('bulan');
            $data = $this->MU->GetLogUser($kode,$bulan,$tahun);
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
        }elseif ($this->get('get') == "getCount") {
            $kode = $this->get('kode');
            $data = $this->MU->GetCounts($kode);
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
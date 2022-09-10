<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require_once 'vendor/dompdf/autoload.inc.php';

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library(array("client"));
        $this->load->model('MLogin');
        $this->load->helper(array("url"));
        
        
        
    }
    
    public function LaporanKegiatan()
    {

        $dompdf = new Dompdf();

        $kirim['kodeP']=  $this->input->post('inputPendamping');
        $tanggal =  $this->input->post('cariBulanLaporanKegiatan');
        $kirim['tahun'] =  date("Y", strtotime($tanggal));
        $kirim['bulan'] =  date("m", strtotime($tanggal));
        $kirim['get'] =  "getDetailKegiatan";
        $getPengguna = json_decode($this->client->simple_get(API_User, array("kode" => $kirim['kodeP'])));
            foreach ($getPengguna->data as $data) {
                $setData['namaPengguna'] = $data->nama_dtl;
                $setData['bidang'] = $data->jabatan_dtl;
            }
        $getData = json_decode($this->client->simple_get(API_Laporan, $kirim));
        $setData['print'] = $getData->data;
        $this->load->view('Print/CetakLaporanKegiatan',$setData);
        $cetak = $this->output->get_output();
        $dompdf->loadHtml($cetak);

        // (Optional) Setup the paper size and orientation

        $dompdf->setPaper('F4', 'potrait');
        
        // Render the HTML as PDF
        $dompdf->render();

        setlocale(LC_ALL, 'IND');
        $namaBulan = strftime("%B",strtotime($tanggal));
        // Output the generated PDF to Browser
        $dompdf->stream("Laporan-".$setData['namaPengguna']."-".$namaBulan."-".$kirim['tahun'].".pdf");

    }

    public function LaporanExcleUMKM()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $tanggal = $this->input->post('inputtahunDataExcle');
        $kirim['get'] = "getLaporan";
        $kirim['tahunAwl'] = $tanggal;
        $kirim['tahunAkhr'] = $tanggal+1;
        $getData = json_decode($this->client->simple_get(API_Laporan, $kirim));

        //setLebar Kolom
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(24.14);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20.86);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(19.43);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15.57);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(14.57);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(17.71);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(23.57);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(13.71);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(11.14);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(11.14);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(13.14);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(13.43);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(16.29);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(13.71);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(11.14);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(11.14);
        
        $sheet->getRowDimension('1')->setRowHeight(34.50);
        $sheet->getRowDimension('2')->setRowHeight(26.25);
        $sheet->getRowDimension('4')->setRowHeight(30);
        $sheet->getRowDimension('5')->setRowHeight(30);

            $styleHeader = [
                    'font' => [
                        'name' => "Times New Roman",
                        'size' => 18,
                    ],
                ];
                $sheet->getStyle('A1:A2')->applyFromArray($styleHeader);
                
                $styleLabel = [
                        'font' => [
                            'name' => "Times New Roman",
                            'size' => 11,
                        ],
                    ];
                
        $sheet->getStyle('A4:R5')->applyFromArray($styleLabel);
        $sheet->getStyle('A1:R5')->getAlignment()
                ->setHorizontal('center')
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('A1', 'DAFTAR UMKM BINAAN PLUT-KUMKM');
        $sheet->mergeCells('A1:R1');
        
        $sheet->setCellValue('A2', 'TAHUN '.$tanggal."-".$tanggal+1);
        $sheet->mergeCells('A2:R2');
        
        $sheet->setCellValue('A4', 'No');
        $sheet->mergeCells('A4:A5');

        $sheet->setCellValue('B4', 'Nama');
        $sheet->mergeCells('B4:D4');
        
        $sheet->setCellValue('B5', 'Pemilik');
        $sheet->setCellValue('C5', 'NIK');
        $sheet->setCellValue('D5', 'Merk Usaha');
        
        $sheet->setCellValue('E4', 'Nomor Induk Berusaha (NIB)');
        $spreadsheet->getActiveSheet()->getStyle('E4')->getAlignment()->setWrapText(true);
        $sheet->mergeCells('E4:E5');
        
        $sheet->setCellValue('F4', 'HP');
        $sheet->mergeCells('F4:F5');
        
        $sheet->setCellValue('G4', 'Email');
        $sheet->mergeCells('G4:G5');
        
        $sheet->setCellValue('H4', 'Sosial Media (FB,IG,dsb)');
        $spreadsheet->getActiveSheet()->getStyle('H4')->getAlignment()->setWrapText(true);
        $sheet->mergeCells('H4:H5');
        
        $sheet->setCellValue('I4', 'Sertifikasi Produk Yang Dimiliki');
        $spreadsheet->getActiveSheet()->getStyle('I4')->getAlignment()->setWrapText(true);
        $sheet->mergeCells('I4:I5');
        
        $sheet->setCellValue('J4', 'Bidang Usaha');
        $sheet->mergeCells('J4:J5');
        
        $sheet->setCellValue('K4', 'Tahun Berdiri');
        $sheet->mergeCells('K4:K5');
        
        $sheet->setCellValue('L4', 'Tahun Menjadi Binaan PLUT');
        $spreadsheet->getActiveSheet()->getStyle('L4')->getAlignment()->setWrapText(true);
        $sheet->mergeCells('L4:L5');
        
        $sheet->setCellValue('M4', 'Aset (Rp)');
        $sheet->mergeCells('M4:N4');
        
        $sheet->setCellValue('O4', 'Omset (Rp)');
        $sheet->mergeCells('O4:P4');
        
        $sheet->setCellValue('Q4', 'Tenaga Kerja (Orang)');
        $sheet->mergeCells('Q4:R4');
        
        $sheet->setCellValue('M5', $tanggal);
        $sheet->setCellValue('N5', $tanggal+1);
        $sheet->setCellValue('O5', $tanggal);
        $sheet->setCellValue('P5', $tanggal+1);
        $sheet->setCellValue('Q5', $tanggal);
        $sheet->setCellValue('R5', $tanggal+1);

        $i = 1;
        $awal = 6;
        foreach($getData->data as $data){
            $sheet->setCellValue('A'.$awal, $i);
            $sheet->setCellValue('B'.$awal, $data->namaOwner);
            $sheet->setCellValue('C'.$awal, $data->nik);
            $sheet->setCellValue('D'.$awal, $data->namaUMKM);
            $sheet->setCellValue('E'.$awal, $data->nib);
            $sheet->setCellValue('F'.$awal, $data->noHP);
            $sheet->setCellValue('G'.$awal, $data->email);
            $sheet->setCellValue('H'.$awal, $data->pemasaranOnline);
            $sheet->setCellValue('I'.$awal, $data->legalitas);
            $sheet->setCellValue('J'.$awal, $data->jenisUsaha);
            $sheet->setCellValue('K'.$awal, $data->tahunBerdiri);
            $sheet->setCellValue('L'.$awal, $data->tahunBinaan);
            $sheet->setCellValue('M'.$awal, $data->asset1);
            $sheet->setCellValue('N'.$awal, $data->asset2);
            $sheet->setCellValue('O'.$awal, $data->omzet1);
            $sheet->setCellValue('P'.$awal, $data->omzet2);
            $sheet->setCellValue('Q'.$awal, $data->pekerja1);
            $sheet->setCellValue('R'.$awal, $data->pekerja2);
            $awal++;
            $i++;
        }

        $styleArray = [
    'font' => [
        'name' => "Times New Roman",
        'size' => 11,
        ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            
        ],
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
            
        ],
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
            
        ],
        'left' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
            
        ],
        'right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
            
        ],
    ],
];

        $sheet->getStyle(
    'A4:' .
    $sheet->getHighestColumn() .
    $sheet->getHighestRow()
    )->applyFromArray($styleArray);

        $sheet->getStyle(
    'A4:' .
    "L" .
    $sheet->getHighestRow()
    )->getNumberFormat()
    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);;

        $writer = new Xlsx($spreadsheet);
		$filename = 'Laporan UMKM Tahun '.$tanggal."-".$tanggal+1;
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output');

        exit();
    }
}
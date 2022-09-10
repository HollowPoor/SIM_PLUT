<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- membuat card -->
    <div class="card">
        <div class="card-header p-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto card-header-tabs nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active navLaporanPendamping" id="navLaporanPendamping" href="#">Laporan Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navLaporanUKM" id="navLaporanUKM" href="#">Laporan UMKM</a>
                    </li>
                </ul>
            </div>
            </nav>   
        </div>

            <!-- halaman Laporan Kegiatan -->
            <div class="card p-3" id="cardLaporanPendamping" style="max-width: 100%; ">
                <form action="<?= base_url("Laporan/LaporanKegiatan"); ?>" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPendamping">Nama Pendamping</label>
                        <select class="form-control custom-select" id="inputPendamping" name="inputPendamping">
                            <option value="" disabled selected>Pilih Nama Pendamping</option>
                        </select>
                        </div>
                        <div class="form-group col-md-6">
                        <label for="cariBulanLaporanKegiatan">Tanggal Kegiatan</label>
                        <input type="month" class="form-control" id="cariBulanLaporanKegiatan" name="cariBulanLaporanKegiatan" value="" readonly> </br>
                        </div>
                    </div>
                    
                    <div class="card mb-2" id="cards" style=" padding : 5px; height: 250px;  overflow-y: scroll; ">
                    <div class="d-flex justify-content-between m-1">
                        <strong>Daftar Data Kegiatan Pendamping</strong>
                    </div>
                    <!-- tampilan table -->
                    <table class="table table-striped tableLaporanKegiatan" id="tableLaporanKegiatan">
                        <thead class ="h6">
                            <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama UKM</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Permasalahan</th>
                            <th scope="col">Program Kerja</th>
                            <th scope="col">Materi Pendampingan</th>
                            <th scope="col">Skema Tindakan Lebih Lanjut</th>
                            </tr>
                        </thead>
                        <tbody class="tbLaporanKegiatan" id= "tbLaporanKegiatan" name = "tbLaporanKegiatan">
                            <tr>
                                <th class="text-center" colspan="7">Silahkan Pilih Tanggal Kegiatan</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    <button type="submit" value="Submit" class="btn btn-primary float-right ml-3" id="btnCektakLaporan" target="_blank" disabled>Cetak Laporan</button>
                </form>
            </div>
            <!-- End Card Laporan Kegiatan -->

            <!-- halaman Laporan UMKM -->
            <div class="card p-2" id="cardLaporanUmkm" style="max-width: 100%; display:none; ">
                <form class = "card p-1" action="<?= base_url('Laporan/LaporanExcleUMKM');?>" method="post">
                <!-- card view untuk upload dan input data umkm -->
                <div>
                    <div class="col-sm">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Export Data UMKM Dengan Format Excle</h5>
                            <p class="card-text">Silahkan Pilih Tahun UMKM Yang Akan Di Export Menjadi Excle.</p>
                            <div class="btn-row">
                            <select class="custom-select custom-select-sm " style="max-width: 20%;" id="inputtahunDataExcle" name="inputtahunDataExcle">
                                <option value="" disabled selected>Pilih Tahun Asset</option>
                            </select>
                            <button type="submit" id="btnCetakExcle" class="btn btn-success float-right" disabled>Cetak Excle</button>
                            <span id="txtKeterangan" style="padding-left:10px;">*Silahkan Pilih Tahun Export File </span>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                </form>

                <div class="card mb-1" id="cards" style="max-width: 100%;margin-top:10px; padding : 10px; height: 245px; overflow-y: scroll; ">
        <!-- membuat tombol search -->
        <div class="d-flex justify-content-between m-2">
            <strong>Daftar Data UMKM</strong>

        </div>
        <!-- tampilan table -->
        <table class="table table-striped" id="tablePengguna">
            <thead>
                <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama Owner</th>
                <th scope="col">Nama UMKM</th>
                <th scope="col">Alamat</th>
                <th scope="col">No Hp</th>
                <th scope="col">Aksi</th>
                </tr>
            </thead>
            <?php $i = 1;?>
            <?php foreach ($umkm as $p): ?>
            <tbody>
                <tr>
                <th scope="row"><?=$i?></th>
                <td style="max-width: 100px;"><?= $p->namaOwner;?></td>
                <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;"><?= $p->namaUMKM; ?></td>
                <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;"><?= $p->alamatUsaha; ?></td>
                <td style="max-width: 150px;"><?= $p->noHP; ?></td>

                <td>
                    <button type="button" class="btn btn-primary btnDetailUMKM" data-kode="<?= $p->kode_asset;?>" 
                        >Detail</button>
                    <button type="button" class="btn btn-success" >Hubungi Via Whatsapp</button>
                </td>
                <?php $i++?>
                </tr>
            </tbody>
            <?php endforeach;?>
        </table>
    </div>

                
                </form>
            </div>
    </div>
    <!-- End Card element -->
</div>
<!-- End of Main Content -->

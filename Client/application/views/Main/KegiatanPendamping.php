<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card" id="cards" style="max-width: 100%; padding : 10px">
            <!-- card view untuk upload dan input data umkm -->
            <?php if ($this->session->flashdata('statusKegiatan') == "sukses") {?>
            <!-- alert Jika Data Berhasil Di Upload -->
            <div class="alert alert-success d-flex align-items-center" id="successUMKM"role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                    &nbsp; <?=$this->session->flashdata('dataUpdate')?>.
                </div>
            </div>
            <?php } else if ($this->session->flashdata('statusKegiatan') == "gagal") {?>
            <!-- alert jika data gagal tersimpan -->
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    &nbsp; <?=$this->session->flashdata('dataUpdate')?>.
                </div>
            </div>
            <?php }?>
            <div class="card-header p-0">
            <nav class="navbar navbar-expand-lg navbar-light">
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto card-header-tabs nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active navKelola" id="navKelola" href="#">Kelola Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navJadwal" id="navJadwal" href="#">Buat Jadwal Kegiatan</a>
                    </li>
                </ul>
            </div>
            </nav>   
        </div>
        <!-- Halaman Kelola Kegiatan -->
        <div class="card" id="cardKelolaKegiatan" style="padding: 5px; ">
            <div class="row" style="padding-top: 5px;">
                <div class="col-sm-5">
                    <div class="card mb-2"  style="max-width: 500px;">
                        <div class="row g-0 p-0">
                            <div class="col-md-3 p-1">
                            <img src="<?=base_url("assets")?>/img/profil_img/<?=$FotoPengguna; ?>" width="60" height="60" class="rounded-circle mx-auto d-block m-3" alt="...">
                            </div>
                            <div class="col-md-8 p-0">
                                <div class="card-body pl-0">
                                    <h5 class="card-title"> <strong><?= $NamaPengguna ?></strong></h5>
                                    <p class="card-text">Bidang <?= $Jabatan ?>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-1" id="cards" style=" padding : 10px;  overflow-y: scroll; ">
                        <h7>Pilih Bulan</h7>
                        <input type="month" class="form-control" id="cariBulanKegiatan" name="cariBulanKegiatan" value="<?= date("Y-m", time()); ?>"> </br>
                        <div class="d-flex justify-content-between m-1">
                            <strong>Daftar Data Kegiatan</strong>
                        </div>
                        <!-- tampilan table -->
                        <table class="table table-striped tableKegiatan" id="tableKegiatan">
                            <thead class ="h6">
                                <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama UMKM</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <?php $i=1;?>
                            <?php if($status == true){?>
                                <?php foreach ($kegiatan as $k):?>
                                <tbody class="tbKegiatan" id= "tbKegiatan" name = "tbKegiatan">
                                    <tr>
                                    <th scope="row"><?= $i?></th>
                                    <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;"><?= $k->namaUKM;?></td>
                                    <td style="max-width: 150px;"><?php echo date("d-m-Y", strtotime($k->tanggal))?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btnDetailKegiatan" data-kode="<?= $k->kode_kegiatan?>" 
                                            >Detail</button>
                                    </td>
                                    </tr>
                                </tbody>
                                <?php $i++;?>
                                <?php endforeach;?>
                                <?php }else{ ?>
                                    <tbody class="tbKegiatan" id= "tbKegiatan" name = "tbKegiatan">
                                        <tr>
                                        <th class="text-center" colspan="4">Belum Memiliki Kegiatan</th>
                                        </tr>
                                    </tbody>
                            <?php }?>
                        </table>
                    </div>
                </div>
                <!-- card sisi sebelah kanan -->
                <div class="col-sm-7">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kegiatan Pendampingan</h5>
                            <p class="card-text fs-3">Untuk Mempermudah pengarsipan data maka pendamping dapat menginputan hasil pendampingan ukm dengan mengeklik tombol tambah kegiatan di bawah.</p>
                            <!-- <form method="post" > -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-primary tambahKegiatan" type="button">Tambah Kegiatan Pendampingan</button>
                            </div>
                        </div>
                        <form action="<?= base_url("DataKegiatan/TambahKegiatan"); ?>" method="post">
                        <div class="card m-1 cardKegiatan" id="cardKegiatan" style="display:none;">
                            <div class="card-body" id="card-bodyKeg">
                                <div class="mb-3">
                                    <span><strong  class="judulKegiatan">Detail Kegiatan</strong></span>
                                </div>
                                    <hr class="sidebar-divider"> 
                                    <div class="form-group">
                                        <label for="Form1">Nama UMKM</label>
                                        <input type="text" class="form-control" id="nama_ukm" name="nama_ukm">
                                        <?=form_error('nama_ukm', '<small class="text-danger pl-3">', '</small>');?>
                                    </div>
                                    <div class="form-group">
                                        <label for="form1">Identifikasi Permasalahan</label>
                                        <textarea class="form-control" id="permasalahan" name="permasalahan" rows="3" ></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="form1">Program Kerja</label>
                                        <textarea class="form-control" id="programKerja" name="programKerja" rows="3" ></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="Form1">Tanggal</label>
                                        <input class="form-control" placeholder="dd-mm-yyyy" type="date" id="tglKegiatan" name="tglKegiatan"
                                            value="<?= date("Y-m-d", time()); ?>" 
                                            min="2018-01-01">
                                    </div>
              
                                    <div class="form-group">
                                        <label for="form1">Materi Pendampingan</label>
                                        <textarea class="form-control" id="materi" name="materi" rows="3" ></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="form1">Skema Tindak Lanjut</label>
                                        <textarea class="form-control" id="skema" name="skema" rows="3" ></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btnSimpanKegiatan" id="btnSimpanKegiatan" style="display:;">Simpan</button>
                                    <button type="submit" class="btn btn-success" id="btnUpdateKegiatan" formaction="<?= site_url("DataKegiatan/UpdateKegiatan");?>" style="display:;" >Perbarui</button>
                                    <button type="submit" class="btn btn-danger" id="btnHapusKegiatan" formaction="<?= site_url("DataKegiatan/HapusKegiatan");?>" style="display:;">Hapus</button>
    
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
    
                </div>
            </div>
        </div>

        <!-- Halaman Membuat Jadwal -->
        <div class="card" id="cardJadwalKegiatan" style="padding: 5px; display:none;">
            <div class="row" style="">
                <div class="col-sm-5">
                    <div class="card mb-2"  style="max-width: 500px;">
                        <div class="row g-0 p-0">
                            <div class="col-md-3 p-3">
                            <img src="<?=base_url("assets")?>/img/profil_img/<?=$FotoPengguna; ?>" width="60" height="60" class="rounded-circle mx-auto d-block m-3" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body pl-0">
                                    <h5 class="card-title"> <strong><?= $NamaPengguna ?></strong></h5>
                                    <p class="card-text"><?= $email ?></p>
                                    <p class="card-text">Bidang <?= $Jabatan ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card sisi sebelah kanan -->
                <div class="col-sm-7">
                    <div class="card">
                        <div class="card-body" style="max-height:140px;">
                            <h5 class="card-title">Tambah Jadwal Kegiatan</h5>
                            <p class="card-text fs-3">Silahkan Buat Jadwal Sebagai Pengingat Ke Email Anda.</p>
                            <!-- <form method="post" > -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-primary buatJadwalKegiatan" type="button">Tambah Jadwal Pendampingan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-2" id="cards" style="max-width: 110%; padding : 15px; height: 230px; overflow-y: scroll; ">
                <div class="d-flex justify-content-between m-2">
                    <strong>Jadwal Kegiatan Saya</strong>
                    <form class="form-inline">
                    </form>
                </div>
                <!-- tampilan table -->
                <table class="table table-striped" id="tablejadwal">
                    <thead>
                        <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama Kegiatan</th>
                        <th scope="col">Nama UMKM</th>
                        <th scope="col">Tanggal</th>
                        <th style="text-align:center" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <?php if($jadwalSts == false){?>
                        <tr>
                                <th class="text-center" colspan="5">Belum Ada Aktivitas</th>
                            </tr>
                    <?php }else{?>
                    <tbody>
                        <?php $i = 1;?>
                            <?php foreach ($Jadwal as $p): ?>
                                <tr>    
                                    <td scope="row"><?=$i;?></td>
                                    <td scope="row"><?=$p->NamaKegiatan;?></td>
                                    <td scope="row"><?=$p->NamaUMKM;?></td>
                                    <td scope="row"><?=$p->TanggalJadwal;?></td>
                                    <td style="text-align:center" scope="row">
                                        <button type="button" class="btn btn-danger btnHapusJadwal" data-toggle="modal" data-target="#hapusJadwal" 
                                        data-kodejadwal="<?= $p->id_jadwalkegiatan;?>" 
                                        data-kodep= "<?= $p->kode_pgn; ?>"  
                                        >Hapus</button>
                                    </td>
                                </tr>
                            <?php $i++?>
                            <?php endforeach;?>
                        
                    </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>

        <!-- modal untuk tambah Kegiatan -->
    <div class="modal fade" id="buatJadwalKegiatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="
                width: 650px;
                margin: auto;
                padding: 25px;
                " >
                <!-- pemberitahuan berhasil -->
                <div  class="alert alert-success d-flex align-items-center sr-only" id="ResponSuc"role="alert" >
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    <div class="ResponSuc"></div>
                </div>
                <!-- pemberitahuan ada yang kosong -->
                <div class="alert alert-warning d-flex align-items-center sr-only" role="alert" id="ResponWarn">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div class="ResponWarn"></div>
                </div>
                <!-- header modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat Jadwal Saya</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- body modal -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Form1">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="inputNamaKegiatan" name="inputNamaKegiatan" >
                        <small class="err_nama" style = "color : red;"></small>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputNamaUMKM">Nama UMKM</label>
                            <input type="email" class="form-control inputNamaUMKM" id="inputNamaUMKM" name="inputNamaUMKM" >
                            <small class="err_umkm" style = "color : red;"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputTgl">Tanggal Jadwal</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="dd-mm-yyyy" type="date" id="inputTgl" name="inputTgl"
                                            value="<?= date("Y-m-d", time()); ?>" 
                                            min="2018-01-01">
                            </div>
                            <small class="err_tgl" style = "color : red;"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="close" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary simpanJadwal">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal untuk menghapus kegiatan -->
    <div class="modal fade" id="hapusJadwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Jadwal</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah Anda Yakin Ingin Menghapus Jadwal Kegiatan ?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary btnModalJadwalHapus" type="button" data-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End of Main Content -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- membuat card -->
        <div class="card">
            <?php if ($this->session->flashdata('statusUpdateUmkm') == "sukses") {?>
            <!-- alert Jika Data Berhasil Di Upload -->
            <div class="alert alert-success d-flex align-items-center" id="successUMKM"role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                    &nbsp; <?=$this->session->flashdata('dataUpdate')?>.
                </div>
            </div>
            <?php } else if ($this->session->flashdata('statusUpdateUmkm') == "gagal") {?>
            <!-- alert jika data gagal tersimpan -->
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    &nbsp; <?=$this->session->flashdata('dataUpdate')?>.
                </div>
            </div>
            <?php }?>
            <div class="card-header p-0">

                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav mr-auto card-header-tabs nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active navBiodataPemilik" id="navBiodataPemilik" href="#">Biodata Pemilik</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link navTentangUMKM" id="navTentangUMKM" href="#">Tentang UMKM</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link navAsetUMKM" id="navAsetUMKM" href="#">Asset UMKM</a>
                            </li>
                        </ul>
                        <span class="navbar-text">
                        Data Terakhir di Update : <?= $time ?>
                        </span>
                    </div>
                </nav>
                
            </div>
            <!-- halaman biodata pemilik -->
            <div class="card p-2" id="cardBiodataPemilik" style="max-width: 100%; ">
                <form action="<?= base_url("DataUMKM/UpdateBiodata"); ?>" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputNamaOwner">Nama Owner</label>
                        <input type="text" class="form-control" id="inputNamaOwner" name = "inputNamaOwner" value="<?= $namaOwner ?>">
                        </div>
                        <div class="form-group col-md-6">
                        <label for="inputNik">NIK</label>
                        <input type="text" class="form-control" id="inputNik" name ="inputNik"value="<?= $nik ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputemail" name="inputemail" value="<?= $email ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNohp">No Handphone/ Whatsapp</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputNohp" >+62</span>
                                </div>
                                <input type="text" class="form-control" id="inputNohp" name = "inputNohp"value="<?= $nohp ?>" placeholder="No Handphone">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textAreaAlamatPemilik" >Alamat Pemilik</label>
                        <textarea class="form-control" id="textAreaAlamatPemilik" name = "textAreaAlamatPemilik"rows="2" ><?= $alamatPemilik?></textarea>
                    </div>
                    <button type="submit" value="Submit" class="btn btn-primary float-right ml-3">Simpan</button>
                    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#hapusUkmModal">Hapus Data</button>
                </form>
                
            </div>
            <!-- halaman tentang umkm -->
            <div class="card p-2" id="cardBiodataUmkm" style="max-width: 100%; display:none;">
                <form action="<?= base_url("DataUMKM/UpdateUMKM"); ?>" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputNamaUmkm">Nama UMKM</label>
                        <input type="text" class="form-control" id="inputNamaUmkm" name = "inputNamaUmkm"value="<?= $namaUMKM ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNIB">NOMOR INDUK BERUSAHA (NIB)</label>
                        <input type="text" class="form-control" id="inputNIB" name = "inputNIB" value="<?= $nib ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textAreaAlamatUkm">Alamat UMKM</label>
                        <textarea class="form-control" id="textAreaAlamatUkm" name="textAreaAlamatUkm" rows="2"><?= $alamatUsaha ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputTahunBerdiri">Tahun Berdiri</label>
                            <input type="text" class="form-control" id="inputTahunBerdiri" name="inputTahunBerdiri" value="<?= $tahunBerdiri ?>">
                        </div>
                        <div class="form-group col-md-6">
                        <label for="inputJenis">JENIS / BIDANG USAHA</label>
                        <input type="text" class="form-control" id="inputJenis" name="inputJenis" value="<?= $jenis ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textAreaLegal">LEGALITAS</label>
                        <textarea class="form-control" id="textAreaLegal" name="textAreaLegal" rows="2"><?= $legalitas ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputModalMandiri">Pemodalan Mandiri</label>
                            <input type="text" class="form-control" id="inputModalMandiri" name = "inputModalMandiri"value="<?= $modalMandiri ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputModalLuar">Pemodalan Luar</label>
                            <input type="text" class="form-control" id="inputModalLuar" name="inputModalLuar" value="<?= $modalLuar ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPemasaranOn">Pemasaran Produk Secara Online</label>
                            <input type="text" class="form-control" id="inputPemasaranOn" name ="inputPemasaranOn"value="<?= $pemasaranOn ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPemasaranOff">PEMASARAN PRODUK SECARA OFFLINE</label>
                            <input type="text" class="form-control" id="inputPemasaranOff" name="inputPemasaranOff" value="<?= $pemasaranOff ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputMitra">KERJASAMA / BERMITRA</label>
                            <input type="text" class="form-control" id="inputMitra" name="inputMitra"value="<?= $mitra ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputTahunBinaan">Tahun Menjadi Binaan PLUT</label>
                            <input type="text" class="form-control" id="inputTahunBinaan" name="inputTahunBinaan"value="<?= $tahunBinaan ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textAreaKegiatan">Kegiatan Usaha</label>
                        <textarea class="form-control" id="textAreaKegiatan" name= "textAreaKegiatan" rows="2"><?= $kegiatan ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success float-right">Simpan</button>
                </form>
            </div>

            <!-- halaman Asset UMKM -->
            <div class="card p-2" id="cardAsetUmkm" style="max-width: 100%; display:none; ">
                <form class = "card p-2" action="<?= base_url('DataUMKM/UpdateAsset');?>" method="post">
                <div class="form-inline">
                    <div class="form-group p-1">
                        <label for="inputtahunAsset">Tahun Asset    : &nbsp;</label>
                        <select class="custom-select custom-select-sm" id="inputtahunAsset" name="inputtahunAsset">
                            <option value="" disabled selected>Pilih Tahun Asset</option>
                        </select>
                    </div>
                </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="inputPekerja">Jumlah Tenaga Kerja</label>
                        <input type="text" class="form-control" id="inputPekerja" name = "inputPekerja">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="inputAset">Total Assset</label>
                        <input type="text" class="form-control" id="inputAset" name="inputAset">
                        </div>
                        <div class="form-group col-md-6">
                        <label for="inputOmzet">Total Omzet</label>
                        <input type="text" class="form-control" id="inputOmzet" name="inputOmzet">
                        </div>
                    </div>
                    <div class="btn-row">
                        <button type="submit" class="btn btn-success float-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- form untuk halaman data umkm   -->
        <!-- Logout Modal-->
        <div class="modal fade" id="hapusUkmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data UKM</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Apa Anda Ingin Mengapus Data UKM <?= $namaUMKM ?> ?.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="<?=base_url("dataUMKM/DeleteUKM");?>">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->
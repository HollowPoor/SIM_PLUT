<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- masukan ke dalem card -->
    <div class="card mb-3" id="cards" style="max-width: 100%; padding : 10px">
        <?php if ($this->session->flashdata('statusUMKM')=="sukses"){ ?>
        <!-- alert Jika Data Berhasil Di Upload -->
        <div class="alert alert-success d-flex align-items-center" id="successUMKM"role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                &nbsp; <?=$this->session->flashdata('dataHasilUMKM')?>.
            </div>
        </div>
        <?php }else if($this->session->flashdata('statusUMKM')=="gagal"){ ?>
        <!-- alert jika data gagal tersimpan -->
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
                &nbsp; <?=$this->session->flashdata('dataHasilUMKM')?>.
            </div>
        </div>
        <?php }?>
        <!-- card view untuk upload dan input data umkm -->
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Input Data UMKM Manual</h5>
                    <p class="card-text">Dapat Memasukan data umkm secara manual dengan memasukan data secara satu per satu kedalam database.</p>
                    <a href="#" class="btn btn-primary btnTambahUMKM">Tambah Data</a>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Upload Data .CSV UMKM</h5>
                        <p class="card-text">Untuk mempermudah penginputan, kita dapat memasukan data UMKM dengan Mengupload file .CSV dari Googleform.</p>
                        <form method="post" action="<?php echo base_url('DataUMKM/importCSV') ?>" enctype="multipart/form-data">
                        <div class="input-group ">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="csvUMKM" name="csvUMKM">
                                <label class="custom-file-label" for="csvUMKM">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" name="submit" data-target="#ModalLoading" data-toggle="modal" data-backdrop="static" >Upload</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-2" id="cards" style="max-width: 110%; padding : 15px; height: 260px; overflow-y: scroll; ">
        <!-- membuat tombol search -->
        <div class="d-flex justify-content-between m-2">
            <strong>Daftar Data UMKM</strong>
            <form class="form-inline">
            </form>
        </div>
        <!-- tampilan table -->
        <table class="table table-striped" id="tableUMKM">
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
            <tbody>
                <?php $i = 1;?>
                <?php foreach ($umkm as $p): ?>
                <tr>
                <th scope="row"><?=$i?></th>
                <td style="max-width: 100px;"><?= $p->namaOwner;?></td>
                <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;"><?= $p->namaUMKM; ?></td>
                <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;"><?= $p->alamatUsaha; ?></td>
                <td style="max-width: 150px;"><?= $p->noHP; ?></td>

                <td>
                    <button type="button" class="btn btn-primary btnDetailUMKM" data-kode="<?= $p->kode_asset;?>" 
                        >Detail</button>
                    <button type="button" onClick = "HubungiWa(this.value)" value="<?= $p->noHP; ?>" class="btn btn-success" >Hubungi Wa</button>
                </td>
                <?php $i++?>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalLoading" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex align-items-center">
                        <strong>Uploading Data UMKM, Mohon Tunggu Sebentar .......   </strong>
                        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal untuk tambah UMKM -->
    <div class="modal fade" id="tambahUMKM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data UMKM</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- body modal -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Form1">Nama Owner</label>
                        <input type="text" class="form-control" id="inputNamaOwner" name="inputNamaOwner" >
                        <small class="err_nama" style = "color : red;"></small>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail">Email</label>
                            <input type="email" class="form-control inputemails" id="inputemail" name="inputemail" >
                            <small class="err_email" style = "color : red;"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNohp">No Handphone/ Whatsapp</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputNohp" >+62</span>
                                </div>
                                <input type="text" class="form-control inputNohp" id="inputNohp" name ="inputNohp" placeholder="No Handphone">
                            </div>
                            <small class="err_nohp" style = "color : red;"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputNamaUmkm">Nama UMKM</label>
                            <input type="email" class="form-control" id="inputNamaUmkm" name="inputNamaUmkm" >
                            <small class="err_ukm" style = "color : red;"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAlamatUkm">Alamat</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="inputAlamatUkm" name = "inputAlamatUkm" >
                            </div>
                            <small class="err_alamat" style = "color : red;"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textAreaKegiatan" >Kegiatan Usaha</label>
                        <textarea class="form-control" id="textAreaKegiatan" name = "textAreaKegiatan"rows="2" ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="close" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary simpanukm">Simpan</button>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- End of Main Content -->

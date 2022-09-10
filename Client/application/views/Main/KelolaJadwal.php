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
                        <h5 class="card-title">Pilih Akun Pengguna</h5>
                        <p class="card-text">Untuk Mempermudah Pembuatan Jadwal Pendamping Harap Pilih Nama Pendamping Terlebih Dahulu.</p>
                        <select class="form-control custom-select" id="inputJadwalPendamping" name="inputJadwalPendamping">
                            <option value="" disabled selected>Pilih Nama Pendamping</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Membuat Jadwal Pendamping</h5>
                    <p class="card-text">Dapat Membuat Jadwal Pendamping, Kemudian Jadwal Akan Di Kirimkan Melalui Email Yang Terdaftar Pada Akun Pengguna.</p>
                    <button href="#" class="btn btn-primary btnTambahJadwalP" disabled>Tambah Kegiatan</button>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-2" id="cards" style="max-width: 110%; padding : 15px; height: 260px; overflow-y: scroll; ">
        <div class="d-flex justify-content-between m-2">
            <strong>Daftar Jadwal Pendamping</strong>
            <form class="form-inline">
            </form>
        </div>
        <!-- tampilan table -->
        <table class="table table-striped" id="tablejadwalpendamping">
                    <thead>
                        <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama Kegiatan</th>
                        <th scope="col">Nama UMKM</th>
                        <th scope="col">Tanggal</th>
                        <th style="text-align:center" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center" colspan="7">Silahkan Pilih Akun Pendamping</th>
                        </tr>
                    </tbody>
                </table>
    </div>

    <!-- modal tambah kegiatan Pengguna -->
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
                    <button class="btn btn-primary simpanJadwalK">Simpan</button>
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
                    <button class="btn btn-primary btnModalKelolaJadwalHapus" id="btnModalKelolaJadwalHapus" type="button" data-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- End of Main Content -->

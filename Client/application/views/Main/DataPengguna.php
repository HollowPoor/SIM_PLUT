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

<div class="container-fluid">
    <!-- card buka -->
    <div class="card mb-3" id="cards" style="max-width: 100%;">
        <!-- membuat alert saat hapus data -->
        <?php if ($this->session->flashdata()): ?>
        <div class="alert alert-warning d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 " width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
                <?=$this->session->flashdata('deletedPengguna');?>.
            </div>
        </div>
        <?php endif;?>
        <!-- membuat tombol search -->
        <div class="d-flex justify-content-between m-2">
            <button type="button" class="btn btn-success btnTambahPengguna">Tambah Pengguna</button>
            <form class="form-inline">
            <div class="form-group">
                <!-- search bar -->
                <label for="search">Search</label>
                <input type="text" id="search" class="form-control mx-sm-3" aria-describedby="passwordHelpInline">
            </div>
            </form>
        </div>

        <!-- mulai table -->
        <table class="table table-striped mr-md-3" id="tablePengguna">
            <thead>
                <tr>
                <th scope="col">No.</th>
                <th scope="col">Kode Pengguna</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">Tanggal Dibuat</th>
                <th scope="col">Status Akun</th>
                <th scope="col">Role</th>
                <th scope="col">Aksi</th>
                </tr>
            </thead>
            <?php $i = 1;?>
            <?php foreach ($pengguna as $p): ?>
            <tbody >
                <tr>
                <th scope="row"><?=$i?></th>
                <td><span id="kode"><?=$p->kode_dtl;?></span></td>
                <td><?=$p->nama_dtl;?></td>
                <td><?=$p->email_dtl;?></td>
                <td><?=date('d F Y', strtotime($p->DateCreated));?></td>
                <td><?php if ($p->status_dtl == true) {
    echo "Aktif";
} else {
    echo 'Tidak Aktif';
}?></td>
                <td>
                <?php if ($p->role_dtl == 1) {
    echo "Admin";
} else {
    echo 'Super Admin';
}?>
                </td>
                <td>
                    <button type="button" class="btn btn-primary editPengguna" id="editPengguna" data-toggle="modal" data-target="#editPenggunaModal"
                        data-kode="<?=$p->kode_dtl;?>"
                        data-email="<?=$p->email_dtl;?>"
                        data-password="<?=$p->password_dtl;?>"
                        data-status="<?=$p->status_dtl;?>"
                        data-lvl="<?=$p->role_dtl;?>"
                        >Edit</button>
                    <button type="button" class="btn btn-success lihatProfil" data-kode="<?=$p->kode_dtl;?>">Lihat Profil</button>
                </td>
                <?php $i++?>
                </tr>
            </tbody>
            <?php endforeach;?>
        </table>
        <!-- table selesai -->
    </div>
    <!-- card tutup -->

    <!-- modal untuk edit data -->
    <div class="modal fade" id="editPenggunaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Pengguna</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- body modal -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Form1">Kode</label>
                        <input type="text" class="form-control" id="kodePengguna" name="kodePengguna"  readonly>
                    </div>
                    <div class="form-group">
                        <label for="Form1">Email Pengguna</label>
                        <input type="email" class="form-control checkEmail" id="emailPengguna" name="emailPengguna" placeholder="name@example.com"  >
                        <small class="err_email" style = "color : red;"></small>
                        <small class="vld_email" style = "color : green;"></small>
                    </div>
                    <div class="form-group">
                        <label for="Form1">Password</label>
                        <input type="text" class="form-control" id="passwordPengguna" name="passwordPengguna" >
                        <small class="err_password" style = "color : red;"></small>
                    </div>
                    <div class="form-group">
                        <label for="Form1">Status Aktif</label>
                        <select class="form-select form-control form-select-sm" id="statusPengguna" name="statusPengguna" aria-label=".form-select-sm" selected>
                            <option value="9" selected>-Pilih Level Pengguna</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                        <small class="err_stats" style = "color : red;"></small>
                    </div>
                    <div class="form-group">
                        <label for="Form1">Level Pengguna</label>
                        <select class="form-select form-control form-select-sm" id="levelPengguna" name="levelPengguna" aria-label=".form-select-sm" selected>
                            <option value="9" selected>-Pilih Level Pengguna</option>
                                <option value="1" >Admin</option>
                                <option value="2" >Super Admin</option>
                            </select>
                        <small class="err_lvl" style = "color : red;"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="close" type="button" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger"  id="HapusPengguna"
                    data-nama="<?=$p->kode_dtl;?>"
                    data-email="<?=$p->email_dtl;?>"
                    >Hapus</button>
                    <button class="btn btn-primary simpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal untuk tambah Pengguna -->
    <div class="modal fade" id="tambahPengguna" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pengguna</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- body modal -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Form1">Kode</label>
                        <input type="text" class="form-control" id="kodeTbhPengguna" name="kodePengguna"  readonly>
                    </div>
                    <div class="form-group">
                        <label for="Form1">Email Pengguna</label>
                        <input type="email" class="form-control" id="emailTbhPengguna" name="emailPengguna" placeholder="name@example.com"  >
                        <small class="err_email" style = "color : red;"></small>
                        <small class="vld_email" style = "color : green;"></small>
                    </div>
                    <div class="form-group">
                        <label for="Form1">Password</label>
                        <input type="text" class="form-control" id="passwordTbhPengguna" name="passwordPengguna" >
                        <small class="err_password" style = "color : red;"></small>
                    </div>
                    <div class="form-group">
                        <label for="Form1">Status Aktif</label>
                        <select class="form-select form-control form-select-sm" id="statusTbhPengguna" name="statusPengguna" aria-label=".form-select-sm" selected>
                            <option value="9" selected>-Pilih Level Pengguna</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                        <small class="err_stats" style = "color : red;"></small>
                    </div>
                    <div class="form-group">
                        <label for="Form1">Level Pengguna</label>
                        <select class="form-select form-control form-select-sm" id="levelTbhPengguna" name="levelPengguna" aria-label=".form-select-sm" selected>
                            <option value="9" selected>-Pilih Level Pengguna-</option>
                                <option value="1" >Admin</option>
                                <option value="2" >Super Admin</option>
                            </select>
                        <small class="err_lvl" style = "color : red;"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="close" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary simpanpgn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hapus Modal-->
    <div class="modal fade" id="HapusPenggunaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title " id="exampleModalLabel">Apakah Anda Yakin Ingin Menghapus Data Pengguna ini ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Data dengan kode <strong id="kodeDel" name="kodeDel"></strong>, dan email <strong id="emailDel" name="emailDel"></strong> Akan Di hapus  </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal" data-toggle="modal">Batal</button>
                    <button class="btn btn-danger btnHapusPgn" type="button" data-dismiss="modal" data-toggle="modal">Hapus</button>

                </div>
            </div>
        </div>
    </div>
    <!-- modal ke edit Profil -->
    <div class="modal" tabindex="-1" role="dialog" id="simpanPengguna">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Berhasil Menambahkan Pengguna Baru!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Silahkan Update Terlebih Dahulu Data Pengguna.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" >Konfirmasi</button>
            </div>
            </div>
        </div>
    </div>


</div>

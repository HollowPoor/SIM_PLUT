<div class="container-fluid">

  <div class="card mb-3" style="max-width: 100%;">

          <?php if ($this->session->flashdata()): ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 " width="24" height="24" role="img" aria-label="success:"><use xlink:href="#exclamation-triangle-fill"/></svg>
              <div>
                <?=$this->session->flashdata('profil')?>.
              </div>
            </div>
            <?php endif;?>

            <form method = "post" action="<?=base_url('Dashboard/ProfilUpdate');?>" enctype="multipart/form-data" >
            <?=form_open_multipart('Dashboard/ProfilUpdate')?>
            <div class="row no-gutters">
              <div class="col-md-4 p-4">
              <img src="<?=base_url("assets")?>/img/profil_img/<?=$FotoPengguna?>" class="rounded" width="300" height="300" alt="...">
              <!-- Pilih Gambar -->
              <div class="card mt-3">
                <div class="card-body">
                  <p class="card-text">Silahkan Masukan Foto Profil Anda Dengan Format *.JPG atau *.PNG 300x300</p>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto_dtl" name="foto_dtl">
                    <label class="custom-file-label" for="foto_dtl">Pilih Gambar</label>
                  </div>
                </div>
              </div>

        <!-- Selesai Pilih Gambar -->

      </div>
      <div class="col-md-8">
        <div class="card-body">

          <div class="mb-3">
            <span class="float-right">Date Created : <?=$Tanggal;?> </span>
            <span><strong>Biodata Diri</strong></span>
          </div>
          <hr class="sidebar-divider">

          <div class="form-group">
            <label for="Form1">Nama</label>
            <input type="text" class="form-control" id="nama_pgn" name="NamaPengguna" value="<?=$NamaPengguna?>">
            <?=form_error('NamaPengguna', '<small class="text-danger pl-3">', '</small>');?>
          </div>
          <div class="form-group">
            <label for="Form1">Email address</label>
            <input type="email" class="form-control" id="email_pgn" name="EmailPengguna" placeholder="name@example.com" value="<?=$Email?>" readonly>
          </div>
          <div class="form-group">
            <label for="Form1">No Telphone</label>
            <input type="text" class="form-control" id="tlp_pgn" name="TelphonePengguna" value="<?=$NoTelphone?>">
          </div>
          <div class="form-group">
            <label for="Form1">Jabatan/ Bidang Pekerjaan</label>
            <input type="text" class="form-control" id="jabatan_pgn" name="JabatanPengguna" value="<?=$Jabatan?>">
          </div>
          <div class="form-group">
            <label for="form1">Alamat</label>
            <textarea class="form-control" id="alamat_pgn" name="AlamatPengguna" rows="3" ><?=$Alamat?></textarea>
          </div>

          

          <button type="button" class="btn btn-primary btnUbahPassword">Ubah Password</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

        </div>
      </div>
    </div>
  </div>


<div class="modal fade" id="editPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h5 class="modal-title" id="exampleModalLabel">Reset Password Pengguna</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- body modal -->
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label for="Form1">Password Lama</label>
                        <input type="text" class="form-control" id="passwordPenggunaOld" name="passwordPengguna" >
                        <small class="err_passwordOld" style = "color : red;"></small>
                    </div>
                    <hr class="sidebar-divider">
                    <div class="form-group">
                        <label for="Form1">Password Baru</label>
                        <input type="text" class="form-control" id="passwordPenggunaNew" name="passwordPengguna" >
                        <small class="err_passwordNew" style = "color : red;"></small>
                    </div>

                    <div class="form-group">
                        <label for="Form1">Ulangi Password Baru</label>
                        <input type="text" class="form-control" id="RepasswordPenggunaNew" name="passwordPengguna" >
                        <small class="err_RepasswordNew" style = "color : red;"></small>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="close" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary btnSimpanPassword">Simpan</button>
                </div>
            </div>
        </div>
    </div>
<!-- modal untuk edit data -->
    

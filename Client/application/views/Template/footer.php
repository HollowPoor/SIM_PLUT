 </div>
 <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SIM PLUT-KUMKM 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingin Logout ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah Anda Yakin Ingin Keluar ?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?=base_url("Dashboard/DeleteSession");?>">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Tambah Pengguna Selesai -->


    <!-- Bootstrap core JavaScript-->
    
    <script src="<?=base_url()?>assets/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url()?>assets/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url()?>assets/js/sb-admin-2.min.js"></script>

    <script>
         

        $('.custom-file-input').on('change',function(){
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass('selected').html(fileName);

        });

        //script halaman profil
        $(document).ready(function() {
            //reset password modal
            $('.btnUbahPassword').on('click',function(){
                $('#editPassword').modal('show');
                var element = document.getElementById("ResponSuc");
                element.classList.add("sr-only");
                var element = document.getElementById("ResponWarn");
                element.classList.add("sr-only");
            });

            $('.btnSimpanPassword').on('click',function(){
                var element = document.getElementById("ResponSuc");
                element.classList.add("sr-only");
                var element = document.getElementById("ResponWarn");
                element.classList.add("sr-only");
                if($('#passwordPenggunaOld').val()==""){
                    $(".err_passwordOld").show();
                    $(".err_passwordOld").text("Silahkan Ketik Password Lama Di isi");
                    var err_pw = 1;
                }else{
                    $(".err_passwordOld").hide();
                    var err_pw = 0;
                }
                if($('#passwordPenggunaNew').val()==""){
                    $(".err_passwordNew").show();
                    $(".err_passwordNew").text("Silahkan Password Baru Di isi");
                    var err_pwn = 1;
                }else{
                    $(".err_passwordNew").hide();
                    var err_pwn = 0;
                }
                if($('#RepasswordPenggunaNew').val()==""){
                    $(".err_RepasswordNew").show();
                    $(".err_RepasswordNew").text("Silahkan Ketik Ulang Password Baru Di isi");
                    var err_rpwn = 1;
                }else{
                    $(".err_RepasswordNew").hide();
                    var err_rpwn = 0;
                }

                var pwo = $('#passwordPenggunaOld').val();
                var pwn = $('#passwordPenggunaNew').val();
                var rpwn = $('#RepasswordPenggunaNew').val();

            
                if(err_pw==1 || err_rpwn == 1 || err_pwn == 1){
                    
                        var element = document.getElementById("ResponWarn");
                        element.classList.remove("sr-only");
                        $('.ResponWarn').text("Silahkan Isi Data Terlebih Dahulu");
                        
                    }else{
                    if(pwn != rpwn){
                        var element = document.getElementById("ResponWarn");
                        element.classList.remove("sr-only");
                        $('.ResponWarn').text("Password Tidak Sama");
                    }else{
                    $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("Dashboard/CheckPassword"); ?>",
                        data : {
                            "oldPass" : pwo,
                        },
                        success : function(response){
                            if(response == "Kosong"){
                                element.classList.remove("sr-only");
                                $('.ResponWarn').text("Password Yang Di Masukan salah, Silahkan Periksa Terlebih Dahulu");
                            }else{
                                $.ajax({
                                    type : "POST",
                                    url :"<?php echo site_url("Dashboard/UpdatePassword"); ?>",
                                    data : {
                                        "newPass" : pwn,
                                    },
                                    success : function(response){
                                        if(response == "Berhasil Di Update"){
                                            var elementS = document.getElementById("ResponSuc");
                                            elementS.classList.remove("sr-only");
                                            $('.ResponSuc').text("Password Berhasil Diubah");
                                            $('#passwordPenggunaOld').val("");
                                            $('#passwordPenggunaNew').val("");
                                            $('#RepasswordPenggunaNew').val("");
                                            
                                        }else{
                                            element.classList.remove("sr-only");
                                            $('.ResponWarn').text("Password Gagal Di Ubah, Silahkan Coba Lagi");
                                        }
                                    }
                                });
                            }
                        }
                    });
                    }
                    }
            });

            
        })
        // js untuk halaman data pengguna
        $(document).ready(function(){
            let err_email = 0;
            let kd;
            let refresh_togl = 0;
            //Check Email Saat Di Inputkan
            $(".checkEmail").on('keyup',function(e){
                var kode = $("#kodePengguna").val();
                var emailnew = $("#emailPengguna").val();
                $(".err_email").hide() ;
                $(".vld_email").hide() ;
                $.ajax({
                    type : "POST",
                    url :"<?php echo site_url("DataPengguna/CheckEmail"); ?>",
                    data : {
                        "kode" : kode,
                        "emailnew" : emailnew,
                    },
                    success : function(response){
                        if(response == "Email Dapat Digunakan"){
                            if($(".checkEmail").val()==""){
                                $(".err_email").show() ;
                                $(".err_email").text("Silahkan Isi Email terlebih Dahulu") ;
                            }else{

                                var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                                if (mailformat . test($("#emailPengguna").val()) == false) {
                                    err_email =1;
                                    $(".err_email").show() ;
                                    $(".err_email").text("Masukan Email Sesuai Format *Contoh@mail.com") ;
                                }else{
                                    err_email = 0;
                                    $(".vld_email").show() ;
                                    $(".vld_email").text(response);
                                }

                            }
                        }else{
                            $(".err_email").show() ;
                            $(".err_email").text(response) ;
                        }
                    }
                });
            });

            // modal edit data
            $('.table #editPengguna').on('click', function(){
                let kodePengguna = $(this).data('kode');
                let emailPengguna = $(this).data('email');
                let passwordPengguna = $(this).data('password');
                let statusPengguna = $(this).data('status');
                let levelPengguna = $(this).data('lvl');

                $('#kodePengguna').val(kodePengguna);
                $('#emailPengguna').val(emailPengguna);
                $('#passwordPengguna').val(passwordPengguna);
                $('#statusPengguna').val(statusPengguna);
                $('#levelPengguna').val(levelPengguna);

            });

            // Lihat Profil
            $('.table .lihatProfil').on('click', function(){
                let kodePengguna = $(this).data('kode');
                $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataPengguna/SetSession"); ?>",
                        data : {
                            "kodePengguna" : kodePengguna,
                        },
                        success : function(response){
                            location.href = "<?=base_url('DataPengguna/ProfilPengguna')?>";

                        }
                    });
            });

            // refresh table dan semunyikan pemberitahuan
            $('#HapusPenggunaModal').on('hidden.bs.modal',function(){
                var element = document.getElementById("ResponWarn");
                element.classList.add("sr-only");
                var element = document.getElementById("ResponSuc");
                element.classList.add("sr-only");
                $(".err_email").hide() ;
                $(".vld_email").hide() ;
                window . location . reload();
            });

            //pindahkan data ke dalam modal hapus pengguna
            $('#HapusPengguna').on('click',function(){

                $('#editPenggunaModal').modal('hide');
                $('#HapusPenggunaModal').modal('show');

                let kode = $('#kodePengguna').val();
                let email = $('#emailPengguna').val();

                $('#kodeDel').text(kode);
                $('#emailDel').text(email);
            });

            //tambah Data Pengguna
            $('.btnTambahPengguna').on('click',function(){
                $('#tambahPengguna').modal('show');
                $.ajax({
                    type : "POST",
                    url :"<?=base_url("DataPengguna/GetKodePengguna");?>",
                    success : function(response){
                        $('#kodeTbhPengguna').val(response);
                    }
                });
            });

            $('.simpanpgn').on('click',function(){

                $(".err_email").hide() ;
                var element = document.getElementById("ResponSuc");
                element.classList.add("sr-only");
                var element = document.getElementById("ResponWarn");
                element.classList.add("sr-only");
                if($('#passwordTbhPengguna').val()==""){
                    $(".err_password").show();
                    $(".err_password").text("Silahkan Password Di isi");
                    var err_pw = 1;
                }else{
                    $(".err_password").hide();
                    var err_pw = 0;
                }
                if($('#emailTbhPengguna').val()==""){
                    $(".err_email").show();
                    $(".err_email").text("Silahkan Email Diisi");
                    err_email = 1;
                }else if(err_email == 1){
                $(".err_email").show() ;
                $(".err_email").text("Masukan Email Sesuai Format *Contoh@mail.com") ;
                }
                if($('#levelTbhPengguna').val()==9){
                    $(".err_lvl").show();
                    $(".err_lvl").text("Silahkan Tentukan Role Pengguna");
                    var err_lvl = 1;
                }else{
                    $(".err_lvl").hide();
                    var err_lvl = 0;
                }
                if($('#statusTbhPengguna').val()==9){
                    $(".err_stats").show();
                    $(".err_stats").text("Silahkan Tentukan Status Akun Pengguna");
                    var err_stats = 1;
                }else{
                    $(".err_stats").hide();
                    var err_stats = 0;
                }
                var kode = $('#kodeTbhPengguna').val();
                kd = $('#kodeTbhPengguna').val();
                var email = $('#emailTbhPengguna').val();
                var pw = $('#passwordTbhPengguna').val();
                var status = $('#statusTbhPengguna').val();
                var lvl = $('#levelTbhPengguna').val();

                if(err_pw==1 || err_email == 1 || err_lvl == 1 || err_stats == 1 ){
                    var element = document.getElementById("ResponWarn");
                    element.classList.remove("sr-only");
                    $('.ResponWarn').text("Silahkan Isi Data Terlebih Dahulu");
                }else{
                    $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataPengguna/AddDataPengguna"); ?>",
                        data : {
                            "kodePengguna" : kode,
                            "emailPengguna" : email,
                            "passwordPengguna" : pw,
                            "statusPengguna" : status,
                            "levelPengguna" : lvl,
                            "Date_Created" : <?php echo time(); ?>
                        },
                        success : function(response){
                            if(response !="Pengguna gagal Ditambahkan"){
                                $('#tambahPengguna').modal('hide');
                                $('#simpanPengguna').modal('show');
                            }else{
                            var element = document.getElementById("ResponWarn");
                            element.classList.remove("sr-only");
                            $('.ResponWarn').text("Tidak Ada Data Yang Ditambahkan");
                            }
                        }
                    });
                }
            });

            //fungsi tombol hapus di modal hapus
            $('.btnHapusPgn').on('click',function(){
                let kode = $('#kodeDel').text();
                let email = $('#emailDel').text();

                $.ajax({
                    type : "POST",
                    url :"<?=base_url("DataPengguna/DeletePengguna");?>",
                    data : {
                        "kodePengguna" : kode,
                        "emailPengguna" : email,
                    },
                    success : function(response){
                    }
                });
            });

            // fungsi button simpan
            $(".simpan").on('click',function(){

                $(".err_email").hide() ;
                var element = document.getElementById("ResponSuc");
                element.classList.add("sr-only");
                var element = document.getElementById("ResponWarn");
                element.classList.add("sr-only");
                if($('#passwordPengguna').val()==""){
                    $(".err_password").show();
                    $(".err_password").text("Silahkan Password Di isi");
                    var err_pw = 1;
                }else{
                    $(".err_password").hide();
                    var err_pw = 0;
                }
                if($('.checkEmail').val()==""){
                    $(".err_email").show();
                    $(".err_email").text("Silahkan Email Diisi");
                    err_email = 1;
                }else if(err_email == 1){
                $(".err_email").show() ;
                $(".err_email").text("Masukan Email Sesuai Format *Contoh@mail.com") ;
                }
                if($('#levelPengguna').val()==9){
                    $(".err_lvl").show();
                    $(".err_lvl").text("Silahkan Tentukan Role Pengguna");
                    var err_lvl = 1;
                }else{
                    $(".err_lvl").hide();
                    var err_lvl = 0;
                }
                if($('#statusPengguna').val()==9){
                    $(".err_stats").show();
                    $(".err_stats").text("Silahkan Tentukan Status Akun Pengguna");
                    var err_stats = 1;
                }else{
                    $(".err_stats").hide();
                    var err_stats = 0;
                }
                var kode = $('#kodePengguna').val();
                var email = $('#emailPengguna').val();
                var pw = $('#passwordPengguna').val();
                var status = $('#statusPengguna').val();
                var lvl = $('#levelPengguna').val();

                if(err_pw==1 || err_email == 1 || err_lvl == 1 || err_stats == 1 ){
                    var element = document.getElementById("ResponWarn");
                    element.classList.remove("sr-only");
                    $('.ResponWarn').text("Silahkan Isi Data Terlebih Dahulu");
                }else{
                    $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataPengguna/UpdatePengguna"); ?>",
                        data : {
                            "kodePengguna" : kode,
                            "emailPengguna" : email,
                            "passwordPengguna" : pw,
                            "statusPengguna" : status,
                            "levelPengguna" : lvl,
                        },
                        success : function(response){
                            if(response !="Gagal Update Data Pengguna"){
                                refresh_togl = 1;
                                var element = document.getElementById("ResponSuc");
                                element.classList.remove("sr-only");
                                $('.ResponSuc').text(response);
                            }else{
                            var element = document.getElementById("ResponWarn");
                            element.classList.remove("sr-only");
                            $('.ResponWarn').text("Tidak Ada Data Yang Diubah");
                            }
                        }
                    });
                }
            });

            //jika modal edit hilang maka halaman refresh
            $('#editPenggunaModal').on('hidden.bs.modal',function(){
                if(refresh_togl == 1){
                    window . location . reload();
                }
            });

            //jika modal Konfirmasi Update hilang maka halaman ke profil
            $('#simpanPengguna').on('hidden.bs.modal',function(){

                location.href = "<?=base_url('DataPengguna/ProfilPengguna')?>";
            });

        });

        //script Halaman Data umkm
        $(document).ready(function(){
            $('#tabelTest1').DataTable();
            $('.navTentangUMKM').on('click', function(){
                var a1 = document.getElementById("navTentangUMKM");
                a1.classList.add("active");
                var a2 = document.getElementById("navBiodataPemilik");
                a2.classList.remove("active");
                var a3 = document.getElementById("navAsetUMKM");
                a3.classList.remove("active");

                var b1 = document.getElementById("cardBiodataUmkm");
                b1.style.display = "";
                var b2 = document.getElementById("cardBiodataPemilik");
                b2.style.display = "none";
                var b3 = document.getElementById("cardAsetUmkm");
                b3.style.display = "none";
            });
            $('.navBiodataPemilik').on('click', function(){
                var a1 = document.getElementById("navBiodataPemilik");
                a1.classList.add("active");
                var a2 = document.getElementById("navTentangUMKM");
                a2.classList.remove("active");
                var a3 = document.getElementById("navAsetUMKM");
                a3.classList.remove("active");

                var b1 = document.getElementById("cardBiodataPemilik");
                b1.style.display = "";
                var b2 = document.getElementById("cardBiodataUmkm");
                b2.style.display = "none";
                var b3 = document.getElementById("cardAsetUmkm");
                b3.style.display = "none";
            });
            $('.navAsetUMKM').on('click', function(){
                var a1 = document.getElementById("navAsetUMKM");
                a1.classList.add("active");
                var a2 = document.getElementById("navTentangUMKM");
                a2.classList.remove("active");
                var a3 = document.getElementById("navBiodataPemilik");
                a3.classList.remove("active");

                var b1 = document.getElementById("cardAsetUmkm");
                b1.style.display = "";
                var b2 = document.getElementById("cardBiodataUmkm");
                b2.style.display = "none";
                var b3 = document.getElementById("cardBiodataPemilik");
                b3.style.display = "none";
            });
            $('#inputtahunAsset').each(function() {

                var year = (new Date()).getFullYear();
                var current = year;
                year -= 4;
                for (var i = 0; i < 8; i++) {
                    if ((year+i) == current)
                    $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
                    else
                    $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
                }
            });
            // Lihat Detail UMKM
            $('.btnDetailUMKM').on('click', function(){
                let kodeUMKM = $(this).data('kode');
                $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataUMKM/SetSessionUMKM"); ?>",
                        data : {
                            "kodeAset" : kodeUMKM,
                        },
                        success : function(response){
                            location.href="<?= base_url('DataUMKM/DetailUMKM'); ?>";
                            

                        }
                    });
            });
            $('#inputtahunAsset').on('change', function(){
                let tahun = $("#inputtahunAsset").val();
                $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataUMKM/GetAsset"); ?>",
                        data : {
                            "tahun" : tahun,
                        },
                        dataType : "json",
                        success : function(response){
                            if(response.status){
                                $('#inputAset').val(response.aset);
                                $('#inputOmzet').val(response.omzet);
                                $('#inputPekerja').val(response.pekerja);
                            }else{
                                $('#inputAset').val("-");
                                $('#inputOmzet').val("-");
                                $('#inputPekerja').val("-");
                                
                            }
                        }
                    });
            });
            //tambah Data UKM
            $('.btnTambahUMKM').on('click',function(){
                $('#tambahUMKM').modal('show');
            });
            $('.simpanukm').on('click',function(){

                $(".err_email").hide() ;
                var element = document.getElementById("ResponSuc");
                element.classList.add("sr-only");
                var element = document.getElementById("ResponWarn");
                element.classList.add("sr-only");
                if($('#inputNamaOwner').val()==""){
                    $(".err_nama").show();
                    $(".err_nama").text("Silahkan Nama Di isi");
                    var err_nama = 1;
                }else{
                    $(".err_nama").hide();
                    var err_nama = 0;
                }
                if($('#inputEmail').val()==""){
                    $(".err_email").show();
                    $(".err_email").text("Silahkan Email Diisi");
                    err_email = 1;
                }else{
                    $(".err_email").hide();
                    err_email = 0;
                }
                if($('.inputNohp').val()==""){
                    $(".err_nohp").show();
                    $(".err_nohp").text("Silahkan ini No Handphone");
                    var err_nohp = 1;
                }else{
                    $(".err_nohp").hide();
                    var err_nohp = 0;
                }
                if($('#inputNamaUmkm').val()== ""){
                    $(".err_ukm").show();
                    $(".err_ukm").text("Silahkan Masukan Nama UMKM");
                    var err_ukm = 1;
                }else{
                    $(".err_ukm").hide();
                    var err_ukm = 0;
                }
                if($('#inputAlamatUkm').val()== ""){
                    $(".err_alamat").show();
                    $(".err_alamat").text("Silahkan Masukan Nama UMKM");
                    var err_alamat = 1;
                }else{
                    $(".err_alamat").hide();
                    var err_alamat = 0;
                }
                var namaOwner = $('#inputNamaOwner').val();
                var email = $('.inputemails').val();
                var nohp = $('.inputNohp').val();
                var namaUkm = $('#inputNamaUmkm').val();
                var alamat = $('#inputAlamatUkm').val();
                var kegiatan = $('#textAreaKegiatan').val();

                if(err_nama==1 || err_email == 1 || err_nohp == 1 || err_ukm == 1 || err_alamat == 1){
                    var element = document.getElementById("ResponWarn");
                    element.classList.remove("sr-only");
                    $('.ResponWarn').text("Silahkan Isi Data Terlebih Dahulu");
                }else{
                    $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataUMKM/tambahDataUMKM"); ?>",
                        data : {
                            "namaOwner" : namaOwner,
                            "email" : email,
                            "nohp" : nohp,
                            "namaUKM" : namaUkm,
                            "alamat" : alamat,
                            "kegiatan" : kegiatan,
                        },
                        success : function(response){
                            if(response !="gagal"){
                                var element = document.getElementById("ResponSuc");
                                element.classList.remove("sr-only");
                                $('.ResponSuc').text("Berhasil Menambahkan Data UMKM "+namaUkm);
                                $('#inputNamaOwner').val("");
                                $('.inputemails').val("");
                                $('.inputNohp').val("");
                                $('#inputNamaUmkm').val("");
                                $('#inputAlamatUkm').val("");
                                $('#textAreaKegiatan').val("");
                            }else{
                                var element = document.getElementById("ResponWarn");
                                element.classList.remove("sr-only");
                               $('.ResponWarn').text("Tidak Ada Data Yang Ditambahkan");
                            }
                        }
                    });
                }
            });
            //fitur search
            $('#searchUKM').on('keyup',function() {
                var search = $('#searchUKM').val();
                $("tbody").empty();

                $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataUMKM/SearchUMKM"); ?>",
                        data : {
                            "search" : search,
                        },
                        dataType : "json",
                        success : function(response){
                            if(response.status){
                                var data = response.data;
                                for (var i=0; i<data.length; i++) {
                                document . getElementById("tableUMKM").getElementsByTagName('tbody')[0].insertRow(-1).
                                innerHTML = 
                                '<th scope="row">'+(i+1)+'</th>'+
                                '<td style="max-width: 100px;">'+data[i].namaOwner+'</td>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">'+data[i].namaUMKM+'</td>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">'+data[i].alamatUsaha+'</td>'+
                                '<td style="max-width: 150px;">'+data[i].noHP+'</td>'+

                                '<td>'+
                                    '<button type="button" style="margin-right: 10px;" class="btn btn-primary btnDetailUMKM" onclick="DetailUMKM(this.value)" value="'+data[i].kode_asset+'">Detail</button>'+
                                    '<button type="button" onClick = "HubungiWa(this.value)" value="'+data[i].noHP+'" class="btn btn-success" >Hubungi Via Whatsapp</button>'+
                                '</td>'
                                }   
                            }else{
                                document.getElementById("tableUMKM").getElementsByTagName('tbody')[0].innerHTML = '<th class="text-center kosong" colspan="7">Data UMKM Tidak Di Temukan</th>';
                                
                            }
                        }
                    });
            })

        });
            function DetailUMKM(val) {
                    let kodeUMKM = val;
                    $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataUMKM/SetSessionUMKM"); ?>",
                        data : {
                            "kodeAset" : kodeUMKM,
                        },
                        success : function(response){
                            location.href="<?= base_url('DataUMKM/DetailUMKM'); ?>";
                        }
                    });
                }

            function HubungiWa(val) {
                var ucapan;
                var h=(new Date()).getHours();
                var m=(new Date()).getMinutes();
                var s=(new Date()).getSeconds();
                if (h >= 4 && h < 10) ucapan = "Selamat pagi, ";
                if (h >= 10 && h < 15) ucapan ="Selamat siang, ";
                if (h >= 15 && h < 18) ucapan ="Selamat sore, ";
                if (h >= 18 || h < 4) ucapan ="Selamat malam, ";
                if(val.charAt(0) === '0'){
                        let noHP = val.substring(1);
                        location.href="https://wa.me/62"+noHP+"/?text="+ucapan+" Pak/Bu Saya ...";
                    }else if(val.charAt(0) === '6'){
                        location.href="https://wa.me/"+val+"/?text="+ucapan+" Pak/Bu Saya ...";
                    }else{
                        alert('Nomor Handphone Tidak Valid');
                    }
                }

        //script halaman kegiatan
        $(document).ready(function() {
            let kodeJ;
            //fungsi tombol hapus di modal hapus
            $('.btnHapusJadwal').on('click',function(){
                kodeP = $(this).data('kodep');
                kodeJ = $(this).data('kodejadwal');
                
            });
            $('.btnModalJadwalHapus').on('click',function(){
                $.ajax({
                    type : "POST",
                    url :"<?=base_url("KelolaJadwal/HapusJadwal");?>",
                    data : {
                        "kodePengguna" : kodeP,
                        "kodeJadwal" : kodeJ,
                    },
                    success : function(response){
                        if(response == "sukses"){
                            alert("Berhasil Menghapus Data");
                            window . location . reload();
                        }else{
                            alert("Gagal Menghapus Data");
                        }
                    }
                });    
            });
            
            //tampilkan Modal
            $('.buatJadwalKegiatan').on('click',function(){
                $('#buatJadwalKegiatan').modal('show');
            });
            
            //Tombol Simpan Jadwal
            $('.simpanJadwal').on('click',function(){
                var element = document.getElementById("ResponSuc");
                element.classList.add("sr-only");
                var element = document.getElementById("ResponWarn");
                element.classList.add("sr-only");
                if($('#inputNamaKegiatan').val()==""){
                    $(".err_nama").show();
                    $(".err_nama").text("Silahkan Nama Kegiatan Di isi");
                    var err_nama = 1;
                }else{
                    $(".err_nama").hide();
                    var err_nama = 0;
                }
                if($('#inputNamaUMKM').val()==""){
                    $(".err_umkm").show();
                    $(".err_umkm").text("Silahkan Nama UMKM Diisi");
                    err_umkm = 1;
                }else{
                    $(".err_umkm").hide();
                    err_umkm = 0;
                }
                var namaKeg = $('#inputNamaKegiatan').val();
                var namaUKM = $('.inputNamaUMKM').val();
                var tgl = $('#inputTgl').val();

                if(err_nama==1 || err_umkm == 1){
                    var element = document.getElementById("ResponWarn");
                    element.classList.remove("sr-only");
                    $('.ResponWarn').text("Silahkan Isi Data Terlebih Dahulu");
                }else{
                    $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataKegiatan/TambahJadwalKegiatan"); ?>",
                        data : {
                            "namaKegiatan" : namaKeg,
                            "namaUMKM" : namaUKM,
                            "tgl" : tgl,
                        },
                        success : function(response){
                            if(response !="gagal"){
                                var element = document.getElementById("ResponSuc");
                                element.classList.remove("sr-only");
                                $('.ResponSuc').text("Berhasil Menambahkan Jadwal Baru");
                                $('#inputNamaOwner').val("");
                                $('.inputemails').val("");
                                $('.inputNohp').val("");
                                $('#inputNamaUmkm').val("");
                                $('#inputAlamatUkm').val("");
                                $('#textAreaKegiatan').val("");
                                alert("Berhasil Menambahkan Jadwal Baru");
                                window . location . reload();
                            }else{
                                var element = document.getElementById("ResponWarn");
                                element.classList.remove("sr-only");
                               $('.ResponWarn').text("Tidak Ada Data Yang Ditambahkan");
                            }
                        }
                    });
                }
            });
            
            //navigasi Halaman Kegiatan
            $('.navKelola').on('click', function(){
                var a1 = document.getElementById("navKelola");
                a1.classList.add("active");
                var a2 = document.getElementById("navJadwal");
                a2.classList.remove("active");

                var b1 = document.getElementById("cardKelolaKegiatan");
                b1.style.display = "";
                var b2 = document.getElementById("cardJadwalKegiatan");
                b2.style.display = "none";
            });
            $('.navJadwal').on('click', function(){
                var a1 = document.getElementById("navJadwal");
                a1.classList.add("active");
                var a2 = document.getElementById("navKelola");
                a2.classList.remove("active");

                var b1 = document.getElementById("cardJadwalKegiatan");
                b1.style.display = "";
                var b2 = document.getElementById("cardKelolaKegiatan");
                b2.style.display = "none";
            });

            $('#cariBulanKegiatan').on('change',function(){
            var tanggal = document.getElementById("cariBulanKegiatan").value;
            $("tbody").empty();
            $.ajax({
                type : "POST",
                url :"<?php echo site_url("DataKegiatan/getKegiatanBulan"); ?>",
                data : {
                    "tanggals" : tanggal,
                },
                dataType : "json",
                success : function(response){
                    var data = response.data;
                    if(response.status == false){
                        document.getElementById("tableKegiatan").getElementsByTagName('tbody')[0].innerHTML = '<th class="text-center kosong" colspan="4">Belum Memiliki Kegiatan</th>';
                    }else{
                        var data = response.data;
                            for (var i=0; i<data.length; i++) {
                                var options = { year: 'numeric', month: 'numeric', day: 'numeric' };
                                const d = new Date(data[i].tanggal);
                                document . getElementById("tableKegiatan").getElementsByTagName('tbody')[0].insertRow(-1).
                                innerHTML = 
                                ' <th>'+(i+1)+'</th>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">'+data[i].namaUKM+'</td>'+
                                '<td>'+d.toLocaleString("id-ID",options)+'</td>'+
                                '<td><button type="button" class="btn btn-primary btnDetailKegiatan" onclick="MyDetail(this.value)" id="btnDetailKegiatan" value="'+data[i].kode_kegiatan+'" data-kode="'+data[i].kode_kegiatan+'">Detail</button></td>';
                            }   
                            }
                        }
                        
                    });
           });

           var ck = 0;
           $('.tambahKegiatan').on('click',function() {
               if(ck ==1){
                var cardK = document.getElementById("cardKegiatan");
                cardK.style.display = "none";
                $('.tambahKegiatan').text('Tambah Kegiatan Pendampingan');
                ck=0;
            }else{
                var btnHapus = document.getElementById("btnHapusKegiatan");
                btnHapus.style.display = "none";
                var btnUpdate = document.getElementById("btnUpdateKegiatan");
                btnUpdate.style.display = "none";
                var btnsimpan = document.getElementById("btnSimpanKegiatan");
                btnsimpan.style.display = "";
                var cardK = document.getElementById("cardKegiatan");
                cardK.style.display = "";
                $('.judulKegiatan').text('Tambah Kegiatan');
                $('.tambahKegiatan').text('Sembunyikan');
                ck=1;
                $('#nama_ukm').val("");
                            $('#permasalahan').val("");
                            $('#programKerja').val("");
                            $('#materi').val("");
                            $('#skema').val("");
                }
           });
                    $('.btnDetailKegiatan').on('click',function() {
                    var cardK = document.getElementById("cardKegiatan");
                    cardK.style.display = "";
                    $('.tambahKegiatan').text('Tambah Kegiatan Pendampingan');
                    $('.judulKegiatan').text('Update Kegiatan');
                    ck=0;
                    var btnUpdate = document.getElementById("btnUpdateKegiatan");
                    btnUpdate.style.display = "";
                    var btnHapus = document.getElementById("btnHapusKegiatan");
                    btnHapus.style.display = "";
                    var btnSimpan = document.getElementById("btnSimpanKegiatan");
                    btnSimpan.style.display = "none";
                    var kode = $(this).data('kode');
                    $.ajax({
                            type : "POST",
                            url :"<?php echo site_url("DataKegiatan/GetDetailKegiatan"); ?>",
                            data : {
                                "kodeK" : kode,
                                },
                            dataType : "json",
                            success : function(response){
                                $('#nama_ukm').val(response[0].namaUKM);
                                $('#permasalahan').val(response[0].permasalahan);
                                $('#programKerja').val(response[0].programKerja);
                                $('#tglKegiatan').val(response[0].tanggal);
                                $('#materi').val(response[0].materi);
                                $('#skema').val(response[0].tindakan);
                            }
                        });
                    });
                    
                    
                    
                    
                    
        });
                function MyDetail(val) {
                    var cardK = document.getElementById("cardKegiatan");
                    cardK.style.display = "";
                    $('.tambahKegiatan').text('Tambah Kegiatan Pendampingan');
                    $('.judulKegiatan').text('Update Kegiatan');
                    ck=0;
                    var btnUpdate = document.getElementById("btnUpdateKegiatan");
                    btnUpdate.style.display = "";
                    var btnHapus = document.getElementById("btnHapusKegiatan");
                    btnHapus.style.display = "";
                    var btnSimpan = document.getElementById("btnSimpanKegiatan");
                    btnSimpan.style.display = "none";
                    var kode = val;
                    $.ajax({
                            type : "POST",
                            url :"<?php echo site_url("DataKegiatan/GetDetailKegiatan"); ?>",
                            data : {
                                "kodeK" : kode,
                                },
                            dataType : "json",
                            success : function(response){
                                $('#nama_ukm').val(response[0].namaUKM);
                                $('#permasalahan').val(response[0].permasalahan);
                                $('#programKerja').val(response[0].programKerja);
                                $('#tglKegiatan').val(response[0].tanggal);
                                $('#materi').val(response[0].materi);
                                $('#skema').val(response[0].tindakan);
                            }
                        });

                }

        // script halaman Laporan
        $(document).ready(function(){
            $('#inputPendamping').each(function() {
                $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataLaporan/GetNamaPendamping"); ?>",
                        dataType : "json",
                        success : function(response){
                            var data = response.data;
                            for (var i = 0; i < data.length; i++) {
                                $('#inputPendamping').append('<option value="' + data[i].kode_pgn + '">' + data[i].nama_dtl + '</option>');
                            }
                        }
                    });
            });

            $('#inputPendamping').on('change',function() {
                var tgl = document.getElementById("cariBulanLaporanKegiatan");
                tgl.readOnly = false;
            });

            $('#cariBulanLaporanKegiatan').on('change',function() {
                
                var tanggal = document.getElementById("cariBulanLaporanKegiatan").value;
                $("tbody").empty();
            $.ajax({
                type : "POST",
                url :"<?php echo site_url("DataLaporan/getKegiatanLaporan"); ?>",
                data : {
                    "kodeP" : $('#inputPendamping').val(),
                    "tanggals" : tanggal,
                },
                dataType : "json",
                success : function(response){
                    var data = response.data;
                    if(response.status == false){
                        document.getElementById("tableLaporanKegiatan").getElementsByTagName('tbody')[0].innerHTML = '<th class="text-center kosong" colspan="7">Belum Memiliki Kegiatan</th>';
                        $('#btnCektakLaporan').prop('disabled', true);
                    }else{
                        var data = response.data;
                        $('#btnCektakLaporan').prop('disabled', false);
                        for (var i=0; i<data.length; i++) {
                                var options = { year: 'numeric', month: 'numeric', day: 'numeric' };
                                const d = new Date(data[i].tanggal);
                                document . getElementById("tableLaporanKegiatan").getElementsByTagName('tbody')[0].insertRow(-1).
                                innerHTML = 
                                ' <th>'+(i+1)+'</th>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">'+data[i].namaUKM+'</td>'+
                                '<td>'+d.toLocaleString("id-ID",options)+'</td>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">'+data[i].permasalahan+'</td>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">'+data[i].programKerja+'</td>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">'+data[i].materi+'</td>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">'+data[i].tindakan+'</td>';
                            }   
                            }
                        }
                        
                    });
            });
            $('#inputPendamping').on('change',function() {
                $('#cariBulanLaporanKegiatan').val("");
                $('#btnCektakLaporan').prop('disabled', true);
                document.getElementById("tableLaporanKegiatan").getElementsByTagName('tbody')[0].innerHTML = '<th class="text-center kosong" colspan="7">Silahkan Pilih Tanggal Kegiatan</th>';
            });

            $('.navLaporanUKM').on('click', function(){
                var a1 = document.getElementById("navLaporanUKM");
                a1.classList.add("active");
                var a2 = document.getElementById("navLaporanPendamping");
                a2.classList.remove("active");

                var b1 = document.getElementById("cardLaporanUmkm");
                b1.style.display = "";
                var b2 = document.getElementById("cardLaporanPendamping");
                b2.style.display = "none";
            });
            $('.navLaporanPendamping').on('click', function(){
                var a1 = document.getElementById("navLaporanPendamping");
                a1.classList.add("active");
                var a2 = document.getElementById("navLaporanUKM");
                a2.classList.remove("active");

                var b1 = document.getElementById("cardLaporanPendamping");
                b1.style.display = "";
                var b2 = document.getElementById("cardLaporanUmkm");
                b2.style.display = "none";
            });

            $('#inputtahunDataExcle').each(function() {

                var year = (new Date()).getFullYear();
                var current = year;
                year -= 4;
                for (var i = 0; i < 8; i++) {
                    if ((year+i) == current)
                    $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
                    else
                    $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
                }
            });
            $('#inputtahunDataExcle').on('change', function(){
                $('#btnCetakExcle').prop('disabled', false);
                let tahun = $("#inputtahunDataExcle").val();
                $('#txtKeterangan').text("*Anda Akan Meng-Export Data UMKM Tahun "+tahun+" - "+(+tahun+1));
            });

        });

        // script halaman Log
        $(document).ready(function(){
            $('#namaPengguna').each(function() {
                $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataLaporan/GetNamaPendamping"); ?>",
                        dataType : "json",
                        success : function(response){
                            var data = response.data;
                            for (var i = 0; i < data.length; i++) {
                                $('#namaPengguna').append('<option value="' + data[i].kode_pgn + '">' + data[i].nama_dtl + '</option>');
                            }
                        }
                    });
            });

            $('#namaPengguna').on('change',function() {
                var tgl = document.getElementById("cariBulanLog");
                tgl.readOnly = false;
            });

            $('#cariBulanLog').on('change',function() {
                
                var tanggal = document.getElementById("cariBulanLog").value;
                $("tbody").empty();
            $.ajax({
                type : "POST",
                url :"<?php echo site_url("DataLog/getLogAktivitas"); ?>",
                data : {
                    "kodeP" : $('#namaPengguna').val(),
                    "tanggals" : tanggal,
                },
                dataType : "json",
                success : function(response){
                    var data = response.data;
                    if(response.status == false){
                        document.getElementById("tableLog").getElementsByTagName('tbody')[0].innerHTML = '<th class="text-center kosong" colspan="7">Belum Memiliki Kegiatan</th>';
                        
                    }else{
                        var data = response.data;
                        
                        for (var i=0; i<data.length; i++) {
                                var options = {dateStyle: 'full', timeStyle: 'long' };
                                const d = new Date(data[i].tanggal_log);
                                document . getElementById("tableLog").getElementsByTagName('tbody')[0].insertRow(-1).
                                innerHTML = 
                                ' <th style="max-width: 5%;">'+(i+1)+'</th>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 10%;">'+data[i].nama_dtl+'</td>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 20%;">'+d.toLocaleString("id-ID",options)+'</td>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 65%;">'+data[i].aktivitas_log+'</td>';
                            }   
                            }
                        }
                        
                    });
            });
            $('#namaPengguna').on('change',function() {
                $('#cariBulanLog').val("");
                document.getElementById("tableLog").getElementsByTagName('tbody')[0].innerHTML = '<th class="text-center kosong" colspan="7">Silahkan Pilih Tanggal Kegiatan</th>';
            });


        });

        //halaman kelola Jadwal
            let kodeKJ;
        $(document).ready(function() {
            $('.simpanJadwalK').on('click',function(){
                var element = document.getElementById("ResponSuc");
                element.classList.add("sr-only");
                var element = document.getElementById("ResponWarn");
                element.classList.add("sr-only");
                if($('#inputNamaKegiatan').val()==""){
                    $(".err_nama").show();
                    $(".err_nama").text("Silahkan Nama Kegiatan Di isi");
                    var err_nama = 1;
                }else{
                    $(".err_nama").hide();
                    var err_nama = 0;
                }
                if($('#inputNamaUMKM').val()==""){
                    $(".err_umkm").show();
                    $(".err_umkm").text("Silahkan Nama UMKM Diisi");
                    err_umkm = 1;
                }else{
                    $(".err_umkm").hide();
                    err_umkm = 0;
                }
                var namaKeg = $('#inputNamaKegiatan').val();
                var namaUKM = $('.inputNamaUMKM').val();
                var tgl = $('#inputTgl').val();

                if(err_nama==1 || err_umkm == 1){
                    var element = document.getElementById("ResponWarn");
                    element.classList.remove("sr-only");
                    $('.ResponWarn').text("Silahkan Isi Data Terlebih Dahulu");
                }else{
                    $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("KelolaJadwal/TambahJadwalKeg"); ?>",
                        data : {
                            "kodeP" : $('#inputJadwalPendamping').val(),
                            "namaKegiatan" : namaKeg,
                            "namaUMKM" : namaUKM,
                            "tgl" : tgl,
                        },
                        success : function(response){
                            if(response !="gagal"){
                                var element = document.getElementById("ResponSuc");
                                element.classList.remove("sr-only");
                                $('.ResponSuc').text("Berhasil Menambahkan Jadwal Baru");
                                $('#inputNamaOwner').val("");
                                $('.inputemails').val("");
                                $('.inputNohp').val("");
                                $('#inputNamaUmkm').val("");
                                $('#inputAlamatUkm').val("");
                                $('#textAreaKegiatan').val("");
                                alert("Berhasil Menambahkan Jadwal Baru");
                                window . location . reload();
                            }else{
                                var element = document.getElementById("ResponWarn");
                                element.classList.remove("sr-only");
                               $('.ResponWarn').text("Tidak Ada Data Yang Ditambahkan");
                            }
                        }
                    });
                }
            });
            $('.btnTambahJadwalP').on('click',function(){
                $('#buatJadwalKegiatan').modal('show');
            });
           $('#inputJadwalPendamping').each(function() {
                $.ajax({
                        type : "POST",
                        url :"<?php echo site_url("DataLaporan/GetNamaPendamping"); ?>",
                        dataType : "json",
                        success : function(response){
                            var data = response.data;
                            for (var i = 0; i < data.length; i++) {
                                $('#inputJadwalPendamping').append('<option value="' + data[i].kode_pgn + '">' + data[i].nama_dtl + '</option>');
                            }
                        }
                    });
            }); 
            $('#inputJadwalPendamping').on('change',function() {       
                $("tbody").empty();
                $.ajax({
                type : "POST",
                url :"<?php echo site_url("KelolaJadwal/AmbilDataJadwal"); ?>",
                data : {
                    "kodeP" : $('#inputJadwalPendamping').val(),
                },
                dataType : "json",
                success : function(response){
                    var data = response.data;
                    if(response.status == false){
                        document.getElementById("tablejadwalpendamping").getElementsByTagName('tbody')[0].innerHTML = '<th class="text-center kosong" colspan="7">Belum Memiliki Jadwal Kegiatan</th>';
                        $('.btnTambahJadwalP').prop('disabled', false);
                    }else{
                        var data = response.data;
                        $('.btnTambahJadwalP').prop('disabled', false);
                        for (var i=0; i<data.length; i++) {
                                document . getElementById("tablejadwalpendamping").getElementsByTagName('tbody')[0].insertRow(-1).
                                innerHTML = 
                                ' <th>'+(i+1)+'</th>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">'+data[i].NamaKegiatan+'</td>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">'+data[i].NamaUMKM+'</td>'+
                                '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">'+data[i].TanggalJadwal+'</td>'+
                                '<td style="text-align:center" scope="row">'+
                                    '<button type="button" class="btn btn-danger btnHapusKegiatanJadwal" onclick="HapusKegiatan(this.value)" value="'+data[i].id_jadwalkegiatan+'" data-toggle="modal" data-target="#hapusJadwal"'+
                                    'data-kodejadwal="'+data[i].id_jadwalkegiatan+'"'+
                                    'data-kodep= "'+data[i].kode_pgn+'"'+
                                    '>Hapus</button>'+
                                '</td>';
                            }   
                            }
                        }
                        
                    });
            });
            
            $('#btnModalKelolaJadwalHapus').on('click',function(){
                $.ajax({
                    type : "POST",
                    url :"<?=base_url("KelolaJadwal/HapusJadwal");?>",
                    data : {
                        "kodePengguna" : $('#inputJadwalPendamping').val(),
                        "kodeJadwal" : kodeKJ,
                    },
                    success : function(response){
                        if(response == "sukses"){
                            alert("Berhasil Menghapus Data");
                            window . location . reload();
                        }else{
                            alert("Gagal Menghapus Data");
                        }
                    }
                });
            });
        });
            function HapusKegiatan(val) {
                kodeKJ = val;
            }
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script>
        $("#tableUMKM").ready(function () {
    $('#tableUMKM').DataTable();
    });
        $("#tablejadwal").ready(function () {
    $('#tablejadwal').DataTable();
    });
        $("#tableLog").ready(function () {
    $('#tableLog').DataTable();
    });
    </script>


</body>

</html>

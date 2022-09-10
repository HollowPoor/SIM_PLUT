<!-- Begin Page Content -->
<div class="container-fluid">

            <!-- halaman Laporan Kegiatan -->
            <div class="card p-3" id="cardLaporanPendamping" style="max-width: 100%; ">
                <form action="<?= base_url("Laporan/LaporanKegiatan"); ?>" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="namaPengguna">Nama Pengguna</label>
                        <select class="form-control custom-select" id="namaPengguna" name="namaPengguna">
                            <option value="" disabled selected>Pilih Nama Pengguna</option>
                        </select>
                        </div>
                        <div class="form-group col-md-6">
                        <label for="cariBulanLog">Tanggal Aktivitas</label>
                        <input type="month" class="form-control" id="cariBulanLog" name="cariBulanLog" value="" readonly> </br>
                        </div>
                    </div>
                    
                    <div class="card mb-2" id="cards" style=" padding : 5px; height: 330px;  overflow-y: scroll; ">
                    <div class="d-flex justify-content-between m-1">
                        <strong>Data Log Kegiatan Pengguna</strong>
                    </div>
                    <!-- tampilan table -->
                    <table class="table table-striped tableLog" id="tableLog">
                        <thead class ="h6">
                            <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" colspan="7">Silahkan Pilih Tanggal Aktivitas</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    
                </form>
            </div>
            <!-- End Card Laporan Kegiatan -->

            
    
    <!-- End Card element -->
</div>
<!-- End of Main Content -->

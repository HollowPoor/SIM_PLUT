<!-- Begin Page Content -->
<div class="container-fluid">

     <div class="card mb-3" id="cards" style="max-width: 100%; padding : 10px">
        <div class="card-deck">
            <div class="col-sm-4">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header bg-success font-weight-bold">Jumlah UMKM</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <img src="<?= base_url("assets") ?>/img/component_img/person.svg" width="100" height="100" class="rounded float-left" alt="...">
                            </div>
                            <div class="col">
                                <p class="card-text">Total UMKM Yang Terdata.</p>
                                <p class="card-text font-weight-bold text-center"><?= $hasilUMKM ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header bg-primary">Jumlah Kegiatan Saya Bulan Ini</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <img src="<?= base_url("assets") ?>/img/component_img/file.svg" width="100" height="100" class="rounded float-left" alt="...">
                            </div>
                            <div class="col">
                                <p class="card-text">Kegiatan Saya Bulan Ini.</p>
                                <p class="card-text font-weight-bold text-center"><?= $hasilKegiatanBulan ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-white bg-danger   mb-3" style="max-width: 18rem;">
                    <div class="card-header bg-danger  ">Total Kegiatan Saya</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <img src="<?= base_url("assets") ?>/img/component_img/notif.svg" width="100" height="100" class="rounded float-left" alt="...">
                            </div>
                            <div class="col">
                                <p class="card-text">Keseluruhan Kegiatan Saya.</p>
                                <p class="card-text font-weight-bold text-center"><?= $hasilKegiatanSeluruh ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-2" id="cards" style=" padding : 15px; height: 230px;  overflow-y: scroll; ">
                    <div class="d-flex justify-content-between m-1">
                        <strong>Data Log Kegiatan Saya Bulan Ini</strong>
                    </div>
                    <!-- tampilan table -->
                    <table class="table table-striped tableLog" id="tableLog">
                        <thead class ="h6">
                            <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;?>
                            <?php if($status == false) {?>
                            <tr>
                                <th class="text-center" colspan="7">Belum Ada Aktivitas</th>
                            </tr>
                            <?php }else{?>
                            <?php foreach ($Logs as $p): ?>
                            <tr>
                                <th style="max-width: 5%;" scope="row"><?=$i?></th>
                                <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 20%;"><?= $p->tanggal_log; ?></td>
                                <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 75%;"><?= $p->aktivitas_log; ?></td>
                            </tr>
                            <?php $i++?>
                            <?php endforeach;?>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
    </div>
</div>
<!-- End of Main Content -->

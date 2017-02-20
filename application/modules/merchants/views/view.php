<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pedagang
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Pedagang</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-10 col-sm-12 col-xs-12 pull-left">
                            <h4>
                                <small>
                                    <strong class="tgl-dftr"><span class="fa fa-calendar"></span></strong>
                                    <em><?php echo pretty_date($merchant['merchant_input_date']) ?></em>
                                </small>
                            </h4>
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td>Nama Toko</td>
                                        <td>:</td>
                                        <td><?php echo $merchant['merchant_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Pemilik</td>
                                        <td>:</td>
                                        <td><?php echo $merchant['merchant_owner_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>No. Telepon Toko</td>
                                        <td>:</td>
                                        <td><?php echo $merchant['merchant_phone'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td><?php echo $merchant['merchant_email'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><?php echo $merchant['merchant_address'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>No. Telepon Pemilik</td>
                                        <td>:</td>
                                        <td><?php echo $merchant['merchant_owner_phone'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo site_url('admin/merchants') ?>" class="btn btn-app">
                                <i class="fa fa-arrow-circle-o-left"></i> Batal
                            </a>
                            <a href="<?php echo site_url('admin/merchants/edit/' . $merchant['merchant_id']) ?>" class="btn btn-app">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                                <a href="#delModal" data-toggle="modal" class="btn btn-app">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->

    <div class="modal modal-danger fade" id="delModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <?php echo form_open('admin/merchants/delete/'.$merchant['merchant_id']); ?>
                    <input type="hidden" name="delName" value="<?php echo $merchant['merchant_name']; ?>">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                    <button type="submit" class="btn btn-outline"><span class="fa fa-check"></span> Hapus</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<?php
if (isset($merchant)) {
    $id = $merchant['merchant_id'];
    $NameValue = $merchant['merchant_name'];
    $PhoneValue = $merchant['merchant_phone'];
    $AddressValue = $merchant['merchant_address'];
    $EmailValue = $merchant['merchant_email'];
    $OwnerNameValue = $merchant['merchant_owner_name'];
    $OwnerPhoneValue = $merchant['merchant_owner_phone'];
} else {
    $UserNameValue = set_value('username');
    $NameValue = set_value('merchant_name');
    $PhoneValue = set_value('merchant_phone');
    $AddressValue = set_value('merchant_address');
    $EmailValue = set_value('merchant_email');
    $OwnerNameValue = set_value('merchant_owner_name');
    $OwnerPhoneValue = set_value('merchant_owner_phone');
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pedagang
            <small><?php echo $operation; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Pedagang</li>
            <li class="active"><?php echo $operation; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php echo form_open(current_url()); ?>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php echo validation_errors(); ?>
                        <?php if (isset($merchant)) { ?>
                            <input type="hidden" name="merchant_id" value="<?php echo $merchant['merchant_id']; ?>">
                        <?php }else{ ?>
                        <div class="form-group">
                            <label>Username <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="username" required="" type="text" class="form-control" value="<?php echo $UserNameValue ?>" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label>Password <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="password" required="" type="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label>PassConf <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="passconf" required="" type="password" class="form-control" placeholder="Konfirmasi Password">
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Nama Toko <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="merchant_name" required="" type="text" class="form-control" value="<?php echo $NameValue ?>" placeholder="Nama Toko">
                        </div>

                        <div class="form-group">
                            <label>No. Telepon Toko<small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="merchant_phone" required="" type="text" class="form-control" value="<?php echo $PhoneValue ?>" placeholder="No. Telepon Toko">
                        </div>

                        <div class="form-group">
                            <label>Email <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="merchant_email" required="" type="email" class="form-control" value="<?php echo $EmailValue ?>" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label>Alamat <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <textarea class="form-control" name="merchant_address" placeholder="Alamat" required=""><?php echo $AddressValue ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Nama Pedagang <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="merchant_owner_name" required="" type="text" class="form-control" value="<?php echo $OwnerNameValue ?>" placeholder="Nama Pedagang">
                        </div>   

                        <div class="form-group">
                            <label>No. Telepon <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="merchant_owner_phone" required="" type="text" class="form-control" value="<?php echo $OwnerPhoneValue ?>" placeholder="No. Telepon">
                        </div>      

                        <p class="text-muted">*) Kolom wajib diisi.</p>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <button type="submit" class="btn btn-flat btn-block btn-success"><span class="fa fa-check-circle"></span> Simpan</button>
                        <a href="<?php echo site_url('admin/merchants'); ?>" class="btn btn-flat btn-block btn-info"><span class="fa fa-arrow-circle-left"></span> Batal</a>
                        <?php if (isset($merchant) AND $this->session->userdata('uid') != $merchant['merchant_id']) { ?>
                            <a href="#delModal" class="btn btn-flat btn-block btn-danger" data-toggle="modal" ><span class="fa fa-close"></span> Hapus</a>
                        <?php } ?>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
        <!-- /.row -->
    </section>
    <!-- /.content -->

    <?php if (isset($merchant)) { ?>
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
                    <?php echo form_open('admin/merchants/delete/' . $merchant['merchant_id']); ?>
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
    <?php } ?>
</div>
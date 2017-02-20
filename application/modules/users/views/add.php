<?php
if (isset($user)) {
    $id = $user['user_id'];
    $NameValue = $user['user_name'];
    $FullNameValue = $user['user_full_name'];
    $RoleValue = $user['user_role_role_id'];
    $PobValue = $user['user_pob'];
    $DobValue = $user['user_dob'];
    $EmailValue = $user['user_email'];
} else {
    $NameValue = set_value('user_name');
    $FullNameValue = set_value('user_full_name');
    $RoleValue = set_value('role_id');
    $PobValue = set_value('user_pob');
    $DobValue = set_value('user_dob');
    $EmailValue = set_value('user_email');
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pengguna
            <small><?php echo $operation; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Pengguna</li>
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
                        <?php if (isset($user)) { ?>
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                        <?php } ?>
                        <div class="form-group">
                            <label>Nama lengkap <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="user_full_name" required="" type="text" class="form-control" value="<?php echo $FullNameValue ?>" placeholder="Nama lengkap">
                        </div>

                        <div class="form-group">
                            <label>Tempat lahir <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="user_pob" required="" type="text" class="form-control" value="<?php echo $PobValue ?>" placeholder="Tempat lahir">
                        </div>

                        <div class="form-group">
                            <label>Tanggal lahir <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="user_dob" required="" type="text" class="form-control datepicker" value="<?php echo $DobValue ?>" placeholder="Tanggal lahir">
                        </div>

                        <div class="form-group">
                            <label>Email <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="user_email" required="" type="email" class="form-control" value="<?php echo $EmailValue ?>" placeholder="Email">
                        </div>      

                        <div class="form-group">
                            <label>Username <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="user_name" required="" type="text" class="form-control" <?php echo (isset($user)) ? 'disabled' : ''; ?> value="<?php echo $NameValue ?>" placeholder="Username">
                        </div>   

                        <?php if (!isset($user)) { ?>
                            <div class="form-group">
                                <label>Password <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                                <input name="user_password" required="" type="password" class="form-control" placeholder="Password">
                            </div>            

                            <div class="form-group">
                                <label>Konfirmasi Password <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                                <input name="passconf" required="" type="password" class="form-control" placeholder="Konfirmasi Password">
                            </div>       
                        <?php } ?>

                        <div class="form-group">
                            <label>Peran <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <select name="role_id" class="form-control" required="">
                                <option value="">-Pilih Peran-</option>
                                <?php foreach ($roles as $row): ?>
                                    <option value="<?php echo $row['role_id']; ?>" <?php echo ($RoleValue == $row['role_id']) ? 'selected' : '' ?>><?php echo $row['role_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
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
                        <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-flat btn-block btn-info"><span class="fa fa-arrow-circle-left"></span> Batal</a>
                        <?php if (isset($user) AND $this->session->userdata('uid') != $user['user_id']) { ?>
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

    <?php if (isset($user)) { ?>
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
                    <?php echo form_open('admin/users/delete/' . $user['user_id']); ?>
                    <input type="hidden" name="delName" value="<?php echo $user['user_full_name']; ?>">
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
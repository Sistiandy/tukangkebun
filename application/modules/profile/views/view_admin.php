<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Profile
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Profile</li>
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
                            <div class="col-md-2 col-sm-2 hidden-xs pull-left">
                                <img src="<?php echo media_url() ?>img/user.png" class="img-responsive">
                            </div>
                            <div class="col-xs-12 hidden-lg hidden-md hidden-sm">
                                <center>
                                    <img src="<?php echo media_url() ?>img/user.png" class="img-responsive img-prfl">
                                </center>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 pull-left">
                                <p class="pull-left"><h3><?php echo $user['user_name'] ?></h3>
                                <span><i><?php echo $user['user_full_name'] ?></i></span>
                                </p>
                                <p><?php echo $user['user_email'] ?></p>
                                <p>Peran : <?php echo $user['role_name']; ?></p>
                            </div>
                            <div class="col-md-3 col-sm-10 col-xs-12">
                                <h4 class="pull-right">
                                    <small>
                                        <strong class="tgl-dftr pull-right">TANGGAL DAFTAR</strong><br>
                                        <em><?php echo pretty_date($user['user_input_date']) ?></em>
                                    </small>
                                </h4>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-app">
                                    <i class="fa fa-edit"></i> Edit
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
</div>
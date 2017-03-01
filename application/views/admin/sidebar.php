<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo media_url() ?>/img/user.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst($this->session->userdata('ufullname')); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?php echo ($this->uri->segment(2) == 'dashboard' OR $this->uri->segment(2) == NULL) ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'dashboard' OR $this->uri->segment(2) == NULL) ? 'active' : '' ?>"><a href="<?php echo site_url('admin') ?>"><i class="fa <?php echo ($this->uri->segment(2) == 'dashboard' OR $this->uri->segment(2) == NULL) ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Dashboard</a></li>
                </ul>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'merchants') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Pedagang</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'merchants' AND $this->uri->segment(3) != 'add') ? 'active' : '' ?> ">
                        <a href="<?php echo site_url('admin/merchants') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'merchants' AND $this->uri->segment(3) != 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Daftar Pedagang</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'users') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Pengguna</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'users' AND $this->uri->segment(3) != 'add') ? 'active' : '' ?> ">
                        <a href="<?php echo site_url('admin/users') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'users' AND $this->uri->segment(3) != 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Daftar Pengguna</a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(2) == 'users' AND $this->uri->segment(3) == 'add') ? 'active' : '' ?> ">
                        <a href="<?php echo site_url('admin/users/add') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'users' AND $this->uri->segment(3) == 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Tambah Pengguna</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'logs') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-clock-o"></i> <span>Log Aktifitas</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'logs' AND $this->uri->segment(3) != 'add') ? 'active' : '' ?> ">
                        <a href="<?php echo site_url('admin/logs') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'logs' AND $this->uri->segment(3) != 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Daftar Log Aktifitas</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
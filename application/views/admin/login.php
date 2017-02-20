<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>LOGIN</title>
        <link rel="icon" href="<?php echo media_url('ico/favicon.jpg'); ?>" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo media_url() ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo media_url() ?>css/login.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <h1 class="text-center login-title">Sign in to continue</h1>
                    <div class="account-wall">
                        <img class="profile-img" src="<?php echo media_url() ?>img/user.png"
                             alt="">
                        <form class="form-signin" role="form" action="<?php echo site_url('admin/auth/login') ?>" method="post">
                            <?php
                            echo form_open(current_url(), array('role' => 'form', 'class' => 'form-signin'));
                            if (isset($_GET['location'])) {
                                echo '<input type="hidden" name="location" value="';
                                if (isset($_GET['location'])) {
                                    echo htmlspecialchars($_GET['location']);
                                }
                                echo '" />';
                            }
                            ?>
                            <?php if ($this->session->flashdata('failed')) { ?>
                                <div class="callout callout-danger">
                                    <h5><i class="glyphicon glyphicon-warning-sign"></i> Username atau password salah!</h5>

                                    </div>
                            <?php } ?>
                            <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">
                                Sign in</button>
                        </form>
                    </div>
                    <a href="#" class="text-center new-account">Create an account </a>
                </div>
            </div>
        </div>
    </body>
</html>
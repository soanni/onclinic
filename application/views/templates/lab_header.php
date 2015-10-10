<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php if (isset($title)){echo $title; }?></title>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url('assets/js/jquery-ui-1.11.4.autocomplete/external/jquery-ui.css');?>" type="text/css">
    </head>
    <body>
        <div id="header">
            <a href="<?php echo site_url();?>" class="logo"><img src="<?php echo base_url('assets/images/logo.png'); ?>" alt=""></a>
            <ul>
                    <li <?php if(uri_string() == ''){echo 'class="selected"';}?>>
                        <a href="<?php echo site_url();?>">home</a>
                    </li>
                    <li <?php if(uri_string() == 'services'){echo 'class="selected"';}?>>
                        <a href="<?php echo site_url('services');?>">Services</a>
                    </li>

                <?php if(!isset($_SESSION['logged_in'])): ?>
                    <li <?php if(uri_string() == 'patient/login'){echo 'class="selected"';}?>>
                        <a href="<?php echo site_url('patient/login');?>">Patient Login</a>
                    </li>
                    <li <?php if(uri_string() == 'operator/login'){echo 'class="selected"';}?>>
                        <a href="<?php echo site_url('operator/login');?>">Employee Login</a>
                    </li>
                <?php endif; ?>

                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['is_operator']): ?>
                    <li <?php if(strpos(current_url(),'operator/profile')){echo 'class="selected"';}?>>
                        <a href="<?php echo site_url('operator/profile');?>">Employee profile</a>
                    </li>
                <?php endif; ?>

                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['is_patient']): ?>
                    <li <?php if(strpos(current_url(),'report/index')){echo 'class="selected"';}?>>
                        <a href="<?php echo site_url('report/index/' . $_SESSION['user_id']);?>">Reports list</a>
                    </li>
                <?php endif; ?>

                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                    <li>
                        <?php
                            echo "<span class='auth'> Welcome, {$_SESSION['username']}</span>";
                            echo "<a href='" . site_url('operator/logout') . "'>Logout</a>";
                        ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

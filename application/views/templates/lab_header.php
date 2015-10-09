<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php if (isset($title)){echo $title; }?></title>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>" type="text/css">
    </head>
    <body>
        <div id="header">
            <a href="<?php echo site_url();?>" class="logo"><img src="<?php echo base_url('assets/images/logo.png'); ?>" alt=""></a>
            <ul>
                <?php if(!isset($_SESSION['logged_in'])): ?>
                    <li class="selected">
                        <a href="<?php echo site_url();?>">home</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('services');?>">Services</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('user/login');?>">Patient Login</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('operator/login');?>">Employee Login</a>
                    </li>
                <?php endif; ?>
                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['is_operator']): ?>
                    <li>
                        <a href="<?php echo site_url('patient/list');?>">Patient List</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('patient/create');?>">Patient Create</a>
                    </li>
                    <li>
                        <?php
                            echo "Welcome, {$_SESSION['username']}";
                            echo "<a href='" . site_url('operator/logout') . "'>Logout</a>";
                        endif; ?>
                    </li>
                </li>
            </ul>
        </div>

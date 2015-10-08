<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>" type="text/css">
    </head>
    <body>
        <div id="header">
            <a href="<?php echo site_url();?>" class="logo"><img src="<?php echo base_url('assets/images/logo.png'); ?>" alt=""></a>
            <ul>
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
            </ul>
        </div>

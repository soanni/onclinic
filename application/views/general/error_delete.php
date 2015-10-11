<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    include APPPATH . 'views\templates\lab_header.php';
?>
<div id="body">
    <?php include_once APPPATH . 'views\templates\lab_sidebar.php';?>
    <?php if(isset($error)) : ?>
        <div>
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <div class="content">
    </div>
</div>
<?php include APPPATH . 'views\templates\lab_footer.php'; ?>
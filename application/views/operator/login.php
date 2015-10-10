<?php
    defined('BASEPATH') or exit('No direct script access allowed');
?>
<div id="body">
    <?php
        echo validation_errors();
        if(isset($error)) : ?>
            <div>
                <?php echo $error; ?>
            </div>
    <?php endif; ?>
    <div class="content">
        <h2 class="main_heading">please provide your credentials to log in</h2>
        <?= form_open('operator/login') ?>
            <label for="username"> <span>Username*</span>
                <input type="text" name="username" id="username" placeholder="Please provide your username">
            </label>
            <label for="pass"> <span>Password*</span>
                <input type="password" name="pass" id="pass" placeholder="Please provide your password">
            </label>
            <input type="submit" value="" id="submit">
        </form>
    </div>
</div>
<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    include APPPATH . 'views\templates\lab_header.php'; ?>
<div id="body">
    <?php if(isset($error)) : ?>
        <div>
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <div class="content">
        <h2>Create new patient</h2>
        <?= form_open('patient/create');?>
            <label for="first"><span>Firstname:</span>
                <input type="text" name="firstname" id="first" value="<?php echo set_value('firstname');?>" placeholder="Please enter patient's first name" required>
                <?php echo form_error('firstname',"<div class='error'>",'</div>')?>
            </label>
            <label for="last"><span>Lastname:</span>
                <input type="text" name="lastname" id="last" value="<?php echo set_value('lastname')?>" placeholder="Please enter patient's last name" required>
                <?php echo form_error('lastname',"<div class='error'>",'</div>')?>
            </label>
            <label for="age"><span>Age:</span>
                <input type="number" name="age" id="age" value="<?php echo set_value('age')?>" min = "0" max="120" placeholder="Please enter patient's age" required>
                <?php echo form_error('age',"<div class='error'>",'</div>')?>
            </label>
            <label for="sex"><span>Sex:</span>
                <select name="sex" id="sex">
                    <option value="1" selected>Male</option>
                    <option value="2">Female</option>
                    <option value="3">Not selected</option>
                </select>
            </label>
            <label for="ssn"><span>Social Security Number:</span>
                <input type="text" name="ssn" id="ssn" value="<?php echo set_value('ssn')?>" placeholder="Please enter patient's SSN" required>
                <?php echo form_error('ssn',"<div class='error'>",'</div>')?>
            </label>
            <label for="phone"><span>Phone number:</span>
                <input type="text" name="telephone" id="phone" value="<?php echo set_value('telephone')?>" placeholder="Phone number format x-xxx-xxx-xxxx" required>
                <?php echo form_error('telephone',"<div class='error'>",'</div>')?>
            </label>
            <label for="email"><span>Email address:</span>
                <input type="email" name="email" id="email" value="<?php echo set_value('email')?>" placeholder="Please enter patient's email" required>
                <?php echo form_error('email',"<div class='error'>",'</div>')?>
            </label>
            <!--passcode is auto-generated in controller -->
            <label for="passcode"><span>Passcode:</span>
                <input type="text" name="passcode" id="passcode" value="<?php if(isset($passcode)){echo $passcode;}?>" required>
            </label>
            <label for="birthday"><span>Birthday:</span>
                <input type="date" name="birthday" id="birthday" value="<?php echo set_value('birthday')?>" placeholder="Please enter patient's birth date" required>
                <?php echo form_error('birthday',"<div class='error'>",'</div>')?>
            </label>
            <input type="submit" value="" id="submit">
        </form>
    </div>
</div>
<?php include APPPATH . 'views\templates\lab_footer.php'; ?>
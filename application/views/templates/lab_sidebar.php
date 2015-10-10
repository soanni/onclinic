<div class="sidebar">
    <ul>
        <li <?php if(uri_string() == 'patient/index'){echo 'class="selected"';}?>>
            <a href="<?php echo site_url('patient/index');?>">Patient List</a>
        </li>
        <li <?php if(uri_string() == 'patient/create'){echo 'class="selected"';}?>>
            <a href="<?php echo site_url('patient/create');?>">Patient Create</a>
        </li>
        <li <?php if(uri_string() == 'report/create'){echo 'class="selected"';}?>>
            <a href="<?php echo site_url('report/create');?>">Report Create</a>
        </li>
        <li <?php if(uri_string() == 'report/create'){echo 'class="selected"';}?>>
            <a href="<?php echo site_url('report/index');?>">Report list</a>
        </li>
    </ul>
</div>
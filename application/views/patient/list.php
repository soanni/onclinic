<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    include APPPATH . 'views\templates\lab_header.php';
?>
    <div id="body">
        <div class="content">
            <h2 class="main_heading">List of patients</h2>
            <table id="patients">
                <thead>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>SSN</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th>Birthday</th>
                    <th>Locked</th>
                    <th>Update</th>
                    <th>Delete</th>
                    <th>Switch</th>
                    <th>Reports</th>
                </thead>
                <tbody>
                <?php foreach($result as $row):?>
                    <tr class = "<?php if(!$row['locked']){
                        echo 'active';
                    }else{
                        echo 'noactive';
                    }
                    ?>">
                        <td><?php echo htmlspecialchars(ucfirst($row['firstname']));?></td>
                        <td><?php echo htmlspecialchars(ucfirst($row['lastname']));?></td>
                        <td>
                        <?php echo htmlspecialchars($row['age']);?>
                        </td>
                        <td><?php if($row['sex'] == 1){echo 'Male';}elseif($row['sex'] == 2){echo 'Female';}else{echo 'Not selected';}?></td>
                        <td><?php echo htmlspecialchars($row['ssn']);?></td>
                        <td><?php echo htmlspecialchars($row['telephone']);?></td>
                        <td><?php echo htmlspecialchars($row['email']);?></td>
                        <td><?php echo nice_date($row['birthday'],'Y-m-d'); ?></td>
                        <td><?php if($row['locked']){ echo 'Locked';}else{echo 'Active';}?></td>
                        <td><a href="<?php echo site_url('patient/edit') . '/' .$row['patient_id'];?>">Update</a></td>
                        <td><a href="<?php echo site_url('patient/delete/') . '/' .$row['patient_id'];?>">Delete</a></td>
                        <?php if($row['locked']):?>
                            <td><a href="<?php echo site_url('patient/unlock/') . '/' .$row['patient_id'];?>">Enable</a></td>
                        <?php else: ?>
                            <td><a href="<?php echo site_url('patient/lock/') . '/' .$row['patient_id'];?>">Disable</a></td>
                        <?php endif;?>
                        <td><a href="<?php echo site_url('report/index/') . '/' .$row['patient_id'];?>">Reports</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include APPPATH . 'views\templates\lab_footer.php';?>
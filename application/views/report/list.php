<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    include APPPATH . 'views\templates\lab_header.php';
?>
    <div id="body">
        <div class="content">
            <h2 class="main_heading">List of ALL patients reports</h2>
            <?php foreach($patients as $key => $value):?>
                <?php if(!empty($reports[$key])): ?>
                    <h2><?php echo $value;?></h2>
                    <table class="reports">
                        <thead>
                            <tr>
                                <th>Report date</th>
                                <th>Doctor name</th>
                                <th>Patient firstname</th>
                                <th>Patient lastname</th>
                                <th>Patient SSN</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($reports[$key] as $row):?>
                            <tr>
                                <td><?php echo nice_date($row['created'],'Y-m-d'); ?></td>
                                <td><?php echo htmlspecialchars($row['doctorname']);?></td>
                                <td><?php echo htmlspecialchars(ucfirst($row['firstname']));?></td>
                                <td><?php echo htmlspecialchars(ucfirst($row['lastname']));?></td>
                                <td><?php echo htmlspecialchars($row['ssn']);?></td>
                                <td><?php echo htmlspecialchars($row['telephone']);?></td>
                                <td><?php echo htmlspecialchars($row['email']);?></td>
                                <td><a href="<?php echo site_url('report/edit') . '/' .$row['reportid'];?>">Update</a></td>
                                <td><a href="<?php echo site_url('report/delete/') . '/' .$row['reportid'];?>">Delete</a></td>
                                <td><a href="<?php echo site_url('report/view/') . '/' .$row['reportid'];?>">View</a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif;?>
            <?php endforeach; ?>
        </div>
    </div>
<?php include APPPATH . 'views\templates\lab_footer.php';?>
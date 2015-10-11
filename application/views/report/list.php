<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    include APPPATH . 'views\templates\lab_header.php';
?>
    <div id="body">
        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['is_operator']): ?>
            <?php include_once APPPATH . 'views\templates\lab_sidebar.php';?>
        <?php endif; ?>
        <?php if(isset($error)) : ?>
            <div>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <div class="content">
            <h2 class="main_heading"><?php echo $heading;?></h2>
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
                                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['is_operator']): ?>
                                    <th>Update</th>
                                    <th>Delete</th>
                                <?php endif; ?>
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
                                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['is_operator']):?>
                                    <td><a href="<?php echo site_url('report/edit') . '/' .$row['reportid'];?>">Update</a></td>
                                    <td><a href="<?php echo site_url('report/delete/') . '/' .$row['reportid'];?>">Delete</a></td>
                                <?php endif;?>
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
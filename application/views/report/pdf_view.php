<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>" type="text/css">
    </head>
    <body>
        <div id="body">
            <p class="content">
            <h2 class="main_heading"><?php echo "Report #{$head['reportid']}";?></h2>
            <div class="report_head">
                <p>
                <ul>
                    <li>Report #: <?php echo $head['reportid'];?></li>
                    <li>Report date: <?php echo $head['created'];?></li>
                    <li>Doctor: <?php echo htmlspecialchars(ucfirst($head['doctorname']));?></li>
                    <li>Patient firstname: <?php echo htmlspecialchars(ucfirst($head['firstname']));?></li>
                    <li>Patient lastname: <?php echo htmlspecialchars(ucfirst($head['lastname']));?></li>
                    <li>Patient SSN: <?php echo $head['ssn'];?></li>
                    <li>Patient tel: <?php echo $head['telephone'];?></li>
                    <li>Patient email: <?php echo $head['email'];?></li>
                </ul>
                        <span>Doctor comment: <span>
                        <?php echo htmlspecialchars($head['comment']);?>
                                </p>
            </div>
            <div class="report_details">
                <table class="inner_report">
                    <thead>
                    <tr>
                        <th>Test</th>
                        <th>Value</th>
                        <th>Min Range</th>
                        <th>Max Range</th>
                        <th>Unit</th>
                        <th>Comment</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($details as $row):?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['testname']);?></td>
                            <td><?php echo $row['value'];?></td>
                            <td><?php echo $row['range_min'];?></td>
                            <td><?php echo $row['range_max'];?></td>
                            <td><?php echo htmlspecialchars($row['unitname']);?></td>
                            <td><?php echo htmlspecialchars($row['testcomment']);?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
<?php include_once APPPATH . 'views\templates\lab_header.php'; ?>
<div id="body">
    <?php include_once APPPATH . 'views\templates\lab_sidebar.php';?>
    <?php if(isset($error)) : ?>
        <div>
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <div class="content">
        <h2 class="main_heading">Update report</h2>
        <?php echo validation_errors(); ?>
        <?= form_open('report/edit/' . $head['reportid']);?>
            <label for="patient"><span>Patient:</span>
                <?= form_dropdown('patient',$patients,$head['patientid'],'id = "patient"');?>
            </label>
            <label for="doctor"><span>Doctor:</span>
                <?= form_dropdown('doctor',$doctors,$head['doctorid'],'id = "doctor"');?>
            </label>
            <label for="comment"><span>Doctor's comments:</span>
                <textarea name="comment" id="comment" cols="60" rows="8"><?php htmlspecialchars($head['comment']);?></textarea>
            </label>
            <h2>Tests Results</h2>
            <p>
                <input type="button" value="Add Test" onClick = "addRow('tests')">
                <input type="button" value="Remove Test" onClick = "deleteRow('tests')">
            </p>
            <table id="tests" border="1">
                <thead>
                <tr>
                    <th>Test</th>
                    <th>Result</th>
                    <th>Doctor's commentary</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($details as $row):?>
                    <tr>
                        <td>
                            <?= form_dropdown('test[]',$tests,$row['testid'],'id = "test" required placeholder="test"');?>
                        </td>
                        <td>
                            <input type="number" name="result[]" id="result" value = "<?php echo $row['value'];?>" step="0.1" required placeholder="Test result">
                        </td>
                        <td>
                            <input type="text" name="test_comment[]" id="test_comment" value = "<?php echo htmlspecialchars($row['testcomment']);?>" placeholder="Test comment">
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <?= form_submit('Update','UpdateReport','id="create_report"');?>
        <?= form_close('</div></div>');?>
<?php include_once APPPATH . 'views\templates\lab_footer.php';
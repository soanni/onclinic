<?php
    // header
    include_once APPPATH . 'views\templates\lab_header.php';
?>
    <div id="body">
        <?php include_once APPPATH . 'views\templates\lab_sidebar.php';?>
        <?php if(isset($error)) : ?>
            <div>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <div class="content">
            <h2 class="main_heading">Create new report</h2>
            <?php echo validation_errors(); ?>
            <?= form_open('report/create');?>
                <label for="patient"><span>Patient:</span>
                    <?= form_dropdown('patient',$patients,'id = "patient"');?>
                </label>
                <label for="doctor"><span>Doctor:</span>
                    <?= form_dropdown('doctor',$doctors,'id = "doctor"');?>
                </label>
                <label for="comment"><span>Doctor's comments:</span>
                    <textarea name="comment" id="comment" cols="60" rows="8"></textarea>
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
                        <tr>
                            <td>
                                <?= form_dropdown('test[]',$tests,'id = "test" required placeholder="test"');?>
                            </td>
                            <td>
                                <input type="number" name="result[]" id="result" step="0.1" required placeholder="Test result">
                            </td>
                            <td>
                                <input type="text" name="test_comment[]" id="test_comment" placeholder="Test comment">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?= form_submit('Create','CreateReport','id="create_report"');?>
            <?= form_close('</div></div>');?>
<?php include_once APPPATH . 'views\templates\lab_footer.php';
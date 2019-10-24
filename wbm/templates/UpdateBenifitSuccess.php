<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">


    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Edit Benefit") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <?php echo message() ?>
            <?php echo $form['_csrf_token']; ?>
            <br class="clear"/>
            <div class="leftCol">
                <label class=""><?php echo __("Benefit Type") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select name="cmbbtype" id="cmbbtype" class="formSelect">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($loadbtype as $btype) {
 ?>
                        <option value="<?php echo $btype->getBt_id(); ?>" <?php if ($btype->getBt_id() == $benifittypelist->getBt_id())
                            echo"selected"; ?>> <?php
                        if ($Culture == 'en') {
                            echo $btype->getBt_name();
                        } elseif ($Culture == 'si') {
                            if (($btype->getBt_name_si()) == null) {
                                echo $btype->getBt_name();
                            } else {
                                echo $btype->getBt_name_si();
                            }
                        } elseif ($Culture == 'ta') {
                            if (($btype->getBt_name_ta()) == null) {
                                echo $btype->getBt_name();
                            } else {
                                echo $btype->getBt_name_ta();
                            }
                        }
                    ?></option>
<?php } ?>
                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                &nbsp;
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("English") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Sinhala") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Tamil") ?></label>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label  for="txtLocationCode"><?php echo __("Benefit Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <textarea id="txtName"  name="txtName" type="text"  class="formTextArea"  tabindex="1" ><?php echo $benifittypelist->getBst_name() ?></textarea>
            </div>


            <div class="centerCol">
                <textarea id="txtJobTitleDesc" class="formTextArea" tabindex="2" name="txtNamesi"  type="text"><?php echo $benifittypelist->getBst_name_si() ?></textarea>

            </div>
            <div class="centerCol">
                <textarea id="txtJobTitleComments" class="formTextArea" tabindex="3" name="txtNameta"  type="text"><?php echo $benifittypelist->getBst_name_ta() ?></textarea>

            </div>
            <br class="clear"/>


        </form>



        <div class="formbuttons">
            <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                   value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
            <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                   value="<?php echo __("Reset"); ?>" />
            <input type="button" class="backbutton" id="btnBack"
                   value="<?php echo __("Back") ?>" tabindex="18"  onclick="goBack();"/>
        </div>

    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>

<script type="text/javascript">

		

    $(document).ready(function() {
        buttonSecurityCommon("null","null","editBtn","null");
<?php if ($editMode == true) { ?>
                              $('#frmSave :input').attr('disabled', true);
                              $('#editBtn').removeAttr('disabled');
                              $('#btnBack').removeAttr('disabled');
<?php } ?>

                       //Validate the form
                       $("#frmSave").validate({

                           rules: {
                               cmbbtype: { required: true },
                               txtName: { required: true,noSpecialCharsOnly: true, maxlength:200 },
                               txtNamesi: {noSpecialCharsOnly: true, maxlength:200 },
                               txtNameta: {noSpecialCharsOnly: true, maxlength:200 }
                           },
                           messages: {
                               cmbbtype: "<?php echo __("Please select Benefit") ?>",
                               txtName: {required:"<?php echo __("Benefit is required in English") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                               txtNamesi:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                               txtNameta:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}
                           }
                       });

                       // When click edit button
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock

                               location.href="<?php echo url_for('wbm/UpdateBenifit?id=' . $benifittypelist->getBst_id() . '&lock=1') ?>";
                           }
                           else {

                               $('#frmSave').submit();
                           }


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/wbm/Benifit')) ?>";
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           location.href="<?php echo url_for('wbm/UpdateBenifit?id=' . $benifittypelist->getBst_id() . '&lock=0') ?>";
                       });

                   });
</script>

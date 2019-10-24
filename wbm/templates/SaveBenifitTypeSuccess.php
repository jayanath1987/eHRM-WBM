<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col" >
    <div class="navigation">

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Define Benefit Type") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="">
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
                <label for="txtLocationCode"><?php echo __("Benefit Type Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <textarea id="txtName"  name="txtName"  class="formTextArea" rows="3" cols="5" tabindex="1" ></textarea>
            </div>


            <div class="centerCol">
                <textarea id="txtJobTitleDesc" class="formTextArea" rows="3" cols="5"  tabindex="2" name="txtNamesi"></textarea>

            </div>
            <div class="centerCol">
                <textarea id="txtJobTitleComments" class="formTextArea" rows="3" cols="5"  tabindex="3" name="txtNameta" ></textarea>

            </div>
            <br class="clear"/>
            <br class="clear"/>
            <div class="formbuttons">
                <input type="button" class="savebutton" id="editBtn"

                       value="<?php echo __("Save") ?>" tabindex="8" />
                <input type="button" class="clearbutton"  id="resetBtn"
                       value="<?php echo __("Reset") ?>" tabindex="9" />
                <input type="button" class="backbutton" id="btnBack"
                       value="<?php echo __("Back") ?>" tabindex="10" />
            </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>

<script type="text/javascript">

    $(document).ready(function() {
        buttonSecurityCommon("null","editBtn","null","null");


        //Validate the form
        $("#frmSave").validate({

            rules: {
                txtName: { required: true,noSpecialCharsOnly: true, maxlength:100 },
                txtNamesi: {noSpecialCharsOnly: true, maxlength:100 },
                txtNameta: {noSpecialCharsOnly: true, maxlength:100 }
            },
            messages: {
                txtName: {required:"<?php echo __("BenefitType is required in English") ?>",maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtNamesi:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtNameta:{maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}
                                        
            }
        });

        // When click edit button
        $("#editBtn").click(function() {
            $('#frmSave').submit();
        });

        //When click reset buton
        $("#resetBtn").click(function() {
            document.forms[0].reset('');
        });

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/wbm/BenifitType')) ?>";
        });

    });
</script>

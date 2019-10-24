<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Define Benefit") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel"><?php echo __("Benefit Type") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select name="cmbbtype" id="cmbbtype" class="formSelect">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($loadbtype as $btype) {
 ?>
                        <option value="<?php echo $btype->getBt_id(); ?>" > <?php
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
                <label  for="txtLocationCode" class="controlLabel"><?php echo __("Benefit Name") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <textarea id="txtName"  name="txtName" type="text"  class="formTextArea" value="" tabindex="1" ></textarea>
            </div>


            <div class="centerCol">
                <textarea id="txtJobTitleDesc" class="formTextArea" tabindex="2" name="txtNamesi" type="text"></textarea>

            </div>

            <div class="centerCol">
                <textarea id="txtJobTitleComments" class="formTextArea" tabindex="3" name="txtNameta" type="text"></textarea>

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
                cmbbtype: { required: true },
                txtName: { required: true,noSpecialCharsOnly: true, maxlength:100 },
                txtNamesi: {noSpecialCharsOnly: true, maxlength:100 },
                txtNameta: {noSpecialCharsOnly: true, maxlength:100 }
            },
            messages: {
                cmbbtype: "<?php echo __("Please select Benefit") ?>",
                txtName: {required:"<?php echo __("Benefit is required in English") ?>",maxlength:"<?php echo __("Maximum 100 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
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
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/wbm/Benifit')) ?>";
        });

        //When click Add Pay Grade
        $("#addPayGrade").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/savePromotioncklist')) ?>";
        });

        //When click Edit Pay Grade
        $("#editPayGrade").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/savePromotioncklist')) ?>";
        });
    });
</script>

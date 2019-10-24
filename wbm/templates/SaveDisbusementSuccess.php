<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Benefit Disbursement") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Employee Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input type="text" name="txtEmployeeName" disabled="disabled" id="txtEmployee" value="<?php echo $empfname; ?>" readonly="readonly"/>
                <input type="hidden" name="txtEmpId" id="txtEmpId" value="<?php echo $etid; ?>"/>&nbsp;
            </div>
            <div class="centerCol">
                <input class="button" type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php echo $disabled; ?> />
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label class=""><?php echo __("Benefit Type") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">

                <select name="cmbbtype" id="cmbbtype" onchange="getbenfittype(this.value);">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($loadbtype as $btype) {
 ?>
                        <option value="<?php echo $btype->getBt_id(); ?>" <?php if ($cmbbtId == $btype->getBt_id()
                            )echo "selected"; ?>> <?php
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
                <label class=""><?php echo __("Benefit") ?><span class="required">*</span></label>
            </div>

            <div class="centerCol" >
                <select name="cmbbstype" id="cmbbstype" >
                    <option value=""><?php echo __("--Select--") ?></option>

                </select>

            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Disbursement Date") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="disbdate" type="text" name="txtdisbdate" value="<?php //echo $extfdate; ?>">
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Comment") ?></label>
            </div>
            <div class="centerCol">
                <textarea cols="" rows=""  id="txtcom"  maxlength="200" name="txtcomment" type="text"  class="formTextArea" style="margin-left: 0px; margin-top: 0px; height: 80px; width: 320px;" value="" tabindex="1" ></textarea>
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
<?php
                    require_once '../../lib/common/LocaleUtil.php';
                    $sysConf = OrangeConfig::getInstance()->getSysConf();
                    $sysConf = new sysConf();
                    $inputDate = $sysConf->dateInputHint;
                    $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
                    <script type="text/javascript">
                        function SelectEmployee(data){

                            myArr = data.split('|');
                            $("#txtEmpId").val(myArr[0]);
                            $("#txtEmployee").val(myArr[1]);
                        }
                        function getbenfittype(id){
                            btId=id;


                            $.post(

                            "<?php echo url_for('wbm/Checkbtype') ?>", //Ajax file

                            { id: id },  // create an object will all values

                            //function that is called when server returns a value.
                            function(data){

                                var selectbox="<option value=''><?php echo __('--Select--') ?></option>";
                                $.each(data, function(key, value) {
                                    selectbox=selectbox +"<option value="+key+">"+value+"</option>";
                                });
                                $('#cmbbstype').html(selectbox);



                            },

                            //How you want the data formated when it is returned from the server.
                            "json"

                        );


                        }

                        $(document).ready(function() {
                            buttonSecurityCommon("null","editBtn","null","null");

                            $('#empRepPopBtn').click(function() {

                                var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
                                if(!popup.opener) popup.opener=self;
                                popup.focus();
                            });

                            jQuery.validator.addMethod("orange_date",
                            function(value, element, params) {

                                var format = params[0];

                                // date is not required
                                if (value == '') {

                                    return true;
                                }
                                var d = strToDate(value, "<?php echo $format ?>");


                                return (d != false);

                            }, ""
                        );
                            //Validate the form
                            $("#frmSave").validate({

                                rules: {
                                    txtEmpId: { required: true },
                                    cmbbtype: { required: true },
                                    cmbbstype: { required: true },
                                    txtdisbdate: { required: true ,orange_date:true},
                                    txtcomment: {noSpecialCharsOnly: true, maxlength:200 }

                                },
                                messages: {
                                    txtEmpId: "<?php echo __("Please Select the Employee Name") ?>",
                                    cmbbtype: "<?php echo __("Please select Benefit Type") ?>",
                                    cmbbstype: "<?php echo __("Please select Benefit") ?>",
                                    txtdisbdate: {required:"<?php echo __("Please Enter Date") ?>",orange_date: "<?php echo __("Please specify valid date") ?>"},
                                    txtcomment:{maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}

                                }

                            });

                            // When click edit button
                            $("#editBtn").click(function() {
                                //var retid=$('#txtcom').blur(function(){
                                var username_length;
                                username_length = $("#txtcom").val().length;

                                //alert(retid);
                                if(username_length > 200){
                                    alert("<?php echo __("Comment field length should be lessthan 200 character") ?>");
                                    //$("#txtcom").append("Comment field");
                                    return false;
                                }


                                $('#frmSave').submit();
                            });

                            //When click reset buton
                            $("#resetBtn").click(function() {
                                document.forms[0].reset('');
                            });

                            //When Click back button
                            $("#btnBack").click(function() {
                                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/wbm/Disbusement')) ?>";
                            });


                            $("#disbdate").datepicker({ dateFormat:'<?php echo $inputDate; ?>' });

    });
</script>

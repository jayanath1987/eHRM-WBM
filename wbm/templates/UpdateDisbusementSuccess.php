    <?php
if ($lockMode=='1') {
        $editMode = false;
        $disabled = '';
    } else {
        $editMode = true;
        $disabled = 'disabled="disabled"';
    }
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js')?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css')?>" rel="stylesheet" type="text/css"/>
<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>

<div class="formpage4col">
        <div class="navigation">
        	
                 
        </div>
        <div id="status"></div>
        <div class="outerbox">
            <div class="mainHeading"><h2><?php echo __("Edit Benefit Disbursement")?></h2></div>
            	<form name="frmSave" id="frmSave" method="post"  action="">
                    <?php echo message()?>
            	<?php echo $form['_csrf_token']; ?>
                
                <br class="clear"/>
                <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Employee Name")?> <span class="required">*</span></label>
                </div>
                <div class="centerCol">
                    <input type="text" name="txtEmployeeName" disabled="disabled"
               id="txtEmployee" value="<?php echo $benifittypelist->Employee->getEmp_lastname(); ?>" readonly="readonly" style="color: #222222"/>
                </div>
                <div class="centerCol">
                 </div>
                
                 <div class="leftCol">&nbsp;</div>
                 <div class="centerCol">
                 <input  type="hidden" name="txtEmpId" id="txtEmpId" value="<?php echo $benifittypelist->getEmp_number();?>"/>
                 <input  type="hidden" name="txtBenID" id="txtEmpId" value="<?php echo $benifittypelist->getBen_id();?>"/>
                 </div>

                <br class="clear"/>
                <div class="leftCol">
                <label class=""><?php echo __("Benefit Type")?><span class="required">*</span></label>
                </div>
              <div class="centerCol">
                    <select name="cmbbtype" id="cmbbtype" onchange="getbenfittype(this.value);">
	            <option value="all"><?php echo __("--Select--")?></option>
                    <?php foreach ($loadbtype as $btype){  ?>
                    <option value="<?php echo $btype->getBt_id();?>" <?php if($btype->getBt_id()==$benifittypelist->getBt_id()) echo"selected"; ?>> <?php if($Culture=='en'){echo $btype->getBt_name();}
                                                elseif($Culture=='si'){ if(($btype->getBt_name_si())==null){ echo $btype->getBt_name(); }else{ echo $btype->getBt_name_si();} }
                                                elseif($Culture=='ta'){ if(($btype->getBt_name_ta())==null){ echo $btype->getBt_name(); }else{ echo $btype->getBt_name_ta();} }?></option>
                    <?php } ?>
                    </select>
                </div>
                <br class="clear"/>
                <div class="leftCol">
                <label class=""><?php echo __("Benefit")?><span class="required">*</span></label>
                </div>

                <div class="centerCol" >
                    <select name="cmbbstype" id="cmbbstype" >
                        <option value=""><?php echo __("--Select--")?></option>
                        <?php foreach ($loadbstype as $btype){  ?>
                        <option value="<?php echo $btype->getBst_id();?>" <?php if($btype->getBst_id()==$benifittypelist->getBst_id()) echo"selected"; ?>><?php if($Culture=='en'){echo $btype->getBst_name();}
                                                elseif($Culture=='si'){ if(($btype->getBst_name_si())==null){ echo $btype->getBst_name(); }else{ echo $btype->getBst_name_si();} }
                                                elseif($Culture=='ta'){ if(($btype->getBst_name_ta())==null){ echo $btype->getBst_name(); }else{ echo $btype->getBst_name_ta();} }?></option>
                    <?php } ?>
                    </select>
                    </div>
               
             
                <br class="clear"/>
                 <div class="leftCol">
                     <label for="txtLocationCode"><?php echo __("Disbursement Date")?> <span class="required">*</span></label>
                 </div>
                 <div class="centerCol">
                    <input id="disbdate" type="text" name="txtdisbdate" value="<?php echo LocaleUtil::getInstance()->formatDate($benifittypelist->getBen_date());?>">
                 </div>
                <br class="clear"/>
                 <div class="leftCol">
                 <label for="txtLocationCode"><?php echo __("Comment")?></label>
                </div>
                 <div class="centerCol">
                     <textarea cols="" rows=""  id="txtcom" maxlength="200" name="txtcomment" type="text" style="margin-left: 0px; margin-top: 0px; height: 80px; width: 320px;"  class="formTextArea" value="" tabindex="1" ><?php echo $benifittypelist->getBen_comment();?></textarea>
                 </div>

                <br class="clear"/>

            </form>

	

                <div class="formbuttons">
        <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton';?>" name="EditMain" id="editBtn"
        	value="<?php echo $editMode ? __("Edit") : __("Save");?>"
        	title="<?php echo $editMode ? __("Edit") : __("Save");?>"
        	onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
        <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled;?>
                value="<?php echo __("Reset");?>" />
        <input type="button" class="backbutton" id="btnBack"
                value="<?php echo __("Back")?>" tabindex="18"  onclick="goBack();"/>
            </div>

        </div>
 <div class="requirednotice"><?php echo __("Fields marked with an asterisk")?><span class="required"> * </span> <?php   echo __("are required") ?></div>
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
function getbenfittype(id){

           btId=id;


           $.post(

    "<?php echo url_for('wbm/Checkbtype') ?>", //Ajax file

    { id: id },  // create an object will all values

    //function that is called when server returns a value.
    function(data){
         var selectbox="<option value='-1'><?php echo __('--Select--') ?></option>";
   $.each(data, function(key, value) {
        selectbox=selectbox +"<option value="+key+">"+value+"</option>";
    });
        selectbox=selectbox +"</select>";
   $('#cmbbstype').html(selectbox);

},
    //How you want the data formated when it is returned from the server.
   "json"
    );


       }

		$(document).ready(function() {
                buttonSecurityCommon("null","null","editBtn","null");
              <?php  if($editMode == true){ ?>
                $('#frmSave :input').attr('disabled', true);
                  $('#editBtn').removeAttr('disabled');
                      $('#btnBack').removeAttr('disabled');
                  <?php } ?>

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
                                        cmbbtype: { required: true },
                                        cmbbstype: { required: true },
				 	txtName: { required: true },
                                        txtdisbdate: { required: true ,orange_date:true},
                                        txtcomment: { maxlength:200, noSpecialCharsOnly: true }
			 	 },
			 	 messages: {
                                        cmbbtype: "<?php echo __("Please select Benefit Type")?>",
                                        cmbbstype: "<?php echo __("Please select Benefit")?>",
			 		txtName: "<?php echo __("Job Title Name is required")?>",
                                         txtdisbdate: {required:"<?php echo __("Please Enter Date")?>",orange_date: "<?php echo __("Please specify valid  date");?>"},
                                        txtcomment:{maxlength:"<?php echo __("Maximum 200 Characters")?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed")?>"}
			 	 }
			 });

 // When click edit button
         $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);
         
        $("#editBtn").click(function() {
            
            var editMode = $("#frmSave").data('edit');
            if (editMode == 1) {
                // Set lock = 1 when requesting a table lock
                 
                location.href="<?php echo url_for('wbm/UpdateDisbusement?id='.$benifittypelist->getBen_id().'&lock=1')?>";
            }
            else {
               
    		$('#frmSave').submit();
            }

           
        });

        //When Click back button
        $("#btnBack").click(function() {
                              location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/wbm/Disbusement')) ?>";
                             });

       //When click reset buton
	$("#btnClear").click(function() {
            // Set lock = 0 when resetting table lock
             location.href="<?php echo url_for('wbm/UpdateDisbusement?id='.$benifittypelist->getBen_id().'&lock=0')?>";
	});

                                 $("#disbdate").datepicker({ dateFormat:'<?php echo $inputDate; ?>' });

		 });
</script>
       
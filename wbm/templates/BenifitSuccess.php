<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Benefits Summary") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return checkValue();" >
            <input type="hidden" name="mode" value="search" >
            <div class="searchbox">
                <label for="searchMode"><?php echo __("Search By") ?></label>


                <select name="searchMode" id="searchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>
                    <option value="bst_name_"><?php echo __("Benefit") ?></option>
                    <option value="bt_name_" ><?php echo __("Benefit Type") ?></option>
                </select>

                <label for="searchValue" ><?php echo __("Search For") ?></label>
                <input type="text" size="20" name="searchValue" id="searchValue" value="<?php echo $searchValue ?>"  />
                <input type="submit" class="plainbtn"
                       value="<?php echo __("Search") ?>" />
                <input type="reset" class="plainbtn" id="resetBtn"
                       value="<?php echo __("Reset") ?>" />
                <br class="clear"/>
            </div>
        </form>
        <div class="actionbar">
            <div class="actionbuttons">

                <input type="button" class="plainbtn" id="buttonAdd"
                       value="<?php echo __("Add") ?>" />


                <input type="button" class="plainbtn" id="buttonRemove"
                       value="<?php echo __("Delete") ?>" />

            </div>
            <div class="noresultsbar"></div>
            <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?> </div>
            <br class="clear" />
        </div>
        <br class="clear" />
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('wbm/DeleteBenift') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">

                            <input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" />

                        </td>


                        <td scope="col">
                            <?php if ($Culture == 'en') {
                                $ename = 'b.bst_name';
                            } else {
                                $ename = 'b.bst_name_' . $Culture;
                            } ?>
                            <?php echo $sorter->sortLink($ename, __('Benefit'), '@Benifit', ESC_RAW); ?>

                        </td>
                        <td scope="col">
<?php if ($Culture == 'en') {
                                $ename = 't.bt_name';
                            } else {
                                $ename = 't.bt_name_' . $Culture;
                            } ?>
                    <?php echo $sorter->sortLink($ename, __('Benefit Type'), '@Benifit', ESC_RAW); ?>


                                </td>
                            </tr>
                        </thead>

                        <tbody>
<?php
                            $row = 0;
                            foreach ($benifitlist as $reasons) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
?>
                    <tr class="<?php echo $cssClass ?>">
                        <td >
                            <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $reasons->getBst_id() ?>' />
                        </td>

                        <td class="">
                            <a href="<?php echo url_for('wbm/UpdateBenifit?id=' . $reasons->getBst_id()) ?>"><?php
                                if ($Culture == 'en') {
                                    $dd = $reasons->getBst_name();
                                    $rest = substr($reasons->getBst_name(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                    } else {
                                        echo $rest;
                                    }
                                } else {
                                    $cc = "getBst_name_" . $Culture;
                                    if (strlen($reasons->$cc())) {

                                        $dd = $reasons->$cc();
                                        $rest = substr($reasons->$cc(), 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                        } else {
                                            echo $rest;
                                        }
                                    } else {
                                        $dd = $reasons->getBst_name();
                                        $rest = substr($reasons->getBst_name(), 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest
?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                        } else {
                                            echo $rest;
                                        }
                                    }
                                }
?></a>
                            </td>
                            <td class="">
                            <?php
                            ?>
                            <?php
                                if ($Culture == 'en') {
                                    $dd = $reasons->BenifitType->getBt_name();
                                    $rest = substr($reasons->BenifitType->getBt_name(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                    } else {
                                        echo $rest;
                                    }
                                } else {
                                    $cc = "getBt_name_" . $Culture;
                                    if ($reasons->BenifitType->$cc() == "") {
                                        $dd = $reasons->BenifitType->getBt_name();
                                        $rest = substr($reasons->BenifitType->getBt_name(), 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                        } else {
                                            echo $rest;
                                        }
                                    } else {
                                        $dd = $reasons->BenifitType->$cc();
                                        $rest = substr($reasons->BenifitType->$cc(), 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest
                            ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                        } else {
                                            echo $rest;
                                        }
                                    }
                                }
                            ?>
                                    </td>

                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            function disableAnchor(obj, disable){
                if(disable){
                    var href = obj.getAttribute("href");
                    if(href && href != "" && href != null){
                        obj.setAttribute('href_bak', href);
                    }
                    obj.removeAttribute('href');
                    obj.style.color="gray";
                }
                else{
                    obj.setAttribute('href', obj.attributes
                    ['href_bak'].nodeValue);
                    obj.style.color="blue";
                }
            }
            function checkValue(){
                if($("#searchValue").val()==""){
                    alert("<?php echo __('Please enter search value') ?>");
                    return false;

                }
                if($("#searchMode").val()=="all"){
                    alert("<?php echo __('Please select the search mode') ?>");
                    return false;
                }
                else{
                    $("#frmSearchBox").submit();
                }
            }
            $(document).ready(function() {
                buttonSecurityCommon("buttonAdd","null","null","buttonRemove");
                //When click add button
                $("#buttonAdd").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/wbm/SaveBenifit')) ?>";

                });

                // When Click Main Tick box
                $("#allCheck").click(function() {
                    if ($('#allCheck').attr('checked')){

                        $('.innercheckbox').attr('checked','checked');
                    }else{
                        $('.innercheckbox').removeAttr('checked');
                    }
                });

                $(".innercheckbox").click(function() {
                    if($(this).attr('checked'))
                    {

                    }else
                    {
                        $('#allCheck').removeAttr('checked');
                    }
                });

                $("#buttonRemove").click(function() {
                    $("#mode").attr('value', 'delete');
                    if($('input[name=chkLocID[]]').is(':checked')){
                        answer = confirm("<?php echo __("Do you really want to Delete?") ?>");
                    }


                    else{
                        alert("<?php echo __("select at least one check box to delete") ?>");

                    }

                    if (answer !=0)
                    {

                        $("#standardView").submit();

                    }
                    else{
                        return false;
                    }

                });

                //When click reset buton
                $("#resetBtn").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/wbm/Benifit')) ?>";
        });

    });


</script>

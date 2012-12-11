<?php defined("SYSPATH") or die("No direct script access.") ?>
<style type="text/css">
#g-dialog, .ui-dialog {
    width:800px !important;
}
#iptcwrap {
    width: 300px;
    float: left;
    margin-right: 20px;
}
.radiolable {
    margin-right: 10px;
    color: white;
}
.rhorizont {
    float: left;
    width: 80px;
    padding: 5px;
}
.clear {
    clear: both;
}
#validateLink {
    visibility: hidden;
}
#iptc-choose {
    background-color: #F08080;
    width: 297px;
    padding: 5px;
    margin-bottom: 5px;
}
#iptcsubmit {
    visibility: hidden;
}
</style>
<script type="text/javascript">
  var IPTC_TITLE =
    <?= t('Edit IPTC-data of all items in "%album_title"', array("album_title" => "__TITLE__"))->for_js() ?>;
  var set_title = function(title) {
    $("#g-dialog").dialog("option", "title", IPTC_TITLE.replace("__TITLE__", title));
  }
  set_title("<?= $item->title ?>");
  if($('#g-add-photos-form').length <= 0){
      $('#iptc-choose').hide();
      $('#validateLink').css('visibility','visible');
      //$('#iptcsubmit').css('vsisbility', 'hidden');
  }else{
      $('#iptcsubmit').hide();
      $('#validateLink').hide();
  }
  
</script>

<div class="g-iptcedit-dialog">
<body>
<div id="iptcwrap">
    <form action="<?= url::site("iptcedit/upload_dialog/{$item->id}") ?>" method="post" id="iptcedit">
    <p></p>
    <div id="iptc-choose">
        <!--<label>
        <input class="checkbox" type="checkbox" value="1" name="write_iptc" checked="checked">
            <span style="color: white;"><?= t('Write IPTC-data to all existing and now uploading items?'); ?></span>
        </label>-->
        <span style="color: white;"><?= t('Write IPTC-data to'); ?></span>
        <br/>
        <div class="rhorizont">
            <label for="all" class="radiolable">
            <input class="radio" type="radio" name="radio" value="all" checked="">
            <?= t("all") ?>
            </label>
        </div>
        <div class="rhorizont">
            <label for="new" class="radiolable">
            <input class="radio" type="radio" name="radio" value="new">
            <?= t("new") ?>
            </label>
        </div>
        <div class="rhorizont">
            <label for="no" class="radiolable">
            <input class="radio" type="radio" name="radio" value="no">
            <?= t("no*") ?>
            </label>
        </div>
        <div class="clear" style="color: white;"><?= t('items.'); ?></div>
        <div class="clear" style="color: white; font-size: 0.7em; margin-top: 3px;"><strong>* </strong><?= t('Preserves existing IPTC-data in uploaded items.'); ?></div>
    </div>
     <?php
     if(empty($iptcTags)){
         echo "<div class='g-warning'>" . t('No IPTC-Tags are activated. Go to admin->settings->IPTC edit to activate and label.') . "</div>";
         $type = "hidden";
     }else{
         $type = "submit";
        foreach($iptcTags as $key => $value) {
            $label = $iptcLabels[$key];
            $formValue = $i->get($iptcTags[$key]);
            
            
            //fill headline, caption and by_line with albumtitle, albumdescription and username
            if($key == 'IPTC_HEADLINE' && module::get_var("iptcedit", $key."_fill") && $formValue == '') {
                $formValue = $IPTC_HEADLINE;
            }elseif($key == 'IPTC_CAPTION' && module::get_var("iptcedit", $key."_fill") && $formValue == '') {
                $formValue = $IPTC_CAPTION;
            }elseif($key == 'IPTC_BYLINE' && module::get_var("iptcedit", $key."_fill") && $formValue == '') {
                $formValue = $IPTC_BYLINE;
            }elseif($key == 'IPTC_CREATED_DATE' && module::get_var("iptcedit", $key."_fill") && $formValue == '') {
                $formValue = $IPTC_CREATED_DATE;
            }
            //normal <input> for all but textarea for caption
            if($key == 'IPTC_CAPTION') {
                $inputs .= '<label for="' . $key . '"><span style="color:#656565;">' . $label . '</span></label>';
                $inputs .= '<textarea id="' . $key  . '" type="text" name="iptcdata[' . $key .']" style="height:3.5em">'. $formValue .'</textarea><br />';
            }else{
                $inputs .= '<label for="' . $key . '"><span style="color:#656565;">' . $label . '</span></label>';
                $inputs .= '<input id="' . $key  . '" type="text" name="iptcdata[' . $key .']" value="' . $formValue . '" size="100" /><br />';
            }
        }
        echo $inputs;
     }
    ?>
        <input type="hidden" name="file" value="<?php print $file;?>" />
        <!-- itemId of last existing item -->
        <input type="hidden" name="lastItem" value="<?php print $last;?>" />
        <input type="hidden" name="submitted" value="1" />
        <input type="<?php echo $type ?>" value="<?= t("Save") ?>" id="iptcsubmit" onclick="reload()"/>
    </form>
    <a href="#" id="validateLink" onclick="validate()"><?= t("Validate IPTC-data") ?></a>
</div>
<iframe id="dp_target" name="dp_target" src="<?php echo url::abs_file('modules/iptcedit/helpers/datepicker_frame.php'); ?>" style="display: none; width:100%;height: 100%;min-width:310px;min-height:300px;border:0px solid #fff;margin: 0;padding: 0;"></iframe>
<script type="text/javascript">
    $(document).ready(function(){
        if ($("#g-upload-done").is('*')) {
          $("#iptcsubmit").css({visibility: "hidden"});
        }else{
          $("#g-dialog, .ui-dialog").css({width: "-=300px"});
          $("#iptcwrap").css({width: "+=180px"});
        }
        $('#g-upload-done').removeAttr('onclick').unbind('click');
    });

    $('#g-upload-done').bind('click', function(event) {
        var ready = 0;
        ready = validate();
        if(ready == 0) {
           $('#g-add-photos-form').submit();
           event.preventDefault();
           $.post("<?= url::site("iptcedit/upload_dialog/{$item->id}") ?>", $("#iptcedit").serialize());
           $.post("<?php echo $purgeIPTCcache?>");
           //$('.ui-dialog-content').html('<div style="border-bottom:1px solid green; padding-bottom: 5px; margin-bottom: 10px; color:green;">Die IPTC-Daten wurden aktualisiert.</div>');
           $('html, body').animate({scrollTop: $(".ui-dialog-titlebar").offset().top}, 1000);
           reload();
        }else{
           event.preventDefault();
        }
    });
    
    function reload(){
        setTimeout("location.reload()", 800);
    }
    
    //datepicker iframe
    function setDate(e){
        $('#IPTC_CREATED_DATE').val(e);
        $('#dp_target').dialog('close');
    }
    $('#IPTC_CREATED_DATE').focus(function(e){
        $('#dp_target').dialog({
            height: 300,
            width: 300
        });
        $('#dp_target').dialog('open');
    });
    
    //form validation
    function validate(){
        var invalid = 0;
        $('input').css('background-color', 'white');
        $('textarea').css('background-color', 'white');
        <?php
        foreach($iptcTags as $key => $value) {
            if(module::get_var("iptcedit", $key."_required") && module::get_var("iptcedit", $key)) {
                echo "if ($('#$key').val().length == 0) {invalid += 1; $('#$key').css('background-color','#FFF9A0');} ";
            }
        }
        ?>
        if(invalid == 0) {
            $('#iptcsubmit').css('visibility', 'visible');
            $('#validateLink').css('visibility', 'hidden');
        }else{
            $('#iptcsubmit').css('visibility', 'hidden');
            $('#validateLink').css('visibility', 'visible');
            alert("<?= t("Please fill all required (colored) fields.")?>");
        }
        return invalid;
    }
    
</script>
</body>  
  
</div>
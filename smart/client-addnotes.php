<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
echo "<script>location.reload();</script>";
exit();
}


$show = false;
$id = intval($_GET['id']);
// $sql = "SELECT * FROM `clientCreateNotes` WHERE `fid`='$id'";
// $data = $dbF->getRows($sql);
?>
<div class="event_details" id="myform">
<h3>Add New Notes</h3>
<div class="form_side">
<form method="post" id="myForm" action="crm">
<?php echo $functions->setFormToken('addnotesTitle',false); ?>



<div class="form-group">
<label>Title :</label>
<input type="text" name="titlenotes" value="" required>
<input type='hidden' name='refId' value='<?php echo $id ?>'>
<input type='hidden' name='userID' value="<?php echo @$_SESSION[currentUser] ?>" >
</div>



















<?php


echo '<input type="submit" class="submit_class" value="Create" name="submit">';


?>
</form>
</div><!-- form_side close -->
</div><!-- event_details -->
<script>

     // wait for the DOM to be loaded
     $(function() {
       // bind 'myForm' and provide a simple callback function
       $('#myForm').ajaxForm(function() {
               $(".fixed_side").removeClass("fixed_side_");
        $(".col5").removeClass("col5_");
        $(".myevents-div").removeClass("myevents-div_");
        $(".myevents-div").removeClass("redborder");
        $(".myevents-div").removeClass("blueborder");
        $(".myevents-div").removeClass("greenborder");
        $("[title='chat widget']").parent('div').attr("style", "display: block !important;position: fixed !important");
        setTimeout(function(){
            $(".myevents-form").empty();
             $('.myevents-div #loader').show();

          $(".div<?php echo $id ?>").load("crm.php .div<?php echo $id ?>", function() {


});
        },1000); 
       });
     });
</script>
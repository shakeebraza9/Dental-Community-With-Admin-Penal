<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
echo "<script>location.reload();</script>";
exit();
}


$show = false;
$id = $_GET['id'];

$ids =explode(":", $id);
$id = intval($ids[0]);
$id123 = intval($ids[1]);



$sql = "SELECT * FROM `clientCreateNotes` WHERE `id`='$id'";
$data = $dbF->getRows($sql);
?>
<div class="event_details" id="myform">
<h3>Add Notes Comments</h3>
<div class="form_side">
<form method="post" id="myForm" action="crm">
<?php echo $functions->setFormToken('addnotescomments',false); ?>


<?php foreach ($data as $key => $value) {
$fid= $value['id'];

?>

<div class="form-group">
<label > Note Title</label>
<input type="text" name="title" value="<?php echo $value['heading'] ?>" required>
<input type='hidden' name='refId' value='<?php echo $id ?>'>
<input type='hidden' name='mainId' value='<?php echo $id123 ?>'>
<input type='hidden' name='userID' value="<?php echo @$_SESSION[currentUser] ?>" >
</div>

<?php	

$sqlw = "SELECT * FROM `clientCreateNotes_comments` WHERE `fid`='$fid'";
$dataw = $dbF->getRows($sqlw);
foreach ($dataw as $keyw => $valuew) {
?>
<div class="form-group">
<span style="
font-size: smaller;
"><?php echo $functions->UserName($valuew['userID']); ?> on (<?php echo date('d-M-Y H:i', strtotime($valuew['dateTime'])) ?>)</span>
<label style="color: #01abbf;font-weight: bold;"><?php echo $valuew['heading'] ?>  </label>
<!-- <textarea name="desc" placeholder="Comments" required></textarea> -->
</div>
<!-- form-group -->



<?php

}

echo "<div class='form-group'>
<label>Comment :</label>
<textarea name='comm1' placeholder='Type here...'></textarea>
</div>
<div class='form-group' style='display:none'>
<button type='button' id='addnotesbtn".$fid."' class='submit_class' value='add more' name='sssss' onclick='addnotes".$fid."()' >Add new comments</button> 
<!-- form-group -->
</div> 
<div class='form-group' id='addnotes".$fid."' style='display: none'>
<hr><div class='alert alert-success alert-dismissible'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<div class='form-group'>
<label>New Comments :</label>
<textarea name='comm2' placeholder='Enter New Comments'></textarea>
</div>
</div>
</div><!-----------Close addMore Div-----> 
<script>
function addnotes".$fid."(ths)
{ 
$('#addnotes".$fid."').show();
$('#addnotesbtn".$fid."').hide();
}
</script>
<hr>";
} 
?>

















<?php


echo '<input type="submit" class="submit_class" value="Save" name="submit">';


?>
</form>
</div><!-- form_side close -->
</div><!-- event_details -->
<script>
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

           
$(".div<?php echo $id123 ?>").load("crm.php .div<?php echo $id123 ?>", function() {


});


        },1000); 
       });
     });
</script>
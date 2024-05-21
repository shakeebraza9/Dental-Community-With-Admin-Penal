<?php 
include_once("global.php");
global $dbF, $webClass, $functions;
    //       ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
$login       =  $webClass->userLoginCheck();
if(!$login){
echo "<script>location.reload();</script>";
exit();
}
$show = false;
$id = intval($_GET['id']);
$sql = "SELECT * FROM `insertGroup` WHERE `id`='$id'";
$data = $dbF->getRow($sql);
$UserName=$webClass->UserName($data['users']); 
?>
<div class="event_details" id="myform">
<h3>Group Management Edit</h3>
<div class="form_side">
<form method="post" id="myForm" action="practice-profile">
<?php echo $functions->setFormToken('insertGroupEDIT',false); ?>


<div class="form-group">
<label>Group Name :</label> 
<select name ="group_name[]" id="group-select-list">
  <option value="" >Select an Group</option>
  <?php
  $user =  intval($_SESSION['currentUser']);
  $sql="SELECT DISTINCT group_name,group_id FROM `insertGroup` WHERE `practiceID` = '$user' ";
  $dataG = $dbF->getRows($sql);

    foreach ($dataG as $key => $val) {

      $select=$val['group_name']==$data['group_name'] ? "selected" : "";
        echo'<option value="'.$val['group_name'].'::'.$val['group_id'].'" '.$select.'>'.$val['group_name'].'</option>';
   } 
  ?>
 <option value="custom">Add More</option>
</select>
 <input type="text" id="txt-custom" name="group_name[]" style="display: none;" />



</div>











<div class="form-group">
<label>User :</label>
<input type="text" name="practiceIds" value="<?php echo $UserName ?>" readonly>





<input type='hidden' name='refId' value='<?php echo $id ?>'>


</div>




<div class="form-group">
<label>Description :</label>
<input type="text" name="changedesc" value="<?php echo $data['desc'] ?>">

 


</div>






<?php
echo '<input type="submit" class="submit_class" value="Save" name="submit">';
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



$(".updateTableGroup").load("practice-profile.php .updateTableGroup", function() {


});



},1000); 





});




});







</script>
<script >
	let selectEl = document.getElementById('group-select-list');

selectEl.addEventListener('change', (e) => {
  if (e.target.value == 'custom') {
    document.getElementById('txt-custom').style.display = 'block';
 
    
  } else {
    document.getElementById('txt-custom').style.display = 'none';
   
    
  }
});

</script>
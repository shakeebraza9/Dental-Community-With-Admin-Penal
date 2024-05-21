<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
echo "<script>location.reload();</script>";
exit();
}
$option = $functions->eventCategory();
$show = false;

 $id = ($_GET['id']);
$sql = "SELECT * FROM `myevents` WHERE `id`= ? ";
$data = $dbF->getRow($sql,array($id));
@$recurring_duration   = @$data['recurring_duration'];

if (@@$data['recurring_duration'] != '') {

$recurring = '<option Selected  value="'.$recurring_duration.'"> '.$recurring_duration.'</option>';
echo "<script>$('.rd').show();</script>";
}

else 
{

$recurring = '<option  selected disabled  value="">Select Recurring Duration</option>';
// echo "<script>$('.rd').hide();</script>";
}

// if ($id == 'undefined'  ||  @$data['status'] == 'complete'  && @$data['approved'] == '1' ) {
if ($id == 'undefined') {

$chek = '';
$display="style=display:none";

$data2=array();



}
else
{
$display="style=display:block";
 
$chek = '';
$fetch_id = $data['fetch_id'];




if(empty($data['fetch_id'])){

    $fetch_id = $id;
}




 $sql2 = "SELECT * FROM `myeventform` WHERE `title_id`=? AND `publish`=?";
@$data2 = $dbF->getRows($sql2,array($fetch_id,"1"));



}













?>
<div class="event_details" id="myform">
<h3>My Events</h3>



<div class="form_side">
<form method="post" action="calendar" enctype="multipart/form-data">
<?php echo $functions->setFormToken('myEvents',false); ?>
<input type="hidden" name="id" value="<?php echo @$data['id'] ?>">
<input type="hidden" value="<?php echo $id ?>" name="edit_id">
<input type="hidden" value="<?php echo $fetch_id ?>" name="title_id">
<input type="hidden" value="<?php echo @$data['user'] ?>" name="cur_user">
<input type="hidden" value="<?php echo @$data['file'] ?>" name="old_file">
<div class="row">


<div class="form-group col-sm-4">
<label>Title :</label>
<input type="text" name="title" value="<?php echo @$data['title'] ?>" required>
</div>

<div class="form-group col-sm-4">
<label>Due Date :</label>
 

<input class="datepicker" id="from" type="text" value="<?php if(!empty(@$data['due_date'])) echo date('d-M-Y',strtotime(@$data['due_date'])) ?>" name="date" required autocomplete="off" >
</div>
 





<?php 



//Recurring Duration

echo '








<div class="form-group col-sm-4 rd">
<label>Recurring Duration</label>

<select class="form-control "  name="recurring_duration">
'.$recurring .'

<option value="No Recurrence">No Recurrence</option>
<option value="1 day">1 day</option>
<option value="1 week">1 week</option>
<option value="2 weeks">2 weeks</option>
<option value="3 weeks">3 weeks</option>
<option value="1 Month">1 Month</option>
<option value="2 Months">2 Months</option>
<option value="3 Months">3 Months</option>
<option value="4 Months">4 Months</option>
<option value="6 Months">6 Months</option>
<option value="12 Months">12 Months</option>
<option value="24 Months">24 Months</option>
<option value="36 Months">36 Months</option>
<option value="60 Months">60 Months</option>
</select>



</div>'; ?>



</div>

<div class="row">
<div class="form-group col-sm-6">
<label>Select Category :</label>
<select name="category" class="category" required>
<option selected disabled>Select Category</option>
<?php echo $option; ?>
</select>
<?php
if(@$data['category'] != ''){ ?>
<script>
$('.category').val('<?php echo @$data['category'] ?>').change();
</script>
<?php } ?>
</div>
<!-- form-group col-sm-6 -->



<?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0'){  echo "<input type='hidden' value='$data[assignto]' name='assignto'>";} else {
$selected = '';
if(strpos(@$data['assignto'],'-1') !== false){
$selected = 'selected';
}
?>



<div class="form-group col-sm-6">
<label>Delegate Task :</label>
<select name="assignto" class="assignto" required>
<option selected disabled>Select Employee</option>
<option <?php echo "value='-1.$_SESSION[currentUser]' $selected" ?>>All Employee</option>
<?php echo $functions->allEmployee($_SESSION['currentUser'],$data['assignto']) ?>
<option >Unassigned</option>
<option disabled>--Groups</option>
<?php echo $functions->allGroups($_SESSION['currentUser']) ?>
</select>
</div>


<!-- form-group col-sm-6 -->
<?php } ?>









<?php
if(@$data['status'] != ''){
if(@$data['status'] == 'complete'){
?>
<div class="form-group col-sm-6">

    <label>Approved Status :</label>

<select  name="status" class="status">
<option value="complete">Complete</option>
<option value="pending">Pending</option>


</select>
<!-- <input type="text" class="status" name="status" value="pending"> -->
<script> 
$('.status').val('<?php echo @$data['status'] ?>').change();  
</script>

</div>
<?php 

}
else
{
   ?>
   <input type="hidden" class="status" name="status" value="pending">
   <?php 
}

}else{
?>

</div>



<div class="row">


<input type="hidden" class="status" name="status" value="pending">

   <?php  
}
?>
<div class="form-group col-sm-6">
<label>Details :</label>
<textarea name="desc" placeholder="Details"><?php echo @$data['desc'] ?></textarea>
</div>
<!-- form-group -->
<div class="form-group">

<label>Attach File :</label>
<div class="file">
<input type="file" id="file-upload" name="document">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div>


</div>
<div class="form-group col-sm-6">
<label>Select Type :</label>
<select name="event_type" class="event_type" required>
<option selected disabled>Select Type</option>
<option value="recommended">Recommended</option>
<option value="mandatory">Mandatory</option>
</select>
<?php
if(@$data['type'] != ''){ ?>
<script>
$('.event_type').val('<?php echo @$data['type'] ?>').change();
</script>
<?php } ?>
</div>

</div>
<?php
if(@$data['file'] != '' && @$data['file'] != '#'){
        echo $functions->downloadButton($data['file']);
    }
    
// if(@$data['file'] != '' && @$data['file'] != '#'){
// $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
// $ext = pathinfo(@$data['file'], PATHINFO_EXTENSION);
// if (!in_array($ext, $allowed)) {
// echo "<div class='form-group'><a href='http://view.officeapps.live.com/op/view.aspx?src=".WEB_URL."/images/$data[file]' title='View/Download' class='dbtn' data-toggle='tooltip' target='_blank'><i class='fas fa-file'></i>&nbsp;&nbsp;Download File</a>";

// if (@$data['approved'] != '-1') {


// echo "<a data-id='$id' onclick='AjaxDelScriptmy(this);' class='btn  secure_delete' >


// <i class='idbtn glyphicon glyphicon-trash trash fa fa-times-circle' ></i>
// <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
// </a>";

// }

// echo "</div>";
// }
// else {
// echo "<div class='form-group'><a href='$data[file]' title='View/Download' class='dbtn' data-toggle='tooltip' target='_blank'><i class='fas fa-file'></i>&nbsp;&nbsp;Download File</a>
// ";
// if (@$data['approved'] != '-1') {


// echo "<a data-id='$id' onclick='AjaxDelScriptmy(this);' class='btn  secure_delete' >


// <i class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' ></i>
// <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
// </a>";

// }

// echo "</div>";
// }
// }
 
?>


 


<?php
if (!empty(@$data2)) {
?>

<h4 style="    text-align: center;">Add / Update Custom Questions</h4>

<?php

    $ij = 0;
foreach ($data2 as $keyc => $valuec) {


?>


<div class="delWhole" id="paa<?php echo $valuec['id'] ?>"><input type="hidden" name="fid[]" value="<?php echo $valuec['id'] ?>">
<div class="sub-form">
<hr>


<div class="form-group">
<label>Question :</label>
<textarea name="question[]" placeholder="Question" required><?php echo $valuec['question'] ?></textarea>
</div>


<div class="row">
<div class="form-group col-3 col-md-3">
<label>Category :</label>
<input type="text" name="categoryS[]" value="<?php echo $valuec['category'] ?>"  autocomplete="off" placeholder="Category">
</div>
<div class="form-group col-4 col-md-3">
<label>Field 1 :</label>
<input type="text" name="field1[]" value="<?php echo $valuec['field1'] ?>" placeholder="e.g. Comments, Actions" autocomplete="off">
</div>
<div class="form-group col-4 col-md-3">
<label>Field 2 :</label>

<input type="text" name="field2[]" value="<?php echo $valuec['field2'] ?>" placeholder="e.g. Temperature" autocomplete="off">
</div>
<div class="form-group col-5 col-md-3">
<label>Response :</label>


<div class="covidshowbtn">
<div class="switch-field">
<input type="checkbox" id="radio-yes<?php echo $valuec['id'] ?>" name="rRadio[<?php echo $ij ?>]" value="Radio" <?php  if(@$valuec['radio']=="Radio" )echo "checked" ; ?>  />
<label for="radio-yes<?php echo $valuec['id'] ?>">Radio</label>
<input type="checkbox" id="radio-Date<?php echo $valuec['id'] ?>" name="rDate[<?php echo $ij ?>]" value="Date" <?php  if(@$valuec['date']=="Date" )echo "checked" ; ?>  />
<label for="radio-Date<?php echo $valuec['id'] ?>">Date</label>
<input type="checkbox" id="radio-Time<?php echo $valuec['id'] ?>" name="rTime[<?php echo $ij ?>]" value="Time" <?php  if(@$valuec['time']=="Time" )echo "checked" ; ?>  />
<label for="radio-Time<?php echo $valuec['id'] ?>">Time</label>
</div>
</div>




 
 
     <p class="btn btn-danger" onclick="deleteAjaxFormId(<?php echo $valuec['id'] ?>)"><i class="fas fa-trash"></i></p>





</div>


</div>




</div>
</div>
<?php
$ij++;
 
}
?>

<div id="addmoreEdit"></div>
<br>
<button type="button" class="submit_class add_field_button"  onclick="add_contactEdit(<?php echo $ij ?>)" style="
    float: right;
"><?php  $dbF->hardWords('Add more'); ?></button> 
<br>
<?php
}else{
?>
<h4 style="    text-align: center;">Add Custom Questions</h4>
<div class="sub-form">
<hr>

<div class="delWhole" id="p0">

<div class="form-group">
<label>Question :</label>
<textarea name="question[]" placeholder="Question"></textarea>
</div><!-- form-group -->





<div class="row">
<div class="form-group col-3 col-md-3">
<label>Category :</label>
<input type="text" name="categoryS[]"   autocomplete="off" placeholder="Category">
</div>






<div class="form-group col-4 col-md-3">
<label>Field 1 :</label>
<input type="text" name="field1[]" value="" placeholder="e.g. Comments, Actions" autocomplete="off">
</div>

<div class="form-group col-4 col-md-3">
<label>Field 2 :</label>
<input type="text" name="field2[]" value="" placeholder="e.g. Temperature" autocomplete="off">

</div>

<div class="form-group col-5 col-md-3">
<label>Response :</label>
<div class="covidshowbtn">
<div class="switch-field">

<input type="checkbox" id="radio-Radio" name="rRadio[0]" value="Radio" />
<label for="radio-Radio">Radio</label>


<input type="checkbox" id="radio-Date" name="rDate[0]" value="Date" />
<label for="radio-Date">Date</label>

<input type="checkbox" id="radio-Time" name="rTime[0]" value="Time" />
<label for="radio-Time">Time</label>

</div>
</div>




    <p class="btn btn-primary" onclick="add_contact(this)">Add more</p>  
 
     <p class="btn btn-danger" onclick="del_contact('0')"><i class="fas fa-trash"></i></p>

</div>








</div>

</div>
<div class="addmore"></div>
<!-- <br>
<button type="button" class="submit_class add_field_button"  onclick="add_contact(this)" >+    &nbsp;&nbsp;&nbsp;<?php  $dbF->hardWords('Add more'); ?></button> 
<br> -->

</div>
<?php
} ?>
<?php if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['ccalendar'] == 'edit' || $_SESSION['superUser']['ccalendar'] == 'full'){ ?>
<?php echo $chek; ?>
<?php } ?>
<!-- form-group -->




<?php
if($_SESSION['userType']=='Trial')
  { 
      echo'<input type="button" class="submit_class" value="Save event" onclick="alertbx()" name="">';
  }else{
if ($id == 'undefined') {
echo '<input type="submit" class="submit_class" value="Save event" name="submit">';
}
else{
echo '<input type="submit" class="submit_class" value="Save event" name="edit">';
if (!isset($_GET['new']) && $_SESSION['currentUserType'] != 'Employee') {
    
echo '<input type="submit" class="submit_class asNewEvent"  value="Save new event" name="submit">';
}
}
}
?>
</form>
</div><!-- form_side close -->
</div><!-- event_details -->
<script>
$(".asNewEvent").click(function(event)
  {
    if(!confirm("Are You Sure You Want To Copy This Event To As A New Event?")){
        event.preventDefault(); 
       return false;   
    }
    
  });

$('[data-toggle="tooltip"]').tooltip();
$(".datepicker").datepicker({ dateFormat: 'd-M-yy',
changeMonth: true,
changeYear: true,
yearRange: "-80:+20",
showButtonPanel:true,
});
$('.file input').on('change', function() {
filename = this.files[0].name;
$(this).parent('div').find('div').text(filename);
});







function deleteAjaxFormId(ths){
// btn=$(ths);
// console.log(btn);
// console.log(ths);
if(secure_delete()){
// btn.addClass('disabled');
// btn.children('.trash').hide();
// btn.children('.waiting').show();

// id=btn.attr('data-id');
$.ajax({
type: 'POST',
url: 'ajax_call.php?page=deleteAjaxFormId',   
data: { id:ths }
}).done(function(data)
{


    $('#paa'+ths).remove();




});
}
};

function AjaxDelScriptmy(ths){
btn=$(ths);
console.log(btn);
console.log(ths);
if(secure_delete()){
btn.addClass('disabled');
btn.children('.trash').hide();
btn.children('.waiting').show();

id=btn.attr('data-id');
$.ajax({
type: 'POST',
url: 'ajax_call.php?page=DeleteMyEventFile',   
data: { id:id }
}).done(function(data)
{
ift =true;
console.log(data);
if(data > 0 ){
console.log(data);




// Remove row from HTML Table
$(ths).closest('div').css('background','e5f3f2');
$(ths).closest('div').fadeOut(800,function(){
$(ths).remove();
});
}else{
alert('Invalid ID.');
}

if(ift){
btn.removeClass('disabled');
btn.children('.trash').show();
btn.children('.waiting').hide();
}

});
}
};


//for small delete in other project
function secure_delete(text){
// text = 'view on alert';
text = typeof text !== 'undefined' ? text : 'Are you sure you want to Delete?';

bool=confirm(text);
if(bool==false){return false;}else{return true;}


}








var c = 0;
function add_contactEdit(ths){


var contact_texts = '<div id ="pa'+c+'" class="delWhole"><div class="form-group"><label>Question :</label><textarea name="equestion[]" placeholder="Question"></textarea></div><div class="row">    <div class="form-group col-6 col-md-3"><label>Category :</label><input type="text" name="ecategoryS[]" autocomplete="off" placeholder="Category"></div><div class="form-group col-6 col-md-3"><label>Field 1 :</label><input type="text" name="efield1[]" placeholder="e.g. Comments, Actions" autocomplete="off"></div><div class="form-group col-6 col-md-3"><label>Field 2 :</label><input type="text" name="efield2[]" placeholder="e.g. Temperature" autocomplete="off"></div><div class="form-group col-5 col-md-3"><label>Response :</label>   <div class="covidshowbtn">  <div class="switch-field">  <input type="checkbox" id="radio-Radio'+c+'" name="erRadio['+c+']" value="Radio" /><label for="radio-Radio'+c+'">Radio</label><input type="checkbox" id="radio-Date'+c+'" name="erDate['+c+']" value="Date" /><label for="radio-Date'+c+'">Date</label><input type="checkbox" id="radio-Time'+c+'" name="erTime['+c+']" value="Time" /><label for="radio-Time'+c+'">Time</label></div></div><p class="btn btn-danger pa'+c+' delCSS" onclick="del_contactde('+c+')"><i class="fas fa-trash"></i></p></div></div><!-- <p onclick="del_contactde('+c+')" class ="pa'+c+' delCSS"><i class="fas fa-trash"></i></p> --></div>';
$('#addmoreEdit').append(contact_texts);
c++;}



function del_contactde(c){

$('#pa'+c).remove();
$('.pa'+c).remove();
}

var c = 0;
function add_contact(ths){

    // console.log(ths);
    // console.log(this);
    // $(this).remove();
c++;



var contact_text = '<div id ="p'+c+'" class="delWhole"><div class="form-group"><label>Question :</label><textarea name="question[]" placeholder="Question"></textarea></div><div class="row"><div class="form-group col-6 col-md-3"><label>Category :</label><input type="text" name="categoryS[]"   autocomplete="off" placeholder="Category"></div><div class="form-group col-6 col-md-3"><label>Field 1 :</label><input type="text" name="field1[]" value="" placeholder="e.g. Comments, Actions" autocomplete="off"></div> <div class="form-group col-6 col-md-3"><label>Field 2 :</label><input type="text" name="field2[]" value="" placeholder="e.g. Temperature" autocomplete="off"></div><div class="form-group col-5 col-md-3"><label>Response :</label><div class="covidshowbtn"><div class="switch-field"><input type="checkbox" id="radio-Radio'+c+'" name="rRadio['+c+']" value="Radio" /><label for="radio-Radio'+c+'">Radio</label><input type="checkbox" id="radio-Date'+c+'" name="rDate['+c+']" value="Date" /><label for="radio-Date'+c+'">Date</label><input type="checkbox" id="radio-Time'+c+'" name="rTime['+c+']" value="Time" /><label for="radio-Time'+c+'">Time</label></div></div><p class="btn btn-primary" onclick="add_contact(this)">Add more</p>&nbsp;<p class="btn btn-danger" onclick="del_contact('+c+')"><i class="fas fa-trash"></i></p><!-- <p onclick="del_contact('+c+')" class ="delCSS p'+c+'"><i class="fas fa-trash"></i></p> --></div></div></div>';
$('.addmore').append(contact_text);
}



function del_contact(c){

$('#p'+c).remove();
$('.p'+c).remove();
}

// function delAddmore(){

// $('.alert').remove();
 
// }
var $dropzone = document.querySelector('.form_side');
    var input = document.getElementById('file-upload');

    $dropzone.ondragover = function (e) { 
      e.preventDefault(); 
      this.classList.add('dragover');
    };
    $dropzone.ondragleave = function (e) { 
        e.preventDefault();
        this.classList.remove('dragover');
    };
    $dropzone.ondrop = function (e) {
        e.preventDefault();
        this.classList.remove('dragover');
        input.files = e.dataTransfer.files;
        filename =  e.dataTransfer.files[0].name;
        $('#file-upload').parent('div').find('div').text(filename);




        }
    function alertbx(){
  alert("To unlock this feature please upgrade your package...");
}

</script>
<!-- <style type="text/css">
    
    p.delCSS {
    position: absolute;
    right: 0;
    /* bottom: 0; */
    transform: translateY(-50%);
    top: 50%;
}


div.delWhole {
    position: relative;
}
</style> -->
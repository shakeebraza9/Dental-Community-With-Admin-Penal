<?php 
include_once("global.php");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$login       =  $webClass->userLoginCheck();
if(!$login){
echo "<script>location.reload();</script>";
exit();
}
$show = false;
$id = intval($_GET['id']);
$sql = "SELECT * FROM `lab_management` WHERE `id`='$id'";
$data = $dbF->getRow($sql);
?>
<div class="event_details" id="myform">
<h3>Lab Report</h3>
<div class="form_side">
<form method="post" id="myForm" action="lab-management">
<?php echo $functions->setFormToken('labReportEdit',false); ?>
<div class="row">
  <input type='hidden' name='edit_id' value='<?php echo $id ?>'>
<div class="form-group col-md-3">
<label>Name of Patient</label>
<input type="text" id="_patient" value="<?php echo $data['name_of_patient'];?>" name="_patient"/>
</div>
<!-- form-group -->
<div class="form-group col-md-3">
<label>Patient ID</label>    
<input type="text" id="patient_id" value="<?php echo $data['patient_id'];?>" name="patient_id"/>     
</div>
<!-- form-group -->
<div class="form-group col-md-3">
<label>Lab</label>    
<input type="text" id="lab" value="<?php echo $data['lab'];?>" name="lab"/>     
</div>
<!-- form-group -->
<div class="form-group col-md-3">
<label>Surgery Number</label>    
<input type="text" id="surgery_num" value="<?php echo $data['surgery_number'];?>" name="surgery_num"/>     
</div>
<!-- form-group -->

<div class="form-group col-md-3">
<label>Name of Dentist</label>
<input class="name_of_dentist" id="name_of_dentist" type="text" value="<?php echo $data['name_of_dentist'];?>" name="name_of_dentist" required autocomplete="off">
</div>
<!-- form-group -->
<!-- form-group -->
<div class="form-group col-md-3">
<label>Date Lab Work Sent</label>    
<input type="date" id="work_sent" value="<?php echo $data['lab_work_sent'];?>" name="work_sent" style="padding-right: 7px;"/>     
</div>
<!-- form-group -->
<div class="form-group col-md-3">
<label>Estimated Arrival Date</label>    
<input type="date" id="arrival_date" value="<?php echo $data['arrival_date'];?>" name="arrival_date" style="padding-right: 7px;" />     
</div>

<div class="form-group col-12">
<!--<button style="display: inline-block;margin-top:0;" class="submit_class" value="submit" name="submit">Submit</button>-->
</div> 
<div class="form-group col-md-6" style="display:inline-flex;">

<input class="name_of_dentist" id="name_of_dentist" type="text" value="" name="lab_note" placeholder="Add Note" required autocomplete="off">&nbsp;&nbsp;&nbsp;&nbsp;
<button style="display: inline-block;margin-top:0;" class="submit_class" value="submit" name="submit">Submit</button>

</div>
<!-- form-group -->
</div>
<span style="    font-size: 20px;
    margin-bottom: 35px;
    color: #333;">Notes</span><hr>

 


<div class="form-group col-12">
<ul>
 <?php 
		$sql="SELECT * FROM `lab_note` WHERE lab_id='$id' ORDER BY `lab_note`.`id` DESC";
		$data2 = $dbF->getRows($sql);
		foreach ($data2 as $value) {
			echo '<li>'.$functions->UserName($value['user'])." wrote on ".$value['date'].' - '.$value['note'].'</li>';
		}
		?>
		</ul>
</div> 
<!-- form-group -->

</div>





</form>
</div><!-- form_side close -->
</div><!-- event_details -->

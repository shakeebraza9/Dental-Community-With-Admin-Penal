<?php 
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
global $dbF,$webClass;
if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Reminder management',false);
}
@$id = intval($_GET['id']);

$sql = "SELECT * FROM `practiceaddreminder` WHERE `id` = '$id'";
$data = $dbF->getRow($sql);

?>
<div class="form_heading">
    <h1>Reminder Edit</h1>
</div>
<div class="inner_forms" style="margin: 0 !important;">
<form class="profile" action="addReminder.php" role="form" method="post" enctype="multipart/form-data" class="main_form">

 
<div class="form-group-inline mb-0">
<div class="form-group mb-0"><input class="form-control" name="ttitle" type="text" placeholder="Reminder title" value="<?php echo $data['ttitle'] ?>">
<label for="ttitle" class="label">Reminder title</label></div>
<input name="id" type="hidden" placeholder="" value="<?php echo @$id ?>">
</div>

<div class="form-group-inline mb-0">
<div class="form-group mb-0"><input name="ffromdate" type="text" class="datepicker form-control" autocomplete="off"  placeholder="From date" value="<?php echo date("Y-m-d", strtotime($data['ffromdate'])); ?>">
<label for="ffromdate" class="label">From date</label></div>
</div>

<div class="form-group-inline mb-0">
<div class="form-group mb-0"><input name="ttodate" type="text" placeholder="To date" class="datepicker form-control" autocomplete="off" value="<?php echo date("Y-m-d", strtotime($data['ttodate'])); ?>">
<label for="ttodate" class="label">To date</label></div>
</div>
 
 
 

<div class="form-group"><button type="submit" name="submit_btn" id="signup_btn" class="btn btn-lg btn-primary ">Save Reminder</button></div>

</form>
</div>


<script type="text/javascript">
	 
	$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true,
	yearRange:  "1947:<?php echo date('Y'); ?>"


	});



</script>
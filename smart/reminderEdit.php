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

<form class="profile" action="addReminder.php" role="form" method="post" enctype="multipart/form-data">

 

<div class="form-group col-12 col-sm-6"><label>Reminder title</label><input name="ttitle" type="text" placeholder="Reminder title" value="<?php echo $data['ttitle'] ?>"><input name="id" type="hidden" placeholder="" value="<?php echo @$id ?>"></div>


<div class="form-group col-12 col-sm-6"><label>From date</label><input name="ffromdate" type="text" class="datepicker" autocomplete="off"  placeholder="From date" value="<?php echo date("Y-m-d", strtotime($data['ffromdate'])); ?>"></div>

<div class="form-group col-12 col-sm-6"><label>To date</label><input name="ttodate" type="text" placeholder="To date" class="datepicker" autocomplete="off" value="<?php echo date("Y-m-d", strtotime($data['ttodate'])); ?>"></div>

 
 
 

<div class="form-group"><button type="submit" name="submit_btn" id="signup_btn" class="btn btn-lg btn-primary ">Save Reminder</button></div>

</form>


<script type="text/javascript">
	 
	$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true,
	yearRange:  "1947:<?php echo date('Y'); ?>"


	});



</script>
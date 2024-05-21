<?php 
include_once("global.php");
global $dbF,$webClass;
$login       =  $webClass->userLoginCheck();
if(!$login){
echo "<script>location.reload();</script>";
exit();
}
@$id = $_GET['id'];
$id = intval($id);
// echo $id;
// var_dump($id);
if (@$id !='0') {
$token = $functions->setFormToken('clientstatusedit',false);
} else {
$token = $functions->setFormToken('clientstatus',false);
}


if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0'){
$user = $_SESSION['superid'];
}
else{
$user = $_SESSION['currentUser'];

}

$sql = "SELECT * FROM `clientAddTbl` WHERE  id = ?";
        $data = $dbF->getRow($sql,array($id));
?>
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/style2.css?<?php echo filemtime('./css/style2.css')?>">
    <style>
    .myevents-div {
     top: 0; 
     padding: 0; 
     transform: none; 
}</style>
<div class="myevents-div">
    <?php if($_GET['msg']!=''){ echo base64_decode($_GET['msg']); } ?>

<div class="event_details" id="myform">
<h3>Add Client</h3>
<div class="form_side">
<form method="post" id="myForm" action="crm">
<?php echo $token ?>
<input name="editid" type="hidden" value="<?php echo @$id ?>" >
<input name="loginid" type="hidden" value="<?php echo @$_SESSION[currentUser] ?>" >




<div class="form-group">
<label>Name</label>
<input name="name" type="text" placeholder="Name Of Contact/Customer" value="<?php echo @$data['name'] ?>" required>
</div>
<!-- form-group -->



<div class="form-group">
<label>Business Name</label>
<input name="business_name" type="text" value="<?php echo @$data['business_name'] ?>">
</div>
<!-- form-group -->



<div class="form-group">
<label>Manager Name</label>

<input name="manager_name" type="text" value="<?php echo @$data['manager_name'] ?>">
</div>
<!-- form-group -->


<div class="form-group">
<label>Email</label>
<input name="email" type="email" value="<?php echo @$data['email'] ?>" required>
</div>
<!-- form-group -->




<div class="form-group">
<label>Phone</label>
<input name="phone" type="text" value="<?php echo @$data['phone'] ?>">
</div>
<!-- form-group -->





<div class="form-group">
<label>Mobile</label>
<input name="mobile" type="text" value="<?php echo @$data['mobile'] ?>">
</div>
<!-- form-group -->


<div class="form-group">
<label>Address</label>
 <textarea name="address"><?php echo @$data['address'] ?></textarea>
</div>
<!-- form-group -->


<!--<div class="form-group">-->
<!--lab<el>Date Of Birth</label>-->
 <input class="datepicker" name="dob" type="hidden" value="<?php echo @$data['dob'] ?>" autocomplete="off">
<!--</div>-->
<!-- form-group -->




<input name="userService" type="hidden" autocomplete="off">
<input name="userService1" type="hidden" placeholder="Type Service / Plan *" style="display: none;" id="userService1" value="">
<input type="hidden" name="dataType" value="0" />
<input type="hidden" name="cs" value="Hot lead From Show" />
<input type="hidden" name="otherDetail" value="Hot lead From Show" />


<input type="submit" class="submit_class" value="Submit Information" name="submit">
</form>
</div>
<!-- form_side close -->
</div>
<!-- event_details -->
</div>
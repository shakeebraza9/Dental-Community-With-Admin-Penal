<?php 
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
global $dbF,$webClass;
if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Safeguard Form',false);
}

$login       =  $webClass->userLoginCheck();
if(!$login){
header('Location: login');
}
include_once('header.php');
$msg = "";
$chk1 = $functions->safegurading_form();
if($chk1){
$msg = "Safegurading Form Add Successfully";
}




include'dashboardheader.php';
?>
<div class="index_content mypage resources">
<div class="left_right_side">

<!--link_menu close -->
<div class="left_side">
<?php $active = 'reportIssue'; include'dashboardmenu.php';?>
</div>
<!-- left_side close -->



<div class="right_side">

<h3 class="main-heading_">Safeguarding Form</h3>

<?php if($msg!=''){ ?>
<div class="col-sm-12 alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $msg; ?>
</div>
<?php } ?>








<div class="cpd-table hr-absence profile">


<div id="tabs">
<ul id="gettabs">
<li><a href="#tabs-add" >Add</a></li>
<li><a href="#tabs-view" >View</a></li>
</ul>
<div id="tabs-add">



<div id="tabs_">
<div id="tabs-add1">

<div class="form-group "></div><!-- form-group col-12 col-sm-6 -->

<?php 
echo '<form class="profile" action="#" role="form" method="post" enctype="multipart/form-data">


'.$functions->setFormToken('Safegurading_Form',false).'


<div class="row">
<div  class="maintwoDivs">
<h3 style="width:100%;">Details of Person Reporting Concern</h3>



<div class="leftDivForm">

<div class="form-group ">
<label>Name of person reporting concern:</label>
<input name="name_of_person" type="text" placeholder=" " value="">
</div>

<div class="form-group ">
<label>Date:</label>
<input name="date" type="date">
</div>

<div class="form-group ">
<label>Job role:</label>
<input name="job_role" type="text" placeholder=" " value="">
</div>
</div>
<div class="rightDivForm">
<div class="form-group ">
<label>Work address:</label>
<input name="work_address" type="text" placeholder=" " value="">
</div>

<div class="form-group ">
<label>Email:</label>
<input name="email" type="text" placeholder=" " value="">
</div>

<div class="form-group ">
<label>Contact Number:</label>
<input name="contact_nub" type="text" placeholder=" " value="">
</div>
</div>
</div>
<div class="maintwoDivs">
<h3 style="width:100%;">Description of Incident/Concern</h3>


<div class="form-group ">
<h6 for="radiograph_audits">This log of concern relates to (please check any one)</h6>

<label for="log_concern" style="display:inline;">Child</label>
<input type="radio" name="log_concern" value="child" style="margin: 12px 20px 1px 7px;"> 
<label for="log_concern" style="display:inline;">Young person</label>
<input type="radio" name="log_concern" value="Young person" style="margin: 12px 20px 1px 7px;">
<label for="log_concern" style="display:inline;">Vulnerable adult</label>
<input type="radio" name="log_concern" value="Vulnerable adult" style="margin: 12px 20px 1px 7px;">

</div>
</div>

<div class="maintwoDivs">

<h3 style="width:100%;">Subject(s) Details</h3>
<div class="leftDivForm">
<div class="form-group ">
<label>Subject(s) name(s):</label>
<input name="subject_name" type="text" placeholder=" " value="">
</div>

<div class="form-group ">
<label>Name of parents/carers (if appropriate):</label>
<input name="name_of_parent" type="text">
</div>

<div class="form-group ">
<label>Telephone number:</label>
<input name="telephone_nub" type="text" placeholder=" " value="">
</div>

<div class="form-group ">
<label>Mobile number:</label>
<input name="mobile_nub" type="text" placeholder=" " value="">
</div>
</div>

<div class="rightDivForm">
<div class="form-group">
<label>First language (ifknown):</label>
<input name="first_lang" type="text" placeholder=" " value="">
</div>

<div class="form-group ">
<label>Address:</label>
<input name="address" type="text" placeholder=" " value="">
</div>

<div class="form-group ">
<label>Postcode:</label>
<input name="postcode" type="text" placeholder=" " value="">
</div>

<div class="form-group ">
<label>Any special factors to be considered?(e.g. language difficulties, disability or any thing else of relevance):</label>
<input name="special_factor" type="text" placeholder=" " value="">
</div>
</div>
</div>
<div class="maintwoDivs">
<h3 style="width:100%;">Details</h3>

<div class="form-group ">
<label>Are you reporting your own concerns or passing on those of somebody else?</label>
<textarea name="reporting_your_own_concerns_or_passing" class="form-control"></textarea>
</div>
</div>
<div class="maintwoDivs">
<div class="leftDivForm">
<div class="form-group ">
<label>Date of the incident/concern:</label>
<input name="date_of_incident" type="date" placeholder=" " value="">
</div>
</div>
<div class= "rightDivForm">
<div class="form-group ">
<label>Time of the incident/concern:</label>
<input name="time_of_incident" type="text" placeholder=" " value="">
</div>
</div>
</div>
<div class="maintwoDivs">
<div class="form-group ">
<label>What has prompted the concerns? Include dates, times and details of any specific incidents, making a clear distinction between fact, opinion and hear say:</label>
<textarea name="prompted_the_concerns" class="form-control"></textarea>
</div>

<div class="form-group ">
<label>What (if any) physical, behavioural or indirect signs were present?</label>
<textarea name="indirect_signs" class="form-control"></textarea>
</div>



<div class="form-group d-column" style="display: flex;" id="spoken_to_the_child">
<div style="width: 42%; ">
<label>Have you spoken to the child, young person or vulnerable adult? :</label>
</div><div style="width: 15%;">

<input name="spoken_to_the_child" type="radio" value="yes" id="spok1" style="margin: 12px 20px 1px 7px;">
<label for="spoken_to_the_child" style="display:inline;">Yes</label>
<input name="spoken_to_the_child" type="radio" value="no" id="spok2" style="margin: 12px 20px 1px 7px;">
<label for="spoken_to_the_child" style="display:inline;">No</label>

</div><div style="width: 43%; display: flex;">
<label for="spoken_to_the_child" style="margin: 8px 17px 1px 7px;">Description</label>
<textarea name="spoken_to_the_child_comment" class="form-control" id="spok3" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;"></textarea>
</div>
</div>

<div class="form-group d-column " style="display: flex;">
<div style="width: 42%; ">
<label>Have you spoken to the parents/carers?</label>
</div><div style="width: 15%;">

<input name="spoken_to_the_parents" type="radio" value="yes" style="margin: 12px 20px 1px 7px;">
<label for="spoken_to_the_parents" style="display:inline;">Yes</label>
<input name="spoken_to_the_parents" type="radio" value="no"style="margin: 12px 20px 1px 7px;">
<label for="spoken_to_the_parents" style="display:inline;">No</label>

</div><div style="width: 43%; display: flex;">
<label for="spoken_to_the_parents" style="margin: 8px 17px 1px 7px;">Description</label>
<textarea name="spoken_to_the_parents_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;"></textarea>
</div>
</div>

<div class="form-group d-column " style="display: flex;">
<div style="width: 42%; ">
<label>Has any body been all eged to be the abuser?</label>
</div><div style="width: 15%;">

<input name="abuser" type="radio" value="yes" style="margin: 12px 20px 1px 7px;">
<label for="abuser" style="display:inline;">Yes</label>
<input name="abuser" type="radio" value="no"style="margin: 12px 20px 1px 7px;">
<label for="abuser" style="display:inline;">No</label>

</div><div style="width: 43%; display: flex;">
<label for="abuser" style="margin: 8px 17px 1px 7px;">Description</label>
<textarea name="abuser_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;"></textarea>
</div>
</div>

<div class="form-group d-column" style="display: flex;">
<div style="width: 42%; ">
<label>Have you consulted any one else?</label>
</div><div style="width: 15%;">

<input name="consulted" type="radio" value="yes" style="margin: 12px 20px 1px 7px;">
<label for="consulted" style="display:inline;">Yes</label>
<input name="consulted" type="radio" value="no"style="margin: 12px 20px 1px 7px;">
<label for="consulted" style="display:inline;">No</label>

</div><div style="width: 43%; display: flex;">
<label for="consulted" style="margin: 8px 17px 1px 7px;">Description</label>
<textarea name="consulted_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;"></textarea>
</div>
</div>

<div class="form-group d-column" style="display: flex;">
<div style="width: 42%; ">
<label>Is there anyone else who might be involved in the incident? (e.g. anyone you think has seen or heard things related to the incident?) </label>
</div><div style="width: 15%;">

<input name="involved_in_the_incident" type="radio" value="yes" style="margin: 12px 20px 1px 7px;">
<label for="involved_in_the_incident" style="display:inline;">Yes</label>
<input name="involved_in_the_incident" type="radio" value="no"style="margin: 12px 20px 1px 7px;">
<label for="involved_in_the_incident" style="display:inline;">No</label>

</div><div style="width: 43%; display: flex;">
<label for="involved_in_the_incident" style="margin: 8px 17px 1px 7px;">Description</label>
<textarea name="involved_in_the_incident_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;"></textarea>
</div>
</div>
</div>
<div class="maintwoDivs">
<div class="form-group  ">
<label>Signature of person completing log:</label>
<input name="Signature_of_person_completing" type="text" placeholder=" " value="">
</div>
</div>


';






?>




<?php


echo '




</div>

<div class="maintwoDivs">
<div class="form-group"><button type="submit" name="submit" id="signup_btn" class="btn btn-lg btn-primary ">Submit Information</button></div>
</div>


</form>
'; ?>

</div><!-- tabs-add -->


</div><!-- tabs -->






</div><!-- tabs-add -->


<div id="tabs-view">
<div class="crm_search">
<div class="mr_old">
<div class="form-group col-12 col-sm-6"><h3 style='width:100%;'>View Issue</h3></div>

<div class="resources_search crm_search">



<input type="text" placeholder="Keywords" id="searchIsissue_serviceskywd" class="clientAddTbl_all_users_services clientAddTbl_all_users">
<!-- <button type="submit" id="resources_search"><i class='fas fa-search'></i></button> -->
</div>
<!-- resources_search -->
<div class="cpd-table">


<div class="cpd-tbl">
<?php 
$sql  = "SELECT * FROM safeguarding";
if ($_SESSION['currentUserType'] == 'Employee') {
$user = $_SESSION['webUser']['id'];
$sql  .= " where submitBy = '$user' ORDER BY `safeguarding`.`id` DESC";
} else {
$user = $_SESSION['webUser']['id'];
$sql  .= " where user = '$user' ORDER BY `safeguarding`.`id` DESC";
}

// var_dump($sql);


$data = $dbF->getRows($sql);
// var_dump($data);
echo '  <div class="cpd-table tableIBMS">


<div class="cpd-tbl">
<table  class="cpd-table tableIBMS">
<thead>
<tr>


<th>From</th>
<th>Name of person</th>




<th>Status</th>
<th>Record Entry Date</th>
<th>Action</th>


</tr>
</thead>
<tbody>';
foreach ($data as $key => $value) {
$loginid =  $value['user'];
$name =  $value['name_of_person'];
$dateTime =  $value['datetime'];
$status =  $value['status'];







$tp = "Pending";
if($status == "1"){

$tp = "Complete";

}







echo '<tr class="removeKeyPress">

<td>'.$functions->UserName($value['submitBy']).'</td>
<td>'.$name.'</td>

<td>'.$tp.'</td>
<td>'.Date('d-M-Y',strtotime($dateTime)).'</td>';


echo "<td><button class='btn btn-purple' data-toggle='tooltip' title='Change Status' style='cursor: pointer;' id='" . $value['id'] . "' onClick='changeStatusSafeguard(this.id)'>";

// echo $tp;
echo "<i class='fas fa-sync-alt'></i>";


echo "</button>";




echo "<button class='btn btn-purple' data-toggle='tooltip' title='View all details' style='cursor: pointer;' id='" . $value['id'] . "' onClick='viewSafeguarding(this.id)'><i class='fas fa-clipboard'></i></button>";



echo '<a class="btn btn-purple" href="printReports.php?id=' . base64_encode($value['id']) . ':Safeguarding" target="_blank" data-toggle="tooltip" title="Print/Save"><i class="fas fa-print"></i></a>';




echo "</td>";






echo "

</tr>";
}
?>
</tbody>
</table>
</div><!-- cpd-tbl -->
</div><!-- cpd-table -->
</div><!-- mr_old -->
</div><!-- crm_search -->
</div><!-- tabs-view -->
</div><!-- tabs -->










</div><!-- cpd-table hr-absence profile -->
</div><!-- right_side -->
</div><!-- left_right_side -->
</div><!-- index_content mypage resources -->
<style type="text/css">
    


  .mr_old {
    width: 100%;
    overflow-x: auto;
    overflow-y: auto;
}



    /*.infoDivClsass{*/

/*width: 8%;*/
  /*display: inline-block;*/

    /*}*/

.main-row .main-row-top * {
    vertical-align: top;
    display: inline-block;
    font-size: 13px;
    text-align:center;
}

.mr_old a{
    color: #fff !important;
}

.threeDivs {
    width: 8%;
    /*display: inline-block;*/
    padding: 0 5px;
}

.actionDiv {
    width: 5%;
  display: inline-block;
  text-align: center;
}

.main-row .main-row-top .actionDiv i {
    float: none;
    display: inline-block;
    font-size: 20px;
    padding: 0px 5px;
}
 .unlimitedDivs{

width: 24%;
  display: inline-block;

    }
 .onedivs{

width: 8%;
  display: inline-block;

    }

    p.client_com {
    font-size: 13px;
}
</style>
<?php include_once('footer.php'); ?>
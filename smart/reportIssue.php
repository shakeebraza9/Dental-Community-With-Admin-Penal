<?php 
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
global $dbF,$webClass;
if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Report Complaint',false);
}

$login       =  $webClass->userLoginCheck();
if(!$login){
header('Location: login');
}
include_once('header.php');
$msg = "";
$chk = $functions->accident_form_report_issue();
if($chk){
$msg = "Serious Accident Incident Form Add Successfully";
}


$chk1 = $functions->submitclientIssue();
if($chk1){
$msg = "Complaint Form Add Successfully";
}




include'dashboardheader.php';
?>
<div class="index_content mypage resources">
<div class="left_right_side">


<div class="link_menu">
<span>
<img src="webImages/menu.png" alt="">
</span>Report Issue
</div>
<!--link_menu close -->
<div class="left_side">
<?php $active = 'reportIssue'; include'dashboardmenu.php';?>
</div>
<!-- left_side close -->



<div class="right_side">

<h3 class="main-heading_">Report An Issue</h3>


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
<ul id="gettabs">
<li><a href="#tabs-add1" >Serious Accident Incident</a></li>
<li><a href="#tabs-add2" >Complaint Form</a></li>
</ul>
<div id="tabs-add1">


<div class="form-group col-12 col-sm-6"><h3 style='width:100%;'>Serious Accident Incident</h3></div>
<div class="form-group "></div><!-- form-group col-12 col-sm-6 -->

<?php 

echo '<form class="profile" action="#" role="form" method="post" enctype="multipart/form-data">'.$functions->setFormToken('accident_form_report_issue',false).'

<div class="row">

<div class="form-group col-12 col-sm-6" style=""><label>Type of incident (refer to policy if unsure)</label>




<select name="person_completing_type_of_incident">
<option value="">Select one</option>
<option value="Incident">Incident</option>
<option value="Serious Incident">Serious Incident</option>


</select>

</div>


<div class="maintwoDivs">
<div class="leftDivForm">
<div class="form-group label_50_per"><h3 style="width:100%;">Primary person(s) affected </h3>(Leave blank if no persons affected)</div>

<div class="form-group label_50_per"><label>First name:</label><input name="primary_person_fn" class="textbox50Per" type="text" placeholder=" " value=""></div>

<div class="form-group label_50_per"><label>Surname:</label><input name="primary_person_surname" class="textbox50Per" type="text" placeholder=" " value=""></div>

<div class="form-group label_50_per"><label>Identity</label><input name="primary_person_identity" class="textbox50Per" type="text" placeholder="i.e. service user, carer, staff role" value=""></div>

<div class="form-group label_50_per"><label>Address:</label><input name="primary_person_address" class="textbox50Per" type="text" placeholder=" " value=""></div>

<div class="form-group label_50_per"><label>Phone number:</label><input name="primary_person_pn" class="textbox50Per" type="text" placeholder=" " value=""></div>

<div class="form-group label_50_per"><label>Email:</label><input name="primary_person_email" class="textbox50Per" type="text" placeholder=" " value=""></div>

</div>




<div class="rightDivForm">


<div class="form-group label_50_per"><h3 style="width:100%;">Person(s) believed to be responsible </h3>(Leave blank if not applicable)</div>

<div class="form-group label_50_per"><label>First name:</label><input name="person_believed_fn" class="textbox50Per" type="text" placeholder=" " value=""></div>

<div class="form-group label_50_per"><label>Surname:</label><input name="person_believed_surname" class="textbox50Per" type="text" placeholder=" " value=""></div>

<div class="form-group label_50_per"><label>Identity</label><input name="person_believed_identity" class="textbox50Per" type="text" placeholder="i.e. service user, carer, staff role" value=""></div>

<div class="form-group label_50_per"><label>Address:</label><input name="person_believed_address" class="textbox50Per" type="text" placeholder=" " value=""></div>

<div class="form-group label_50_per"><label>Phone number:</label><input name="person_believed_pn" class="textbox50Per" type="text" placeholder=" " value=""></div>

<div class="form-group label_50_per"><label>Email:</label><input name="person_believed_email" class="textbox50Per" type="text" placeholder=" " value=""></div>

</div>
</div>

<div class="maintwoDivs"><h3 style="width:100%;">Details of person completing form</h3>
<div class="leftDivForm">














<div class="form-group label_50_per"><label>First name:</label><input name="person_completing_fn" class="textbox50Per" type="text" placeholder=" " value=""></div>
</div><div class="rightDivForm">
<div class="form-group label_50_per"><label>Surname:</label><input name="person_completing_surname" class="textbox50Per" type="text" placeholder=" " value=""></div>


</div>
</div>

<h3 style="width:100%;">Description of the incident</h3>







<div class="form-group" style="width:100%"><label>Your description should be as detailed as possible.</label>




<textarea name="desc_of_incident" placeholder="Please state only FACTS, not opinions."></textarea>




</div>
<h3 style="width:100%;">When and where the incident took place</h3>







<div class="form-group label_50_per col-12 col-sm-6"><label>Location:</label><input class="textbox50Per" name="incident_location" type="text" placeholder=" " value=""></div>

<div class="form-group label_50_per col-12 col-sm-6"><label>Address:</label><input class="textbox50Per" name="incident_address" type="text" placeholder=" " value=""></div>
<div class="form-group label_50_per col-12 col-sm-6"><label>Date:</label><input class="textbox50Per" name="incident_date" type="date" placeholder=" " value=""></div>
<div class="form-group label_50_per col-12 col-sm-6"><label>Time of incident</label><input class="textbox50Per" name="incident_time" type="text" placeholder="24h clock" value=""></div>


<div class="maintwoDivs">
<div class="leftDivForm">




<h3 style="width:100%;">Witness(1) to the incident</h3>






<div class="form-group label_50_per"><label>First name:</label><input class="textbox50Per" name="witness_fn1" type="text" placeholder=" " value=""></div>
<div class="form-group label_50_per"><label>Surname:</label><input class="textbox50Per" name="witness_surname1" type="text" placeholder=" " value=""></div>
<div class="form-group label_50_per"><label>Identity</label><input class="textbox50Per" name="witness_identity1" type="text" placeholder="i.e. service user, carer, staff role" value=""></div>
<div class="form-group label_50_per"><label>Address:</label><input class="textbox50Per" name="witness_address1" type="text" placeholder="" value=""></div>
<div class="form-group label_50_per"><label>Phone number:</label><input class="textbox50Per" name="witness_pn1" type="text" placeholder="" value=""></div>

</div>
<div class="rightDivForm">
<h3 style="width:100%;">Witness(2) to the incident</h3>








<div class="form-group label_50_per"><label>First name:</label><input class="textbox50Per" name="witness_fn2" type="text" placeholder=" " value=""></div>
<div class="form-group label_50_per"><label>Surname:</label><input class="textbox50Per" name="witness_surname2" type="text" placeholder=" " value=""></div>
<div class="form-group label_50_per"><label>Identity</label><input class="textbox50Per" name="witness_identity2" type="text" placeholder="i.e. service user, carer, staff role" value=""></div>
<div class="form-group label_50_per"><label>Address:</label><input class="textbox50Per" name="witness_address2" type="text" placeholder="" value=""></div>
<div class="form-group label_50_per"><label>Phone number:</label><input class="textbox50Per" name="witness_pn2" type="text" placeholder="" value=""></div>

</div></div>

<h3 style="width:100%;">If witness statements are required, list the names of individuals to request statements from:</h3>









<div class="form-group col-12 col-sm-6"><label>Immediate actions taken</label><input name="immediate_action_taken" type="text" placeholder="to reduce impact of incident and/or risk of reoccurrence. Include who took actions" value=""></div>
<div class="form-group col-12 col-sm-6"><label>Details of any external agencies involved</label><input name="detail_of_any_external_agency_involved" type="text" placeholder="include staff names, contact details, advice given and actions taken" value=""></div>



<div class="form-group col-12 col-sm-6"><label>Cause of incident</label><input name="cause_of_incident" type="text" placeholder="including any relevant events leading up to the incident" value=""></div>


<div class="form-group col-12 col-sm-6"><label>Management actions</label><input name="management_action" type="text" placeholder="" value=""></div>




<div class="form-group col-12 col-sm-6">
<label>Upload File:</label>
<input type="file" name="imageFx"></div>



</div>


<div class="form-group"><button type="submit" name="submit" id="signup_btn" class="btn btn-lg btn-primary ">Submit Information</button></div>

</form>';

?>

</div><!-- tabs-add -->

<div id="tabs-add2">


<div class="form-group col-12 col-sm-6"><h3 style='width:100%;'>Complaint Form</h3></div>
<div class="form-group "></div><!-- form-group col-12 col-sm-6 -->

<?php 
echo '<form class="profile" action="#" role="form" method="post" enctype="multipart/form-data">


'.$functions->setFormToken('submitclientIssue',false).'


<div class="row">

<h3 style="width:100%;">Person making the complaint</h3>





<div class="form-group col-12 col-sm-6">
<label>Name:</label>
<input name="complaint_name" type="text" placeholder=" " value="">
</div>



<div class="form-group col-12 col-sm-6">
<label>Address:</label>
<input name="complaint_address" type="text" placeholder=" " value="">
</div>

<div class="form-group col-12 col-sm-6">
<label>Telephone Number:</label>
<input name="complaint_tel" type="text" placeholder=" " value="">
</div>
<div class="form-group col-12 col-sm-6">
<label>Names of any employees specifically complained of or complimented:</label>
<input name="complaint_employee" type="text" placeholder=" " value="">
</div>
<div class="form-group col-12 col-sm-6">
<label>Name and contact details of the healthcare professional to which the complaint refers:</label>
<input name="complaint_refers" type="text" placeholder="" value="">
</div>

<div class="form-group col-12 col-sm-6">
<label>Details of complaint, concern or compliment:</label>
<input name="complaint_detail" type="text" placeholder="include dates, times and witnesses where possible" value="">
</div>



<div class="form-group col-12 col-sm-6">
<label>Name of person originally complained to:</label>
<input name="complaint_originally" type="text" placeholder="if not the person completing this form" value="">
</div>

<div class="form-group col-12 col-sm-6">
<label>Name of the person to whom the complaint was referred on to for investigation:</label>
<input name="complaint_investigation" type="text" placeholder="Name of Person "as above" if the person who receives the complaint also investigates" value="">
</div>

<div class="form-group col-12 col-sm-6">
<label>Investigations carried out:</label>
<input name="complaint_carried_out" type="text" placeholder="attach additional pages if required" value="">
</div>

<div class="form-group col-12 col-sm-6">
<label>Action taken or recommended by investigator:</label>
<input name="complaint_action" type="text" placeholder=" " value="">
</div>

<div class="form-group col-12 col-sm-6">
<label>Did this action satisfy the complainant? If not, state why, and who the complaint was referred on to next:</label>
<input name="complaint_nextrefer" type="text" placeholder="" value="">
</div>
<div class="form-group col-12 col-sm-6">
<label>Name of organization to which the complaint was referred in the event of a failure to satisfy the complainant?</label>
<input name="complaint_name_of_org" type="text" placeholder="" value="">
</div>

<div class="form-group col-12 col-sm-6">
<label>Action taken by person to whom the complaint was referred on to:</label>
<input name="complaint_referred_onto" type="text" placeholder=" " value="">
</div>

<div class="form-group col-12 col-sm-6">
<label>Did this action satisfy the complainant?</label>
<input name="complaint_action_satisfy" type="text" placeholder="" value="">
</div>





<div class="form-group col-12 col-sm-6">
<label>Date:</label>
<input name="complaint_date" type="date">
</div>

<div class="form-group col-12 col-sm-6">
<label>Complainant details:</label>
<input name="complaint_details" type="text" placeholder=" " value="">
</div>

<div class="form-group col-12 col-sm-6">
<label>Summary of complaint:</label>
<input name="complaint_summary" type="text" placeholder="" value="">
</div>

<div class="form-group col-12 col-sm-6">
<label>Action Taken:</label>
<input name="complaint_action_taken" type="text" placeholder=" " value="">
</div>


<div class="form-group col-12 col-sm-6">
<label>Upload File:</label>
<input type="file" name="imageFx">
</div>


';






?>




<?php


echo '




</div>


<div class="form-group"><button type="submit" name="submit" id="signup_btn" class="btn btn-lg btn-primary ">Submit Information</button></div>



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
<select id="clientAddTbl_all_users" class="clientAddTbl_all_users">


<option value="all">Filter</option>
<option value="Serious Accident Incident Form">Serious Accident Incident Form</option>
<option value="Complaint Form">Complaint Form</option>



</select>


<input type="text" placeholder="Keywords" id="searchIsissue_serviceskywd" class="clientAddTbl_all_users_services clientAddTbl_all_users">
<!-- <button type="submit" id="resources_search"><i class='fas fa-search'></i></button> -->
</div>
<!-- resources_search -->
<div class="cpd-table">


<div class="cpd-tbl">
<?php 
$sql  = "SELECT * FROM clientAddIssue";
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = $_SESSION['webUser']['id'];
$sql  .= " where submitBy = '$user' AND status != '-1' ORDER BY `clientAddIssue`.`id` DESC";
} else {
$user = $_SESSION['currentUser'];
$sql  .= " where userId = '$user' AND status != '-1' ORDER BY `clientAddIssue`.`id` DESC";
}

// var_dump($sql);


$data = $dbF->getRows($sql);
echo '  <div class="cpd-table tableIBMS">


<div class="cpd-tbl">
<table  class="cpd-table tableIBMS">
<thead>
<tr>


<th>From</th>
<th>Type</th>
<th>Completing Name</th>
<th>About Incident</th>


<th>Status</th>
<th>Record Entry Date</th>
<th>Action</th>


</tr>
</thead>
<tbody>';
foreach ($data as $key => $value) {
$loginid =  $value['userId'];
$filename =  $value['filename'];
$otherDetail =  $value['otherDetail'];
$dateTime =  $value['dateTime'];
$name =  $value['name'];
$status =  $value['status'];



$cn =  $value['name'];
if($cn == "Complaint Form"){
$cn =  $value['complaint_name'];
}else{
$cn =  $value['person_completing_fn'];
}

$complaint_summary =  $value['name'];
if($complaint_summary == "Complaint Form"){
$complaint_summary =  $value['complaint_summary'];
}else{
$complaint_summary =  $value['desc_of_incident'];

}



$tp = "Pending";
if($status == "1"){

$tp = "Complete";

}







echo '<tr class="removeKeyPress">

<td>'.$functions->UserName($value['submitBy']).'</td>
<td>'.$name.'</td>
<td>'.$cn.'</td>
<td>'.$complaint_summary.'</td>


<td>'.$tp.'</td>
<td>'.Date('d-M-Y',strtotime($value['todayDate'])).'</td>';


echo "<td><button class='btn btn-danger' data-toggle='tooltip' title='Change Status' style='cursor: pointer;' id='" . $value['id'] . "' onClick='changeStatuses(this.id)'>";

// echo $tp;
echo "<i class='fas fa-sync-alt'></i>";
echo "</button>";
echo "<button class='btn btn-danger' data-toggle='tooltip' title='Delete' style='cursor: pointer;' id='" . $value['id'] . "' onClick='changeStatusesDel(this.id)'><i class='fas fa-trash'></i></button>";



$typess =  $value['name'];
if($typess == "Complaint Form"){

echo "<button class='btn btn-danger' data-toggle='tooltip' title='View all details' style='cursor: pointer;' id='" . $value['id'] . "' onClick='viewComplaintIssue(this.id)'><i class='fas fa-clipboard'></i></button>";
}else{

echo "<button class='btn btn-danger' data-toggle='tooltip' title='View all details' style='cursor: pointer;' id='" . $value['id'] . "' onClick='viewIncidentIssue(this.id)'><i class='fas fa-clipboard'></i></button>";

}



if($value['filename'] != ""){

echo "<button class='btn btn-danger' title='View file' data-toggle='tooltip' style='cursor: pointer;' id='" . $value['id'] . "' onClick='viewComplainFile(this.id)'><i class='fas fa-eye'></i></button>";
}else{




}



if($typess == "Complaint Form"){

echo '<a class="btn btn-danger" href="printReports.php?id=' . base64_encode($value['id']) . ':Complaint Form" target="_blank" data-toggle="tooltip" title="Print/Save"><i class="fas fa-print"></i></a>';
}else{

echo '<a class="btn btn-danger" href="printReports.php?id=' . base64_encode($value['id']) . ':Serious Accident Incident Form" target="_blank" data-toggle="tooltip" title="Print/Save"><i class="fas fa-print"></i></a>';
}



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
<?php 
include_once("global.php");
global $dbF,$webClass;
$login       =  $webClass->userLoginCheck();
if(!$login){
header('Location: login');
}
include_once('header.php');
$msg = "";
$chk = $functions->submitclientstatus();
if($chk){
$msg = "Client Add Successfully";
}


$chk = $functions->addnotesTitle();
if($chk){
$msg = "Notes Create Successfully";
}

$chk = $functions->addnotescomments();
if($chk){
$msg = "Notes Comments Added";
}


$chk = $functions->clientstatusedit();
if($chk){
$msg = "Client Edit Successfully";
}



$chk = $functions->changeColor();
if($chk){
$msg = "Color Updated Successfully";
}

$chk = $functions->changeStatus();
if($chk){
$msg = "Updated Successfully";
}



include'dashboardheader.php';



  
 


 



     ?>
<div class="index_content mypage resources">
<div class="left_right_side">
<div class="link_menu">
<span>
<img src="webImages/menu.png" alt="">
</span>Client Status
</div>
<!--link_menu close -->
<div class="left_side">
<?php $active = 'addClient'; include'dashboardmenu.php';?>
</div>
<!-- left_side close -->
<div class="right_side">
<div class="right_side_top">
<div class="change-session">
<?php
$functions->changeSession();

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0') {
}
else { ?>

    <div class="col1_btnn col1_btn22">
<a href="javascript:;" onclick="addClient('new')">Add Client</a>
</div>

<?php 
}
$data = $functions->health_check($_SESSION['currentUser']);
if($data && $_SESSION['currentUserType'] !='Employee' || @$_SESSION['superUser']['cdashboard'] == 'edit' || @$_SESSION['superUser']['cdashboard'] == 'full')
{ ?>
<div class="col1_btnn">
<a href="<?php echo WEB_URL."/health_check_form" ?>">Initial Compliance Health Check form</a>
</div>
<?php } ?>
</div>
<!-- change-session -->
</div>
<!-- right_side_top close -->
<?php if($msg!=''){ ?>
<div class="col-sm-12 alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $msg; ?>
</div>
<?php } ?>


<div class="resources_search crm_search">
<select id="clientAddTbl_all_users" class="clientAddTbl_all_users">
<?php echo $functions->clientAddTbl_all_users() ?>
</select>
<!-- <input type="text" placeholder="Keywords" id="kywd" class="optn"> -->
<!-- <button type="submit" id="resources_search"><i class='fas fa-search'></i></button> -->
<select id="clientAddTbl_all_users_services" class="clientAddTbl_all_users_services">
<?php echo $functions->clientAddTbl_all_users_services() ?>
</select>
<input type="text" placeholder="Keywords" id="clientAddTbl_all_users_serviceskywd" class="clientAddTbl_all_users_services clientAddTbl_all_users">
<button type="submit" id="resources_search"><i class='fas fa-search'></i></button>
</div>
<!-- resources_search -->

<div class="cpd-table hr-absence profile">

<div id="tabs">
<ul id="gettabs">
<li><a href="#tabs-customer" >Customer</a></li>
<li><a href="#tabs-lead" >Lead</a></li>
</ul>
<div id="tabs-customer">
<div class="mr_old">
<?php $functions->viewClientsData("1") ?>
</div>
<!-- mr -->
</div>
<div id="tabs-lead">
<div class="mr_old">
<?php $functions->viewClientsData("0") ?>
</div>
<!-- mr -->
</div>
</div>
</div>
<!-- cpd-table -->
</div>
<!-- right_side close -->
</div>
<!-- left_right_side -->
<script>
// $('.APIedit').on('click', function() {
// start_loader();
// var url = this.id;
// var windowurl = window.location.href;
// $.get("https://script.google.com/macros/s/AKfycbyF0ZruTXnjYPGrD02L306gOd50I9LSEjHcN6wVCR_Qaa4ReJNY/exec?url="+url, function(id) {
// localStorage.setItem("url",url);
// localStorage.setItem("windowurl",windowurl);
// document.cookie="id="+id;
// $.get("https://script.google.com/macros/s/AKfycbwYy6HL5H9O85RtbH5YXBIJxnrO_Pd175XZJRW0ww/exec?id="+id, function(editurl) {
// document.cookie="editurl="+editurl; 
// $.get("https://script.google.com/macros/s/AKfycbx_uPRmTSV6kXAKe4Lhw-xwSG_y9giQHEaMeFwNcHGMun6doBqr/exec?id="+id);
// location.replace("<?php //echo WEB_URL ?>/docs");
// });
// });
// });




</script>

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


<script type="text/javascript">
          function AjaxDelScript(thss){ 
            // btn=$(ths);
            console.log(thss);
            // console.log(btn);
            if(secure_delete()){
                $.ajax({
                    type: 'POST',
                      url: "_models/functions/products_ajax_functions.php?page=deleteClientInCRMpage",
                    data: {itemId:thss}
                }).done(function(data)
                {
                       console.log(data);
                    ift =true;
                    if(data=='1'){
                        // btn.closest('tr').hide(1000,function(){
                          $('.div'+thss).remove();
                        // });
                    }
                    // else(data=='0'){
                    // alert('Delete Fail Please Try Again.');
                // }


                });
            }
        };

</script>
<?php include_once('footer.php'); ?>
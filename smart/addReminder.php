<?php 
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
global $dbF,$webClass;
if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Reminder management',false);
}

$login       =  $webClass->userLoginCheck();
if(!$login){
header('Location: login');
}
include_once('header.php');




$msg = "";
$chk = $functions->addReminder();
if($chk){
$msg = "Reminder Add Successfully";
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
<?php $active = 'calendar'; include'dashboardmenu.php';?>
</div>
<!-- left_side close -->



<div class="right_side">

<?php

if(isset($_POST['submit_btn'])){
    $id = $_POST['id'];
    $ttitle = $_POST['ttitle'];
    $ffromdate = $_POST['ffromdate'];
    $ttodate = $_POST['ttodate'];

    $sql = "UPDATE `practiceaddreminder` SET `ttitle` = '$ttitle', `ffromdate` = '$ffromdate', `ttodate` = '$ttodate' WHERE `id` = '$id'";
    $dbF->setRow($sql);
        // If($isSubmit > 0){
        $msg = "Reminder Updated Successfully";
        // }
        // else{
        // $msg = "Reminder Updation Successfully";
        // }
}

?>
<h3 class="main-heading_">My Reminder</h3>
<?php if($msg!=''){ ?>
<div class="col-sm-12 alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $msg; ?>
</div>
<?php } ?>


<div class="cpd-table hr-absence profile">


<div id="tabs">
<ul id="gettabs">

<li><a href="#tabs-view" >View</a></li><li><a href="#tabs-add" >Add</a></li>
</ul>
<div id="tabs-add">



 


<div class="form-group col-12 col-sm-6"><h3 style='width:100%;'>Reminder management</h3></div>
 

<?php 

echo '<form class="profile" action="#" role="form" method="post" enctype="multipart/form-data">'.$functions->setFormToken('addReminder',false).'
 

<div class="form-group col-12 col-sm-6"><label>Reminder title</label><input name="ttitle" type="text" placeholder="Reminder title" value="" required></div>


<div class="form-group col-12 col-sm-6"><label>From date</label><input name="ffromdate" type="text" class="datepicker" autocomplete="off"  placeholder="From date" value=""></div>

<div class="form-group col-12 col-sm-6"><label>To date</label><input name="ttodate" type="text" placeholder="To date" class="datepicker" autocomplete="off" value=""></div>

 
 
 

<div class="form-group col-12 "><button type="submit" name="submit" id="signup_btn" class="btn btn-lg btn-primary ">Save Reminder</button></div>

</form>';

?>

 

 






</div><!-- tabs-add -->


<div id="tabs-view">
 

 <?php 
$sql  = "SELECT * FROM practiceaddreminder";
 
$user = $_SESSION['currentUser'];
$sql  .= " where pid = '$user'";
 

// var_dump($sql);


$data = $dbF->getRows($sql);

?>
<div class="cpd-table tableIBMS">


<div class="cpd-tbl">
<table  class="cpd-table tableIBMS">
<thead>
<tr>

<th>Title</th>
<th>From</th>
<th>To</th>
<th>Action</th>
 
 


</tr>
</thead>
<tbody>

	 <?php
foreach ($data as $key => $value) {


	
$ttitle =  $value['ttitle'];
$ffromdate =  $value['ffromdate'];
$ttodate =  $value['ttodate'];
 




echo '<tr class="removeKeyPress">
 
<td>'.$ttitle.'</td>
<td>'.$ffromdate.'</td>
<td>'.$ttodate.'</td>
<td>
	<button class="del-btn" data-toggle="tooltip" title="Edit detail" style="cursor: pointer;" id="' . $value['id'] . '" onClick="myremindersedit(this.id)"><i class="fas fa-edit"></i></button>

	<button class="del-btn" data-toggle="tooltip" title="Delete" style="cursor: pointer;" id="' . $value['id'] . '" onClick="deleteReminder(this)"><i class="fas fa-trash"></i></button>
</td>

 ';

  

  






echo "

</tr>";
}
?>
</tbody>
</table>

</div>
</div>



</div>
 
</div><!-- tabs -->
 
</div><!-- cpd-table hr-absence profile -->



<script type="text/javascript">
	 
	$(".datepicker").datepicker({ dateFormat: 'd-M-yy',
	changeMonth: true,
	changeYear: true,
	yearRange:  "1947:<?php echo date('Y'); ?>"


	});



</script>


 <script type="text/javascript">
 	function deleteReminder(ths){
        btn=$(ths);
        if(secure_delete()){
            // btn.addClass('disabled');
            // btn.children('.trash').hide();
            // btn.children('.waiting').show();

            id=btn.attr('id');
            $.ajax({
                type: 'POST',
                url: 'ajax_call.php?page=deleteReminder',
                data: { id:id }
            }).done(function(data)
                {
                    ift =true;
                    
                        
                        btn.closest('tr').hide(1000,function(){$(this).remove()});
                    
                    

                    if(ift){
                        btn.removeClass('disabled');
                        btn.children('.trash').show();
                        btn.children('.waiting').hide();
                    }

                });
        }
    }
 </script>

 
</div><!-- right_side -->
</div><!-- index_content -->
</div><!-- left_right_side mypage resources -->
 
<?php include_once('footer.php'); ?>
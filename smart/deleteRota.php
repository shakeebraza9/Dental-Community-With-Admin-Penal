<?php 
include_once("global.php");

global $dbF,$webClass,$functions;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php');

$functions->pin();

include'dashboardheader.php'; 

$display = "";

if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrreports'] == '0'){
    $display = "style='display:none'";
    $_GET['page'] = 'staff';
    $_GET['user'] = $_SESSION['superid'];
}

$chk = $functions->rotadeletemultipleSubmit();
if($chk){
    
    $chk = "Rota  delete";
}
?>
<style>
   /* This css is for normalizing styles. You can skip this. */
*, *:before, *:after {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}




.new {
  padding: 50px;
}

.checkboxx {
  display: block;
  margin-bottom: 15px;
}

.checkboxx input {
  padding: 0;
  height: initial;
  width: initial;
  margin-bottom: 0;
  display: none;
  cursor: pointer;
}

.checkboxx label {
  position: relative;
  cursor: pointer;
}

.checkboxx label:before {
  content:'';
  -webkit-appearance: none;
  background-color: transparent;
  border: 2px solid #0079bf;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
  padding: 10px;
  display: inline-block;
  position: relative;
  vertical-align: middle;
  cursor: pointer;
  margin-right: 5px;
}

.checkboxx input:checked + label:after {
  content: '';
  display: block;
  position: absolute;
  top: 2px;
  left: 9px;
  width: 6px;
  height: 14px;
  border: solid #0079bf;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}
</style>

<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            Delete Rota By Date
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'hrm'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side rota">
            <div class="right_side_top">
                <div class="change-session">
                <?php
                  //  $functions->changeSession();
                ?>
                </div>
                <!-- change-session -->
            </div>
            <!-- right_side_top close -->
            <div class="profile rota">
            <form method="POST"  action="" enctype="multipart/form-data">
                 <?php echo $functions->setFormToken('rotadeletemultiple',false); ?>
                 <h1 style='font-size: 33px;font-family: montserratmedium;border-bottom: 4px solid #01abbf;padding-bottom: 2px;margin-bottom: 10px;color: #333;display: inline-block;text-align: center;'>Rota Delete</h1>
                <div class="row">
                <div class="form-group col-12 col-md-6">
                    <label>From</label>
                    <input class="datepicker" type="text" name="from" value="<?php echo @$_GET['from'] ?>" required autocomplete="off" readonly >
                </div>
                <div class="form-group col-12 col-md-6">
                    <label>To</label>
                    <input class="datepicker" type="text" name="to" value="<?php echo @$_GET['to'] ?>" required autocomplete="off" readonly>
                </div>
                <?php
                
                    if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){
                       
                    $display = "style='display:none'";
                    } 
                
                else { 
                     $display="";
                }
                ?>
                <div class=" checkboxx col-12 col-md-6 user"  <?php echo $display ?>>
                   <h3>Select User</h3>
                   
                 
                        <?php echo $functions->allEmployeeCheckbox($_SESSION['currentUser']) ?>
                    
                    

                    <?php
                if(@$_GET['page'] == 'staff') { ?>
                    <script>$('.staff').val("<?php echo @$_GET['user'] ?>").change();</script>
                    <?php } ?>
                </div>
                <div class="form-group col-12">
                    <input class="submit_class" id="myForm" onclick="secure_delete('By Submitting This Form Rota Will Be Deleted Permanently. Please Proceed With Precautions')" type="submit" name="submit" value="Submit">
                </div>
                </div>
            </form>
           
        </div>
    </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <script>
         function secure_delete(text){
            // text = 'view on alert';
            text = typeof text !== 'undefined' ? text : 'Are you sure you want to Delete.';

            bool=confirm(text);
            if(bool==false)
                {  
                    return false;}
            else{

             <?php 
                    //echo "<pre>"; 
                 
                   // echo "<pre>"; 
            ?>

                   return true;
               }

        }

    </script>
</div>
<!-- index_content -->

<?php include_once('footer.php'); ?>
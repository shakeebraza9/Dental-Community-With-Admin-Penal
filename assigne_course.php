<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}


$msg = $functions->addCoursCPD_multiple_user();
  // var_dump($msg);
  if ($msg) {
     
     $msg =  "Succesfully Done ...";   
  }     
// include_once('header.php'); 

include'dashboardheader.php'; ?>
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
  display: block;
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
  top: 5px;
  left: 9px;
  width: 6px;
  height: 14px;
  border: solid #0079bf;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

</style>
<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        
        <!-- left_side close -->
        <div class="right_side">
        <h3 class="main-heading_">Assign Course</h3>
                   
            <div class="right_side_top">
                <div class="change-session">
                    <?php
                    //$functions->changeSession();
                    ?>
                    <?php
                    $requiredHours  = $functions->requiredHours();
$completedHours = $functions->completedHours();
$remainingHours = $requiredHours-$completedHours;
                    ?>
                </div>
                <!-- change-session -->
               
                <!-- jumbo -->
            </div>
            <!-- right_side_top close -->
            
            <?php if($msg !=''){ ?>
                    <div class="col-sm-12 alert alert-success alert-dismissible" style="margin-top: 10px">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo $msg; ?>
                    </div>
                    <?php } ?>
          
               <div class="cpd-courses">
            
                  <div id="tabs">
                 <ul>
                     <li ><a active href="#tabs-1">  Add Courses </a></li>
                     <li><a href="#tabs-2"> View Assigned Courses </a></li>
                 </ul>
                 <div id="tabs-1">
                     <form method="POST"  action="" enctype="multipart/form-data">
                 <?php echo $functions->setFormToken('rotadeletemultiple',false); ?>
                <!--  <h1 style='font-size: 33px;font-family: montserratmedium;border-bottom: 4px solid #01abbf;padding-bottom: 2px;margin-bottom: 10px;color: #333;display: inline-block;text-align: center;'>Rota Delete</h1> -->
               
                
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
                <div class="form-group col-12 col-md-6 box">
                      <h3>Select Course</h3>
                    
                  <?php 
                      $sql  = "SELECT * FROM `subjects` WHERE `test_category`='CPD Courses' AND `under`='0' AND `publish`='1'   ";
                    $data = $dbF->getRows($sql);

             echo '<select name="cpdcourse">
             <option selected disable value="">Select Course </option>';
              foreach ($data as $key => $value) {
              
                       
                  $title =  $value['subject_title'].$mod;
                    echo '  <option value="'.$value['subject_id'].'"> '.$title.'</option>';
        }

             echo '</select>';
                      ?>
                      
                       <!-- Design tiré du site flatuicolors.com -->
                    

                    <!-- Bouton Select reconstruit -->
           
                   


           

                  </div>
               
                    <!-- Bouton Select reconstruit -->

                <div class="form-group col-12">
                    <input type="submit" class="submit_class" id="myForm"  value="Submit">
                </div>
                
            </form>


                 </div>
                 <div id="tabs-2">
                     <?php 

                  

     $sql  = "SELECT * FROM `subjects` INNER JOIN delegate_cpd_course ON `subject_id` = `delegate_subject_id` WHERE `test_category`='CPD Courses' AND `under`='0' AND `publish`='1' AND `delegate_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_type` = '1' AND`acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under' OR acc_id = '$user') AND acc_type='1') ORDER BY subject_title,dateTime DESC";
                    $data = $dbF->getRows($sql);
               echo '  <div class="cpd-table">
                <h3></h3>
                <div class="cpd-tbl">
                <div class="overflow_table">
                <table>
                    <thead>
                        <tr>
                            <th>Course Title</th>
                            <th>Delegated To</th>
                            <th>Date Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
              foreach ($data as $key => $value) {

               

              $module = $dbF->getRow("SELECT COUNT(*) FROM `subjects` WHERE `under`='0' AND `course_dental_category` = 'delegate' AND `publish`='1'");
                        if($module[0] > 0){
                            $mod = "<span>( $module[0]&nbsp;MODULES)</span>";
                        }
                        else{
                            $mod = "";
                        }
                  $title =  $value['subject_title'].$mod;
                  $replace = str_replace('&', '',str_replace(' ', '',$value['course_dental_category']));


        echo '  <tr>
                 <td>'.$title.'</td>
                 <td>'.$functions->UserName($value['delegate_user']).'</td>
                 <td>'.Date('d-M-Y',strtotime($value['dateTime'])).'</td>';
           echo "<td><a data-id='".$value['id']."' onclick='AjaxDelScript(this);' class='btn edit_btn secure_delete' style=width: 45px;'>
                                    <i class='glyphicon glyphicon-trash trash fa fa-trash' ></i>
                                    <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
                                </a></td>
               </tr>";
        }
                      ?>
                    </tbody>
                </table>
                
                </div>
                </div>
                <!-- cpd-tbl -->
            </div>
            <!-- cpd-table -->
                 </div>
              </div>
            <!-- tabs -->        
             
              </div>
          



        </div>
        <!-- right_side close -->
    <!-- </div> -->
    <!-- left_right_side -->
       <script>
        function AjaxDelScript(ths){
            btn=$(ths);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=delete_delegate_cpd_course',   
                    data: { itemId:id }
                }).done(function(data)
                {
                    ift =true;
                    //    console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
        // Remove row from HTML Table
        $(ths).closest('tr').css('background','e5f3f2');
        $(ths).closest('tr').fadeOut(800,function(){
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


    </script>
   
    <?php include_once('dashboardfooter.php'); ?>
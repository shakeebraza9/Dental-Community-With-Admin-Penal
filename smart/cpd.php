<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
$msg='';
$msg = $functions->CpdInsertDocument();

include_once('header.php'); 

include'dashboardheader.php'; ?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            CPD Dashboard
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'cpd-dashboard'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div class="right_side_top">
                 <h3 class="main-heading_">Bitesize CPD Learning</h3>
                <div class="change-session">
                    <?php
                    $functions->changeSession();
                    ?>
                    <?php
                    $requiredHours  = $functions->requiredHours();
$completedHours = $functions->completedHours();
$remainingHours = $requiredHours-$completedHours;
                    ?>
                </div>
                <!-- change-session -->
                <div class="jumbo hrm flex_">
                   
                    
                    <div class="jumbo-left">
                          <div class="cpd-main-box">
                <div class="row mainClass">
                    <div class="col-md-4">
                        <div class="cpd-inner-box">
                            <div class="cpd-box-content">
                                <h5>Required CPD Hours</h5>
                                <h3><?php echo $requiredHours ?></h3>
                            </div>
                            <img src="webImages/cpd1.svg">
                            <div class="line"></div>
                        </div>
                        <!-- cpd-inner-box -->
                    </div>
                    <div class="col-md-4">
                        <div class="cpd-inner-box">
                            <div class="cpd-box-content">
                                <h5>Completed CPD Hours</h5>
                                <h3><?php echo $completedHours ?></h3>
                            </div>
                            <img src="webImages/cpd2.svg">
                            <div class="line"></div>
                        </div>
                        <!-- cpd-inner-box -->
                    </div>
                    <div class="col-md-4">
                        <div class="cpd-inner-box">
                            <div class="cpd-box-content">
                                <h5>Remaining CPD Hours</h5>
                                <h3><?php echo $remainingHours ?></h3>
                            </div>
                            <img src="webImages/cpd3.svg">
                            <div class="line"></div>
                        </div>
                        <!-- cpd-inner-box -->
                    </div>
                </div>
            </div>
                    </div>
                      <div class="jumbo-right">
                            <div class="jumbo-v">
                                <img src="webImages/jumbovideo.png">
                                <a onclick="video('EJUtPIhK-Bg')"><img src="webImages/jumbobtn.svg"></a>
                            </div>
                            <div><span>Play a Demo Video
                        </span></div>
                    </div>
                </div>
                <!-- jumbo -->
            </div>
            <!-- right_side_top close -->
          
            <!-- cpd-main-box -->
            <div class="cpd-table cpd-table-1">
                <div class="p-heading"><h3>Attempt CPD</h3></div>
                <div class="cpd-tbl">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Certifcate</th>
                            <th>Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                             if($_SESSION['currentUserType'] == 'Employee'){
                           // $user = $user = $_SESSION['superid'];
                            $user = $_SESSION['superid'];
                        }
                        else{
                            $user = $_SESSION['currentUser'];
                       
                        }
                        $sql = "SELECT * FROM `assigned_paper` JOIN `paper` ON `paper`.`paper_id` = `assigned_paper`.`assign_paper` WHERE `result`='completed' AND `status`='1' AND  `assign_user`='$user' ORDER BY `completion_date` DESC LIMIT 10"; //
                        $data = $dbF->getRows($sql);
                        foreach ($data as $key => $value) {
                            $d = $dbF->getRow("SELECT `subject_title` FROM `subjects` WHERE `subject_id`='$value[subject_id]'");
                            $title = $d[0];
                            $display = "";
                            $assignid = md5($value['assign_id']);
                            $c_date = date("d-M-Y",strtotime($value['completion_date']));
                            $hours = round(((int)$value['minutes']/60),2);
                            $gdc = $value['development_outcomes'];
                            $ab = $value['activity_benefit'];
                            $result = ucwords($value['result']);
                            $status = $value['result'];
                            if($status != 'failed' && $value['expiry_date'] < date('Y-m-d')){
                                $result = 'Expired';
                                $status = 'expired';
                            }
                        $faileddisplay = "style='display:none'";
                            if($status == 'failed'){
                                $display = "style='display:none'";
                                $faileddisplay = "style='display:block'";

                            }
                          
                           $thisid =  '"'.$value['assign_id'].'"';
                           $certificate_title = '"'.$title.'"';
                           $certificate_title = str_replace(' ', '::',$certificate_title);
                           $certificate_user = '"'.$value['assign_user'].'"';
                           $certificate_expiry_date = '"'.date("Y-m-d",strtotime($value['expiry_date'])).'"'; 
                    $certificate_completion_date = '"'.date("Y-m-d",strtotime($value['completion_date'])).'"'; 
                    
            if($_SESSION['currentUserType'] == 'Employee'){
                $user = $_SESSION['superid'];
                
            }
            else{
                $user = $_SESSION['currentUser'];
               

            }

           
             $filename= WEB_URL.'/images/files/cpd-certificates/'.$user.':_:'.$functions->UserName($user).'-'.$title.'_'.$value['expiry_date'].'.pdf';
              $filename=str_replace(" ", "_", $filename);
            
                  $sql = "SELECT * FROM `userdocuments` WHERE `user` = '$user' AND `file` ='$filename' ";  
                      $chekFile = $dbF->getRow($sql);
                      $hide = '';
                      if ($chekFile > 0) {
                          $hide = "<a class='anim anim2 tooltips' data-toggle='tooltip' title='Your Certificate Uploaded' $display href='javascript:;'><i class='fa fa-address-card'></i></a>";
                      }else{   
                          $hide = "  <a class='anim anim2 tooltips' data-toggle='tooltip' title='Click to Upload Staff Folder' $display href='javascript:;'  onclick='documentselectcpdpdf($thisid,$certificate_user);' ><i class='fa fa-address-card'></i> </a>";
                      }

                            echo "<tr>
                                    <td>$title</td>
                                    <td>$c_date</td>
                                    <td><span class='$status'>$result</span></td>
                                    <td>";
                                   if ($result == 'Expired' || $status == 'expired') { echo  "<a class='anim anim2 ' data-toggle='tooltip' title='Click To Print' $display href='printResult.php?assignid=$assignid'><i class='fas fa-print' target='_blank'></i> </a>
                              <a class='anim anim2 ' data-toggle='tooltip' title='Click To Download' $display href='downloadResult.php?assignid=$assignid' target='_blank'><i class='fas fa-download'></i></a>
                                 
                            
                            <a href='javascript:;' data-id='$value[assign_id]'  onclick='AjaxDelScript(this);'  $faileddisplay class='delete'>Delete</a>
                              ";  }
                                   else{
                                         echo  "<a class='anim anim2 ' data-toggle='tooltip' title='Click To Print' $display href='printResult.php?assignid=$assignid' target='_blank'><i class='fas fa-print'></i> </a>
                              <a class='anim anim2 ' data-toggle='tooltip' title='Click To Download' $display href='downloadResult.php?assignid=$assignid' target='_blank'><i class='fas fa-download' target='_blank'></i></a>
                              $hide     
                            
                            <a href='javascript:;' data-id='$value[assign_id]'  onclick='AjaxDelScript(this);'  $faileddisplay class='delete'>Delete</a>

                              ";
                              


                                   }
                                
                                 echo "</td>";
                                         echo "
                     
                                    </td>
                                    <td>
                                        <div class='cpd-stars'>";


                                       $x = 1;
                                for ($i=0; $i < @$value['star']; $i++) { 
                                   echo "<i class='fas fa-star'></i>";
                                }



                                echo "</div>
                                    </td>
                                  </tr>";
                        }
                        ?>
                         <script>
        function myFunction() {
  alert("Sorry, the CPD certificates are currently under maintenance work. Please try back later Sorry for the inconvenience !");
}
          
       </script>
                        </tbody>
                    </table>
                </div>
                <!-- cpd-tbl -->
            </div>
            <!-- cpd-table -->
            <div class="cpd-courses">
                <div class="p-heading">
                    <h3>Courses</h3>
                    <div class="src-cpd">
                        <input type="text" id="src-cpd"><i class="fas fa-search"></i>
                    </div>
                </div>
                 <?php echo $functions->course_dentis_category_title() ?>
               
                <div class="row grid">
                 
                    <?php
                    $sql  = "SELECT * FROM `subjects` WHERE `test_category`='CPD Courses' AND `under`='0' AND `publish`='1'  ";  
                    // AND `course_dental_category` NOT IN ('','Delegate')
                    $data = $dbF->getRows($sql);
                   
       
       
               foreach ($data as $key => $value) {
            
            $sql2  = "SELECT * FROM `delegate_cpd_course` WHERE delegate_subject_id = '$value[subject_id]' AND `delegate_user` = '$user' ";  
           $data2 = $dbF->getRow($sql2);  
        
             if ($data2['delegate_user'] == $user) {
                $replace = 'delegate'; 
             }
             else{
                      
            $replace = str_replace('&', '',str_replace(',', ' ',str_replace(' ','',$value['course_dental_category'])));

             }
            

            $module = $dbF->getRow("SELECT COUNT(*) FROM `subjects` WHERE `under`='$value[subject_id]' AND `publish`='1'");
                        if($module[0] > 0){
                            $mod = "<span>( $module[0]&nbsp;MODULES)</span>";
                        }
                        else{
                            $mod = "";
                        }
                    $title =  $value['subject_title'].$mod;
               
                   echo '<div class="col-sm-6 col-lg-3 '.$replace.' ">
                                 <div class="cpd-courses-box">
                                     <img alt="" src="'.$value['image'].'" />
                                     <a href="course?id='.$value['subject_id'].'">
                                        '.$title.'
                                     </a>
                                 </div>
                               </div>';
                 
        
        }


 
    //Delegate User 
 // echo   $delegateUser = $dbF->getRow("SELECT 'acc_id' FROM `accounts_user` WHERE acc_type = '1' AND`acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under' OR acc_id = '$user') AND acc_type='1'");

            
                

      // $sql  = "SELECT * FROM `subjects` JOIN `delegate_cpd_course` ON `delegate_subject_id` = `subject_id` GROUP BY delegate_user";
      //               $data = $dbF->getRows($sql);

       
       
      //   foreach ($data as $key => $value) {
      //         $module = $dbF->getRow("SELECT COUNT(*) FROM `subjects` WHERE `under`='$value[subject_id]' AND `publish`='1'");
      //                   if($module[0] > 0){
      //                       $mod = "<span>( $module[0]&nbsp;MODULES)</span>";
      //                   }
      //                   else{
      //                       $mod = "";
      //                   }
      //             $title =  $value['subject_title'].$mod;
      //             $replace = str_replace('&', '',str_replace(' ', '',$value['course_dental_category']));
      //   echo '  
      //   <div class="col-sm-6 col-lg-4 delegate ">
      //                            <div class="cpd-courses-box">
      //                                <img alt="" src="'.$value['image'].'" />
      //                                <a href="course?id="'.$value['subject_id'].'">
      //                                   "'.$title.'"
      //                                </a>
      //                            </div>
      //                          </div>';
      //  }
         

          
     

          ?>
                    



                </div>
            <!-- grid -->

            </div>
            <!-- cpd-courses -->
        </div>
        <!-- right_side close -->
    </div>
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
                    url: 'ajax_call.php?page=deleteCertificate',   
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
    <?php include_once('footer.php'); ?>
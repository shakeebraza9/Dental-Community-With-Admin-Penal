<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
$msg='';
$msg = $functions->CpdInsertDocument();
// include_once('header.php'); 

include'dashboardheader.php'; ?>
<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        
        <!-- left_side close -->
        <div class="right_side hrm">
            <div class="right_side_top">
                <div class="change-session">
                    <?php
                    //$functions->changeSession();
                    ?>
                </div>
                <!-- change-session -->
            </div>
            <!-- right_side_top close -->
           <div class="cpd-table cpd-table-1">
                <div class="p-heading"><h3>Attempt CE</h3></div>
                <div class="cpd-tbl">
                        <?php
                            if($_SESSION['currentUserType'] == 'Employee'){
                             $user = $_SESSION['superid'];
                        }
                        else{
                            $user = $_SESSION['currentUser'];
                       
                        }
                        $sql = "SELECT * FROM `assigned_paper` JOIN `paper` ON `paper`.`paper_id` = `assigned_paper`.`assign_paper` WHERE `status`='1' AND `assign_user`='$user' ORDER BY `completion_date` DESC";
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
                            //printResult.php?assignid=$assignid
                              $thisid =  '"'.$value['assign_id'].'"';
                           $certificate_title = '"'.$title.'"';
                           $certificate_title = str_replace(' ', '::',$certificate_title);
                           $certificate_user = '"'.$value['assign_user'].'"';
                           $certificate_expiry_date = '"'.date("Y-m-d",strtotime($value['expiry_date'])).'"'; 
                    $certificate_completion_date = '"'.date("Y-m-d",strtotime($value['completion_date'])).'"'; 
                    
            if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0'){
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

                      echo "<div class='single_course'>
                        <p>$title</p>
                        <div class='ttip2' data-toggle='tooltip' title='Update Date: $c_date'>$c_date</div>
                        <div class='cpd-stars'>";
                            $x = 1;
                            for ($i=0; $i < @$value['star']; $i++) { 
                               echo "<i class='fas fa-star'></i>";
                            }
                        echo "</div>
                        <span class='$status'><i class='fas fa-circle-check p-1'></i>$result</span>";
                        if ($result == 'Expired' || $status == 'expired'){
                            echo "<div class='courses_btn'>
                                <a class='anim anim2 ' data-toggle='tooltip' title='Click To Print' $display href='printResult.php?assignid=$assignid' target='_blank'><i class='fas fa-print'></i> </a>
                                <a class='anim anim2 ' data-toggle='tooltip' title='Click To Download' $display href='downloadResult.php?assignid=$assignid' target='_blank'><i class='fas fa-download' target='_blank'></i></a>
                                <a href='javascript:;' data-id='$value[assign_id]'  onclick='AjaxDelScript(this);'  $faileddisplay style='display:none' class='delete'>Delete</a>
                            </div>
                        </div>";
                        }else{
                            echo "<div class='courses_btn'>
                            <a class='anim anim2 ' data-toggle='tooltip' title='Click To Print' $display href='printResult.php?assignid=$assignid' target='_blank'><i class='fas fa-print'></i> </a>
                            <a class='anim anim2 ' data-toggle='tooltip' title='Click To Download' $display href='downloadResult.php?assignid=$assignid' target='_blank'><i class='fas fa-download' target='_blank'></i></a>
                            <!--<a class='anim anim2 tooltips' data-toggle='tooltip' title='Your Certificate Uploaded' href='javascript:;'><i class='fa fa-address-card'></i></a>-->
                            $hide
                            <a href='javascript:;' data-id='$value[assign_id]'  onclick='AjaxDelScript(this);'  $faileddisplay style='display:none' class='delete'>Delete</a>
                                </div>
                            </div>";
                        }
                        }
                        ?>
                         <script>
        function myFunction() {
  alert("Sorry, the CPD certificates are currently under maintenance work. Please try back later Sorry for the inconvenience !");
}
          
       </script>
                        <!-- </tbody>
                    </table> -->
                </div>
                <!-- cpd-tbl -->
            </div>
            <!-- cpd-table -->
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
<?php include_once('dashboardfooter.php'); ?>
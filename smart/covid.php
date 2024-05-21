<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php'); 

$functions->pin();

include'dashboardheader.php';

$display = "";
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrreports'] == '0'){
    $display = 'style="display:none;"';
}
                            $user = $_SESSION['currentUser'];
                            $sql1 = "SELECT * FROM `accounts_user` WHERE `acc_id` ='$user'";
                            $data1 = $dbF->getRow($sql1);
 


?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            COVID Screening
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'resources'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        
        <div class="right_side">







<?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0'){ ?>
             

                      <div class="form-group">
                <label></label>

                  <div class="covidshowbtn">
                          <div class="switch-field">
     
                 </div>
                 </div>
                 </div>

                   
                    <?php }else{ ?>
                         <div class="form-group">
                <label>Covid-19 Question Screen</label>

                  <div class="covidshowbtn">
                          <div class="switch-field">
        <input type="radio" id="radio-one" name="covidshow" value="1" <?php  if($data1['covid']=="1" )echo "checked" ; ?>  />
        <label for="radio-one">Enable</label>
        <input type="radio" id="radio-two" name="covidshow" value="0" <?php  if($data1['covid']=="0" )echo "checked" ; ?>   />
        <label for="radio-two">Disable</label>
    </div>
 
                        </div>
 </div>

                  <?php  } ?>
            <div class="cpd-table">
                <div class="cpd-tbl datable">
                    <table>
                        <thead>
                            <tr>
                                <th <?php echo $display?>>Employee</th>
                                <th>Date</th>
                                <th>Positive for COVID-19</th>
                                <th>Waiting for COVID-19 test</th>
                                <th>Any symptoms</th>
                                <th>Live with someone</th>
                                <th>Contact of a person</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $user = $_SESSION['currentUser'];
                           $sql = "SELECT * FROM `covid` WHERE `user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1')";
                           $data = $dbF->getRows($sql);
                            foreach ($data as $key => $value) {
                            $date = date('d-M-Y',strtotime($value['date']));
                            echo "<tr>
                                    <td $display>".$functions->UserName($value['user'])."</td>
                                    <td>$date</td>
                                    <td>$value[q1] - $value[q1c]</td>
                                    <td>$value[q2] - $value[q2c]</td>
                                    <td>$value[q3] - $value[q3c]</td>
                                    <td>$value[q4] - $value[q4c]</td>
                                    <td>$value[q5] - $value[q5c]</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- cpd-tbl -->
            </div>
            <!-- cpd-table -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->

<script src="<?php echo WEB_ADMIN_URL; ?>/assets/data_table_bs/jquery.dataTables.1.10.2.js"></script>
<script>
    $('.datable table').DataTable();




 $('input[type=radio][name="covidshow"]').change(function() {
                                         var value =  $(this).val();
                                      console.log(value);
     // $("#action1").change(function(){

           // var value = $(this).val();
           // console.log(value);
          // var url = $(this).attr("url"); 

             $.ajax({
                type: 'POST',
                url: 'ajax_call.php?page=covid',
                data:"value="+value,  
            }).done(function(data){
               console.log(data);
                 
                   
                   // if (data != '111') 
                   // {
                        //$('#selectCheckinForget').html(data);
                   // var selectval =  $('#selectCheckOutForget').val();
                   // console.log(selectval);
                   // }
                  
                });

           // $.ajax({
           //     type: "POST",
           //     url: url,
           //     data: "value="+value,        //POST variable name value
           //     success: function(msg){

           //          if(msg =='success'){
           //              alert('Success');
           //          } 
           //          else{
           //              alert('Fail');
           //          }
           //     }
           // }); 
     }); 




          



</script>
<?php include_once('footer.php'); ?>
<?php 
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php');

$functions->pin();

$msg = "";
$chk1 = $functions->newDailyAdd();
if($chk1){
     if (isset($_POST['Publish'])) {
         
       $msg = "Rota Publish  Successfully ";
      
      }
      if(isset($_POST['submit'])) {
         
       $msg = "Rota  Save  Successfully";
       } 
       if (isset($_POST['amend'])) {
          
       $msg = "Rota  Amend  Successfully ";
       }
}

$chk3 = $functions->MonthlyAdd();
if($chk3){
     if (isset($_POST['Publish'])) {
         
       $msg = "Rota Publish  Successfully ";
      
      }
      if(isset($_POST['submit'])) {
         
       $msg = "Rota  Save  Successfully";
       } 
       if (isset($_POST['amend'])) {
          
       $msg = "Rota  Amend  Successfully";
       }
}

$chk2 = $functions->massRota();  
if($chk2){
    $msg = "Weekly Rota Add Successfully";
}  
include'dashboardheader.php'; ?>
<script>
$( function() {
    $( document ).tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
  } );
  </script>
  <style>
   .arrow:after {
    background: white;
    border: 2px solid white;
  }

  .arrow {
    width: 70px;
    height: 16px;
    overflow: hidden;
    position: absolute;
    left: 50%;
    margin-left: -35px;
    bottom: -16px;
  }
  .arrow.top {
    top: -16px;
    bottom: auto;
  }
  .arrow.left {
    left: 20%;
  }
  .arrow:after {
    content: "";
    position: absolute;
    left: 20px;
    top: -20px;
    width: 25px;
    height: 25px;
    box-shadow: 6px 5px 9px -9px black;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
  .arrow.top:after {
    bottom: -20px;
    top: auto;
  }
  </style>
<div class="index_content health_form">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            Rota Management
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'hrm'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div class="right_side_top">
                <div class="change-session">
                <?php
                    $functions->changeSession();




  if($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'full' || @$_SESSION['superUser']['hrrota'] == 'edit'){
                  ?>
      <div class="deleteRota col1_btn_practices">
            <a href="<?php echo WEB_URL."/deleteRota" ?>">Delete Rota</a>
                    </div>

<?php    
}
else{
?>

              


<?php
}
?>






                   
                    <div class="surgeriesview col1_btn_practices" >
            <a href="<?php echo WEB_URL."/surgeriesview" ?>">Surgeries view</a>
                    </div>    
            
                    <div class="monthlyrota col1_btn_practices" style="display: none;">
            <a href="<?php echo WEB_URL."/monthlyrota" ?>">Monthly Rota</a>
                    </div>
                </div>
                <!-- change-session -->
                
            </div>
            <!-- right_side_top close -->
            <?php if($msg !=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>

            <!--  <div class="col-sm-12 alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               Our rota management is currently under maintenance, we are adding some new features and updating the current features. Sorry for the inconvenience caused.
            </div> -->
         <?php
             @$_GET['rotamonthlysubmit'];
             @$_GET['rotaweeklysubmit'];
            $activeweekly = '';
            $activemonthly = '';
           
          if (@$_GET['rotamonthlysubmit'] == "Create Monthly Rota") {
               $activemonthly = 'active';

            }
          
          if (@$_GET['rotaweeklysubmit'] == "Create Weekly Rota") {
               $activeweekly = 'active';

            }
           

            ?>
            <div class="profile rota">
                <?php if($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'read' || @$_SESSION['superUser']['hrrota'] == 'edit' || @$_SESSION['superUser']['hrrota'] == 'full'){ ?>

             <div id="tabs">
                        <ul>
                              
                            <li class="tabWeekly"><a  href="#tabs-1">Weekly</a></li>
                            <li class="tabMonthly "><a  href="#tabs-2">Monthly</a></li>
                           
                        </ul>   
                           <div id="tabs-1">
                       
                         <?php


  if($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'full' || @$_SESSION['superUser']['hrrota'] == 'edit'){
                  ?>


                   <form action="rota" method="get" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>Create Weekly Rota of</label>
                            <input class="wrdatepicker" type="text" name="date2" value="<?php echo @$_GET['date2'] ?>" autocomplete="off" readonly>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Copy From Week</label>
                            <input class="wrdatepicker" type="text" name="date" value="<?php if(empty(@$_GET['date'])) echo @$_GET['date2']; else echo @$_GET['date']; ?>" autocomplete="off" >
                           <!--readonly-->
                        </div>
                        <div class="form-group col-12" style="display: inherit;">
                            <?php
                            if($_SESSION['userType']=='Trial')
                              {
                                 echo'<input style="margin-top: 0" type="button" onclick="alertbx()" class="submit_class" value="Create Rota" name="">';
                              }else{ ?>
                            <input style="margin-top: 0; margin-right: 60px;" type="submit" class="submit_class" value="Create Rota" name="submit">
                            <?php //if(isset($_GET['date2'])){ ?>
                            <!--<label class="ccheckbox">-->
                                <!--<input class="checkuser" id="checkuser" type="checkbox" value="dentist" name="role" onclick="hidenUserTr()">-->
                                <!--<span class="cmark"></span>Tick to hide all dentist-->
                            <!--</label>-->
                          <?php //} ?>
                            <?php }?>
                        </div>
                    </div>
                </form>
                <form method='post'>
                    <?php echo $functions->setFormToken("massRotaWeekly");
                    if($_SESSION['userType']=='Trial')
                              {
                                 echo'<div class="col-12"><input style="margin-top: 0" onclick="alertbx()" type="button" class="submit_class" name="" value="Use Template Weekly"></div>';
                              }else{
?>
                    
                    <div class="col-12" style="display: flex;">
                        <input style="margin-top: 0; margin-right: 60px;" onclick="return confirm('This will Create an automated rota for a week. Are you sure You want to Proceed. ');" type='submit' class="submit_class" name='submit' value='Use Template Weekly'>
                    <?php //if(isset($_GET['date2'])){ ?>
                        <!--<label class="ccheckbox">-->
                            <!--<input class="checkuser" id="checkuser2" type="checkbox" value="staff" name="role" onclick="hidenUserTr()">-->
                            <!--<span class="cmark"></span>Tick to hide other staff-->
                        <!--</label>-->
                  
                    <?php //}?>
                    </div>
                <?php }?>
                </form>
                
                   <?php if($_SESSION['userType'] !='Trial' && isset($_GET['date2'])) { ?>
                    <div style="
                            margin-left: 20px;
                        ">
                             <label class="ccheckbox">
                                <input class="checkuser hideShift" id="hideShift" type="checkbox" value="1" name="hideShift" onclick="hideSecShift()">
                                <span class="cmark"></span>Tick to hide 2nd shift
                            </label>
                            <label class="ccheckbox">
                                <input class="checkuser" id="checkuser2" type="checkbox" value="staff" name="role" onclick="hidenUserTr()">
                                <span class="cmark"></span>Tick to hide other staff
                            </label>
                            <label class="ccheckbox">
                                <input class="checkuser" id="checkuser" type="checkbox" value="dentist" name="role" onclick="hidenUserTr()">
                                <span class="cmark"></span>Tick to hide all dentist
                            </label>
                    </div>
                <?php } ?>  
                 
                <hr>

                <?php
                } ?>
                <?php

                if(isset($_GET['date'])){
                     if(empty($_GET['rotamonthlysubmit'])){
                    $functions->shiftName();
                    $functions->newDaily(true);
                    echo "<script> 
          $('#tabs-2').show();
          $('#tabs-1').hide();
          </script>";
                     }
                }

                      ?>


                </div>
                <div id="tabs-2">


                     <?php


  if($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'full' || @$_SESSION['superUser']['hrrota'] == 'edit'){
                  ?>

                <form action="rota" method="get" enctype="multipart/form-data">
                    <div class="row">
                    <div class="form-group col-12 col-md-6">
                            <label>Monthly  Rota of</label>
                            <input class="mrdatepicker" type="text" name="date2" value="<?php echo @$_GET['date2'] ?>" autocomplete="off" readonly>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Copy From Month</label>
                            <input class="mrdatepicker" type="text" name="date" value="<?php if(empty(@$_GET['date'])) echo @$_GET['date2']; else echo @$_GET['date']; ?>" autocomplete="off" readonly>
                        </div>

                        <div class="form-group col-12">
                            <?php
                            if($_SESSION['userType']=='Trial')
                              {
                                 echo'<input style="margin-top: 0" type="button" onclick="alertbx()" class="submit_class" value="Create Monthly Rota" >';
                              }else{

                            ?> 
                            <input style="margin-top: 0" type="submit" class="submit_class" value="Create Monthly Rota" name="rotamonthlysubmit">
                            <?php }?>
                        </div>
                    </div>
                    </form>
              




                <form method='post'>
                    <?php echo $functions->setFormToken("massRotaMonthly");
                    if($_SESSION['userType']=='Trial')
                              {
                                 echo'<div class="col-12"><input style="margin-top: 0" onclick="alertbx()" type="buttom" class="submit_class"  value="Use Template Weekly"></div>';
                              }else{
                    ?>
                    <div class="col-12"><input style="margin-top: 0" onclick="return confirm('This will Create an automated rota for a week. Are you sure You want to Proceed. ');" type='submit' class="submit_class" name='submit' value='Use Template Weekly'></div>
                <?php }?>
                </form>
                <hr> 
                <?php } 

echo "</div>";
echo "</div>";

              }?>
 

                <?php

                if(isset($_GET['date'])){
                    
                     if(!empty($_GET['rotamonthlysubmit'])){  
                    $functions->shiftName();
                    $functions->newMonthly(true);
                     echo "<script>$(document).ready(function(){
          $('.tabWeekly').removeClass('ui-tabs-active ui-state-active'); 
          $('.tabMonthly').addClass('ui-tabs-active ui-state-active');
          $('#tabs-2').show();
          $('#tabs-1').hide();
                         
                     }); 
    </script> ";
                
                     }
                }
                // if($_SESSION['currentUserType'] != 'Employee' ){
            // echo '</div>';
// }
                if(!isset($_GET['date'])){

                  if(!isset($_GET['date'])){


                    if(empty(@$_GET['datev'])){

                      $date=date( 'Y-m-d', strtotime( 'monday this week' ) );


                    } else{$date=@$_GET['datev'];}
                 echo "<h2 class='h2Heading'>Published Rota</h2>";
                        // echo"
                        // <div class='m_next_pre_'>   
                        //     <a class='submit_class rota-btn' href='rota?datev=".date('d-M-Y',strtotime('-7 day '.$date))."&rotaweeklysubmit=Create+Weekly+Rota'>Prev</a>
                        //     <a class='submit_class rota-btn' href='rota?datev=".date('d-M-Y',strtotime('+7 day '.$date))."&rotaweeklysubmit=Create+Weekly+Rota'>Next</a>
                        // </div>";
                echo"
                    <div class='m_next_pre'>   
                        <a class='submit_class rota-btn' href='rota?datev=".date('d-M-Y',strtotime('-7 day '.$date))."'><i class='fas fa-arrow-circle-left'></i></a>
                        <a class='submit_class rota-btn' href='rota?datev=".date('d-M-Y',strtotime('+7 day '.$date))."'><i class='fas fa-arrow-circle-right'></i></a></div>
   
                        <div class='m_ammend_srch_reset_rota_'>
                            <a class='submit_class filter-rota' href='rota-reports'>Search Rota</a>";
                        if($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'full' || @$_SESSION['superUser']['hrrota'] == 'edit'){
                            if($_SESSION['userType']=='Trial')
                              {
                                 echo "<a class='submit_class filter-rota' onclick='alertbx()' href=''>Amend Rota</a>
                            <a class='submit_class filter-rota' onclick='alertbx()' href=''>Reset Rota</a>";
                              }else{
                   
                            echo "<a class='submit_class filter-rota' href='rota?date2=".date('d-M-Y',strtotime($date))."&date=".date('d-M-Y',strtotime($date))."&rotaweeklysubmit=Create+Weekly+Rota'>Amend Rota</a>
                            <a class='submit_class filter-rota' href='rota?date2=".date('d-M-Y',strtotime($date))."&date=".date('d-M-Y',strtotime($date))."&type=reset'>Reset Rota</a>";    
                        
                              }
                              }
                        
                        echo "</div>";
                      echo "<div class='m_ammend_srch_reset_rota'>
                      <a class='submit_class filter-rota' href='rota-reports'><i class='fas fa-search'></i></a>";
                     if($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'full' || @$_SESSION['superUser']['hrrota'] == 'edit'){
                            echo "<a class='submit_class filter-rota' href='rota?date2=".date('d-M-Y',strtotime($date))."&date=".date('d-M-Y',strtotime($date))."'><i class='fas fa-edit'></i></a>
                            <a class='submit_class filter-rota' href='rota?date2=".date('d-M-Y',strtotime($date))."&date=".date('d-M-Y',strtotime($date))."&type=reset'><i class='fas fa-history'></i></a>";    
                        }

                        echo "</div>";
                        echo "<div class='m_next_pre_'> 
                            <div class='m_next_pre_inner' style='display: flex;align-items: baseline;'>  
                            <a class='submit_class rota-btn' href='rota?datev=".date('d-M-Y',strtotime('-7 day '.$date))."&rotaweeklysubmit=Create+Weekly+Rota' style='padding: 0px 25px;width: 12%;'>Prev</a>
                            
                            <input class='wrdatepicker rotaSearch' type='text' name='date2'  autocomplete='off' readonly style='width: 20%;' placeholder='Search' value='".@$_GET['datev']."'>
                            <i class='fa fa-calendar' aria-hidden='true' style='position: relative;right: 21px;'></i>
                            <a class='submit_class rota-btn' href='rota?datev=".date('d-M-Y',strtotime('+7 day '.$date))."&rotaweeklysubmit=Create+Weekly+Rota' style='padding: 0px 25px; margin-left: -7px;width:12%;'>Next</a>
                            </div>
                            </div>";
                echo     $functions->WeeklyWagesResult();
                         
                }
            }
                ?>

                
               </div>

<!-- Tabs End -->
            </div>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <script>
    $('.rotaSearch').on('change', function() {
        var value = $(this).val();
        window.location.replace("<?php echo WEB_URL; ?>/rota?datev="+value+"&rotaweeklysubmit=Create+Weekly+Rota");
    });
    $(document).ready(function(){
      

        $(".wrdatepicker").datepicker({ beforeShowDay:function(dt){
           return [dt.getDay() == 1 ? true : false];
        },
        dateFormat: 'd-M-yy',firstDay: 1, });

   
        $(".mrdatepicker").datepicker({ beforeShowDay:function(dt){
           return [dt.getDate() == 1 ? true : false];
        },
        dateFormat: 'd-M-yy',firstDay: 1, });


     });

    $('.shtd').on('click', function() {
        var val = $(this).find('input').val();
        val = (val == "1") ? "0" : "1";
        $(this).find('input').val(val);
        $(this).find('i').toggleClass('fa-eye-slash');
        $(this).parent('th').find('span').toggleClass('mt');
        $(this).parents('tr').find('.row').toggle('fast');
    });

    $('.ettd').on('click', function() {
        $(this).find('input').val('1');
        $(this).parents('tr').find('td').css({'cursor':'unset','opacity':'1'});
        $(this).parents('tr').find('td').removeClass('nodrop');
        $(this).parents('tr').find('.insertTimeTable').css({'pointer-events':'auto'});
    });

    $('.checkHours').on('click', function(e) {
        $('table tbody tr').each(function(i){
            var val = null;
            var whours = $(this).find('.whours').text();
            var name = $(this).find('th span').text();
            if(name == ''){
                return true;
            }
            whours = whours.replace(/[^0-9]/g,'');
            $(this).find('.rslt').each(function() {
                val += parseInt($(this).val());
            });
            // if(whours == ''){
            //     alert("Please insert hours of "+name);
            //     e.preventDefault(e);
            //     // return false;
            // }
            // else{
            //     if(whours > val){
            //         alert("Hours less of "+name);
            //         e.preventDefault(e);
            //         // return false;
            //     }
            // }
        });
    });
    

    function deleteShift(id){
        var result = confirm("Are you sure you want to delete?");
        if (result) {
            $.ajax({
                    type: 'post',
                    data: {id:id},
                    url: 'ajax_call.php?page=deleteShift',                
                }).done(function(data) {
                    if (data == '1') {
                        $('#'+id).parent('li').hide('slow');
                    }
            });
        }
    } 
    
    // drag
    $(document).ready(function() {

        // $('.rota-table table').on('mouseover', 'td', function(e) { 
        //     $('.rota-table table th').css({ "background-color": "transparent"}); 
        //     var day = e.delegateTarget.tHead.rows[0].cells[this.cellIndex],
        //         sno  = this.parentNode.cells[0];
        //     $(sno).css({ "background-color": "#e5f3f2"});
        //     $(day).css({ "background-color": "#e5f3f2"});
        //     $(sno).next('th').css({ "background-color": "#e5f3f2"});
        // });

        $('.fa-user.dentist_id').click(function() {
            $(this).parents('.insertTimeTable').find('select.dentist_id').slideToggle('slow');
        }); 
     $('.fa-bed.allsurgeries').click(function() {
            $(this).parents('.insertTimeTable').find('select.allsurgeries').slideToggle('slow');
        });

        $('.fa-comment-alt.commentsh').click(function() {
            $(this).parents('.insertTimeTable').find('input.commentsh').slideToggle('slow');
        });
          
           $('.fa-clock.cheksinout').click(function() {
            $(this).parents('.insertTimeTable').find('input.cheksinout').slideToggle('slow');
        });

        $('li').mouseover(function() {
            $(this).css('cursor', 'pointer');
        });

        $("#draggable li").draggable({ helper: 'clone' });
        $(".time").droppable({
            accept: "#draggable li",
            drop: function(ev, ui) {
                if($(this).hasClass('nodrop')){
                    return false;
                }
                $(this).find('.time_from,.time_to,.break').val('');
                var tf  = ui.draggable.find('.tf').val();
                var tt  = ui.draggable.find('.tt').val();
                var bk  = ui.draggable.find('.bk').val();
                var dn  = ui.draggable.find('.dn').val();
                var cr  = ui.draggable.find('.cr').val();
                var dyo = ui.draggable.find('.dyo').val();
                var ho  = ui.draggable.find('.ho').val();
                var sk  = ui.draggable.find('.sk').val();   
                var rf  = ui.draggable.find('.rf').val();
                var sn  = ui.draggable.find('.sn').val();
                var rotaOff =  $(this).find('.is-not-working').val();
                console.log(rotaOff);

                if(dyo){
                    $(this).find('.rota-off').show().text('Day Off');
                    $(this).find('.rota-off-val').val('Day Off');
                    $(this).find('.time_from_div').hide();
                    $(this).find('.time_to_div').hide();
                    $(this).find('.bDiv').hide();
                    $(this).find('.rDiv').css({'display':'block','max-width':'100%','flex':'auto'});
                     $(this).find('.rDiv .spanStyle').show();
                      $(this).find('.rDiv').find('input').val('0');
                    $(this).find('.spanStyle').hide();
                    $(this).find('.rDiv .spanStyle').hide();
                    $(this).css('border-color', '#e5f3f2');
                    $(this).find('.sn_').val('');
                    $(this).find('.backcolor').val('');
                    $(this).find('.sn_').hide();
                    
                }                
                else if(ho){
                    $(this).find('.rota-off').show().text('Holiday');
                    $(this).find('.rota-off-val').val('Holiday');
                    $(this).find('.time_from_div').hide();
                    $(this).find('.time_to_div').hide();
                    $(this).find('.bDiv').hide();
                    $(this).find('.rDiv').css({'display':'block','max-width':'100%','flex':'auto'});
                     $(this).find('.rDiv .spanStyle').hide();
                      $(this).find('.rDiv').find('input').val('0');
                    $(this).find('.spanStyle').hide();
                    $(this).css('border-color', '#e5f3f2');
                    $(this).find('.sn_').val('');
                    $(this).find('.backcolor').val('');
                    $(this).find('.sn_').hide();
                }
                else if(sk){
                    $(this).find('.rota-off').show().text('Sick');
                    $(this).find('.rota-off-val').val('Sick');
                    $(this).find('.time_from_div').hide();
                    $(this).find('.time_to_div').hide();
                    $(this).find('.bDiv').hide();
                     $(this).find('.rDiv').css({'display':'block','max-width':'100%','flex':'auto'});
                       $(this).find('.rDiv').find('input').val('0');
                       $(this).find('.rDiv .spanStyle').hide();
                    $(this).find('.spanStyle').hide();
                    $(this).css('border-color', '#e5f3f2');
                    $(this).find('.sn_').val('');
                    $(this).find('.backcolor').val('');
                    $(this).find('.sn_').hide();
                } 
                else if(rf){

                    if(rotaOff.includes('Staff Not Working')){
                    
                    $(this).find('.rota-off').show().html(rotaOff);
                    $(this).find('.rota-off-val').val(rotaOff);
                    $(this).find('.time_from_div').hide();
                    $(this).find('.time_to_div').hide();
                    $(this).find('.bDiv').hide();
                     $(this).find('.rDiv').hide();
                       $(this).find('.rDiv .spanStyle').hide();
                    $(this).find('.spanStyle').hide();
                    $(this).css('border-color', '#e5f3f2');
                    $(this).find('.sn_').val('');
                    $(this).find('.backcolor').val('');
                    $(this).find('.sn_').hide();
                    $(this).find('._sn').hide();
                    $(this).find('.rslt').hide();
                }

                    else{
                      $(this).find('.rDiv').removeAttr('style');
                    $(this).find('.rota-off').hide();
                    $(this).find('.rota-off-val').val('Reset');
                    $(this).find('.rDiv .spanStyle').show();
                    $(this).find('.sn_').show();
                    $(this).find('.bDiv').show();
                    $(this).find('.rDiv').show();
                    $(this).find('.rDiv').find('input').val('0');
                    $(this).find('.spanStyle').show();
                    $(this).find('.time_from,.time_to,.break').val('');
                  $(this).find('.time_from_div').show();
                    $(this).find('.time_to_div').show();
                  $(this).find('.time_from').val('00:00');
                    $(this).find('.time_to').val('00:00');
                    $(this).find('.break').val('00:00');
                    $(this).find('.dentist_id').val('');
                  $(this).css('border-color', '#fff');
                   $(this).find('.backcolor').val('white').change();
                   $(this).find('.backcolor').val('');
                   $(this).find('.sn_').val('');
               }
             

                }

                else{
                    $(this).find('.rDiv').removeAttr('style');
                    $(this).find('.rota-off').hide();
                    $(this).find('.rota-off-val').val('');
                   
                    $(this).find('.time_from_div').show();
                    $(this).find('.time_to_div').show();
                    $(this).find('.bDiv').show();
                    $(this).find('.rDiv').show();
                    $(this).find('.spanStyle').show();
                    $(this).find('.time_from').insertAtCaret(tf);
                    $(this).find('.time_to').insertAtCaret(tt);
                    $(this).find('.break').insertAtCaret(bk);
                    $(this).find('.dentist_id').val(dn).change();
                    $(this).find('.backcolor').val(cr).change();
                    $(this).find('.sn_').val(sn).change();
                    $(this).find('._sn').val(sn).change();
                    $(this).find('._sn').show();
                    $(this).css('border-color', cr);
                    // calc
                    var dateStart1 = new Date("10/13/2016 " + tf);
                    hourStart1 = dateStart1.getHours();
                    minStart1 = dateStart1.getMinutes();
                    var dateEnd1 = new Date("10/13/2016 " + tt);
                  
                    hourEnd1 = dateEnd1.getHours();
                     if (hourEnd1 == 0 && time_to != '00:00') {
                        
                     hourEnd1 = 24;}
                   
                    if (tt == '00:00' || tf == '00:00' ) 
                    {
                        
                    var time_to = $(this).parent('div').next('div').find('input').val();
                      //$(this).find('.rDiv').hide();
                        hourEnd1 = '0' ;
                         

                      }


                   
                    
                    minEnd1 = dateEnd1.getMinutes();
                    var hours1 = hourEnd1 - hourStart1;
                    var mins1 = minEnd1 - minStart1;
                    var mins_h1 = mins1 / 60;
                    var result1 = hours1 + mins_h1;

                    var dateStart = new Date("10/13/2016 " + tf);
                    hourStart = dateStart.getHours();
                    minStart = dateStart.getMinutes();
                    var dateEnd = new Date("10/13/2016 " + tt);
                    hourEnd = dateEnd.getHours();
                    // 0 means, hour was 24 entered
                    if (hourEnd == 0 && $(this).val() != '00:00') {
                        hourEnd = 24;
                    }
                    minEnd = dateEnd.getMinutes();
                    var bdateStart = new Date("10/13/2016 " + bk);
                    bhourStart = bdateStart.getHours();
                    bminStart = bdateStart.getMinutes();
                    var hours = (hourEnd - hourStart) - bhourStart;
                    var mins = (minEnd - minStart) - bminStart;
                    if ((hourStart < 0 || hourStart > 24)) {
                        alert("Please enter hours between 0 and 24 only.");
                        return false;
                    };
                    check_number(minEnd, this);
                    // if ((minEnd != 0 && minEnd != 15) || (minStart != 0 && minStart != 15)) {
                    //     alert("Please enter 0 minutes or 15 minutes only.");
                    //     $(this).val('00:00');
                    //     $(this).parent('div').prev('div').find('input').val('00:00');
                    //     $(this).parent('div').prev('div').prev('div').find('input').val('00:00');
                    //     $(this).parent('div').next('div').find('input').val('0');
                    //     return false;
                    // };
                    // convert mins to hours
                    var mins_h = mins / 60;
                    var result = hours + mins_h;
                    if (!check_number(hours, this)) {
                        alert(hours);
                        return false;
                    }
                    $(this).find('.rslt').val((isNaN(result) ? 0 : result));
                    // calc
                }
            }
        });
  

        $.fn.insertAtCaret = function(myValue) {
            return this.each(function() {
                if (document.selection) {
                    this.focus();
                    sel = document.selection.createRange();
                    sel.text = myValue;
                    this.focus();
                } else if (this.selectionStart || this.selectionStart == '0') {
                    var startPos = this.selectionStart;
                    var endPos = this.selectionEnd;
                    var scrollTop = this.scrollTop;
                    this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this.value.length);
                    this.focus();
                    this.selectionStart = startPos + myValue.length;
                    this.selectionEnd = startPos + myValue.length;
                    this.scrollTop = scrollTop;
                } else {
                    this.value += myValue;
                    this.focus();
                }
            });
        };
    });
    // drag


    // function Refresh() 
    // {
        
    //              var tf  = $('.tf').val('');
    //             var tt  = $('.tt').val('');
    //             var bk  = $('.bk').val('');
    //             var dn  = $('.dn').val('');
    //             var cr  = $('.cr').val('');
    //             var dyo = $('.dyo').val('');
    //             var ho  = $('.ho').val('');
    //             var sk  = $('.sk').val('');
    //             var rf  = $('.rf').val('');
                  
    //                 $(this).find('.rDiv').val('');
    //                 $(this).find('.rota-off').hide();
    //                 $(this).find('.rota-off-val').val('');
                   
    //                 $(this).find('.time_from_div').show();
    //                 $(this).find('.time_to_div').show();
    //                 $(this).find('.bDiv').show();
    //                 $(this).find('.rDiv').show();
    //                 $(this).find('.spanStyle').show();
    //                 $(this).find('.time_from').insertAtCaret(tf);
    //                 $(this).find('.time_to').insertAtCaret(tt);
    //                 $(this).find('.break').insertAtCaret(bk);
    //                 $(this).find('.dentist_id').val(dn).change();
    //                 $(this).css('background-color', cr);

    // }
    
    function calc_time_diff() {
        $('.rota').on('change', '.time_to', function(event) {
            event.preventDefault();
            /* Act on the event */
            console.log("Changed!");
            console.log("$(this).val() " + $(this).val());
            var input_before_val = $(this).parent('div').prev('div').find('input').val();
            // date can be any, we just want to work with the time
            var dateStart = new Date("10/13/2016 " + input_before_val);
            hourStart = dateStart.getHours();
            minStart = dateStart.getMinutes();
            var dateEnd = new Date("10/13/2016 " + $(this).val());
            hourEnd = dateEnd.getHours();
            // 0 means, hour was 24 entered
            if (hourEnd == 0 && $(this).val() != '00:00') {
                hourEnd = 24;
            }
            minEnd = dateEnd.getMinutes();
            console.log("minStart: " + minStart);
            console.log("minEnd: " + minEnd);
            var hours = hourEnd - hourStart;
            var mins = minEnd - minStart;
            console.log("hourEnd: " + hourEnd);
            console.log("hourStart: " + hourStart);
            console.log("minStart != 0: " + minStart != 0);
            console.log("minEnd != 30: " + minEnd != 30);
            // console.log( minEnd != 0 && minEnd != 30 );
            var input_break_val = $(this).parent('div').next('div').next('div').next('div').find('input').val();
            // date can be any, we just want to work with the time
            var bdateStart = new Date("10/13/2016 " + input_break_val);
            bhourStart = bdateStart.getHours();
            bminStart = bdateStart.getMinutes();
            console.log("BreAKhour: " + bhourStart);
            console.log("BreAKMIN: " + bminStart);
            var hours = hourEnd - hourStart - bhourStart;
            var mins = minEnd - minStart - bminStart;
            console.log("hourEnd: " + hourEnd);
            console.log("hourStart: " + hourStart);
            console.log("minStart != 0: " + minStart != 0);
            console.log("minEnd != 30: " + minEnd != 30);
            // console.log( minEnd != 0 && minEnd != 30 );
            if ((hourStart < 0 || hourStart > 24)) {
                // if ( (hourStart >= 0 || hourStart <= 24) && (hourEnd >= 0 || hourEnd <= 24)  ) {
                alert("Please enter hours between 0 and 24 only.");
                // $(this).val('00:00');
                // $(this).parent('div').prev('div').find('input').val('00:00');
                // $(this).parent('div').next('div').find('input').val('0');
                return false;
            };
            check_number(minEnd, this);
            // if ((minEnd != 0 && minEnd != 30)) {
            //     alert("Please enter 0 minutes or 30 minutes only.");
            //     $(this).val('00:00');
            //     $(this).parent('div').prev('div').find('input').val('00:00');
            //     $(this).parent('div').next('div').next('div').find('input').val('0');
            //     return false;
            // };
            // convert mins to hours
            var mins_h = mins / 60;
            // for two decimal places, we multiply by 100, for three multiply by 1000 and so on.
            // mins_h     = Math.round(mins_h * 100);
            // combine hours, mins
            var result = hours + mins_h;
            if (!check_number(hours, this)) {
                // $(this).val('00:00');
                // $(this).parent('div').prev('div').find('input').val('00:00');
                // $(this).parent('div').next('div').find('input').val('0');
                alert(hours);
                return false;
            }
            // if hrs greater then 6 minus 30 mins;
            // if(result > 6){
            // var result= result - .5;
            // }
            // if hrs greater then 6 minus 30 mins;
            // var result = result - dateCat;
            //  var result = "21";
            $(this).parent('div').next('div').next('div').next('div').next('div').find('input').val((isNaN(result) ? 0 : result));
            console.log("Result: " + result);
        });

        $('.rota').on('change', '.break', function(event) {
            event.preventDefault();
            var input_before_val = $(this).parent('div').prev('div').prev('div').prev('div').prev('div').find('input').val();
            // date can be any, we just want to work with the time
            var dateStart = new Date("10/13/2016 " + input_before_val);
            hourStart = dateStart.getHours();
            minStart = dateStart.getMinutes();
            var dateEnd = new Date("10/13/2016 " + $(this).parent('div').prev('div').prev('div').prev('div').find('input').val());
            console.log(dateEnd);
            hourEnd = dateEnd.getHours();
            // 0 means, hour was 24 entered
            if (hourEnd == 0 && $(this).val() != '00:00') {
                hourEnd = 24;
            }
            minEnd = dateEnd.getMinutes();
            var input_break_val = $(this).val();
            // date can be any, we just want to work with the time
            var bdateStart = new Date("10/13/2016 " + input_break_val);
            bhourStart = bdateStart.getHours();
            bminStart = bdateStart.getMinutes();
            var hours = (hourEnd - hourStart) - bhourStart;
            var mins = (minEnd - minStart) - bminStart;
            if ((hourStart < 0 || hourStart > 24)) {
                alert("Please enter hours between 0 and 24 only.");
                return false;
            };
            check_number(minEnd, this);
            // if ((minEnd != 0 && minEnd != 15) || (bminStart != 0 && bminStart != 15) || (minStart != 0 && minStart != 15)) {
            //     alert("Please enter 0 minutes or 15 minutes only.");
            //     $(this).val('00:00');
            //     $(this).parent('div').prev('div').find('input').val('00:00');
            //     $(this).parent('div').prev('div').prev('div').find('input').val('00:00');
            //     $(this).parent('div').next('div').find('input').val('0');
            //     return false;
            // };
            // convert mins to hours
            var mins_h = mins / 60;
            var result = hours + mins_h;
            if (!check_number(hours, this)) {
                alert(hours);
                return false;
            }
            $(this).parent('div').next('div').find('input').val((isNaN(result) ? 0 : result));
            console.log("Result: " + result);
        });
    }
    calc_time_diff();

    //time_to

    $('.rota').on('change', '.tableIBMS tr > td:nth-child(2) .time_from', function(event) {
        event.preventDefault();
        var time_from = $(this).val();
        var time_to = $(this).parent('div').next('div').find('input').val();
        var path = $(this).parent('div').parent('div').parent('td').parent('tr');
        var dateStart1 = new Date("10/13/2016 " + $(this).val());
        hourStart1 = dateStart1.getHours();
        minStart1 = dateStart1.getMinutes();
        var dateEnd1 = new Date("10/13/2016 " + time_to);
        hourEnd1 = dateEnd1.getHours();
        if (hourEnd1 == 0 && $(this).val() != '00:00') {
            hourEnd1 = 24;
        }
        minEnd1 = dateEnd1.getMinutes();
        var hours1 = hourEnd1 - hourStart1;
        var mins1 = minEnd1 - minStart1;
        var mins_h1 = mins1 / 60;
        var result1 = hours1 + mins_h1;
        // if (result1 > 6) {
        //     var result1 = result1 - .5;
        // }
        if (minEnd1 != 0 && minEnd1 != 30 || result1 < 0) {
            $(path).each(function() {
                $(this).find('.rslt').val("0");
                $(this).find('.time_from').val("00:00");
                $(this).find('.time_to').val("00:00");
            });
        } else {
            // $(path).each(function(){
            $(this).find('.rslt').val(result1);
            $(this).find('.time_from').val(time_from);
            $(this).find('.time_to').val(time_to);
            // });
        }
    });

    $('.rota').on('change', '.tableIBMS tr > td:nth-child(2) .time_to', function(event) {
        var time_from = $(this).parent('div').prev('div').find('input').val();
        var time_to = $(this).val();
        var path = $(this).parent('div').parent('div').parent('td').parent('tr');
        var dateStart1 = new Date("10/13/2016 " + time_from);
        hourStart1 = dateStart1.getHours();
        minStart1 = dateStart1.getMinutes();
        var dateEnd1 = new Date("10/13/2016 " + $(this).val());
        hourEnd1 = dateEnd1.getHours();
        if (hourEnd1 == 0 && $(this).val() != '00:00') {
            hourEnd1 = 24;
        }
        minEnd1 = dateEnd1.getMinutes();
        var hours1 = hourEnd1 - hourStart1;
        var mins1 = minEnd1 - minStart1;
        var mins_h1 = mins1 / 60;
        var result1 = hours1 + mins_h1;
        // if (result1 > 6) {
        //     var result1 = result1 - .5;
        // }
        if (minEnd1 != 0 && minEnd1 != 30 || result1 < 0) {
            // $(path).each(function(){
            $(this).find('.time_to').next('div').find('input').val("0");
            $(this).find('.time_from').val("00:00");
            $(this).find('.time_to').val("00:00");
            //  });
        } else {
            //    $(path).each(function(){
            $(this).find('.rslt').val(result1);
            $(this).find('.time_from').val(time_from);
            $(this).find('.time_to').val(time_to);
            //   });
        }
    });

    function check_number(num, ths) {
        result = true;
        if (isNaN(num)) {
            console.log(num+" Illegal number inserted please try again.");
            // $(ths).val('00:00');
            // $(ths).parent('div').prev('div').find('input').val('00:00');
            result = false;
        } else if (num < 0) {
            alert("Hours cannot be negative, please try again.");
            // $(ths).val('00:00');
            // $(ths).parent('div').prev('div').find('input').val('00:00');
            result = false;
        };
        return result;
    }

    function validate_time_from() {
        $('.rota').on('change', '.time_from', function(event) {
            event.preventDefault();
            /* Act on the event */
            var dateStart = new Date("10/13/2016 " + $(this).val());
            hourStart = dateStart.getHours();
            minStart = dateStart.getMinutes();
            console.log("$(this).val() " + $(this).val());
            console.log("hourStart " + hourStart);
            console.log("minStart " + minStart);
            var input_break_val = $(this).parent('div').next('div').next('div').next('div').next('div').find('input').val();
            // date can be any, we just want to work with the time
            var bdateStart = new Date("10/13/2016 " + input_break_val);
            bhourStart = bdateStart.getHours();
            bminStart = bdateStart.getMinutes();
            console.log("BreAKhour:time_from " + bhourStart);
            console.log("BreAKMIN:time_from " + bminStart);

            if (!check_number(minStart, this)) {
                $(this).val('00:00');
                // time to input
               // $(this).parent('div').next('div').find('input').val('00:00');
                // hour input
               // $(this).parent('div').next('div').next('div').find('input').val('0');
                return false;
            };

            // if ((minStart != 0 && minStart != 15)) {
            //     alert("Please enter 0 minutes or 15 minutes only.");
            //     // time from input
            //     $(this).val('00:00');
            //     // time to input
            //     $(this).parent('div').next('div').find('input').val('00:00');
            //     // hour input
            //     $(this).parent('div').next('div').next('div').find('input').val('0');
            //     return false;
            // };

            // if .time_to is filled in, then calculate result
            // time to input
            time_to_target = $(this).parent('div').next('div').find('input').val();
            console.log(time_to_target);
            var dateEnd = new Date("10/13/2016 " + time_to_target);
            hourEnd = dateEnd.getHours();
            // 0 means, hour was 24 entered
            if (hourEnd == 0 && time_to_target != '00:00') {
                hourEnd = 24;
            }
            minEnd = dateEnd.getMinutes();
            hours = 0;
            var mins, mins_h, result;
            if (time_to_target != '00:00') {
                hours = hourEnd - hourStart - bhourStart;
                mins = minEnd - minStart - bminStart;
                mins_h = mins / 60;
                result = hours + mins_h;
                if (!check_number(result, this)) {
                    // $(this).val('00:00');
                    // $(this).parent('div').prev('div').find('input').val('00:00');
                    // $(this).parent('div').next('div').find('input').val('0');
                    // alert(hours);
                    // hour input
                  //  $(this).parent('div').next('div').next('div').find('input').val('0');
                    return false;
                }
                // save hours
                // hour input
                // if(result > 6){
                // var result= result - .5;
                // }
                $(this).parent('div').next('div').next('div').next('div').next('div').next('div').find('input').val(result);
            };
            console.log(hourEnd);
            console.log(minEnd);
            console.log("hours are: " + result);
        });
    }
    validate_time_from();


     var scrolling = null;
 
    function scroll_up() {
        var d = document.getElementById('rota-table');
 
        d.scrollLeft = d.scrollLeft - 50;
 
        scrolling = window.setTimeout(function() {
            scroll_up();
        }, 100);
    }
 
    function scroll_down() {
        var d = document.getElementById('rota-table');
 
        d.scrollLeft = d.scrollLeft + 50;
 
        scrolling = window.setTimeout(function() {
            scroll_down();
        }, 100);
    }
 
    function stop_scroll() {
        window.clearTimeout(scrolling);
    }
    </script>
    
    <script>
      function hidenUserTr(ths){
        // $(document).ready(function(){
        //     $('.checkuser').click(function(e) {
        //         $('.checkuser').not(this).prop('checked', false);
                
        //     });
        // });
        
        
        //   var staff=document.getElementById("checkuser");
        //   var dentist=document.getElementById("checkuser2");
            
        //   let id = "";
        //   if (staff.checked == true){
        //   id = document.getElementById("checkuser").value;
        //   }else if (dentist.checked == true){
        //   id = document.getElementById("checkuser2").value;
        //   }
        $('.rotaTr').map((item0, index0)=>{
                index0.style.display='table-row'
            });
            
          var toHide = [];
            $.each($("input[name='role']:checked"), function(){
                toHide.push($(this).val());
            });
            
            
          toHide.map((item , index)=>{
              console.log($(`.${item}`).closest('.rotaTr'), );
              $(`.${item}`).closest('.rotaTr').map((item1, index1)=>{
                  index1.style.display='none'
              })
          })
        
      }
      function hideSecShift(ths){
          let display = $('input#hideShift').is(':checked') ? 'none' : 'block'
          let rotaLength = $('.rotaTr').length;
          for(let i=1; i<=rotaLength; i++){
             let rota_double_table = $($('.rotaTr')[i]).find('.rota-double-table');
             rota_double_table.map((item, index)=>{
                 $($($(index).find('.rota-td')[1])[0]).css('display', display);
             })
          }
      }
    </script>
    <?php include_once('footer.php'); ?>
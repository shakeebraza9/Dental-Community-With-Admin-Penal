<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php');
include'dashboardheader.php';
$functions->pin();
$functions->updateTimeINOUT();

 

$display = "";

if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrreports'] == '0'){
    $display = "style='display:none'";
    $_GET['page'] = 'staff';
    $_GET['user'] = intval($_SESSION['superid']);
}
?>
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
    background: black;
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
<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        
        <div class="right_side rota">
            <div class="right_side_top">
                <div class="change-session">
                <?php
                    //$functions->changeSession();
                ?>
                </div>
                <!-- change-session -->
            </div>
            <!-- right_side_top close -->
            <!--<div class="profile rota">-->
            <div class="inner_forms">
            <form method="get">
                
                
                    <div class="form-group-flex">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-4" <?php echo $display; ?>>
                                <label for="subject" class="label3">Select Report</label>
                                <select name="page" id="company" class="form-control" required>
                                    <option value="select">--Select Reports--</option>
                                        <option value="c1">All Staff</option>
                                        <option value="c2">Staff</option>
                                        <option value="c3">Weekly</option>
                                    <!-- <option value="fullweekly">Full Weekly</option> -->
                                </select>
                                </div>
                                <?php
                                if (isset($_GET['page'])) { ?>
                                <script>$('.page').val("<?php echo @$_GET['page'] ?>").change();</script>
                                <?php } ?>
                            
                            <div class="form-group col-sm-12 col-md-4">
                                <label class="label3">From</label>
                                <input  class="datepicker form-control" type="text" name="from" placeholder="From" value="<?php echo @$_GET['from'] ?>" required autocomplete="off" readonly>
                            </div>
                            
                            <div class="form-group col-sm-12 col-md-4">
                                <label class="label3">To</label>
                                <input class="datepicker form-control" type="text" name="to" placeholder="To" value="<?php echo @$_GET['to'] ?>" required autocomplete="off" readonly>
                            </div>      
                        </div>
                    </div>
                
                <!--<div class="form-group-flex">-->
              
                <!--</div>-->
                
                <!--<div class="form-group-flex">-->
                
                <!--</div>-->
               
                
                <?php
                if(@$_GET['page'] == 'staff'){
                    if(@$_SESSION['superUser']['hrreports'] != '0'){
                        $display="";
                    } 
                }
                else { 
                    $display = "style='display:none'";
                }
                ?>
                <div class="form-group col-12 col-md-6 user" <?php echo $display ?>>
                    <label>Select User</label>
                    <select name="user" class="staff">
                        <option disabled selected>Select User</option>
                        <option value="<?php echo $_SESSION['currentUser'] ?>"><?php echo $functions->UserName($_SESSION['currentUser']) ?></option>
                        <?php echo $functions->allEmployee($_SESSION['currentUser']) ?>
                    </select>
                    <?php
                if(@$_GET['page'] == 'staff') { ?>
                    <script>$('.staff').val("<?php echo @$_GET['user'] ?>").change();</script>
                    <?php } ?>
                </div>
                <div class="footer-bottom">
                <div class="form-group">
                    <input class="submit_btn" id="signup_btn" type="submit" name="submit" value="Submit">
                </div>
                </div>
            </form>
            <?php
        if (isset($_GET['submit'])) { ?>
            <div class="reportDate">
                <h2 style="margin-top: 0px;">From: <?php echo @$_GET['from'] ?> &nbsp &nbsp To: <?php echo @$_GET['to'] ?></h2>
            </div>
            <?php 
            $page = @$_GET['page'];
            if($page == 'branch'){
                $functions->branchWagesResult();
            }
            if($page == 'staff'){
                $functions->staffWagesResult();
            }
            if($page == 'weekly'){
                $functions->WeeklyWagesResult_old();
            }
            if($page == 'fullweekly'){
                $functions->WeeklyWagesResult();
            }
        }
        ?>
        </div>
    </div>
        <!-- right_side close -->
    <!-- </div> -->
    <!-- left_right_side -->
</div>
<!-- index_content -->
<script>
$(document).ready(function() {
    $('.page').on('change', function() {
        chk = $(this).val();
        if (chk == 'staff') {
            $('.user').slideDown('slow');
        } else {
            $('.user').slideUp('slow');
        }
    });

    $('.rota-table table').on('mouseover', 'td', function(e) { 
        $('.rota-table table th').css({ "background-color": "transparent"}); 
        var day = e.delegateTarget.tHead.rows[0].cells[this.cellIndex],
            sno  = this.parentNode.cells[0];
        $(sno).css({ "background-color": "#e5f3f2"});
        $(day).css({ "background-color": "#e5f3f2"});
        $(sno).next('th').css({ "background-color": "#e5f3f2"});
    });
    
});

 


function editTiming(isId) {$(".myevents-form").empty(),$(".fixed_side").toggleClass("fixed_side_"),$(".myevents-div").toggleClass("myevents-div_"),$(".myevents-form").load("editTiming.php?id="+isId,(function(){$(".myevents-div #loader").fadeOut(600),$(".background_side").fadeOut(600)})),$("[title='chat widget']").parent("div").hide()} 
</script>
<?php include_once('dashboardfooter.php'); ?>
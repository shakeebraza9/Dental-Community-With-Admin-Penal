<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}



include'dashboardheader.php'; 
$functions->pin();

?>

<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        <div class="right_side rota">
            <div class="right_side_top">
            
            </div>
            <!-- right_side_top close -->
            <div class="profile rota">
            <form method="get">
                <div class="row">
                <div class="form-group col-12 col-md-6">
                    <label>Select Report</label>
                    <select name="page" class="page" required>
                        <option disabled selected>Select Reports</option>
                        <option value="branch">Branch</option>
                        <option value="staff">Staff</option>
                        <option value="weekly">Weekly</option>
                        <option value="fullweekly">Full Weekly</option>
                    </select>
                    <?php
                    if (isset($_GET['page'])) { ?>
                    <script>$('.page').val("<?php echo @$_GET['page'] ?>").change();</script>
                    <?php } ?>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label>From</label>
                    <input type="date" name="from" value="<?php echo @$_GET['from'] ?>" required>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label>To</label>
                    <input type="date" name="to" value="<?php echo @$_GET['to'] ?>" required>
                </div>
                <?php if(@$_GET['page'] == 'staff') $display=""; else $display="display: none;"; ?>
                <div class="form-group col-12 col-md-6 user" style="<?php echo $display ?>">
                    <label>Select User</label>
                    <select name="user" class="staff">
                        <option disabled selected>Select User</option>
                        <?php echo $functions->allEmployee($_SESSION['currentUser']) ?>
                    </select>
                    <?php
                if(@$_GET['page'] == 'staff') { ?>
                    <script>$('.staff').val("<?php echo @$_GET['user'] ?>").change();</script>
                    <?php } ?>
                </div>
                <div class="form-group col-12">
                    <button class="submit_class" type="submit" name="submit">Submit</button>
                </div>
                </div>
            </form>
            <?php
        if (isset($_GET['submit'])) {
            $page = htmlspecialchars($_GET['page']);
            if($page == 'branch'){
                $functions->branchWagesResult();
            }
            if($page == 'staff'){
                $functions->staffWagesResult();
            }
            if($page == 'weekly'){
                $functions->WeeklyWagesResult();
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
</script>
<?php include_once('dashboardfooter.php'); ?>
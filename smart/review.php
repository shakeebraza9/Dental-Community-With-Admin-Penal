<?php
include_once("global.php");
$login = $webClass->userLoginCheck();
if (!$login) {
    header("Location: login.php");
}
$box19      = $webClass->getBox("box19");
$bannerImg  = $box19['image'];
$subHeading = 'Quiz Review';
include_once('header.php'); ?>
<?php include'dashboardheader.php'; ?>
<div class="index_content">
     <div class="left_side">
            <?php $active = 'dashboard'; include'dashboardmenu.php';?>
        </div><!-- left_side close -->
        <div class="right_side">
<?php
global $dbF, $webClass, $functions;
if (isset($_GET['finnish'])) {
    include_once('finnish.php');
    
}
if (isset($_POST['submitReview'])) {
    $quest_option = $_POST['option'];
    // $dbF->prnt($_POST);
    foreach ($quest_option as $key => $value) {
        $sqlReviewUpd = "UPDATE `test_result` SET `chosen_option` = ? WHERE `result_id` = ?";
        $resReviewUpd = $dbF->setRow($sqlReviewUpd, array(
            $value,
            $key
        ));
    }
}
$testId      = @$_GET['test'];
$testId = filter_var($_GET['test'], FILTER_SANITIZE_STRING);

$sql         = "SELECT * FROM `test_result` WHERE `test_id` = ?";
$res         = $dbF->getRows($sql, array($testId));
$userName    = $_SESSION['webUser']['name'];
$testId_expl = explode(':', $testId);
$assign_id   = $testId_expl[0];
$sqlPaper    = "SELECT `paper_title`,`total_questions` FROM `assigned_paper` ap JOIN `paper` p ON ap.`assign_paper` = p.`paper_id` WHERE ap.`assign_id` = ?";
$resPaper    = $dbF->getRow($sqlPaper, array(
    $assign_id
));
if (time() < $res[0]['end_time'] && !isset($_GET['finnish'])) {
?>

<div class="search_popup">
    <div class="search_inner">
        <div class="detail"> You have choosen to end your quiz and this review. If you click YES, Remove ; you will end your quiz, you will NOT be able to return to this review, and your quiz will be immediately submitted for scoring.</div>
        <div class="ques"> Are you sure you want to end your quiz and this review ?</div>
        <div class="form">
            <input type="submit" id="yes" name="yes" value="YES">
            <input type="submit" id="no" name="no" value="NO">
        </div>
    </div>
    <!--search_inner-->
</div>
<!--search_popup-->
<div class="quiz">
        <div class="standard">
            <div class="quiz_main">
            <div class="heading_col">
                <h3><?php echo $resPaper['paper_title'] . ' - ' . $userName; ?></h3>
                <div class="heading_col_right">
                    <div class="tm">Time Remaining&nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-clock"></i>&nbsp;&nbsp;<span id="timer"></span></div>
                    <!-- timer close -->
                </div>
                <!-- heading_col_right close -->
            </div>
            <!-- heading_col close -->
<div class="heading_col2">
<?php
    if (isset($_GET['rv'])) {
        $sqli    = "SELECT * FROM `test_result` WHERE `test_id` = ? AND `flag` = 1 AND `result_id` = ?";
        $resflag = $dbF->getRows($sqli, array(
            $testId,
            $_GET['rv']
        ));
        if (empty($resflag)) {
        } else {
?>
<div class="heading_col2_right">
<div class="col2_box_side"> 
<a id="flag" class="pointer" data-id="<?php echo $_GET['rv']; ?>" onclick="flag_question_update(this)"><i class="far fa-flag"></i>Remove Flag</a> 
</div>
<!-- col2_box_side close -->
</div>
<!-- heading_col2_right close -->
<?php
        }
    }
?>
</div>
<!-- heading_col2 close -->
            <div class="question_side">
                <h2>Quiz Review</h2>
                <?php
    $reviewLink = WEB_URL . '/review.php?test=' . $testId;
    if (isset($_GET['rv'])) {
        echo '<form action="' . $reviewLink . '" method="post">';
        $revResId      = $_GET['rv'];
        $sqlRv         = "SELECT * FROM `test_result` WHERE `test_id` = ? AND `result_id` = $revResId LIMIT 1 ";
        $resRv         = $dbF->getRow($sqlRv, array(
            $testId
        ));
        $q_detail      = $functions->getQuestionDetail($resRv['question_id'], $resRv['subjectId']);
        $options       = json_decode($q_detail['options']);
        $chosen_option = $resRv['chosen_option'];
        $result_id     = $resRv['result_id'];
        $optionRadio   = '';
        foreach ($options as $key => $value) {
            $new_index = $key + 1;
            $selected  = ($chosen_option == $new_index) ? 'checked' : '';
            $numbers   = "";
            if ($key == 0) {
                $numbers = "A";
            } elseif ($key == 1) {
                $numbers = "B";
            } elseif ($key == 2) {
                $numbers = "C";
            } elseif ($key == 3) {
                $numbers = "D";
            } elseif ($key == 4) {
                $numbers = "E";
            } elseif ($key == 5) {
                $numbers = "F";
            }
            $optionRadio .= '<label>
                                            <input class="indeterminate-checkbox" type="radio" name="option[' . $result_id . ']" value="' . $new_index . '" ' . $selected . '> 
                                           ' . $numbers . '.&nbsp;&nbsp;&nbsp;' . $value . ' 
                                           <span class="chkmark"></span>
                                        </label>';
        }
        echo '<div class="question_side1">
                                <div class="question_side_main"> ' . $q_detail['question_title'] . '</div>
                                <div class="options_side">
                                    <div class="option_side_line">
                                    ' . $optionRadio . '
                                    </div>
                                </div>
                            </div>';
        echo '<div class="quiz_btn">
                            <div class="quiz_btn_back"> <a href="' . $reviewLink . '">Back to Review</a> </div>
                            <!-- button_side_back close -->
                            <input type="submit" name="submitReview" value="Update" class="quiz_btn_next">
                        </div>';
        echo '</form>';
    } else {
?>
<form action="review.php?finnish=END+REVIEW" method="post" id="form-id">
<?php
        $quest_count = 1;
        $table       = '<table>';
        $com         = "Complete";
        foreach ($res as $key => $value) {
            $result_id     = $value['result_id'];
            $chosen_option = $value['chosen_option'];
            $flag          = '';
            $comment       = '';
            if ($value['flag'] == 1) {
                $flag = '<i class="fas fa-flag"></i>';
            }
            if (!empty($value['comment'])) {
                $comment = '<span>(Comment: ' . $value['comment'] . ' )<span>';
            }
            $subject_det  = $functions->getSubject($value['subjectId'], 'subject_title');
            $subject_name = $subject_det['subject_title'];
            $q_detail     = $functions->getQuestionDetail($value['question_id'], $value['subjectId']);
            $options      = json_decode($q_detail['options']);
            $optionRadio  = '';
            foreach ($options as $key => $value) {
                $new_index = $key + 1;
                $selected  = ($chosen_option == $new_index) ? 'checked' : '';
                $optionRadio .= '<label>
<input class="indeterminate-checkbox" type="radio" name="option[' . $result_id . ']" value="' . $new_index . '" ' . $selected . '> 
' . $value . ' 
</label>';
            }
            if (!($chosen_option == NULL)) {
                $com = 'Complete';
            } else {
                $com = 'Incomplete';
            }
            $questUrl = WEB_URL . '/review.php?test=' . $testId . '&rv=' . $result_id;
            if ($quest_count % 2 != 0) {
                $table .= '
<tr>
<th>' . $flag . '
<a href="' . $questUrl . '">Question ' . $quest_count . '</a>' . '<span>' . $com . '</span></th>

';
            } else {
                $table .= '

<th>' . $flag . '
<a href="' . $questUrl . '">Question ' . $quest_count . '</a>' . '<span>' . $com . '</span></th>
</tr>
';
            }
            $quest_count++;
        }
        echo $table .= '</table>';
?>

<input type="hidden" name="test" value="<?php echo $testId; ?>">
<div class="quiz_btn">
<input type="submit" id="button" name="finnish" value="END REVIEW" class="quiz_btn_next">
</div>
<!-- quiz_btn -->
</form>
<?php
    }
?>
            </div>
            <!-- question_side close -->
        </div>
        <!-- page_content close -->
     </div>
        <!-- standard -->
    </div>
    <!-- quiz -->

<?php
} elseif(!isset($_GET['finnish'])) {
?>

<div class="content_page">
    <div class="content_page_main">
        <div class="content_logo">
            <a href="<?php
    WEB_URL;
?>">
                <div class="logo_animation"> <!-- <img src="<?php //WEB_URL; 
?>/webImages/3.png" alt=""> --> </div>
                <!-- logo_animation close -->
                <div class="logo_text"> <!-- <img src="<?php //WEB_URL; 
?>/webImages/2.png" alt=""> --> </div>
                <!-- logo_text close -->
            </a>
        </div>
        <!-- content_logo close -->
        <div class="page_content">
            <div id="timer"></div>
            <!-- timer close -->
            <div class="question_side">
                Timeout
            </div>
            <!-- question_side close -->
        </div>
        <!-- page_content close -->
    </div>
    <!-- content_page_main close -->
</div>
<!-- content_page close -->

<?php
}
?>
</div><!-- rightside Close-->
<script>
 // Set the date we're counting down to
 // var countDownDate = new Date("Jan 5, 2019 16:00").getTime();
 var countDownDate = '<?php echo ($_SESSION['endd_time'])*1000; ?>';
 // var countDownDate = '<?php //echo (@$res[0]['end_time '])*1000; ?>';
 console.log(countDownDate);
 // Update the count down every 1 second
 var x = setInterval(function() {
     // Get todays date and time
     var now = new Date().getTime();
     // Find the distance between now and the count down date
     var distance = countDownDate - now;
     console.log(countDownDate + ' | ' + now + ' | ' + distance);
     // Time calculations for days, hours, minutes and seconds
     var days = Math.floor(distance / (1000 * 60 * 60 * 24));
     var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
     var hoursmin = Math.floor((hours * 60));
     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
     var plus = Math.floor(minutes + hoursmin);

     var seconds = Math.floor((distance % (1000 * 60)) / 1000);
     // Output the result in an element with id="timer"
     document.getElementById("timer").innerHTML = plus + "m " + seconds + "s ";
     // If the count down is over, write some text 
     if (distance < 0) {
         clearInterval(x);
         document.getElementById("timer").innerHTML = "Timeout";
     }
 }, 1000);

 $("#button").on("click", function(e) {
     e.preventDefault();
 });

 $(function() {

     $("#button").click(function() {
         $(".search_popup").addClass("show_search");
     });

     $(".close_btn").click(function() {
         $(".search_popup").removeClass("show_search");
     });

     $("#no").click(function() {
         $(".search_popup").removeClass("show_search");
     });

     $("#yes").click(function() {
        $("#form-id").submit();
     });

 });

 function flag_question_update(ths) {
     result_id = $(ths).data('id');
     $.ajax({
         url: 'ajax_call.php?page=flagQuestionZero',
         type: 'post',
         data: {
             result_id: result_id
         }
     }).done(function(res) {
         console.log(res);
         if (res == '1') {
             $(ths).html('<i class="fas fa-flag"></i>Done');
         }
     });
 }

</script>
<style>
    .inner_banner{
        height: 300px;
    }
    @media only screen and (max-width:768px){
        .col1_btn_main{
            display: none !important;
        }
    }
</style>
<?php include_once('footer.php'); ?>
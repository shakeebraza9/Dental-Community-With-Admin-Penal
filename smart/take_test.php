<?php
include_once("global.php");
global $dbF, $webClass, $functions, $start_time, $end_time, $remain_time;
$login = $webClass->userLoginCheck();
if (!$login) {
    header("Location: login.php");
}
$box19      = $webClass->getBox("box19");
$bannerImg  = $box19['image'];
$subHeading = 'Quiz';
include_once('header.php');?>
<?php include'dashboardheader.php'; ?>
<div class="left_side">
            <?php $active = 'dashboard'; include'dashboardmenu.php';?>
        </div><!-- left_side close -->
<div class="index_content">
<?php
if ($functions->getFormToken('generalInstToken')) {
    $user_id  = $_POST['user_id'];
    $paper_id = $_POST['paper_id'];
    $sql      = "INSERT INTO `assigned_paper`(`assign_user`,`assign_paper`,`status`) VALUES ('$user_id','$paper_id','0')";
    $dbF->setRow($sql);
    $lastId                  = $dbF->rowLastId;
    $_SESSION['assigned_id'] = $lastId;
}
$user_id  = $webClass->webUserId();
$userName = $_SESSION['webUser']['name'];
$testId   = @$_SESSION['assigned_id'] . ':' . $user_id;
$msg      = '';
if (isset($_GET['back'])) {
    if ($_SESSION['Question_no'] > 1) {
        $_SESSION['Question_no'] = $_SESSION['Question_no'] - 1;
    }
}
// if(isset($_POST['next_quest'])){
// $_SESSION['Question_no'] = $_SESSION['Question_no']+1;
// }
if (isset($_GET['st']) && $_GET['st'] == 'updateTest' && isset($_SESSION['assigned_id'])) {
    // $_SESSION['previous'] = $_POST['test_resultId'];
    $_SESSION['current_time'] = time();
    $_SESSION['Question_no'] += 1;
    if (time() > $_SESSION['end_time']) {
        $msg = "Sorry Timeout!";
        // exit;
    }
    $attempt_time = time();
    $sql_check    = "SELECT `time`,`start_time`,`end_time` FROM `test_result` WHERE `test_id` = ? ORDER BY `date_timestamp` DESC";
    $res_check    = $dbF->getRow($sql_check, array(
        $testId
    ));
    $endTime      = $res_check['end_time'];
    $currTime     = $res_check['time'];
    // $_SESSION['endd_time'] = $end_time-$currTime;
    if ($attempt_time <= $endTime) {
        $status = 1;
        $sqlUpd = "UPDATE `test_result` SET `chosen_option` = ?, `status` = ?, `time` = ? WHERE `question_id` = ? AND `subjectId` = ? AND `test_id` = ?";
        if (empty($_POST['option'])) {
            $option = NULL;
            $status = 0;
        } else {
            $option = $_POST['option'];
        }
        $option = empty($_POST['option']) ? NULL : $_POST['option'];
        $res    = $dbF->setRow($sqlUpd, array(
            @$_POST['option'],
            $status,
            $attempt_time,
            $_POST['question_id'],
            $_POST['subjectId'],
            $testId
        ));
        if ($_SESSION['Question_no'] == ($_SESSION['total_questions'] + 1)) {
            $sql = "UPDATE `assigned_paper` SET `status` = 1 WHERE `assign_id` = ?";
            $res = $dbF->setRow($sql, array(
                $_SESSION['assigned_id']
            ));
            if ($dbF->rowCount > 0) {
                echo "<script>window.location.href='review.php?test=$testId'</script>";
                exit;
            }
        }
    } else {
        $msg = "Question Not Submitted As Time Ran Out!";
        exit();
    }
}
if (isset($_SESSION['assigned_id'])) {
    $sqlj            = "SELECT * FROM `assigned_paper` WHERE `assign_id` = ?";
    $res_assign      = $dbF->getRow($sqlj, array(
        $_SESSION['assigned_id']
    ));
    // var_dump($_SESSION['assigned_id']);
    $paperDetail     = $functions->getPaperDetail($res_assign['assign_paper']);
    $paper_title     = $paperDetail['paper_title'];
    $allowed_time    = $paperDetail['allowed_time'];
    $total_questions = $paperDetail['total_questions'];
    // var_dump($paperDetail['paper_questions']);
    $paper_questions = json_decode($paperDetail['paper_questions']);
    if (isset($_GET['st']) && $_GET['st'] == 'start') {
        $start_time            = time();
        $end_time              = $start_time + (60 * $allowed_time);
        $_SESSION['endd_time'] = $end_time;
        $uniqueDomain          = array();
        foreach ($paper_questions as $key => $value) {
            $domain_id      = $key;
            $uniqueDomain[] = $key;
            $domain_name    = $functions->getSubject($domain_id, 'subject_title');
            foreach ($value as $row) {
                $sql   = "SELECT `time`,`end_time` FROM `test_result` WHERE `test_id` = '$testId' AND `subjectId` = '$domain_id' AND `question_id` = '$row' ORDER BY `date_timestamp` DESC";
                $resCh = $dbF->getRows($sql);
                if (empty($resCh)) {
                    $sql = "INSERT INTO `test_result`(`test_id`, `start_time`, `end_time`, `time`, `subjectId`, `question_id`, `status`) VALUES (?,?,?,?,?,?,?)";
                    $res = $dbF->setRow($sql, array(
                        $testId,
                        $start_time,
                        $end_time,
                        $start_time,
                        $domain_id,
                        $row,
                        0
                    ));
                } else {
                    $_SESSION['endd_time'] = $resCh[0]['end_time'];
                    if (time() > $resCh[0]['end_time']) {
                        $msg = "Sorry Timeout!";
                        // exit;
                    }
                }
            }
        }
        $sqlQuesUpd    = "SELECT count(*) AS 'count' FROM `test_result` WHERE `test_id` = '$testId' AND `status` = 1 AND `chosen_option` IS NOT NULL";
        $resSqlQuesUpd = $dbF->getRow($sqlQuesUpd);
        if (!empty($resSqlQuesUpd)) {
            $_SESSION['remain_question'] = $resSqlQuesUpd['count'];
        } else {
            $_SESSION['remain_question'] = 0;
        }
        $allResultIds = array();
        $sqlShift     = "SELECT `result_id` FROM `test_result` WHERE `test_id` = '$testId' ORDER BY `result_id` ASC";
        $resShift     = $dbF->getRows($sqlShift);
        foreach ($resShift as $keyS => $valueS) {
            $allResultIds[] = $valueS['result_id'];
        }
        array_shift($allResultIds);
        $shiftCount = 0;
        foreach ($resShift as $keyShift => $valueShift) {
            if (isset($allResultIds[$shiftCount])) {
                $nextValShift = $allResultIds[$shiftCount];
                $sqlShiftUpd  = "UPDATE `test_result` SET `next_quest` = ?,`previous_quest` = ? WHERE `result_id` = ?";
                $preValShift  = $valueShift['result_id'] - 1;
                $resShiftUpd  = $dbF->setRow($sqlShiftUpd, array(
                    $nextValShift,
                    $preValShift,
                    $valueShift['result_id']
                ));
                $shiftCount++;
            }
        }
        $_SESSION['start_time']   = $start_time;
        $_SESSION['end_time']     = $end_time;
        $_SESSION['current_time'] = $start_time;
        $_SESSION['Question_no']  = 1 + $_SESSION['remain_question'];
    }
    // if(time() > $res['end_time']){
    //     $msg = "Sorry Timeout!";
    //     // exit;
    // }
    // echo $_SESSION['Question_no'].'  '.$_SESSION['total_questions'].' '.$msg;
    if (empty($msg) && ($_SESSION['Question_no'] <= $_SESSION['total_questions'])) {
        if (time() > $_SESSION['end_time']) {
            $msg = "Sorry Timeout!";
            // exit;
        }
        if (isset($_GET['back'])) {
            $dbPrevious = $_GET['back'];
            $sqli       = "SELECT * FROM `test_result` WHERE `test_id` = ? AND `result_id` = $dbPrevious LIMIT 1 ";
        } elseif (isset($_POST['next_quest'])) {
            $dbNext = $_POST['next_quest'];
            $sqli   = "SELECT * FROM `test_result` WHERE `test_id` = ? AND `result_id` = $dbNext LIMIT 1 ";
        } else {
            $sqli = "SELECT * FROM `test_result` WHERE `test_id` = ? AND `status` = 0 ORDER BY `result_id` ASC LIMIT 1 ";
        }
        $res        = $dbF->getRow($sqli, array(
            $testId
        ));
        $q_detail   = $functions->getQuestionDetail($res['question_id'], $res['subjectId']);
        $options    = json_decode($q_detail['options']);
        // var_dump($q_detail['options']);
        $next_quest = $res['next_quest'];
        if (isset($_GET['st']) && $_GET['st'] == 'start') {
            $prev_quest = 0;
        } else {
            $sqlPrev    = "SELECT `previous_quest` FROM `test_result` WHERE `test_id` = ? AND `result_id` = ? LIMIT 1 ";
            $resPrev    = $dbF->getRow($sqlPrev, array(
                $testId,
                $res['result_id']
            ));
            $prev_quest = $resPrev['previous_quest'];
            // var_dump($prev_quest);
            // var_dump($res['result_id']);
            // $prev_quest = $res['previous_quest'];
            if ($prev_quest == NULL)
                $prev_quest = $res['result_id'] - 1;
        }
        // $prev_quest = $_SESSION['previous'];
        $chosen_option         = $res['chosen_option'];
        $subjectID             = $res['subjectId'];
        $subj_det              = $functions->getSubject($subjectID, 'subject_title');
        $subj_name             = $subj_det['subject_title'];
        $_SESSION['endd_time'] = $res['end_time'];
?>
 <div class="right_side">
    <div class="quiz">
        <div class="standard">
            <div class="quiz_main">
                <form action="take_test.php?st=updateTest" method="post" id="questionForm">
                    <div class="heading_col">
                        <h3>
                            <?php echo $paper_title . ' - ' . $userName; ?>
                        </h3>
                        <div class="heading_col_right">
                            <div class="tm">Time Remaining&nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-clock"></i>&nbsp;&nbsp;<span id="timer"></span></div>
                            <!-- timer close -->
                        </div>
                        <!-- heading_col_right close -->
                    </div>
                    <!-- heading_col close -->
                    <div class="heading_col2">
                        <!-- col2_box_side close -->
                        <div class="heading_col2_right">
                            <div class="col2_box_side">
                                <a id="flag" class="pointer" data-id="<?php echo $res['result_id']; ?>" onclick="flag_question(this)"><i class="far fa-flag"></i>Flag for Review</a>
                            </div>
                            <!-- col2_box_side close -->
                        </div>
                        <!-- heading_col2_right close -->
                    </div>
                    <!-- heading_col2 close -->
                    <!-- timer close -->
                    <div class="question_side">
                        <?php //$dbF->prnt($res); ?>
                        <?php //echo $_SESSION['endd_time'].' | '.$_SESSION['end_time']; ?>
                        <input type="hidden" id="subjectId" name="subjectId" value="<?php echo $subjectID; ?>" />
                        <input type="hidden" id="question_id" name="question_id" value="<?php echo $res['question_id'];
                        ?>" />
                        <input type="hidden" id="assign_id" name="assign_id" value="<?php echo $testId; ?>" />
                        <input type="hidden" id="next_quest" name="next_quest" value="<?php echo $next_quest; ?>" />
                        <input type="hidden" id="prev_quest" name="prev_quest" value="<?php echo $prev_quest; ?>" />
                        <input type="hidden" id="test_resultId" name="test_resultId" value="<?php echo $res['result_id']; ?>" />
                        <div class="counting"><span>Question</span>
                            <?php echo $_SESSION['Question_no'] . "/" . $total_questions; ?>
                        </div>
                        <!-- counting close -->
                        <div class="question_side_main">
                            <?php echo $q_detail['question_title']; ?>
                        </div>
                        <!-- question_side_main close -->
                        <div class="options_side">
                            <div class="option_side_line">
                                <?php
                                foreach ($options as $key => $value) {
                                    if (!empty($value)) {
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
                                        } elseif ($key == 6) {
                                            $numbers = "G";
                                        } elseif ($key == 7) {
                                            $numbers = "H";
                                        } elseif ($key == 8) {
                                            $numbers = "I";
                                        } elseif ($key == 9) {
                                            $numbers = "J";
                                        } elseif ($key == 10) {
                                            $numbers = "K";
                                        }
                                        echo '<label>
                                            <input class="indeterminate-checkbox" type="radio" name="option" value="' . $new_index . '" ' . $selected . '>
                                            ' . $numbers . '.&nbsp;&nbsp;&nbsp;' . $value . ' 
                                            <span class="chkmark"></span>
                                            </label>';
                                    }
                                }
                                ?>
                            </div>
                            <!-- option_side_line close -->
                            <?php
                            // $curUrl = $_SERVER['REQUEST_URI'];
                            $curUrl  = WEB_URL . '/take_test.php?back=' . $prev_quest;
                            $nextUrl = WEB_URL . '/take_test.php?next=' . $next_quest;
                            ?>
                            <div class="quiz_btn">
                                <?php
                                if ($_SESSION['Question_no'] != 1): ?>
                                <div class="quiz_btn_back"> <a href="<?php echo $curUrl; ?>">Back</a></div>
                                <?php endif; ?>
                                <!-- quiz_btn_back close -->
                                <div class="quiz_btn_next" id="next_question">Next</div>
                                <!-- quiz_btn_next close -->
                            </div>
                            <!-- quiz_btn close -->
                        </div>
                        <!-- options_side close -->
                    </div>
                    <!-- question_side close -->
                </form>
            </div>
            <!-- quiz_main close -->
        </div>
        <!-- standard -->
    </div>
    </div>
    <!-- quiz -->
    <?php
    } else {
?>
    <div class="content_page">
        <div class="content_page_main">
            <div class="content_logo" style="display: none;">
                <a href="<?php
        echo WEB_URL;
?>">
                    <div class="logo_animation">
                        <!-- <img src="webImages/3.png" alt=""> -->
                    </div>
                    <!-- logo_animation close -->
                    <div class="logo_text">
                        <!-- <img src="webImages/2.png" alt=""> -->
                    </div>
                    <!-- logo_text close -->
                </a>
            </div>
            <!-- content_logo close -->
            <div class="page_content">
                <div id="timer"></div>
                <!-- timer close -->
                <div class="question_side">
                    <?php         echo $msg; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
}
?>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#next_question').click(function(event) {
            $('#questionForm').submit();
        });
    });

    $(document).ready(function() {
        result_id = <?php echo (empty(@$res['result_id'])?0:$res['result_id']); ?>;
        $.ajax({
            url: 'ajax_call.php?page=flagQuestionSelect',
            type: 'post',
            data: {
                result_id: result_id
            }
        }).done(function(res) {
            if (res == '1') {
                $('#flag').html('<i class="fas fa-flag"></i>Flagged');
            }
        });
    });

    function flag_question(ths) {
        result_id = $(ths).data('id');
        $.ajax({
            url: 'ajax_call.php?page=flagQuestion',
            type: 'post',
            data: {
                result_id: result_id
            }
        }).done(function(res) {
            if (res == '1') {
                $(ths).html('<i class="fas fa-flag"></i>Flagged');
            }
        });
    }

    // Set the date we're counting down to
    // var countDownDate = new Date("Jan 5, 2019 16:00").getTime();
    var countDownDate = '<?php echo ($_SESSION['endd_time'])*1000; ?>';
    // Update the count down every 1 second
    var x = setInterval(function() {
        // Get todays date and time
        var now = new Date().getTime();
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
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
    </script>
    <style>
    .inner_banner {
        height: 300px;
    }
    @media only screen and (max-width:768px){
        .col1_btn_main{
            display: none !important;
        }
    }
    </style>
    <?php include_once('footer.php'); ?>
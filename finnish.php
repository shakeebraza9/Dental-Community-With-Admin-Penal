<?php 
$msg = $functions->feedbackratingSubmit();

 
 
    //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
 
if ($msg) {
     $msg =  "Thanku For Your Feedback";
    $display = 'style="display:none;"';
}




$test_id = filter_var($_POST['test'], FILTER_SANITIZE_STRING);

$userName = $_SESSION['webUser']['name'];
$testId_expl = explode(':', $test_id);
$assign_id = $testId_expl[0];
$user = $_SESSION['webUser']['id'];
//to be removed
// $test_id = "37608:10";
$sqlTestRes = "SELECT t.result_id, q.question_id, t.subjectId, q.question_title, q.options, q.correct_opt, t.chosen_option FROM questions AS q JOIN test_result AS t ON q.question_id = t.question_id WHERE t.test_id = ? ORDER BY t.result_id ASC";
$TestRes = $dbF->getRow($sqlTestRes, array($test_id));
// var_dump($TestRes);

$sqlPaper = "SELECT *,ap.`date_timestamp` AS 'exam_date' FROM `paper` p JOIN `assigned_paper` ap ON p.`paper_id` = ap.`assign_paper` WHERE ap.`assign_id` = ?";

$resPaper = $dbF->getRow($sqlPaper, array($test_id));

$failed = false;
$sqlTestResult = "SELECT t.result_id, q.question_id, t.subjectId, q.question_title, q.options, q.correct_opt, t.chosen_option FROM questions AS q JOIN test_result AS t ON q.question_id = t.question_id WHERE t.test_id = ? ORDER BY t.result_id ASC";
$testResult =  $dbF->getRows($sqlTestResult, array($test_id));


$pass_percent = $functions->ibms_setting('passing percent');

$paperQues = json_decode($resPaper['paper_questions']);
$paperDoamin = $resPaper['paper_questions'];
$total_ques = $resPaper['total_questions'];
$paper_title = $resPaper['paper_title'];
$aim = $resPaper['aim'];
$objectives = $resPaper['objectives'];
$learning_content = $resPaper['learning_content'];
$development_outcomes = $resPaper['development_outcomes'];
$apDateTimestamp = explode(' ',$resPaper['exam_date']);
$exam_date = $apDateTimestamp[0];

$question_answer = array();

foreach ($paperQues as $key => $value) {
    foreach ($value as $row) {
        $sqlCorrect = "SELECT `correct_opt` FROM `questions` WHERE `question_id` = ?";
        $resCorrect = $dbF->getRow($sqlCorrect, array($row));
        $question_answer[$row] = $resCorrect['correct_opt'];
    }
}

$totalPassQues = 0;
$domainResult = '';
foreach ($paperQues as $key => $value) {

    $domain_id = $key;
    $domainDet = $functions->getSubject($domain_id, 'subject_title');
    $domain_name = $domainDet['subject_title'];
    $domain_total = count($value);

    $sqlResQuestion = "SELECT `question_id`,`chosen_option` FROM `test_result` WHERE `test_id` = ? AND `subjectId` = ? AND `chosen_option` IS NOT NULL";
    $resResQuestion = $dbF->getRows($sqlResQuestion, array($test_id, $domain_id));

    $domainCorrectCount = 0;
    foreach ($resResQuestion as $keyRes => $valueRes) {
        $chosen = $valueRes['chosen_option'];
        $questi = $valueRes['question_id'];
        if($chosen == $question_answer[$questi]){
            $domainCorrectCount++;
        }   
    }
    $totalPassQues += $domainCorrectCount; 
}

// if($total_ques == NULL){
//     $total_ques = 0;
// }
$obtain_perc = ($totalPassQues/$total_ques)*100;


$q = "SELECT `expiration`,`minutes` FROM `subjects` WHERE `subject_id` = ? ";
$d = $dbF->getRow($q,array($domain_id));
$expiry_date = date('Y-m-d',strtotime('+ '.$d['expiration'].' Month'));
$minutes = $d['minutes'];

if($obtain_perc >= $pass_percent){
    $btnFeedback = TRUE;
   
    $aassign_id = md5($assign_id);
    $result = "You have PASSED the CPD please <a href='printResult.php?assignid=$aassign_id&user=$user' target='_blank'>Click here</a> to download your certificate <br><br>
        <a class='anim anim2 tooltips' data-toggle='tooltip' title='Click to Upload Staff Folder' href='javascript:;'  onclick='documentselectcpdpdf($assign_id,$user);' >Click here</a> to upload certificate to your document folder";
    $sql = "UPDATE `assigned_paper` SET `expiry_date` = ?, `minutes`= ?, `completion_date`= ?, `result` = ? WHERE `assign_id` = '$assign_id'";
    $dbF->setRow($sql, array($expiry_date,$minutes,date('Y-m-d'),'completed'));
    $nots =  $functions->notifications('completecpd',$user);
    $functions->setlog("Quiz PASSED",$functions->userName($user)." : ".$user,$assign_id,$domain_name);

}else{
    $btnFeedback = FALSE;
    $failed = true ;
    $result = 'You have FAILED, Please try again.';
    $sql = "UPDATE `assigned_paper` SET `expiry_date` = ?, `minutes`= ?, `completion_date`= ?, `result` = ? WHERE `assign_id` = '$assign_id'";
    $dbF->setRow($sql, array('0','0',date('Y-m-d'),'failed'));
    $functions->setlog("Quiz FAILED",$functions->userName($user)." : ".$user,$assign_id,$domain_name);
}
?>

<div class="quiz">
    <div class="standard">
        <div class="heading_col">
            <h3><?php echo $resPaper['paper_title'].' - '.$userName ; ?></h3>
            <div class="heading_col_right">
            <!--     <div id="timer"></div> -->
                <!-- timer close -->
                <div class="col_total_side"> Total <span><?php echo $resPaper['total_questions']; ?></span> Questions </div>
                <!-- col_total_side close -->
            </div>
            <!-- heading_col_right close -->
        </div>
        <!-- heading_col close -->
        <br>
        <br>
        <h2 style="text-align: center;"><?php echo $result ?></h2>
        
          <!--Review-->
        <?php if($failed){ ?>
                <div class="question-review">
                    <?php  foreach($testResult as $key=>$test){ 
                        $tempClass = $test['correct_opt'] == $test['chosen_option'] ? "right_" : "wrong_"
                    ?>
                            <div class="questionTab" style="display: none;">
                                <div class="question-heading ">
                                    <h3 class="<?php echo $tempClass ?>"> Question No <?php echo $key+1 ; ?></h3>
                                    <?php 
                                    if($test['correct_opt'] == $test['chosen_option']){
                                        echo '<i class="fas fa-check"></i>';
                                    }
                                    else{
                                        echo '<i class="fas fa-times"></i>';
                                    }
                                    ?>
                                </div>
                                <div class="question-title" >
                                    <?php echo $test['question_title'] ?>
                                </div>
                            </div>
                   <?php } ?>
                    
                </div>
        <?php } ?>
        <!--Review-->
        
        <br>
        <br>
        <h2 style="text-align: center;"><?php echo $msg ?></h2>
         <?php 
          $sql = "SELECT feedback FROM  assigned_paper WHERE assign_id = ? ";
           $dataFeedback = $dbF->getRow($sql,array($assign_id));
           
        if( $dataFeedback == TRUE  && $dataFeedback['feedback'] =="" ){
         echo   "<script>$(document).ready(function(){feedbackRating('$assign_id','$test_id');});</script>";
          ?>
        <h2 style="text-align: center; width: 30%;margin: 6px auto;" ><a href="javascript:;" onclick="feedbackRating('<?php echo $assign_id ?>','<?php echo $test_id ?>');" class="submit_class" >Feedback</a></h2>
<?php   } ?>
    </div>
    <!-- standard -->
</div>
<!-- quiz -->

<script type="text/javascript">
   $('.questionTab').click(function() {
        if($(this).children('.question-title').hasClass('active')){
            $(this).children('.question-title').removeClass('active')
        }
        else{
            
       $(this).children('.question-title').addClass('active')
        }

    });
    $( document ).ready(function() {
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
    });
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
<?php include_once('dashboardfooter.php'); ?>
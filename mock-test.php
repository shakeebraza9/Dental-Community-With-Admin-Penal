<?php 
include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
    header("Location: login.php");
}
$box19 = $webClass->getBox("box19"); 
$bannerImg = $box19['image'];
$subHeading = 'Mock Quiz';
// include_once('header.php'); 

$user_id = $webClass->webUserId();

$id = base64_decode($_GET['id']);
$paperDetail     = $functions->getPaperDetail($id);
$paper_id        = $paperDetail['paper_id'];
$allowed_time    = $paperDetail['allowed_time'];
$total_questions = $paperDetail['total_questions'];
?>
<?php include'dashboardheader.php'; ?>
<div class="index_content">
    
          <div class="right_side">
    <div class="quiz">
        <div class="standard">
            <div class="heading_col">
                <h3>How to Select an Answer</h3>
            </div>
            <!-- heading_col close -->
            <p>
                Each item will have four choices with one correct answer. You select the best answer by:
            </p>
            <ul>
                <li>Clicking anywhere in the answer, or</li>
                <li>Clicking the circle next to the answer</li>
            </ul>
            <p>
                Correct answer is "NFPA" Select the response now
            </p>
            <p>
                When you are ready to continue, Select the Next button<br><br>
                The correct acronym for the National Fire Protection Association?
            </p>
           <!--  <p>
                
            </p> -->
            <div class="option_side_line">
                <label>
                    <input type="radio" name="mock"> A.&nbsp;&nbsp;&nbsp;NPF
                    <span class="chkmark"></span>
                </label>
                <label>
                    <input type="radio" name="mock"> B.&nbsp;&nbsp;&nbsp;FPAP
                    <span class="chkmark"></span>
                </label>
                <label>
                    <input type="radio" name="mock"> C.&nbsp;&nbsp;&nbsp;NFPA
                    <span class="chkmark"></span>
                </label>
                <label>
                    <input type="radio" name="mock"> D.&nbsp;&nbsp;&nbsp;NAPFPA
                    <span class="chkmark"></span>
                </label>
            </div>
            <!-- option_side_line -->
            <?php 
              $test_id = md5($paper_id.':'.$user_id);
              $_SESSION['total_questions'] = $total_questions;
             ?>
            <form method="post" action="take_test.php?st=start" id="generalInsFrom">
                <?php $webClass->setFormToken('generalInstToken'); ?>
                <input type="hidden" name="paper_id" value="<?php echo @$paper_id ?>" />
                <input type="hidden" name="user_id" value="<?php echo @$user_id ?>" />
                <input type="hidden" name="allowed_time" value="<?php echo @$allowed_time ?>" />
                <input type="hidden" name="total_questions" value="<?php echo @$total_questions ?>" />
                <div class="quiz_btn">
                    <div class="quiz_btn_back">
                        <a id="startButton" href="javascript:;">Next</a>
                    </div>
                    <!-- quiz_btn_back close -->
                </div>
                <!-- quiz_btn -->
            </form>
        </div>
        <!-- standard -->
    </div>
    </div>
    <!-- quiz -->
    <script type="text/javascript">
    $('#startButton').on('click', function(event) {
        $('#generalInsFrom').submit();
    });
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
    <?php include_once('dashboardfooter.php'); ?>
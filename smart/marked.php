<?php 
include_once("global.php");
global $dbF,$webClass,$functions;

// $login       =  $webClass->userLoginCheck();
// if(!$login){
//if user not login then go to login page
//     header("Location: login.php");
// }

// if(isset($_GET['finnish'])){
//     include_once('finnish.php');
//     exit;
// }

// if(isset($_POST['submitReview'])){
//     $quest_option = $_POST['option'];
//     // $dbF->prnt($_POST);

//     foreach ($quest_option as $key => $value) {

//         $sqlReviewUpd = "UPDATE `test_result` SET `chosen_option` = ? WHERE `result_id` = ?";
//         $resReviewUpd = $dbF->setRow($sqlReviewUpd, array($value, $key));
//     }
// }


$testId = @$_GET['assignid'].":".@$_GET['user'];
// $testId = @$_GET['assignid'];
$sql = "SELECT * FROM `test_result` WHERE `test_id` = ?";
$res = $dbF->getRows($sql, array($testId));

$userName = $_SESSION['webUser']['name'];

$testId_expl = explode(':', $testId);
$assign_id = $testId_expl[0];

$sqlPaper = "SELECT `paper_title`,`total_questions` FROM `assigned_paper` ap JOIN `paper` p ON ap.`assign_paper` = p.`paper_id` WHERE ap.`assign_id` = ?";
$resPaper = $dbF->getRow($sqlPaper, array($assign_id));



if(1 == 1){

?>
<!DOCTYPE html>
<html>
<head>
<title>Phoenix Safety Consultants (Private) Limited</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="icon" href="<?php echo WEB_URL ?>/favicon.png" type="image/x-icon"/>
<link rel="shortcut icon" href="<?php echo WEB_URL ?>/favicon.png" type="image/x-icon"/>
<!--Bootstrap css file-->
<link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/other.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/button.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/theme.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/style.css">

<!-- DESKTOP -->
<link href="<?php echo WEB_URL ?>/css/style-desktop.css" rel="stylesheet" type="text/css" media="only screen and (min-width:979px) and (max-width:1420px)">
<!-- TABLET -->
<link href="<?php echo WEB_URL ?>/css/style-tablet.css" rel="stylesheet" type="text/css" media="only screen and (min-width:768px) and (max-width:978px)">
<!-- MOBILE -->
<link href="<?php echo WEB_URL ?>/css/style-mobile.css" rel="stylesheet" type="text/css" media="only screen and (min-width:461px) and (max-width:767px)">
<!-- MOBILE SMALL-->
<link href="<?php echo WEB_URL ?>/css/style-mobile-small.css" rel="stylesheet" type="text/css" media="only screen and (max-width:460px)"> 
      <script type="text/javascript" src="<?php echo WEB_ADMIN_URL; ?>/js/jquery.1.11.1.js"></script>
<style type="text/css">
.result_main{
width: 650px;
position: relative;
margin: 0 auto;
border: 2px solid #dcdada;
padding: 20px;
font-size: 100%;
}

.logo img{
width: 200px;
margin-bottom: 15px;
}

.center {
text-align: center;
}

.paper_title{
margin-bottom: 30px;
font-size: 15px;
font-weight: bold;
}

.paper_title p{
margin-bottom: 0px;
}

.personal_detail{
width: 55%;
}

.detail_lebel{
font-weight: bold;
}

.result{
font-weight: bold;
margin-top: 15px;
margin-bottom: 15px;
}

.result_top, .result_bottom{
margin-bottom: 15px;
text-align: justify;
}

.result_bottom{
margin-top: 15px;
text-align: justify;
}

.table_center{
text-align: center;
}

.table_left{
text-align: left;
font-weight: bold;
}

body:before {
background-color: white;
}

table th{
text-decoration: underline;
}
</style>
</head>
<div class="search_popup">
<div class="search_inner">
<div class="close_btn">
</div>

<div class="top_heading">

<h1>End Review</h1>



</div>


<div class="detail"> You have choosen to end your exam and this review. If you click YES; you will end your exam, you will NOT be able to return to this review, and your examination will be immediately submitted for scoring.</div>

<div class="ques"> Are you sure you want to end your exam and this review ?</div>
<div class="form">
<input type="submit" id="yes" name="yes" value="YES">
<input type="submit" id="no" name="no" value="NO">
<!-- <button type="submit"><i class="fa fa-search"></i></button>  -->
</form> 
</div> 
</div>
<!--search_inner-->
</div>
<!--search_popup-->

<div class="content_page">
<div class="content_page_main">
<div class="content_logo" style="display: none;">
<a href="<?php WEB_URL; ?>">
<div class="logo_animation"> <!-- <img src="<?php //WEB_URL; ?>/webImages/3.png" alt=""> --> </div>
<!-- logo_animation close -->
<div class="logo_text"> <!-- <img src="<?php //WEB_URL; ?>/webImages/2.png" alt=""> --> </div>
<!-- logo_text close -->
</a>
</div>
<!-- content_logo close -->
<div class="page_content">
<div class="heading_col">
<h3><?php echo $resPaper['paper_title'].' - '.$userName; ?></h3>
<div class="heading_col_right">
<!-- <div class="tm">Time Remaining&nbsp;&nbsp;&nbsp;&nbsp;<span id="timer"></span></div> -->
<!-- timer close -->
<div class="col_total_side"> Total <span><?php echo $resPaper['total_questions']; ?></span> Questions </div>
<!-- col_total_side close -->
</div>
<!-- heading_col_right close -->
</div>
<!-- heading_col close -->
<div class="heading_col2" style="display: none;">
<div class="col2_box_side"> 
<a><img src="webImages/clt.png" alt="" style="height:25px;margin-right:10px;margin-top: -2px;">Calculator</a> 
</div>
<!-- col2_box_side close -->
<?php 
htmlspecialchars($_GET['rv']);
if(isset($_GET['rv'])){
$sqli = "SELECT * FROM `test_result` WHERE `test_id` = ? AND `flag` = 1 AND `result_id` = ?";
$resflag = $dbF->getRows($sqli, array($testId,$_GET[rv]));
if(empty($resflag)){}else{
?>




<div class="heading_col2_right">

<!-- <div class="col2_box_side"> 

<a id="flag" class="pointer" data-id="<?php echo $_GET[rv]; ?>" onclick="flag_question_update(this)"><i class="far fa-flag"></i>Remove Flag</a> 

</div> -->

<!-- col2_box_side close -->

</div>

<!-- heading_col2_right close -->

<?php }} ?>





</div>
<!-- heading_col2 close -->
<!-- <div class="text_box" id="comment_box">
<textarea name="comment" placeholder="Enter Your Comment"></textarea>
</div> -->




<div class="question_side">
<!-- <h1 align="center">EXAM REVIEW</h1> -->
<?php 
$reviewLink = WEB_URL.'/review.php?test='.$testId;
if(isset($_GET['rv'])){

// echo '<form action="'.$reviewLink.'" method="post">';

$revResId = $_GET['rv'];
$sqlRv = "SELECT * FROM `test_result` WHERE `test_id` = ? AND `result_id` = ? LIMIT 1 ";
$resRv = $dbF->getRow($sqlRv, array($testId,$revResId));

$q_detail = $functions->getQuestionDetail($resRv['question_id'], $resRv['subjectId']);
$options = json_decode($q_detail['options']);
$chosen_option = $resRv['chosen_option'];
$result_id = $resRv['result_id'];

$optionRadio = '';

foreach ($options as $key => $value) {
$new_index= $key+1;
$selected = ($chosen_option == $new_index) ? 'checked' : '';


$numbers = "";

if($key == 0){

$numbers = "A";

}elseif($key == 1){

$numbers = "B";

}
elseif($key == 2){

$numbers = "C";

}elseif($key == 3){

$numbers = "D";

}

elseif($key == 4){

$numbers = "E";

}


elseif($key == 5){

$numbers = "F";

}



$optionRadio .= '<label>
<input class="indeterminate-checkbox" type="radio" name="option['.$result_id.']" value="'.$new_index.'" '.$selected.'> 
'.$numbers.'.&nbsp;&nbsp;&nbsp;'.$value.' 
</label>';
}

echo '<div class="question_side1">
<!-- <div class="counting">'.$quest_count.'.</div> -->
<div class="question_side_main"> '.$q_detail['question_title'].'</div>
<div class="options_side">
<div class="option_side_line">
'.$optionRadio.'
</div>
</div>
</div><br>';


echo '<div class="button_side">

<div class="button_side_back"> <a href="'.$reviewLink.'">Back to Review</a> </div>

<!-- button_side_back close -->

<input type="submit" name="submitReview" value="Update" class="submit_side button_side_next" style="float:right;"> </div>
<!-- <div class="button_side_next pointer" id="next_question"> <a>Update</a> </div> -->

<!-- button_side_next close -->

</div>';

// echo '</form>';

}else{

?>
<!-- <form action="" method="get" id="form-id"> -->
<?php                 
$quest_count = 1; 
$table = '<table class="tablesorter">
';

$com = "Complete";
foreach ($res as $key => $value) {

$result_id = $value['result_id'];
$chosen_option = $value['chosen_option'];
$question_id = $value['question_id'];
$flag = '';
$comment = '';
if($value['flag'] == 1){
$flag = '<i class="fas fa-flag"></i>';
}

if(!empty($value['comment'])){
$comment = '<span>(Comment: '.$value['comment'].' )<span>';
}

$subject_det  = $functions->getSubject($value['subjectId'], 'subject_title');
$subject_name = $subject_det['subject_title'];

$q_detail = $functions->getQuestionDetail($value['question_id'], $value['subjectId']);
$options = json_decode($q_detail['options']);

$optionRadio = '';


foreach ($options as $key => $value) {
$new_index= $key+1;
$selected = ($chosen_option == $new_index) ? 'checked' : '';

$optionRadio .= '<label>
<input class="indeterminate-checkbox" type="radio" name="option['.$result_id.']" value="'.$new_index.'" '.$selected.'> 
'.$value.' 
</label>';
}


if (!($chosen_option == NULL)) {

$com ='Complete';

}else{

$com ='Incomplete';

}
$questUrl = WEB_URL.'/review.php?test='.$testId.'&rv='.$result_id;



if($quest_count % 2 != 0){

$table .= '
<tr>
<th class="q'.$question_id.' header" data-tbl="'.$question_id.'">
Question '.$quest_count.'<span>'.$com.'</span></th>

';
}else{

$table .= '

<th class="q'.$question_id.' header" data-tbl="'.$question_id.'">
Question '.$quest_count.'<span>'.$com.'</span></th>
</tr>
';}


echo '<div class="question_side1">
        <div class="counting">'.$quest_count.'.</div>
        <div class="question_side_main"> '.$q_detail['question_title'].' '.$flag.'</div>'.$comment.'
        <div class="options_side">
            <div class="option_side_line">
            '.$optionRadio.'
            </div>
        </div>
    </div><br>';

// $questUrl = WEB_URL.'/review.php?test='.$testId.'&rv='.$result_id;
// echo '<div class="question_side1">
// <div class="counting">'.$quest_count.'.</div>
// <div class="question_side_main review"><a href="'.$questUrl.'"> '.$q_detail['question_title'].'</a> '.$flag.'</div><br>'.$comment.'
// </div><br>';


$quest_count++;
}
echo $table .= '</table>';


?>
<div class="button_side">
<!-- <div class="button_side_next"> -->
<!-- <input type="hidden" name="test" value="<?php echo $testId; ?>"> -->
<!-- <input type="submit" id="button" name="finnish" value="END REVIEW" class="submit_side"> </div> -->
<!-- button_side_next close -->
<!-- </div> -->
<!-- button_side close -->
<!-- </form> -->
<?php } ?>
</div>
<!-- question_side close -->
<div class="bottom_bar"></div>
</div>
<!-- page_content close -->
</div>
<!-- content_page_main close -->
</div>
<!-- content_page close -->

<?php
}
?>



<script>
// Set the date we're counting down to
// var countDownDate = new Date("Jan 5, 2019 16:00").getTime();
// var countDownDate = '<?php #echo ($res[0]['end_time'])*1000; ?>';
// console.log(countDownDate);
// // Update the count down every 1 second
// var x = setInterval(function() {
// // Get todays date and time
// var now = new Date().getTime();
// // Find the distance between now and the count down date
// var distance = countDownDate - now;
// console.log(countDownDate+' | '+now+' | '+distance);
// // Time calculations for days, hours, minutes and seconds
// var days = Math.floor(distance / (1000 * 60 * 60 * 24));
// var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
// var hoursmin = Math.floor((hours * 60));
// var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
// var plus = Math.floor(minutes + hoursmin);

// var seconds = Math.floor((distance % (1000 * 60)) / 1000);
// // Output the result in an element with id="timer"
// document.getElementById("timer").innerHTML = plus + "m " + seconds + "s ";
// // If the count down is over, write some text 
// if (distance < 0) {
// clearInterval(x);
// document.getElementById("timer").innerHTML = "Timeout";
// }
// }, 1000);


//     $("#button").click(function(event){
//     if(!confirm ("Finish Paper ?"))
//        event.preventDefault();
// });



// $("#button").on("click",function(e){
// e.preventDefault();
// });




</script>


<script type="text/javascript">

	$("table.tablesorter tr th.header").on("click", function(){

var tbls=  $(this).data("tbl");

$.ajax({
type: "POST",
url: "ajaxfill.php",
data: {table:tbls},
beforeSend: function(){
},
success: function(data){


$(".search_popup").addClass("show_search");
$("."+idis).show();
$("."+idis).html(data);
// console.log(data);
}
});

 $(".search_popup").addClass("show_search");

    alert("The th was clicked."+tbls);
});
// $(function() {


// $("#button").click(function() {
// $(".search_popup").addClass("show_search");
// // exit();
// });

// $(".close_btn").click(function() {
// $(".search_popup").removeClass("show_search");
// });


// $("#no").click(function() {
// $(".search_popup").removeClass("show_search");
// });



// $("#yes").click(function() {
// window.location = "review.php?finnish=END+REVIEW"; 
// });




// var form = document.getElementById("form-id");

// document.getElementById("yes").addEventListener("click", function () {
//   form.submit();
// });


// });
// function flag_question_update(ths){

// result_id = $(ths).data('id');



// $.ajax({

// url: 'ajax_call.php?page=flagQuestionZero',

// type: 'post',

// data: {result_id : result_id}

// }).done(function(res){
// console.log(res);
// if(res == '1'){

// $(ths).html('<i class="fas fa-flag"></i>Done');

// }



// });

// }



</script>

<?php include_once('footer.php'); ?>
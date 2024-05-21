<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}
 
if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Refer a friend',false);
}

?>
<?php

$pMmsg = '';

$contactAllow = TRUE;
if($contactAllow){

$labelClass = "col-sm-3 padding-0";

$divClass = "col-sm-9";

?>
<div class="background_side">
    </div>
<div class="col101 col101_book" style="display:block;position:relative;top:0;">
        <h1>We'd Love Your Feedback</h1><br>
        <!-- <div class="col101_txt">
            See how we can help you Pass your next CQC inspection
        </div>
      
        <h6>COMPANY DETAILS</h6> -->
        <form method="post">
            <?php $functions->setFormToken('feedbackForm'); ?>

                         <input type="hidden" id="g-bookForm" name="g-bookForm">
    <input type="hidden" name="action" value="bookForm">

            <h6>The system is easy to navigate through</h6>

            <div class="col101_btn_main">
            <div class="col1_btn">
                <input id="f1" type="radio" name="form[easy_to_navigate]" value="Strongly Agree">
                <label for="f1">Strongly Agree</label>
            </div>
            <!-- col1_btn close -->
            <div class="col1_btn">
                <input id="f2" type="radio" name="form[easy_to_navigate]" value="Agree">
                <label for="f2">Agree</label>
            </div>
            <!-- col1_btn close -->
            <div class="col1_btn">
                <input id="f3" type="radio" name="form[easy_to_navigate]" value="Neutral">
                <label for="f3">Neutral</label>
            </div>
           <div class="col1_btn">
                <input id="f4" type="radio" name="form[easy_to_navigate]" value="Disagree">
                <label for="f4">Disagree</label>
            </div>
            <div class="col1_btn">
                <input id="f5" type="radio" name="form[easy_to_navigate]" value="Strongly Disagree">
                <label for="f5">Strongly Disagree</label>
            </div>

        </div>

        <h6>Customer Support is readily available, helpful, and efficient</h6>

            <div class="col101_btn_main">
            <div class="col1_btn">
                <input id="f6" type="radio" name="form[customer_support_is_available]" value="Strongly Agree">
                <label for="f6">Strongly Agree</label>
            </div>
            <!-- col1_btn close -->
            <div class="col1_btn">
                <input id="f7" type="radio" name="form[customer_support_is_available]" value="Agree">
                <label for="f7">Agree</label>
            </div>
            <!-- col1_btn close -->
            <div class="col1_btn">
                <input id="f8" type="radio" name="form[customer_support_is_available]" value="Neutral">
                <label for="f8">Neutral</label>
            </div>
           <div class="col1_btn">
                <input id="f9" type="radio" name="form[customer_support_is_available]" value="Disagree">
                <label for="f9">Disagree</label>
            </div>
            <div class="col1_btn">
                <input id="f10" type="radio" name="form[customer_support_is_available]" value="Strongly Disagree">
                <label for="f10">Strongly Disagree</label>
            </div>

        </div>

        <h6>The system makes dental compliance much easier to manage</h6>

            <div class="col101_btn_main">
            <div class="col1_btn">
                <input id="f11" type="radio" name="form[makes_dental_compliance_easier]" value="Strongly Agree">
                <label for="f11">Strongly Agree</label>
            </div>
            <!-- col1_btn close -->
            <div class="col1_btn">
                <input id="f12" type="radio" name="form[makes_dental_compliance_easier]" value="Agree">
                <label for="f12">Agree</label>
            </div>
            <!-- col1_btn close -->
            <div class="col1_btn">
                <input id="f13" type="radio" name="form[makes_dental_compliance_easier]" value="Neutral">
                <label for="f13">Neutral</label>
            </div>
           <div class="col1_btn">
                <input id="f14" type="radio" name="form[makes_dental_compliance_easier]" value="Disagree">
                <label for="f14">Disagree</label>
            </div>
            <div class="col1_btn">
                <input id="f15" type="radio" name="form[makes_dental_compliance_easier]" value="Strongly Disagree">
                <label for="f15">Strongly Disagree</label>
            </div>

        </div>

        <h6>CPD Courses are too a good standard</h6>

            <div class="col101_btn_main">
            <div class="col1_btn">
                <input id="f16" type="radio" name="form[cpd_courses_good_standard]" value="Strongly Agree">
                <label for="f16">Strongly Agree</label>
            </div>
            <!-- col1_btn close -->
            <div class="col1_btn">
                <input id="f17" type="radio" name="form[cpd_courses_good_standard]" value="Agree">
                <label for="f17">Agree</label>
            </div>
            <!-- col1_btn close -->
            <div class="col1_btn">
                <input id="f18" type="radio" name="form[cpd_courses_good_standard]" value="Neutral">
                <label for="f18">Neutral</label>
            </div>
           <div class="col1_btn">
                <input id="f19" type="radio" name="form[cpd_courses_good_standard]" value="Disagree">
                <label for="f19">Disagree</label>
            </div>
            <div class="col1_btn">
                <input id="f20" type="radio" name="form[cpd_courses_good_standard]" value="Strongly Disagree">
                <label for="f20">Strongly Disagree</label>
            </div>

        </div>

        <h6>HR management platform is useful</h6>

            <div class="col101_btn_main">
            <div class="col1_btn">
                <input id="f21" type="radio" name="form[hr_management_is_useful]" value="Strongly Agree">
                <label for="f21">Strongly Agree</label>
            </div>
            <!-- col1_btn close -->
            <div class="col1_btn">
                <input id="f22" type="radio" name="form[hr_management_is_useful]" value="Agree">
                <label for="f22">Agree</label>
            </div>
            <!-- col1_btn close -->
            <div class="col1_btn">
                <input id="f23" type="radio" name="form[hr_management_is_useful]" value="Neutral">
                <label for="f23">Neutral</label>
            </div>
           <div class="col1_btn">
                <input id="f24" type="radio" name="form[hr_management_is_useful]" value="Disagree">
                <label for="f24">Disagree</label>
            </div>
            <div class="col1_btn">
                <input id="f25" type="radio" name="form[hr_management_is_useful]" value="Strongly Disagree">
                <label for="f25">Strongly Disagree</label>
            </div>

        </div>

        <label for="t21" style="    font-size: 1.2rem;
    font-weight: 700;
    margin-top: 2rem;
    float: left;">What features could be added or improved to make the system better for you?</label>
        <div class="text_area1">
                <textarea type="text" placeholder="(Insert comment here)" name="form[comment]" style="    border-radius: 0; height: 10rem; border: 1px solid #656565;" required ></textarea>
            </div>

        <div class="col101_btn_main2">
                      <div id="recaptcha3" class="recaptcha3">
                              <input type="hidden" id="token" name="token">
                                </div>
            <!-- form_input close -->
            <br>
            <div class="col1_btn">
                <button type="submit" name="submit">Submit</button>
            </div>
            <!-- col1_btn close -->
        </div>
        <!-- col101_btn_main2 close -->
        </form>
    </div>
    <!-- col101 close -->
<!-- Referfriend -->

<style type="text/css">.referfriend .form_side h3{

   font-size: 22px;

width: unset;

}
.col101 h6 {
        color: #000;
    text-align: left;
    width: 100%;
    margin: 0rem auto 0;
    padding: 1rem 0;
    font-size: 1.2rem;
    font-weight: 700;
    text-align: left;
}

.col101_btn_main .col1_btn {
    min-width: 18.7% !important;
    margin: 0 !important;
}

.col101_btn_main {
    position: relative;
    width: 100%;
    display: flex;
    justify-content: flex-start;
    gap: 1rem;
    margin-bottom: 2rem;
    margin: 0 auto 1rem;
}


.text_area1 {
    border-radius: 0 !important;
    width: 100%;
    margin: 0;
}


.myevents-div {
    
    max-width: 1150px !important;
    
}

.text_area1{
    position: relative;
    display: inline-block;
    vertical-align: top;
    width: 100%;
    margin: 0% 2%;
    margin-bottom: 25px;
}

.col1_btn label {
  padding: 0 15px !important;
  font-size: 14px !important;
}

.col101_btn_main .col1_btn {
    margin: 0 !important;
}

.col101_btn_main .col1_btn:before {
    background: #03aabe;
}

.referfriend .form_side h2{

   

    width: unset;
   font-size: 16px;
    margin: 0 auto 10px;
    color: #f2701d;
    font-weight: 600;
    
}

/*.col101_btn_main .col1_btn {

    min-width: 130px !important;
}
*/
.col101 {
    width: 95.35% !important;
    
}




@media screen and (max-width: 767px) {
 .referfriend .form-group {
    width: 100%;
    max-width: 100%;

 }

 .referfriend .form_side h3 {
 

    font-size: 20px;
   

}


}
 @media screen and (max-width: 461px){
.referfriend .form_side h3 {
    font-size: 14px;
}}



</style>
<?php
}
?>
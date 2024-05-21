<?php
include("global.php");
$user = intval($_SESSION['webUser']['id']);
$sql="SELECT acc_created FROM `accounts_user`WHERE acc_id='$user'";
$userData = $dbF->getRow($sql);
$acc_created=$userData['acc_created'];
@$acc_created = Date('Y-m-d', strtotime($userData['acc_created']));
// var_dump($acc_created);
$date = Date('Y-m-d');
$currentDate =  date('Y-m-d', strtotime($date));
// var_dump($acc_created>$currentDate);
// if($acc_created>$currentDate){

$sql  = "SELECT * FROM `orders` WHERE `order_user`='$user' AND `product_id` IN (1,14,22,23,24,82,87,89,90,139,157,163)  AND  order_mandate != '' ";
$data =  $dbF->getRows($sql);
// var_dump($data);
$productId=$data[0]['product_id'];
 $sql="SELECT * FROM term_and_condition WHERE status=1 AND productId='$productId'  ORDER BY Id DESC LIMIT 1";
           $data = $dbF->getRow($sql);
            $term="";
            if($_SESSION['currentUserType']=='Master'){
                $term=translateFromSerialize($data['master_term']);
            }elseif ($_SESSION['currentUserType']=='Employee') {
                $term=translateFromSerialize($data['employee_term']);
            }elseif ($_SESSION['currentUserType']=='Practice') {
                $term=translateFromSerialize($data['practice_term']);
            }else{
                $term="";
            }
            $date = Date('Y-m-d');
            $currentDate =  date('Y-m-d', strtotime($date));
            $user = intval($_SESSION['currentUser']);
            $userType = $_SESSION['currentUserType'];
if($term!=""){
?>
<div class="background_side" style="display:block"></div>
<!--<div class="new-popup helloween">-->
<div class="terms new-popup">
    <form method="post" autocomplete="off">
    <?php $functions->setFormToken('termAndConditionForm'); ?>
        <input type="hidden" name="action" value="termAndConditionForm">
        <input type="hidden" name="Uid" value="<?php echo $user?>">
        <input type="hidden" name="uType" value="<?php echo $userType?>">
        <input type="hidden" name="termId" value="<?php echo $data['id']?>">

            <div class='terms-image'>
                <img src="https://smartdentalcompliance.com/webImages/new-logo.png" style="
    display: inline;
    width: 200px;
    margin: 0;
">
            </div>
            <div class='terms-heading'>
                Terms And Condition
            </div>
                
               <div class='terms-desc'>
                <?php echo $term?>
               
                </div>
                <div class='terms-date'>
                <input type="hidden" name="dateSign" value="<?php echo $currentDate?>">
                </div>

                

                  <div id="recaptcha3" class="recaptcha3">
                              <input type="hidden" id="token" name="token">
                                </div>
           
          
                <div class="popup-footer terms-foot">
                    
                    <!-- <button type="button" class="cancle" onclick="close_newpopup()">Cancel</button> -->
                    <button type="submit" class="submit transition_7" >I Agree</button>
                </div>
 
    
    </form>
    <!--<div class="new-popup-bottom">-->
    <!--    www.smartdentalcompliance.com | 0800 689 1061-->
    <!--</div>-->
</div>
<?php  } ?>
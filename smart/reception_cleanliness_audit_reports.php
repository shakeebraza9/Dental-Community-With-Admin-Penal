<?php 
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
 
include_once('header.php'); 


include'dashboardheader.php';
$receptionscore = 0;
$receptionTotal = 51;
$receptionarray = array();
$receptionValue = '';
$tempReceptionData=array();
$ReceptionData=array();
 foreach ($_POST['reception'] as $key => $value) {
  $_comment =   $_POST['form'][$key.'_comment'];
  $_question =   $_POST['form'][$key.'_question'];
   if ($value == 'yes') {
        $receptionValue .=$_comment;
        $receptionscore++;
    }else{
        $receptionValue .=$value;
        $receptionValue .=$_comment;
        $receptionarray[]=$value;
    }
    $tempReceptionData=array($key=>array('value'=>$value,'comment'=>$_comment,'question'=>$_question));
    $ReceptionData=array_merge($ReceptionData,$tempReceptionData);
}



$Rcleanlines= array('reception' =>array('receptionscore'=>$receptionscore,'data'=>$ReceptionData),
);
$allHTML=json_encode($Rcleanlines);


?>
 <form method="post" action="" enctype="multipart/form-data">     
  <?php $functions->setFormToken('cleanlinesform'); ?>
<input type="hidden" name="name_of_practice" value="<?php echo $_POST['form']['name-of-practice'] ?>">
<input type="hidden" name="name_of_practice_manager" value="<?php echo $_POST['form']['name-of-practice-manager'] ?>">        
<input type="hidden" name="name_of_complianc_champion" value="<?php echo $_POST['form']['audit_carried_out_by'] ?>">        
<input type="hidden" name="date_audit" value="<?php echo $_POST['form']['Date'] ?>">     
<input type="hidden" name="location" value="<?php echo $_POST['form']['cleanliness_type'] ?>">      
<input type="hidden" name="total_score" value="<?php echo  abs($receptionscore)  ?>">                    


<input type="hidden" name="allHTML" value='<?php echo json_encode($Rcleanlines); ?>'>        

  <!-- <input class="submit_class" type="submit" value="submit"> -->

                     </form> 
<?php 
 
 if(isset($_POST['form']['name-of-practice'])){
            $totla = $receptionscore;
            $name_of_practice     = empty($_POST['form']['name-of-practice'])       ? ""  : $_POST['form']['name-of-practice'];
            $name_of_practice_manager     = empty($_POST['form']['name-of-practice-manager'])       ? ""  : $_POST['form']['name-of-practice-manager'];
			$audit_carried_out_by     = empty($_POST['form']['audit_carried_out_by'])       ? ""  : $_POST['form']['audit_carried_out_by'];
            
            $date     = empty( $_POST['form']['Date'])       ? ""  :  $_POST['form']['Date'];
            $cleanliness_type     = empty($_POST['form']['cleanliness_type'])       ? ""  : $_POST['form']['cleanliness_type'];
            $pid     = empty($_POST['pid'])       ? ""  : $_POST['pid'];
            $oldid     = empty($_POST['old_id'])       ? ""  : $_POST['old_id'];
            $allHTML=json_encode($Rcleanlines);
var_dump($oldid);


              $dbF->setRow("DELETE FROM `mock_inspection_report` WHERE `id`= ? ",array($oldid));
           $sql= "INSERT INTO `cleanliness_audit` (
                `pid`,
                `name_of_practice`, 
                `name_of_practice_manager`, 
                `audit_conduct_by`, 
                `date`, 
                `all_html`, 
                `cleanliness_type`, 
                `total_score`)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $array   = array(
                	$pid,
                    $name_of_practice,
                    $name_of_practice_manager,
                    $audit_carried_out_by,
                    $date,
                    $allHTML,
                    $cleanliness_type,
                    $totla
                );

                $dbF->setRow($sql,$array);
               $lastId = $dbF->rowLastId;
                
          

        } // If end

 ?>

 
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            Cleanliness Form
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'reportIssue'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        
        <div class="right_side mockpage cleanliness">

         <?php
         @$id =  $_GET['allhtml'];
           $sql  = "SELECT * FROM cleanliness_audit WHERE id = '$id'";
           $data = $dbF->getRow($sql);
           $pid=$data['pid'];
          $htmldata=json_decode($data['all_html'],true); 
         if (!empty($data)) {
            if(is_array($htmldata)){

$receptionValue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';

                foreach ($htmldata as $key1 => $value1) {
   //sa           

                   // var_dump($key1,$value1['data']);
                   foreach ($value1['data'] as $key2 => $value2) {

                    // var_dump($key2,$value2['value']);
                      # code...

 // $safevalue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';
 if($key1=='reception') {
  $_comment =   $value2['comment'];
  $value=$value2['value'];
  $_question =$value2['question'];
    $receptionValue .='<tr style="border-bottom: 2px solid #80808036;"><td><div class="row-title">'.$_question .'</div><div class="row-icons"></div></td>';
   if ($value == 'yes') {  
        $receptionValue .='<td style="color: green;">Yes</td><td></td><td><div class="row-title">'.$_comment .'</div><div class="row-icons"></div></td>';
    $receptionscore++;
    }else{
        if($value=="N/A"){
            $receptionValue .='<td style="color: red;">N/A</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
            $receptionTotal--;
        }else{
    $receptionValue .='<td style="color: red;">No</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
    }
    $receptionValue .='<td><div class="row-title">'.$_comment.'</div><div class="row-icons"></div></td>';
    $receptionarray[]=$value;
    }
    $receptionValue .='</tr>';
}
                    }       
                }
                $preception=(round(($receptionscore/$receptionTotal)*100));
            if($preception<=50){
                $rcolor='red';
            }elseif($preception>50 && $preception<=90){
                $rcolor='blue';
            }
            else{
                $rcolor='green';
            }
    $dlink='';
	if($preception<=75){
	$star='
	<div class="cleanliness-star">
	<i class="fa fa-star cleanliness-checked"></i>
	<i class="fa fa-star" ></i>
	<i class="fa fa-star" ></i>
	<i class="fa fa-star" ></i>
	<i class="fa fa-star" ></i>
	</div>';
	$dlink='https://smartdentalcompliance.com/uploads/files/Cleanliness/Posters/1_Star_Rating_Poster.pdf';
}elseif($preception>=76 && $preception<=78){
	$star='
	<div class="cleanliness-star">
	<i class="fa fa-star cleanliness-checked"></i>
	<i class="fa fa-star cleanliness-checked"></i>
	<i class="fa fa-star" ></i>
	<i class="fa fa-star" ></i>
	<i class="fa fa-star" ></i>
	</div>';
	$dlink='https://smartdentalcompliance.com/uploads/files/Cleanliness/Posters/2_Star_Rating_Poster.pdf';

}elseif($preception>=79 && $preception<=81){
	$star='
	<div class="cleanliness-star">
	<i class="fa fa-star cleanliness-checked"></i>
	<i class="fa fa-star cleanliness-checked"></i>
	<i class="fa fa-star cleanliness-checked"></i>
	<i class="fa fa-star" ></i>
	<i class="fa fa-star" ></i>
	</div>';
	$dlink='https://smartdentalcompliance.com/uploads/files/Cleanliness/Posters/3_Star_Rating_Poster.pdf';
}
elseif($preception>=82 && $preception<=84){
	$star='
	<div class="cleanliness-star">
	<i class="fa fa-star cleanliness-checked"></i>
	<i class="fa fa-star cleanliness-checked"></i>
	<i class="fa fa-star cleanliness-checked"></i>
	<i class="fa fa-star cleanliness-checked"></i>
	<i class="fa fa-star" ></i>
	</div>'; 
	$dlink='https://smartdentalcompliance.com/uploads/files/Cleanliness/Posters/4_Star_Rating_Poster.pdf';
}else{
	$star='
	<div class="cleanliness-star">
	<i class="fa fa-star cleanliness-checked" ></i>
	<i class="fa fa-star cleanliness-checked" ></i>
	<i class="fa fa-star cleanliness-checked" ></i>
	<i class="fa fa-star cleanliness-checked" ></i>
	<i class="fa fa-star cleanliness-checked" ></i>
	</div>';
	$dlink='https://smartdentalcompliance.com/uploads/files/Cleanliness/Posters/5_Star_Rating_Poster.pdf';
}   
$downLink=base64_encode($dlink.":s:".date('d'));  
$dlink="https://smartdentalcompliance.com/d?f=".$downLink;
 echo $allHTML = ' 
          <div class="allHTML_">
            <div class="jumbo ins_report">
                 <h3><span>Reception Cleanliness Audit Report</span></h3>                  
        </div>
        </div>
        <h3 style="padding: 30px 30px 30px;font-weight: 800; text-align: center;">You Have Scored</h3> 
        	'.$star.'
        	
                <div class="pie_disply">

                                  
                                    <div class=" col3_left_main2_left '.$rcolor.'">
                                        <div class="box-piesite">
                                            <ul>
                                             
                                                <li class="design">
                                                    <div class="piesite" id="pie_0" data-pie="'.(int)$preception.'" style="cursor:pointer;"><div class="percent"><span class="int">0</span><span class="symbol">%</span></div><div id="slice"><div class="pie"></div></div></div>
                                                </li>
                                                <li class="center">
                                                  
                                                </li>
                                            </ul>
                                          
                                        </div>
                                        <!-- box-piesite close -->
                                    </div>

                                 
                                    <!-- col3_left_main2_right close -->
                                   
                                </div>      
            <div class="form-group">

            <br>  
           	<div class="cleanliness-star">Download Poster <a class="" href="'.$dlink.'" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download" style="color: #005bb2"></i></a>
           	</div> 

                <div class="mockInspectionReport">
              
              
                <!--==================Responsive=====================  -->
 
                    <!--===========Responsive==========End==================  -->
 </div>
        </div>
        </div>
         
        <!-- right_side close -->';







            }
            else{
           echo $data['all_html'];}
       // json_decode($data['all_html']);
         }elseif(isset($_POST['save'])=='save'){

           // $pid=$data['pid'];
           //  if($_SESSION['currentUser']==$pid){
                header('Location: mock_inspection?editId='.$lastId);}
         else {
         header('Location: reception_cleanliness_audit_reports?allhtml='.$lastId);
          }

           ?>
      

   </div>
    <!-- left_right_side -->


<?php include_once('footer.php'); ?>
<?php 
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
 
include_once('header.php'); 


include'dashboardheader.php';

// echo "<pre>";
// var_dump($_POST['safe']);
// echo "</pre>";
$chk4 = $functions->mockInspectionSubmit();

$surgeriesscore = 0;

$surgeriesTotal = 30;

$surgeriesarray = array();

$surgeriesValue = '';

$tempSurgeriesData=array();
$SurgeriesData=array();
var_dump($_POST['surgeries']);
 foreach ($_POST['surgeries'] as $key => $value) {
  $_comment =   $_POST['form'][$key.'_comment'];
  $_question =   $_POST['form'][$key.'_question'];
  $_main_question=$_POST['form'][$key.'_main_question'];
   if ($value == 'yes') {
        $surgeriesValue .=$_comment;
        $surgeriesscore++;
    }else{
        $surgeriesValue .=$value;
        $surgeriesValue .=$_comment;
        $surgeriesarray[]=$value;
    }
    $tempSurgeriesData=array($key=>array('value'=>$value,'comment'=>$_comment,'question'=>$_question,'main_question'=>$_main_question));
    // $safeData[]=array('key'=>$key,'value'=>$value,'comment'=>$_comment);
    
    $SurgeriesData=array_merge($SurgeriesData,$tempSurgeriesData);
}

$surgeries_cleanlines= array('surgeries' =>array('surgeriesscore'=>$surgeriesscore,'data'=>$SurgeriesData),
);
$allHTML=json_encode($surgeries_cleanlines);

// print_r($allHTML);
// exit();
?>
<form method="post" action="" enctype="multipart/form-data">     
  <?php $functions->setFormToken('cleanlinesform'); ?>
<input type="hidden" name="name_of_practice" value="<?php echo $_POST['form']['name-of-practice'] ?>">
<input type="hidden" name="name_of_practice_manager" value="<?php echo $_POST['form']['name-of-practice-manager'] ?>">        
<input type="hidden" name="name_of_complianc_champion" value="<?php echo $_POST['form']['audit_carried_out_by'] ?>">        
<input type="hidden" name="date_audit" value="<?php echo $_POST['form']['Date'] ?>">     
<input type="hidden" name="location" value="<?php echo $_POST['form']['cleanliness_type'] ?>">      
<input type="hidden" name="total_score" value="<?php echo  abs($surgeriesscore)  ?>">                    


<input type="hidden" name="allHTML" value='<?php echo json_encode($surgeries_cleanlines); ?>'>        

  <!-- <input class="submit_class" type="submit" value="submit"> -->

                     </form> 
<?php 
 
 if(isset($_POST['form']['name-of-practice'])){
            $totla = $surgeriesscore;
            $name_of_practice     = empty($_POST['form']['name-of-practice'])       ? ""  : $_POST['form']['name-of-practice'];
            $name_of_practice_manager     = empty($_POST['form']['name-of-practice-manager'])       ? ""  : $_POST['form']['name-of-practice-manager'];
            $audit_carried_out_by     = empty($_POST['form']['audit_carried_out_by'])       ? ""  : $_POST['form']['audit_carried_out_by'];
            
            $date     = empty( $_POST['form']['Date'])       ? ""  :  $_POST['form']['Date'];
            $cleanliness_type     = empty($_POST['form']['cleanliness_type'])       ? ""  : $_POST['form']['cleanliness_type'];
            $pid     = empty($_POST['pid'])       ? ""  : $_POST['pid'];
            $oldid     = empty($_POST['old_id'])       ? ""  : $_POST['old_id'];
            $allHTML=json_encode($surgeries_cleanlines);
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


$surgeriesValue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';

                foreach ($htmldata as $key1 => $value1) {
   //sa           

                   foreach ($value1['data'] as $key2 => $value2) {

 if($key1=='surgeries') {
  $_comment =   $value2['comment'];
  $value=$value2['value'];
  $_question =$value2['question'];
  $m_question =$value2['main_question'];
  if($m_question!=""){
  $surgeriesValue .='<tr style="border-bottom: 2px solid #80808036;"><td><div class="row-title"><b>Q. '.$m_question .'</b></div><div class="row-icons"></div></td>';}
    $surgeriesValue .='<tr style="border-bottom: 2px solid #80808036;"><td><div class="row-title">'.$_question .'</div><div class="row-icons"></div></td>';
   if ($value == 'yes') {  
        $surgeriesValue .='<td style="color: green;">Yes</td><td></td><td><div class="row-title">'.$_comment .'</div><div class="row-icons"></div></td>';
    $surgeriesscore++;
    }else{
        if($value=="N/A"){
            $surgeriesvalue .='<td style="color: red;">N/A</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
            $surgeriesTotal--;
        }else{
    $surgeriesValue .='<td style="color: red;">No</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
    }
    $surgeriesValue .='<td><div class="row-title">'.$_comment.'</div><div class="row-icons"></div></td>';
    $surgeriesarray[]=$value;
    }
    $surgeriesValue .='</tr>';
}

                    }       
                }
                $psurgeries=(round(($surgeriesscore/$surgeriesTotal)*100));
            
            if($psurgeries<=50){
                $scolor='red';
            }elseif($psurgeries>50 && $psurgeries<=90){
                $scolor='blue';
            }
            else{
                $scolor='green';
            }
             $dlink='';
    if($psurgeries<=85){
    $star='
    <div class="cleanliness-star">
    <i class="fa fa-star cleanliness-checked"></i>
    <i class="fa fa-star" ></i>
    <i class="fa fa-star" ></i>
    <i class="fa fa-star" ></i>
    <i class="fa fa-star" ></i>
    </div>';
    $dlink='https://smartdentalcompliance.com/uploads/files/Cleanliness/Posters/1_Star_Rating_Poster.pdf';
}elseif($psurgeries>=86 && $psurgeries<=88){
    $star='
    <div class="cleanliness-star">
    <i class="fa fa-star cleanliness-checked"></i>
    <i class="fa fa-star cleanliness-checked"></i>
    <i class="fa fa-star" ></i>
    <i class="fa fa-star" ></i>
    <i class="fa fa-star" ></i>
    </div>';
    $dlink='https://smartdentalcompliance.com/uploads/files/Cleanliness/Posters/2_Star_Rating_Poster.pdf';

}elseif($psurgeries>=89 && $psurgeries<=91){
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
elseif($psurgeries>=92 && $psurgeries<=94){
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
         <h3><span>Surgeries Cleanliness Audit Report</span></h3>  
       
        </div>
        </div>
        <h3 style="padding: 30px 30px 30px;font-weight: 800; text-align: center;">
        You have Scored</h3> 
              '.$star.'
                <!-- jumbo -->

                <div class="pie_disply">

                                  
                                    <div class=" col3_left_main2_left '.$scolor.'">
                                        <div class="box-piesite">
                                            <ul>
                                             
                                                <li class="design">
                                                    <div class="piesite" id="pie_0" data-pie="'.(int)$psurgeries.'" style="cursor:pointer;"><div class="percent"><span class="int">0</span><span class="symbol">%</span></div><div id="slice"><div class="pie"></div></div></div>
                                                </li>
                                                <li class="center">
                                                   <b>Surgeries</b>
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
         header('Location: surgeries_cleanliness_audit_report?allhtml='.$lastId);
          }

           ?>
      

   </div>
    <!-- left_right_side -->


<?php include_once('footer.php'); ?>
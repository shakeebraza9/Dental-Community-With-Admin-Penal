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
// var_dump($chk4);

$safescore = 0;
$effectivescore = 0;
$responsivescore = 0;
$wellledscore = 0;
$caringscore = 0;

$safeTotal=69;
$effectiveTotal=13;
$wellledTotal=8;
$caringTotal=3;
$responsiveTotal=4;


$safesarray =  array();
$effectivearray =  array();
$responsivearray =  array();
$wellledarray =  array();
$caringarray =  array();


$safevalue  = '';
$effectivevalue= '';
$wellledvalue = '';
$responsivevalue = '';
$caringvalue = '';

$tempSafeData=array();
$safeData=array();
 foreach ($_POST['safe'] as $key => $value) {
  $_comment =   $_POST['form'][$key.'_comment'];
  $_question =   $_POST['form'][$key.'_question'];
   if ($value == 'yes') {
        $safevalue .=$_comment;
        $safescore++;
    }else{
        $safevalue .=$value;
        $safevalue .=$_comment;
        $safesarray[]=$value;
    }
    $tempSafeData=array($key=>array('value'=>$value,'comment'=>$_comment,'question'=>$_question));
    // $safeData[]=array('key'=>$key,'value'=>$value,'comment'=>$_comment);
    
    $safeData=array_merge($safeData,$tempSafeData);
}
$tempEffectiveData=array();
$effectiveData=array();
 foreach ($_POST['effective'] as $key => $value) {
    $_comment =   $_POST['form'][$key.'_comment'];
    $_question =   $_POST['form'][$key.'_question'];
   if ($value == 'yes') { 
    $effectivevalue .=$_comment;
    $effectivescore++;}else{
        $effectivevalue .=$value;
        $effectivevalue .=$_comment;
        $effectivearray[]=$value;
    }
    $tempEffectiveData=array($key=>array('value'=>$value,'comment'=>$_comment,'question'=>$_question));
    $effectiveData=array_merge($effectiveData,$tempEffectiveData);
    // $effectiveData[]=array('key'=>$key,'value'=>$value,'comment'=>$_comment);
}
$tempWellledData=array();
$wellledData=array();
 foreach ($_POST['wellled'] as $key => $value) {
    $_comment =   $_POST['form'][$key.'_comment'];
    $_question =   $_POST['form'][$key.'_question'];
   if ($value == 'yes') {
        $wellledvalue .=$_comment;
        $wellledscore++;}else{
            $wellledvalue .=$value;
            $wellledvalue .=$_comment;
            $wellledarray[]=$value;
}
    $tempWellledData=array($key=>array('value'=>$value,'comment'=>$_comment,'question'=>$_question));
    $wellledData=array_merge($wellledData,$tempWellledData);
    // $wellledData[]=array('key'=>$key,'value'=>$value,'comment'=>$_comment);
}
$tempCaringData=array();
$caringData=array();
foreach ($_POST['caring'] as $key => $value) {
  $_comment =   $_POST['form'][$key.'_comment'];
  $_question =   $_POST['form'][$key.'_question'];
   if ($value == 'yes') { 
        $caringvalue .=$_comment; 
        $caringscore++;}else{
        $caringvalue .=$value;
        $caringvalue .=$_comment; 
        $caringarray[]=$value;
    }
    $tempCaringData=array($key=>array('value'=>$value,'comment'=>$_comment,'question'=>$_question));
    $caringData=array_merge($caringData,$tempCaringData);
    // $caringData[]=array('key'=>$key,'value'=>$value,'comment'=>$_comment);
}
$tempResponsiveData=array();
$responsiveData=array();
foreach ($_POST['responsive'] as $key => $value) {
    $_comment =   $_POST['form'][$key.'_comment'];
    $_question =   $_POST['form'][$key.'_question'];
    if ($value == 'yes') {
        $responsivevalue .=$_comment ;
        $responsivescore++;}else{
            $responsivevalue .= $value;
            $responsivevalue .=$_comment;
            $responsivearray[]=$value;
}
$tempResponsiveData=array($key=>array('value'=>$value,'comment'=>$_comment,'question'=>$_question));
$responsiveData=array_merge($responsiveData,$tempResponsiveData);
// $responsiveData[]=array('key'=>$key,'value'=>$value,'comment'=>$_comment);
}
$mock= array('safe' =>array('safescore'=>$safescore,'data'=>$safeData),
            'effective'=> array('effectivescore' => $effectivescore,'data'=>$effectiveData),
            'wellled'=> array('wellledscore' => $wellledscore,'data'=>$wellledData),
            'caring'=> array('caringscore' => $caringscore,'data'=>$caringData),
            'responsive'=> array('responsivescore' => $responsivescore,'data'=>$responsiveData)
 );
$allHTML=json_encode($mock);

?>
 <form method="post" action="" enctype="multipart/form-data">     
                <?php $functions->setFormToken('mockInspection'); ?>
<input type="hidden" name="name_of_practice" value="<?php echo $_POST['form']['name-of-practice'] ?>">
<input type="hidden" name="name_of_practice_manager" value="<?php echo $_POST['form']['name-of-practice-manager'] ?>">        
<input type="hidden" name="name_of_complianc_champion" value="<?php echo $_POST['form']['name-of-complianc-champion'] ?>">        
<input type="hidden" name="date_audit" value="<?php echo $_POST['form']['Date-Audit'] ?>">     
<input type="hidden" name="location" value="<?php echo $_POST['form']['location'] ?>">      
<input type="hidden" name="practice_contact" value="<?php echo $_POST['form']['practice-contact'] ?>">        
<input type="hidden" name="email" value="<?php echo $_POST['form']['email'] ?>">        
<input type="hidden" name="detail" value="<?php echo $_POST['form']['Detail'] ?>"> 
<input type="hidden" name="total_score" value="<?php echo  abs($safescore + $effectivescore + $wellledscore + $caringscore + $responsivescore)  ?>"> 
                      


<input type="hidden" name="allHTML" value='<?php echo json_encode($mock); ?>'>        

  <!-- <input class="submit_class" type="submit" value="submit"> -->

                     </form> 
<?php 
 
 if(isset($_POST['form']['name-of-practice'])){
            $totla = $safescore + $effectivescore + $wellledscore + $caringscore + $responsivescore;
            $name_of_practice     = empty($_POST['form']['name-of-practice'])       ? ""  : $_POST['form']['name-of-practice'];

            $name_of_practice_manager     = empty($_POST['form']['name-of-practice-manager'])       ? ""  : $_POST['form']['name-of-practice-manager'];

            $name_of_complianc_champion     = empty($_POST['form']['name-of-complianc-champion'])       ? ""  : $_POST['form']['name-of-complianc-champion'];
            
            $date_audit     = empty( $_POST['form']['Date-Audit'])       ? ""  :  $_POST['form']['Date-Audit'];
            $location     = empty($_POST['form']['location'])       ? ""  : $_POST['form']['location'];
            $practice_contact     = empty($_POST['form']['practice-contact'])       ? ""  : $_POST['form']['practice-contact'];
            $email     = empty($_POST['form']['email'])       ? ""  : $_POST['form']['email'];
            $detail     = empty($_POST['form']['Detail'])       ? ""  : $_POST['form']['Detail'];
            $pid     = empty($_POST['pid'])       ? ""  : $_POST['pid'];
            $oldid     = empty($_POST['old_id'])       ? ""  : $_POST['old_id'];
            $allHTML=json_encode($mock);
var_dump($oldid);
// var_dump($safescore,
// $effectivescore,
// $responsivescore,
// $wellledscore,
// $caringscore,
// $safesarray,
// $effectivearray,
// $responsivearray,
// $wellledarray,
// $caringarray,
// $safevalue  ,
// $effectivevalue,
// $wellledvalue ,
// $responsivevalue ,
// $caringvalue);

              $dbF->setRow("DELETE FROM `mock_inspection_report` WHERE `id`= ? ",array($oldid));
                $sql  = "INSERT INTO `mock_inspection_report`(
                 `name_of_practice`,
                 `name_of_practice_manager`,
                 `name_of_complianc_champion`,
                 `date_audit`,
                 `location`,
                 `practice_contact`,
                 `email`,
                 `detail`,
                 `all_html`,
                 `pid`,
                `total_score`)
                
                 VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                $array   = array(
                    $name_of_practice,
                    $name_of_practice_manager,
                    $name_of_complianc_champion,
                    $date_audit,
                    $location,
                    $practice_contact,
                    $email,
                    $detail,
                    $allHTML,
                    $pid,
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
            Mock Inspection Form
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'reportIssue'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        
        <div class="right_side mockpage">

         <?php
         @$id =  $_GET['allhtml'];
           $sql  = "SELECT * FROM mock_inspection_report WHERE id = '$id'";
           $data = $dbF->getRow($sql);
           $pid=$data['pid'];
          $htmldata=json_decode($data['all_html'],true); 
         if (!empty($data)) {
            if(is_array($htmldata)){
                // echo "heel0";
                // var_dump($htmldata);

$safevalue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';
$effectivevalue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';
$wellledvalue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';
$caringvalue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';
$responsivevalue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';
                foreach ($htmldata as $key1 => $value1) {
   //sa           

                   // var_dump($key1,$value1['data']);
                   foreach ($value1['data'] as $key2 => $value2) {

                    // var_dump($key2,$value2['value']);
                      # code...

 // $safevalue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';
 if($key1=='safe') {
  $_comment =   $value2['comment'];
  $value=$value2['value'];
  $_question =$value2['question'];
    $safevalue .='<tr style="border-bottom: 2px solid #80808036;"><td><div class="row-title">'.$_question .'</div><div class="row-icons"></div></td>';
   if ($value == 'yes') {  
        $safevalue .='<td style="color: green;">Yes</td><td></td><td><div class="row-title">'.$_comment .'</div><div class="row-icons"></div></td>';
    $safescore++;
    }else{
        if($value=="N/A"){
            $safevalue .='<td style="color: red;">N/A</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
            $safeTotal--;
        }else{
    $safevalue .='<td style="color: red;">No</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
    }
    $safevalue .='<td><div class="row-title">'.$_comment.'</div><div class="row-icons"></div></td>';
    $safesarray[]=$value;
    }
    $safevalue .='</tr>';
}
// $effectivevalue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';
 if($key1=='effective') {
    $_comment =   $value2['comment'];
    $value=$value2['value'];
     $_question =$value2['question'];
    $effectivevalue .='<tr style="border-bottom: 2px solid #80808036;"><td><div class="row-title">'.$_question .'</div><div class="row-icons"></div></td>';
   if ($value == 'yes') { 
    $effectivevalue .='<td style="color: green;">Yes</td><td></td><td><div class="row-title">'.$_comment .'</div><div class="row-icons"></div></td>';
    $effectivescore++;}else{
        if($value=="N/A"){
            $effectiveTotal--;
    $effectivevalue .='<td style="color: red;">N/A</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
}else{
    $effectivevalue .='<td style="color: red;">No</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
}
$effectivevalue .='<td><div class="row-title">'.$_comment.'</div><div class="row-icons"></div></td>';
$effectivearray[]=$value;
}
$effectivevalue .='</tr>';
}
// $wellledvalue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';
  if($key1=='wellled') {
    $_comment =   $value2['comment'];
    $value=$value2['value'];

      $_question =$value2['question'];
    $wellledvalue .='<tr style="border-bottom: 2px solid #80808036;"><td><div class="row-title">'.$_question .'</div><div class="row-icons"></div></td>';

   if ($value == 'yes') {
    $wellledvalue .='<td style="color: green;">Yes</td><td></td><td><div class="row-title">'.$_comment .'</div><div class="row-icons"></div></td>';
   $wellledscore++;}else{
if($value=="N/A"){
    $wellledTotal--;
$wellledvalue .='<td style="color: red;">N/A</td><td><div class="row-title" ">'.$value.'</div><div class="row-icons"></div></td>';
}else{
$wellledvalue .='<td style="color: red;">No</td><td><div class="row-title" ">'.$value.'</div><div class="row-icons"></div></td>';
}

$wellledvalue .='<td><div class="row-title">'.$_comment.'</div><div class="row-icons"></div></td>';
$wellledarray[]=$value;
}
$wellledvalue .='</tr>';
}
// $caringvalue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';
if($key1=='caring') {
    $_comment =   $value2['comment'];
    $value=$value2['value'];
   $_question =$value2['question'];
    $caringvalue .='<tr style="border-bottom: 2px solid #80808036;"><td><div class="row-title">'.$_question .'</div><div class="row-icons"></div></td>';  
   if ($value == 'yes') { 
    $caringvalue .='<td style="color: green;">Yes</td><td></td><td><div class="row-title">'.$_comment .'</div><div class="row-icons"></div></td>';
     $caringscore++;}else{
if($value=="N/A"){
    $caringTotal--;
$caringvalue .='<td style="color: red;">N/A</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
}else{
$caringvalue .='<td style="color: red;">No</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
}
$caringvalue .='<td><div class="row-title">'.$_comment.'</div><div class="row-icons"></div></td>';
$caringarray[]=$value;
}
$caringvalue .='</tr>';
}
// $responsivevalue .='<tr style="border-bottom: 2px solid #80808036;"><th>Question</th><th>Status</th><th>Comment</th><th>User Comment</th></tr>';
 if($key1=='responsive') {
    $_comment =   $value2['comment'];
    $value=$value2['value'];
    $_question =$value2['question'];
    $responsivevalue .='<tr style="border-bottom: 2px solid #80808036;"><td><div class="row-title">'.$_question .'</div><div class="row-icons"></div></td>';
   if ($value == 'yes') {
    $responsivevalue .='<td style="color: green;">Yes</td><td></td><td><div class="row-title">'.$_comment.'</div><div class="row-icons"></div></td>';
     $responsivescore++;}else{
    if($value=="N/A"){
        $responsiveTotal--;
        $responsivevalue .='<td  style="color: red;"">N/A</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
    }else
    {
     $responsivevalue .='<td  style="color: red;"">No</td><td><div class="row-title">'.$value.'</div><div class="row-icons"></div></td>';
    }
    $responsivevalue .='<td><div class="row-title">'.$_comment.'</div><div class="row-icons"></div></td>';
   $responsivearray[]=$value;
}

$responsivevalue .='</tr>';
}







                    }       
                }
                $psafe=(round(($safescore/$safeTotal)*100));
            $peffective=(round(($effectivescore/$effectiveTotal)*100));
            $pwellled=(round(($wellledscore/$wellledTotal)*100));
            $pcaring=(round(($caringscore/$caringTotal)*100));
            $presponsive=(round(($responsivescore/$responsiveTotal)*100));
            
            if($psafe<=50){
                $scolor='red';
            }elseif($psafe>50 && $psafe<=90){
                $scolor='blue';
            }
            else{
                $scolor='green';
            }
            if($peffective<=50){
                $ecolor='red';
            }elseif($peffective>50 && $peffective<=90){
                $ecolor='blue';
            }
            else{
                $ecolor='green';
            }
            if($pwellled<=50){
                $wcolor='red';
            }elseif($pwellled>50 && $pwellled<=90){
                $wcolor='blue';
            }
            else{
                $wcolor='green';
            }
            if($pcaring<=50){
                $ccolor='red';
            }elseif($pcaring>50 && $pcaring<=90){
                $ccolor='blue';
            }
            else{
                $ccolor='green';
            }
            if($presponsive<=50){
                $rcolor='red';
            }elseif($presponsive>50 && $presponsive<=90){
                $rcolor='blue';
            }
            else{
                $rcolor='green';
            }
 echo $allHTML = ' 
          <div class="allHTML_">
            <div class="jumbo ins_report">
                    <h3><span>'.$data['name_of_practice_manager'].' <br></span>'. $data['name_of_practice'].'</h3>
                 <h3><span>Inspection Report</span></h3>
  
             <ul style="list-style: none;">

                
        <li>Compliance Champion:<span><strong>'. $data['name_of_complianc_champion'].'</strong></span></li>
       
        <li>Location:<span><strong>'. $data['location'] .'</strong></span></li>
        
        <li>Contact Number:<span> <strong>'. $data['practice_contact'] .'</strong></span></li>
        
         <li>Email:<span><strong> '. $data['email'] .'</strong></span></li>
         <li>Detail:<span><strong> '.$data['detail'] .'</strong></span></li>
               
        </ul>
        <div class="ins_report_span" style="width: 75%;">
        <span>Date of inspection visit:<strong>&nbsp;&nbsp;'. date('d-M-Y',strtotime($data['date_audit'])).'</strong></span>
        <br>
       
        </div>
        </div>
        <h3 style="padding: 30px 30px 30px;font-weight: 800; text-align: center;">Overall Compliance Score <span style="color: red">                           '. round((abs($safescore + $effectivescore + $wellledscore + $caringscore + $responsivescore)/97)*100) .' %</span></h3> 
              
                <!-- jumbo -->

                <div class="pie_disply">

                                    <div class=" col3_left_main2_left '.$scolor.'">
                                        <div class="box-piesite">
                    
                                            <ul>
                                             
                                                <li class="design">
                                                    <div class="piesite" id="pie_0" data-pie="'.(int)$psafe.'" style="cursor:pointer;"><div class="percent"><span class="int">0</span><span class="symbol">%</span></div><div id="slice"><div class="pie"></div></div></div>
                                                </li>
                                                <li class="center">
                                                   <b>Safe</b>
                                                </li>
                                                
                                            </ul>
                
                                        </div>
                                        <!-- box-piesite close -->
                                    </div>
                                    <div class=" col3_left_main2_left '.$ecolor.'">
                                        <div class="box-piesite">
                                                                                    <ul>
                                             
                                                <li class="design">
                                                    <div class="piesite" id="pie_1" data-pie="'.(int)$peffective.'" style="cursor:pointer;"><div class="percent"><span class="int">0</span><span class="symbol">%</span></div><div id="slice"><div class="pie"></div></div></div>
                                                </li>
                                                <li class="center">
                                                   <b>Effective</b>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        <!-- box-piesite close -->
                                    </div>
                                    <div class=" col3_left_main2_left '.$wcolor.'">
                                        <div class="box-piesite">
                                            <ul>
                                             
                                                <li class="design">
                                                    <div class="piesite" id="pie_2" data-pie="'.(int)$pwellled.' " style="cursor:pointer;"><div class="percent"><span class="int">0</span><span class="symbol">%</span></div><div id="slice"><div class="pie"></div></div></div>
                                                </li>
                                                <li class="center">
                                                   <b>Wellled</b>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        <!-- box-piesite close -->
                                    </div>
                                    <div class=" col3_left_main2_left '.$ccolor.'">
                                        <div class="box-piesite">
                                            <ul>
                                             
                                                <li class="design">
                                                    <div class="piesite" id="pie_3" data-pie="'.(int)$pcaring.'" style="cursor:pointer;"><div class="percent"><span class="int">0</span><span class="symbol">%</span></div><div id="slice"><div class="pie"></div></div></div>
                                                </li>
                                                <li class="center">
                                                   <b>Caring</b>
                                                </li>
                                            </ul>
                                          
                                        </div>
                                        <!-- box-piesite close -->
                                    </div>
                                    <div class=" col3_left_main2_left '.$rcolor.'">
                                        <div class="box-piesite">
                                            <ul>
                                             
                                                <li class="design">
                                                    <div class="piesite" id="pie_4" data-pie="'.(int)$presponsive.'" style="cursor:pointer;"><div class="percent"><span class="int">0</span><span class="symbol">%</span></div><div id="slice"><div class="pie"></div></div></div>
                                                </li>
                                                <li class="center">
                                                   <b>Responsive</b>
                                                </li>
                                            </ul>
                                          
                                        </div>
                                        <!-- box-piesite close -->
                                    </div>

                                 
                                    <!-- col3_left_main2_right close -->
                                   
                                </div>      
            <div class="form-group">
              
            

                <div class="mockInspectionReport">
                
                <!--==================Safe=====================  -->
                <div class="main-row" style="width: 95%;">
<div class="main-row-top">
<h5>Safe                     <span style="width: 100%;margin-right: 383px;">'. $safescore .' out of '. $safeTotal .'</span> </h5>
<i class="fas fa-chevron-down"></i>
</div>

<div class="main-row-down" style="display: none;"><table style="border-collapse: collapse;">



'. $safevalue .'

</table></div>

</div>
                <!--===========safe==========End==================  -->

                <!--==================effective=====================  -->
                <div class="main-row" style="width: 95%";>
<div class="main-row-top">
<h5>Effective                     <span style="width: 100%;margin-right: 383px;">'. $effectivescore .' out of '. $effectiveTotal .' </span></h5>
<i class="fas fa-chevron-down"></i>
</div>

<div class="main-row-down" style="display: none;"><table style="border-collapse: collapse;">



'. $effectivevalue .'

</table></div>

</div>
                <!--===========effective==========End==================  -->
                <!--==================well led=====================  -->
                 <div class="main-row" style="width: 95%";>
<div class="main-row-top">
<h5>Well led                     <span style="width: 100%;margin-right: 383px;">'. $wellledscore .' out of '. $wellledTotal .' </span></h5>
<i class="fas fa-chevron-down"></i>
</div>

<div class="main-row-down" style="display: none;"><table style="border-collapse: collapse;">



'. $wellledvalue .'

</table></div>

</div>
                <!--===========well led==========End==================  -->                <!--==================caring=====================  -->
                 <div class="main-row" style="width: 95%";>
<div class="main-row-top">
<h5>Carring                     <span style="width: 100%;margin-right: 383px;">'. $caringscore .' out of '. $caringTotal .' </span></h5>
<i class="fas fa-chevron-down"></i>
</div>

<div class="main-row-down" style="display: none;"><table style="border-collapse: collapse;">



'. $caringvalue .'

</table></div>

</div>
                <!--===========caring==========End==================  -->
                <!--==================Responsive=====================  -->
                 <div class="main-row" style="width: 95%";>
<div class="main-row-top">
<h5>Responsive                     <span style="width: 100%;margin-right: 383px;">'. $responsivescore .' out of '. $responsiveTotal .' </span></h5>
<i class="fas fa-chevron-down"></i>
</div>

<div class="main-row-down" style="display: none;"><table style="border-collapse: collapse;">



'. $responsivevalue .'

</table></div>

</div>
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
         header('Location: mock_inspection_report?allhtml='.$lastId);
          }

           ?>
      

   </div>
    <!-- left_right_side -->


<?php include_once('footer.php'); ?>
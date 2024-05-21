<?php
ob_start();
include_once("global.php");
require_once (__DIR__."/tcpdf/tcpdf.php");

global $productClass, $webClass, $dbF, $functions, $db;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
$chk = $functions->cpdAllow();

if($chk){
    echo "<h2>You Are Not Allow to View Certificate</h2>";
    exit();
}

 $assign_id           = $_POST['certificate_paper_id'];
if(isset($_POST['certificate_user'])){
    $user_id = $_POST['certificate_user'];
}else{
    if($_SESSION['currentUserType'] == 'Employee'){
        $user_id = $_SESSION['superid'];
    }
    else{
        $user_id = $_SESSION['currentUser'];
    }
}
$userDetail          = $functions->getWebUser($user_id, 'acc_name');
$user_name           = $userDetail['acc_name'];


$data = $dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$user_id' AND setting_name = 'gdc_number'");
$gdc = $data[0];


$sqlPaper = "SELECT * FROM `assigned_paper` WHERE assign_id = ?";
$resPaper             = $dbF->getRow($sqlPaper, array($assign_id));
$apDateTimestamp      = explode(' ', $resPaper['date_timestamp']);
$exam_date            = $apDateTimestamp[0];
$expiry_date   = $resPaper['expiry_date'];
$completion_date   = $resPaper['completion_date'];
$assign_paper         = $resPaper['assign_paper'];   

$data1 = $dbF->getRow("SELECT * FROM `paper` WHERE `paper_id` = '$assign_paper'");

$aim                  = $data1['aim'];
$objectives           = $data1['objectives'];
$learning_content     = $data1['learning_content'];
$development_outcomes = $data1['development_outcomes'];
$subject_id           = $data1['subject_id'];

$data = $dbF->getRow("SELECT `subject_title`,`minutes` FROM `subjects` WHERE `subject_id` = '$subject_id'");
$title = $data[0];
$certificate_title = $title;
$minutes = $data['minutes'];

$stampImage = '<img width="120" src="'. WEB_URL .'/webImages/stamp1.png">';

if ($minutes == "60" ) { 
$stampImage = '<img width="120" src="'. WEB_URL .'/webImages/stamp1.png">';
}
if ($minutes == "120" ){
$stampImage = '<img width="120" src="'. WEB_URL .'/webImages/stamp2.png">';
}

class MYPDF extends TCPDF {
    
    public $imagePath;
    public $expiryDate;
    
    public function setData($imagePath,$expiryDate){
        $this->imagePath  = $imagePath;
        $this->expiryDate = $expiryDate;
    }
    
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-60);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        $html = '<style> 
        .result_bottom {
        position: absolute;
        width: 100%;
        bottom: 0px;
        padding: 0;
        font-size: 10px !important;
        }
        .result_bottom strong {
        font-size: 10px !important;
        }
        .result_bottom table tr td img {
        width: 90px;
        display: block;
        margin-bottom: 5px;
        }
        </style>
        <div class="result_bottom"><table><tr><td valign="baseline"> '. $this->imagePath .'</td><td valign="baseline"> &nbsp;  &nbsp;  &nbsp;  &nbsp; <img width="80" src="https://smartdentalcompliance.com/webImages/signsaba.jpg"> </td></tr></table><br> <table width="100%"><tr>
        <td>Valid Till ' . date("d-M-Y", strtotime($this->expiryDate)). '. <strong>This CPD is subject to quality assurance by </strong><br>We confirm that the information provided on this certificate is full and accurate.</td></tr></table>
        </div>';
        $this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setData($stampImage,$expiry_date);
//set document information
//remove default header
//$pdf->setPrintHeader(false);
//$pdf->setPrintFooter(false);
// add a page
$pdf->AddPage();

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image

$img_file = K_PATH_IMAGES.'certificate1.png';
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$pdf->SetAutoPageBreak(false, 0);
$html1 = '
<!DOCTYPE html>
<html>
<head>
    <title>Smart Dental Compliance</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?php echo WEB_URL;?>/webImages/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo WEB_URL;?>/webImages/favicon.ico" type="image/x-icon" />
<style>
    *{
        font-family: Arial, Helvetica, sans-serif;
        margin: 0 !important;
        padding: 0 !important;
        color: #222;
        font-size: 12px;
    }

    .result_main {
        width: 789px;
        position: relative;
        margin: 0 auto;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        
    }
    .result_top {
        text-align: center;
        line-height:14px;
    }
    .h2 {
        font-size: 16px;
        font-weight: normal;
        padding-bottom:5px !important;
    }
    
    .gdc{
        font-size: 12px;
        font-weight: normal;
    }
  
    .result_middle {
        padding: 0px 0px;
        position:relative;
    }
    
    .h5{
        font-size: 14px;
    }
  
    .result_middle p {
        padding-left: 13px;
        margin-bottom: 0px;
    }
    
</style>
</head>
<body>

<div class="result_main" >

<br><br><br><br><br><br>
<div class="result_top">
<div class="h2" > '. $user_name .' <span class="gdc"> (GDC NO.'. $gdc . ') </span> </div> 
Attended a Training session on the topic of:<br>
<span class="h2"> ' . $title . ' </span><br> on<br>
<span class="h2"> '. date("d-M-Y", strtotime($completion_date)) . '</span>
</div>

<div class="result_middle">
<strong>Aim</strong><br>
<span>' . $aim . '</span><br><br>
<strong>Objectives</strong><br>
<span>' . $objectives .'</span><br><br>
<strong>Learning Content</strong><br>
<span>' . $learning_content . '</span><br><br>
<strong>Development Outcomes</strong><br>
<span>' . $development_outcomes .'</span><br>
</div>

</div>
</body>
</html>
';

// echo $html1;
// exit;

 $filename=$_POST['certificate_user'].':_:'.$user_name.'-'.$title.'_'.$resPaper['expiry_date'].'.pdf';
$filename=str_replace(" ", "_", $filename);
$pdf->writeHTML($html1, true, false, true, false, '');
$pdf->Output($_SERVER['DOCUMENT_ROOT']."/images/files/cpd-certificates/$filename", 'F');
//=================insert Start====================================================================== 
        $file = WEB_URL."/images/files/cpd-certificates/$filename";
        $id  =   empty($_POST['certificate_paper_id']) ? "" : $_POST['certificate_paper_id'];
        $certificat_expiry_date   = $resPaper['expiry_date'];
        $certificat_completion_date   = $resPaper['completion_date'];
        $certificate_user  =   empty($_POST['certificate_user']) ? "" : $_POST['certificate_user'];
       
        $category  =   empty($_POST['category']) ? "" : $_POST['category'];
        $sub_dcategory  =   empty($_POST['sub_dcategory']) ? "" : $_POST['sub_dcategory'];
        $titledoc  =   empty($_POST['title_ducment']) ? "" : $_POST['title_ducment'];
        $tid =  empty($_POST['title_id']) ? "" : $_POST['title_id'];   
          
          htmlspecialchars($category);  
          htmlspecialchars($sub_dcategory);  
          htmlspecialchars($titledoc);  
          intval($tid);  
          intval($certificate_user);  
        if ($_POST['title_ducment'] =='') {
            $titledoc = $certificate_title;
        }
    $sql      =   "INSERT INTO `userdocuments` (`title_id`,`title`, `category`,`sub_dcategory`, `user`, `file`,`completion_date`, `expiry_date`) VALUES (?,?,?,?,?,?,?,?)";
    $array   = array($tid,$titledoc,$category,$sub_dcategory,$certificate_user,$file,$certificat_completion_date,$certificat_expiry_date);
    $this->dbF->setRow($sql,$array,false);


?>

 





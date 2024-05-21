<?php
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

$orderid           = $_GET['orderid'];
// $user=$_GET['User']
if(isset($_GET['user'])){
    $user_id = $_GET['user'];
}else{
    if($_SESSION['currentUserType'] == 'Employee'){
        $user_id = $_SESSION['superid'];
    }
    else{
        $user_id = $_SESSION['currentUser'];
    }
}
$userDetail          = $functions->getWebUser($user_id, 'acc_name');
$userDetail2          = $functions->getWebUser($user_id, 'acc_email');
$user_name           = $userDetail['acc_name'];
$acc_email           = $userDetail2['acc_email'];
$title="";

 $page  = $webClass->getPage("terms-and-conditions");


$mem = "SELECT * FROM `orders` WHERE `order_id`='$orderid' AND `product_id` IN (1,14,22,23,24,82,87,89,90)  AND  order_mandate != ''";
$val             = $dbF->getRow($mem);
$expire_date = date("d-M-Y",strtotime($val['expire_date']));
    $order_date = date("d-M-Y",strtotime($val['order_date']));
$term_accept_date = date("d-M-Y",strtotime($val['terms_accept_date']));
$pname = $webClass->getProductName($val['product_id'],'prodet_name');
$title=translateFromSerialize($pname['prodet_name']);
$sql1  = "SELECT * FROM `terms_sign_By_user` WHERE userId = ? ORDER BY id DESC LIMIT 1";
    $data1 =  $dbF->getRow($sql1,array($user));
    if($dbF->rowCount>0){
      $term_accept_date = date("d-M-Y", strtotime($data1['termSignDate']));
        $page['desc'] =  $data1['terms'];
    }

class MYPDF extends TCPDF {
    
    public $expire_date;
    public $expiryDate;
    
    public function setData($expiryDate){

        $this->expiryDate = $expire_date;
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
        margin-bottom: 20px;
        }
        </style>
<div class="result_bottom"><br>
        </div>
        ';
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

$pdf->SetFooterMargin(10);
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image

$img_file = K_PATH_IMAGES.'certificate1.png';
$pdf->Image('', 0, 0, 210, 297, '', '', '', false, 50, '', false, false, 0);
// $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$pdf->SetAutoPageBreak(true, 1);
$pdf->SetPrintHeader(false);
$html1 = '<!DOCTYPE html><html><head>
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
        padding-bottom:0px !important;
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
<body onload="window.open("https://www.google.com/", "_blank");">

<div class="result_main" >
<div class="logo_side" style="text-align:center">

<div class="logo_img">
<img src="https://smartdentalcompliance.com/webImages/logo-72x72.png?magic=1246353672" alt="">
</div>
<div class="logo_txt">
<h3>SMART DENTAL COMPLIANCE &amp; TRAINING</h3>

</div>

</div>

<div class="result_middle">
<strong>Product Name</strong><br>
<span>' . translateFromSerialize($pname['prodet_name']) . '</span><br><br>
<strong>Name</strong><br>
<span>' . $user_name . '</span><br><br>
<strong>Email</strong><br>
<span>' . $acc_email . '</span><br><br>
<strong>Order Date</strong><br>
<span>' . $order_date . '</span><br><br>
<strong>Expiry Date</strong><br>
<span>' . $expire_date . '</span><br><br>
<strong>You digitally signed this contract on</strong><br>
<span>' . $term_accept_date . '</span><
<span>' . $page['desc'] . '</span><br><br>

</div>

</div>
</body>
</html>
';
  $pdf->setCellPaddings(0, -10, 0, -2);
 // echo $html1;
 // exit;
 $filename=$user_name.'-'.$title.'.pdf';
 $filename=str_replace(" ", "_", $filename);;
 $pdf->writeHTML($html1, true, false, true, false, '');
 $pdf->Output("$filename", 'D');

// $setPswrdHash = $val['acc_email'].'--'.$this->functions->decode($val['acc_pass']);
// //             $setPswrdHash = base64_encode($setPswrdHash);
// //             $link        =   WEB_URL . "/login.php?".'set='.$setPswrdHash;
?>

 
<!DOCTYPE html>
<html>
<head>
    <title>
        
    </title>
</head>
<body>
<a data-id="10" data-val="1" href="https://smartdentalcompliance.com/login.php?set=c21hcnRkZW50YWxjb21wbGlhbmNlQG91dGxvb2suY29tLS0xMjM0NTY3ODk=" target="_blank" class="btn" title="User Login">
</body>
</html>




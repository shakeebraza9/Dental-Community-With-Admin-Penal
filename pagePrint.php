<?php
ob_start();
include_once("global.php");
require_once (__DIR__."/tcpdf/tcpdf.php");
global $productClass, $webClass, $dbF, $functions, $db;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
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

// $img_file = K_PATH_IMAGES.'certificate1.png';
$pdf->Image('', 0, 0, 210, 297, '', '', '', false, 50, '', false, false, 0);
// $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$pdf->SetAutoPageBreak(true, 1);
$pdf->SetPrintHeader(false);
$pSlug =   htmlspecialchars(base64_decode($_GET['pSlug']));
       $explode = explode(":",$pSlug);
         $explode[0];  
         $explode[1];
$user = $_SESSION['currentUser'];
        $sql1 = "SELECT * FROM `accounts_user` WHERE `acc_id` =  ? ";
        $data1 = $dbF->getRow($sql1,array($user));
        

       
if ($explode[0] == 'u') {
      $data = $dbF->getRow("SELECT * FROM `userdocuments` WHERE  id = '$explode[1]' ");
  }
  if ($explode[0] == 'd') {   
   
      $data = $dbF->getRow("SELECT * FROM `documents` WHERE  id = '$explode[1]' "); 
  }
  if ($explode[0] == 'm') {   
   
      $data = $dbF->getRow("SELECT * FROM `myuploads` WHERE  id = '$explode[1]' "); 
  }
$user = $_SESSION['currentUser'];
        $sql1 = "SELECT * FROM `accounts_user` WHERE `acc_id` =  ? ";
        $data1 = $dbF->getRow($sql1,array($user));
    $fileopen = str_replace(WEB_URL, $_SERVER['DOCUMENT_ROOT'].'/', $data['file']);
    $handle = fopen($fileopen, 'r'); 
    $contents = stream_get_contents($handle);
                        fclose($handle);
                    
$html1='<!DOCTYPE html>
<html>

<head>
    <title>Smart Dental Compliance</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <link rel="icon" href="<?php echo WEB_URL;?>/webImages/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo WEB_URL;?>/webImages/favicon.ico" type="image/x-icon" />
    <style>
    body{
        max-width:900px;
        margin:0 auto;
        }
    table{
        text-align:center;
        width:80%;
    }

    </style>
</head>

<body>
    <div class="content"> 
        '.$contents.'
    </div>
</body>

</html>';
if($_GET['print']==0){
echo $html1;
 exit;
}else{
$pdf->setCellPaddings(0, -10, 0, -2);
 $filename="username".'-'."title".'.pdf';
 $filename=str_replace(" ", "_", $filename);
 $pdf->writeHTML($html1, true, false, true, false, '');
 $pdf->Output("$filename", 'D');
 } ?>
<?php
############ Export table into CSV ############

require_once("../global.php");

$_d = ","; //$delimiter

####### CSV file Headings, for excel edit mode.
$file_heading = "product_id{$_d}product_name{$_d}Manufacturer Name{$_d}Sweden(SEK){$_d}Norwegian(NOK){$_d}Denmark(DK){$_d}Finland(FI)";
// $file_heading .= "qty_pk{$_d}qty_store_id{$_d}qty_product_id{$_d}qty_product_scale{$_d}qty_product_color{$_d}product_store_hash";
$file_heading .= "\n";

$output = $file_heading;

####### get data from DB
$sql    = "SELECT d.`prodet_id`,d.`prodet_name`,s.`setting_val` 
            FROM `proudct_detail` d 
                JOIN `product_setting` s 
                    WHERE d.`prodet_id`= s.`p_id` 
                        AND s.`setting_name` = 'Model'"; // ORDER BY qty_pk DESC
$data   = $dbF->getRows($sql);

foreach ($data as $val) {

    $pId         = $val['prodet_id'];
    $prodet_name = $functions->unserializeTranslate($val['prodet_name']);
    $prodet_name   = specialChar_to_english_letters($prodet_name);
    $setting_val = $val['setting_val'];

    $sql1 = "SELECT `propri_cur_id`, `propri_price` FROM `product_price` WHERE `propri_prodet_id` = ?";
    $priceData = $dbF->getRows($sql1, array($pId));

    // $dbF->prnt($priceData);
    // exit;

    $denmark    = (isset($priceData[0]['propri_price']))? $priceData[0]['propri_price'] : '0';
    $finland    = (isset($priceData[1]['propri_price']))? $priceData[1]['propri_price'] : '0';
    $norwegian  = (isset($priceData[2]['propri_price']))? $priceData[2]['propri_price'] : '0';
    $sweden     = (isset($priceData[3]['propri_price']))? $priceData[3]['propri_price'] : '0';

    ####### CSV single row...
    $output .= "{$pId}{$_d}{$prodet_name}{$_d}{$setting_val}{$_d}{$sweden}{$_d}{$norwegian}{$_d}{$denmark}{$_d}{$finland}";
    $output .= "\n";
}


####### Download csv File...
$filename = "IBMS_product_price.csv";
header('Content-type: application/csv;charset=UTF-8');
header('Content-Disposition: attachment; filename=' . $filename);

echo $output;
exit;

?>
<?php
ob_start();
require_once("classes/invoice.php");
global $adminPanelLanguage;

$_w                                                  = array();
$_w['Invoice ID']                             = '';
$_w['Due Date']                             = '';
$_w['Price']                             = '';
$_w['Payment Status']                             = '';
$_e['INVOICE DETAILS']                             = '';
global $functions;
global $dbF;
global $_e;
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=DownloadallwithDate.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
function webUserInfoArray($data,$settingName){
foreach($data as $val){
if($val['setting_name']==$settingName){
return $val['setting_val'];
}
}
return "";
}


?>
<table>
<thead>

<?php 

if(isset($_GET['daTe']) && $_GET['daTe'] != ""){
	?>

	<tr style='background-color:Olive;'>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td><?php echo date("D j M Y",strtotime($_GET['daTe'])) ?></td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
</tr>
 
<?php
}else{
?>

	<tr style='background-color:Olive;'>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td><?php echo date("D j M Y") ?></td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
</tr>

<?php

 
}
 ?>




 




<tr>
<th><?php echo _uc('SNO'); ?></th>
<th><?php echo _uc('Name'); ?></th>
<th><?php echo _uc('Email'); ?></th>
<th><?php echo _uc('Account Type'); ?></th>
<th><?php echo _uc('Role'); ?></th>
<th><?php echo _uc('Practice name'); ?></th>
<th><?php echo _uc('Phone'); ?></th>
<th><?php echo _uc('Address'); ?></th>
<th><?php echo _uc('Account Created'); ?></th>
<th><?php echo _uc('Last Login'); ?></th>
<th><?php echo _uc('Birth Day'); ?></th>
</tr>
</thead>
<tbody>

<?php         
if(isset($_GET['daTe']) && $_GET['daTe'] != ""){
$sql  = "SELECT * FROM accounts_user WHERE acc_created like '%$_GET[daTe] %' ORDER BY `accounts_user`.`acc_created` DESC";
}else{
$sql  = "SELECT * FROM accounts_user WHERE acc_created >= NOW() - INTERVAL 1 DAY ORDER BY `accounts_user`.`acc_created` DESC";
}
$dataa =  $dbF->getRows($sql);
$i=0;

if ($dbF->rowCount > 0) {

echo "<tr style='background-color:Olive;'>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td>Sign Up Today</td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>

</tr>";




foreach($dataa as $val){
$id = $val['acc_id'];
$acc_created = date("D j M Y",strtotime($val['acc_created']));
if(!empty($val['last_login'])){
$last_login = date("D j M Y",strtotime($val['last_login']));
}else{
$last_login = '';
}
$acc_email = $val['acc_email'];
$acc_name = $val['acc_name'];
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $dbF->getRows($sql,array($id));
$pn =  webUserInfoArray($userInfo,'practice name');
$phone =  webUserInfoArray($userInfo,'phone');
$role =  webUserInfoArray($userInfo,'role');
$address =  webUserInfoArray($userInfo,'address');
$city =  webUserInfoArray($userInfo,'city');
$country =  webUserInfoArray($userInfo,'country');
$account_type =  webUserInfoArray($userInfo,'account_type');
$bd =  webUserInfoArray($userInfo,'date_of_birth');
$bd = date("D j M Y",strtotime($bd));
if($account_type != "Employee"){
$i++;
echo "<tr>
<td>$i</td>
<td>$acc_name</td>
<td>$acc_email</td>
<td>$account_type</td>
<td>$role</td>
<td>$pn</td>
<td>$phone</td>
<td>$address $city $country</td>
<td>$acc_created</td>
<td>$last_login</td>
<td>$bd</td>
</tr>";
}
}
}
?>






<?php         
if($_GET['daTe'] != ""){

$sql1  = "SELECT * FROM accounts_user WHERE acc_created  between DATE_GET ('$_GET[daTe]', INTERVAL 7 day ) AND '$_GET[daTe]' ORDER BY `accounts_user`.`acc_created` DESC";

}else{

$sql1  = "SELECT * FROM accounts_user WHERE acc_created >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
ORDER BY `accounts_user`.`acc_created` DESC";
}
// var_dump($sql1);
$datadd =  $dbF->getRows($sql1);
echo "<tr style='background-color:Olive;'>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td>Onboarding 7 Days</td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>

</tr>";

foreach($datadd as $val){
$id = $val['acc_id'];
$acc_created = date("D j M Y",strtotime($val['acc_created']));
if(!empty($val['last_login'])){
$last_login = date("D j M Y",strtotime($val['last_login']));
}else{
$last_login = '';
}
$acc_email = $val['acc_email'];
$acc_name = $val['acc_name'];
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $dbF->getRows($sql,array($id));
$pn =  webUserInfoArray($userInfo,'practice name');
$phone =  webUserInfoArray($userInfo,'phone');
$role =  webUserInfoArray($userInfo,'role');
$address =  webUserInfoArray($userInfo,'address');
$city =  webUserInfoArray($userInfo,'city');
$country =  webUserInfoArray($userInfo,'country');
$account_type =  webUserInfoArray($userInfo,'account_type');
$bd =  webUserInfoArray($userInfo,'date_of_birth');
$bd = date("D j M Y",strtotime($bd));
if($account_type != "Employee"){
$i++;
echo "<tr>
<td>$i</td>
<td>$acc_name</td>
<td>$acc_email</td>
<td>$account_type</td>
<td>$role</td>
<td>$pn</td>
<td>$phone</td>
<td>$address $city $country</td>
<td>$acc_created</td>
<td>$last_login</td>
<td>$bd</td>
</tr>";
}
}
?>









<?php         

if(isset($_GET['daTe']) && $_GET['daTe'] != ""){




$sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_GET[daTe]', INTERVAL 30 DAY) AND DATE_SUB('$_GET[daTe]', INTERVAL 15 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";






}else{

$sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND DATE_SUB(CURDATE(), INTERVAL 15 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";
}


$data =  $dbF->getRows($sql11);
 echo "<tr style='background-color:Olive;'>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td>Catchup Calls 15 Days</td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>

</tr>";
foreach($data as $val){
$id = $val['acc_id'];
$acc_created = date("D j M Y",strtotime($val['acc_created']));
if(!empty($val['last_login'])){
$last_login = date("D j M Y",strtotime($val['last_login']));
}else{
$last_login = '';
}
$acc_email = $val['acc_email'];
$acc_name = $val['acc_name'];
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $dbF->getRows($sql,array($id));
$pn =  webUserInfoArray($userInfo,'practice name');
$phone =  webUserInfoArray($userInfo,'phone');
$role =  webUserInfoArray($userInfo,'role');
$address =  webUserInfoArray($userInfo,'address');
$city =  webUserInfoArray($userInfo,'city');
$country =  webUserInfoArray($userInfo,'country');
$account_type =  webUserInfoArray($userInfo,'account_type');
$bd =  webUserInfoArray($userInfo,'date_of_birth');
$bd = date("D j M Y",strtotime($bd));
if($account_type != "Employee"){
$i++;
echo "<tr>
<td>$i</td>
<td>$acc_name</td>
<td>$acc_email</td>
<td>$account_type</td>
<td>$role</td>
<td>$pn</td>
<td>$phone</td>
<td>$address $city $country</td>
<td>$acc_created</td>
<td>$last_login</td>
<td>$bd</td>
</tr>";
}
}
?>








<?php         

if(isset($_GET['daTe']) && $_GET['daTe'] != ""){
$sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_GET[daTe]', INTERVAL 45 DAY) AND DATE_SUB('$_GET[daTe]', INTERVAL 30 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";
}else{
$sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 45 DAY) AND DATE_SUB(CURDATE(), INTERVAL 30 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";
}




$data =  $dbF->getRows($sql11);
 echo "<tr style='background-color:Olive;'>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td>Catchup Calls 1 month</td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>

</tr>";

foreach($data as $val){
$id = $val['acc_id'];
$acc_created = date("D j M Y",strtotime($val['acc_created']));
if(!empty($val['last_login'])){
$last_login = date("D j M Y",strtotime($val['last_login']));
}else{
$last_login = '';
}
$acc_email = $val['acc_email'];
$acc_name = $val['acc_name'];
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $dbF->getRows($sql,array($id));
$pn =  webUserInfoArray($userInfo,'practice name');
$phone =  webUserInfoArray($userInfo,'phone');
$role =  webUserInfoArray($userInfo,'role');
$address =  webUserInfoArray($userInfo,'address');
$city =  webUserInfoArray($userInfo,'city');
$country =  webUserInfoArray($userInfo,'country');
$account_type =  webUserInfoArray($userInfo,'account_type');
$bd =  webUserInfoArray($userInfo,'date_of_birth');
$bd = date("D j M Y",strtotime($bd));
if($account_type != "Employee"){
$i++;
echo "<tr>
<td>$i</td>
<td>$acc_name</td>
<td>$acc_email</td>
<td>$account_type</td>
<td>$role</td>
<td>$pn</td>
<td>$phone</td>
<td>$address $city $country</td>
<td>$acc_created</td>
<td>$last_login</td>
<td>$bd</td>
</tr>";
}
}
?>











<?php         

if(isset($_GET['daTe']) && $_GET['daTe'] != ""){
$sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_GET[daTe]', INTERVAL 75 DAY) AND DATE_SUB('$_GET[daTe]', INTERVAL 60 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";
}else{
$sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 75 DAY) AND DATE_SUB(CURDATE(), INTERVAL 60 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";
}




$data =  $dbF->getRows($sql11);
  echo "<tr style='background-color:Olive;'>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td>Catchup Calls 2 months
</td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>

</tr>";
foreach($data as $val){
$id = $val['acc_id'];
$acc_created = date("D j M Y",strtotime($val['acc_created']));
if(!empty($val['last_login'])){
$last_login = date("D j M Y",strtotime($val['last_login']));
}else{
$last_login = '';
}
$acc_email = $val['acc_email'];
$acc_name = $val['acc_name'];
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $dbF->getRows($sql,array($id));
$pn =  webUserInfoArray($userInfo,'practice name');
$phone =  webUserInfoArray($userInfo,'phone');
$role =  webUserInfoArray($userInfo,'role');
$address =  webUserInfoArray($userInfo,'address');
$city =  webUserInfoArray($userInfo,'city');
$country =  webUserInfoArray($userInfo,'country');
$account_type =  webUserInfoArray($userInfo,'account_type');
$bd =  webUserInfoArray($userInfo,'date_of_birth');
$bd = date("D j M Y",strtotime($bd));
if($account_type != "Employee"){
$i++;
echo "<tr>
<td>$i</td>
<td>$acc_name</td>
<td>$acc_email</td>
<td>$account_type</td>
<td>$role</td>
<td>$pn</td>
<td>$phone</td>
<td>$address $city $country</td>
<td>$acc_created</td>
<td>$last_login</td>
<td>$bd</td>
</tr>";
}
}
?>








<?php         



if(isset($_GET['daTe']) && $_GET['daTe'] != ""){
$sql1a1  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_GET[daTe]', INTERVAL 95 DAY) AND DATE_SUB('$_GET[daTe]', INTERVAL 90 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";
}else{
$sql1a1  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 95 DAY) AND DATE_SUB(CURDATE(), INTERVAL 90 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";
}



$data =  $dbF->getRows($sql1a1);
   echo "<tr style='background-color:Olive;'>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td>Catchup Calls 3 months

</td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>

</tr>";
foreach($data as $val){
$id = $val['acc_id'];
$acc_created = date("D j M Y",strtotime($val['acc_created']));
if(!empty($val['last_login'])){
$last_login = date("D j M Y",strtotime($val['last_login']));
}else{
$last_login = '';
}
$acc_email = $val['acc_email'];
$acc_name = $val['acc_name'];
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $dbF->getRows($sql,array($id));
$pn =  webUserInfoArray($userInfo,'practice name');
$phone =  webUserInfoArray($userInfo,'phone');
$role =  webUserInfoArray($userInfo,'role');
$address =  webUserInfoArray($userInfo,'address');
$city =  webUserInfoArray($userInfo,'city');
$country =  webUserInfoArray($userInfo,'country');
$account_type =  webUserInfoArray($userInfo,'account_type');
$bd =  webUserInfoArray($userInfo,'date_of_birth');
$bd = date("D j M Y",strtotime($bd));
if($account_type != "Employee"){
$i++;
echo "<tr>
<td>$i</td>
<td>$acc_name</td>
<td>$acc_email</td>
<td>$account_type</td>
<td>$role</td>
<td>$pn</td>
<td>$phone</td>
<td>$address $city $country</td>
<td>$acc_created</td>
<td>$last_login</td>
<td>$bd</td>
</tr>";
}
}
?>








<?php         



if(isset($_GET['daTe']) && $_GET['daTe'] != ""){
$sql1a1  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_GET[daTe]', INTERVAL 195 DAY) AND DATE_SUB('$_GET[daTe]', INTERVAL 180 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";
}else{
$sql1a1  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 195 DAY) AND DATE_SUB(CURDATE(), INTERVAL 180 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";
}






$data =  $dbF->getRows($sql1a1);
    echo "<tr style='background-color:Olive;'>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td>Catchup Calls 6 months

</td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>

</tr>";
foreach($data as $val){
$id = $val['acc_id'];
$acc_created = date("D j M Y",strtotime($val['acc_created']));
if(!empty($val['last_login'])){
$last_login = date("D j M Y",strtotime($val['last_login']));
}else{
$last_login = '';
}
$acc_email = $val['acc_email'];
$acc_name = $val['acc_name'];
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $dbF->getRows($sql,array($id));
$pn =  webUserInfoArray($userInfo,'practice name');
$phone =  webUserInfoArray($userInfo,'phone');
$role =  webUserInfoArray($userInfo,'role');
$address =  webUserInfoArray($userInfo,'address');
$city =  webUserInfoArray($userInfo,'city');
$country =  webUserInfoArray($userInfo,'country');
$account_type =  webUserInfoArray($userInfo,'account_type');
$bd =  webUserInfoArray($userInfo,'date_of_birth');
$bd = date("D j M Y",strtotime($bd));
if($account_type != "Employee"){
$i++;
echo "<tr>
<td>$i</td>
<td>$acc_name</td>
<td>$acc_email</td>
<td>$account_type</td>
<td>$role</td>
<td>$pn</td>
<td>$phone</td>
<td>$address $city $country</td>
<td>$acc_created</td>
<td>$last_login</td>
<td>$bd</td>
</tr>";
}
}
?>













<?php         



if(isset($_GET['daTe']) && $_GET['daTe'] != ""){
$oneyearQ  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_GET[daTe]', INTERVAL 375 DAY) AND DATE_SUB('$_GET[daTe]', INTERVAL 360 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";
}else{
$oneyearQ  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 375 DAY) AND DATE_SUB(CURDATE(), INTERVAL 360 DAY)
ORDER BY `accounts_user`.`acc_created` DESC";
}







$data =  $dbF->getRows($sql1a1);
     echo "<tr style='background-color:Olive;'>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td>Catchup Calls 12 months

</td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>

</tr>";
foreach($data as $val){
$id = $val['acc_id'];
$acc_created = date("D j M Y",strtotime($val['acc_created']));
if(!empty($val['last_login'])){
$last_login = date("D j M Y",strtotime($val['last_login']));
}else{
$last_login = '';
}
$acc_email = $val['acc_email'];
$acc_name = $val['acc_name'];
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $dbF->getRows($sql,array($id));
$pn =  webUserInfoArray($userInfo,'practice name');
$phone =  webUserInfoArray($userInfo,'phone');
$role =  webUserInfoArray($userInfo,'role');
$address =  webUserInfoArray($userInfo,'address');
$city =  webUserInfoArray($userInfo,'city');
$country =  webUserInfoArray($userInfo,'country');
$account_type =  webUserInfoArray($userInfo,'account_type');
$bd =  webUserInfoArray($userInfo,'date_of_birth');
$bd = date("D j M Y",strtotime($bd));
if($account_type != "Employee"){
$i++;
echo "<tr>
<td>$i</td>
<td>$acc_name</td>
<td>$acc_email</td>
<td>$account_type</td>
<td>$role</td>
<td>$pn</td>
<td>$phone</td>
<td>$address $city $country</td>
<td>$acc_created</td>
<td>$last_login</td>
<td>$bd</td>
</tr>";
}
}
?>



















<?php         


if(isset($_GET['daTe']) && $_GET['daTe'] != ""){



$sql11  = "SELECT * 
FROM  accounts_user_detail 
WHERE  DATE_ADD(setting_val, 
INTERVAL YEAR('$_GET[daTe]')-YEAR(setting_val)
+ IF(DAYOFYEAR('$_GET[daTe]') >= DAYOFYEAR(setting_val),1,0)
YEAR)  
BETWEEN '$_GET[daTe]' AND DATE_ADD('$_GET[daTe]', INTERVAL 14 DAY) AND setting_name = 'date_of_birth' and setting_val !='' ORDER BY `accounts_user_detail`.`setting_val` ASC";



}else{
$sql11  = "SELECT * 
FROM  accounts_user_detail 
WHERE  DATE_ADD(setting_val, 
INTERVAL YEAR(CURDATE())-YEAR(setting_val)
+ IF(DAYOFYEAR(CURDATE()) >= DAYOFYEAR(setting_val),1,0)
YEAR)  
BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 14 DAY) AND setting_name = 'date_of_birth' and setting_val !='' ORDER BY `accounts_user_detail`.`setting_val` ASC";
}





     echo "<tr style='background-color:Olive;'>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td>Birth Day
</td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>

</tr>";


$data =  $dbF->getRows($sql11);
 
foreach($data as $val){



$id = $val['id_user'];


$sql11a  = "SELECT * FROM accounts_user WHERE acc_id = '$id'";
$data11a =  $dbF->getRow($sql11a);



$acc_created = date("D j M Y",strtotime($data11a['acc_created']));
$bd = date("D j M Y",strtotime($val['setting_val']));
if(!empty($data11a['last_login'])){
$last_login = date("D j M Y",strtotime($data11a['last_login']));
}else{
$last_login = '';
}


$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $dbF->getRows($sql,array($id));



$pn =  webUserInfoArray($userInfo,'practice name');
$phone =  webUserInfoArray($userInfo,'phone');
$address =  webUserInfoArray($userInfo,'address');
$city =  webUserInfoArray($userInfo,'city');
$country =  webUserInfoArray($userInfo,'country');

$account_type =  webUserInfoArray($userInfo,'account_type');





if($account_type != "Employee"){

$acc_email = $data11a['acc_email'];
$acc_name = $data11a['acc_name'];




$i++;
echo "<tr>
<td>$i</td>
<td>$acc_name</td>
<td>$acc_email</td>
<td>$account_type</td>
<td>$role</td>
<td>$pn</td>
<td>$phone</td>
<td>$address $city $country</td>
<td>$acc_created</td>
<td>$last_login</td>
<td>$bd</td>
</tr>";
}
}
?>





</tbody>
</table>
<?php return ob_get_clean(); ?>
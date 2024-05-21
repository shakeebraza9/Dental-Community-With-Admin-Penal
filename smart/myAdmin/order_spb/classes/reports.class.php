<?php
require_once (__DIR__."/../../global.php"); //connection setting db

################### NEW MODULE NOTE ##########################
//If you want to make new module like reports, just copy paste reports. and change page_type to your type
//and only change label  and hide or show any fields.

class reports extends object_class{
    public $productF;
    public $imageName;
    private $page_type = "reports";
    public function __construct(){
        parent::__construct('3');

        /**
         * MultiLanguage keys Use where echo;
         * define this class words and where this class will call
         * and define words of file where this class will called
         **/
        global $_e;
        global $adminPanelLanguage;
        $_w=array();
        //Index
        $_w['reports Management'] = '' ;
        //reports.php
        $_w['Manage reports'] = '' ;
        $_w['Active reports'] = '' ;
        $_w['Pending'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Add New reports'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;

        //reportsNew.php
        $_w['Add New reports/Event'] = '' ;

        //This Class
        $_w['SNO'] = '' ;
        $_w['TITLE'] = '' ;
        $_w['PUBLISH DATE'] = '' ;
        $_w['UPDATE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['reports Save Successfully'] = '' ;
        $_w['Added'] = '' ;
        $_w['reports Save Failed'] = '' ;

        $_w['SAVE'] = '' ;
        $_w['reports Image (278x278 px)'] = '' ;
        $_w['Leave Blank to publish now'] = '' ;
        $_w['Publish'] = '' ;

        $_w['Allow Comment'] = '' ;
        $_w['reports Date'] = '' ;
        $_w['Date'] = '' ;
        $_w['reports Setting'] = '' ;
        $_w['Enter Full Detail'] = '' ;
        $_w['Detail'] = '' ;
        $_w['Enter Short Description'] = '' ;
        $_w['Short Description'] = '' ;
        $_w['reports Title'] = '' ;
        $_w['Type'] = '' ;
        $_w['reports Detail'] = '' ;
        $_w['Old reports Image'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin reports Management');

    }

   // public function reportsBDAY(){
   //      $today = date('Y-m-d');
   //         $week = date("Y-m-d", strtotime("-1 week"));
   //      $page_type = $this->page_type;
   //      // $sql  = "SELECT id, heading,publish_date,dateTime FROM reports WHERE publish = '1' AND publish_date <= '$today' ";
       
   //       $sql  = "SELECT * FROM `accounts_user_detail` where setting_name = 'date_of_birth' and setting_val !='' setting_val BETWEEN '$week' AND '$today'";




   //      $data =  $this->dbF->getRows($sql);
   //      $this->print_reports_table($data);
   //  }
    public function reportsSUP(){
        $today = date('Y-m-d');
        $page_type = $this->page_type;
        // $sql  = "SELECT id, heading,publish_date,dateTime FROM reports WHERE publish = '1' AND publish_date <= '$today' ";
  
        



        if(isset($_POST['dateIs']) && $_POST['dateIs'] != ""){
  
   $sql  = "SELECT * FROM accounts_user WHERE acc_created like '%$_POST[dateIs] %' ORDER BY `accounts_user`.`acc_created` DESC";

}else{

  $sql  = "SELECT * FROM accounts_user WHERE acc_created >= NOW() - INTERVAL 1 DAY ORDER BY `accounts_user`.`acc_created` DESC";
}







        $data =  $this->dbF->getRows($sql);
        $this->print_reports_table($data);
    }

    // public function reportsPending(){
    //     $today = date('Y-m-d');
    //     $page_type = $this->page_type;
    //     $sql  = "SELECT id, heading,publish_date,dateTime FROM reports WHERE publish = '1' AND publish_date > '$today' ";
    //     $data =  $this->dbF->getRows($sql);
    //     $this->print_reports_table($data);
    // }


    // public function reportsDraft(){
    //     $page_type = $this->page_type;
    //     $sql  = "SELECT id, heading,publish_date,dateTime FROM reports WHERE publish = '0' ";
    //     $data =  $this->dbF->getRows($sql);

    //     $this->print_reports_table($data);
    // }


// SELECT 
//     first_name, status, doj
// FROM
//     opl_employs
// WHERE 
//     `doj` between DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND DATE_SUB(CURDATE(), INTERVAL 75 DAY)

 public function webUserInfoArray($data,$settingName){
        foreach($data as $val){
            if($val['setting_name']==$settingName){
                return $val['setting_val'];
            }
        }
        return "";
    }



    private function print_reports_table($data){
        $data   = empty($data) ? array() : $data;
        global $_e;

        echo '<div class="table-responsive">
<form method="post" class="form-horizontal">
<input type="date" name="dateIs" class="form-control">
<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">Search</button>

<a href="-order_spb?page=DownloadallwithDate&daTe='.$_POST['dateIs'].'" class="btn btn-primary btn-sm" style="font-size: 24px;">Download All</a>

</form>';

if(isset($_POST['dateIs']) && $_POST['dateIs'] != ""){
echo '<h2 class="sub_heading" style="text-align: center;">'.date("D j M Y",strtotime($_POST['dateIs'])).'</h2>';

}else{

echo '<h2 class="sub_heading" style="text-align: center;">'.date("D j M Y").'</h2>';
}





                echo '<br>
        <br>
         <button  class="btn-success" style="
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
">  Sign Up Today </button> 
                <table class="table table-hover">

               



                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>Name - Email</th>
                        <th>Practice name - Phone</th>
                        <th>Address</th>
                        <th>Account Created</th>
                        <th>Last Login</th>
                         
                    </thead>
        <tbody>';




        $i = 0;
        $defaultLang = $this->functions->AdminDefaultLanguage();
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
    $userInfo   = $this->dbF->getRows($sql,array($id));
  

           $pn =  $this->webUserInfoArray($userInfo,'practice name');
           $phone =  $this->webUserInfoArray($userInfo,'phone');
           $address =  $this->webUserInfoArray($userInfo,'address');
           $city =  $this->webUserInfoArray($userInfo,'city');
           $country =  $this->webUserInfoArray($userInfo,'country');
           $account_type =  $this->webUserInfoArray($userInfo,'account_type');

if($account_type != "Employee"){
 $i++;
            echo "<tr>
                    <td>$i</td>
                    <td>$acc_name ($account_type) - $acc_email</td>



                    <td>$pn - $phone</td>
                    <td>$address $city $country</td>


                    <td>$acc_created</td>

                    <td>$last_login</td>
                    
                  </tr>";
        }
        }









// AND acc_created < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY

 



if(isset($_POST['dateIs']) && $_POST['dateIs'] != ""){

  $sql1  = "SELECT * FROM accounts_user WHERE acc_created  between DATE_SUB( '$_POST[dateIs]', INTERVAL 7 day ) AND '$_POST[dateIs]' ORDER BY `accounts_user`.`acc_created` DESC";

}else{

 $sql1  = "SELECT * FROM accounts_user WHERE acc_created >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
 ORDER BY `accounts_user`.`acc_created` DESC";
}






        $data1 =  $this->dbF->getRows($sql1);

echo "<tr  class='btn-success'> <td>Onboarding 7 Days</td></tr>";



echo ' <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>Name - Email</th>
                         <th>Practice name - Phone</th>
                        <th>Address</th>
                        <th>Account Created</th>
                        <th>Last Login</th>
                        
                    </thead>';
  foreach($data1 as $val){
            
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
    $userInfo   = $this->dbF->getRows($sql,array($id));



             $pn =  $this->webUserInfoArray($userInfo,'practice name');
           $phone =  $this->webUserInfoArray($userInfo,'phone');
           $address =  $this->webUserInfoArray($userInfo,'address');
           $city =  $this->webUserInfoArray($userInfo,'city');
           $country =  $this->webUserInfoArray($userInfo,'country');

            $account_type =  $this->webUserInfoArray($userInfo,'account_type');

if($account_type != "Employee"){

$i++;
            echo "<tr>
                    <td>$i</td>
                    <td>$acc_name ($account_type) - $acc_email</td>
                     <td>$pn - $phone</td>
                    <td>$address $city $country</td>
                    <td>$acc_created</td>
                    <td>$last_login</td>
                  
                  </tr>";
        }

}















if(isset($_POST['dateIs']) && $_POST['dateIs'] != ""){

 


      $sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_POST[dateIs]', INTERVAL 30 DAY) AND DATE_SUB('$_POST[dateIs]', INTERVAL 15 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";






}else{

    $sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND DATE_SUB(CURDATE(), INTERVAL 15 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";
}







 //   $sql11  = "SELECT * FROM accounts_user WHERE acc_created >= curdate() - INTERVAL DAYOFWEEK(curdate())+22 DAY AND DATEDIFF( CURDATE(), acc_created ) > 15
 // ORDER BY `accounts_user`.`acc_created` DESC";
        $data11 =  $this->dbF->getRows($sql11);

echo "<tr  class='btn-success'> <td>Catchup Calls 15 Days</td></tr>";
echo ' <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>Name - Email</th>
                         <th>Practice name - Phone</th>
                        <th>Address</th>
                        <th>Account Created</th>
                        <th>Last Login</th>
                        
                    </thead>';
  foreach($data11 as $val){
        
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
    $userInfo   = $this->dbF->getRows($sql,array($id));



             $pn =  $this->webUserInfoArray($userInfo,'practice name');
           $phone =  $this->webUserInfoArray($userInfo,'phone');
           $address =  $this->webUserInfoArray($userInfo,'address');
           $city =  $this->webUserInfoArray($userInfo,'city');
           $country =  $this->webUserInfoArray($userInfo,'country');

            $account_type =  $this->webUserInfoArray($userInfo,'account_type');

if($account_type != "Employee"){
    $i++;

            echo "<tr>
                    <td>$i</td>
                    <td>$acc_name ($account_type) - $acc_email</td>
                     <td>$pn - $phone</td>
                    <td>$address $city $country</td>
                    <td>$acc_created</td>
                    <td>$last_login</td>
                   
                  </tr>";
        }
}


 

if(isset($_POST['dateIs']) && $_POST['dateIs'] != ""){
$sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_POST[dateIs]', INTERVAL 45 DAY) AND DATE_SUB('$_POST[dateIs]', INTERVAL 30 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";
}else{
$sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 45 DAY) AND DATE_SUB(CURDATE(), INTERVAL 30 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";
}






 //   $sql11  = "SELECT * FROM accounts_user WHERE acc_created >= curdate() - INTERVAL DAYOFWEEK(curdate())+37 DAY AND DATEDIFF( CURDATE(), acc_created ) > 30
 // ORDER BY `accounts_user`.`acc_created` DESC";
        $data11 =  $this->dbF->getRows($sql11);

echo "<tr  class='btn-success'> <td>Catchup Calls 1 month</td></tr>";
echo ' <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>Name - Email</th>
                         <th>Practice name - Phone</th>
                        <th>Address</th>
                        <th>Account Created</th>
                        <th>Last Login</th>
                       
                    </thead>';
  foreach($data11 as $val){
           
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
    $userInfo   = $this->dbF->getRows($sql,array($id));



             $pn =  $this->webUserInfoArray($userInfo,'practice name');
           $phone =  $this->webUserInfoArray($userInfo,'phone');
           $address =  $this->webUserInfoArray($userInfo,'address');
           $city =  $this->webUserInfoArray($userInfo,'city');
           $country =  $this->webUserInfoArray($userInfo,'country');

            $account_type =  $this->webUserInfoArray($userInfo,'account_type');

if($account_type != "Employee"){

 $i++;
            echo "<tr>
                    <td>$i</td>
                    <td>$acc_name ($account_type) - $acc_email</td>
                     <td>$pn - $phone</td>
                    <td>$address $city $country</td>
                    <td>$acc_created</td>
                    <td>$last_login</td>
                   
                  </tr>";
        }



}

if(isset($_POST['dateIs']) && $_POST['dateIs'] != ""){
$sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_POST[dateIs]', INTERVAL 75 DAY) AND DATE_SUB('$_POST[dateIs]', INTERVAL 60 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";
}else{
$sql11  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 75 DAY) AND DATE_SUB(CURDATE(), INTERVAL 60 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";
}

 


 //   $sql11  = "SELECT * FROM accounts_user WHERE acc_created >= curdate() - INTERVAL DAYOFWEEK(curdate())+67 DAY AND DATEDIFF( CURDATE(), acc_created ) > 60
 // ORDER BY `accounts_user`.`acc_created` DESC";
        $data11 =  $this->dbF->getRows($sql11);

echo "<tr  class='btn-success'> <td>Catchup Calls 2 months</td></tr>";
echo ' <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>Name - Email</th>
                         <th>Practice name - Phone</th>
                        <th>Address</th>
                        <th>Account Created</th>
                        <th>Last Login</th>
                        
                    </thead>';
  foreach($data11 as $val){
            
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
    $userInfo   = $this->dbF->getRows($sql,array($id));



             $pn =  $this->webUserInfoArray($userInfo,'practice name');
           $phone =  $this->webUserInfoArray($userInfo,'phone');
           $address =  $this->webUserInfoArray($userInfo,'address');
           $city =  $this->webUserInfoArray($userInfo,'city');
           $country =  $this->webUserInfoArray($userInfo,'country');


            $account_type =  $this->webUserInfoArray($userInfo,'account_type');

if($account_type != "Employee"){


$i++;
            echo "<tr>
                    <td>$i</td>
                    <td>$acc_name ($account_type) - $acc_email</td>
                     <td>$pn - $phone</td>
                    <td>$address $city $country</td>
                    <td>$acc_created</td>
                    <td>$last_login</td>
            
                  </tr>";
        }

}





 



if(isset($_POST['dateIs']) && $_POST['dateIs'] != ""){
$sql1a1  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_POST[dateIs]', INTERVAL 95 DAY) AND DATE_SUB('$_POST[dateIs]', INTERVAL 90 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";
}else{
$sql1a1  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 95 DAY) AND DATE_SUB(CURDATE(), INTERVAL 90 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";
}




 //   $sql11  = "SELECT * FROM accounts_user WHERE acc_created >= curdate() - INTERVAL DAYOFWEEK(curdate())+67 DAY AND DATEDIFF( CURDATE(), acc_created ) > 60
 // ORDER BY `accounts_user`.`acc_created` DESC";
        $data1a1 =  $this->dbF->getRows($sql1a1);

echo "<tr  class='btn-success'> <td>Catchup Calls 3 months</td></tr>";
echo ' <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>Name - Email</th>
                         <th>Practice name - Phone</th>
                        <th>Address</th>
                        <th>Account Created</th>
                        <th>Last Login</th>
                        
                    </thead>';
  foreach($data1a1 as $val){
           
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
    $userInfo   = $this->dbF->getRows($sql,array($id));



             $pn =  $this->webUserInfoArray($userInfo,'practice name');
           $phone =  $this->webUserInfoArray($userInfo,'phone');
           $address =  $this->webUserInfoArray($userInfo,'address');
           $city =  $this->webUserInfoArray($userInfo,'city');
           $country =  $this->webUserInfoArray($userInfo,'country');

            $account_type =  $this->webUserInfoArray($userInfo,'account_type');

if($account_type != "Employee"){
 $i++;

            echo "<tr>
                    <td>$i</td>
                    <td>$acc_name ($account_type) - $acc_email</td>
                     <td>$pn - $phone</td>
                    <td>$address $city $country</td>
                    <td>$acc_created</td>
                    <td>$last_login</td>
            
                  </tr>";
        }

}



if(isset($_POST['dateIs']) && $_POST['dateIs'] != ""){
$sql1a1  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_POST[dateIs]', INTERVAL 195 DAY) AND DATE_SUB('$_POST[dateIs]', INTERVAL 180 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";
}else{
$sql1a1  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 195 DAY) AND DATE_SUB(CURDATE(), INTERVAL 180 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";
}




 


 //   $sql11  = "SELECT * FROM accounts_user WHERE acc_created >= curdate() - INTERVAL DAYOFWEEK(curdate())+67 DAY AND DATEDIFF( CURDATE(), acc_created ) > 60
 // ORDER BY `accounts_user`.`acc_created` DESC";
        $data1a1 =  $this->dbF->getRows($sql1a1);

echo "<tr  class='btn-success'> <td>Catchup Calls 6 months</td></tr>";
echo ' <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>Name - Email</th>

                         <th>Practice name - Phone</th>
                        <th>Address</th>


                        <th>Account Created</th>
                        <th>Last Login</th>
                        
                    </thead>';
  foreach($data1a1 as $val){
            
            $id = $val['acc_id'];
            $acc_created = date("D j M Y",strtotime($val['acc_created']));
if(!empty($val['last_login'])){
 $last_login = date("D j M Y",strtotime($val['last_login']));
}else{
     $last_login = '';
}
             $sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
    $userInfo   = $this->dbF->getRows($sql,array($id));
            $acc_email = $val['acc_email'];
            $acc_name = $val['acc_name'];
             $pn =  $this->webUserInfoArray($userInfo,'practice name');
           $phone =  $this->webUserInfoArray($userInfo,'phone');
           $address =  $this->webUserInfoArray($userInfo,'address');
           $city =  $this->webUserInfoArray($userInfo,'city');
           $country =  $this->webUserInfoArray($userInfo,'country');


            $account_type =  $this->webUserInfoArray($userInfo,'account_type');

if($account_type != "Employee"){


$i++;
            echo "<tr>
                    <td>$i</td>
                    <td>$acc_name ($account_type) - $acc_email</td>
                     <td>$pn - $phone</td>
                    <td>$address $city $country</td>
                    <td>$acc_created</td>
                    <td>$last_login</td>
            
                  </tr>";
        }


}


if(isset($_POST['dateIs']) && $_POST['dateIs'] != ""){
$oneyearQ  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB('$_POST[dateIs]', INTERVAL 375 DAY) AND DATE_SUB('$_POST[dateIs]', INTERVAL 360 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";
}else{
$oneyearQ  = "SELECT * FROM accounts_user WHERE acc_created between DATE_SUB(CURDATE(), INTERVAL 375 DAY) AND DATE_SUB(CURDATE(), INTERVAL 360 DAY)
  ORDER BY `accounts_user`.`acc_created` DESC";
}



 


 //   $sql11  = "SELECT * FROM accounts_user WHERE acc_created >= curdate() - INTERVAL DAYOFWEEK(curdate())+67 DAY AND DATEDIFF( CURDATE(), acc_created ) > 60
 // ORDER BY `accounts_user`.`acc_created` DESC";
        $oneyearData =  $this->dbF->getRows($oneyearQ);

echo "<tr  class='btn-success'> <td>Catchup Calls 12 months</td></tr>";
echo ' <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>Name - Email</th>
                         <th>Practice name - Phone</th>
                        <th>Address</th>
                        <th>Account Created</th>
                        <th>Last Login</th>
                        
                    </thead>';
  foreach($oneyearData as $val){
            
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
    $userInfo   = $this->dbF->getRows($sql,array($id));



             $pn =  $this->webUserInfoArray($userInfo,'practice name');
           $phone =  $this->webUserInfoArray($userInfo,'phone');
           $address =  $this->webUserInfoArray($userInfo,'address');
           $city =  $this->webUserInfoArray($userInfo,'city');
           $country =  $this->webUserInfoArray($userInfo,'country');


            $account_type =  $this->webUserInfoArray($userInfo,'account_type');

if($account_type != "Employee"){
    $i++;
            echo "<tr>
                    <td>$i</td>
                    <td>$acc_name ($account_type) - $acc_email</td>
                     <td>$pn - $phone</td>
                    <td>$address $city $country</td>
                    <td>$acc_created</td>
                    <td>$last_login</td>
            
                  </tr>";
        }

}



// $sql11  = "SELECT * FROM accounts_user_detail WHERE
// STR_TO_DATE( CONCAT(YEAR(CURDATE()), '-', MONTH(setting_val), '-', DAY(setting_val) ), '%Y-%m-%d' ) = DATE_ADD(CURDATE(), INTERVAL +1 DAY) AND setting_name = 'date_of_birth' and setting_val !=''
// ORDER BY `accounts_user_detail`.`setting_val`  DESC";






if(isset($_POST['dateIs']) && $_POST['dateIs'] != ""){
 


  $sql11  = "SELECT * 
FROM  accounts_user_detail 
WHERE  DATE_ADD(setting_val, 
                INTERVAL YEAR('$_POST[dateIs]')-YEAR(setting_val)
                         + IF(DAYOFYEAR('$_POST[dateIs]') >= DAYOFYEAR(setting_val),1,0)
                YEAR)  
            BETWEEN '$_POST[dateIs]' AND DATE_ADD('$_POST[dateIs]', INTERVAL 14 DAY) AND setting_name = 'date_of_birth' and setting_val !='' ORDER BY `accounts_user_detail`.`setting_val` ASC";



}else{
$sql11  = "SELECT * 
FROM  accounts_user_detail 
WHERE  DATE_ADD(setting_val, 
                INTERVAL YEAR(CURDATE())-YEAR(setting_val)
                         + IF(DAYOFYEAR(CURDATE()) >= DAYOFYEAR(setting_val),1,0)
                YEAR)  
            BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 14 DAY) AND setting_name = 'date_of_birth' and setting_val !='' ORDER BY `accounts_user_detail`.`setting_val` ASC";
}






$data11 =  $this->dbF->getRows($sql11);

echo "<tr  class='btn-success'> <td>Birth Day</td></tr>";
echo ' <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>Name - Email</th>
                        <th>Birth Day</th>
                         <th>Practice name - Phone</th>
                        <th>Address</th>
                        <th>Account Created</th>
                        <th>Last Login</th>
                        
                    </thead>';
foreach($data11 as $val){

$id = $val['id_user'];


$sql11a  = "SELECT * FROM accounts_user WHERE acc_id = '$id'";
$data11a =  $this->dbF->getRow($sql11a);



            $acc_created = date("D j M Y",strtotime($data11a['acc_created']));
            $bd = date("D j M Y",strtotime($val['setting_val']));
if(!empty($data11a['last_login'])){
 $last_login = date("D j M Y",strtotime($data11a['last_login']));
}else{
     $last_login = '';
}
           

            $sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
    $userInfo   = $this->dbF->getRows($sql,array($id));


    
             $pn =  $this->webUserInfoArray($userInfo,'practice name');
           $phone =  $this->webUserInfoArray($userInfo,'phone');
           $address =  $this->webUserInfoArray($userInfo,'address');
           $city =  $this->webUserInfoArray($userInfo,'city');
           $country =  $this->webUserInfoArray($userInfo,'country');

 $account_type =  $this->webUserInfoArray($userInfo,'account_type');

if($account_type != "Employee"){

$i++;
            $acc_email = $data11a['acc_email'];
            $acc_name = $data11a['acc_name'];
            
            echo "<tr>
                    <td>$i</td>
                    <td>$acc_name ($account_type) - $acc_email</td>
                     <td>$bd</td>
                     <td>$pn - $phone</td>
                    <td>$address $city $country</td>
                   
                    <td>$acc_created</td>
                    <td>$last_login</td>
               
                  </tr>";
        }


}


        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }

    // public function newreportsAdd(){
        
        
    //     global $_e;
    //     if(isset($_POST['submit'])){
    //         if(!$this->functions->getFormToken('newreports')){return false;}

    //         $heading        = empty($_POST['heading'])      ? ""    : serialize($_POST['heading']);
    //         $short_desc     = empty($_POST['shortDesc'])    ? ""    : serialize($_POST['shortDesc']);
    //         $dsc            = empty($_POST['dsc'])          ? ""    : serialize($_POST['dsc']);
    //         $date           = empty($_POST['date'])         ? ""    : $_POST['date'];
    //         $publish        = empty($_POST['publish'])      ? "0"   : $_POST['publish'];
    //         $ntype          = "noti";
    //         $publishDate    = empty($_POST['publish_date']) ? ""    : date('Y-m-d',strtotime($_POST['publish_date']));
    //         $comment        = empty($_POST['comment'])      ? "0"   : $_POST['comment'];
    //         $file           = empty($_FILES['image']['name'])? false    : true;
    //         $returnImage    = "";
    //         $date           =   date('Y-m-d',strtotime($date));
    //         try{
    //             $this->db->beginTransaction();

    //             $sql      =   "INSERT INTO `reports`(
    //                                 `date`, `heading`, `shortDesc`,
    //                                  `dsc`, `image`,
    //                                  `comment`, `publish`,`publish_date`,
    //                                  `type`)
    //                                 VALUES (?,?,?,  ?,?,   ?,?,?, ?)";

    //             if($file){
    //                 $returnImage =  $this->functions->uploadSingleImage($_FILES['image'],'reports');
    //                 if($returnImage==false){
    //                     throw new Exception('Image File Error');
    //                 }
    //             }

    //             $array   = array($date,$heading,$short_desc,
    //                 $dsc,$returnImage,
    //                 $comment,$publish,$publishDate,$ntype);

    //             $this->dbF->setRow($sql,$array,false);

    //             $this->db->commit();
    //             if($this->dbF->rowCount>0){
    //                $heading = translateFromSerialize($heading);
    //                 $content = translateFromSerialize($short_desc)."<br>".translateFromSerialize($dsc);
    //                 $data = $this->dbF->getRows("SELECT * FROM `accounts_user` WHERE `acc_type` = '1'");
    //                 foreach ($data as $key => $value) {
    //                     $email = $value['acc_email'];
    //                     $uid = $value['acc_id'];
    //                    $this->functions->send_mail($email,$heading,$content);
    //                    $this->functions->push_notification($heading,translateFromSerialize($short_desc),$this->functions->getUserPlayerId($uid));
    //                      $sql  = "INSERT INTO `notification_record` (`user`,`type`,`notification`,`playerid`) VALUES (?,?,?,?)";
    //                           $array   = array($uid,$ntype,$content,$this->functions->getUserPlayerId($uid));
    //                           $this->dbF->setRow($sql,$array);
                              
    //                 }
    //                 $this->functions->notificationError(_uc($_e['reports']),($_e['reports Save Successfully']),'btn-success');
    //                 $this->functions->setlog(_uc($_e['Added']),_uc($_e['reports']),$this->dbF->rowLastId,($_e['reports Save Successfully']));
    //             }else{
    //                 $this->functions->notificationError(_uc($_e['reports']),($_e['reports Save Failed.']),'btn-danger');
    //             }
    //         }catch (Exception $e){
    //             if($returnImage!==false){
    //                 $this->functions->deleteOldSingleImage($returnImage);
    //             }
    //             $this->db->rollBack();
    //             $this->dbF->error_submit($e);
    //             $this->functions->notificationError(_uc($_e['reports']),($_e['reports Save Failed.']),'btn-danger');
    //         }
    //     } // If end
    
        
    // }

    // public function reportsEditSubmit(){
    //     global $_e;
    //     if(isset($_POST['submit'])  && isset($_POST['editId'])){
    //          if(!$this->functions->getFormToken('editreports')){return false;}

    //         $heading        = empty($_POST['heading'])      ? ""    : serialize($_POST['heading']);
    //         $short_desc     = empty($_POST['shortDesc'])    ? ""    : serialize($_POST['shortDesc']);
    //         $dsc            = empty($_POST['dsc'])          ? ""    : serialize($_POST['dsc']);
    //         $date           = empty($_POST['date'])         ? ""    : $_POST['date'];
    //         $publish        = empty($_POST['publish'])      ? "0"   : $_POST['publish'];
    //         $ntype           = "noti";
    //           // $ntype           = empty($_POST['ntype'])         ? ""   : $_POST['ntype'];
    //         $publishDate    = empty($_POST['publish_date']) ? ""    : date('Y-m-d',strtotime($_POST['publish_date']));
    //         $comment        = empty($_POST['comment'])      ? "0"   : $_POST['comment'];
    //         $file           = empty($_FILES['image']['name'])? false    : true;
    //         $date           =   date('Y-m-d',strtotime($date));
    //         $oldImg         = empty($_POST['oldImg'])       ? ""    : $_POST['oldImg'];
    //         $returnImage    = $oldImg;
    //         try{
    //             $this->db->beginTransaction();
    //             $lastId   =   $_POST['editId'];

    //             if($file){
    //                 $this->functions->deleteOldSingleImage($oldImg);
    //                 $returnImage =  $this->functions->uploadSingleImage($_FILES['image'],'reports');
    //                 if($returnImage==false){
    //                     throw new Exception('Image File Error');
    //                 }
    //             }else{
    //                 $this->imageName = $oldImg;
    //             }

    //             $sql    =  "UPDATE `reports` SET
    //                                 `date`=?,
    //                                 `heading`=?,
    //                                 `shortDesc`=?,
    //                                 `dsc` =?  ,
    //                                 `image`=?,
    //                                 `comment`=?,
    //                                 `publish`=?,
    //                                 `publish_date`=?,
    //                                 `type` = ?
    //                                    WHERE id = '$lastId'
    //                             ";

    //             $array   = array($date,$heading,$short_desc,
    //                 $dsc,$returnImage,
    //                 $comment,$publish,$publishDate,$ntype);

    //             $this->dbF->setRow($sql,$array,false);

    //             $this->db->commit();

    //             if($this->dbF->rowCount>0){
    //                 $this->functions->notificationError(_uc($_e['reports']) ,_uc($_e['reports Save Successfully']) ,'btn-success');
    //                 $this->functions->setlog(_uc($_e['UPDATE']) ,_uc($_e['reports']) ,$this->dbF->rowLastId,_uc($_e['reports Save Successfully']) );
    //             }else{
    //                 $this->functions->notificationError(_uc($_e['reports']) ,_uc($_e['reports Save Failed']) ,'btn-danger');
    //             }

    //         }catch (Exception $e){
    //             if($file && $returnImage!==false){
    //                 $this->functions->deleteOldSingleImage($returnImage);
    //             }
    //             $this->db->rollBack();
    //             $this->dbF->error_submit($e);
    //             $this->functions->notificationError(_uc($_e['reports']) ,_uc($_e['reports Save Failed']) ,'btn-danger');
    //         }

    //     }
    // }


//     public function reportsNew(){
//         global $_e;
//         $token       = $this->functions->setFormToken('newreports',false);
//         //No need to remove any thing,, go in developer setting table and set 0
//         echo '<form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">'.
//            $token.
//            '<div class="form-horizontal">

//            <!-- Nav tabs -->
//             <ul class="nav nav-tabs tabs_arrow" role="tablist">
//                 <li class="active"><a href="#homeP" role="tab" data-toggle="tab">'. _uc($_e['Detail']) .'</a></li>
//                 <li><a href="#setting" role="tab" data-toggle="tab">'. _uc($_e['reports Setting']) .'</a></li>
//             </ul>


//            <!-- Tab panes -->
//               <div class="tab-content">
//                   <div class="tab-pane fade in active container-fluid" id="homeP">
//                     <h2  class="">'. _uc($_e['reports Detail']) .'</h2>
//            ';

//         $lang = $this->functions->IbmsLanguages();
//         if($lang != false){
//             $lang_nonArray = implode(',', $lang);
//         }
//         echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';

//         echo '<div class="panel-group" id="accordion">';
//         for ($i = 0; $i < sizeof($lang); $i++) {
//             if($i==0){
//                 $collapseIn = ' in ';
//             }else{
//                 $collapseIn = '';
//             }
//             echo '<div class="panel panel-default">
//                           <div class="panel-heading">
//                                  <a data-toggle="collapse" data-parent="#accordion" href="#'.$lang[$i].'">
//                                     <h4 class="panel-title">
//                                         '.$lang[$i].'
//                                     </h4>
//                                  </a>
//                           </div>
//                           <div id="'.$lang[$i].'" class="panel-collapse collapse '.$collapseIn.'">
//                              <div class="panel-body">';

//                                 //Title
//                                 echo '<div class="form-group">
//                                             <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['TITLE']) .'</label>
//                                             <div class="col-sm-10  col-md-9">
//                                                 <input type="text" name="heading['.$lang[$i].']"  maxlength="150"  class="form-control" placeholder="'. _uc($_e['reports Title']) .'">
//                                             </div>
//                                         </div>';

//                                 //Short Desc
//                                 echo '<div class="form-group">
//                                         <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Short Description']) .'</label>
//                                         <div class="col-sm-10  col-md-9">
//                                             <textarea name="shortDesc['.$lang[$i].']" class="form-control" maxlength="500" placeholder="'. _uc($_e['Enter Short Description']) .'"></textarea>
//                                         </div>
//                                    </div>';

//                                 //Desc
//                                 echo '<div class="form-group">
//                                         <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Detail']) .'</label>
//                                         <div class="col-sm-10  col-md-9">
//                                             <textarea name="dsc['.$lang[$i].']" id="dsc_'.$lang[$i].'_" placeholder="'. _uc($_e['Enter Full Detail']) .'" class="ckeditor"></textarea>
//                                         </div>
//                                    </div>';

//             echo '           </div> <!-- panel-body end -->
//                           </div> <!-- collapse end-->
//                     </div><!-- panel end-->';
//         }


//         echo '</div> <!-- .accordian end -->';

//         echo '</div> <!-- homeP Tab End -->
//                      <div class="tab-pane fade in container-fluid" id="setting">
//                             <h2  class="">'. _uc($_e['reports Setting']) .'</h2>
//                 ';

//                         //Date
//                         if($this->functions->developer_setting('reports_date')=='1'){
//                             echo '<div class="form-group">
//                                 <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Date']) .'</label>
//                                 <div class="col-sm-10  col-md-9">
//                                     <input type="text" name="date" value="'.date("Y-m-d").'" class="date form-control" placeholder="'. _uc($_e['reports Date']) .'">
//                                 </div>
//                             </div>';
//                         }else{ echo '<input type="hidden" name="date" value="" class="form-control">';}

                  

//                         //Publish
//                         echo '<div class="form-group">
//                                     <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Publish']) .'</label>
//                                     <div class="col-sm-10  col-md-9">
//                                         <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Publish']) .'" data-off-label="'. _uc($_e['Draft']) .'">
//                                             <input type="checkbox" name="publish" value="1">
//                                         </div>
//                                     </div>
//                                </div>';


//                         //Publish Date
//                         echo '<div class="form-group" style="display:none">
//                                     <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['PUBLISH DATE']) .'</label>
//                                     <div class="col-sm-10  col-md-9">
//                                         <input type="text" value="'.date("Y-m-d").'" name="publish_date" class="date form-control" placeholder="'. ($_e['Leave Blank to publish now']) .'">
//                                     </div>
//                                </div>';


//                         //Banner
//                         if($this->functions->developer_setting('reports_image')=='1'){
//                             echo '<div class="form-group">
//                                     <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['reports Image (278x278 px)']) .'</label>
//                                     <div class="col-sm-10  col-md-9">
//                                         <input type="file" name="image" class="btn-file btn btn-primary">
//                                     </div>
//                                </div>';
//                         }else{ echo '<input type="hidden" name="mage" value="" class="form-control">';}

//                         //echo '<input type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary"/>';
//                     echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _u($_e['SAVE']) .'</button>';

//         echo "</div><!-- setting tabs end -->
//         </div> <!-- tab-content end -->
//     </div> <!-- container end -->
// </form>";
//     }

//     public function reportsEdit(){
//         global $_e;
//         $token  = $this->functions->setFormToken('editreports',false);
//         $id     =   $_GET['pageId'];
//         $sql    =   "SELECT * FROM reports where id = ? ";
//         $data   =   $this->dbF->getRow($sql,array($id));
//         if($this->dbF->rowCount==0){
//             echo "reports Not Found For Update";
//             return false;
//         }

//         //No need to remove any thing,, go in developer setting table and set 0
//         echo '<form method="post" action="-reports?page=reports" class="form-horizontal" role="form" enctype="multipart/form-data">'.
//             $token.
//             '<input type="hidden" name="editId" value="'.$id.'"/>
//             <div class="form-horizontal">

//             <!-- Nav tabs -->
//             <ul class="nav nav-tabs tabs_arrow" role="tablist">
//                 <li class="active"><a href="#homeP" role="tab" data-toggle="tab">'. _uc($_e['Detail']) .'</a></li>
//                 <li><a href="#setting" role="tab" data-toggle="tab">'. _uc($_e['reports Setting']) .'</a></li>
//             </ul>


//            <!-- Tab panes -->
//               <div class="tab-content">
//                   <div class="tab-pane fade in active container-fluid" id="homeP">
//                     <h2  class="">'. _uc($_e['reports Detail']) .'</h2>
//            ';

//         $lang = $this->functions->IbmsLanguages();
//         if($lang != false){
//             $lang_nonArray = implode(',', $lang);
//         }
//         echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';

//         echo '<div class="panel-group" id="accordion">';

//         $heading = unserialize($data['heading']);
//         $shortDesc =  unserialize($data['shortDesc']);
//         $dsc =  unserialize($data['dsc']);

//         for ($i = 0; $i < sizeof($lang); $i++) {
//             if($i==0){
//                 $collapseIn = ' in ';
//             }else{
//                 $collapseIn = '';
//             }
//             echo '<div class="panel panel-default">
//                           <div class="panel-heading">
//                                  <a data-toggle="collapse" data-parent="#accordion" href="#'.$lang[$i].'">
//                                     <h4 class="panel-title">
//                                         '.$lang[$i].'
//                                     </h4>
//                                  </a>
//                           </div>
//                           <div id="'.$lang[$i].'" class="panel-collapse collapse '.$collapseIn.'">
//                              <div class="panel-body">';

//             //Title
//                             echo '<div class="form-group">
//                                     <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['TITLE']) .'</label>
//                                     <div class="col-sm-10  col-md-9">
//                                         <input value="'.$heading[$lang[$i]].'" type="text" name="heading['.$lang[$i].']"  maxlength="150"  class="form-control" placeholder="'. _uc($_e['reports Title']) .'">
//                                     </div>
//                                 </div>';

//             //Short Desc
//                             echo '<div class="form-group">
//                                     <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Short Description']) .'</label>
//                                     <div class="col-sm-10  col-md-9">
//                                         <textarea name="shortDesc['.$lang[$i].']" class="form-control" maxlength="500" placeholder="'. _uc($_e['Enter Short Description']) .'">'.$shortDesc[$lang[$i]].'</textarea>
//                                     </div>
//                                 </div>';

//             //Desc
//                             echo '<div class="form-group">
//                                     <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Detail']) .'</label>
//                                     <div class="col-sm-10  col-md-9">
//                                         <textarea name="dsc['.$lang[$i].']" id="dsc_'.$lang[$i].'_" placeholder="'. _uc($_e['Enter Full Detail']) .'" class="ckeditor">'.$dsc[$lang[$i]].'</textarea>
//                                     </div>
//                                </div>';


//             echo '        </div> <!-- panel-body end -->
//                       </div> <!-- collapse end-->
//                 </div><!-- panel end-->';
//         }


//         echo '</div> <!-- .accordian end -->';

//         echo '</div> <!-- homeP Tab End -->
//                      <div class="tab-pane fade in container-fluid" id="setting">
//                             <h2  class="">'. _uc($_e['reports Setting']) .'</h2>
//                 ';

//         //Date
//         if($this->functions->developer_setting('reports_date')=='1'){
//             echo '<div class="form-group">
//                     <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Date']) .'</label>
//                     <div class="col-sm-10  col-md-9">
//                         <input type="text" name="date" value="'.$data['date'].'"  class="date form-control" placeholder="'. _uc($_e['reports Date']) .'">
//                     </div>
//                  </div>';
//         }else{ echo '<input type="hidden" name="date" value="" class="form-control">';}

//         //Type
//         // if($this->functions->developer_setting('reports_comment')=='1'){
      
//         // }else{ echo '<input type="hidden" name="comment" value="0" class="form-control">';}

//         //Publish
//         $checked = "";
//         if($data['publish']=='1'){$checked='checked';}
//         echo '<div class="form-group">
//                     <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Publish']) .'</label>
//                     <div class="col-sm-10  col-md-9">
//                         <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Publish']) .'" data-off-label="'. _uc($_e['Draft']) .'">
//                             <input type="checkbox" name="publish" value="1" '.$checked.'>
//                         </div>
//                     </div>
//                </div>';


//         //Publish Date
//         $publish_date = empty($data['publish_date'])?"":date('m/d/Y',strtotime($data['publish_date']));
//         echo '<div class="form-group" style="display:none">
//                     <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['PUBLISH DATE']) .'</label>
//                     <div class="col-sm-10  col-md-9">
//                         <input type="text" value="'.$publish_date.'" name="publish_date" class="date form-control" placeholder="'. ($_e['Leave Blank to publish now']) .'">
//                     </div>
//                </div>';

//         //Banner
//         if($this->functions->developer_setting('reports_image')=='1'){
//             $img = "";
//             if($data['image']!=''){
//                 $img=$data['image'];
//                 echo "<input type='hidden' name='oldImg' value='$img' />";
//                 echo '<div class="form-group">
//                     <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Old reports Image']) .'</label>
//                     <div class="col-sm-10  col-md-9">
//                         <img src="../images/'.$img.'" style="max-height:250px;" >
//                     </div>
//                </div>';
//             }

//             echo '<div class="form-group">
//                     <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['reports Image (278x278 px)']) .'</label>
//                     <div class="col-sm-10  col-md-9">
//                         <input type="file" name="image" class="btn-file btn btn-primary">
//                     </div>
//                </div>';
//         }else{ echo '<input type="hidden" name="image" value="" class="form-control">';}

//         //echo '<input type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary"/>';
//         echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _u($_e['SAVE']) .'</button>';

//         echo "</div><!-- setting tabs end -->
//         </div> <!-- tab-content end -->
//     </div> <!-- container end -->
// </form>";

//     }
}
?>
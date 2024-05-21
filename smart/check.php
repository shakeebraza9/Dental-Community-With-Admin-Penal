<?php
include('global.php');

// userNotLoggedinDay3
// echo "<pre>";var_dump($_SESSION);

    // $return1 = $functions->someDayOfSignup("someDayOfSignup",1);
    // $return2 = $functions->someDayOfTrial("someDayOfTrial",3);
    // $return2 = $functions->notSubmitStaffDoc("staffDocNotSubmit");
    // $return3 = $functions->someDayOfTrial("someDayOfTrial",6);
    // $return4 = $functions->someDayOfTrial("someDayOfTrial",7);
    // $return5 = $functions->notLoggedinTrial("trialNotLoggedinDay",3);


    // echo $table ='<table border="1">
    //             <tr>
    //                 <td>name</td>
                    
    //                 <td>email</td>
    //                 <td>type</td>
    //                 <td>msg</td>
    //                 <td>subject</td>
                    
    //                 <td>acc_create</td>
                    
                    
    //             </tr>
    //             '.$return5.'
    //         </table>';
            
            
          
          
          
            
            
            
            
$data= $functions->dbF->getRows("SELECT `acc_id` FROM `accounts_user` WHERE 
last_login NOT BETWEEN DATE_ADD(CURDATE(), INTERVAL -31 DAY) AND 
DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND 
acc_type=1 AND 
acc_id = '6652' AND 
acc_id NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') AND 
acc_id NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_name='account_under' AND (setting_val IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') OR setting_val IN (SELECT acc_id FROM `accounts_user` WHERE acc_type=0)) )");
	foreach ($data as  $value) {
		$user=$value['acc_id'];
		$functions->notifications('notlogin30', $user);

	}







$sqlnewuser = "SELECT * FROM accounts_user WHERE acc_created between date_sub(now(),INTERVAL 1 WEEK) and now() limit 1";
    $data = $dbF->getRow($sqlnewuser);
        // foreach($datanewuser as $key => $value){
            $id = $data['acc_id']; 
            // $start_date = date('d-M-Y',strtotime($value['acc_created'])) ;
            // $date = strtotime($start_date);
            // $date = strtotime("+7 day", $date);
            // $UserDate = date('d-M-Y', $date);
           
            // $edit_id = "";
            // $title = "";
            // $title_id = "";
            // if ( $UserDate == $todayDate) {
                    // $functions->setlog(
                    //     "One week notification publish to (".$this->UserName($id).":".$id.")",
                    //     $this->UserName($id) . " : $id",
                    //     $edit_id, $title . " : " . $title_id);
                        $functions->notifications('oneweek', $id);
            // }   
        // }
            
            ?>
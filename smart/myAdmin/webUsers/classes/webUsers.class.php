<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class webUsers extends object_class{
    public $productF;
    public $imageName;
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
        
        $_w['All WebUser'] = '' ;
        $_w['Add New'] = '' ;
        $_w['Not Allow'] = '' ;
        $_w['Add New'] = '' ;
        $_w['Form'] = '' ;
        $_w['Profile Add Successfully!'] = '' ;
        $_w['Profile Add Failed!'] = '' ;
        $_w['Employee/User Add fail please try again.!'] = '' ;
        $_w['Duplicate Email, User Already Exist.'] = '' ;

        $_w['Manage WebUsers'] = '';
        $_w['Verify Users'] = '';
        $_w['Not Verify'] = '';
        $_w['UnVerify Users'] = '';
        $_w['SNO']  =   '';
        $_w['USER NAME'] ='';
        $_w['Account Create'] = '';
        $_w['Account Status'] = '';
        $_w['Account Type'] = '';
        $_w['ACTION'] = '';
        $_w['Active'] = '';
        $_w['Active User'] = '';
        $_w['Address'] = '';
        $_w['Admin Update with Name : {{name}}'] = '';
        $_w['Admin User Group'] = '';
        $_w['Admin Users'] = '';
        $_w['adminUser Update fail please try again.!'] = '';
        $_w['adminUser Update fail please try again.! Or Duplicate Email.'] = '';
        $_w['Are You Sure You Want TO Update?'] = '';
        $_w['Back To WebUsers'] = '';
        $_w['Back To AdminUsers'] = '';
        $_w['Back To AdminGroups'] = '';
        $_w['City'] = '';
        $_w['Country'] = '';
        $_w['Admin Panel'] = '';
        $_w['Date Of Birth'] = '';
        $_w['DeActive'] = '';
        $_w['DeActive User'] = '';
        $_w['DeActive Users'] = '';
        $_w['Delete Email'] = '';
        $_w['Delete Fail Please Try Again.'] = '';
        $_w['Delete Group'] = '';
        $_w['Delete User'] = '';
        $_w['Draft Users'] = '';
        $_w['Edit User Info'] = '';
        $_w['Email'] = '';
        $_w['Edit User Group Permissions'] = '';
        $_w['Female'] = '';
        $_w['Gender'] = '';
        $_w['Pin'] = '';
        $_w['Old Pin'] = '';
        $_w['Groups'] = '';
        $_w['Group add'] = '';
        $_w['Group Name'] = '';
        $_w['GROUP NAME'] = '';
        $_w['Group Update'] = '';
        $_w['Invalid Email Address! Or Some Thing Went Wrong'] = '';
        $_w['ITEMS IN CART'] = '';
        $_w['Last Update'] = '';
        $_w['Male'] = '';
        $_w['Manage Admin Users'] = '';
        $_w['Manage Admin Groups'] = '';
        $_w['Name'] = '';
        $_w['New Admin Add with Name : {{name}}'] = '';
        $_w['New Admin User group Add with name : {{name}}'] = '';
        $_w['New AdminUser'] = '';
        $_w['New Group'] = '';
        $_w['New Group Add Failed'] = '';
        $_w['New Group Add Successfully'] = '';
        $_w['New Group Update Failed'] = '';
        $_w['New Group Update Successfully'] = '';
        $_w['Not Access'] = '';
        $_w['New Users'] = '';
        $_w['ORDER CANCEL'] = '';
        $_w['ORDER DONE'] = '';
        $_w['ORDER PENDING'] = '';
        $_w['ORDER STATUS'] = '';
        $_w['ORDER SUBMIT'] = '';
        $_w['OTHERS STATUS'] = '';
        $_w['OWNER'] = '';
        $_w['Selected SubTotal'] = '';
        $_w['User Orders'] = '';
        $_w['Password'] = '';
        $_w['Password Not Matched!'] = '';
        $_w['Old Pin Not Matched!'] = '';
        $_w['Password Required!'] = '';
        $_w['Permissions'] = '';
        $_w['Phone'] = '';
        $_w['Post Code'] = '';
        $_w['Profile Update Failed!'] = '';
        $_w['Profile Update Successfully!'] = '';
        $_w['Read Only'] = '';
        $_w['Read, Write and Delete'] = '';
        $_w['Retype Password'] = '';
        $_w['Save'] = '';
        $_w['This Is Owner Account Please Go Back:'] = '';
        $_w['Update'] = '';
        $_w['Update AdminUser'] = '';
        $_w['Update Fail Please Try Again.'] = '';
        $_w['USER EMAIL'] = '';
        $_w['USER FROM'] = '';
        $_w['User Group'] = '';
        $_w['Users'] = '';
        $_w['WebUsers'] = '';
        $_w['WebUser Update fail please try again.!'] = '';
        $_w['Write Only'] = '';
        $_w['WebUsers Management'] = '';
        $_w['Page Not Found.'] = '';
        $_w['Admin User'] = '';
        $_w['Admin User group Update with name : {{name}}'] = '';
        $_w['Make Sponsor'] = '' ;
        $_w['DeActive Sponsor'] = '' ;
        $_w['Are You Sure You Want TO Change Sponsor Status?'] = '' ;
        $_w['Employee'] = '' ;
        $_w['Yes'] = '' ;
        $_w['No'] = '' ;
        $_w['Designation'] = '' ;
        $_w['Emergency Contact'] = '' ;
        $_w['Image'] = '' ;
        $_w['Standard'] = '' ;
        $_w['Trial'] = '' ;
        $_w['Trial Expiry Date'] = '' ;
        $_w['Trial Accounts'] = '' ;
        $_w['User Type'] = '' ;
        $_w['Gold'] = '' ;
        $_w['Premium'] = '' ;
        $_w['Sort Position'] = '' ;
        $_w['Initial Health Form'] = '' ;
        $_w['Master'] = '' ;
        $_w['CEO'] = '' ;
        $_w['Practice'] = '' ;
        $_w['Web Users Management'] = '' ;
        $_w['Practice Name'] = '' ;
        $_w['ACCOUNT TYPE'] = '' ;
        $_w['USER TYPE'] = '' ;
        $_w['LAST LOGIN'] = '' ;
        $_w['Retype Pin'] = '' ;
        $_w['STATUS'] = '' ;
        $_w['LOGGIN'] = '' ;
        $_w['LOGGIN & HISTORY'] = '' ;
        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,"Users Management");
    }

    public function userSelectOptionList(){
        //Payment type select box create
        $sql  = "SELECT acc_id,acc_name,acc_email FROM accounts_user WHERE acc_type = '1' ORDER BY acc_name ASC ";
        $data =  $this->dbF->getRows($sql);
        $option='';
        foreach($data as $key=>$val){
            $option.= "<option value='$val[acc_id]'>$val[acc_name] -- ($val[acc_email])</option>";
        }
        return $option;
    }
    public function accountType($type){
        if($type=='practice'){
        $sql  = "SELECT acc_id,acc_name,acc_email FROM accounts_user WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='practice' OR `setting_val`='master' ) ORDER BY acc_name ASC";
        }elseif($type=='master'){
        $sql  = "SELECT acc_id,acc_name,acc_email FROM accounts_user WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='master' ) ORDER BY acc_name ASC";
        }
        $data =  $this->dbF->getRows($sql);
        $option='';
        foreach($data as $key=>$val){
            $option.= "<option value='$val[acc_id]'>$val[acc_name] -- ($val[acc_email])</option>";
        }
        return $option;
    }
    public function accountRole(){
        $sql  = "SELECT `setting_val` FROM `ibms_setting`  WHERE `setting_name`='account_role'";
        $data =  $this->dbF->getRow($sql);
        $ids = explode(",",$data[0]);
        $option = '';
        foreach($ids as $key=>$val){
            $option.= "<option value='$val'>$val</option>";
        }
        return $option;
    }
     public function UserType2($id){
          $sql = "SELECT `setting_val` FROM `accounts_user_detail` WHERE  `setting_name`='superuser' AND `id_user`= ? ";
        $data = $this->dbF->getRow($sql,array($id));
        return $data[0];
     }
     public function UserType($id){
        $sql = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_type' AND `id_user`= ? ";
        $data = $this->dbF->getRow($sql,array($id));
    
    return $data[0];
    }
    public function webUsersView(){
        global $_e;
       $uniq=uniqid('id');
        $href = 'webUsers/webUsers_ajax.php?page=active_WebUsers';
      

            echo  '
            <div class="table-responsive">
            <table class="table table-hover tableIBMS dTable_ajax " data-href="'.$href.'" data-uniq="'.$uniq.'">
                    <thead>
                         <th>'._u($_e['SNO']).'</th>
                        <th>'._u($_e['USER NAME']).'</th>
                        <th>'._u($_e['USER EMAIL']).'</th>
                        <th>'._u($_e['LAST LOGIN']).'</th>
                        <th>'._u($_e['ACCOUNT TYPE']).'</th>
                        <th>'._u($_e['USER TYPE']).'</th>
                        <th>'._u($_e['STATUS']).'</th>
                        <th>'._u($_e['USER FROM']).'</th>
                        <th>'._u($_e['LOGGIN & HISTORY']).'</th>
                        <th>'._u($_e['ACTION']).'</th>
                    </thead>
                <tbody>';
        $sql  = "SELECT * FROM accounts_user WHERE acc_type = '1' ORDER BY acc_id DESC ";
        $data =  $this->dbF->getRows($sql);
        $i = 0;
        //foreach($data as $val){
//             $i++;
//             $id = $val['acc_id'];
//             $pName = "";
//             $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='account_type'");
//             $account_type = $d[0];
//             $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='user_type'");
//             $user_type = $d[0];
//             $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='account_under'");
//             if($account_type != 'Master'){$pName = $this->functions->UserName($d[0]);}
//             $d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='role' AND `id_user`='$id'");
//             $role = $d[0];
//             $setPswrdHash = $val['acc_email'].'--'.$this->functions->decode($val['acc_pass']);
//             $setPswrdHash = base64_encode($setPswrdHash);
//             $link        =   WEB_URL . "/login.php?".'set='.$setPswrdHash;
//             echo "<tr>
//                     <td>$i</td>
//                     <td>$val[acc_name] ($role)</td>
//                     <td>$val[acc_email]</td>
//                     <td>$val[last_login]</td>
//                     <td>$account_type ($pName)</td>
//                     <td>$user_type</td>
                  
        
//                     <td>"; 
// if($this->UserType2($id) == "on"){ echo "SuperUser";}
// else{echo  $this->UserType($id);}
//                       echo"</td>
//                     <td>$val[acc_created]</td>
//                     <td>
//                         <div class='btn-group btn-group-sm'>

//                         <a data-id='$id' data-val='1' href='--setting?page=history&id=$id' target='_blank' class='btn' title='Activity Log'>
//                                 <i class='glyphicon glyphicon-time'></i>
//                             </a>
//                         <a data-id='$id' data-val='1' href='$link' target='_blank' class='btn' title='User Login'>
//                                 <i class='glyphicon glyphicon-user'></i>
//                             </a>

//                             <a data-id='$id' data-val='0' onclick='activeWebUser(this);' class='btn' title='".$_e['DeActive User']."'>
//                                 <i class='glyphicon glyphicon-thumbs-down trash'></i>
//                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
//                             </a>

//                             <a data-id='$id' href='-webUsers?page=edit&userId=$id' class='btn'>
//                                 <i class='glyphicon glyphicon-edit'></i>
//                             </a>

//                             <a data-id='$id' onclick='deleteWebUser(this);' class='btn'   title='".$_e['Delete Email']."'>
//                                 <i class='glyphicon glyphicon-trash trash'></i>
//                                 <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
//                             </a>
//                         </div>
//                     </td>
//                   </tr>";
//         }


        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }

    public function webUsersPending(){
              global $_e;
          $href = 'webUsers/webUsers_ajax.php?page=draft_WebUsers';
          $uniq=uniqid('id');

            echo  '
            <div class="table-responsive">
            <table class="table table-hover tableIBMS dTable_ajax " data-href="'.$href.'" data-uniq="'.$uniq.'">
                    <thead>
                       <th>'._u($_e['SNO']).'</th>
                        <th>'._u($_e['USER NAME']).'</th>
                        <th>'._u($_e['USER EMAIL']).'</th>
                        <th>'._u($_e['LAST LOGIN']).'</th>
                        <th>'._u($_e['ACCOUNT TYPE']).'</th>
                        <th>'._u($_e['USER TYPE']).'</th>
                        <th>'._u($_e['STATUS']).'</th>
                        <th>'._u($_e['USER FROM']).'</th>
                        <th>'._u($_e['LOGGIN & HISTORY']).'</th>
                        <th>'._u($_e['ACTION']).'</th>
                    </thead>
                <tbody>';
        $sql  = "SELECT * FROM accounts_user WHERE acc_type = '0' ORDER BY acc_id DESC ";
        $data =  $this->dbF->getRows($sql);
        $i = 0;
        // foreach($data as $val){
        //     $i++;
        //     $id = $val['acc_id'];
        //     $d =  $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='account_type'");
        //     $account_type = $d[0];
        //     $d =  $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='user_type'");
        //     $user_type = $d[0];
        //     echo "<tr>
        //             <td>$i</td>
        //             <td>$val[acc_name]</td>
        //             <td>$val[acc_email]</td>
        //             <td>$account_type</td>
        //             <td>$user_type</td>
        //             <td>$val[acc_created]</td>
        //             <td>
        //                 <div class='btn-group btn-group-sm'>

        //                     <a data-id='$id' data-val='1' onclick='activeWebUser(this);' class='btn' title='".$_e['DeActive User']."'>
        //                         <i class='glyphicon glyphicon-thumbs-up trash'></i>
        //                         <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
        //                     </a>

        //                     <a data-id='$id' href='-webUsers?page=edit&userId=$id' class='btn'>
        //                         <i class='glyphicon glyphicon-edit'></i>
        //                     </a>

        //                     <a data-id='$id' onclick='deleteWebUser(this);' class='btn'   title='".$_e['Delete Email']."'>
        //                         <i class='glyphicon glyphicon-trash trash'></i>
        //                         <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
        //                     </a>
        //                 </div>
        //             </td>
        //           </tr>";
        // }


        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }

    public function webUsersTrial(){
              global $_e;
          $href = 'webUsers/webUsers_ajax.php?page=trial_WebUsers';
          $uniq=uniqid('id');

            echo  '
            <div class="table-responsive">
            <table class="table table-hover tableIBMS dTable_ajax " data-href="'.$href.'" data-uniq="'.$uniq.'">
                    <thead>
                       <th>'._u($_e['SNO']).'</th>
                        <th>'._u($_e['USER NAME']).'</th>
                        <th>'._u($_e['USER EMAIL']).'</th>
                        <th>'._u($_e['LAST LOGIN']).'</th>
                        <th>'._u($_e['ACCOUNT TYPE']).'</th>
                        <th>'._u($_e['USER TYPE']).'</th>
                        <th>'._u($_e['STATUS']).'</th>
                        <th>'._u($_e['USER FROM']).'</th>
                        <th>'._u($_e['LOGGIN & HISTORY']).'</th>
                        <th>'._u($_e['ACTION']).'</th>
                    </thead>
                <tbody>';
        $sql  = "SELECT * FROM accounts_user WHERE acc_type = '1' AND acc_id IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_name='user_type' AND setting_val='Trial') ";
        $data =  $this->dbF->getRows($sql);
        $i = 0;
        // foreach($data as $val){
        //     $i++;
        //     $id = $val['acc_id'];
        //     $d =  $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='account_type'");
        //     $account_type = $d[0];
        //     $d =  $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='user_type'");
        //     $user_type = $d[0];
        //     echo "<tr>
        //             <td>$i</td>
        //             <td>$val[acc_name]</td>
        //             <td>$val[acc_email]</td>
        //             <td>$account_type</td>
        //             <td>$user_type</td>
        //             <td>$val[acc_created]</td>
        //             <td>
        //                 <div class='btn-group btn-group-sm'>

        //                     <a data-id='$id' data-val='1' onclick='activeWebUser(this);' class='btn' title='".$_e['DeActive User']."'>
        //                         <i class='glyphicon glyphicon-thumbs-up trash'></i>
        //                         <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
        //                     </a>

        //                     <a data-id='$id' href='-webUsers?page=edit&userId=$id' class='btn'>
        //                         <i class='glyphicon glyphicon-edit'></i>
        //                     </a>

        //                     <a data-id='$id' onclick='deleteWebUser(this);' class='btn'   title='".$_e['Delete Email']."'>
        //                         <i class='glyphicon glyphicon-trash trash'></i>
        //                         <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
        //                     </a>
        //                 </div>
        //             </td>
        //           </tr>";
        // }


        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }


    public function webUserAddSubmit(){
        global $_e;
        if (isset($_POST['name']) && !empty($_POST['name'])
            && isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['oldId']) && $_POST['oldId']==''
        ){

            //if(!$this->functions->getFormToken('webUserAdd')){return false;}
            try {
                $email = strip_tags(strtolower(trim($_POST['email'])));
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $id     = empty($_POST['oldId']) ? "" : $_POST['oldId'];
                    $name   = empty($_POST['name']) ? "" : $_POST['name'];
                    $roll   = empty($_POST['roll']) ? "" : $_POST['roll'];
                    $pass   = empty($_POST['pass']) ? "" : $_POST['pass'];
                    $pin    = empty($_POST['pin']) ? "000000" : $_POST['pin'];
                    $rpass  = empty($_POST['rpass']) ? "" : $_POST['rpass'];
                    $type   = empty($_POST['acc_type']) ? 1 : $_POST['acc_type'];
                $health   = empty($_POST['health_form']) ? 0 : $_POST['health_form'];

htmlspecialchars($id);
htmlspecialchars($name);
htmlspecialchars($roll);
htmlspecialchars($pass);
htmlspecialchars($rpass);
intval($pin);
intval($type);
intval($health);

                    if($pass != $rpass){
                        $msg = $_e['Password Not Matched!'];
                        return $msg;
                    }
                    if($pass == ''){
                        $msg = $_e['Password Required!'];
                        return $msg;
                    }

                    $this->db->beginTransaction();
                    $date = date('Y-m-d H:i:s');
                    $weeklyEmail = date('Y-m-d');
                    $sql = "INSERT INTO  `accounts_user` SET
                                `acc_name` = ?,
                                `acc_email` = ?,
                                `acc_type` = ?,
                                `acc_pass` = ?,
                                `acc_pin` = ?,
                                `roll` = ?,
                                `weekly_email` = ?,
                                `acc_created` = ?,
                                `health_form` = ?
                                ";

                    $password  =  $this->functions->encode($pass);
                    $pin       =  $this->functions->encode($pin);

                    $array = array($name,$email,$type,$password,$pin,$roll,$weeklyEmail,$date,$health);
                    $this->dbF->setRow($sql,$array,false);
                    if($this->dbF->hasException){
                        $msg = $_e['Duplicate Email, User Already Exist.'];
                        return $msg;
                    }

                    $lastId = $this->dbF->rowLastId;
                    $setting    = empty($_POST['signUp']) ? array() : $_POST['signUp'];

                    $sql        =   "INSERT INTO `accounts_user_detail` (`id_user`,`setting_name`,`setting_val`) VALUES ";
                    $arry       =   array();
                    foreach($setting as $key=>$val){
                        $sql .= "('$lastId',?,?) ,";
                        if (is_array($val)) {
                             $val = implode(',',$val);
                        }
                        $arry[]= $key ;
                        $arry[]= $val ;
                    }
                    $sql = trim($sql,",");
                    $this->dbF->setRow($sql,$arry,false);

                } else {
                    $AccLoginInfoT = $_e['Invalid Email Address! Or Some Thing Went Wrong'];
                    $msg = $AccLoginInfoT;
                    return $msg;
                }

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $msg = $_e['Profile Add Successfully!'];
                    $mailArray['name'] = $name;
                    $mailArray['email'] = $email;
                    $mailArray['password'] = $pass;
                    $mailArray['pin']     =   '000000';
                    $this->functions->send_mail($email,'','','accountCreate',$name,$mailArray);
                }else{
                    $msg = $_e['Profile Add Failed!'];
                }
                return $msg;
            } catch (PDOException $e) {
                $msg = $_e['Employee/User Add fail please try again.!'];
                $this->db->rollBack();
                return $msg;
            }
        }
        return "";

    }

    public function webUserEditSubmit(){
        global $_e;
        if (isset($_POST['name']) && !empty($_POST['name'])
            && isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['oldId']) && !empty($_POST['oldId'])
        ){

            if(!$this->functions->getFormToken('webUserEdit')){return false;}
            try {

                $email = strip_tags(strtolower(trim($_POST['email'])));
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $id     = empty($_POST['oldId']) ? "" : $_POST['oldId'];
                    $name   = empty($_POST['name']) ? "" : $_POST['name'];
                    $roll   = empty($_POST['roll']) ? "" : $_POST['roll'];
                    $pass   = empty($_POST['pass']) ? "" : $_POST['pass'];
                    $rpin   = empty($_POST['rpin']) ? "" : $_POST['rpin'];
                    $pin    = empty($_POST['pin']) ? "" : $_POST['pin'];
                    $rpass  = empty($_POST['rpass']) ? "" : $_POST['rpass'];
          $type   = (trim($_POST['acc_type'])=="") ? "1" : $_POST['acc_type'];
             $health   = empty($_POST['health_form']) ? 0 : $_POST['health_form'];

intval($id);
htmlspecialchars($name);
htmlspecialchars($roll);
htmlspecialchars($pass);
htmlspecialchars($rpin);
htmlspecialchars($rpass);
intval($pin);
intval($type);
intval($health);

                    $passwordStatus = false;
                    $pinStatus      = false;
                    if($pass != $rpass){
                        $msg = $_e['Password Not Matched!'];
                        return $msg;
                    }

                    if($pass != ''){
                        $passwordStatus =true;
                    }

                    if($rpin != $pin){
                        $msg = 'Pin Not Matched!';
                        $msg = $this->dbF->hardWords($msg,false);
                        return $msg;
                    }

                    if($pin != ''){
                        $pinStatus =true;
                    }

                    // if($pin != ''){
                    //     $d = $this->dbF->getRow("SELECT MD5(acc_pin) FROM accounts_user WHERE acc_id='$id'");
                    //     $chkpin = $d[0];
                    //     $oldpin =  hash("md5", $this->functions->encode($oldpin));
                    //     if($oldpin != $chkpin){
                    //         $msg = $_e['Old Pin Not Matched!'];
                    //         return $msg;
                    //     }
                    //     $pinStatus =true;
                    // }
               
                    $this->db->beginTransaction();
                    
                    $sql = "UPDATE  accounts_user SET
                                acc_name = ?,
                                acc_email = ?,
                                roll = ?,
                                acc_type = ?,
                                health_form = ?
                                WHERE acc_id = '$id'";
                    $array = array($name,$email,$roll,$type,$health);
                    $this->dbF->setRow($sql,$array,false);

                    if($passwordStatus){
                        $password  =  $this->functions->encode($pass);
                        $sql = "UPDATE  accounts_user SET
                                acc_pass = ?
                                WHERE acc_id = '$id'";
                        $array = array($password);
                        $this->dbF->setRow($sql,$array,false);
                         $this->functions->setlog("$name passwor is change  myAdmin",$this->functions->UserName($id)." : $id","",$id );
                    }

                    if($pinStatus){
                        $pin       =  $this->functions->encode($pin);
                        $sql = "UPDATE  accounts_user SET
                                acc_pin = ?
                                WHERE acc_id = '$id'";
                        $array = array($pin);
                        $this->dbF->setRow($sql,$array,false);
                         $this->functions->setlog(" $name pin is change  myAdmin",$this->functions->UserName($id)." : $id","",$id );
                    }

                    if ($type == 0 ) {
                         $this->functions->setlog("$name Account is DeActive myAdmin",$this->functions->UserName($id)." : $id","",$id );
   
                   }

                    $lastId = $id;
                    $setting    = empty($_POST['signUp']) ? array() : $_POST['signUp'];

                    $sql = "DELETE FROM `accounts_user_detail` WHERE id_user= '$id'";
                    $this->dbF->setRow($sql);

                    $sql        =   "INSERT INTO `accounts_user_detail` (`id_user`,`setting_name`,`setting_val`) VALUES ";
                    $arry       =   array();
                    foreach($setting as $key=>$val){
                        $sql .= "('$lastId',?,?) ,";
                        if (is_array($val)) {
                             $val = implode(',',$val);
                        }
                        $arry[]= $key ;
                        $arry[]= $val ;
                    }
                    $sql = trim($sql,",");
                    $this->dbF->setRow($sql,$arry,false);


                } else {
                    $AccLoginInfoT = $_e['Invalid Email Address! Or Some Thing Went Wrong'];
                    $msg = $AccLoginInfoT;
                    $this->db->rollBack();
                    return $msg;
                }

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $msg = $_e['Profile Update Successfully!'];
                }else{
                    $msg = $_e['Profile Update Failed!'];
                }
                return $msg;
            } catch (PDOException $e) {
                $msg = $_e['WebUser Update fail please try again.!'];
                $this->db->rollBack();
                return $msg;
            }
        }
        return "";
    }

    public function webUserInfoArray($data,$settingName){
        foreach($data as $val){
            if($val['setting_name']==$settingName){
                return $val['setting_val'];
            }
        }
        return "";
    }


    public function webUserEdit($id ='',$new=false){
        global $_e;
        $edit = false;
        $required = '';
        if($id=='' && $new == false){
            $id     = $_GET['userId'];
        }else if($new == true){
            $token  =    $this->functions->setFormToken('webUserAdd',false);
            $required = " required='required'";
        }


        if($new == false){
            $sql    = "SELECT * FROM accounts_user WHERE acc_id =  ? ";
            $userData   =   $this->dbF->getRow($sql,array($id));
            if(!$this->dbF->rowCount){return false;}

            $sql    = "SELECT * FROM accounts_user_detail WHERE id_user = '$id'";
            $userInfo   = $this->dbF->getRows($sql);

            $sql1    = "SELECT * FROM userdocuments WHERE user = '$id' AND category='training'";
            $mysql1   = $this->dbF->getRows($sql1);

            $sql2    = "SELECT * FROM userdocuments WHERE user = '$id' AND category='document'";
            $mysql2   = $this->dbF->getRows($sql2);
            $sql2ttl    = "SELECT count(*) as ttl FROM userevent WHERE user = '$id'";
            $mysql2ttl   = $this->dbF->getRow($sql2ttl);
            $token  =    $this->functions->setFormToken('webUserEdit',false);
            $edit = true;
        }

        $employeePage = $this->functions->developer_setting('employeePage');


        echo '<form class="form-horizontal" role="form" method="post">'.$token.'
        <input type="hidden" name="oldId" value="'.$id.'"/> ';


    if($edit){
        echo "<div class='tab-content'><div class='tab-pane fade in active container-fluid' id='form'><h2 class='tab_heading'>Form</h2>";
    }

        if($employeePage == '1'){
            echo '<div class="form-group">
                    <label class="col-sm-3  control-label"></label>
                    <div class="col-sm-10  ">
                        <img src="' . @$this->webUserInfoArray($userInfo, 'image') . '" class="userImage kcFinderImage"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">' . $_e['Image'] . '</label>
                    <div class="col-sm-10 ">

                        <div class="input-group">
                            <input type="url" name="signUp[image]" value="' . @$this->webUserInfoArray($userInfo, 'image') . '"  class="userImage form-control" placeholder="">
                            <div class="input-group-addon pointer " onclick="' . "openKCFinderImageWithImg('userImage')" . '"><i class="glyphicon glyphicon-picture"></i></div>
                        </div>
                    </div>
                </div>';
        }


        echo '<h3>Personal Details</h3>
                <div class="form-group">
                    <label for="user" class="col-sm-3 control-label">'.$_e['Name'].'</label>
                    <div class="col-sm-9">
                    <!-- patteren not working for sweden lang pattern="[a-zA-z- ]{3,50}"-->
                        <input type="text" class="form-control" name="name" id="user"
                               placeholder="'.$_e['Name'].'" value="'.@$userData['acc_name'].'" required onChange="filter(this); vali()">
                    </div>
                </div>

                <div class="form-group">
                    <label for="user" class="col-sm-3 control-label">'.$_e['Practice Name'].'</label>
                    <div class="col-sm-9">
                    <!-- patteren not working for sweden lang pattern="[a-zA-z- ]{3,50}"-->
                        <input type="text" class="form-control" name="signUp[practice name]"
                               placeholder="'.$_e['Practice Name'].'" value="'.@$this->webUserInfoArray($userInfo, 'practice name').'" required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" >'.$_e['Address'].'</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="signUp[address]" placeholder="'.$_e['Address'].'" >'.@$this->webUserInfoArray($userInfo,'address').'</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" >Personal Contact Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'phone').'" name="signUp[phone]" placeholder="Personal Contact Number" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label" >Personal Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control"  value="'.@$userData['acc_email'].'" name="email" id="inputEmail3" placeholder="Personal Email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">'.$_e['Gender'].'</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" class="gender" name="signUp[gender]" value="female">'.$_e['Female'].'
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="gender" name="signUp[gender]" value="male">'.$_e['Male'].'
                        </label>
                    </div>
                </div>
                <script>
                $(document).ready(function(){
                    $(".gender[value=\''.@strtolower($this->webUserInfoArray($userInfo,'gender')).'\']").attr("checked", true);
                });
                </script>


                <div class="form-group">
                    <label class="col-sm-3 control-label" >Next Of Kin</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'kin_name').'" name="signUp[kin_name]" placeholder="Next Of Kin" >
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-sm-3 control-label" >Next Of Kin Contact Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'kin_phone').'" name="signUp[kin_phone]" placeholder="Next Of Kin Contact Number" >
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label">'.$_e['Account Type'].'</label>

                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" class="account_type" name="signUp[account_type]" value="CEO">'.$_e['CEO'].'
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="account_type" name="signUp[account_type]" value="Master">'.$_e['Master'].'
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="account_type" name="signUp[account_type]" value="Practice">'.$_e['Practice'].'
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="account_type" name="signUp[account_type]" value="Employee">'.$_e['Employee'].'
                        </label>
                    </div>
                </div>
                <script>
                $(document).ready(function(){
                    $(".account_type[value=\''.@$this->webUserInfoArray($userInfo,'account_type').'\']").attr("checked", true);
                });

                </script>

                <div class="form-group master"  style="'.(@$this->webUserInfoArray($userInfo,'account_type')!='Master'?'display:none':'').'">
                    <label class="col-sm-3 control-label">Select Practices</label>
                    <div class="col-sm-9">
                        
                        <select name="signUp[account_under][]"  id="choices-multiple-remove-button" placeholder="Select" multiple>
                        '.$this->accountType('practice').'
                        </select>
                    </div>
                </div>';
                if(@$this->webUserInfoArray($userInfo,'account_type')=='Master'){
                echo '<script>
                $(document).ready(function(){
                    $(".master select").val(['.@$this->webUserInfoArray($userInfo,'account_under').']).prop("selected", true);
                });
                </script>';
                }
                
                echo '<div class="form-group employee"  style="'.(@$this->webUserInfoArray($userInfo,'account_type')!='Employee'?'display:none':'').'">
                    <label class="col-sm-3 control-label">Select a Practice</label>
                    <div class="col-sm-9">
                        <select class="form-control selects" name="signUp[account_under][]">
                        <option value="">NONE</option>
                        '.$this->accountType('practice').$this->accountType('master').'
                        </select>
                    </div>
                </div><script>
                $(document).ready(function(){
                    $(".employee select").val("'.@$this->webUserInfoArray($userInfo,'account_under').'").change();
                });
                </script>


                <div class="form-group">
                    <label class="col-sm-3 control-label">'.$_e['User Type'].'</label>

                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" class="user_type" name="signUp[user_type]" value="Standard" checked>'.$_e['Standard'].'
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="user_type" name="signUp[user_type]" value="Premium">'.$_e['Premium'].'
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="user_type" name="signUp[user_type]" value="Trial" >'.$_e['Trial'].'
                        </label>
                        <input type="hidden" class="hideField"  value="" name="signUp[date_of_expiry]" >
                    </div>
                </div>
                <script>
                $(document).ready(function(){
                    $(".user_type[value=\''.@$this->webUserInfoArray($userInfo,'user_type').'\']").attr("checked", true);
                    if("'.@$this->webUserInfoArray($userInfo,'date_of_expiry').'" != ""){
                        $(".expiryShow").show();
                    }

                $(".user_type").click(function(){
                    if($(this).val() == "Trial"){
                            $(".hideField").removeAttr("name");
                            $(".expiryShow").show();
                            $(".expiryField").val("'.@$this->webUserInfoArray($userInfo,'date_of_expiry').'");
                        }else{
                            $(".hideField").attr("name","signUp[date_of_expiry]");
                            $(".expiryShow").hide();
                            $(".expiryField").val("");
                        }
                    });
                
                });

                </script>

                <div class="form-group expiryShow" style="display:none;">
                    <label class="col-sm-3 control-label" >'.$_e['Trial Expiry Date'].'</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control date expiryField"  value="'.@$this->webUserInfoArray($userInfo,'date_of_expiry').'" name="signUp[date_of_expiry]" placeholder="'.$_e['Trial Expiry Date'].'" >
                    </div>
                </div>
                <h3>Work Details</h3>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Practice Address</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'practice_address').'" name="signUp[practice_address]" placeholder="Practice Address" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Work Email Address</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'work_email').'" name="signUp[work_email]" placeholder="Work Email Address" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Practice Contact Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'practice_contact').'" name="signUp[practice_contact]" placeholder="Practice Contact Number" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Role</label>
                    <div class="col-sm-9">
                        <select class="form-control arole" name="signUp[role]">'.
                        $this->accountRole()
                        .'</select>
                        <script>
                        $(document).ready(function(){
                            $(".arole").val("'.@$this->webUserInfoArray($userInfo, 'role').'").change();
                        });
                        </script>
                    </div>
                </div>

                <h3>HR Details</h3>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Contract Type</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'contract_type').'" name="signUp[contract_type]" placeholder="Contract Type" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Start Date</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control date"  value="'.@$this->webUserInfoArray($userInfo,'start_date').'" name="signUp[start_date]" placeholder="Start Date" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Hour Worked(weekly)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'hours_worked').'" name="signUp[hours_worked]" placeholder="Hour Worked(weekly)" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Probation Period End</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'probation_period_end').'" name="signUp[probation_period_end]" placeholder="Probation Period End" >
                    </div>
                </div>

                 <div class="form-group">
                    <label class="col-sm-3 control-label">Salary (per hour)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'salary').'" name="signUp[salary]" placeholder="Salary (per hour)" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Holiday Entitlement</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'holiday_entitlement').'" name="signUp[holiday_entitlement]" placeholder="Holiday Entitlement" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" >'.$_e['Date Of Birth'].'</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control date"  value="'.@$this->webUserInfoArray($userInfo,'date_of_birth').'" name="signUp[date_of_birth]" placeholder="'.$_e['Date Of Birth'].'" >
                    </div>
                </div>

                <h3>Payment Details</h3>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Bank Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'bank_name').'" name="signUp[bank_name]" placeholder="Bank Name" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Sort Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'sort_code').'" name="signUp[sort_code]" placeholder="Sort Code" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Account Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'account_number').'" name="signUp[account_number]" placeholder="Account Number" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Bank Account Holder Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'account_holder_name').'" name="signUp[account_holder_name]" placeholder="Bank Account Holder Name" >
                    </div>
                </div>

                <h3>CPD Details</h3>

                <div class="form-group">
                    <label class="col-sm-3 control-label">CPD Cycle Start Date</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control date"  value="'.@$this->webUserInfoArray($userInfo,'cpd_start_date').'" name="signUp[cpd_start_date]" placeholder="CPD Cycle Start Date" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">GDC Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'gdc_number').'" name="signUp[gdc_number]" placeholder="GDC Number" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Allow My Practice Manager to view my CPD certificates</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" class="cpd_certificates" name="signUp[cpd_certificates]" value="1">Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="cpd_certificates" name="signUp[cpd_certificates]" value="0">No
                        </label>
                    </div>
                </div>
                <script>
                $(document).ready(function(){
                    $(".cpd_certificates[value=\''.@$this->webUserInfoArray($userInfo,'cpd_certificates').'\']").attr("checked", true);
                });
                </script>

                <h3>Others</h3>

                <div class="form-group">
                    <label class="col-sm-3 control-label" >Interests</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'interests').'" name="signUp[interests]" placeholder="Interests" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" >Enrollment Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$userData['roll'].'" name="roll" placeholder="Enrollment Number" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" >'.$_e['Post Code'].'</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'post_code').'" name="signUp[post_code]" placeholder="'.$_e['Post Code'].'" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" >'.$_e['City'].'</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'city').'" name="signUp[city]" placeholder="'.$_e['City'].'" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" >'.$_e['Country'].'</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'country').'" name="signUp[country]" placeholder="'.$_e['Country'].'" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">'.$_e['Account Status'].'</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" class="acc_type" name="acc_type" value="1" '. $required .'>'.$_e['Active'].'
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="acc_type" name="acc_type" value="0" '. $required .'>'.$_e['DeActive'].'
                        </label>
                    </div>
                </div>
                <script>
                $(document).ready(function(){
                    $(".acc_type[value=\''.@strtolower($userData['acc_type']).'\']").attr("checked", true);
                });

                </script>

                <div class="form-group">
                    <label class="col-sm-3 control-label">'.$_e['Initial Health Form'].'</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" class="health" name="health_form" value="0" '. $required .'>'.$_e['Active'].'
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="health" name="health_form" value="1" '. $required .'>'.$_e['DeActive'].'
                        </label>


<label class="radio-inline">
<a data-id="'.$id.'" data-val="'.$id.'" onclick="trashAllEvents(this);" data-toggle="tooltip" title="trash all TOTAL '.$mysql2ttl[0].' userevent" class="btn">
<i class="fa fa-refresh waiting fa-spin"></i>
</a>
</label>


                    </div>
                </div>
                <script>
                $(document).ready(function(){
                    $(".health[value=\''.@strtolower($userData['health_form']).'\']").attr("checked", true);
                });
                </script>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Super User</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" class="superuser" name="signUp[superuser]" value="on">'.$_e['Active'].'
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="superuser" name="signUp[superuser]" value="off">'.$_e['DeActive'].'
                        </label>
                    </div>
                </div>
                <script>
                $(document).ready(function(){
                    $(".superuser[value=\''.@$this->webUserInfoArray($userInfo,'superuser').'\']").attr("checked", true);
                });
                </script>';

        if($edit) {
            echo '<div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label" >' . $_e['Account Create'] . '</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="' . @$userData['acc_created'] . '" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label" >' . $_e['Last Update'] . '</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="' . @$userData['acc_timestamp'] . '" readonly>
                    </div>
                </div>';
        }

        echo '<!--          <div class="form-group">
                    <label class="col-sm-2 control-label" >Account Type</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="'.@$this->webUserInfoArray($userInfo,'type').'" name="signUp[type]" placeholder="Account Type" >
                    </div>
                </div>-->

                <hr>
                <div class="form-group ">
                    <label for="pin" class="col-sm-3 control-label">'.$_e['Pin'].'</label>

                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="pin" '. $required .' id="pin"
                               placeholder="Default pin 000000" maxlength="6" minlength="6">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="pin" class="col-sm-3 control-label">'.$_e['Retype Pin'].'</label>
                    <div class="col-sm-9">
                        <input pattern="[0-9]+" type="password" class="form-control" name="rpin" '. $required .' id="rpin"
                               placeholder="Enter 6 digits pin" maxlength="6" minlength="6">
                    </div>
                </div>

                <div class="form-group ">
                    <label for="pass" class="col-sm-3 control-label">'.$_e['Password'].'</label>
                    <div class="col-sm-9">
                        <input type="password" onChange="passM();" class="form-control" name="pass" '. $required .' id="pass"
                               placeholder="'.$_e['Password'].'" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="rpass" class="col-sm-3 control-label">'.$_e['Retype Password'].'</label>
                    <div class="col-sm-9">
                        <input type="password" onChange="passM();" onkeyup="passM();" class="form-control" '. $required .' name="rpass" id="rpass"
                               placeholder="'.$_e['Retype Password'].'">
                        <div id="pm"></div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" name="submit" id="signup_btn" class="btn btn-primary defaultSpecialButton" onClick="subf()">
                               '.$_e['Save'].'
                        </button>
                    </div>
                </div>
            </form>';
    }



    // public function allWebUser(){
        
    //                 $sql    = "SELECT * FROM accounts_user";
    //         $userData   =   $this->dbF->getRows($sql);
    //                     foreach($userData as $val){
    //         echo $val['acc_id']."    ".$val['acc_name']."    ".$val['acc_email']."   |  " ;

    //         $sql    = "SELECT * FROM accounts_user_detail WHERE id_user = '$val[acc_id]'";
    //         $userInfo   = $this->dbF->getRows($sql);
         
    //         foreach($userInfo as $val){
    //                 echo $val['setting_name']." :: ".$val['setting_val']."  |  ";
    //         }
    //         echo "<br><hr><br>";
    //         }

    // } 

public function allWebUser(){
         
    $sql    = "SELECT * FROM accounts_user WHERE acc_type = 1  AND acc_id IN (SELECT id_user FROM accounts_user_detail WHERE setting_name = 'account_type' AND setting_val != 'Employee') ";
            $userData   =   $this->dbF->getRows($sql);
             
            echo    '<div class="table-responsive">
            <table class="table table-hover tableIBMS">';
           
            echo    "<thead>";
            echo    "<tr>";
            
            echo    "<th>ID</th>";
            echo    "<th>Account Create Date</th>";
            echo    "<th>Name</th>";
            echo    "<th>Email</th>";
            echo "<th>Practice Name</th>";
            echo "<th>Phone</th>";
            echo "<th>Address</th>";
            echo "<th>City</th>";
            echo "<th>Country</th>";
            echo "<th>Post Code</th>";
            echo "<th>Gender</th>";
            echo "<th>Account Type</th>";
            echo "<th>Practice Address</th>";
            echo "<th>Practice Contact</th>";
            echo "<th>Work Email</th>";
            echo "<th>GDC Number</th>";
            echo "<th>Role</th>";
            echo "<th>Date Of Birth</th>";


            echo    "</tr>";

            echo    "</thead>";
            echo    "<tbody>";
            
                        foreach($userData as $val){
            echo    "<tr>";
             echo "<td>".$val['acc_id']."</td>
                   <td>".$val['acc_created']."</td>
                   <td>".$val['acc_name']."</td>
                   <td>".$val['acc_email']."</td>";

            $sql    = "SELECT * FROM accounts_user_detail WHERE id_user = '$val[acc_id]' and setting_val != 'Employee'  ";
            $userInfo   = $this->dbF->getRows($sql);
         
                     
                   
                  
echo "<td>".$this->webUserInfoArray($userInfo,'practice name')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'phone')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'address')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'city')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'country')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'post_code')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'gender')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'account_type')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'practice_address')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'practice_contact')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'work_email')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'gdc_number')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'role')."</td>";
echo "<td>".$this->webUserInfoArray($userInfo,'date_of_birth')."</td>"; 
                    
        
                 

                   

            
            
            echo    "</tr>";
            
           $datessDOB = date('d-M-Y', strtotime($this->webUserInfoArray($userInfo,'date_of_birth')));

$r = "";
if(trim($this->webUserInfoArray($userInfo,'role')) != ""){
    $r = $this->webUserInfoArray($userInfo,'role');
}


$c = "";
if(trim($this->webUserInfoArray($userInfo,'city')) != ""){
    $c = " , ".$this->webUserInfoArray($userInfo,'city');
}



$cc = "";
if(trim($this->webUserInfoArray($userInfo,'country')) != ""){
    $cc = " , ".$this->webUserInfoArray($userInfo,'country');
}

$ccc = "";
if(trim($this->webUserInfoArray($userInfo,'post_code')) != ""){
    $ccc = " , ".$this->webUserInfoArray($userInfo,'post_code');
}

$ccc1 = "";
if(trim($this->webUserInfoArray($userInfo,'work_email')) != ""){
    $ccc1 = " <br> Work Email: ".$this->webUserInfoArray($userInfo,'work_email');
}



$ccc11 = "";
if(trim($this->webUserInfoArray($userInfo,'practice_contact')) != ""){
    $ccc11 = "<br> Practice Contact: ".$this->webUserInfoArray($userInfo,'practice_contact');
}

$v = "";
if(trim($this->webUserInfoArray($userInfo,'practice_address')) != ""){
$v = " <br> Practice Address: ".$this->webUserInfoArray($userInfo,'practice_address');
}



$vs = "";
if(trim($this->webUserInfoArray($userInfo,'gdc_number')) != ""){
$vs = " <br> GDC #: ".$this->webUserInfoArray($userInfo,'gdc_number');
}





// $sqls = "INSERT INTO `clientAddTbl` (`loginid`,`userAssign`,`name`,`business_name`,`manager_name`,`email`,`phone`,`mobile`,`address`,`dob`,`userService`,`cs`,`otherDetail`,`color`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
// $this->dbF->setRow($sqls, array("10","0",$val['acc_name'],
// $this->webUserInfoArray($userInfo,'practice name'),$r,$val['acc_email'],
// $this->webUserInfoArray($userInfo,'phone'),"",$this->webUserInfoArray($userInfo,'address')



// .$c
// .$cc
// .$ccc

// ,$datessDOB,"","","ID: ".$val['acc_id']


// ." <br> Created: ".$val['acc_created']
// ." <br> Gender: ".$this->webUserInfoArray($userInfo,'gender')
// ." <br> Type: ".$this->webUserInfoArray($userInfo,'account_type')
// .$v
// .$ccc11
// .$ccc1
// .$vs



// ,"")); 
//   $datessDOB = date('d-M-Y', strtotime($this->webUserInfoArray($userInfo,'date_of_birth')));

// $sqls = "INSERT INTO `clientAddTbl` (`loginid`,`userAssign`,`name`,`business_name`,`manager_name`,`email`,`phone`,`mobile`,`address`,`dob`,`userService`,`cs`,`otherDetail`,`color`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
// $this->dbF->setRow($sqls, array("10","0",$val['acc_name'],$this->webUserInfoArray($userInfo,'practice name'),"",$val['acc_email'],$this->webUserInfoArray($userInfo,'phone'),"",$this->webUserInfoArray($userInfo,'address')." - City: ".$this->webUserInfoArray($userInfo,'city')." - Country: ".$this->webUserInfoArray($userInfo,'country')." - Post Code: ".$this->webUserInfoArray($userInfo,'post_code'),$datessDOB,"","","User ID: ".$val['acc_id']." - A/C Create Date: ".$val['acc_created']." - Gender: ".$this->webUserInfoArray($userInfo,'gender')." - A/C Type: ".$this->webUserInfoArray($userInfo,'account_type')." - Practice Address: ".$this->webUserInfoArray($userInfo,'practice_address')." - Practice Contact: ".$this->webUserInfoArray($userInfo,'practice_contact')." - Work Email: ".$this->webUserInfoArray($userInfo,'work_email')." - GDC #: ".$this->webUserInfoArray($userInfo,'gdc_number')." - Role: ".$this->webUserInfoArray($userInfo,'role'),""));


            }

            echo    "</tbody>";
            echo    "</tbody>";
            echo    "</table>";
            echo    "</div>";
    } 
    
    public function newAdminUser($id ='',$action=''){
        global $_e;
        $isEdit = false;
        if($id !=''){
            $sql        = "SELECT * FROM accounts WHERE acc_id =  ? ";
            $userData   =   $this->dbF->getRow($sql,array($id));
            if($this->dbF->rowCount)
            {
                $isEdit =true;
                $sql        = "SELECT * FROM accounts_detail WHERE id_user = '$id'";
                $userInfo   = $this->dbF->getRows($sql);
            }
        }else if($id=='' && isset($_GET['userId'])){
            @$id     = $_GET['userId'];

            $sql    = "SELECT * FROM accounts WHERE acc_id =  ? ";
            $userData   =   $this->dbF->getRow($sql,array($id));
            if($this->dbF->rowCount)
            {
                if($userData['acc_role']=='0'){
                    //Will not work just for security
                    echo $_e['This Is Owner Account Please Go Back:'];
                    return false;
                }
                $isEdit =   true;
                $sql    =   "SELECT * FROM accounts_detail WHERE id_user = '$id'";
                $userInfo   = $this->dbF->getRows($sql);
                $pagePermission = $this->functions->pagePermissionStatus();
                if($pagePermission===true || $pagePermission==='3'){}
                else if($pagePermission==='2' && $_SESSION['_uid']==$id){}
                else{
                    return false;
                }
            }else{
                $id = '';
            }
        }

        if($id ==''){
            $token  =    $this->functions->setFormToken('adminUserNew',false);
        }else{
            $token  =    $this->functions->setFormToken('adminUserEdit',false);
        }


        $form_fields = array();

        $form_fields[] = array(
            'type' => 'none',
            'thisFormat' => "<div class='col-sm-12 padding-0'>"
        );

        $form_fields[] = array(
            'type' => 'none',
            'format' => $token
        );

        $form_fields[] = array(
            'name' => 'oldId',
            'value' => "$id",
            'type' => 'hidden',
        );



        $form_fields[] = array(
            'label' => $_e['Name'],
            'name' => 'name',
            'value' => @$userData['acc_name'],
            'type' => 'text',
            'class' => 'form-control',
            'required' => 'true',
            'id'        => 'user',
            'data' => 'onChange="filter(this); vali()"'
        );

        $form_fields[] = array(
            'label' => $_e['Email'],
            'name' => 'email',
            'value' => @$userData['acc_email'],
            'type' => 'email',
            'class' => 'form-control',
            'required' => 'true',
            'id'        => 'inputEmail3',
            'data' => 'onChange="filter(this); vali()"'
        );




        $form_fields[] = array(
            'label' => $_e['User Group'],
            'type' => 'none',
            'format' => '<select name="acc_grp" class="acc_grp form-control"  required>
                            '.$this->adminUserGrpOption().'
                            </select>
                            <script>
                                $(document).ready(function(){
                                    $(".acc_grp").val("'.@$userData['acc_role'].'").change();
                                });
                            </script>'
        );

        $form_fields[] = array(
            'label' => $_e['Gender'],
            'name' => 'signUp[gender]',
            'type' => 'radio',
            'option' => $_e['Female'].",".$_e['Male'],
            'value' => "female,male",
            'class' => 'gender',
            'selected' => @strtolower($this->webUserInfoArray($userInfo,'gender')),
            'format' => '<label class="radio-inline">{{form}} {{option}}</label>'
        );

        $form_fields[] = array(
            'label' => $_e['Date Of Birth'],
            'name' => 'signUp[date_of_birth]',
            'value' => @$this->webUserInfoArray($userInfo,'date_of_birth'),
            'type' => 'text',
            'class' => 'form-control date',
        );

        $form_fields[] = array(
            'label' => $_e['Phone'],
            'name' => 'signUp[phone]',
            'value' => @$this->webUserInfoArray($userInfo,'phone'),
            'type' => 'text',
            'class' => 'form-control',
        );

        $form_fields[] = array(
            'label' => $_e['Address'],
            'name' => 'signUp[address]',
            'value' => @$this->webUserInfoArray($userInfo,'address'),
            'type' => 'textarea',
            'class' => 'form-control',
        );

        $form_fields[] = array(
            'label' => $_e['Post Code'],
            'name' => 'signUp[post_code]',
            'value' => @$this->webUserInfoArray($userInfo,'post_code'),
            'type' => 'text',
            'class' => 'form-control',
        );

        $form_fields[] = array(
            'label' => $_e['City'],
            'name' => 'signUp[city]',
            'value' => @$this->webUserInfoArray($userInfo,'city'),
            'type' => 'text',
            'class' => 'form-control',
        );

        $form_fields[] = array(
            'label' => $_e['Country'],
            'name' => 'signUp[country]',
            'value' => @$this->webUserInfoArray($userInfo,'country'),
            'type' => 'text',
            'class' => 'form-control',
        );

        //checking adminPanel Language
        $option = "default,";
        if($this->functions->developer_setting('multi_language')=='1') {
            $langs = $this->functions->IbmsLanguages();
            @$temp2 = $this->webUserInfoArray($userInfo, 'adminLang');
            foreach ($langs as $op) {
                $option .= "$op,";
            }

            $form_fields[] = array(
                'label' => $_e['Admin Panel'],
                'name' => 'signUp[adminLang]',
                'option' => $option,
                'value' => $option,
                'type' => 'select',
                'select' => $temp2,
                'class' => 'form-control',
            );
        }else{
            $form_fields[] = array(
                'label' => $_e['Admin Panel'],
                'name' => 'signUp[adminLang]',
                'value' => "",
                'type' => 'hidden',
                'class' => 'form-control',
            );
        }

        $form_fields[] = array(
            'label' => $_e['Account Status'],
            'name' => 'acc_type',
            'type' => 'radio',
            'option' => $_e['Active'].",".$_e['DeActive'],
            'value' => "1,0",
            'class' => 'acc_type',
            'selected' =>  @$userData['acc_type'],
            'format' => '<label class="radio-inline">{{form}} {{option}}</label>'
        );

        $form_fields[] = array(
            'label' => $_e['Account Create'],
            'value' => @$userData['acc_created'],
            'type' => 'text',
            'class' => 'form-control',
            'readonly' => 'true'
        );

        $form_fields[] = array(
            'label' => $_e['Last Update'],
            'value' => @$userData['acc_timestamp'],
            'type' => 'text',
            'class' => 'form-control',
            'readonly' => 'true',
            'format' => "{{form}} <hr>"
        );


        $form_fields[] = array(
            'label' => $_e['Password'],
            'name' => 'pass',
            'id' => 'pass',
            'type' => 'password',
            'class' => 'form-control',
            'data' => 'onChange="passM();"'
        );

        $form_fields[] = array(
            'label' => $_e['Retype Password'],
            'name' => 'rpass',
            'id' => 'rpass',
            'type' => 'password',
            'class' => 'form-control',
            'data' => 'onChange="passM();" onkeyup="passM();"',
            'format' => '{{form}} <div id="pm"></div>'
        );

        $form_fields[]  = array(
            "value" => $_e['Save'],
            "name"  => 'btn',
            'class' => 'btn btn-primary defaultSpecialButton',
            'type'  => 'submit',
            'data'  => ' onClick="subf()"',
        );

        $form_fields[] = array(
            'type' => 'none',
            'thisFormat' => "</div>"
        );

        if($action==''){
            $action = 'AdminUsers';
        }
        $form_fields['form']  = array(
            'type'      => 'form',
            'class'     => "form-horizontal",
            'id'        => "formId",
            'action'   => '-'.$this->functions->getLinkFolder().'?page='.$action,
            'method'   => 'post',
            'format'   => '<div class="form-horizontal">{{form}}</div>'
        );

        $format = '<div class="form-group">
                        <label class="col-md-4  control-label">{{label}}</label>
                        <div class="col-md-8">
                            {{form}}
                        </div>
                    </div>';
        //$format = false;
        $this->functions->print_form($form_fields,$format);
    }


    public function adminUserGrpOption(){
        $sql    =   "SELECT id,name FROM accounts_prm_grp ORDER BY name ASC";
        $data   =   $this->dbF->getRows($sql);

        $op='';
        if($this->dbF->rowCount > 0){
            foreach($data as $val){
                $op .="<option value='$val[id]'>$val[name]</option>";
            }
            return $op;
        }
        return "";
    }




    public function adminUserEditSubmit(){
        global $_e;
        if (isset($_POST['name']) && !empty($_POST['name'])
            && isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['oldId']) && !empty($_POST['oldId'])
        ){

            if(!$this->functions->getFormToken('adminUserEdit')){return false;}
            try {

                $email = strip_tags(strtolower(trim($_POST['email'])));
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $id     = empty($_POST['oldId']) ? "" : $_POST['oldId'];
                    $name   = empty($_POST['name']) ? "" : $_POST['name'];
                    $pass   = empty($_POST['pass']) ? "" : $_POST['pass'];
                    $rpass  = empty($_POST['rpass']) ? "" : $_POST['rpass'];
                    $type   = empty($_POST['acc_type']) ? 0 : $_POST['acc_type'];
                    $role   = empty($_POST['acc_grp']) ? 0 : $_POST['acc_grp'];

htmlspecialchars($id);
htmlspecialchars($name);
htmlspecialchars($pass);
htmlspecialchars($rpass);
htmlspecialchars($type);
htmlspecialchars($role);

                    $passwordStatus = false;
                    if($pass != $rpass){
                        $msg = $_e['Password Not Matched!'];
                        return $msg;
                    }
                    if($pass != ''){
                        $passwordStatus =true;
                    }

                    $this->db->beginTransaction();
                    $sql = "UPDATE  accounts SET
                                acc_name = ?,
                                acc_email = ?,
                                acc_type  = ?,
                                acc_role  =?
                                WHERE acc_id = '$id'";
                    $array = array($name,$email,$type,$role);
                    $this->dbF->setRow($sql,$array,false);

                    if($passwordStatus){
                        $password  =  $this->functions->encode($pass);
                        $sql = "UPDATE  accounts SET
                                acc_pass = ?
                                WHERE acc_id = '$id'";
                        $array = array($password);
                        $this->dbF->setRow($sql,$array,false);
                    }

                    $lastId = $id;
                    $setting    = empty($_POST['signUp']) ? array() : $_POST['signUp'];

                    $sql = "DELETE FROM `accounts_detail` WHERE id_user= '$id'";
                    $this->dbF->setRow($sql);

                    $sql        =   "INSERT INTO `accounts_detail` (`id_user`,`setting_name`,`setting_val`) VALUES ";
                    $arry       =   array();
                    foreach($setting as $key=>$val){
                        $sql .= "('$lastId',?,?) ,";
                        $arry[]= $key ;
                        $arry[]= $val ;
                    }
                    $sql = trim($sql,",");
                    $this->dbF->setRow($sql,$arry,false);

                } else {
                    $AccLoginInfoT = $_e['Invalid Email Address! Or Some Thing Went Wrong'];
                    $msg = $AccLoginInfoT;
                    $this->db->rollBack();
                    return $msg;
                }

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->setlog($_e['Update AdminUser'],$_e['Admin User'],$lastId,str_replace( '{{name}}' , $name  , $_e['Admin Update with Name : {{name}}']  ));
                    $msg = $_e['Profile Update Successfully!'];
                }else{
                    $msg = $_e['Profile Update Failed!'];
                }
                return $msg;
            } catch (PDOException $e) {
                $msg = $_e['adminUser Update fail please try again.!'];
                $this->db->rollBack();
                return $msg;
            }
        }
        return "";
    }

    public function adminUserAddSubmit(){
        global $_e;
        if (isset($_POST['name']) && !empty($_POST['name'])
            && isset($_POST['email']) && !empty($_POST['email'])
        ){

            if(!$this->functions->getFormToken('adminUserNew')){return false;}
            try {

                $email = strip_tags(strtolower(trim($_POST['email'])));
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $id     = empty($_POST['oldId']) ? "" : $_POST['oldId'];
                    $name   = empty($_POST['name']) ? "" : $_POST['name'];
                    $pass   = empty($_POST['pass']) ? "" : $_POST['pass'];
                    $rpass  = empty($_POST['rpass']) ? "" : $_POST['rpass'];

                    $type   = empty($_POST['acc_type']) ? 1 : $_POST['acc_type'];
                    $role   = empty($_POST['acc_grp']) ? 0 : $_POST['acc_grp'];

htmlspecialchars($id);
htmlspecialchars($name);
htmlspecialchars($pass);
htmlspecialchars($rpass);
htmlspecialchars($type);
htmlspecialchars($role);

                    $passwordStatus = false;
                    if($pass != $rpass){
                        $msg = $_e['Password Not Matched!'];
                        return $msg;
                    }
                    if($pass == ''){
                        $msg = $_e['Password Required!'];
                        return $msg;
                    }

                    $password  =  $this->functions->encode($pass);
                    $this->db->beginTransaction();
                    $sql = "INSERT INTO `accounts` SET
                                `acc_name` = ?,
                                `acc_email` = ?,
                                `acc_pass`  = ?,
                                `acc_type`  = ?,
                                `acc_role`  =?,
                                `acc_created` = ?
                                ";
                    $array = array($name,$email,$password,$type,$role,date('Y-m-d H:i:s'));
                    $this->dbF->setRow($sql,$array,false);

                    if($this->dbF->hasException===true){
                        throw new Exception("");
                    }

                    $lastId = $this->dbF->rowLastId;

                    $setting    = empty($_POST['signUp']) ? array() : $_POST['signUp'];

                    $sql        =   "INSERT INTO `accounts_detail` (`id_user`,`setting_name`,`setting_val`) VALUES ";
                    $arry       =   array();
                    foreach($setting as $key=>$val){
                        $sql .= "('$lastId',?,?) ,";
                        $arry[]= $key ;
                        $arry[]= $val ;
                    }
                    $sql = trim($sql,",");
                    $this->dbF->setRow($sql,$arry,false);
                } else {
                    $AccLoginInfoT = $_e['Invalid Email Address! Or Some Thing Went Wrong'];
                    $msg = $AccLoginInfoT;
                    $this->db->rollBack();
                    return $msg;
                }

                $this->db->commit();
                $this->functions->setlog($_e['New AdminUser'],$_e['Admin User'],$lastId,str_replace( '{{name}}' , $name  , $_e['New Admin Add with Name : {{name}}']  ));
                $msg = $_e['Profile Add Successfully!'];
                return $msg;
            } catch (Exception $e) {
                $msg = $_e['adminUser Update fail please try again.! Or Duplicate Email.'];
                $this->db->rollBack();
                return $msg;
            }
        }
        return "";
    }


    public function adminUsersView(){
        $sql  = "SELECT * FROM accounts WHERE acc_type = '1' AND acc_grp = '1' ORDER BY acc_id DESC ";
        $data =  $this->dbF->getRows($sql);
        $this->adminUserPrint($data,true);
    }

    public function adminUserPrint($data,$active=true){
        global $_e;
        echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                        <th>'._u($_e['SNO']).'</th>
                        <th>'._u($_e['USER NAME']).'</th>
                        <th>'._u($_e['USER EMAIL']).'</th>
                        <th>'._u($_e['USER FROM']).'</th>
                        <th>'._u($_e['ACTION']).'</th>
                    </thead>
                <tbody>';
        $i = 0;
        $pagePermission = $this->functions->pagePermissionStatus();
        foreach($data as $val){
            $i++;
            $id = $val['acc_id'];

            if($val['acc_role']=='0'){
                $editDiv    =   "<div class='btn btn-sm btn-danger'>"._u($_e['OWNER'])."</div>";
            }else{
                $editDiv    = "<div class='btn-group btn-group-sm'>";

                if($pagePermission==='3' || $pagePermission===true) {
                    if($active) {
                        $editDiv .= "<a data-id = '$id' data-val = '0' onclick = 'activeAdminUser(this);' class='btn' title = '" . $_e['DeActive User'] . "' >
                                <i class='glyphicon glyphicon-thumbs-down trash' ></i >
                                <i class='fa fa-refresh waiting fa-spin' style = 'display: none' ></i >
                            </a>";
                    }else{
                        $editDiv.=" <a data-id='$id' data-val='1' onclick='activeAdminUser(this);' class='btn' title='".$_e['Active User']."'>
                                <i class='glyphicon glyphicon-thumbs-up trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>";
                    }
                }
                if($pagePermission==='2' && $_SESSION['_uid']==$id || $pagePermission===true) {
                    $editDiv.= "<a data-id='$id' href='-webUsers?page=adminEdit&userId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>";
                }elseif($pagePermission==='3'){
                    $editDiv.= "<a data-id='$id' href='-webUsers?page=adminEdit&userId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>";
                }
                if($pagePermission==='3'|| $pagePermission===true) {
                    $editDiv.= "<a data-id='$id' onclick='deleteAdminUser(this);' class='btn'   title='" . $_e['Delete User'] . "'>
                                <i class='glyphicon glyphicon-trash trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>";
                }
                echo " </div>";
            }


            echo "<tr>
                    <td>$i</td>
                    <td>$val[acc_name]</td>
                    <td>$val[acc_email]</td>
                    <td>$val[acc_created]</td>
                    <td>$editDiv</td>
                  </tr>";
        }


        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }

    public function adminUsersViewDeActive(){
        $sql  = "SELECT * FROM accounts WHERE acc_type = '0' AND acc_grp = '1'  ORDER BY acc_id DESC ";
        $data =  $this->dbF->getRows($sql);
        $this->adminUserPrint($data,false);
    }



    public function adminUsersGrpView(){
        global $_e;
        echo '<div class="table-responsive">
                <table class="table table-hover tableIBMS">
                    <thead>
                        <th>'._u($_e['SNO']).'</th>
                        <th>'._u($_e['GROUP NAME']).'</th>
                        <th>'._u($_e['ACTION']).'</th>
                    </thead>
                <tbody>';

        $sql  = "SELECT * FROM accounts_prm_grp ORDER BY id DESC ";
        $data =  $this->dbF->getRows($sql);
        $i = 0;
        foreach($data as $val){
            $i++;
            $id = $val['id'];

            $editDiv    = "<div class='btn-group btn-group-sm'>

                            <a data-id='$id' href='-webUsers?page=groupEdit&grpId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>

                            <a data-id='$id' onclick='deleteAdminGrp(this);' class='btn'   title='".$_e['Delete Group']."'>
                                <i class='glyphicon glyphicon-trash trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>
                        </div>";

            echo "<tr>
                    <td>$i</td>
                    <td>$val[name]</td>
                    <td>$editDiv</td>
                  </tr>";
        }


        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }


    public function newAdminGrp($id=''){
        global $_e;
        if($id=='' && isset($_GET['grpId'])){
            @$id     = $_GET['grpId'];

            $sql    = "SELECT * FROM accounts_prm_grp WHERE id = ? ";
            $userData   =   $this->dbF->getRow($sql,array($id));
            if($this->dbF->rowCount)
            {
                $token  =    $this->functions->setFormToken('adminGrpEdit',false);
            }else{
                $id = '';
            }
        }
        if($id ==''){
            $token  =    $this->functions->setFormToken('adminGrpNew',false);
        }
        echo '<form action="-webUsers?page=AdminGrp" class="form-horizontal" role="form" method="post">'.$token.'
                <input type="hidden" name="oldId" value="'.$id.'"/>
                <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">'.$_e['Group Name'].'</label>

                    <div class="col-sm-10">
                    <!-- patteren not working for sweden lang pattern="[a-zA-z- ]{3,50}"-->
                        <input type="text" class="form-control" name="name" id="user"
                               placeholder="'.$_e['Name'].'" value="'.@$userData['name'].'" required">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label" >'.$_e['Permissions'].'</label>

                    <div class="col-sm-10">
                        '.$this->userPermissions(@$userData['permission']).'
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="submit" id="signup_btn" class="btn btn-primary defaultSpecialButton">
                               '.$_e['Save'].'
                        </button>
                    </div>
                </div>
            </form>';


    }

    public function userPermissions($permission){
        global $_e;
        $edit = false;
        if($permission!=''){
            $edit = true;
            $permission     =   unserialize($permission);
        }
        //var_dump($permission);

        $menuClass  =   new menu();
        $MenuVisible = $menuClass->autoVisibleMenuArray();
        $menuLink   =   $menuClass->AutoVisibleMenuLink;
        $menuName   =   $menuClass->AutoVisibleMenuName;

        $temp       =   "<div class='' style='height: 300px;overflow-y: scroll;padding: 5px;'>";

        foreach($MenuVisible['menu'] as $val){
            // var_dump($val);
            $check = 'checked';
            if($edit){
                $check = '';
                if(in_array($val,$permission['menu'])){
                    $check = 'checked';
                }
            }
            $temp .= "<div class='col-sm-12 h2 btn-info'><label>
                                <input type='checkbox' value='$val' $check name='MainMenu[]'>
                                    $menuName[$val]
                                </label></div>";
            if(!empty($MenuVisible[$val])){
                foreach($MenuVisible[$val] as $val2){
                    $link   =   $menuLink[$val2];
                    $check1 = 'checked';
                    $check2 = '';
                    $check3 = '';
                    $check4 = '';
                    if($edit){
                        $check1 = '';
                        if('0'===@$permission[$val][$link]){
                            $check1 = 'checked';
                        }elseif('1'===@$permission[$val][$link]){
                            $check2 = 'checked';
                        }elseif('2'===@$permission[$val][$link]){
                            $check3 = 'checked';
                        }elseif('3'===@$permission[$val][$link]){
                            $check4 = 'checked';
                        }else{
                            $check1 = 'checked';
                        }
                    }
                    $temp .= "<div class='col-sm-12 btn-default'>
                                <div class='col-sm-3 btn-sm'>  $val2</div>
                                <div class='col-sm-9 radio btn-sm'>
                                    <label>
                                        <input type='radio' value='0' $check1 name='permissions[$val][$link]'>
                                        ".$_e['Not Access']."
                                    </label>
                                    <label>
                                        <input type='radio' value='1' $check2 name='permissions[$val][$link]'>
                                        ".$_e['Read Only']."
                                    </label>
                                    <label>
                                        <input type='radio' value='2' $check3 name='permissions[$val][$link]'>
                                        ".$_e['Write Only']."
                                    </label>
                                    <label>
                                        <input type='radio' value='3' $check4 name='permissions[$val][$link]'>
                                        ".$_e['Read, Write and Delete']."
                                    </label>
                                </div>
                              </div>";
                }
            }

        }

        $temp .=    '</div>';
        return $temp;
    }


    public function adminGrpSubmit(){
        global $_e;
        if (isset($_POST['name']) && !empty($_POST['name'])
            && isset($_POST['MainMenu']) && !empty($_POST['MainMenu'])
        ){

            if(!$this->functions->getFormToken('adminGrpNew')){return false;}
            $name   =   htmlspecialchars($_POST['name']);;
            $mainMenu   =   htmlspecialchars($_POST['MainMenu']);
            $permissions = htmlspecialchars($_POST['permissions']);
            $makeNewLink    =       array();
            foreach($mainMenu as $val){
                $makeNewLink['menu'][] = $val;
                if(!empty($permissions[$val])){
                    foreach($permissions[$val] as $key=>$val2){
                        $makeNewLink['subMenu'][] =   $key;
                        $makeNewLink['subMenuP'][$key] =   $val2;
                        $makeNewLink[$val][$key]  =   $val2;
                    }
                }
            }

            $makeNewLink = serialize($makeNewLink);

            $sql    =   "INSERT INTO `accounts_prm_grp` SET
                            `name` = ?,
                            `permission` = ?";
            $this->dbF->setRow($sql,array($name,$makeNewLink));
            //var_dump($makeNewLink);

            if($this->dbF->rowCount>0){
                $this->functions->notificationError($_e['User Group'],$_e['New Group Add Successfully'],'btn-success');
                $this->functions->setlog($_e['Group add'],$_e['Admin User Group'],$this->dbF->rowLastId,str_replace( '{{name}}' , $name  , $_e['New Admin User group Add with name : {{name}}']  ));

            }else{
                $this->functions->notificationError($_e['User Group'],$_e['New Group Add Failed'],'btn-danger');
            }
        }
    }

    public function adminGrpEditSubmit(){
        global $_e;
        if (isset($_POST['name']) && !empty($_POST['name'])
            && isset($_POST['MainMenu']) && !empty($_POST['MainMenu'])
        ){

            if(!$this->functions->getFormToken('adminGrpEdit')){return false;}

            $id     = empty($_POST['oldId']) ? "" : $_POST['oldId'];
            intval($id);
            $name   =   htmlspecialchars($_POST['name']);
            $mainMenu   =   htmlspecialchars($_POST['MainMenu']);
            $permissions = htmlspecialchars($_POST['permissions']);
            $makeNewLink    =       array();
            foreach($mainMenu as $val){
                $makeNewLink['menu'][] = $val;
                if(!empty($permissions[$val])){
                    foreach($permissions[$val] as $key=>$val2){
                        $makeNewLink['subMenu'][] =   $key;
                        $makeNewLink['subMenuP'][$key] =   $val2;
                        $makeNewLink[$val][$key]  =   $val2;
                    }
                }
            }

            $makeNewLink = serialize($makeNewLink);

            $sql    =   "UPDATE `accounts_prm_grp` SET
                            `name` = ?,
                            `permission` = ? WHERE id = '$id'";
            $this->dbF->setRow($sql,array($name,$makeNewLink));
            //var_dump($makeNewLink);

            if($this->dbF->rowCount>0){
                $this->functions->notificationError($_e['User Group'],$_e['New Group Update Successfully'],'btn-success');
                $this->functions->setlog($_e['Group Update'],$_e['Admin User Group'],$this->dbF->rowLastId,str_replace( '{{name}}' , $name  , $_e['Admin User group Update with name : {{name}}']  ));

            }else{
                $this->functions->notificationError($_e['User Group'],$_e['New Group Update Failed'],'btn-danger');
            }
        }
    }



}
?>
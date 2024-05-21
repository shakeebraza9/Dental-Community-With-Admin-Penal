<?php
require_once (__DIR__."/../../global_ajax.php"); //connection setting db
class webusers_ajax extends object_class{
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
        $_w["Delete WebUser"]    =   "";
        $_w["Update WebUser"]    =   "";
        $_w["WebUser Update Successfully"]    =   "";
        $_w["WebUser Delete Successfully"]    =   "";
        $_w["WebUser"]    =   "";
        $_w["Delete AdminUser"]    =   "";
        $_w["Delete UserGroup"]    =   "";
        $_w["Admin User Group"]    =   "";
        $_w["Admin User Group Delete Successfully"]    =   "";
        $_w["AdminUser Update Successfully"]    =   "";
        $_w["AdminUser"]    =   "";
        $_w["Update AdminUser"]    =   "";
        $_w["AdminUser Delete Successfully"]    =   "";
        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,"Users Management");
    }
       public function UserType2($id){
          $sql = "SELECT `setting_val` FROM `accounts_user_detail` WHERE  `setting_name`='superuser' AND `id_user`=  ? ";
        $data = $this->dbF->getRow($sql,array($id));
        return $data[0];
     }
     public function UserType($id){
        $sql = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_type' AND `id_user`= ? ";
        $data = $this->dbF->getRow($sql,array($id));
    
    return $data[0];
    }
    public function deleteWebuser(){
        global $_e;
        try{
            $this->db->beginTransaction();
            $id=intval($_POST['id']);

            $sql2="DELETE FROM accounts_user WHERE acc_id='$id'";
            $this->dbF->setRow($sql2,false);
            if($this->dbF->rowCount) echo '1';
            else echo '0';

            $this->db->commit();
            $this->functions->setlog(_uc($_e['Delete WebUser']),_uc($_e['WebUser']),$id,_uc($_e['WebUser Delete Successfully']));
        }catch (PDOException $e) {
            echo '0';
            $this->db->rollBack();
            $this->dbF->error_submit($e);
        }
    }

    public function deleteAdminUser(){
        try{
            global $_e;
            $this->db->beginTransaction();
            $id=intval($_POST['id']);

            $sql2="DELETE FROM accounts WHERE acc_id='$id' AND acc_role != '0'";
            $this->dbF->setRow($sql2,false);
            if($this->dbF->rowCount) echo '1';
            else echo '0';

            $this->db->commit();
            $this->functions->setlog(_uc($_e['Delete AdminUser']),_uc($_e['AdminUser']),$id,_uc($_e['AdminUser Delete Successfully']));
        }catch (PDOException $e) {
            echo '0';
            $this->db->rollBack();
            $this->dbF->error_submit($e);
        }
    }
    public function activeWebUser(){
        global $_e;
        try{
            $this->db->beginTransaction();
            $id=intval($_POST['id']);
            $verify = htmlspecialchars($_POST['val']);

            $sql2="UPDATE accounts_user SET acc_type = '$verify' WHERE acc_id='$id'";
            $this->dbF->setRow($sql2,false);
            if($this->dbF->rowCount) echo '1';
            else echo '0';

            $this->db->commit();
            $this->functions->setlog(_uc($_e['Update WebUser']),_uc($_e['WebUser']),$id,_uc($_e['WebUser Update Successfully']));
        }catch (PDOException $e){
            echo '0';
            $this->db->rollBack();
            $this->dbF->error_submit($e);
        }
    }

    public function activeSponsor(){
        global $_e;
        try{
            $this->db->beginTransaction();
            $id=intval($_POST['id']);
            $verify = htmlspecialchars($_POST['val']);

            $sql2="UPDATE accounts_user SET acc_role = '$verify' WHERE acc_id='$id'";
            $this->dbF->setRow($sql2,false);
            if($this->dbF->rowCount) echo '1';
            else echo '0';

            $this->db->commit();
            $this->functions->setlog(_uc($_e['Update WebUser']),_uc($_e['WebUser']),$id,_uc($_e['WebUser Update Successfully']));
        }catch (PDOException $e){
            echo '0';
            $this->db->rollBack();
            $this->dbF->error_submit($e);
        }
    }


    public function activeAdminUser(){
        global $_e;
        try{
            $this->db->beginTransaction();
            $id=intval($_POST['id']);
            $verify = htmlspecialchars($_POST['val']);

            $sql2="UPDATE accounts SET acc_type = '$verify' WHERE acc_id='$id' AND acc_role != '0'";
            $this->dbF->setRow($sql2,false);
            if($this->dbF->rowCount) echo '1';
            else echo '0';

            $this->db->commit();
            $this->functions->setlog(_uc($_e['Update AdminUser']),_uc($_e['AdminUser']),$id,_uc($_e['AdminUser Update Successfully']));
        }catch (PDOException $e){
            echo '0';
            $this->db->rollBack();
            $this->dbF->error_submit($e);
        }
    }

    public function deleteAdminGrp(){
        global $_e;
        try{
            $this->db->beginTransaction();
            $id=intval($_POST['id']);

            $sql2="DELETE FROM accounts_prm_grp WHERE id='$id'";
            $this->dbF->setRow($sql2,false);
            if($this->dbF->rowCount) echo '1';
            else echo '0';

            $this->db->commit();
            $this->functions->setlog(_uc($_e['Delete UserGroup']),_uc($_e['Admin User Group']),$id,_uc($_e['Admin User Group Delete Successfully']));
        }catch (PDOException $e) {
            echo '0';
            $this->db->rollBack();
            $this->dbF->error_submit($e);
        }
    }
  function fetch_draft_WebUsers(){

  
    
        global $_e, $functions;
        $start  = ( isset($_POST['start']) )  ? $_POST['start']             : 0;
        $length = ( isset($_POST['length']) ) ? $_POST['length']            : 10;
        $draw   = ( isset($_POST['draw']) )   ? (int) $_POST['draw']        : null;
        $search = ( isset($_POST['search']) ) ? ($_POST['search']['value']) : null;

        #### Search Query #####
        @$page  = $_GET['page'];
        $setting_val = " '1' ";
        if($page == 'draft_products'){
            $setting_val = " '0' ";
        }

        if($search) { $search_sql = "
                    (( `a`.`acc_name` LIKE '%{$search}%' ) OR
                     ( `a`.`acc_email` LIKE '%{$search}%' ))
                                        AND
                                        ";
            



        } else 
        { $search_sql = ''; }

        ############# GET TOTAL ROWS #############
         $total_count_sql = " SELECT  COUNT(`a`.`acc_id`) AS cnt
        FROM accounts_user AS `a`
     
      WHERE  
    {$search_sql}

        ( `a`.`acc_type` = '0') 
        ";


    
        $all_data = $this->dbF->getRow($total_count_sql);
         $recordsTotal = $all_data['cnt'];


        ###### Get Data ######
        $qry = "SELECT  `a`.*
        FROM accounts_user AS `a`
    
      WHERE  

                {$search_sql}

                
                  ( `a`.`acc_type` = '0')
                ORDER BY `a`.`acc_id` DESC LIMIT {$start},{$length} ";


        $data = $this->dbF->getRows($qry);


        $columns = array();
        if($draw == 1){ $draw - 1; }

        $columns["draw"] =$draw+1;
        $columns["recordsTotal"] = $recordsTotal; //total record,
        $columns["recordsFiltered"] = $recordsTotal; //filter record, same as total record, then next button will appear

        $i = $start;
        foreach($data as $key => $val){
            $i++;
            
             $id = $val['acc_id'];
            $pName = "";
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='account_type'");
            $account_type = $d[0];
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='user_type'");
            $user_type = $d[0];
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='date_of_expiry'");
            $date_of_expiry = $d[0];
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='account_under'");
            if($account_type != 'Master'){$pName = $this->functions->UserName($d[0]);}
            $d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='role' AND `id_user`='$id'");
            $role = $d[0];
            $setPswrdHash = $val['acc_email'].'--'.$this->functions->decode($val['acc_pass']);
            $setPswrdHash = base64_encode($setPswrdHash);
            $link2        =   WEB_URL . "/login.php?".'set='.$setPswrdHash;
         
                      if( $this->UserType2($id) == "on"){ $chk_status ="SuperUser";}
             else{  $chk_status = $this->UserType($id);}
                
                 $acc_name =           $val['acc_name']."-(".$role.")";
                 $acc_email =          $val['acc_email'];
                 $last_login =          $val['last_login'];
                 $account_typePname =   $account_type."-(".$pName.")";
                 if($user_type=='Trial'){$user_type= $user_type.' - Exp:'.$date_of_expiry;}else{$user_type;}
                 $acc_created=   $val['acc_created'];
            # this functions uses $_SERVER['REQUEST_URI'], as now we are using ajax request so the link in $_SERVER['REQUEST_URI'] is of the ajax request not the current url in browser, so we are hardcoding this for the time being, new way / function will have to be created.
             //$link  = $this->functions->getLinkFolder();
            $link  = '-userEvent?page=edit&eventId='.$id;
            


            $uniq = ( isset($_GET['uniq']) ) ? $_GET['uniq'] : 'no-uniq';
            $first_column = " 
                        <div class='checkbox'>
                            <label>
                                <input type='checkbox' ng-checked='$uniq' name='productListCheck[]' value='$id'> $i
                            </label>
                        </div>
            ";


            $myprefix = 'userId';
            $login = " <div class='btn-group btn-group-sm'><a data-id='$id' data-val='1' href='$link2' target='_blank' class='btn' title='User Login'>
                                <i class='glyphicon glyphicon-user'></i>
                            </a>  <a data-id='$id' data-val='1' href='-setting?page=history&id=$id' target='_blank' class='btn' title='Activity Log'>
                                 <i class='glyphicon glyphicon-time'></i>
                             </a></div>";
            $action = "
                            
                                <div class='btn-group btn-group-sm'>
                                   

                               
                               <a data-id='$id' data-val='1' onclick='activeWebUser(this);' class='btn' title='Active User'>
                                <i class='glyphicon glyphicon-thumbs-up trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>

                            <a data-id='$id' href='-webUsers?page=edit&userId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>

                            <a data-id='$id' onclick='deleteWebUser(this);' class='btn'   title='Delete Email'>
                                <i class='glyphicon glyphicon-trash trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>
                                </div>
                           
                    ";

            //6 columns
            $columns["data"][$key] = array(
                 ##### disabling this for the time being needs work "{$first_column}",
                    
   

            $i,
           
            $acc_name,
            $acc_email,
            $last_login,
            $account_typePname,
             $chk_status,
             $user_type,
            $acc_created,
            $login,
             $action
            );
        }
        if($recordsTotal =='0'){
            $columns["data"] = array();
        }
        //Jason Encode
        echo json_encode( $columns );
    


}

  function fetch_trial_WebUsers(){

  
    
        global $_e, $functions;
        $start  = ( isset($_POST['start']) )  ? $_POST['start']             : 0;
        $length = ( isset($_POST['length']) ) ? $_POST['length']            : 10;
        $draw   = ( isset($_POST['draw']) )   ? (int) $_POST['draw']        : null;
        $search = ( isset($_POST['search']) ) ? ($_POST['search']['value']) : null;

        #### Search Query #####
        @$page  = $_GET['page'];
        $setting_val = " '1' ";
        if($page == 'draft_products'){
            $setting_val = " '0' ";
        }

        if($search) { $search_sql = "
                    (( `a`.`acc_name` LIKE '%{$search}%' ) OR
                     ( `a`.`acc_email` LIKE '%{$search}%' ))
                                        AND
                                        ";
            



        } else 
        { $search_sql = ''; }

        ############# GET TOTAL ROWS #############
         $total_count_sql = " SELECT  COUNT(`a`.`acc_id`) AS cnt
        FROM accounts_user AS `a`
     
      WHERE  
    {$search_sql}

        ( `a`.`acc_type` = '1') 
        AND `a`.`acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_name='user_type' AND setting_val='Trial')
        ";


    
        $all_data = $this->dbF->getRow($total_count_sql);
         $recordsTotal = $all_data['cnt'];


        ###### Get Data ######
        $qry = "SELECT  `a`.*
        FROM accounts_user AS `a`
    
      WHERE  

                {$search_sql}

                
                  ( `a`.`acc_type` = '1') AND `a`.`acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_name='user_type' AND setting_val='Trial')
                ORDER BY `a`.`acc_id` DESC LIMIT {$start},{$length} ";


        $data = $this->dbF->getRows($qry);


        $columns = array();
        if($draw == 1){ $draw - 1; }

        $columns["draw"] =$draw+1;
        $columns["recordsTotal"] = $recordsTotal; //total record,
        $columns["recordsFiltered"] = $recordsTotal; //filter record, same as total record, then next button will appear

        $i = $start;
        foreach($data as $key => $val){
            $i++;
            
             $id = $val['acc_id'];
            $pName = "";
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='account_type'");
            $account_type = $d[0];
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='user_type'");
            $user_type = $d[0];
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='date_of_expiry'");
            $date_of_expiry = $d[0];
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='account_under'");
            if($account_type != 'Master'){$pName = $this->functions->UserName($d[0]);}
            $d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='role' AND `id_user`='$id'");
            $role = $d[0];
            $setPswrdHash = $val['acc_email'].'--'.$this->functions->decode($val['acc_pass']);
            $setPswrdHash = base64_encode($setPswrdHash);
            $link2        =   WEB_URL . "/login.php?".'set='.$setPswrdHash;
         
                      if( $this->UserType2($id) == "on"){ $chk_status ="SuperUser";}
             else{  $chk_status = $this->UserType($id);}
                
                 $acc_name =           $val['acc_name']."-(".$role.")";
                 $acc_email =          $val['acc_email'];
                 $last_login =          $val['last_login'];
                 $account_typePname =   $account_type."-(".$pName.")";
                 if($user_type=='Trial'){$user_type= $user_type.' - Exp:'.$date_of_expiry;}else{$user_type;}
                 $acc_created=   $val['acc_created'];
            # this functions uses $_SERVER['REQUEST_URI'], as now we are using ajax request so the link in $_SERVER['REQUEST_URI'] is of the ajax request not the current url in browser, so we are hardcoding this for the time being, new way / function will have to be created.
             //$link  = $this->functions->getLinkFolder();
            $link  = '-userEvent?page=edit&eventId='.$id;
            


            $uniq = ( isset($_GET['uniq']) ) ? $_GET['uniq'] : 'no-uniq';
            $first_column = " 
                        <div class='checkbox'>
                            <label>
                                <input type='checkbox' ng-checked='$uniq' name='productListCheck[]' value='$id'> $i
                            </label>
                        </div>
            ";


            $myprefix = 'userId';
            $login = " <div class='btn-group btn-group-sm'><a data-id='$id' data-val='1' href='$link2' target='_blank' class='btn' title='User Login'>
                                <i class='glyphicon glyphicon-user'></i>
                            </a>  <a data-id='$id' data-val='1' href='-setting?page=history&id=$id' target='_blank' class='btn' title='Activity Log'>
                                 <i class='glyphicon glyphicon-time'></i>
                             </a></div>";
            $action = "
                            
                                <div class='btn-group btn-group-sm'>
                                   

                               
                               <a data-id='$id' data-val='1' onclick='activeWebUser(this);' class='btn' title='Active User'>
                                <i class='glyphicon glyphicon-thumbs-up trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>

                            <a data-id='$id' href='-webUsers?page=edit&userId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>

                            <a data-id='$id' onclick='deleteWebUser(this);' class='btn'   title='Delete Email'>
                                <i class='glyphicon glyphicon-trash trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>
                                </div>
                           
                    ";

            //6 columns
            $columns["data"][$key] = array(
                 ##### disabling this for the time being needs work "{$first_column}",
                    
   

            $i,
           
            $acc_name,
            $acc_email,
            $last_login,
            $account_typePname,
             $chk_status,
             $user_type,
            $acc_created,
            $login,
             $action
            );
        }
        if($recordsTotal =='0'){
            $columns["data"] = array();
        }
        //Jason Encode
        echo json_encode( $columns );
    


}



    function fetch_WebUsers(){

  
    
        global $_e, $functions;
        $start  = ( isset($_POST['start']) )  ? $_POST['start']             : 0;
        $length = ( isset($_POST['length']) ) ? $_POST['length']            : 10;
        $draw   = ( isset($_POST['draw']) )   ? (int) $_POST['draw']        : null;
        $search = ( isset($_POST['search']) ) ? ($_POST['search']['value']) : null;

        #### Search Query #####
        @$page  = $_GET['page'];
        $setting_val = " '1' ";
        if($page == 'draft_products'){
            $setting_val = " '0' ";
        }

       if($search) { $search_sql = "
                    (( `a`.`acc_id` LIKE '%{$search}%' ) OR
                    ( `a`.`acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `setting_val`='{$search}' )) OR
                    ( `a`.`acc_name` LIKE '%{$search}%' ) OR
                     ( `a`.`acc_email` LIKE '%{$search}%' ))
                                        AND
                                    ";
            



        } else 
        { $search_sql = ''; }

        ############# GET TOTAL ROWS #############
         $total_count_sql = " SELECT  COUNT(`a`.`acc_id`) AS cnt
        FROM accounts_user AS `a` 
       
      WHERE  
    {$search_sql}
        ( `a`.`acc_type` = '1') 

        ";


    
        $all_data = $this->dbF->getRow($total_count_sql);
         $recordsTotal = $all_data['cnt'];


        ###### Get Data ######
        $qry = "SELECT  `a`.*
        FROM accounts_user AS `a`
    
      WHERE  

                {$search_sql}

                
                ( `a`.`acc_type` = '1')
                ORDER BY `a`.`acc_id` DESC LIMIT {$start},{$length} ";


        $data = $this->dbF->getRows($qry);


        $columns = array();
        if($draw == 1){ $draw - 1; }

        $columns["draw"] =$draw+1;
        $columns["recordsTotal"] = $recordsTotal; //total record,
        $columns["recordsFiltered"] = $recordsTotal; //filter record, same as total record, then next button will appear

        $i = $start;
        foreach($data as $key => $val){
            $i++;
            
             $id = $val['acc_id'];
            $pName = "";
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='account_type'");
            $account_type = $d[0];
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='user_type'");
            $user_type = $d[0];
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='date_of_expiry'");
            $date_of_expiry = $d[0];
            $d = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='account_under'");
            if($account_type != 'Master' && $account_type != 'CEO'){$pName = $this->functions->UserName($d[0]);$account_under =$d[0];}
            $d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='role' AND `id_user`='$id'");
            $role = $d[0];
            $setPswrdHash = $val['acc_email'].'--'.$this->functions->decode($val['acc_pass']);
            $setPswrdHash = base64_encode($setPswrdHash);
            $link2        =   WEB_URL . "/login.php?".'set='.$setPswrdHash;
         
                      if( $this->UserType2($id) == "on"){ $chk_status ="SuperUser";}
             else{  $chk_status = $this->UserType($id);}
                
                 $acc_name =           $val['acc_name']." (".$role.")";
                 $acc_email =          $val['acc_email'];
                 $last_login =          $val['last_login'];
                 $account_typePname =   $account_type." (".$pName.")";
                 if($user_type=='Trial'){$user_type= $user_type.' - Exp:'.$date_of_expiry;}else{$user_type;}
                 $acc_created=   $val['acc_created'];
            # this functions uses $_SERVER['REQUEST_URI'], as now we are using ajax request so the link in $_SERVER['REQUEST_URI'] is of the ajax request not the current url in browser, so we are hardcoding this for the time being, new way / function will have to be created.
             //$link  = $this->functions->getLinkFolder();
            $link  = '-userEvent?page=edit&eventId='.$id;
            


            $uniq = ( isset($_GET['uniq']) ) ? $_GET['uniq'] : 'no-uniq';
            $first_column = " 
                        <div class='checkbox'>
                            <label>
                                <input type='checkbox' ng-checked='$uniq' name='productListCheck[]' value='$id'> $i
                            </label>
                        </div>
            ";


            $myprefix = 'userId';
            $login = " <div class='btn-group btn-group-sm'><a data-id='$id' data-val='1' href='$link2' target='_blank' class='btn' title='User Login'>
                                <i class='glyphicon glyphicon-user'></i>
                            </a>  <a data-id='$id' data-val='1' href='-setting?page=history&id=$id' target='_blank' class='btn' title='Activity Log'>
                                 <i class='glyphicon glyphicon-time'></i>
                             </a></div>";
            $action = "
                            
                                <div class='btn-group btn-group-sm'>
                                   

                               
                               <a data-id='$id' data-val='0' onclick='activeWebUser(this);' class='btn' title='DeActive User'>
                                <i class='glyphicon glyphicon-thumbs-down trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>

                            <a data-id='$id' href='-webUsers?page=edit&userId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>

                            <a data-id='$id' onclick='deleteWebUser(this);' class='btn'   title='Delete Email'>
                                <i class='glyphicon glyphicon-trash trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>
                                </div>
                           
                    ";

            //6 columns
            $columns["data"][$key] = array(
                 ##### disabling this for the time being needs work "{$first_column}",
                    
   

            $i,
            // $id."  (".$account_under.")",
            $acc_name,
            $acc_email,
            $last_login,
            $account_typePname,
             $chk_status,
             $user_type,
            $acc_created,
            $login,
             $action
            );
        }
        if($recordsTotal =='0'){
            $columns["data"] = array();
        }
        //Jason Encode
        echo json_encode( $columns );
    


}
}
?>
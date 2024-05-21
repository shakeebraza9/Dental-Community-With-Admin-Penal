<?php
require_once (__DIR__."/../../global_ajax.php"); //connection setting db
class userevent_ajax extends object_class{
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
        //ajax class
        $_w['Delete'] = '' ;
        $_w['Event Management'] = '' ;
        $_w['Event Delete Successfully'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin userevent');
    }

public function deleteuserevent(){
    global $_e;
    try{
        $this->db->beginTransaction();
        $id=intval($_POST['id']);

       $sql2="DELETE FROM userevent WHERE id='$id'";
       $this->dbF->setRow($sql2,false);
        if($this->dbF->rowCount) echo '1';
        else echo '0';

        $this->db->commit();
        $this->functions->setlog(($_e['Delete']),($_e['Event Management']),$id,($_e['Event Delete Successfully']));
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }
}



public function fetch_draft_userevent(){


  
    
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
                    ( `e`.`title` LIKE '%{$search}%'
                   OR `a`.`acc_name` LIKE '%{$search}%'
                   OR `u`.`due_date` LIKE '%{$search}%' 
 
                  
                   )
                                        AND
                                    ";
            



        } else 
        { $search_sql = ''; }

        ############# GET TOTAL ROWS #############
         $total_count_sql = " SELECT  COUNT(`u`.`id`) AS cnt
        FROM userevent AS `u`
     INNER JOIN `eventmanagement`   AS `e` ON `u`.`title_id`  = `e`.`id`
     INNER JOIN `accounts_user`     AS `a` ON `u`.`user` = `a`.`acc_id`
   WHERE 
    {$search_sql}

        (`u`.`approved`='-1' OR `u`.`approved`='0')
        ";


    
        $all_data = $this->dbF->getRow($total_count_sql);
         $recordsTotal = $all_data['cnt'];


        ###### Get Data ######
        $qry = "SELECT `u`.*, 
            `e`.`title` as title,
            `u`.`title_id` as title_id,
             `a`.`acc_name` as acc_name
        
        FROM userevent AS `u`
   INNER JOIN `eventmanagement`        AS `e` ON `u`.`title_id`  = `e`.`id`
 INNER JOIN `accounts_user`          AS `a` ON `u`.`user` = `a`.`acc_id`
   WHERE 

                {$search_sql}

                
                ( `u`.`approved`='-1' OR `u`.`approved`='0')
                ORDER BY `e`.`title` DESC LIMIT {$start},{$length} ";

      
        $data = $this->dbF->getRows($qry);


        $columns = array();
        if($draw == 1){ $draw - 1; }

        $columns["draw"] =$draw+1;
        $columns["recordsTotal"] = $recordsTotal; //total record,
        $columns["recordsFiltered"] = $recordsTotal; //filter record, same as total record, then next button will appear

        $i = $start;
        foreach($data as $key => $val){
            $i++;
            
          
            $uid = $val['user'];
            $sql = "SELECT acc_name FROM `accounts_user` WHERE acc_id= ? ";
            $uid = $this->dbF->getRow($sql,array($uid)); 

            $uid = $uid['acc_name'];
               
            $usertype = $functions->UserType($val['user']);
           // var_dump($usertype);
            $ddate = date("d-M-Y",strtotime($val['due_date']));
            if(empty($val['due_date'])){
                $ddate = 'N/A';
            }
            if(empty($val['dateTime'])){
                $cdate = 'N/A';
            }
            else{
                $cdate = date("d-M-Y",strtotime($val['dateTime']));
            }
            
            $RTitle = '('.$val['title_id'].') - '.$functions->eventTitle($val['title_id']);
            $id    = $val['id'];
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


            $myprefix = 'eventId';
            
            $action = "
                            
                                <div class='btn-group btn-group-sm'>
                                   

                                <a data-id='$id' href='?{$myprefix}=$id'
                                    data-method='post' data-action='$link'
                                    class='btn'><i class='glyphicon glyphicon-edit'></i></a>
                                <a data-id='$id' onclick='deleteuserevent(this);'  class='btn '>
                                    <i class='glyphicon glyphicon-trash trash'></i>
                                    <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                                </a>
                                </div>
                           
                    ";

            //6 columns
            $columns["data"][$key] = array(
                 ##### disabling this for the time being needs work "{$first_column}",
                    
   

            $i,
            $uid,
            $usertype,
           $RTitle,
            $ddate,
            $cdate,
          
            
                
             $action
            );
        }
        if($recordsTotal =='0'){
            $columns["data"] = array();
        }
        //Jason Encode
        echo json_encode( $columns );
    



}
public function fetch_userevent(){

  
    
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
                    ( `e`.`title` LIKE '%{$search}%'
                   OR `a`.`acc_name` LIKE '%{$search}%'
                   OR `u`.`due_date` LIKE '%{$search}%' 
 
                  
                   )
                                        AND
                                    ";
            



        } else 
        { $search_sql = ''; }

        ############# GET TOTAL ROWS #############
         $total_count_sql = " SELECT  COUNT(`u`.`id`) AS cnt
        FROM userevent AS `u`
     INNER JOIN `eventmanagement`   AS `e` ON `u`.`title_id`  = `e`.`id`
     INNER JOIN `accounts_user`     AS `a` ON `u`.`user` = `a`.`acc_id`
   WHERE 
    {$search_sql}

         `u`.`approved` = '1' 
        ";

        # overriding sql for pending products, for total count and normal count
        if ($page == 'pending_eventForms') {

            $date=date('m/d/Y');
            $total_count_sql = $qry="  ";

        }


    
        $all_data = $this->dbF->getRow($total_count_sql);
         $recordsTotal = $all_data['cnt'];


        ###### Get Data ######
        $qry = "SELECT `u`.*, 
            `e`.`title` as title,
            `u`.`title_id` as title_id,
             `a`.`acc_name` as acc_name
        
        FROM userevent AS `u`
   INNER JOIN `eventmanagement`        AS `e` ON `u`.`title_id`  = `e`.`id`
 INNER JOIN `accounts_user`          AS `a` ON `u`.`user` = `a`.`acc_id`
   WHERE 

                {$search_sql}

                
                 `u`.`approved`='1'
                ORDER BY `e`.`title` DESC LIMIT {$start},{$length} ";

        # overriding sql for pending products, for total count and normal count
        if ($page == 'pending_products') {
            $qry = $total_count_sql;
        }

        $data = $this->dbF->getRows($qry);


        $columns = array();
        if($draw == 1){ $draw - 1; }

        $columns["draw"] =$draw+1;
        $columns["recordsTotal"] = $recordsTotal; //total record,
        $columns["recordsFiltered"] = $recordsTotal; //filter record, same as total record, then next button will appear

        $i = $start;
        foreach($data as $key => $val){
            $i++;
            
          
            $uid = $val['user'];

            $sql = "SELECT acc_name FROM `accounts_user` WHERE acc_id= ? ";
            $uid = $this->dbF->getRow($sql,array($uid) ); 

            $acc_name = $uid['acc_name'];
               
            $usertype = $functions->UserType($val['user']);
           // var_dump($usertype);
            $ddate = date("d-M-Y",strtotime($val['due_date']));
            if(empty($val['due_date'])){
                $ddate = 'N/A';
            }
            if(empty($val['dateTime'])){
                $cdate = 'N/A';
            }
            else{
                $cdate = date("d-M-Y",strtotime($val['dateTime']));
            }

            $RTitle = '('.$val['title_id'].') - '.$functions->eventTitle($val['title_id']);
            $id    = $val['id'];
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


            $myprefix = 'eventId';
            
            $action = "
                            
                                <div class='btn-group btn-group-sm'>
                                   

                                <a data-id='$id' href='?{$myprefix}=$id'
                                    data-method='post' data-action='$link'
                                    class='btn'><i class='glyphicon glyphicon-edit'></i></a>
                                <a data-id='$id' onclick='deleteuserevent(this);'  class='btn '>
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
            $usertype,
           $RTitle,
            $ddate,
            $cdate,
          
            
                
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
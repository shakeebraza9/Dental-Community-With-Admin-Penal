<?php
require_once (__DIR__."/../../global_ajax.php"); //connection setting db
class setting_ajax extends object_class{
    public function __construct(){
        parent::__construct('3');
    }

public function deleteHardWord(){
    try{
        $this->db->beginTransaction();

        $id= intval($_POST['id']);

       $sql2="DELETE FROM hardwords WHERE id='$id'";
       $this->dbF->setRow($sql2,false);
        if($this->dbF->rowCount) echo '1';
        else echo '0';

        $this->db->commit();
        $this->functions->setlog('DELETE','Special Words',$id,'Special Words Delete Successfully');
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }
}

  public function DeleteTrashDataadmin(){
          if($_SESSION['currentUserType'] == 'Employee')
        {$user=$_SESSION['superid'];}
    else
       {$user = $_SESSION['currentUser'];}

   $edit_id = intval($_POST['itemId']);
     $sql =  "SELECT * FROM `trashdata` WHERE id = ? ";
       $data=$this->dbF->getRow($sql,array($edit_id));
       
      $ds = "Page Name::".$data['delete_page_name']."::Description::".$data['delete_desc']."File Name::".$data['delete_file']."Delete User By::".$this->functions->UserName($data['delete_from_user'])."Delete User Of::".$this->functions->UserName($data['delete_to_user'])."Delete Table Name::".$data['delete_table_name']."Delete Table Id::".$data['delete_table_id']."Delete Event Perform::".$data['event_perfom']."";  
     
     $this->functions->setlog("TrashData Record Delete ","User By::".$this->functions->UserName($user)." :User off".$this->functions->UserName($data['delete_to_user']),$user,$ds);
          $sql1 = "DELETE FROM `trashdata` WHERE id = '$edit_id'";
         $this->dbF->setRow($sql1);
          
        if($this->dbF->rowCount > 0){
            echo 1;
        }
     }  
    


function fetch_history(){


  
    
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
                    ( `a`.`log_title` LIKE '%{$search}%' )
                    OR  ( `a`.`log_time` LIKE '%{$search}%' )
                    OR  ( `a`.`ref_name` LIKE '%{$search}%' )
                    OR  ( `a`.`ref_user` LIKE '%{$search}%' )
                                        AND
                                    ";
            



        } else 
        { $search_sql = ''; }

        ############# GET TOTAL ROWS #############
         $total_count_sql = " SELECT  COUNT(`a`.`log_id`) AS cnt
        FROM activity_log AS `a`
     
      WHERE  
    {$search_sql}

        ( `a`.`log_title` != '') 
        ";


    
        $all_data = $this->dbF->getRow($total_count_sql);
         $recordsTotal = $all_data['cnt'];


        ###### Get Data ######
        $qry = "SELECT  `a`.*
        FROM activity_log AS `a`
    
      WHERE  

                {$search_sql}

                
                 (`a`.`log_title` !='')
                 ORDER BY `a`.`log_title`,`a`.`log_time`  DESC LIMIT {$start},{$length} ";


        $data = $this->dbF->getRows($qry);


        $columns = array();
        if($draw == 1){ $draw - 1; }

        $columns["draw"] =$draw+1;
        $columns["recordsTotal"] = $recordsTotal; //total record,
        $columns["recordsFiltered"] = $recordsTotal; //filter record, same as total record, then next button will appear

        $i = $start;
        foreach($data as $key => $val){
            $i++;
            
                    $id = $val['log_id'];
                    $log_title = $val['log_title'];
                    $ref_name = $val['ref_name'];
                    $log_time = $val['log_time'];
                    $ref_user = $val['ref_user'];
                    $log_desc = $val['log_desc'];
                    $log_ip = $val['log_ip'];
                    $log_browser = $val['log_browser'];
           
            # this functions uses $_SERVER['REQUEST_URI'], as now we are using ajax request so the link in $_SERVER['REQUEST_URI'] is of the ajax request not the current url in browser, so we are hardcoding this for the time being, new way / function will have to be created.
             //$link  = $this->functions->getLinkFolder();
            
            


            $uniq = ( isset($_GET['uniq']) ) ? $_GET['uniq'] : 'no-uniq';
            $first_column = " 
                        <div class='checkbox'>
                            <label>
                                <input type='checkbox' ng-checked='$uniq' name='productListCheck[]' value='$id'> $i
                            </label>
                        </div>
            ";


          
            
         

            //6 columns
            $columns["data"][$key] = array(
                 ##### disabling this for the time being needs work "{$first_column}",
                    
   

            $i,
           
          $log_title, 
$ref_name, 
$log_time, 
$ref_user, 
$log_desc, 
$log_ip, 
$log_browser 
             
            );
        }
        if($recordsTotal =='0'){
            $columns["data"] = array();
        }
        //Jason Encode
        echo json_encode( $columns );
    



}
function fetc_Trash(){
  
     

  
    
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
                    ( `t`.`delete_table_name` LIKE '%{$search}%'
                   OR `a`.`acc_name` LIKE '%{$search}%'
                   OR `t`.`delete_page_name` LIKE '%{$search}%' 
 
                  
                   )          AND
                                    ";
            



        } else 
        { $search_sql = ''; }

        ############# GET TOTAL ROWS #############
         $total_count_sql = " SELECT  COUNT(`t`.`id`) AS cnt
         FROM trashdata AS `t`
    
     INNER JOIN `accounts_user`  AS `a` ON `t`.`delete_from_user` = `a`.`acc_id`
   WHERE 
    {$search_sql}
      ( `t`.`delete_from_user` > 0  )
        
             ";


    
        $all_data = $this->dbF->getRow($total_count_sql);
         $recordsTotal = $all_data['cnt'];


        ###### Get Data ######
        $qry = "SELECT `t`.*, 
            
             `a`.`acc_name` as acc_name
        
        FROM trashdata AS `t`
        INNER JOIN `accounts_user`          AS `a` ON `t`.`delete_from_user` = `a`.`acc_id`
        WHERE 

                {$search_sql}
 
               ( `t`.`delete_from_user` > 0  )
               
                 ORDER BY `t`.`delete_from_user`    DESC LIMIT {$start},{$length} ";

      

        $data = $this->dbF->getRows($qry);


        $columns = array();
        if($draw == 1){ $draw - 1; }

        $columns["draw"] =$draw+1;
        $columns["recordsTotal"] = $recordsTotal; //total record,
        $columns["recordsFiltered"] = $recordsTotal; //filter record, same as total record, then next button will appear

        $i = $start;
        foreach($data as $key => $val){
            $i++;
             $replace = WEB_URL."/images/".$val['delete_file'];
             $replace = "<a href=".$replace." ></a> ";
             $val['delete_page_name'];
             $val['delete_desc'];
             $replace;           
             $val['delete_from_user'];
             $val['delete_to_user'];
             $val['delete_table_name'];
            $val['delete_table_id'];
            $val['event_perfom'];
          
            $nameFrom = $val['delete_from_user'];

            $sql = "SELECT acc_name FROM `accounts_user` WHERE acc_id='$nameFrom'";
            $nameFrom = $this->dbF->getRow($sql); 
            $nameFrom = $nameFrom['acc_name'];
            



            $nameTo = $val['delete_to_user'];
            $sql = "SELECT acc_name FROM `accounts_user` WHERE acc_id='$nameTo'";
            $nameTo = $this->dbF->getRow($sql); 
            $nameTo = $nameTo['acc_name'];

            $id    = $val['id'];
            # this functions uses $_SERVER['REQUEST_URI'], as now we are using ajax request so the link in $_SERVER['REQUEST_URI'] is of the ajax request not the current url in browser, so we are hardcoding this for the time being, new way / function will have to be created.
             //$link  = $this->functions->getLinkFolder();
          //  $link  = '-userEvent?page=edit&eventId='.$id;
            


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
                                   

                               
                                <a data-id='$id' onclick='DeleteTrashDataadmin(this);'  class='btn '>
                                    <i class='glyphicon glyphicon-trash trash'></i>
                                    <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                                </a>
                                </div>
                           
                    ";

            //6 columns
            $columns["data"][$key] = array(
                 ##### disabling this for the time being needs work "{$first_column}",
                   
   

            $i,
             $val['delete_page_name'],
             $val['delete_desc'],
             $replace,           
            $nameFrom,
            $nameTo,
            $val['delete_table_name'],
            $val['delete_table_id'],
            $val['event_perfom'],
            
            
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
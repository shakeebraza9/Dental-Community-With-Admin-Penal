<?php
require_once (__DIR__."/../../global_ajax.php"); //connection setting db
class userdocuments_ajax extends object_class{
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
        $_w['User Documents Management'] = '' ;
        $_w['User Documents Delete Successfully'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Document');
    }

public function deleteuserdocuments(){
    global $_e;
    try{
        $this->db->beginTransaction();
        $id=intval($_POST['id']);

       $sql2="DELETE FROM userdocuments WHERE id='$id'";
       $this->dbF->setRow($sql2,false);
        if($this->dbF->rowCount) echo '1';
        else echo '0';

        $this->db->commit();
        $this->functions->setlog(($_e['Delete']),($_e['User Documents Management']),$id,($_e['User Documents Delete Successfully']));
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }
}

public function fetch_userdocuments(){



  
    
        global $_e, $functions;
        $start  = ( isset($_POST['start']) )  ? $_POST['start']             : 0;
        $length = ( isset($_POST['length']) ) ? $_POST['length']            : 10;
        $draw   = ( isset($_POST['draw']) )   ? (int) $_POST['draw']        : null;
        $search = ( isset($_POST['search']) ) ? ($_POST['search']['value']) : null;

        #### Search Query #####
        @$page  = $_GET['page'];
        $setting_val = " '1' ";
       
        if($search) { $search_sql = "
                    ( `u`.`title` LIKE '%{$search}%'
                   OR `a`.`acc_name` LIKE '%{$search}%'
                   OR `u`.`category` LIKE '%{$search}%' 
                   OR `u`.`sub_category` LIKE '%{$search}%' 
                       
                       )
                                        AND
                                    ";
            



        } else 
        { $search_sql = ''; }

        ############# GET TOTAL ROWS #############
       

         $total_count_sql = " SELECT  COUNT(`u`.`id`) AS cnt
        FROM userdocuments AS `u`
    
     INNER JOIN `accounts_user`     AS `a` ON `u`.`user` = `a`.`acc_id`
   WHERE 
    {$search_sql}
 
        ( `u`.`archive` = '0' )
        ";


    
        $all_data = $this->dbF->getRow($total_count_sql);
         $recordsTotal = $all_data['cnt'];


        ###### Get Data ######
        $qry = "SELECT `u`.*, 
            
             `a`.`acc_name` as acc_name
       
        FROM userdocuments AS `u`
     
     INNER JOIN `accounts_user`     AS `a` ON `u`.`user` = `a`.`acc_id`
   WHERE 

                {$search_sql}

                
                 (`u`.`archive` ='0')
                ORDER BY `u`.`title` DESC LIMIT {$start},{$length} ";

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
            $id = $val['id'];
            $name = $this->functions->UserName($val['user']);
            $download = "File not available";
            $completion_date = $expiry_date ="N|A";
            if($val['file'] != '#'){
                $download = "<a href='$val[file]' target='_blank'>Download</a>";
            }    
            if(!empty($val['completion_date'])){
                $completion_date = date('d-M-Y',strtotime($val['completion_date']));
            }
            if(!empty($val['expiry_date'])){
                $expiry_date = date('d-M-Y',strtotime($val['expiry_date']));
            }
               $title =   $val['title'];
                $category =  $val['category'];
            $sub_dcategory =  $val['sub_dcategory'];
            
        
            $link  = '-userdocuments?page=edit&userdocumentsId='.$id;
            


            $uniq = ( isset($_GET['uniq']) ) ? $_GET['uniq'] : 'no-uniq';
            $first_column = " 
                        <div class='checkbox'>
                            <label>
                                <input type='checkbox' ng-checked='$uniq' name='productListCheck[]' value='$id'> $i
                            </label>
                        </div>
            ";


            $myprefix = 'userdocumentsId';
            
            $action = "
                            
                                <div class='btn-group btn-group-sm'>
                                   

                                <a data-id='$id' href='?{$myprefix}=$id'
                                    data-method='post' data-action='$link'
                                    class='btn'><i class='glyphicon glyphicon-edit'></i></a>
                                <a data-id='$id' onclick='deleteuserdocuments(this);'  class='btn '>
                                    <i class='glyphicon glyphicon-trash trash'></i>
                                    <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                                </a>
                                </div>
                           
                    ";

            //6 columns
            $columns["data"][$key] = array(
                 ##### disabling this for the time being needs work "{$first_column}",
                    
   

            $i,
           
                   
            $title,
            $name,
            $category,
            $sub_dcategory,
            $download,
            $completion_date,
            $expiry_date,
            $val['desc'],
            
                    
          
            
                
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
<?php
require_once (__DIR__."/../../global_ajax.php"); //connection setting db
class usereventForm_ajax extends object_class{
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
        $_w['User Event Forms Management'] = '' ;
        $_w['User Event Forms Delete Successfully'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin usertraining');
    }

public function deleteusereventForm(){
    global $_e;
    try{
        $this->db->beginTransaction();
        $id=intval($_POST['id']);

       $sql2="DELETE FROM usereventForms WHERE id='$id'";
       $this->dbF->setRow($sql2,false);
        if($this->dbF->rowCount) echo '1';
        else echo '0';

        $this->db->commit();
        $this->functions->setlog(($_e['Delete']),($_e['User Event Forms Management']),$id,($_e['User Event Forms Delete Successfully']));
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }
}

public function fetch_usereventForm(){

  
    
        global $_e, $functions;
        $start  = ( isset($_POST['start']) )  ? $_POST['start']             : 0;
        $length = ( isset($_POST['length']) ) ? $_POST['length']            : 10;
        $draw   = ( isset($_POST['draw']) )   ? (int) $_POST['draw']        : null;
        $search = ( isset($_POST['search']) ) ? ($_POST['search']['value']) : null;

        #### Search Query #####
        $page  = $_GET['page'];
        $setting_val = " '1' ";
        if($page == 'draft_products'){
            $setting_val = " '0' ";
        }

        if($search) { $search_sql = "
                    ( 
                  
                       `a`.`acc_name` LIKE '%{$search}%'

                      OR`ue`.`question` LIKE '%{$search}%'
                  
                     OR `e`.`title` LIKE '%{$search}%'
                   
                   
                   )
                          AND               
                                    ";
        } else 
        { $search_sql = ''; }

        ############# GET TOTAL ROWS #############
        $total_count_sql = " SELECT 
       
           COUNT(`u`.id) AS `cnt`
FROM `usereventForms` AS `u`
INNER JOIN `eventmanagement`        AS `e` ON `u`.`title_id`  = `e`.`id`
INNER JOIN `accounts_user`          AS `a` ON `u`.`user` = `a`.`acc_id`
INNER JOIN `eventForms`          AS `ue` ON `u`.`q_id` = `ue`.`id`

         WHERE {$search_sql} 

       (`u`.`title_id` != '')
              ";

    
        $all_data = $this->dbF->getRow($total_count_sql);
         $recordsTotal = $all_data['cnt'];


        ###### Get Data ######
        $qry = " SELECT 
       
           `u`.*, 
          
         `e`.`title` as 'title',
         `a`.`acc_name` as 'acc_name',
         `ue`.`question` as 'question'
FROM `usereventForms` AS `u`
INNER JOIN `eventmanagement`        AS `e` ON `u`.`title_id`  = `e`.`id`
INNER JOIN `accounts_user`          AS `a` ON `u`.`user` = `a`.`acc_id`
INNER JOIN `eventForms`          AS `ue` ON `u`.`q_id` = `ue`.`id`

         WHERE {$search_sql}

                
                 (`u`.`title_id` != '')
                ORDER BY `e`.`title` DESC LIMIT {$start},{$length} ";
        # overriding sql for pending products, for total count and normal count
       // echo $qry;
        $data = $this->dbF->getRows($qry);


        $columns = array();
        if($draw == 1){ $draw - 1; }

        $columns["draw"] =$draw+1;
        $columns["recordsTotal"] = $recordsTotal; //total record,
        $columns["recordsFiltered"] = $recordsTotal; //filter record, same as total record, then next button will appear

        $i = $start;
        foreach($data as $key => $val){
            //  echo "<pre>";
            // print_r($data);
            //  echo "</pre>";
            $i++;
            $defaultLang= $this->functions->AdminDefaultLanguage();
            
            $id    = $val['id'];
            $acc_name= $val['acc_name'];
            $title= $val['title'];
            $question= $val['question'];
            $radio= $val['radio'];
            $date= $val['date'];
            $time= $val['time'];
            $field1= $val['field1'];
            $field2=  $val['field2'];
           
           
            
            $RTitle = '('.$val['title_id'].') - '.$functions->eventTitle($val['title_id']);
            # this functions uses $_SERVER['REQUEST_URI'], as now we are using ajax request so the link in $_SERVER['REQUEST_URI'] is of the ajax request not the current url in browser, so we are hardcoding this for the time being, new way / function will have to be created.
             //$link  = $this->functions->getLinkFolder();
          $link  = '-usereventForm?page=edit&eventId='.$id;
            


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
                $i, ##### disabling this for the time being needs work "{$first_column}",

            $title,
            $acc_name,
            $question,
            $radio,
            $date,
            $time,
            $field1,
            $field2,
            
                
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
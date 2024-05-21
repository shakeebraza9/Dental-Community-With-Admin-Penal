<?php

require_once (__DIR__."/../../global_ajax.php"); //connection setting db

class paper_ajax extends object_class{

    public function __construct(){

        parent::__construct('3');

    }



public function deletePaper(){

    try{

        $this->db->beginTransaction();



        $id=$_POST['id'];

        $del_sql = "DELETE FROM `paper` WHERE `paper_id` = ?";

        $stmt = $this->db->prepare($del_sql);

        $stmt->execute( array($id) );

        $stmt->rowCount();

        // var_dump($stmt->rowCount());

        if($stmt->rowCount()) echo '1';

        else echo '0';



        // ### This is not working, echo 0 happens, page is deleted but js gives error because 0 is output below instead on 1

        // $sql2="DELETE FROM pages WHERE page_pk='$id'";

        // $this->dbF->setRow($sql2,false);

        // $this->functions->setting_fieldsDelete($id,'pages',false);

        // if($this->dbF->rowCount) echo '1';

        // else echo '0';



        $this->db->commit();

    }catch (PDOException $e) {

        echo '0';

        $this->db->rollBack();

        $this->dbF->error_submit($e);

    }

}

public function deleteAssignedPaper(){

    try{

        $this->db->beginTransaction();



        $id=$_POST['id'];

        $del_sql = " DELETE FROM `assigned_paper` WHERE `assign_id` = ? ";

        $stmt = $this->db->prepare($del_sql);

        $stmt->execute( array($id) );

        $stmt->rowCount();

        // var_dump($stmt->rowCount());

        if($stmt->rowCount()) echo '1';

        else echo '0';



        // ### This is not working, echo 0 happens, page is deleted but js gives error because 0 is output below instead on 1

        // $sql2="DELETE FROM pages WHERE page_pk='$id'";

        // $this->dbF->setRow($sql2,false);

        // $this->functions->setting_fieldsDelete($id,'pages',false);

        // if($this->dbF->rowCount) echo '1';

        // else echo '0';



        $this->db->commit();

    }catch (PDOException $e) {

        echo '0';

        $this->db->rollBack();

        $this->dbF->error_submit($e);

    }

}
public function Fetch_AssignedPaper(){


  
    
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
                    ( `p`.`assign_id` LIKE '%{$search}%'
                  
                   OR `a`.`acc_name` LIKE '%{$search}%'
                   
                   OR `a`.`acc_email` LIKE '%{$search}%'
                  
                   OR `pa`.`paper_title` LIKE '%{$search}%'
                   )
                                        AND
                                    ";
        } else 
        { $search_sql = ''; }

        ############# GET TOTAL ROWS #############
        $total_count_sql = " SELECT 
       
           `p`.*,
          `pa`.`paper_title`
      
        FROM `assigned_paper` AS `p`
        INNER JOIN `accounts_user`   AS `a` ON `p`.`assign_user`  = `a`.`acc_id`
        INNER JOIN `paper`   AS `pa` ON `p`.`assign_paper`  = `pa`.`paper_id`
        
         WHERE {$search_sql}


        ( `p`.`assign_id` != '')  ORDER BY `assign_id` DESC
        ";

       


        $all_data = $this->dbF->getRows($total_count_sql);
        $recordsTotal = $this->dbF->rowCount;


        ###### Get Data ######
        $qry = "SELECT  
        `p`.*,
       
         `pa`.`paper_title`
      
        FROM `assigned_paper` AS `p`
        INNER JOIN `accounts_user`   AS `a` ON `p`.`assign_user`  = `a`.`acc_id`
        INNER JOIN `paper`   AS `pa` ON `p`.`assign_paper`  = `pa`.`paper_id`

                WHERE 

                {$search_sql}

                
                ( `p`.`assign_id` != '')
                ORDER BY `assign_id` DESC LIMIT {$start},{$length} ";

       

        $data = $this->dbF->getRows($qry);


        $columns = array();
        if($draw == 1){ $draw - 1; }

        $columns["draw"] =$draw+1;
        $columns["recordsTotal"] = $recordsTotal; //total record,
        $columns["recordsFiltered"] = $recordsTotal; //filter record, same as total record, then next button will appear

        $i = $start;
        foreach($data as $key => $val){
            $i++;
            $defaultLang= $this->functions->AdminDefaultLanguage();
            
               $id = $val['assign_id'];
               $aid = MD5($id);
               $date_timestamp = $val['date_timestamp'];

               $assign_user = $val['assign_user'];

               $assign_paper = $val['assign_paper'];

               $status = $val['status'];
                
                if($status == 0){

                $paperStatus = 'Unattempted';

                }elseif ($status == 1) {

                $paperStatus = 'Attempted';

                }
                             @$feedback = $val['feedback'];
                             @$Rating = $val['star'];
                             @$feedback =  base64_decode($feedback);
                             @$expload = explode("::", $feedback);
                           @$echo0 =  $expload[0];
                           @$echo1 =  $expload[1];

           
            $userData = $functions->getWebUser($assign_user, 'acc_name, acc_email');

            $paperData = $functions->getPaperDetail($assign_paper, 'paper_title');

         
           
            # this functions uses $_SERVER['REQUEST_URI'], as now we are using ajax request so the link in $_SERVER['REQUEST_URI'] is of the ajax request not the current url in browser, so we are hardcoding this for the time being, new way / function will have to be created.
             //$link  = $this->functions->getLinkFolder();
            $link  = '-eventForm?page=edit&eventId='.$id;
            


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
                                   

                               <a href='../printResult.php?assignid=$aid&user=$assign_user' title='With Marks' alt='With Marks' target='_blank' class='btn'>
            <i class='fa fa-file-pdf-o'></i>


       <!--</a> <a href='../printResult2.php?assignid=$aid&user=$assign_user' alt='WithOut Marks' title='WithOut Marks' target='_blank' class='btn'>
            <i class='fa fa-file-pdf-o'></i>
       </a>-->


       <a style='display:none' href='../marked.php?assignid=$id&user=$assign_user' alt='marked answer, question wise' title='marked answer, question wise' target='_blank' class='btn'>
            <i class='fa fa-file-pdf-o'></i>
       </a>


        <a data-id='$id' onclick='deleteAssignment(this);' class='btn'>

            <i class='glyphicon glyphicon-trash trash'></i>

            <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

        </a>
                                </div>
                           
                    ";

            //6 columns
            $columns["data"][$key] = array(
                $i, ##### disabling this for the time being needs work "{$first_column}",

      
$id,
$userData['acc_name'],
$userData['acc_email'],
$paperData['paper_title'],
$paperStatus,
$Rating,
$echo0,
$echo1,
$date_timestamp,
            
                
             $action
            );
        }
        if($recordsTotal =='0'){
            $columns["data"] = array();
        }
        //Jason Encode
        echo json_encode( $columns );
    



}
public function getQuestions(){

    $dataArray = $_POST['dataArray'];
    $return = '';

    if(null!==(@$_POST['edit']) && @$_POST['edit'] == '1'){
        $return .= '<h1 class="main_heading">Choose Questions</h1>
                <div class="questionsMainDiv">';
    }
    
    foreach ($dataArray as $key => $value) {
        $valExpl = explode('|', $value);
        $domain_id = $valExpl[0];
        $questionLimit = $valExpl[1];

        $subject = $this->getSubject($domain_id, 'subject_title'); 
        $subject_title = $subject['subject_title'];

        $questions = $this->getAllQuestions($domain_id);

        if(!empty($questions)){
            $return .= '<div class="singleDomain">
                            <div class="domainTitle"><h3>'.$subject_title.'</h3></div>
                            <div class="domainQuestions">';
                        foreach ($questions as $key => $value) {
                            $return .= '<p><input type="checkbox" class="questionCheck limitDomain_'.$domain_id.'" name="questionId['.$domain_id.'][]" data-id="'.$domain_id.'" data-limit="'.$questionLimit.'" value="'.$value['question_id'].'" onclick="countQuestions(this)"><span>'.$value['question_title'].'</span></p>';
                        }
                $return .= '</div>
                        </div>';
        }
    }

    if(@$_POST['edit'] == '1'){
        $return .= '</div>';
    }
    echo $return;
}


public function getSubject($id=false, $field=false){
    $where = "";
    $column=  "*";
    if($id){
        $where = " AND `subject_id` = $id";
    }
    if($field){
        $column = $field;
    }
    $sql = "SELECT $column FROM `subjects` WHERE 1 $where";
    $res = $this->dbF->getRow($sql);

    return $res;
}

public function getAllQuestions($subject=false){
    $sql = "SELECT * FROM `questions` WHERE `subject` = '$subject'";
    $res = $this->dbF->getRows($sql);

    return $res;
}




}

?>
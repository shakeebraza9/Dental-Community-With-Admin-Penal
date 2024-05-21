<?php
require_once (__DIR__."/../../global_ajax.php"); //connection setting db
class myUploads_ajax extends object_class{
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
        $_w['FilesManager'] = '' ;
        $_w['Files Delete Successfully'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin FilesManager');
    }

public function deletemyUploads(){
    global $_e;
    try{
        $this->db->beginTransaction();
        $id=$_POST['id'];
        $sql1 = "SELECT `file`,`title`,`user` FROM `myuploads` WHERE `id`= ? ";
        $data =  $this->dbF->getRow($sql1,array($id));
        $this->functions->setlog("MyUploads Delete By Admin",$this->functions->userName($data['user'])." : ".$data['user'],"",$data['title']);
        $path = parse_url($data[0],PHP_URL_PATH);
        $name = $_SERVER['DOCUMENT_ROOT'].$path;
        @unlink($name);
        $sql2="DELETE FROM myuploads WHERE id='$id'";
        $this->dbF->setRow($sql2,false);
        if($this->dbF->rowCount) echo '1';
        else echo '0';
        $this->db->commit();
    }catch (PDOException $e) {
        echo '0';
        $this->db->rollBack();
        $this->dbF->error_submit($e);
    }
}


    public function filesManagerSort(){
        $list=$_POST['album'];
        for ($i = 0; $i < count($list); $i++) {
            $sql3="UPDATE `filesmanager` SET sort='$i' WHERE `id`='$list[$i]'";
            $data=$this->dbF->setRow($sql3);
        }
    }


 public function fetch_MyUploads(){


        global $_e, $functions;
        $start  = ( isset($_POST['start']) )  ? $_POST['start']             : 0;
        $length = ( isset($_POST['length']) ) ? $_POST['length']            : 10;
        $draw   = ( isset($_POST['draw']) )   ? (int) $_POST['draw']        : null;
        $search = ( isset($_POST['search']) ) ? ($_POST['search']['value']) : null;

        #### Search Query #####
        @$page  = $_GET['page'];
        
       

        if($search) { $search_sql = "
                    ( `category` LIKE '%{$search}%'
                   OR `title` LIKE '%{$search}%'
                  
                   )
                                        AND
                                    ";
        } else 
        { $search_sql = ''; }

        ############# GET TOTAL ROWS #############
        $total_count_sql = " SELECT COUNT(*) AS cnt FROM myuploads WHERE
          {$search_sql}

        `publish` = '1' 

        ";


         $all_data = $this->dbF->getRow($total_count_sql);
         $recordsTotal = $all_data['cnt'];


        ###### Get Data ######
        $qry = "SELECT * FROM myuploads 

    WHERE
               
                
             
                {$search_sql}

                
               `publish`='1'

               ORDER BY ID DESC LIMIT {$start},{$length} ";

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
            
             
            $id  = $val['id'];
            $uid = $val['user'];
            $title = $val['title'];
            $category = $val['category'];  
            $sub_category = $val['sub_category'];  
            $download = '';
            if($val['file'] != '#'){
                $download = "<a href='$val[file]' download>Download</a>";
            }
            else{
                $download = "File not available";
            }
            $sql = "SELECT acc_name FROM `accounts_user` WHERE acc_id='$uid'";
            $uid = $this->dbF->getRow($sql);
            $uid = $uid['acc_name'];
                    
                  
            
            # this functions uses $_SERVER['REQUEST_URI'], as now we are using ajax request so the link in $_SERVER['REQUEST_URI'] is of the ajax request not the current url in browser, so we are hardcoding this for the time being, new way / function will have to be created.
             //$link  = $this->functions->getLinkFolder();
            $link  = '-myUploads?page=edit&fileId='.$id;
            

         




         

            $uniq = ( isset($_GET['uniq']) ) ? $_GET['uniq'] : 'no-uniq';
            $first_column = " 
                        <div class='checkbox'>
                            <label>
                                <input type='checkbox' ng-checked='$uniq' name='productListCheck[]' value='$id'> $i
                            </label>
                        </div>
            ";


            $myprefix = 'fileId';
            
            $action = "
                            
                                <div class='btn-group btn-group-sm'>
                                   

                                <a data-id='$id' href='?{$myprefix}=$id'
                                    data-method='post' data-action='$link'
                                    class='btn'><i class='glyphicon glyphicon-edit'></i></a>
                                <a data-id='$id' onclick='deletemyUploads(this);'  class='btn '>
                                    <i class='glyphicon glyphicon-trash trash'></i>
                                    <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                                </a>
                                </div>
                           
                    ";

            //6 columns
            $columns["data"][$key] = array(
                $i, ##### disabling this for the time being needs work "{$first_column}",

              $title,
              $category,
              $sub_category,
              $download,
              $uid, 
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
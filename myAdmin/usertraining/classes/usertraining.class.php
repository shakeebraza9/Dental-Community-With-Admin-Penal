<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class usertraining extends object_class{
    public $productF;
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
        $_w['User Training/Document'] = '' ;
        //filesManagerEdit.php
        $_w['Manage User Training/Document'] = '' ;

        //filesManager.php
        $_w['Active Event'] = '' ;
        $_w['Uncompleted User Training/Document'] = '' ;
        $_w['Add New User Training/Document'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;
        $_w['There is an error, Please Refresh Page and Try Again'] = '' ;
        $_w['SNO'] = '' ;
        $_w['Title'] = '' ;
        $_w['IMAGE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Image User Training/Document Error'] = '' ;
        $_w['Image Not Found'] = '' ;
        $_w['User Training/Document'] = '' ;
        $_w['Added'] = '' ;
        $_w['User Training/Document Add Successfully'] = '' ;
        $_w['User Training/Document Add Failed'] = '' ;
        $_w['User Training/Document Update Failed'] = '' ;
        $_w['User Training/Document Update Successfully'] = '' ;
        $_w['Update'] = '' ;
        $_w['File'] = '' ;
        $_w['Short Desc'] = '' ;
        $_w['Image Recommended Size : {{size}}'] = '' ;
        $_w['Publish'] = '' ;
        $_w['Layer'] = '' ;
        $_w['User'] = '' ;
        $_w['Select'] = '' ;
        $_w['SAVE'] = '' ;
        $_w['Old User Training/Document Image'] = '' ;
        $_w['USER'] = '' ;
        $_w['mail'] = '' ;
        $_w['Products'] = '' ;
        $_w['User'] = '' ;
        $_w['Products'] = '' ;
        $_w['Due Date'] = '' ;
        $_w['Mandatory'] = '' ;
        $_w['Non Mandatory'] = '' ;
        $_w['Assign To'] = '' ;
        $_w['One User'] = '' ;
        $_w['All User'] = '' ;
        $_w['Category'] = '' ;
        $_w['Type'] = '' ;
        $_w['Description'] = '' ;
        $_w['Approved'] = '' ;
        $_w['Yes'] = '' ;
        $_w['No'] = '' ;
        $_w['Completed User Training/Document'] = '' ;
        $_w['Completion Date'] = '' ;
        $_w['Expiry Date'] = '' ;
        $_w['Training'] = '' ;
        $_w['Documents'] = '' ;
        $_w['Type'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin usertraining');

    }

   



    public function eventUsers() {
$sql  = "SELECT * FROM accounts_user WHERE  acc_type = '1' AND acc_id IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='employee')";
$data = $this->dbF->getRows($sql);
$opt  = '';
foreach ($data as $val){
    $mail=$val['acc_email'];
$heading    = $val['acc_name'];
$opt        .= '<option value="'.$val['acc_id'].'">'.htmlentities($heading).' -- '.$mail.'</option>';
}
return $opt;
}


    public function usertrainingView(){
        $sql  = "SELECT * FROM userdocuments WHERE file!='#' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->usertrainingPrint($data);
    }

    public function usertrainingDraft(){
        $sql  = "SELECT * FROM userdocuments WHERE file='#' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->usertrainingPrint($data);
    }

    public function titleName($id){
        $sql  = "SELECT title FROM documents WHERE id='$id'";
        $data =  $this->dbF->getRow($sql);
        return $data[0];
    }
      
    public function usertrainingPrint($data){
        global $_e;
        echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['User']) .'</th>
                        <th>'. _u($_e['Title']) .'</th>
                        <th>'. _u($_e['Category']) .'</th>
                        <th>'. _u($_e['Type']) .'</th>
                        <th>'. _u($_e['File']) .'</th>
                        <th>'. _u($_e['Completion Date']) .'</th>
                        <th>'. _u($_e['Expiry Date']) .'</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        foreach($data as $val){
            $i++;
            $id = $val['id'];
            $uid = $val['user'];
            $sql = "SELECT acc_name FROM `accounts_user` WHERE acc_id='$uid'";
            $uid = $this->dbF->getRow($sql);
            $uid = $uid['acc_name'];
            $c_date = $val['completion_date'];
            $e_date = $val['expiry_date'];
            $category = _uc($val['category']);
            $type     = _uc($val['type']);
            $download = '';
            if($val['file'] != '#'){
                $download = "<a href='$val[file]' download>Download</a>";
            }
            else{
                $download = "File not available";
            }
            echo "<tr>
                    <td>$i</td>
                    <td>$uid</td>
                    <td>".$this->titleName($val['title_id'])."</td>
                    <td>$category</td>
                    <td>$type</td>
                    <td>$download</td>
                    <td>$c_date</td>
                    <td>$e_date</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-id='$id' href='-usertraining?page=edit&eventId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>
                            <a data-id='$id' onclick='deleteusertraining(this);' class='btn'>
                                <i class='glyphicon glyphicon-trash trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>
                        </div>
                    </td>
                  </tr>";
        }

        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }
    public function event(){
        $sql = "SELECT * FROM documents ORDER BY title";
        $data = $this->dbF->getRows($sql);
        $opt  = '';
foreach ($data as $val){
$opt        .= '<option value="'.$val["id"].'">'.$val["title"].'</option>';
}
return $opt;
    }

     public function usertrainingNew(){
        global $_e;
        $this->usertrainingEdit(true);
    }

    public function usertrainingEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newusertraining',false);
            $date = date('Y-m-d');
        }else {
            $id = $_GET['eventId'];
            $sql = "SELECT * FROM userdocuments where id = '$id' ";
            $data = $this->dbF->getRow($sql);
            @$title_id  = $data['title_id'];
            @$desc      = $data['desc'];
            @$c_date    = $data['completion_date'];
            @$e_date    = $data['expiry_date'];
            @$file      = $data['file'];
            @$user      = $data['user'];

            $token = $this->functions->setFormToken('editusertraining', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
        }

        $size = $this->functions->developer_setting('file_size');
        //No need to remove any thing,, go in developer setting table and set 0

        echo '<form method="post" action="-usertraining?page=usertraining" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

        //Type    
        // $checked = "";
        // if(@$category=='training'){$checked='checked';}
        // echo '<div class="form-group">
        //             <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Category']) .'</label>
        //             <div class="col-sm-10  col-md-9">
        //                 <div style="width: 180px;" class="make-switch" id="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Training']) .'" data-off-label="'. _uc($_e['Documents']) .'">
        //                     <input type="checkbox" name="category" value="training" '.$checked.'>
        //                 </div>
        //             </div>
        //        </div>';

$option = $this->eventUsers();
// select user
        echo '<div class="form-group" id="users">
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['User']) .'</label>
<div class="col-sm-10  col-md-9">
<select class="users form-control" name="user">
'.$option.'
</select>
</div>
</div>
<script>$(".users").val("'.@$user.'").change();</script>';

        //Title
$option = $this->event();
// select category
        echo '<div class="form-group" >
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Title']) .'</label>
<div class="col-sm-10  col-md-9">
<select name="title_id" class="form-control event" required>
'.$option.'
</select>
</div>
</div>
<script>$(".event").val("'.@$title_id.'").change();</script>';
        
        //File
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['File']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <div class="input-group">
                                 <input type="text" value="'.@$file.'"  name="file" class="layer1 form-control" placeholder="">
                                 <div class="input-group-addon pointer " onclick="'."openKCFinderFile($('.layer1'))".'"><i class="glyphicon glyphicon-file"></i></div>
                             </div>
                        </div>
                    </div>';
        
        //Description
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Description']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <textarea name="desc" class="form-control" placeholder="'. _uc($_e['Description']) .'">'.@$desc.'</textarea>
                        </div>
                    </div>';

                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Completion Date']) .'</label>
                        <div class="col-sm-10  col-md-9">
                                 <input type="date"  name="c_date" class="form-control" value="'.@$c_date.'">
                        </div>
                    </div>';

                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Expiry Date']) .'</label>
                        <div class="col-sm-10  col-md-9">
                                 <input type="date"  name="e_date" class="form-control" value="'.@$e_date.'">
                        </div>
                    </div>';

        // Approved
        // $checked = "";
        // if(@$publish=='1'){$checked='checked';}
        // echo '<div class="form-group">
        //             <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Approved']) .'</label>
        //             <div class="col-sm-10  col-md-9">
        //                 <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Yes']) .'" data-off-label="'. _uc($_e['No']) .'">
        //                     <input type="checkbox" name="approved" value="1" '.$checked.'>
        //                 </div>
        //             </div>
        //        </div>';

        echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _uc($_e['SAVE']) .'</button>';

        echo "</div>
             </form>";
    }

 public function newusertrainingAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newusertraining')){return false;}

            $title_id = empty($_POST['title_id'])  ? ""    : $_POST['title_id'];
            $desc     = empty($_POST['desc'])      ? ""    : $_POST['desc'];
            $user     = empty($_POST['user'])      ? ""    : $_POST['user'];
            $c_date   = empty($_POST['c_date'])    ? ""    : $_POST['c_date'];
            $e_date   = empty($_POST['e_date'])    ? ""    : $_POST['e_date'];
            $file     = empty($_POST['file'])      ? "#"   : $_POST['file'];
            
            $sql = "SELECT `type`,`category` FROM `documents` WHERE `id`='$title_id'";
            $data = $this->dbF->getRow($sql);
            $type = $data['type'];
            $category = $data['category'];
            
            try{
                $this->db->beginTransaction();

                $sql      =   "INSERT INTO `userdocuments`(`user`,`title_id`,`category`,`type`,`file`,`completion_date`,`expiry_date`,`desc`) VALUES (?,?,?,?,?,?,?,?)";

                $array   = array($user,$title_id,$category,$type,$file,$c_date,$e_date,nl2br($desc));
                $this->dbF->setRow($sql,$array,false);
                $lastId = $this->dbF->rowLastId;


                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['User Training/Document']),($_e['User Training/Document Add Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Added']),_uc($_e['User Training/Document']),$lastId,($_e['User Training/Document Add Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['User Training/Document']),($_e['User Training/Document Add Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['User Training/Document']),($_e['User Training/Document Add Failed']),'btn-danger');
            }
        } // If end
    }
 
 public function userEmail($id){
    $sql = "SELECT acc_email FROM accounts_user WHERE acc_id='$id'";
    $data = $this->dbF->getRow($sql);
    return $data[0];
 }

 public function eventTitle($id){
    $sql = "SELECT title FROM documents WHERE id='$id'";
    $data = $this->dbF->getRow($sql);
    return $data[0];
 }

 public function usertrainingEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('editusertraining')){return false;}

            $title_id = empty($_POST['title_id'])  ? ""    : $_POST['title_id'];
            $desc     = empty($_POST['desc'])      ? ""    : $_POST['desc'];
            $user     = empty($_POST['user'])      ? ""    : $_POST['user'];
            $c_date   = empty($_POST['c_date'])    ? ""    : $_POST['c_date'];
            $e_date   = empty($_POST['e_date'])    ? ""    : $_POST['e_date'];
            $file     = empty($_POST['file'])      ? "#"   : $_POST['file'];
            
            $sql = "SELECT `type`,`category` FROM `documents` WHERE `id`='$title_id'";
            $data = $this->dbF->getRow($sql);
            $type = $data['type'];
            $category = $data['category'];

            try{
                $this->db->beginTransaction();
                $lastId   =   $_POST['editId'];

                $sql    =  "UPDATE `userdocuments` SET
                                    `user`=?,
                                    `title_id`=?,
                                    `category`=?,
                                    `type`=?,
                                    `file`=?,
                                    `completion_date`=?,
                                    `expiry_date`=?,
                                    `desc`=?
                                    WHERE id = '$lastId'
                                ";

                $array   = array($user,$title_id,$category,$type,$file,$c_date,$e_date,nl2br($desc));
                $this->dbF->setRow($sql,$array,false);


                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['User Training/Document']),($_e['User Training/Document Update Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Update']),_uc($_e['User Training/Document']),$lastId,($_e['User Training/Document Update Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['User Training/Document']),($_e['User Training/Document Update Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['User Training/Document']),($_e['User Training/Document Update Failed']),'btn-danger');
            }

        }
    }

}
?>
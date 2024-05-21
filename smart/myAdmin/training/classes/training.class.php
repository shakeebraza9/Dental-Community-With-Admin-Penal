<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class training extends object_class{
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
        $_w['Training/Document Management'] = '' ;
        //filesManagerEdit.php
        $_w['Manage Training/Document'] = '' ;

        //filesManager.php
        $_w['Active Training/Document'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Add New Training/Document'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;
        $_w['There is an error, Please Refresh Page and Try Again'] = '' ;
        $_w['SNO'] = '' ;
        $_w['Training/Document Title'] = '' ;
        $_w['IMAGE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Image Training/Document Error'] = '' ;
        $_w['Image Not Found'] = '' ;
        $_w['Training/Document'] = '' ;
        $_w['Added'] = '' ;
        $_w['Training/Document Add Successfully'] = '' ;
        $_w['Training/Document Add Failed'] = '' ;
        $_w['Training/Document Update Failed'] = '' ;
        $_w['Training/Document Update Successfully'] = '' ;
        $_w['Update'] = '' ;
        $_w['Title'] = '' ;
        $_w['File'] = '' ;
        $_w['Short Desc'] = '' ;
        $_w['Image Recommended Size : {{size}}'] = '' ;
        $_w['Publish'] = '' ;
        $_w['Layer'] = '' ;
        $_w['User'] = '' ;
        $_w['Select'] = '' ;
        $_w['SAVE'] = '' ;
        $_w['Old Training/Document Image'] = '' ;
        $_w['USER'] = '' ;
        $_w['mail'] = '' ;
        $_w['Products'] = '' ;
        $_w['User'] = '' ;
        $_w['Products'] = '' ;
        $_w['Due Date'] = '' ;
        $_w['Mandatory'] = '' ;
        $_w['Recommended'] = '' ;
        $_w['Assign To'] = '' ;
        $_w['One User'] = '' ;
        $_w['All User'] = '' ;
        $_w['Category'] = '' ;
        $_w['Type'] = '' ;
        $_w['Description'] = '' ;
        $_w['Approved'] = '' ;
        $_w['Yes'] = '' ;
        $_w['No'] = '' ;
        $_w['Approved Training/Document'] = '' ;
        $_w['Recurring Duration'] = '' ;
        $_w['Recurrence'] = '' ;
        $_w['Training'] = '' ;
        $_w['Documents'] = '' ;
        $_w['Training/Documents'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Training/Document');

    }

    public function trainingView(){
        $sql  = "SELECT * FROM documents WHERE publish='1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->trainingPrint($data);
    }

    public function trainingDraft(){
        $sql  = "SELECT * FROM documents WHERE publish='0' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->trainingPrint($data);
    }

    public function trainingPrint($data){
        global $_e;
        echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['Title']) .'</th>
                        <th>'. _u($_e['Assign To']) .'</th>
                        <th>'. _u($_e['Category']) .'</th>
                        <th>'. _u($_e['Type']) .'</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        foreach($data as $val){
            $i++;
            $id = $val['id'];
            $uid = $val['assignto'];
            if($uid != 'all'){
            $sql = "SELECT acc_name FROM `accounts_user` WHERE acc_id='$uid'";
            $uid = $this->dbF->getRow($sql);
            $uid = $uid['acc_name'];
            }
            echo "<tr>
                    <td>$id</td>
                    <td>$val[title]</td>
                    <td>$uid</td>
                    <td>$val[category]</td>
                    <td>$val[type]</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-id='$id' href='-training?page=edit&trainingId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>
                            <a data-id='$id' onclick='deletetraining(this);' class='btn'>
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

    public function newtrainingAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newTraining')){return false;}

            $title         = empty($_POST['title'])     ? ""    : $_POST['title'];
            $file          = empty($_POST['file'])      ? "#"   : $_POST['file'];
            $publish       = empty($_POST['publish'])   ? "0"   : $_POST['publish'];
            $assignto      = empty($_POST['assignto'])  ? "all"    : $_POST['assignto'];
            $category      = empty($_POST['category'])  ? "document"    : $_POST['category'];
            $type          = empty($_POST['type'])      ? "recommended"    : $_POST['type'];
            $desc          = empty($_POST['desc'])      ? ""    : $_POST['desc'];

htmlspecialchars($title);
htmlspecialchars($publish);
htmlspecialchars($assignto);
htmlspecialchars($category);
htmlspecialchars($type);
htmlspecialchars($desc);

            try{
                $this->db->beginTransaction();

                $sql      =   "INSERT INTO `documents`(
                                    `title`, `file`,`assignto`,`category`,`type`,`desc`,`publish`)
                                    VALUES (?,?,?,?,?,?,?)";

                $array   = array($title,$file,$assignto,$category,$type,nl2br($desc),$publish);

                $this->dbF->setRow($sql,$array,false);
                $lastId = $this->dbF->rowLastId;

                if($publish == '1'){
                if($assignto == 'all'){
                    $sql  = "SELECT acc_id FROM accounts_user WHERE  acc_type = '1'";
                    $data = $this->dbF->getRows($sql);
                    foreach ($data as $key => $value) {
                        $sql = "INSERT INTO `userdocuments`(`user`,`title_id`,`category`,`type`,`file`) VALUES('$value[acc_id]','$lastId','$category','$type','#')";
                        $this->dbF->setRow($sql);
                    }
                }
                else{
                    $sql = "INSERT INTO `userdocuments`(`user`,`title_id`,`category`,`type`,`file`) VALUES('$assignto','$lastId','$category','$type','#')";
                    $this->dbF->setRow($sql);
                }
                }
                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Training/Document']),($_e['Training/Document Add Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Added']),_uc($_e['Training/Document']),$lastId,($_e['Training/Document Add Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Training/Document']),($_e['Training/Document Add Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Training/Document']),($_e['Training/Document Add Failed']),'btn-danger');
            }
        } // If end
    }




    public function trainingEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('editTraining')){return false;}

        $title    = empty($_POST['title'])     ? ""                : $_POST['title'];
        $file     = empty($_POST['file'])      ? "#"               : $_POST['file'];
        $publish  = empty($_POST['publish'])   ? "0"               : $_POST['publish'];
        $assignto = empty($_POST['assignto'])  ? "all"             : $_POST['assignto'];
        $category = empty($_POST['category'])  ? "document"        : $_POST['category'];
        $type     = empty($_POST['type'])      ? "recommended"     : $_POST['type'];
        $desc     = empty($_POST['desc'])      ? ""                : $_POST['desc'];

htmlspecialchars($title);
htmlspecialchars($file);
htmlspecialchars($publish);
htmlspecialchars($assignto);
htmlspecialchars($category);
htmlspecialchars($type);
htmlspecialchars($desc);
            try{
                $this->db->beginTransaction();
                $lastId     =   intval($_POST['editId']);
                $lastUser   =   intval($_POST['editUser']);

                $sql    =  "UPDATE `documents` SET
                                    `title`=?,
                                    `file`=?,
                                    `type`=?,
                                    `publish`=?,
                                    `assignto`=?,
                                    `category`=?,
                                    `desc`=?
                                       WHERE id = '$lastId'
                                ";

                $array   = array($title,$file,$type,$publish,$assignto,$category,nl2br($desc));
                $this->dbF->setRow($sql,$array,false);

                if($publish == '1'){
                if($assignto == 'all'){
                    $sql  = "SELECT acc_id FROM accounts_user WHERE  acc_type = '1'";
                    $data = $this->dbF->getRows($sql);
                    foreach ($data as $key => $value) {
                        $sql = "INSERT INTO `userdocuments`(`user`,`title_id`,`category`,`type`,`file`) VALUES('$value[acc_id]','$lastId','$category','$type','#')";
                        $this->dbF->setRow($sql);
                    }
                }
                else{
                    $sql = "INSERT INTO `userdocuments`(`user`,`title_id`,`category`,`type`,`file`) VALUES('$assignto','$lastId','$category','$type','#')";
                    $this->dbF->setRow($sql);
                }
                }
                
                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Training/Document']),($_e['Training/Document Update Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Update']),_uc($_e['Training']),$lastId,($_e['Training/Document Update Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Training/Document']),($_e['Training/Document Update Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Training/Document']),($_e['Training/Document Update Failed']),'btn-danger');
            }

        }
    }

    public function trainingNew(){
        global $_e;
        $this->trainingEdit(true);
    }

public function eventUsers() {
$sql  = "SELECT * FROM accounts_user WHERE  acc_type = '1'";
$data = $this->dbF->getRows($sql);
$opt  = '';
foreach ($data as $val){
    $mail=$val['acc_email'];
$heading    = $val['acc_name'];
$opt        .= '<option value="'.$val['acc_id'].'">'.htmlentities($heading).' -- '.$mail.'</option>';
}
return $opt;
}


    public function trainingEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newTraining',false);
        }else {
            $id = $_GET['trainingId'];
            $sql = "SELECT * FROM `documents` where id = '$id' ";
            $data = $this->dbF->getRow($sql);

            $token = $this->functions->setFormToken('editTraining', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
            $token .= '<input type="hidden" name="editUser" value="'.$data['assignto'].'"/>';
        }

        $size = $this->functions->developer_setting('file_size');
        //No need to remove any thing,, go in developer setting table and set 0

        echo '<form method="post" action="-training?page=training" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

        @$title     = $data['title'];
        @$desc      = $data['desc'];
        @$publish   = $data['publish'];
        @$category  = $data['category'];
        @$file      = $data['file'];
        @$assignto  = $data['assignto'];
        @$type      = $data['type'];

        //Type    
        $checked = "";
        if(@$type=='training'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Category']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <div style="width: 180px;" class="make-switch" id="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Training']) .'" data-off-label="'. _uc($_e['Documents']) .'">
                            <input type="checkbox" name="category" value="training" '.$checked.'>
                        </div>
                    </div>
               </div>';

        //Title
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Title']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="text" name="title" value="'.@$title.'" class="form-control" placeholder="'. _uc($_e['Title']) .'" required>
                        </div>
                    </div>';

        //File
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['File']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <div class="input-group">
                                 <input type="text"  name="file" value="'.@$file.'" class="layer1 form-control" placeholder="">
                                 <div class="input-group-addon pointer " onclick="'."openKCFinderFile($('.layer1'))".'"><i class="glyphicon glyphicon-file"></i></div>
                             </div>
                        </div>
                    </div>';

         //Assign To
        $checked = '';
        $dspy = 'style="display:none"';
        if(@$assignto!='all' && @$assignto!=''){$checked='checked'; $dspy='style="display:block"';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Assign To']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <div style="width: 150px;" class="make-switch" id="make-switch0" data-off="danger" data-on="success" data-on-label="'. _uc($_e['One User']) .'" data-off-label="'. _uc($_e['All User']) .'">
                            <input type="checkbox" value="1" '.$checked.'>
                            <input type="hidden" class="checkboxHidden" value="1">
                        </div>
                    </div>
               </div>';

$option = $this->eventUsers();
// select user
        echo '<div class="form-group" '.$dspy.' id="users">
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['User']) .'</label>
<div class="col-sm-10  col-md-9">
<select class="users form-control">
'.$option.'
</select>
</div>
</div>
<script>$(".users").val("'.@$assignto.'").change();</script>';
            
        //Type    
        $checked = "";
        if(@$type=='mandatory'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Type']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <div style="width: 220px;" class="make-switch" id="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Mandatory']) .'" data-off-label="'. _uc($_e['Recommended']) .'">
                            <input type="checkbox" name="type" value="mandatory" '.$checked.'>
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

        //Publish
        $checked = "";
        if(@$publish=='1'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Publish']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Publish']) .'" data-off-label="'. _uc($_e['Draft']) .'">
                            <input type="checkbox" name="publish" value="1" '.$checked.'>
                        </div>
                    </div>
               </div>';

        echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _uc($_e['SAVE']) .'</button>';

        echo "</div>
             </form>";
    }

}
?>
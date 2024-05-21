<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class documents extends object_class{
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
        $_w['Documents Management'] = '' ;
        //filesManagerEdit.php
        $_w['Manage Documents'] = '' ;

        //filesManager.php
        $_w['Active Documents'] = '' ;
        $_w['Draft Documents'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Add New Document'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;
        $_w['There is an error, Please Refresh Page and Try Again'] = '' ;
        $_w['SNO'] = '' ;
        $_w['Documents Title'] = '' ;
        $_w['IMAGE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Image Documents Error'] = '' ;
        $_w['Image Not Found'] = '' ;
        $_w['Documents'] = '' ;
        $_w['Added'] = '' ;
        $_w['Documents Add Successfully'] = '' ;
        $_w['Documents Add Failed'] = '' ;
        $_w['Documents Update Failed'] = '' ;
        $_w['Documents Update Successfully'] = '' ;
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
        $_w['Old Documents Image'] = '' ;
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
        $_w['Approved Documents'] = '' ;
        $_w['Recurring Duration'] = '' ;
        $_w['Recurrence'] = '' ;
        $_w['Training'] = '' ;
        $_w['Documents'] = '' ;
        $_w['Sub Category'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Documents');

    }

    public function documentsView(){
        $sql  = "SELECT * FROM documents WHERE publish='1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->documentsPrint($data);
    }

    public function documentsDraft(){
        $sql  = "SELECT * FROM documents WHERE publish='0' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->documentsPrint($data);
    }

    public function documentsPrint($data){
        global $_e;
        echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['Title']) .'</th>
                        <th>'. _u($_e['Assign To']) .'</th>
                        <th>'. _u($_e['Category']) .'</th>
                        <th>'. _u($_e['Sub Category']) .'</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        foreach($data as $val){
            $i++;
            $id = $val['id'];
            $name = "";
            if(strpos($val['assignto'],'all:') !== false){
                $uid =  str_replace("all:","",$val['assignto']);
                $name = $this->functions->UserName($uid)." - Practice";
            }
            elseif($val['assignto'] == "all"){
                $name = "All";
            }
            else{
              //  $name = $this->functions->UserName($val['assignto']);
              $name = $this->functions->UserName($val['assignto'])." - Practice";
            }
            echo "<tr>
                    <td>$id</td>
                    <td>$val[title]</td>
                    <td>$name</td>
                    <td>$val[category]</td>
                    <td>$val[sub_dcategory]</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-id='$id' href='-documents?page=edit&documentsId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>
                            <a data-id='$id' onclick='deletedocuments(this);' class='btn'>
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

    public function newdocumentsAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newdocuments')){return false;}

            $title         = empty($_POST['title'])     ? ""    : $_POST['title'];
            $file          = empty($_POST['file'])      ? "#"   : $_POST['file'];
            $publish       = empty($_POST['publish'])   ? "0"   : $_POST['publish'];
            $assignto      = empty($_POST['assignto'])  ? "all" : $_POST['assignto'];
            $category      = empty($_POST['category'])  ? ""    : $_POST['category'];
            $sub_dcategory = empty($_POST['sub_dcategory'])  ? ""    : $_POST['sub_dcategory'];
            $expiry        = empty($_POST['expiry'])  ? ""     : $_POST['expiry'];
            
            htmlspecialchars($title);
            htmlspecialchars($publish);
            htmlspecialchars($assignto);
            htmlspecialchars($category);
            htmlspecialchars($sub_dcategory);
            htmlspecialchars($expiry);

            try{
                $this->db->beginTransaction();

                $sql  =  "INSERT INTO `documents`(
                                    `title`, `file`,`assignto`,`category`,`sub_dcategory`,`expiry`,`publish`)
                                    VALUES (?,?,?,?,?,?,?)";

                $array   = array($title,$file,$assignto,$category,$sub_dcategory,$expiry,$publish);

                $this->dbF->setRow($sql,$array,false);
                $lastId = $this->dbF->rowLastId;

                // if($publish == '1'){
                // if($assignto == 'all'){
                //     $sql  = "SELECT acc_id FROM accounts_user WHERE  acc_type = '1'";
                //     $data = $this->dbF->getRows($sql);
                //     foreach ($data as $key => $value) {
                //         $sql = "INSERT INTO `userdocuments`(`user`,`title_id`,`title`,`category`,`file`,`expiry_date`) VALUES('$value[acc_id]','$lastId','$title','$category','$file','$expiry')";
                //         $this->dbF->setRow($sql);
                //     }
                // }
                // else{
                //     $sql = "INSERT INTO `userdocuments`(`user`,`title_id`,`title`,`category`,`file`,`expiry_date`) VALUES('$assignto','$lastId','$title','$category','$file','$expiry')";
                //     $this->dbF->setRow($sql);
                // }
                // }
                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Documents']),($_e['Documents Add Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Added']),_uc($_e['Documents']),$lastId,($_e['Documents Add Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Documents']),($_e['Documents Add Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Documents']),($_e['Documents Add Failed']),'btn-danger');
            }
        } // If end
    }




    public function documentsEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('editDocuments')){return false;}

            $title    = empty($_POST['title'])     ? ""     : $_POST['title'];
            $file     = empty($_POST['file'])      ? "#"    : $_POST['file'];
            $publish  = empty($_POST['publish'])   ? "0"    : $_POST['publish'];
            $assignto = empty($_POST['assignto'])  ? "all"  : $_POST['assignto'];
            $category = empty($_POST['category'])  ? ""     : $_POST['category'];
           $sub_dcategory = empty($_POST['sub_dcategory'])  ? ""     : $_POST['sub_dcategory'];
            $expiry   = empty($_POST['expiry'])  ? ""       : $_POST['expiry'];

intval($publish);
htmlspecialchars($title);
htmlspecialchars($category);
htmlspecialchars($sub_dcategory);
htmlspecialchars($expiry);

            try{
                $this->db->beginTransaction();
                $lastId   =   intval($_POST['editId']);
                $lastUser   =  intval($_POST['editUser']);
                if ($_POST['assignto'] == '' ) {
                     $assignto =  $_POST['editUser'];
                }

                $sql    =  "UPDATE `documents` SET
                                    `title`=?,
                                    `file`=?,
                                    `publish`=?,
                                    `assignto`=?,
                                    `category`=?,
                                    `sub_dcategory`=?,
                                    `expiry`=?
                                       WHERE id = '$lastId'";

        $array  = array($title,$file,$publish,$assignto,$category,$sub_dcategory,$expiry);
        $this->dbF->setRow($sql,$array,false);

                // if($publish == '1'){
                // if($assignto == 'all'){
                //     $sql  = "SELECT acc_id FROM accounts_user WHERE  acc_type = '1'";
                //     $data = $this->dbF->getRows($sql);
                //     foreach ($data as $key => $value) {
                //         $sql = "UPDATE `userdocuments` SET `category`='$category',`title`='$title' WHERE `title_id`='$lastId'";
                //         $this->dbF->setRow($sql);
                //     }
                // }
                // else{
                //     $sql = "UPDATE `userdocuments` SET `category`='$category',`title`='$title' WHERE `user`='$assignto'";
                //     $this->dbF->setRow($sql);
                // }
                // }
                
                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Documents']),($_e['Documents Update Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Update']),_uc($_e['Training']),$lastId,($_e['Documents Update Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Documents']),($_e['Documents Update Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Documents']),($_e['Documents Update Failed']),'btn-danger');
            }

        }
    }

    public function documentsNew(){
        global $_e;
        $this->documentsEdit(true);
    }

public function eventUsers() {
$sql  = "SELECT * FROM accounts_user WHERE  acc_type = '1' ORDER BY `acc_name`";
$data = $this->dbF->getRows($sql);
$opt  = '';
foreach ($data as $val){
    $mail=$val['acc_email'];
$heading    = $val['acc_name'];
$opt        .= '<option value="'.$val['acc_id'].'">'.htmlentities($heading).' -- '.$mail.'</option>';
}
return $opt;
}

    public function documentsEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newdocuments',false);
        }else {
            $id = $_GET['documentsId'];
            $sql = "SELECT * FROM `documents` where id = ?  ";
            $data = $this->dbF->getRow($sql,array($id));

            $token = $this->functions->setFormToken('editDocuments', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
            $token .= '<input type="hidden" name="editUser" value="'.$data['assignto'].'"/>';
        }

        $size = $this->functions->developer_setting('file_size');
        //No need to remove any thing,, go in developer setting table and set 0

        echo '<form method="post" action="-documents?page=documents" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

        @$title     = $data['title'];
        @$publish   = $data['publish'];
        @$category  = $data['category'];
        @$sub_dcategory  = $data['sub_dcategory'];
        @$file      = $data['file'];
        @$assignto  = $data['assignto'];
        @$expiry    = $data['expiry'];

        //Type
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Category']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <select class="form-control category" name="category">
                            <option value="Training">Training</option>
                            <option value="Recruitment">Recruitment</option>
                            <option value="Minute Meeting">Minute Meeting</option>
                            <option value="Signed Policies">Signed Policies</option>
                            <option value="MHRA">MHRA Alerts</option>
                            <option value="Additional Document">Additional Document</option>
                            <option value="Toolkit">Toolkit</option>
                        </select>
                    </div>
               </div>
               <script>$(".category").val("'.@$category.'").change();</script>'; 
               //Type
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Sub Category']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <input type="text" name="sub_dcategory" value="'.@$sub_dcategory.'" class=" sub_dcategory form-control" placeholder="'. _uc($_e['Sub Category']) .'" >
                    </div>
               </div>
               <script>$(".sub_dcategory").val("'.@$sub_dcategory.'").change();</script>';

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

        //Expiry
        echo '<div class="form-group">
                <label class="col-sm-2 col-md-3  control-label">Expiry Date</label>
                <div class="col-sm-10  col-md-9">
                    <input name="expiry" class="date form-control" placeholder="Expiry Date" value="'.@$expiry.'">
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
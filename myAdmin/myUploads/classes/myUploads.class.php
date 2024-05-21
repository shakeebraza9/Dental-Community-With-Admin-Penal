<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class myUploads extends object_class{
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
        $_w['My Uploads'] = '' ;
        //filesManagerEdit.php
        $_w['Manage Files'] = '' ;

        //filesManager.php
        $_w['Active Files'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Sort Files'] = '' ;
        $_w['Add New File'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;
        $_w['There is an error, Please Refresh Page and Try Again'] = '' ;
        $_w['SNO'] = '' ;
        $_w['TITLE'] = '' ;
        $_w['IMAGE'] = '' ;
        $_w['ACTION'] = '' ;

        $_w['Image File Error'] = '' ;
        $_w['Image Not Found'] = '' ;
        $_w['Files'] = '' ;
        $_w['Added'] = '' ;
        $_w['File Add Successfully'] = '' ;
        $_w['File Add Failed'] = '' ;
        $_w['File Update Failed'] = '' ;
        $_w['File Update Successfully'] = '' ;
        $_w['Update'] = '' ;
        $_w['File Title'] = '' ;
        $_w['File Link'] = '' ;
        $_w['Short Desc'] = '' ;
        $_w['Image Recommended Size : {{size}}'] = '' ;
        $_w['Publish'] = '' ;
        $_w['Layer'] = '' ;
        $_w['Web User'] = '' ;
        $_w['Select'] = '' ;
        $_w['SAVE'] = '' ;
        $_w['Old File Image'] = '' ;
        $_w['USER'] = '' ;
        $_w['mail'] = '' ;
        $_w['Products'] = '' ;
        $_w['User'] = '' ;
        $_w['File'] = '' ;
        $_w['Assign To'] = '' ;
        $_w['One User'] = '' ;
        $_w['All User'] = '' ;
        $_w['Title'] = '' ;
        $_w['Category'] = '' ;
        $_w['Sub Category'] = '' ;
        $_w['File'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin FilesManager');

    }


    public function myUploadsSort(){
        echo '<div class="table-responsive sortDiv">
                <div class="container-fluid activeSort">';
        $sql ="SELECT file_heading,layer0,id FROM `filesmanager` WHERE publish = '1' ORDER BY sort ASC";
        $data = $this->dbF->getRows($sql);

        $defaultLang = $this->functions->AdminDefaultLanguage();
        foreach($data as $val){
            $id = $val['id'];
            @$layer0    =   unserialize($val['layer0']);
            @$image    =   $this->functions->addWebUrlInLink($layer0[$defaultLang]);
            @$title = unserialize($val['file_heading']);
            @$title = $title[$defaultLang];
            echo '  <div class="singleAlbum " id="album_'.$id.'">
                         <div class="col-sm-12 albumSortTop"> ::: </div>
                         <div class="albumImage"><img src="'.$image.'"  class="img-responsive"/></div>
                        <div class="clearfix"></div>
                        <div class="albumMange col-sm-12">
                            <div class="col-sm-12 btn-default" style="">'.$title.'</div>
                        </div>
                    </div>';
        }

        echo '</div>';
        echo '</div>';
    }


    public function myUploadsView(){
        $sql  = "SELECT * FROM myuploads WHERE publish='1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->myUploadsPrint($data);
    }

    public function myUploadsDraft(){
        $sql  = "SELECT * FROM myuploads WHERE publish='0' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->myUploadsPrint($data);
    }

    public function myUploadsPrint($data){
        global $_e;
        $class = 'tableIBMS';
        $heading = false;
        if($this->functions->developer_setting('file_heading')=='1'){
            $class=" dTable tableIBMS";
            $heading = true;
        }
       $uniq=uniqid('id');
        $href = 'myUploads/myUploads_ajax.php?page=active_MyUploads';
      

      echo  '
            <div class="table-responsive">
            <table class="table table-hover tableIBMS dTable_ajax  " data-href="'.$href.'" data-uniq="'.$uniq.'">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['TITLE']) .'</th>
                        <th>'. _u($_e['Category']) .'</th>
                          <th>Sub Category</th>
                        <th>'. _u($_e['File']) .'</th>
                        <th>'. _u($_e['User']) .'</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        $defaultLang = $this->functions->AdminDefaultLanguage();

        // foreach($data as $val){
        //     $i++;
        //     $id  = $val['id'];
        //     $uid = $val['user'];
        //     $download = '';
        //     if($val['file'] != '#'){
        //         $download = "<a href='$val[file]' download>Download</a>";
        //     }
        //     else{
        //         $download = "File not available";
        //     }
        //     $sql = "SELECT acc_name FROM `accounts_user` WHERE acc_id='$uid'";
        //     $uid = $this->dbF->getRow($sql);
        //     $uid = $uid['acc_name'];
        //     echo "<td>$i</td>
        //             <td>$val[title]</td>
        //             <td>$val[category]</td>
        //             <td>$download</td>
        //             <td>$uid</td>
        //             <td>
        //                 <div class='btn-group btn-group-sm'>
        //                     <!--<a data-id='$id' href='-myUploads?page=edit&fileId=$id' class='btn'>
        //                         <i class='glyphicon glyphicon-edit'></i>
        //                     </a>-->
        //                     <a data-id='$id' onclick='deletemyUploads(this);' class='btn'>
        //                         <i class='glyphicon glyphicon-trash trash'></i>
        //                         <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
        //                     </a>
        //                 </div>
        //             </td>
        //           </tr>";
        // }


        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }

    public function newmyUploadsAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newFileManager')){return false;}

            $file         = empty($_POST['file'])           ? ""    : $_POST['file'];
            $title        = empty($_POST['title'])          ? ""    : $_POST['title'];
            $publish      = empty($_POST['publish'])        ? "0"   : $_POST['publish'];
            $category     = empty($_POST['category'])       ? ""    : $_POST['category'];
            $sub_category = empty($_POST['sub_category'])   ? ""    : $_POST['sub_category'];
            $assignto     = empty($_POST['assignto'])       ? "all" : $_POST['assignto'];

            try{
                $this->db->beginTransaction();

                $sql      =   "INSERT INTO `filesmanager`(`title`, `file`, `category`,`sub_category`,`assignto`,`publish`)
                                    VALUES (?,?,?,?,?,?)";

                $array   = array($title,$file,$category,$sub_category,$assignto,$publish);
                $this->dbF->setRow($sql,$array,false);
                $lastId = $this->dbF->rowLastId;

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Files']),($_e['File Add Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Added']),_uc($_e['Files']),$lastId,($_e['File Add Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Files']),($_e['File Add Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Files']),($_e['File Add Failed']),'btn-danger');
            }
        } // If end
    }




    public function myUploadsEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('editFiles')){return false;}

            $file         = empty($_POST['file'])           ? ""    : $_POST['file'];
            $title        = empty($_POST['title'])          ? ""    : $_POST['title'];
            $publish      = empty($_POST['publish'])        ? "0"   : $_POST['publish'];
            $category     = empty($_POST['category'])       ? ""    : $_POST['category'];
            $sub_category = empty($_POST['sub_category'])   ? ""    : $_POST['sub_category'];
            $assignto     = empty($_POST['assignto'])       ? "all" : $_POST['assignto'];

            try{
                $this->db->beginTransaction();
                $lastId   =   $_POST['editId'];

                $sql    =  "UPDATE `filesmanager` SET
                                    `title`=?,
                                    `file`=?,
                                    `category`=?,
                                    `sub_category`=?,
                                    `assignto`=?,
                                    `publish`=?
                                       WHERE id = '$lastId'
                                ";

                $array   = array($title,$file,$category,$sub_category,$assignto,$publish);
                $this->dbF->setRow($sql,$array,false);

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Files']),($_e['File Update Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Update']),_uc($_e['Files']),$lastId,($_e['File Update Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Files']),($_e['File Update Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Files']),($_e['File Update Failed']),'btn-danger');
            }

        }
    }

    public function myUploadsNew(){
        global $_e;
        $this->myUploadsEdit(true);
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

public function eventCategory() {
$cats  = $this->functions->ibms_setting('eventcategory');
$cats  = explode(",",$cats);
foreach($cats as $cat) {
$temp .= "<option value='$cat'>$cat</option>";
}


// $sql  = "SELECT `setting_val` FROM accounts_user WHERE  acc_type = '1'";
// $data = $this->dbF->getRows($sql);
// $opt  = '';
// foreach ($data as $val){
//     $mail=$val['acc_email'];
// $heading    = $val['acc_name'];
// $opt        .= '<option value="'.$val['acc_id'].'">'.htmlentities($heading).' -- '.$mail.'</option>';
// }
return $temp;
}

    public function myUploadsEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newFileManager',false);
        }else {
            $id = $_GET['fileId'];
            $sql = "SELECT * FROM filesmanager where id = ?";
            $data = $this->dbF->getRow($sql,array($id));

            $token = $this->functions->setFormToken('editFiles', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
        }

        echo '<form method="post" action="-fileManager?page=fileManager" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

        @$title = $data['title'];
        @$file =  $data['file'];
        @$category = $data['category'];
        @$assignto = $data['assignto'];
        @$sub_category =$data['sub_category'];

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

        // Category
        echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Category']) .'</label>
<div class="col-sm-10  col-md-9">
<select class="category form-control" name="category">
<option value="Compliance Templates">Compliance Templates</option>
<option value="HR Management">HR Management</option>
<option value="Practice Management Resources">Practice Management Resources</option>
</select>
</div>
</div>
<script>$(".category").val("'.@$category.'").change();</script>';

// Sub Category
        echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Sub Category']) .'</label>
<div class="col-sm-10  col-md-9">
<select class="sub_category form-control" name="sub_category">
<option value="Spreadsheets">Spreadsheets</option>
<option value="Checklist">Checklist</option>
<option value="Practice Meeting templates">Practice Meeting templates</option>
<option value="Recruitment Documents">Recruitment Documents</option>
<option value="Interview Questions">Interview Questions</option>
<option value="Job Advert Template">Job Advert Template</option>
<option value="Contracts">Contracts</option>
<option value="Job Description">Job Description</option>
<option value="Staff Policies">Staff Policies</option>
<option value="Application Forms">Application Forms</option>
<option value="Supporting Documents for Application">Supporting Documents for Application</option>
<option value="CQC Registration Documents">CQC Registration Documents</option>
<option value="Staff Forms">Staff Forms</option>
<option value="Contracts">Contracts</option>
<option value="Recruitment Documents">Recruitment Documents</option>
<option value="Marketing Resources">Marketing Resources</option>'.$this->eventCategory().'
</select>
</div>
</div>
<script>$(".sub_category").val("'.@$sub_category.'").change();</script>';

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

        //Publish
        $checked = "";
        if(@$data['publish']=='1'){$checked='checked';}
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
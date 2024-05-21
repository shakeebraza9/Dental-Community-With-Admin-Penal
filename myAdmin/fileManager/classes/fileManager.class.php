<?php
require_once (__DIR__."/../../global.php"); //connection setting db
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
class filesManager extends object_class{
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
        $_w['Files Management'] = '' ;
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
        $_w['Sub Sub Category'] = '' ;
        $_w['Enter Full Detail'] = '' ;
        $_w['Detail'] = '' ;
        $_w['Text'] = '' ;
        $_w['Content'] = '' ;
        $_w['Extra File'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin FilesManager');

    }


    public function filesManagerSort(){
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


    public function filesManagerView(){
        $sql  = "SELECT * FROM filesmanager WHERE publish='1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->filesManagerPrint($data);
    }

    public function filesManagerDraft(){
        $sql  = "SELECT * FROM filesmanager WHERE publish='0' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->filesManagerPrint($data);
    }

    public function filesManagerPrint($data){
        global $_e;
        $class = 'tableIBMS';
        $heading = false;
        if($this->functions->developer_setting('file_heading')=='1'){
            $class=" dTable tableIBMS";
            $heading = true;
        }
        echo '<div class="table-responsive">
                <table class="table table-hover '.$class.'">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['TITLE']) .'</th>
                        <th>'. _u($_e['Category']) .'</th>
                        <th>'. _u($_e['Sub Category']) .'</th>
                        <th>'. _u($_e['Sub Sub Category']) .'</th>
                        <th>'. _u($_e['Assign To']) .'</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        $defaultLang = $this->functions->AdminDefaultLanguage();

        foreach($data as $val){
            $i++;
            $id = $val['id'];
            $uid = $val['assignto'];
            if($uid != 'all'){
            $sql = "SELECT acc_name FROM `accounts_user` WHERE acc_id='$uid'";
            $uid = $this->dbF->getRow($sql);
            $uid = $uid['acc_name'];
            }
            echo "<td>$i</td>
                    <td>$val[title]</td>
                    <td>$val[category]</td>
                    <td>$val[sub_category]</td>
                    <td>$val[sub_sub_category]</td>
                    <td>$uid</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-id='$id' href='-fileManager?page=edit&fileId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>
                            <a data-id='$id' onclick='deleteFileManager(this);' class='btn'>
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

    public function newFilesManagerAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newFileManager')){return false;}

            $file         = empty($_POST['file'])           ? ""    : $_POST['file']; 
            $ytcode = empty($_POST['ytcode']) ? ""    : $_POST['ytcode'];
            $extra_file = empty($_POST['extra_file']) ? ""    : $_POST['extra_file'];
            $psp = empty($_POST['psp']) ? ""    : $_POST['psp'];
            $title        = empty($_POST['title'])          ? ""    : $_POST['title'];
            $publish      = empty($_POST['publish'])        ? "0"   : $_POST['publish'];
            $category     = empty($_POST['category'])       ? ""    : $_POST['category'];
            $sub_category = empty($_POST['sub_category'])   ? ""    : $_POST['sub_category']; 
            $sub_sub_category = empty($_POST['sub_sub_category'])   ? ""    : $_POST['sub_sub_category'];
            $assignto     = empty($_POST['assignto'])       ? "all" : $_POST['assignto'];
               
               
       
            try{
        
         $search = array(',', '.', ' ', '\"', '\'','&','$','`');
         
         
        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','DOCX','docx','DOC','doc','xlsx','xlsm','xlsb','xltx');        
        $ext1 = pathinfo($file, PATHINFO_EXTENSION);     
         if(!in_array($ext1, $allowed)){
        $path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/files/resources/smartDoc".str_replace($search,'', $title).".el";
        $savepath = WEB_URL . "/uploads/files/resources/smartDoc".str_replace($search,'', $title).".el";
               $content = $_POST['file'];
              $fp = fopen($path,"w+");
             fwrite($fp,$content);
                 $file   =  $savepath;
             fclose($fp);
              } 
              else
              {
                 $file   = $_POST['file'];
              }



                $this->db->beginTransaction();

                $sql = "INSERT INTO `filesmanager`(`title`, `file`, `extra_file`, `ytcode`, `psp`, `category`,`sub_category`,`sub_sub_category`,`assignto`,`publish`)
                                    VALUES (?,?,?,?,?,?,?,?,?,?)";

            $array = array($title,$file,$extra_file,$ytcode,$psp,$category,$sub_category,$sub_sub_category,$assignto,$publish);
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




    public function filesManagerEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('editFiles')){return false;}

            $file         = empty($_POST['file'])           ? ""    : $_POST['file'];
            $files         = empty($_POST['files'])           ? ""    : $_POST['files'];
        $ytcode = empty($_POST['ytcode']) ? ""    : $_POST['ytcode'];
            $extra_file = empty($_POST['extra_file']) ? ""    : $_POST['extra_file'];
            $psp = empty($_POST['psp']) ? ""    : $_POST['psp'];
            $title        = empty($_POST['title'])          ? ""    : $_POST['title'];
            $publish      = empty($_POST['publish'])        ? "0"   : $_POST['publish'];
            $category     = empty($_POST['category'])       ? ""    : $_POST['category'];
            $sub_category = empty($_POST['sub_category'])   ? ""    : $_POST['sub_category']; 
             $sub_sub_category = empty($_POST['sub_sub_category'])   ? ""    : $_POST['sub_sub_category'];
            $assignto     = empty($_POST['assignto'])       ? "all" : $_POST['assignto'];
         
            if(isset($files) && !empty($files)){
                $file=$files;
            }
          
            try{

        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','DOCX','docx','DOC','doc');        
        $ext1 = pathinfo($file, PATHINFO_EXTENSION);     
         if(!in_array($ext1, $allowed)){
        $path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/files/resources/smartDoc".str_replace(' ', '', str_replace('.', '', $title)).".el";
        $savepath = WEB_URL . "/uploads/files/resources/smartDoc".str_replace(' ', '', str_replace('.', '', $title)).".el";
               if(isset($files) && !empty($files)){
               $content = $_POST['files'];
           }else{$content = $_POST['file'];}
              $fp = fopen($path,"w+");
             fwrite($fp,$content);
                 $file   =  $savepath;
             fclose($fp);echo "3";
              } 
              elseif(isset($files) && !empty($files)){echo "1";
                $file=$files;
            }else{
                echo "2";
                 $file   = $_POST['file'];
              }

                $this->db->beginTransaction();
                $lastId   =    intval($_POST['editId']);

                $sql    =  "UPDATE `filesmanager` SET
                                    `title`=?,
                                    `file`=?,
                                    `extra_file`=?,
                                    `ytcode`=?, 
                                    `psp`=?,
                                    `category`=?,
                                    `sub_category`=?,
                                    `sub_sub_category`=?,
                                    `assignto`=?,
                                    `publish`=?
                                       WHERE id = '$lastId'
                                ";

                $array   = array($title,$file,$extra_file,$ytcode,$psp,$category,$sub_category,$sub_sub_category,$assignto,$publish);
                // var_dump($array);
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
    public function filesManagerNew(){
        global $_e;
        $this->filesManagerEdit(true);
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

public function eventCategory() {
$temp = "";
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

    public function filesManagerEdit($new=false){
        global $_e;
         $checked = ""; 
         $dspy0='';
         $dspy1 = '';
        if($new){
            $token       = $this->functions->setFormToken('newFileManager',false);
        }else {
            $id = $_GET['fileId'];
            $sql = "SELECT * FROM filesmanager where id = '$id' ";
            $data = $this->dbF->getRow($sql);

            $token = $this->functions->setFormToken('editFiles', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
  @$file =  $data['file'];
  @$title = $data['title'];
  @$ytcode = $data['ytcode'];
//======================================================
    $ext1 = pathinfo(@$file, PATHINFO_EXTENSION);
    
/// $_SERVER["DOCUMENT_ROOT"].'/'.str_replace("https://smartdentalcompliance.com/","",$file);

 if($ext1 == 'el'  ){


 $handle = fopen($_SERVER["DOCUMENT_ROOT"].'/'.str_replace("https://smartdentalcompliance.com/","",$file), 'r+'); 
$contents = stream_get_contents($handle);
fclose($handle);

     
    $dspy1 = 'style="display:none"'; 
    $checked='checked';
    echo '<script>$(".ly0 .layer0").attr("name","file"); </script> ';
    $dspy0='style="display:block"';
       echo '<script>$(".layer1").removeAttr("name");</script>';
       echo '<script>$(".ly0").removeClass("ly0block");</script>';
      }
    else
      {
        $dspy0='style="display:none"';
        $dspy1 ='style="display:block"';
         
        $ext1 = pathinfo(@$file, PATHINFO_EXTENSION);

       }

        }

        echo '<form method="post" action="-fileManager?page=fileManager" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';


 
        
        @$extra_file =  $data['extra_file'];
        @$category = $data['category'];
        @$assignto = $data['assignto'];
        @$sub_category =$data['sub_category'];
        @$sub_sub_category =$data['sub_sub_category'];
        @$psp =$data['psp'];

//Assign To
//Assign To
//Assign To

      
        //Title
                echo '<div class="form-group ">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Title']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="text" name="title" value="'.@$title.'" class="form-control" placeholder="'. _uc($_e['Title']) .'" required>
                        </div>
                    </div>';



        //Video
                echo '<div class="form-group ">
                        <label class="col-sm-2 col-md-3  control-label">Youtube embed code</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="text" name="ytcode" value="'.@$ytcode.'" class="form-control" placeholder="EX: uYZTsHAPrgI">
                        </div>
                    </div>';




         // ==============================================================

              echo '<div class="form-group" class="make-switch1">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Content']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <div style="width: 150px;" class="make-switch" id="make-switch1" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Text']) .'" data-off-label="'. _uc($_e['File']) .'">
                            <input type="checkbox" value="1" '.$checked.'>
                            <input type="hidden" class="checkboxHidden1" value="">
                        </div>
                    </div>
               </div>';
         
         //File 0 
        echo '<style> .ly0block{display:none;} </style>';      
        echo '<div class="form-group files ly0 ly0block" '. $dspy0.' >
            <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Detail']) .'</label>
                              <div class="col-sm-10  col-md-9">
               <textarea name="files" class="form-control ckeditor layer0" placeholder="General Instructions">' . @$contents . '</textarea>
                                 </div>

<br>


<label class="col-sm-2 col-md-3  control-label">Practices Specific Protocol</label>
<div class="col-sm-10  col-md-9">
<textarea name="psp" class="form-control ckeditor" placeholder="">' . @$psp . '</textarea>
</div>
                             


                             </div>';

         // ==============================================================
        //File 1

                echo '<div class="form-group file ly1" '.$dspy1.' >
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['File']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <div class="input-group">
            <input type="text" name="file"  value="'.@$file.'" class="layer1  form-control" placeholder="">
                                 <div class="input-group-addon pointer " onclick="'."openKCFinderFile($('.layer1'))".'"><i class="glyphicon glyphicon-file"></i></div>

                                  
                             </div>
                        </div>
                    </div>';

        //File
         if(!$new){            
            $ext = pathinfo(@$file, PATHINFO_EXTENSION);
            if($ext == 'docx' || $ext == 'doc' || $ext == 'xlsx' || $ext == 'xls'){
                echo '<div class="form-group"  style="display:none;">
                    <label class="col-sm-2 col-md-3  control-label"></label>
                    <div class="col-sm-10  col-md-9">
                        <div class="input-group">
                             <button type="button" class="APIedit btn btn-info btn-sm" id="'.@$file.'"><i class="glyphicon glyphicon-edit"></i> Edit File</button>
                         </div>
                    </div>
                </div>';
            }
        }
         // ==============================================================

        //File 1

                echo '<div class="form-group file ly3 ly0block" '.$dspy0.' >
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Extra File']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <div class="input-group">
            <input type="text" name="extra_file"  value="'.@$extra_file.'" class="layer3 form-control" placeholder="">
                                 <div class="input-group-addon pointer " onclick="'."openKCFinderFile($('.layer3'))".'"><i class="glyphicon glyphicon-file"></i></div>
                             </div>
                        </div>
                    </div>';

        //File
         if(!$new){            
            $ext = pathinfo(@$extra_file, PATHINFO_EXTENSION);
            if($ext == 'el'){
                echo '<style> .ly0block{display:none;} </style>';
                echo '<div class="form-group"  style="display:none;" >
                    <label class="col-sm-2 col-md-3  control-label"></label>
                    <div class="col-sm-10  col-md-9">
                        <div class="input-group">
                             <button type="button" class="APIedit btn btn-info btn-sm" id="'.@$extra_file.'"><i class="glyphicon glyphicon-edit"></i> Edit File</button>
                         </div>
                    </div>
                </div>';
            }
        }



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
'.$this->eventCategory().'
</select>
</div>
</div>
<script>$(".sub_category").val("'.@$sub_category.'").change();</script>';

//sub sub-category
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Sub Sub Category']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="text" name="sub_sub_category" value="'.@$sub_sub_category.'" class="form-control" placeholder="'. _uc($_e['Sub Sub Category']) .'" >
                        </div>
                    </div>';
         //Assign To
        $checked = '';
        $dspy = 'style="display:none"';
        if(@$assignto!='all' && @$assignto!=''){$checked='checked'; $dspy='style="display:block"';}
        echo '<div class="form-group" >
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
<select class="users form-control" name="assignto">
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
<?php
require_once (__DIR__."/../../global.php"); //connection setting db
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
                $_w['Products'] = '' ;

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
        $sql  = "SELECT id, file_heading,layer0 FROM filesmanager WHERE publish='1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->filesManagerPrint($data);
    }

    public function filesManagerDraft(){
        $sql  = "SELECT id, file_heading,layer0 FROM filesmanager WHERE publish='0' ORDER BY ID DESC";
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
                        <th>'. _u($_e['SNO']) .'</th>';
        if($heading){
            echo        '<th>'. _u($_e['TITLE']) .'</th>';
        }
        echo            '<th>'. _u($_e['USER']) .'</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        $defaultLang = $this->functions->AdminDefaultLanguage();

        foreach($data as $val){
            $i++;
            $id = $val['id'];
             $layer0 = unserialize($val['layer0']);

        $sql  = "SELECT * FROM accounts_user WHERE  acc_type = '1' AND acc_id='$layer0'";
        $data = $this->dbF->getRow($sql);
        $opt  = '';
            echo "<tr>
                    <td>$i</td>";
            if($heading){
                @$file_heading = unserialize($val['file_heading']);
                @$file_heading = $file_heading[$defaultLang];
                echo "<td>$file_heading</td>";
            }

            @$layer0    =   unserialize($val['layer0']);
            @$layer0    =   $this->functions->addWebUrlInLink($layer0[$defaultLang]);

            echo "
                    <td>".$data['acc_name']." -- ".$data['acc_email']."</td>
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

            $heading        = empty($_POST['file_heading'])   ? ""    : serialize($_POST['file_heading']);
            $link           = empty($_POST['file_link'])      ? ""    : $_POST['file_link'];
            $short_desc     = empty($_POST['file_shrtDesc'])  ? ""    : serialize($_POST['file_shrtDesc']);
            $publish        = empty($_POST['publish'])          ? "0"   : $_POST['publish'];
            $layer0         = empty($_POST['layer0'])          ? ""    : ($_POST['layer0']);
            $layer1         = empty($_POST['layer1'])          ? ""    : ($_POST['layer1']);
            $layer2         = empty($_POST['layer2'])          ? ""    : ($_POST['layer2']);
            $layer3         = empty($_POST['layer3'])          ? ""    : ($_POST['layer3']);

            $layer0         = serialize($this->functions->removeWebUrlFromLink($layer0));
            $layer1         = serialize($this->functions->removeWebUrlFromLink($layer1));
            $layer2         = ($this->functions->removeWebUrlFromLink($layer2));
            $layer3         = serialize($this->functions->removeWebUrlFromLink($layer3));

            try{
                $this->db->beginTransaction();

                $sql      =   "INSERT INTO `filesmanager`(
                                    `file_link`, `file_heading`, `file_shrtDesc`,`layer0`,`layer1`,`layer2`,`layer3`,`publish`)
                                    VALUES (?,?,?,?,?,?,?,?)";

                $array   = array($link,$heading,$short_desc,$layer0,$layer1,$layer2,$layer3,$publish);
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

            $heading        = empty($_POST['file_heading'])   ? ""    : serialize($_POST['file_heading']);
            $link           = empty($_POST['file_link'])      ? ""    : $_POST['file_link'];
            $short_desc     = empty($_POST['file_shrtDesc'])  ? ""    : serialize($_POST['file_shrtDesc']);
            $publish        = empty($_POST['publish'])          ? "0"   : $_POST['publish'];
            $layer0         = empty($_POST['layer0'])          ? ""    : ($_POST['layer0']);
            $layer1         = empty($_POST['layer1'])          ? ""    : ($_POST['layer1']);
            $layer2         = empty($_POST['layer2'])          ? ""    : ($_POST['layer2']);
            $layer3         = empty($_POST['layer3'])          ? ""    : ($_POST['layer3']);

            $layer0         = serialize($this->functions->removeWebUrlFromLink($layer0));
            $layer1         = serialize($this->functions->removeWebUrlFromLink($layer1));
            $layer2         = ($this->functions->removeWebUrlFromLink($layer2));
            $layer3         = serialize($this->functions->removeWebUrlFromLink($layer3));

            try{
                $this->db->beginTransaction();
                $lastId   =   $_POST['editId'];

                $sql    =  "UPDATE `filesmanager` SET
                                    `file_link`=?,
                                    `file_heading`=?,
                                    `file_shrtDesc`=?,
                                    `layer0`=?,
                                    `layer1`=?,
                                    `layer2`=?,
                                    `layer3`=?,
                                    `publish`=?
                                       WHERE id = '$lastId'
                                ";

                $array   = array($link, $heading, $short_desc,
                                    $layer0,$layer1,$layer2,$layer3,
                                $publish);
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


    public function underMenuOption($type)
    {
// $type = '';
// if(isset($_GET['fileId'])) {
// $type = $_GET['fileId'];
// }

$sql  = "SELECT * FROM accounts_user WHERE  acc_type = '1'";
$data = $this->dbF->getRows($sql);
$opt  = '';
// $defaultLang = $this->functions->AdminDefaultLanguage();

foreach ($data as $val){
    $select='';
    if ($val['acc_id']==$type) {
        $select = "selected";
    }
    $mail=$val['acc_email'];
// $menu2       = $this->underMenu2Option($val['id'],$defaultLang);
$heading    = $val['acc_name'];
// @$heading    = $heading[$defaultLang];
$opt        .= '<option  '.$select.' value="'.$val['acc_id'].'">'.htmlentities($heading).' -- '.$mail.'</option>';
// if($menu2   !=  false){
// $opt    .= $menu2;
// } else{
// continue;
// }
}
return $opt;
}





    public function underProductMenuOption($type){
// $type = '';
// if(isset($_GET['fileId'])) {
// $type = $_GET['fileId'];
// }

$sql  = "SELECT id,heading FROM Products WHERE  publish='1'";
$data = $this->dbF->getRows($sql);
$opt  = '';
// $defaultLang = $this->functions->AdminDefaultLanguage();

foreach ($data as $val){
    $select='';
    if ($val['id']==$type) {
        $select = "selected";
    }
    // $mail=$val['acc_email'];
// $menu2       = $this->underMenu2Option($val['id'],$defaultLang);
$heading    = $val['heading'];
// @$heading    = $heading[$defaultLang];
$opt        .= '<option  '.$select.' value="'.$val['id'].'"> '.getTextFromSerializeArray($heading).' </option>';
// if($menu2   !=  false){
// $opt    .= $menu2;
// } else{
// continue;
// }
}
return $opt;
}


    public function filesManagerEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newFileManager',false);
        }else {
            $id = $_GET['fileId'];
            $sql = "SELECT * FROM filesmanager where id = '$id' ";
            $data = $this->dbF->getRow($sql);

            $token = $this->functions->setFormToken('editFiles', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
        }

        $size = $this->functions->developer_setting('file_size');
        //No need to remove any thing,, go in developer setting table and set 0

        echo '<form method="post" action="-fileManager?page=fileManager" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

        $lang = $this->functions->IbmsLanguages();
        if($lang != false){
            $lang_nonArray = implode(',', $lang);
        }

        echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';

        echo '<div class="panel-group" id="accordion">';


        @$file_heading = unserialize($data['file_heading']);
        @$file_shrtDesc =  unserialize($data['file_shrtDesc']);
        @$layer0 = unserialize($data['layer0']);
        @$layer1 = unserialize($data['layer1']);
        @$layer2 =($data['layer2']);
        @$layer3 = unserialize($data['layer3']);

        $developer_File_heading = $this->functions->developer_setting('file_heading');
        $developer_shrtDesc     = $this->functions->developer_setting('file_shrtDesc');
        $developer_shrtDescEditor = $this->functions->developer_setting('file_shrtDescEditor');
        $developer_layer0     = $this->functions->developer_setting('file_layer0');
        $developer_layer1      = $this->functions->developer_setting('file_layer1');
        $developer_layer2      = $this->functions->developer_setting('file_layer2');
        $developer_layer3      = $this->functions->developer_setting('file_layer3');

        for ($i = 0; $i < sizeof($lang); $i++) {
            if ($i == 0) {
                $collapseIn = ' in ';
            } else {
                $collapseIn = '';
            }

            echo '<div class="panel panel-default">
                          <div class="panel-heading">
                                 <a data-toggle="collapse" data-parent="#accordion" href="#'.$lang[$i].'">
                                    <h4 class="panel-title">
                                        '.$lang[$i].'
                                    </h4>
                                 </a>
                          </div>
                          <div id="'.$lang[$i].'" class="panel-collapse collapse '.$collapseIn.'">
                             <div class="panel-body">';

            //Title
            if($developer_File_heading=='1'){
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['TITLE']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="text" name="file_heading['.$lang[$i].']" value="'.@$file_heading[$lang[$i]].'" class="form-control" placeholder="'. _uc($_e['File Title']) .'">
                        </div>
                    </div>';
            }else{ echo '<input type="hidden" name="file_heading['.$lang[$i].']" value="" class="form-control">';}

            //Short Desc
            if($developer_shrtDesc=='1'){
                $classEditor = '';
                if($developer_shrtDescEditor=='1'){
                    $classEditor = 'ckeditor';
                }
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Short Desc']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <textarea name="file_shrtDesc['.$lang[$i].']" id="file_shrtDesc" maxlength="500" class="'.$classEditor.' form-control" placeholder="'. _uc($_e['Short Desc']) .'">'.@$file_shrtDesc[$lang[$i]].'</textarea>
                        </div>
                    </div>';
            }else{ echo '<input type="hidden" name="file_shrtDesc['.$lang[$i].']" value="" class="form-control">';}


            //file_layer0
            if($developer_layer0=='1'){
                $image0 = empty($layer0[$lang[$i]]) ? "" : $this->functions->addWebUrlInLink(@$layer0[$lang[$i]]);
                echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label"></label>
                    <div class="col-sm-10  col-md-9 ">
                        <img src="'.$image0.'" class="layer0 kcFinderImage"/>
                    </div>
                </div>';

                // echo '<div class="form-group">
                //         <label class="col-sm-2 col-md-3  control-label">'. _replace('{{size}}',$size,$_e['Image Recommended Size : {{size}}']) .'</label>
                //         <div class="col-sm-10  col-md-9">
                //             <div class="input-group">
                //                 <input type="url"  name="layer0['.$lang[$i].']" value="'.$image0.'" class="layer0 form-control" placeholder="">
                //                 <div class="input-group-addon pointer " onclick="'."openKCFinderImageWithImg('layer0')".'"><i class="glyphicon glyphicon-picture"></i></div>
                //             </div>
                //         </div>
                //     </div>';
            }else{ echo '<input type="hidden" name="layer0['.$lang[$i].']" value="" class="form-control">';}

            //file_layer1
            $lay1_Status = intval($developer_layer1);
            if($lay1_Status>0){
                $image1 = empty($layer1[$lang[$i]]) ? "" : $this->functions->addWebUrlInLink(@$layer1[$lang[$i]]);
                if($lay1_Status==3) {

                    $lay1_Status = '<div class="input-group">
                                <input type="text"  name="layer1['.$lang[$i].']" value="'.$image1.'" class="layer1 form-control" placeholder="">
                                <div class="input-group-addon pointer " onclick="'."openKCFinderFile($('.layer1'))".'"><i class="glyphicon glyphicon-file"></i></div>
                            </div>';
                }
                else if($lay1_Status==2) {
                    echo '<div class="form-group">
                            <label class="col-sm-2 col-md-3  control-label"></label>
                            <div class="col-sm-10  col-md-9 ">
                                <img src="' .$image1 . '" class="layer1 kcFinderImage"/>
                            </div>
                    </div>';
                    $lay1_Status = '<div class="input-group">
                                <input type="text"  name="layer1['.$lang[$i].']" value="'.$image1.'" class="layer1 form-control" placeholder="">
                                <div class="input-group-addon pointer " onclick="'."openKCFinderImageWithImg('layer1')".'"><i class="glyphicon glyphicon-picture"></i></div>
                            </div>';
                }else{
                    $lay1_Status = '
                        <input type="text"  name="layer1['.$lang[$i].']" value="'.@$image1.'" class="layer1 form-control" placeholder="">';
                }

                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['File Link']) .' </label>
                        <div class="col-sm-10  col-md-9">
                            '.$lay1_Status.'
                        </div>
                    </div>';
            }else{ echo '<input type="hidden" name="layer1['.$lang[$i].']" value="" class="form-control">';}

            //file_layer2
            $lay2_Status = intval($developer_layer2);
            if($lay2_Status>0){
                $image2 = empty($layer2[$lang[$i]]) ? "" : $this->functions->addWebUrlInLink(@$layer2[$lang[$i]]);
                if($lay2_Status==3) {
                    $lay2_Status = '<div class="input-group">
                                <input type="text"  name="layer2['.$lang[$i].']" value="'.$image2.'" class="layer2 form-control" placeholder="">
                                <div class="input-group-addon pointer " onclick="'."openKCFinderFile($('.layer2'))".'"><i class="glyphicon glyphicon-file"></i></div>
                            </div>';
                }else if($lay2_Status==2) {
                    echo '<div class="form-group">
                            <label class="col-sm-2 col-md-3  control-label"></label>
                            <div class="col-sm-10  col-md-9 ">
                                <img src="' .$image2. '" class="layer2 kcFinderImage"/>
                            </div>
                    </div>';
                    $lay2_Status = '<div class="input-group">
                                <input type="text"  name="layer2['.$lang[$i].']" value="'.$image2.'" class="layer2 form-control" placeholder="">
                                <div class="input-group-addon pointer " onclick="'."openKCFinderImageWithImg('layer2')".'"><i class="glyphicon glyphicon-picture"></i></div>
                            </div>';
                }else{
                    $lay2_Status = '
                        <input type="text"  name="layer2['.$lang[$i].']" value="'.@$image2.'" class="layer2 form-control" placeholder="">';
                }

                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Layer']) .' 2</label>
                        <div class="col-sm-10  col-md-9">
                            '.$lay2_Status.'
                        </div>
                    </div>';
            }else{ echo '<input type="hidden" name="layer2['.$lang[$i].']" value="" class="form-control">';}

            //file_layer3
            $lay3_Status = intval($developer_layer3);
            if($lay3_Status>0){
                $image3 = empty($layer3[$lang[$i]]) ? "" : $this->functions->addWebUrlInLink(@$layer3[$lang[$i]]);
                if($lay3_Status==3) {

                    $lay3_Status = '<div class="input-group">
                                <input type="text"  name="layer3['.$lang[$i].']" value="'.$image3.'" class="layer3 form-control" placeholder="">
                                <div class="input-group-addon pointer " onclick="'."openKCFinderFile($('.layer3'))".'"><i class="glyphicon glyphicon-file"></i></div>
                            </div>';
                }else if($lay3_Status==2) {
                    echo '<div class="form-group">
                            <label class="col-sm-2 col-md-3  control-label"></label>
                            <div class="col-sm-10  col-md-9 ">
                                <img src="' .$image3. '" class="layer3 kcFinderImage"/>
                            </div>
                    </div>';
                    $lay3_Status = '<div class="input-group">
                                <input type="text"  name="layer3['.$lang[$i].']" value="'.$image3.'" class="layer3 form-control" placeholder="">
                                <div class="input-group-addon pointer " onclick="'."openKCFinderImageWithImg('layer3')".'"><i class="glyphicon glyphicon-picture"></i></div>
                            </div>';
                }else{
                    $lay3_Status = '
                        <input type="text"  name="layer3['.$lang[$i].']" value="'.$image3.'" class="layer3 form-control" placeholder="">';
                }

                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Layer']) .' 3</label>
                        <div class="col-sm-10  col-md-9">
                            '.$lay3_Status.'
                        </div>
                    </div>';
            }else{ echo '<input type="hidden" name="layer3['.$lang[$i].']" value="" class="form-control">';}

            echo '           </div> <!-- panel-body end -->
                          </div> <!-- collapse end-->
                    </div><!-- panel end-->';
        }

        echo '</div> <!-- .accordian end -->';


         //product/web
        // $checked = "";
        // if(@$data['publish']=='1'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['User']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" id="make-switch00" data-off="danger" data-on="success" data-on-label="'. _uc($_e['User']) .'" data-off-label="'. _uc($_e['Products']) .'">
                            <input type="checkbox" id="users" name="User" value="1">
                            <input type="hidden" class="checkboxHidden" id="type" value="1">
                        </div>
                    </div>
               </div>';



        //Link
        // if($this->functions->developer_setting('file_link')=='1'){
        //     echo '<div id="uzairn" class="form-group" >
        //             <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['File Link']) .'</label>
        //             <div class="col-sm-10  col-md-9">
        //                 <input type="url" name="file_link" value="'.@$data['file_link'].'" class="form-control" placeholder="'. _uc($_e['File Link']) .'">
        //             </div>
        //         </div>';
        // }else{ echo '<input type="hidden" name="file_link" value="" class="form-control">';}


        $option = $this->underMenuOption($type='');
        // ($layer0);
// select user
        echo '<div id="web" class="form-group" >
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Web User']) .'</label>
<div class="col-sm-10  col-md-9">
<select name="layer0" id="underMenu" class="underMenu form-control">
<option value="0">'. _uc($_e['Select']) .'</option>
'.$option.'
</select>
</div>
</div>';


    
      $option = $this->underProductMenuOption($layer2);

        echo '<div  class="form-group" id="pro" >
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Products']) .'</label>
<div class="col-sm-10  col-md-9">
<select name="layer2" id="underMenu" class="underMenu form-control">
<option value="0">'. _uc($_e['Select']) .'</option>
'.$option.'
</select>
</div>
</div>';

 

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

        //echo '<input type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary"/>';
        echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _uc($_e['SAVE']) .'</button>';

        echo "</div>
             </form>";
    }
}
?>
<!-- <script type="text/javascript">
$('#users').on('change', '#users', function(event) {
event.preventDefault();
/ Act on the event /
console.log(this.id);
console.log("status two:"+$('#users').is(':checked'));
var checkbox_status = $('#uzair').is(':checked');

// save the short_desc status, is it visible or is it showing
var short_desc_container = $("#uzair");

console.log(short_desc_container);

if ( checkbox_status ) {
$('#box_inputs_fieldset').fadeIn(200);
short_desc_container.fadeIn(200);
} else {
$('#box_inputs_fieldset').fadeOut(200);
short_desc_container.fadeOut(200);
}
});</script> -->


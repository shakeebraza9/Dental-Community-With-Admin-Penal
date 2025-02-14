<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class newslider extends object_class{
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
        $_w['Slider Management'] = '' ;
        //brandsEdit.php
        $_w['Manage Slider'] = '' ;

        //brands.php
        $_w['Active Slider'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Sort Slider'] = '' ;
        $_w['Add New Slider'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;
        $_w['There is an error, Please Refresh Page and Try Again'] = '' ;
        $_w['SNO'] = '' ;
        $_w['TITLE'] = '' ;
        $_w['IMAGE'] = '' ;
        $_w['ACTION'] = '' ;

        $_w['Image File Error'] = '' ;
        $_w['Image Not Found'] = '' ;
        $_w['Slider'] = '' ;
        $_w['Added'] = '' ;
        $_w['Slider Add Successfully'] = '' ;
        $_w['Slider Add Failed'] = '' ;
        $_w['Slider Update Failed'] = '' ;
        $_w['Slider Update Successfully'] = '' ;
        $_w['Update'] = '' ;
        $_w['Slider Title'] = '' ;
        $_w['Slider Link'] = '' ;
        $_w['Short Desc'] = '' ;
        $_w['Image Recommended Size : {{size}}'] = '' ;
        $_w['Publish'] = '' ;

        $_w['SAVE'] = '' ;
        $_w['Old Slider Image'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Brands');

    }


    public function newsliderSort(){
        echo '<div class="table-responsive sortDiv">
                <div class="container-fluid activeSort">';
        $sql ="SELECT brand_heading,image,id FROM `newslider` WHERE publish = '1' ORDER BY sort ASC";
        $data = $this->dbF->getRows($sql);

        $defaultLang = $this->functions->AdminDefaultLanguage();
        foreach($data as $val){
            $id = $val['id'];
            $image = $val['image'];
            @$title = unserialize($val['brand_heading']);
            @$title = $title[$defaultLang];
            echo '  <div class="singleAlbum " id="album_'.$id.'">
                         <div class="col-sm-12 albumSortTop"> ::: </div>
                         <div class="albumImage"><img src="../images/'.$image.'"  class="img-responsive"/></div>
                        <div class="clearfix"></div>
                        <div class="albumMange col-sm-12">
                            <div class="col-sm-12 btn-default" style="">'.$title.'</div>
                        </div>
                    </div>';
        }

        echo '</div>';
        echo '</div>';
    }


    public function newsliderView(){
        $sql  = "SELECT id, brand_heading,image FROM newslider WHERE publish='1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->newsliderPrint($data);
    }

    public function newsliderDraft(){
        $sql  = "SELECT id, brand_heading,image FROM newslider WHERE publish='0' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->newsliderPrint($data);
    }

    public function newsliderPrint($data){
        global $_e;
        $class = 'tableIBMS';
        $heading = false;
        if($this->functions->developer_setting('brand_heading')=='1'){
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
        echo            '<th>'. _u($_e['IMAGE']) .'</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        $defaultLang = $this->functions->AdminDefaultLanguage();
        foreach($data as $val){
            $i++;
            $id = $val['id'];
            echo "<tr>
                    <td>$i</td>";
            if($heading){
                @$brand_heading = unserialize($val['brand_heading']);
                @$brand_heading = $brand_heading[$defaultLang];
                echo "  <td>$brand_heading</td>";
            }
            echo "
                    <td><img src='../images/$val[image]' style='max-height:200px;max-with:500px;'/></td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-id='$id' href='-newslider?page=edit&brandId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>
                            <a data-id='$id' onclick='deleteslid(this);' class='btn'>
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

    public function NewsliderAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newBrand')){return false;}

            $heading        = empty($_POST['brand_heading'])   ? ""    : serialize($_POST['brand_heading']);
            $link           = empty($_POST['brand_link'])      ? ""    : $_POST['brand_link'];
            $short_desc     = empty($_POST['brand_shrtDesc'])  ? ""    : serialize($_POST['brand_shrtDesc']);
            $publish        = empty($_POST['publish'])     ? "0"   : $_POST['publish'];
            $file           = empty($_FILES['image']['name'])   ? false    : true;
            $returnImage = "";
            try{
                $this->db->beginTransaction();

                $sql      =   "INSERT INTO `newslider`(
                                    `brand_link`, `brand_heading`, `brand_shrtDesc`,`image`,`publish`)
                                    VALUES (?,?,?,?,?)";

                if($file){
                    $returnImage =  $this->functions->uploadSingleImage($_FILES['image'],'brands');
                    if($returnImage==false){
                        throw new Exception(($_e['Image File Error']));
                    }
                }

                $array   = array($link,$heading,$short_desc,$returnImage,$publish);
                $this->dbF->setRow($sql,$array,false);
                $lastId = $this->dbF->rowLastId;

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Add Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Added']),_uc($_e['Slider']),$lastId,($_e['Slider Add Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Add Failed']),'btn-danger');
                }
            }catch (Exception $e){
                if($returnImage!==false && $file){
                    $this->functions->deleteOldSingleImage($returnImage);
                }
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Add Failed']),'btn-danger');
            }
        } // If end
    }




    public function newsliderEditSubmit(){
        global $_e;
        if(isset($_POST['submit']) && isset($_POST['editId'])){
            if(!$this->functions->getFormToken('editBrands')){return false;}

            $heading        = empty($_POST['brand_heading'])   ? ""    : serialize($_POST['brand_heading']);
            $link           = empty($_POST['brand_link'])      ? ""    : $_POST['brand_link'];
            $short_desc     = empty($_POST['brand_shrtDesc'])  ? ""    : serialize($_POST['brand_shrtDesc']);
            $publish        = empty($_POST['publish'])     ? "0"   : $_POST['publish'];
            $file           = empty($_FILES['image']['name'])   ? false    : true;
            $returnImage = "";

            $oldImg      = empty($_POST['oldImg'])     ? ""   : $_POST['oldImg'];
            $returnImage = $oldImg;
            try{
                $this->db->beginTransaction();
                $lastId   =   $_POST['editId'];

                if($file){
                    $this->functions->deleteOldSingleImage($oldImg);
                    $returnImage =  $this->functions->uploadSingleImage($_FILES['image'],'brands');
                    if($returnImage==false){
                        throw new Exception(($_e['Image File Error']));
                    }
                }

                $sql    =  "UPDATE `newslider` SET
                                    `brand_link`=?,
                                    `brand_heading`=?,
                                    `brand_shrtDesc`=?,
                                    `image`=?,
                                    `publish`=?
                                       WHERE id = '$lastId'
                                ";

                $array   = array($link,$heading,$short_desc,$returnImage,$publish);
                $this->dbF->setRow($sql,$array,false);

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Update Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Update']),_uc($_e['Slider']),$lastId,($_e['Slider Update Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Update Failed']),'btn-danger');
                }
            }catch (Exception $e){
                if($returnImage!==false && $file){
                    $this->functions->deleteOldSingleImage($returnImage);
                }
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Slider']),($_e['Slider Update Failed']),'btn-danger');
            }

        }
    }

    public function newsliderNew(){
        global $_e;
        $this->newsliderEdit(true);
    }

    public function newsliderEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newBrand',false);
        }else {
            
            $id = $_GET['brandId'];
            $sql = "SELECT * FROM newslider where id = '$id' ";
            $data = $this->dbF->getRow($sql);

            $token = $this->functions->setFormToken('editBrands', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
        }
        //No need to remove any thing,, go in developer setting table and set 0

        echo '<form method="post" action="-newslider?page=newslider" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

        $lang = $this->functions->IbmsLanguages();
        if($lang != false){
            $lang_nonArray = implode(',', $lang);
        }

        echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';

        echo '<div class="panel-group" id="accordion">';


        @$brand_heading = unserialize($data['brand_heading']);
        @$brand_shrtDesc =  unserialize($data['brand_shrtDesc']);

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
            if($this->functions->developer_setting('brand_heading')=='1'){
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['TITLE']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="text" name="brand_heading['.$lang[$i].']" value="'.@$brand_heading[$lang[$i]].'" class="form-control" placeholder="'. _uc($_e['Slider Title']) .'">
                        </div>
                    </div>';
                    
            }else{ echo '<input type="hidden" name="brand_heading['.$lang[$i].']" value="" class="form-control">';}

            // Short Desc
            if($this->functions->developer_setting('brand_shrtDesc')=='1'){
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Short Desc']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <textarea name="brand_shrtDesc['.$lang[$i].']" id="brand_shrtDesc" maxlength="500" class="form-control" placeholder="'. _uc($_e['Short Desc']) .'">'.@$brand_shrtDesc[$lang[$i]].'</textarea>
                        </div>
                    </div>';
            }else{ echo '<input type="hidden" name="brand_shrtDesc['.$lang[$i].']" value="" class="form-control">';}


            echo '           </div> <!-- panel-body end -->
                          </div> <!-- collapse end-->
                    </div><!-- panel end-->';
        }

        echo '</div> <!-- .accordian end -->';


        //Link







if($this->functions->developer_setting('brand_link')=='1'){
echo '<div class="form-group">
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Slider Link']) .'</label>
<div class="col-sm-10  col-md-9">
<div class="input-group">
<input type="url" value="'.@$data['brand_link'].'" name="brand_link" class="pastLinkHere form-control" placeholder="'. _uc($_e['Slider Link']) .'">
<div class="input-group-addon linkList pointer"><i class="glyphicon glyphicon-search"></i></div>
</div>
</div>
</div>';
}else{ echo '<input type="hidden" name="brand_link" value="" class="form-control">';}

//Brand
// $size = $this->functions->developer_setting('brand_size');
$img = "";
if(@$data['image']!=''){
$img=$data['image'];
echo "<input type='hidden' name='oldImg' value='$img' />";
echo '<div class="form-group">
<label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Old Slider Image']) .'</label>
<div class="col-sm-10  col-md-9">
<img src="../images/'.$img.'" style="max-height:250px;" >
</div>
</div>';
}

echo '<div class="form-group">
<label  class="col-sm-2 col-md-3  control-label">Image Recommended Size 370 x 211 px</label>
<div class="col-sm-10  col-md-9">
<input type="file" name="image" class="btn-file btn btn-primary">
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

             $this->functions->includeOnceCustom(ADMIN_FOLDER."/menu/classes/menu.class.php");
$menuC  =   new webMenu();
$menuC->menuWidgetLinks();


    }
}
?>
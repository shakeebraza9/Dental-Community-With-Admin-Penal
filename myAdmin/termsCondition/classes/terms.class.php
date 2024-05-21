<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class terms extends object_class{
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
        //index page
        $_w['Terms Management'] = '' ;
        //Terms.php
        $_w['Manage Terms'] = '' ;
        $_w['Active Terms'] = '' ;
        $_w['Draft Terms'] = '' ;
        $_w['Add New Terms'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;

        //blogEdit.php

        //This Class
        $_w['SNO'] = '' ;
        $_w['USER'] = '' ;
        $_w['TITLE'] = '' ;
        $_w['Terms DATE'] = '' ;
        $_w['PUBLISH DATE'] = '' ;
        $_w['UPDATE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Terms'] = '' ;
        $_w['Terms Save Successfully'] = '' ;
        $_w['Added'] = '' ;
        $_w['Terms Save Failed'] = '' ;
        $_w['Terms Update Successfully'] = '' ;
        $_w['Image File Error'] = '' ;
        $_w['Terms Title'] = '' ;

        $_w['Category'] = '' ;
        $_w['Other'] = '' ;
        $_w['Enter Category Name'] = '' ;
        $_w['Short Description'] = '' ;
        $_w['Enter Short Description'] = '' ;
        $_w['Employee User'] = '' ;
        $_w['Master User'] = '' ;
        $_w['Practice User'] = '' ;
        $_w['Enter Full Detail'] = '' ;
        $_w['Allow Comment'] = '' ;
        $_w['Publish'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Date'] = '' ;
        $_w['Leave Blank to publish now'] = '' ;
        $_w['Terms Image'] = '' ;
        $_w['Old Terms Image'] = '' ;
        $_w['SAVE'] = '' ;
        $_w['Slug'] = '' ;
        $_w['SLUG'] = '' ;
        $_w['Product']='';

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Blog');
    }
     function products() {
        $name = '';
        $sql  = "SELECT * FROM `proudct_detail_spb` WHERE product_update='1' AND validity>1";
        $data = $this->dbF->getRows($sql);
        foreach($data as $key => $value) {
            $pid   = $value['prodet_id'];
            $nm    = translateFromSerialize($value['prodet_name']);
            $valid = translateFromSerialize($value['validity']);
            $shortDesc   = translateFromSerialize($value['prodet_shortDesc']);
            $sql   = "SELECT `propri_price` FROM `product_price_spb` WHERE propri_prodet_id= ?";
            $data  = $this->dbF->getRow($sql,array($pid));
            $price = $data[0];
            $name .= '<option value="'.$pid.'">'.$nm."-".$shortDesc.'</option>';
        }
        return $name;
    }


   public function termsView(){
$sql  = "SELECT * FROM term_and_condition WHERE status='1' ORDER BY ID DESC";
$data =  $this->dbF->getRows($sql);
$this->termsPrint($data);
}

public function termsDraft(){
$sql  = "SELECT * FROM term_and_condition WHERE status='0' ORDER BY ID DESC";
$data =  $this->dbF->getRows($sql);
$this->termsPrint($data);
}

public function termsPrint($data){
global $_e;

echo '<div class="table-responsive">
<table class="table table-hover tableIBMS">
<thead>
<th>'. _u($_e['SNO']) .'</th>';

echo            '<th>'. _u($_e['TITLE']) .'</th>
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

@$terms_heading = unserialize($val['title']);
@$terms_heading = $terms_heading[$defaultLang];
echo "<td>$terms_heading</td>";



echo "
<td>
<div class='btn-group btn-group-sm'>
<a data-id='$id' href='-termsCondition?page=edit&termsId=$id' class='btn'>
<i class='glyphicon glyphicon-edit'></i>
</a>
<a data-id='$id' onclick='deleteTerms(this);' class='btn'>
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



  

    public function newTermsAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newTerms')){return false;}

            $heading        = empty($_POST['heading'])     ? ''    : serialize($_POST['heading']);
            $employee     = empty($_POST['employee'])   ? ''    : serialize($_POST['employee']);
            $master            = empty($_POST['master'])         ? ''    : serialize($_POST['master']);
            $practice            = empty($_POST['practice'])         ? ''    : serialize($_POST['practice']);
            $date           = empty($_POST['date'])   ? ""    : $_POST['date'];
            $productId           = empty($_POST['productId'])   ? ""    : $_POST['productId'];
            $publish        = empty($_POST['publish'])     ? "0"   : $_POST['publish'];


            try{

                $this->db->beginTransaction();

                $sql      =   "INSERT INTO `term_and_condition` SET
                                 `title`=?,
                                 `employee_term`=?,
                                 `master_term`=?,
                                 `practice_term`=?,
                                 `productId`=?,
                                 `date`=?,
                                 `status`=?";

                $array   = array($heading,$employee,$master,$practice,$productId,$date,$publish);

                $this->dbF->setRow($sql,$array,false);
                $this->db->commit();

                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Terms']),($_e['Terms Save Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Added']),_uc($_e['Terms']),$this->dbF->rowLastId,($_e['Terms Save Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Terms']),($_e['Terms Save Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Blog']),($_e['Blog Save Failed']),'btn-danger');
            }
        } // If end
    }


    public function termsEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])  && isset($_POST['editId'])){
           if(!$this->functions->getFormToken('editTerms')){return false;}

           
            $heading        = empty($_POST['heading'])     ? ''    : serialize($_POST['heading']);
            $employee     = empty($_POST['employee'])   ? ''    : serialize($_POST['employee']);
            $master            = empty($_POST['master'])         ? ''    : serialize($_POST['master']);
            $practice            = empty($_POST['practice'])         ? ''    : serialize($_POST['practice']);
            $productId           = empty($_POST['productId'])   ? ""    : $_POST['productId'];
            $date           = empty($_POST['date'])   ? ""    : $_POST['date'];
            $publish        = empty($_POST['publish'])     ? "0"   : $_POST['publish'];
         
            try{
                $this->db->beginTransaction();
                $lastId   =   $_POST['editId'];
              

                $sql      =   "UPDATE `term_and_condition` SET
                                 `title`=?,
                                 `employee_term`=?,
                                 `master_term`=?,
                                 `practice_term`=?,
                                 `productId`=?,
                                 `date`=?,
                                 `status`=?

                                WHERE id = '$lastId'

                                ";

                $array   = array($heading,$employee,$master,$practice,$productId,$date,$publish);

                $this->dbF->setRow($sql,$array,false);

                $this->db->commit();

                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Terms']),($_e['Terms Update Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Added']),_uc($_e['Terms']),$this->dbF->rowLastId,($_e['Terms Update Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Terms']),($_e['Terms Save Failed']),'btn-danger');
                }

            }catch (Exception $e){
                if($imgName!==false && $file){
                    $this->functions->deleteOldSingleImage($imgName);
                }
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Terms']),($_e['Terms Update Failed']),'btn-danger');
            }

        }
    }


    public function termsNew(){
        global $_e;
        $token       = $this->functions->setFormToken('newTerms',false);
        //No need to remove any thing,, go in developer setting table and set 0


    echo '<form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">'.
           $token.
           '<div class="form-horizontal">

            <div class="panel-group" id="accordion">

            ';


        $lang = $this->functions->IbmsLanguages();
        if ($lang != false) {
            $lang_size = sizeof($lang);
            for ($i = 0; $i < $lang_size; $i++) {
                if ($i == 0) {
                    $collapseIn = ' in ';
                } else {
                    $collapseIn = '';
                }

                echo '<div class="panel panel-default">
                        <div class="panel-heading">
                             <a data-toggle="collapse" data-parent="#accordion" href="#' . $lang[$i] . '">
                                <h4 class="panel-title">
                                    ' . $lang[$i] . '
                                </h4>
                             </a>
                        </div>
                        <div id="' . $lang[$i] . '" class="panel-collapse collapse ' . $collapseIn . '">
                            <div class="panel-body">';


                //Title
                echo '<div class="form-group">
                            <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Terms Title']) .'</label>
                            <div class="col-sm-10  col-md-9">
                                <input type="text" name="heading[' . $lang[$i] .']" class="form-control" placeholder="'. _uc($_e['Terms Title']) .'">
                            </div>
                      </div>';

                

                //Employee Terms
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Employee User']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <textarea name="employee[' . $lang[$i] .']" id="employee_' . $lang[$i] .'" placeholder="'. _uc($_e['Enter Full Detail']) .'"></textarea>
                            <script>
                               $(function() {
                                 CKEDITOR.replace("employee_' . $lang[$i] .'");
                               });
                            </script>
                        </div>
                   </div>';
                   //Master Terms
                   echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Master User']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <textarea name="master[' . $lang[$i] .']" id="master_' . $lang[$i] .'" placeholder="'. _uc($_e['Enter Full Detail']) .'"></textarea>
                            <script>
                               $(function() {
                                 CKEDITOR.replace("master_' . $lang[$i] .'");
                               });
                            </script>
                        </div>
                   </div>';
                   //Practice Terms
                   echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Practice User']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <textarea name="practice[' . $lang[$i] .']" id="practice_' . $lang[$i] .'" placeholder="'. _uc($_e['Enter Full Detail']) .'"></textarea>
                            <script>
                               $(function() {
                                 CKEDITOR.replace("practice_' . $lang[$i] .'");
                               });
                            </script>
                        </div>
                   </div>';



                echo '

                </div> <!-- panel-body-->
                        </div> <!-- #$lang[$i] -->

                    </div> <!-- .panel-default -->';


            }

            echo '</div> <!-- .panel-group -->';

        }
        echo '<div class="form-group">
        <label for="input2" class="col-sm-2 col-md-3  control-label">'. _uc($_e['Product']) .'</label>
        <div class="col-sm-10  col-md-9">
        <select  id="products" name="productId" class="form-control" required="required">
        <option value="0">Select Product</option>
              ' . $this->products() . '
        </select>
        </div>
        </div>';

         //Date
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Date']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="date" name="date" class="form-control" placeholder="'. _uc($_e['Date']) .'" required>
                        </div>
                    </div>';





        //


        //Publish
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Publish']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Publish']) .'" data-off-label="'. _uc($_e['Draft']) .'">
                            <input type="checkbox" name="publish" value="1">
                        </div>
                    </div>
               </div>';

        //echo '<input type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary"/>';
        echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _u($_e['SAVE']) .'</button>';

        echo "</div>
             </form>";
    }

    public function termsEdit(){
        global $_e;
        $token       = $this->functions->setFormToken('editTerms',false);
        $id     =   $_GET['termsId'];
        $sql    =   "SELECT * FROM term_and_condition where id = '$id' ";
        $data   =   $this->dbF->getRow($sql);
        //No need to remove any thing,, go in developer setting table and set 0
        echo '<form method="post" action="-termsCondition?page=terms" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '<input type="hidden" name="editId" value="'.$id.'"/>
            <div class="form-horizontal">

            <div class="panel-group" id="accordion">

            ';



        $lang = $this->functions->IbmsLanguages();
        if ($lang != false) {
            $lang_size = sizeof($lang);
            for ($i = 0; $i < $lang_size; $i++) {
                if ($i == 0) {
                    $collapseIn = ' in ';
                } else {
                    $collapseIn = '';
                }

                $heading   = unserialize($data['title']);
                $employee_term = unserialize($data['employee_term']);
                $master_term       = unserialize($data['master_term']);
                $practice_term       = unserialize($data['practice_term']);
                $productId=$data['productId'];
                $date=$data['date'];


                echo '<div class="panel panel-default">
                        <div class="panel-heading">
                             <a data-toggle="collapse" data-parent="#accordion" href="#' . $lang[$i] . '">
                                <h4 class="panel-title">
                                    ' . $lang[$i] . '
                                </h4>
                             </a>
                        </div>
                        <div id="' . $lang[$i] . '" class="panel-collapse collapse ' . $collapseIn . '">
                            <div class="panel-body">';


                //Title
                echo '<div class="form-group">
                            <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Terms Title']) .'</label>
                            <div class="col-sm-10  col-md-9">
                                <input type="text" value="'.$heading[$lang[$i]].'" name="heading[' . $lang[$i] .']" class="form-control" placeholder="'. _uc($_e['Terms Title']) .'">
                            </div>
                        </div>';

              


                //Employee User
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Employee User']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <textarea name="employee[' . $lang[$i] .']" id="employee_' . $lang[$i] . '" placeholder="'. _uc($_e['Enter Full Detail']) .'">'.($employee_term[$lang[$i]]).'</textarea>
                            <script>
                               $(function() {
                                 CKEDITOR.replace("employee_' . $lang[$i] . '");
                               });
                            </script>
                        </div>
                   </div>';
                   //Master User
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Master User']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <textarea name="master[' . $lang[$i] .']" id="master_' . $lang[$i] . '" placeholder="'. _uc($_e['Enter Full Detail']) .'">'.($master_term[$lang[$i]]).'</textarea>
                            <script>
                               $(function() {
                                 CKEDITOR.replace("master_' . $lang[$i] . '");
                               });
                            </script>
                        </div>
                   </div>';
                   //Practice User
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Practice User']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <textarea name="practice[' . $lang[$i] .']" id="practice_' . $lang[$i] . '" placeholder="'. _uc($_e['Enter Full Detail']) .'">'.($practice_term[$lang[$i]]).'</textarea>
                            <script>
                               $(function() {
                                 CKEDITOR.replace("practice_' . $lang[$i] . '");
                               });
                            </script>
                        </div>
                   </div>';


                echo '

                </div> <!-- panel-body-->
                        </div> <!-- #$lang[$i] -->

                    </div> <!-- .panel-default -->';


            } // for loop end

            echo '</div> <!-- .panel-group -->';

        }

         echo '<div class="form-group">
        <label for="input2" class="col-sm-2 col-md-3  control-label">'. _uc($_e['Product']) .'</label>
        <div class="col-sm-10  col-md-9">
        <select  id="products" name="productId" class="form-control products" required="required">
        <option value="0">Select Product</option>
              ' . $this->products() . '
        </select>
        </div>
        </div>
        <script>$(".products").val("'.@$productId.'").change();</script>';

          echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Date']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="date" name="date" value="'.@$date.'" class="form-control" placeholder="'. _uc($_e['Date']) .'" required>
                        </div>
                    </div>';



        //Publish
        $checked = "";
        if($data['status']=='1'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Publish']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Publish']) .'" data-off-label="'. _uc($_e['Draft']) .'">
                            <input type="checkbox" name="publish" value="1" '.$checked.'>
                        </div>
                    </div>
               </div>';


       
        echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _u($_e['SAVE']) .'</button>';

        echo "</div>
             </form>";


    }
}
?>
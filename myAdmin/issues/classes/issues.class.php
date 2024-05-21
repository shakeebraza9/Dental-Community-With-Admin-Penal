<?php
require_once (__DIR__."/../../global.php"); //connection setting db

################### NEW MODULE NOTE ##########################
//If you want to make new module like issues, just copy paste issues. and change page_type to your type
//and only change label  and hide or show any fields.

class issues extends object_class{
    public $productF;
    public $imageName;
    private $page_type = "issues";
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
        $_w['Issues Management'] = '' ;
        //issues.php
        $_w['Manage Issues'] = '' ;
        $_w['Active Issues'] = '' ;
        $_w['Pending'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Add New Issues'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;

        //issuesNew.php
        $_w['Add New Issues/Event'] = '' ;

        //This Class
        $_w['SNO'] = '' ;
        $_w['TITLE'] = '' ;
        $_w['PUBLISH DATE'] = '' ;
        $_w['UPDATE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Issues Save Successfully'] = '' ;
        $_w['Added'] = '' ;
        $_w['Issues Save Failed'] = '' ;

        $_w['SAVE'] = '' ;
        $_w['Issues Image (278x278 px)'] = '' ;
        $_w['Leave Blank to publish now'] = '' ;
        $_w['Publish'] = '' ;

        $_w['Allow Comment'] = '' ;
        $_w['Issues Date'] = '' ;
        $_w['Date'] = '' ;
        $_w['Issues Setting'] = '' ;
        $_w['Enter Full Detail'] = '' ;
        $_w['Detail'] = '' ;
        $_w['Enter Short Description'] = '' ;
        $_w['Short Description'] = '' ;
        $_w['Issues Title'] = '' ;
        $_w['Type'] = '' ;
        $_w['Issues Detail'] = '' ;
        $_w['Old Issues Image'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin Issues Management');

    }


    public function issuesView(){
        $today = date('Y-m-d');
        $page_type = $this->page_type;
        // $sql  = "SELECT id, heading,publish_date,dateTime FROM issues WHERE publish = '1' AND publish_date <= '$today' ";
        $sql  = "SELECT * FROM clientAddIssue";
        $data =  $this->dbF->getRows($sql);
        $this->print_issues_table($data);
    }

    public function issuesPending(){
        $today = date('Y-m-d');
        $page_type = $this->page_type;
        $sql  = "SELECT id, heading,publish_date,dateTime FROM issues WHERE publish = '1' AND publish_date > '$today' ";
        $data =  $this->dbF->getRows($sql);
        $this->print_issues_table($data);
    }


    public function issuesDraft(){
        $page_type = $this->page_type;
        $sql  = "SELECT id, heading,publish_date,dateTime FROM issues WHERE publish = '0' ";
        $data =  $this->dbF->getRows($sql);

        $this->print_issues_table($data);
    }

    private function print_issues_table($data){
        $data   = empty($data) ? array() : $data;
        global $_e;
        echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>




                        <th>'. _u($_e['SNO']) .'</th>
                        <th>Type</th>
                        <th>Entry By</th>
                        <th>File</th>
                        <th>About Incident</th>
                        <th>Status</th>
                        <th>Entry Date</th>
                    




                    </thead>
                <tbody>';

        $i = 0;
        $defaultLang = $this->functions->AdminDefaultLanguage();
        foreach($data as $val){
            $i++;
            $id = $val['id'];
            $dateTime = $val['todayDate'];
            $loginid = $this->functions->UserName($val['submitBy']);
            $name = $val['name'];
            $filename = WEB_URL.'/images/'.$val['filename'];
            $otherDetail = $val['otherDetail'];

            $complaint_summary =  $val['name'];
if($complaint_summary == "Complaint Form"){
$complaint_summary =  $val['complaint_summary'];
}else{
$complaint_summary =  $val['desc_of_incident'];

}





          $s = 'Pending';
if($val['status'] == "1"){

 $s = 'Completed';
}
            echo "<tr>
                    <td>$i</td>
                    <td>$name</td>
                    <td>$loginid</td>
                    <td><a href='$filename' target='_blank'>Link</td>
                    <td>$complaint_summary</td>
                    <td>$s</td>
                    <td>$dateTime</td>
                   

                  </tr>";
        }


        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }

    public function newIssuesAdd(){
        
        
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newIssues')){return false;}

            $heading        = empty($_POST['heading'])      ? ""    : serialize($_POST['heading']);
            $short_desc     = empty($_POST['shortDesc'])    ? ""    : serialize($_POST['shortDesc']);
            $dsc            = empty($_POST['dsc'])          ? ""    : serialize($_POST['dsc']);
            $date           = empty($_POST['date'])         ? ""    : $_POST['date'];
            $publish        = empty($_POST['publish'])      ? "0"   : $_POST['publish'];
            $ntype          = "noti";
            $publishDate    = empty($_POST['publish_date']) ? ""    : date('Y-m-d',strtotime($_POST['publish_date']));
            $comment        = empty($_POST['comment'])      ? "0"   : $_POST['comment'];
            $file           = empty($_FILES['image']['name'])? false    : true;
            $returnImage    = "";
            $date           =   date('Y-m-d',strtotime($date));
            try{
                $this->db->beginTransaction();

                $sql      =   "INSERT INTO `issues`(
                                    `date`, `heading`, `shortDesc`,
                                     `dsc`, `image`,
                                     `comment`, `publish`,`publish_date`,
                                     `type`)
                                    VALUES (?,?,?,  ?,?,   ?,?,?, ?)";

                if($file){
                    $returnImage =  $this->functions->uploadSingleImage($_FILES['image'],'issues');
                    if($returnImage==false){
                        throw new Exception('Image File Error');
                    }
                }

                $array   = array($date,$heading,$short_desc,
                    $dsc,$returnImage,
                    $comment,$publish,$publishDate,$ntype);

                $this->dbF->setRow($sql,$array,false);

                $this->db->commit();
                if($this->dbF->rowCount>0){
                   $heading = translateFromSerialize($heading);
                    $content = translateFromSerialize($short_desc)."<br>".translateFromSerialize($dsc);
                    $data = $this->dbF->getRows("SELECT * FROM `accounts_user` WHERE `acc_type` = '1'");
                    foreach ($data as $key => $value) {
                        $email = $value['acc_email'];
                        $uid = $value['acc_id'];
                       $this->functions->send_mail($email,$heading,$content);
                       $this->functions->push_notification($heading,translateFromSerialize($short_desc),$this->functions->getUserPlayerId($uid));
                         $sql  = "INSERT INTO `notification_record` (`user`,`type`,`notification`,`playerid`) VALUES (?,?,?,?)";
                              $array   = array($uid,$ntype,$content,$this->functions->getUserPlayerId($uid));
                              $this->dbF->setRow($sql,$array);
                              
                    }
                    $this->functions->notificationError(_uc($_e['Issues']),($_e['Issues Save Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Added']),_uc($_e['Issues']),$this->dbF->rowLastId,($_e['Issues Save Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Issues']),($_e['Issues Save Failed.']),'btn-danger');
                }
            }catch (Exception $e){
                if($returnImage!==false){
                    $this->functions->deleteOldSingleImage($returnImage);
                }
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Issues']),($_e['Issues Save Failed.']),'btn-danger');
            }
        } // If end
    
        
    }

    public function issuesEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])  && isset($_POST['editId'])){
             if(!$this->functions->getFormToken('editIssues')){return false;}

            $heading        = empty($_POST['heading'])      ? ""    : serialize($_POST['heading']);
            $short_desc     = empty($_POST['shortDesc'])    ? ""    : serialize($_POST['shortDesc']);
            $dsc            = empty($_POST['dsc'])          ? ""    : serialize($_POST['dsc']);
            $date           = empty($_POST['date'])         ? ""    : $_POST['date'];
            $publish        = empty($_POST['publish'])      ? "0"   : $_POST['publish'];
            $ntype           = "noti";
              // $ntype           = empty($_POST['ntype'])         ? ""   : $_POST['ntype'];
            $publishDate    = empty($_POST['publish_date']) ? ""    : date('Y-m-d',strtotime($_POST['publish_date']));
            $comment        = empty($_POST['comment'])      ? "0"   : $_POST['comment'];
            $file           = empty($_FILES['image']['name'])? false    : true;
            $date           =   date('Y-m-d',strtotime($date));
            $oldImg         = empty($_POST['oldImg'])       ? ""    : $_POST['oldImg'];
            $returnImage    = $oldImg;
            try{
                $this->db->beginTransaction();
                $lastId   =   $_POST['editId'];

                if($file){
                    $this->functions->deleteOldSingleImage($oldImg);
                    $returnImage =  $this->functions->uploadSingleImage($_FILES['image'],'issues');
                    if($returnImage==false){
                        throw new Exception('Image File Error');
                    }
                }else{
                    $this->imageName = $oldImg;
                }

                $sql    =  "UPDATE `issues` SET
                                    `date`=?,
                                    `heading`=?,
                                    `shortDesc`=?,
                                    `dsc` =?  ,
                                    `image`=?,
                                    `comment`=?,
                                    `publish`=?,
                                    `publish_date`=?,
                                    `type` = ?
                                       WHERE id = '$lastId'
                                ";

                $array   = array($date,$heading,$short_desc,
                    $dsc,$returnImage,
                    $comment,$publish,$publishDate,$ntype);

                $this->dbF->setRow($sql,$array,false);

                $this->db->commit();

                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Issues']) ,_uc($_e['Issues Save Successfully']) ,'btn-success');
                    $this->functions->setlog(_uc($_e['UPDATE']) ,_uc($_e['Issues']) ,$this->dbF->rowLastId,_uc($_e['Issues Save Successfully']) );
                }else{
                    $this->functions->notificationError(_uc($_e['Issues']) ,_uc($_e['Issues Save Failed']) ,'btn-danger');
                }

            }catch (Exception $e){
                if($file && $returnImage!==false){
                    $this->functions->deleteOldSingleImage($returnImage);
                }
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Issues']) ,_uc($_e['Issues Save Failed']) ,'btn-danger');
            }

        }
    }


    public function issuesNew(){
        global $_e;
        $token       = $this->functions->setFormToken('newIssues',false);
        //No need to remove any thing,, go in developer setting table and set 0
        echo '<form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">'.
           $token.
           '<div class="form-horizontal">

           <!-- Nav tabs -->
            <ul class="nav nav-tabs tabs_arrow" role="tablist">
                <li class="active"><a href="#homeP" role="tab" data-toggle="tab">'. _uc($_e['Detail']) .'</a></li>
                <li><a href="#setting" role="tab" data-toggle="tab">'. _uc($_e['Issues Setting']) .'</a></li>
            </ul>


           <!-- Tab panes -->
              <div class="tab-content">
                  <div class="tab-pane fade in active container-fluid" id="homeP">
                    <h2  class="tab_heading">'. _uc($_e['Issues Detail']) .'</h2>
           ';

        $lang = $this->functions->IbmsLanguages();
        if($lang != false){
            $lang_nonArray = implode(',', $lang);
        }
        echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';

        echo '<div class="panel-group" id="accordion">';
        for ($i = 0; $i < sizeof($lang); $i++) {
            if($i==0){
                $collapseIn = ' in ';
            }else{
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
                                echo '<div class="form-group">
                                            <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['TITLE']) .'</label>
                                            <div class="col-sm-10  col-md-9">
                                                <input type="text" name="heading['.$lang[$i].']"  maxlength="150"  class="form-control" placeholder="'. _uc($_e['Issues Title']) .'">
                                            </div>
                                        </div>';

                                //Short Desc
                                echo '<div class="form-group">
                                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Short Description']) .'</label>
                                        <div class="col-sm-10  col-md-9">
                                            <textarea name="shortDesc['.$lang[$i].']" class="form-control" maxlength="500" placeholder="'. _uc($_e['Enter Short Description']) .'"></textarea>
                                        </div>
                                   </div>';

                                //Desc
                                echo '<div class="form-group">
                                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Detail']) .'</label>
                                        <div class="col-sm-10  col-md-9">
                                            <textarea name="dsc['.$lang[$i].']" id="dsc_'.$lang[$i].'_" placeholder="'. _uc($_e['Enter Full Detail']) .'" class="ckeditor"></textarea>
                                        </div>
                                   </div>';

            echo '           </div> <!-- panel-body end -->
                          </div> <!-- collapse end-->
                    </div><!-- panel end-->';
        }


        echo '</div> <!-- .accordian end -->';

        echo '</div> <!-- homeP Tab End -->
                     <div class="tab-pane fade in container-fluid" id="setting">
                            <h2  class="tab_heading">'. _uc($_e['Issues Setting']) .'</h2>
                ';

                        //Date
                        if($this->functions->developer_setting('issues_date')=='1'){
                            echo '<div class="form-group">
                                <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Date']) .'</label>
                                <div class="col-sm-10  col-md-9">
                                    <input type="text" name="date" value="'.date("Y-m-d").'" class="date form-control" placeholder="'. _uc($_e['Issues Date']) .'">
                                </div>
                            </div>';
                        }else{ echo '<input type="hidden" name="date" value="" class="form-control">';}

                  

                        //Publish
                        echo '<div class="form-group">
                                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Publish']) .'</label>
                                    <div class="col-sm-10  col-md-9">
                                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Publish']) .'" data-off-label="'. _uc($_e['Draft']) .'">
                                            <input type="checkbox" name="publish" value="1">
                                        </div>
                                    </div>
                               </div>';


                        //Publish Date
                        echo '<div class="form-group" style="display:none">
                                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['PUBLISH DATE']) .'</label>
                                    <div class="col-sm-10  col-md-9">
                                        <input type="text" value="'.date("Y-m-d").'" name="publish_date" class="date form-control" placeholder="'. ($_e['Leave Blank to publish now']) .'">
                                    </div>
                               </div>';


                        //Banner
                        if($this->functions->developer_setting('issues_image')=='1'){
                            echo '<div class="form-group">
                                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Issues Image (278x278 px)']) .'</label>
                                    <div class="col-sm-10  col-md-9">
                                        <input type="file" name="image" class="btn-file btn btn-primary">
                                    </div>
                               </div>';
                        }else{ echo '<input type="hidden" name="mage" value="" class="form-control">';}

                        //echo '<input type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary"/>';
                    echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _u($_e['SAVE']) .'</button>';

        echo "</div><!-- setting tabs end -->
        </div> <!-- tab-content end -->
    </div> <!-- container end -->
</form>";
    }

    public function issuesEdit(){
        global $_e;
        $token  = $this->functions->setFormToken('editIssues',false);
        $id     =   $_GET['pageId'];
        $sql    =   "SELECT * FROM issues where id = ? ";
        $data   =   $this->dbF->getRow($sql,array($id));
        if($this->dbF->rowCount==0){
            echo "Issues Not Found For Update";
            return false;
        }

        //No need to remove any thing,, go in developer setting table and set 0
        echo '<form method="post" action="-issues?page=issues" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '<input type="hidden" name="editId" value="'.$id.'"/>
            <div class="form-horizontal">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs tabs_arrow" role="tablist">
                <li class="active"><a href="#homeP" role="tab" data-toggle="tab">'. _uc($_e['Detail']) .'</a></li>
                <li><a href="#setting" role="tab" data-toggle="tab">'. _uc($_e['Issues Setting']) .'</a></li>
            </ul>


           <!-- Tab panes -->
              <div class="tab-content">
                  <div class="tab-pane fade in active container-fluid" id="homeP">
                    <h2  class="tab_heading">'. _uc($_e['Issues Detail']) .'</h2>
           ';

        $lang = $this->functions->IbmsLanguages();
        if($lang != false){
            $lang_nonArray = implode(',', $lang);
        }
        echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';

        echo '<div class="panel-group" id="accordion">';

        $heading = unserialize($data['heading']);
        $shortDesc =  unserialize($data['shortDesc']);
        $dsc =  unserialize($data['dsc']);

        for ($i = 0; $i < sizeof($lang); $i++) {
            if($i==0){
                $collapseIn = ' in ';
            }else{
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
                            echo '<div class="form-group">
                                    <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['TITLE']) .'</label>
                                    <div class="col-sm-10  col-md-9">
                                        <input value="'.$heading[$lang[$i]].'" type="text" name="heading['.$lang[$i].']"  maxlength="150"  class="form-control" placeholder="'. _uc($_e['Issues Title']) .'">
                                    </div>
                                </div>';

            //Short Desc
                            echo '<div class="form-group">
                                    <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Short Description']) .'</label>
                                    <div class="col-sm-10  col-md-9">
                                        <textarea name="shortDesc['.$lang[$i].']" class="form-control" maxlength="500" placeholder="'. _uc($_e['Enter Short Description']) .'">'.$shortDesc[$lang[$i]].'</textarea>
                                    </div>
                                </div>';

            //Desc
                            echo '<div class="form-group">
                                    <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Detail']) .'</label>
                                    <div class="col-sm-10  col-md-9">
                                        <textarea name="dsc['.$lang[$i].']" id="dsc_'.$lang[$i].'_" placeholder="'. _uc($_e['Enter Full Detail']) .'" class="ckeditor">'.$dsc[$lang[$i]].'</textarea>
                                    </div>
                               </div>';


            echo '        </div> <!-- panel-body end -->
                      </div> <!-- collapse end-->
                </div><!-- panel end-->';
        }


        echo '</div> <!-- .accordian end -->';

        echo '</div> <!-- homeP Tab End -->
                     <div class="tab-pane fade in container-fluid" id="setting">
                            <h2  class="tab_heading">'. _uc($_e['Issues Setting']) .'</h2>
                ';

        //Date
        if($this->functions->developer_setting('issues_date')=='1'){
            echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Date']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <input type="text" name="date" value="'.$data['date'].'"  class="date form-control" placeholder="'. _uc($_e['Issues Date']) .'">
                    </div>
                 </div>';
        }else{ echo '<input type="hidden" name="date" value="" class="form-control">';}

        //Type
        // if($this->functions->developer_setting('issues_comment')=='1'){
      
        // }else{ echo '<input type="hidden" name="comment" value="0" class="form-control">';}

        //Publish
        $checked = "";
        if($data['publish']=='1'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Publish']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Publish']) .'" data-off-label="'. _uc($_e['Draft']) .'">
                            <input type="checkbox" name="publish" value="1" '.$checked.'>
                        </div>
                    </div>
               </div>';


        //Publish Date
        $publish_date = empty($data['publish_date'])?"":date('m/d/Y',strtotime($data['publish_date']));
        echo '<div class="form-group" style="display:none">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['PUBLISH DATE']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <input type="text" value="'.$publish_date.'" name="publish_date" class="date form-control" placeholder="'. ($_e['Leave Blank to publish now']) .'">
                    </div>
               </div>';



        //Banner
        if($this->functions->developer_setting('issues_image')=='1'){
            $img = "";
            if($data['image']!=''){
                $img=$data['image'];
                echo "<input type='hidden' name='oldImg' value='$img' />";
                echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Old Issues Image']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <img src="../images/'.$img.'" style="max-height:250px;" >
                    </div>
               </div>';
            }

            echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Issues Image (278x278 px)']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <input type="file" name="image" class="btn-file btn btn-primary">
                    </div>
               </div>';
        }else{ echo '<input type="hidden" name="image" value="" class="form-control">';}

        //echo '<input type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary"/>';
        echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _u($_e['SAVE']) .'</button>';

        echo "</div><!-- setting tabs end -->
        </div> <!-- tab-content end -->
    </div> <!-- container end -->
</form>";

    }
}
?>
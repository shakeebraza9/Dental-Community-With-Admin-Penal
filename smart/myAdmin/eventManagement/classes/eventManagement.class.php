<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class eventManagement extends object_class{
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
        $_w['Event Management'] = '' ;
        //filesManagerEdit.php
        $_w['Manage Event'] = '' ;

        //filesManager.php
        $_w['Active Event'] = '' ;
        $_w['Add Event'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Add New Event'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;
        $_w['There is an error, Please Refresh Page and Try Again'] = '' ;
        $_w['SNO'] = '' ;
        $_w['Event Title'] = '' ;
        $_w['IMAGE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Image Event Error'] = '' ;
        $_w['Image Not Found'] = '' ;
        $_w['Event'] = '' ;
        $_w['Added'] = '' ;
        $_w['Event Add Successfully'] = '' ;
        $_w['Event Add Failed'] = '' ;
        $_w['Event Update Failed'] = '' ;
        $_w['Event Update Successfully'] = '' ;
        $_w['Update'] = '' ;
        $_w['Event Title'] = '' ;
        $_w['File'] = '' ;
        $_w['Short Desc'] = '' ;
        $_w['Image Recommended Size : {{size}}'] = '' ;
        $_w['Publish'] = '' ;
        $_w['Layer'] = '' ;
        $_w['User'] = '' ;
        $_w['Select'] = '' ;
        $_w['SAVE'] = '' ;
        $_w['Old Event Image'] = '' ;
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
        $_w['Approved Event'] = '' ;
        $_w['Recurring Duration'] = '' ;
        $_w['Recurrence'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin eventManagement');

    }

    public function eventManagementView(){
        $sql  = "SELECT * FROM eventmanagement WHERE publish='1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $href = 'eventManagement/eventManagement_ajax.php?page=active_eventManagement';
        $this->eventManagementPrint($data,$href);

    }

    public function eventManagementDraft(){
        $sql  = "SELECT * FROM eventmanagement WHERE publish='0' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $href = 'eventManagement/eventManagement_ajax.php?page=draft_eventManagement';
        $this->eventManagementPrint($data,$href);

    }
    
    public function eventManagementPrint($data,$href){
        global $_e,$functions;
        $arry = array(39,51,41,42,38,54,55,56,64,59,81,134,83,137,74,139,140,156,249,147,4,141,143,142,146,148,149,173,78,151,233,153,154,86,90,89,256,285,260,262,170,264,175,43,123,176,132,177,105);
        $magic = '';
        $uniq=uniqid('id');
      

            echo  '
            <div class="table-responsive">
            <table class="table table-hover tableIBMS dTable_ajax " data-href="'.$href.'" data-uniq="'.$uniq.'">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['Event Title']) .'</th>
                        <th>'. _u($_e['Due Date']) .'</th>
                        <th>'. _u($_e['Recurring Duration']) .'</th>
                        <th>'. _u('Recurring Event') .'</th>
                        <th>'. _u($_e['Assign To']) .'</th>
                        <th>'. _u($_e['Category']) .'</th>
                        <th>'. _u($_e['Type']) .'</th>
                        <th>RADIO</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        foreach($data as $val){
            $i++;
            $id = $val['id'];
            $true = "";
            if(in_array($id, $arry)){
                $true = "<i class='glyphicon glyphicon-ok' style='color:green'></i>";
            }
            $uid = $val['assignto'];
            $RTitle = '('.$val['recurrence'].') - '.$functions->eventTitle($val['recurrence']);
            if($uid != 'all'){
            $sql = "SELECT acc_name FROM `accounts_user` WHERE acc_id= ?";
            $uid = $this->dbF->getRow($sql,array($uid));
            $uid = $uid['acc_name'];
            }
            // echo "<tr>
            //         <td>$id</td>
            //         <td>$val[title] $true</td>
            //         <td>$val[due_date]</td>
            //         <td>$val[recurring_duration]</td>
            //         <td>$RTitle</td>
            //         <td>$uid</td>
            //         <td>$val[category]</td>
            //         <td>$val[type]</td>
            //         <td>$val[radio]</td>
            //         <td>
            //             <div class='btn-group btn-group-sm'>
            //                 <a data-id='$id' href='-eventManagement?page=edit&eventId=$id' class='btn'>
            //                     <i class='glyphicon glyphicon-edit'></i>
            //                 </a>
            //                 <a data-id='$id' onclick='deleteeventManagement(this);' class='btn'>
            //                     <i class='glyphicon glyphicon-trash trash'></i>
            //                     <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
            //                 </a>
            //             </div>
            //         </td>
            //       </tr>";
        }
        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }
 
     public function editProductInformation(){
       if(isset($_POST[$this->prefix_editPro])){
           $this->editPid=$_POST[$this->prefix_editPro];
           $this->pid = $_POST[$this->prefix_editPro];
        }
       //  $this->editPid="491";
      //  $this->pid="491";
    }
    public function neweventManagementAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newEvent')){return false;}

            $title         = empty($_POST['title'])     ? ""    : $_POST['title'];
            $file          = empty($_POST['file'])      ? "#"   : $_POST['file'];
            $due_date      = empty($_POST['due_date'])  ? ""    : $_POST['due_date'];
            $publish       = empty($_POST['publish'])   ? "0"   : $_POST['publish'];
            $assignto      = empty($_POST['assignto'])  ? "all" : $_POST['assignto'];
            $category      = empty($_POST['category'])  ? ""    : $_POST['category'];
            $type          = empty($_POST['type'])      ? "recommended"    : $_POST['type'];
            $radio         = empty($_POST['radio'])     ? "no"  : $_POST['radio'];
            $desc          = empty($_POST['desc'])      ? ""    : $_POST['desc'];
            $recurring_duration          = empty($_POST['recurring_duration'])      ? ""    : $_POST['recurring_duration'];
            $recurrence    = empty($_POST['recurrence'])? ""    : $_POST['recurrence'];

htmlspecialchars($title);
htmlspecialchars($due_date);
htmlspecialchars($publish);
htmlspecialchars($category);
htmlspecialchars($type);
htmlspecialchars($radio);
htmlspecialchars($desc);
htmlspecialchars($recurring_duration);
htmlspecialchars($recurrence);


            try{
                $this->db->beginTransaction();

                $sql      =   "INSERT INTO `eventmanagement`(
                                    `title`, `due_date`,`recurring_duration`,`recurrence`, `file`,`assignto`,`category`,`type`,`radio`,`desc`,`publish`)
                                    VALUES (?,?,?,?,?,?,?,?,?,?,?)";

                $array   = array($title,$due_date,$recurring_duration,$recurrence,$file,$assignto,$category,$type,$radio,nl2br($desc),$publish);
                $this->dbF->setRow($sql,$array,false);
                $lastId = $this->dbF->rowLastId;

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Event']),($_e['Event Add Successfully']),'btn-success');
                    $this->functions->setlog("Event Add By Admin","Assignto : ".$assignto,"",$title);
                }else{
                    $this->functions->notificationError(_uc($_e['Event']),($_e['Event Add Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Event']),($_e['Event Add Failed']),'btn-danger');
            }
        } // If end
    }




    public function eventManagementEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('editEvent')){return false;}

            $title         = empty($_POST['title'])     ? ""    : $_POST['title'];
            $file          = empty($_POST['file'])      ? "#"    : $_POST['file'];
            $due_date      = empty($_POST['due_date'])  ? ""    : $_POST['due_date'];
            $publish       = empty($_POST['publish'])   ? "0"   : $_POST['publish'];
            $assignto      = empty($_POST['assignto'])  ? "all"    : $_POST['assignto'];
            $category      = empty($_POST['category'])  ? ""    : $_POST['category'];
            $type          = empty($_POST['type'])      ? "recommended"    : $_POST['type'];
            $radio         = empty($_POST['radio'])     ? "no"  : $_POST['radio'];
            $desc          = empty($_POST['desc'])      ? ""    : $_POST['desc'];
            $recurring_duration          = empty($_POST['recurring_duration'])      ? ""    : $_POST['recurring_duration'];
            $recurrence    = empty($_POST['recurrence'])? ""    : $_POST['recurrence'];

htmlspecialchars($title);
htmlspecialchars($due_date);
htmlspecialchars($publish);
htmlspecialchars($category);
htmlspecialchars($type);
htmlspecialchars($radio);
htmlspecialchars($desc);
htmlspecialchars($recurring_duration);
htmlspecialchars($recurrence);


            try{
                $this->db->beginTransaction();
                $lastId   =   $_POST['editId'];

                $sql    =  "UPDATE `eventmanagement` SET
                                    `title`=?,
                                    `due_date`=?,
                                    `file`=?,
                                    `type`=?,
                                    `radio`=?,
                                    `publish`=?,
                                    `assignto`=?,
                                    `category`=?,
                                    `desc`=?,
                                    `recurrence`=?,
                                    `recurring_duration`=?
                                       WHERE id = '$lastId'
                                ";

                $array   = array($title,$due_date,$file,$type,$radio,$publish,$assignto,$category,nl2br($desc),$recurrence,$recurring_duration);
                $this->dbF->setRow($sql,$array,false);

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Event']),($_e['Event Update Successfully']),'btn-success');
                    $this->functions->setlog("Event Update By Admin","Assignto : ".$assignto,"",$title);
                }else{
                    $this->functions->notificationError(_uc($_e['Event']),($_e['Event Update Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Event']),($_e['Event Update Failed']),'btn-danger');
            }

        }
    }

    public function eventManagementNew(){
        global $_e;
        $this->eventManagementEdit(true);
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

public function allEvents() {
$sql  = "SELECT `id`,`title` FROM `eventmanagement` ORDER BY `title`";
$data = $this->dbF->getRows($sql);
$opt  = '';
foreach ($data as $value){
$opt .= '<option value="'.$value['id'].'">'.$value['id'].'-'.$value['title'].'</option>';
}
return $opt;
}


    public function eventManagementEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newEvent',false);
        }else {
            $id = $_GET['eventId'];
             $editId = $_GET['eventId'];
            /// $editId=$editeventManagement->eventManagementid;
            $sql = "SELECT * FROM eventmanagement where id = ? ";
            $data = $this->dbF->getRow($sql,array($id));

            $token = $this->functions->setFormToken('editEvent', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
        }

        $size = $this->functions->developer_setting('file_size');
        //No need to remove any thing,, go in developer setting table and set 0

        echo '<form method="post" action="-eventManagement?page=eventManagement" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

        @$title     = $data['title'];
        @$desc      = $data['desc'];
        @$due_date  = $data['due_date'];
        @$publish   = $data['publish'];
        @$category  = $data['category'];
        @$file      = $data['file'];
        @$assignto  = $data['assignto'];
        @$type      = $data['type'];
        @$radio     = $data['radio'];
        @$recurring_duration      = $data['recurring_duration'];
        @$recurrence = $data['recurrence'];

        //Title
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Event Title']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="text" name="title" value="'.@$title.'" class="form-control" placeholder="'. _uc($_e['Event Title']) .'" required>
                        </div>
                    </div>';

        //Date
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Due Date']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="date" name="due_date" value="'.@$due_date.'" class="form-control" placeholder="'. _uc($_e['Due Date']) .'" required>
                        </div>
                    </div>';

                    $option = $this->allEvents();
                    $dsply = 'style="display:none"';
                    if(@$recurring_duration == 'Once'){$dsply = 'style="display:block"';}
        //Recurring Duration
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Recurring Duration']) .'</label>
                        <div class="col-sm-10  col-md-9">
                        <select class="form-control recurring_duration"  name="recurring_duration">
                            <option value="Once Check">Once Check</option>
                            <option value="Once">Once</option>
                            <option value="No Recurrence">No Recurrence</option>
                            <option value="1 day">1 day</option>
                            <option value="1 week">1 week</option>
                            <option value="2 weeks">2 weeks</option>
                            <option value="3 weeks">3 weeks</option>
                            <option value="1 Month">1 Month</option>
                            <option value="2 Months">2 Months</option>
                            <option value="3 Months">3 Months</option>
                            <option value="4 Months">4 Months</option>
                            <option value="6 Months">6 Months</option>
                            <option value="12 Months">12 Months</option>
                            <option value="24 Months">24 Months</option>
                            <option value="36 Months">36 Months</option>
                            <option value="60 Months">60 Months</option>
                        </select>
                        <script>$(".recurring_duration").val("'.@$recurring_duration.'").change();</script>
                        </div>
                        <br><br>
                        <div class="rd" '.$dsply.'>
                        <label class="col-sm-2 col-md-3  control-label">Substitute</label>
                        <div class="col-sm-10  col-md-9">
                        <select class="form-control recurrence"  name="recurrence">
                        '.$option.'
                        </select>
                        <script>$(".recurrence").val("'.@$recurrence.'").change();</script>
                        </div>
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
        $slt = '';
        $dspy = 'style="display:none"';
        if(@$assignto!='all' && @$assignto!=''){$checked='checked'; $dspy='style="display:block"'; $slt='name="assignto"';}
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
<select class="users form-control" '.$slt.'>
'.$option.'
</select>
</div>
</div>
<script>$(".users").val("'.@$assignto.'").change();</script>';
            
        //Type    
        $checked = "";
        if(@$type=='mandatory'){$checked='checked';}
         //Type    
        $checked = "";
        //if(@$type=='mandatory'){$checked='checked';}
         echo '<div class="form-group" >
       <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Type']) .'</label>
        <div class="col-sm-10  col-md-9">
           <select name="type" class="form-control type" required>
          <option value="recommended">Recommended</option>
          <option value="mandatory">Mandatory</option>
          <option value="updates">Updates</option>
          </select>
          </div>
          </div>
<script>$(".type").val("'.@$type.'").change();
$("select option[value='.@$type.']").attr("selected","selected");
</script>';
 
        
$option = $this->functions->eventCategory();
// select category
        echo '<div class="form-group" >
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Category']) .'</label>
<div class="col-sm-10  col-md-9">
<select name="category" class="form-control categ" required>
'.$option.'
</select>
</div>
</div>
<script>$(".categ").val("'.@$category.'").change();</script>';
 
 //Description
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Description']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <textarea name="desc" class="form-control" placeholder="'. _uc($_e['Description']) .'">'.@$desc.'</textarea>
                        </div>
                    </div>';

        //Radio
        $checked = "";
        if(@$radio=='Yes'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">Radio</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="Yes" data-off-label="No">
                            <input type="checkbox" name="radio" value="Yes" '.$checked.'>
                        </div>
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
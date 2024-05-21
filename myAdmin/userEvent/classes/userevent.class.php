<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class userevent extends object_class{
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
        $_w['Approved Event'] = '' ;
        $_w['Due Date'] = '' ;
        $_w['Completion Date'] = '' ;
        $_w['User Type'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin userevent');

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
$sql  = "SELECT `setting_val` FROM `ibms_setting` WHERE  `setting_name`='eventcategory'";
$data = $this->dbF->getRow($sql);
$opt  = '';
$data =explode(",", $data[0]);
foreach ($data as $val){
$opt        .= '<option value="'.$val.'">'.$val.'</option>';
}
return $opt;
}


    public function usereventView(){
        $sql  = "SELECT * FROM userevent WHERE approved='1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
         $href = 'userEvent/userevent_ajax.php?page=active_userEvent';
        $this->usereventPrint($data,$href);
    }

    public function usereventDraft(){
        $sql  = "SELECT * FROM userevent WHERE approved='0' OR approved='-1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
         $href = 'userEvent/userevent_ajax.php?page=draft_userEvent';
        $this->usereventPrint($data,$href);
    }

    public function titleName($id){
        $sql  = "SELECT title FROM eventmanagement WHERE id= ? ";
        $data =  $this->dbF->getRow($sql,array($id));
        return $data[0];
    }
    public function UserType($id){
        $sql = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_type' AND `id_user`= ? ";
        $data = $this->dbF->getRow($sql,array($id));
        return $data[0];
    }
    public function usereventPrint($data,$href){
        global $_e;
       $uniq=uniqid('id');
       
       
   
            echo  '
            <div class="table-responsive">
            <table class="table table-hover tableIBMS dTable_ajax " data-href="'.$href.'" data-uniq="'.$uniq.'">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['User']) .'</th>
                        <th>'. _u($_e['User Type']) .'</th>
                        <th>'. _u($_e['Event Title']) .'</th>
                        <th>'. _u($_e['Due Date']) .'</th>
                        <th>'. _u($_e['Completion Date']) .'</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        // foreach($data as $val){
        //     $i++;
        //     $id = $val['id'];
        //     $uid = $val['user'];
        //     $sql = "SELECT acc_name FROM `accounts_user` WHERE acc_id='$uid'";
        //     $uid = $this->dbF->getRow($sql); 

        //     $uid = $uid['acc_name'];
               
        //     $usertype = $this->UserType($val['user']);
        //   // var_dump($usertype);
        //     $ddate = date("d-M-Y",strtotime($val['due_date']));
        //     if(empty($val['due_date'])){
        //         $ddate = 'N/A';
        //     }
        //     if(empty($val['dateTime'])){
        //         $cdate = 'N/A';
        //     }
        //     else{
        //         $cdate = date("d-M-Y",strtotime($val['dateTime']));
        //     }
        //     echo "<tr>
        //             <td>$i</td>
        //             <td>$uid</td>
        //             <td>".$usertype."</td>
        //             <td>".$this->titleName($val['title_id'])."</td>
        //             <td>$ddate</td>
        //             <td>$cdate</td>
        //             <td>
        //                 <div class='btn-group btn-group-sm'>
        //                     <a data-id='$id' href='-userEvent?page=edit&eventId=$id' class='btn'>
        //                         <i class='glyphicon glyphicon-edit'></i>
        //                     </a>
        //                     <a data-id='$id' onclick='deleteuserevent(this);' class='btn'>
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
    public function event(){
        $sql = "SELECT * FROM eventmanagement ORDER BY title";
        $data = $this->dbF->getRows($sql);
        $opt  = '';
foreach ($data as $val){
$opt        .= '<option value="'.$val["id"].'">'.$val["title"].'</option>';
}
return $opt;
    }

     public function usereventNew(){
        global $_e;
        $this->usereventEdit(true);
    }

    public function usereventEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newEvent',false);
            $date = date('Y-m-d');
        }else {
            $id = $_GET['eventId'];
            $sql = "SELECT * FROM userevent where id = ?  ";
            $data = $this->dbF->getRow($sql,array($id) );
            @$title_id  = $data['title_id'];
            @$desc      = $data['desc'];
            @$ddate      = date('d-M-Y',strtotime($data['due_date']));
            if(empty($data['due_date'])){
                @$ddate = "";
            }
            @$cdate      = date('d-M-Y',strtotime($data['dateTime']));
            if(empty($data['dateTime'])){
                @$cdate = "";
            }
            @$file      = $data['file'];
            @$user      = $data['user'];
            @$publish   = $data['approved'];

            $token = $this->functions->setFormToken('editEvent', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
        }

        $size = $this->functions->developer_setting('file_size');
        //No need to remove any thing,, go in developer setting table and set 0

        echo '<form method="post" action="-userEvent?page=userevent" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

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
<label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Event Title']) .'</label>
<div class="col-sm-10  col-md-9">
<select name="title_id" class="form-control event" required>
'.$option.'
</select>
</div>
</div>
<script>$(".event").val("'.@$title_id.'").change();</script>';
        
        if(!$new){
            echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['File']) .'</label>
                        <div class="col-sm-10  col-md-9">';
                        $doc = explode(",", $file);
                        foreach ($doc as $key => $value) {
                            echo'<div class="input-group">
                                 <input type="text"  name="file[]" value="'.$value.'" class="layer1 form-control" placeholder="">
                                 <div class="input-group-addon pointer " onclick="'."openKCFinderFile($('.layer1'))".'"><i class="glyphicon glyphicon-file"></i></div>
                             </div>';
                        }
                             echo'
                             <div class="add-file"></div>
                             <a href="javascript:;" class="add-file-btn btn btn-primary btn-sm">Add More Files</a>
                        </div>
                    </div>';
        }
        else{
        //File
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['File']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <div class="input-group">
                                 <input type="text"  name="file[]" class="layer1 form-control" placeholder="">
                                 <div class="input-group-addon pointer " onclick="'."openKCFinderFile($('.layer1'))".'"><i class="glyphicon glyphicon-file"></i></div>
                             </div>
                             <div class="add-file"></div>
                             <a href="javascript:;" class="add-file-btn btn btn-primary btn-sm">Add More Files</a>
                        </div>
                    </div>';
        }
        //Description
                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Description']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <textarea name="desc" class="form-control" placeholder="'. _uc($_e['Description']) .'">'.@$desc.'</textarea>
                        </div>
                    </div>';

                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Due Date']) .'</label>
                        <div class="col-sm-10  col-md-9">
                                 <input type="text"  name="ddate" class="form-control date" value="'.@$ddate.'">
                        </div>
                    </div>';

                echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Completion Date']) .'</label>
                        <div class="col-sm-10  col-md-9">
                                 <input type="text"  name="cdate" class="form-control date" value="'.@$cdate.'">
                        </div>
                    </div>';

        // Approved
        $checked = "";
        if(@$publish=='1'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Approved']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Yes']) .'" data-off-label="'. _uc($_e['No']) .'">
                            <input type="checkbox" name="approved" value="1" '.$checked.'>
                        </div>
                    </div>
               </div>';

        echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _uc($_e['SAVE']) .'</button>';

        echo "</div>
             </form>";
    }

 public function newusereventAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newEvent')){return false;}

            $title_id = empty($_POST['title_id'])  ? ""    : $_POST['title_id'];
            $desc     = empty($_POST['desc'])      ? ""    : $_POST['desc'];
            $user     = empty($_POST['user'])      ? ""    : $_POST['user'];
            $approved = empty($_POST['approved'])  ? "-1"  : $_POST['approved'];
            $ddate    = empty($_POST['ddate'])     ? date('Y-m-d')    : $_POST['ddate'];
            $cdate    = empty($_POST['cdate'])     ? date('Y-m-d')    : $_POST['cdate'];
            $file     = empty($_POST['file'])      ? "#"    : implode(',',$_POST['file']);
            $file     = rtrim($file, ',');
            
htmlspecialchars($title_id);
htmlspecialchars($desc);
htmlspecialchars($user);
htmlspecialchars($approved);
htmlspecialchars($ddate);
htmlspecialchars($cdate);

            try{
                $this->db->beginTransaction();

                $sql      =   "INSERT INTO `userevent`(`user`,`title_id`,`file`,`approved`,`desc`,`due_date`,`dateTime`) VALUES (?,?,?,?,?,?,?)";

                $array   = array($user,$title_id,$file,$approved,nl2br($desc),$ddate,$cdate);
                $this->dbF->setRow($sql,$array,false);
                $lastId = $this->dbF->rowLastId;

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Event']),($_e['Event Add Successfully']),'btn-success');
                    $title = $this->functions->eventTitle($title_id);
                    if($approved == 1){
                    $this->functions->setlog("Event Approved by Admin",$this->functions->userName($user)." : $user","",$title." : ".$title_id);
                    } else{
                        $this->functions->setlog("Event Create by Admin",$this->functions->userName($user)." : $user","",$title." : ".$title_id);
                    }
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
 
 public function userEmail($id){
    $sql = "SELECT acc_email FROM accounts_user WHERE acc_id= ? ";
    $data = $this->dbF->getRow($sql,array($id));
    return $data[0];
 }

 public function eventTitle($id){
    $sql = "SELECT title FROM eventmanagement WHERE id= ? ";
    $data = $this->dbF->getRow($sql,array($id));
    return $data[0];
 }

 public function usereventEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('editEvent')){return false;}

            $title_id = empty($_POST['title_id'])  ? ""    : $_POST['title_id'];
            $desc     = empty($_POST['desc'])      ? ""    : $_POST['desc'];
            $user     = empty($_POST['user'])      ? ""    : $_POST['user'];
            $approved = empty($_POST['approved'])  ? "-1"   : $_POST['approved'];
            $ddate     = empty($_POST['ddate'])    ? date('Y-m-d')    : date('Y-m-d',strtotime($_POST['ddate']));
            $cdate     = empty($_POST['cdate'])    ? date('Y-m-d')    : date('Y-m-d',strtotime($_POST['cdate']));
            $file     = empty($_POST['file'])      ? "#"    : implode(',',$_POST['file']);
            $file     = rtrim($file, ',');
              
htmlspecialchars($title_id);
htmlspecialchars($desc);
htmlspecialchars($user);
htmlspecialchars($approved);
htmlspecialchars($ddate);
htmlspecialchars($cdate);
htmlspecialchars($file);
htmlspecialchars($file);

            try{
                $this->db->beginTransaction();
                $lastId   =   intval($_POST['editId']);

                $sql    =  "UPDATE `userevent` SET
                                    `title_id`=?,
                                    `file`=?,
                                    `user`=?,
                                    `approved`=?,
                                    `desc`=?,
                                    `due_date`=?,
                                    `dateTime`=?
                                    WHERE id = '$lastId'
                                ";

                $array   = array($title_id,$file,$user,$approved,nl2br($desc),$ddate,$cdate);
                $this->dbF->setRow($sql,$array,false);

                // if($DueDate == 'Once'){
                //     $sql = "SELECT * FROM `eventmanagement` WHERE `id`=(SELECT `recurrence` FROM `eventmanagement` WHERE `id`='$title_id')";
                //     $data = $this->dbF->getRow($sql);
                //     $title_id = $data['id'];
                //     $DueDate = Date('Y-m-d',strtotime('+'.$data['recurring_duration']));
                // }

                // if($approved == 1){
                // $sql      =   "INSERT INTO `userevent`(`user`,`title_id`,`due_date`) VALUES (?,?,?)";
                // $array   = array($user,$title_id,$DueDate);
                // $this->dbF->setRow($sql,$array,false);
                // }

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Event']),($_e['Event Update Successfully']),'btn-success');
                        // if($approved == 1){
                        //     $this->functions->send_mail($email,$title,'Your Event Approved');
                        // }
                    $title = $this->functions->eventTitle($title_id);
                    if($approved == 1){
                    $this->functions->setlog("Event Approved by Admin",$this->functions->userName($user)." : $user","",$title." : ".$title_id);
                    } else{
                        $this->functions->setlog("Event Denied by Admin",$this->functions->userName($user)." : $user","",$title." : ".$title_id);
                    }
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

}
?>
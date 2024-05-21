<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class rota extends object_class{
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
        $_w['Rota Management'] = '' ;
        //filesManagerEdit.php
        $_w['Manage Shift'] = '' ;

        //filesManager.php
        $_w['Shift'] = '' ;
        $_w['Draft'] = '' ;
        $_w['Add New Shift'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;
        $_w['There is an error, Please Refresh Page and Try Again'] = '' ;
        $_w['SNO'] = '' ;
        $_w['Shift Name'] = '' ;
        $_w['Dentist Name'] = '' ;
        $_w['IMAGE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Image Event Error'] = '' ;
        $_w['Image Not Found'] = '' ;
        $_w['Event'] = '' ;
        $_w['Added'] = '' ;
        $_w['Shift Add Successfully'] = '' ;
        $_w['Shift Add Failed'] = '' ;
        $_w['Shift Update Failed'] = '' ;
        $_w['Shift Update Successfully'] = '' ;
        $_w['Update'] = '' ;
        $_w['Time From'] = '' ;
        $_w['Break'] = '' ;
        $_w['Image Recommended Size : {{size}}'] = '' ;
        $_w['Publish'] = '' ;
        $_w['Color'] = '' ;
        $_w['Time To'] = '' ;
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
        $_w['Shift'] = '' ;
        $_w['Date'] = '' ;
        $_w['Rota'] = '' ;
        $_w['Manage Rota'] = '' ;
        $_w['Date'] = '' ;
        $_w['Name'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin userevent');

    }

    public function shiftView(){
        $sql  = "SELECT * FROM shift WHERE publish='1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->shiftPrint($data);
    }

    public function shiftDraft(){
        $sql  = "SELECT * FROM shift WHERE publish='0' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->shiftPrint($data);
    }

    public function titleName($id){
        $sql  = "SELECT title FROM eventmanagement WHERE id='$id'";
        $data =  $this->dbF->getRow($sql);
        return $data[0];
    }
      
    public function shiftPrint($data){
        global $_e;
        echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['Shift Name']) .'</th>
                        <th>'. _u($_e['Dentist Name']) .'</th>
                        <th>'. _u($_e['Time From']) .'</th>
                        <th>'. _u($_e['Time To']) .'</th>
                        <th>'. _u($_e['Break']) .'</th>
                        <th>'. _u($_e['Color']) .'</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        foreach($data as $val){
            $i++;
            $id = $val['id'];
            echo "<tr>
                    <td>$i</td>
                    <td>$val[shift_name]</td>
                    <td>".$this->functions->Username($val['dentist_id'])."</td>
                    <td>$val[timefrom]</td>
                    <td>$val[timeto]</td>
                    <td>$val[break]</td>
                    <td><div style='background-color:$val[color];height: 30px;width: 50px;display: block;margin: auto;'></div></td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-id='$id' href='-rota?page=edit&shiftId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>
                            <a data-id='$id' onclick='deleteshift(this);' class='btn'>
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

    public function allPractice($id = null){
        $sql  = "SELECT acc_id,acc_name,acc_email FROM accounts_user WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val` IN ('Practice','Master') ) ORDER BY acc_name ASC";
        $data =  $this->dbF->getRows($sql);
        $option = "";
        foreach($data as $key=>$val){
            if($val['acc_id'] == $id){
                $option .= "<option selected value='$val[acc_id]'>$val[acc_name] -- ($val[acc_email])</option>";             
            }
            else{
                $option.= "<option value='$val[acc_id]'>$val[acc_name] -- ($val[acc_email])</option>";
            }
        }
        return $option;
    }

    public function webUserInfoArray($data,$settingName){
        foreach($data as $val){
            if($val['setting_name']==$settingName){
                return $val['setting_val'];
            }
        }
        return "";
    }

    public function staffArrayByDate($data,$userId,$date,$get){
        foreach($data as $val){
            $tDate = $val['date'];
            if($val['date'] == $date && $val['userId'] ==$userId){
                return $val[$get];
            }
            if($date == '' && $val['userId'] ==$userId){
                return $val[$get];
            }
        }
        return "0";
    }

    public function branchWagesForm($weekly=false)
    {
        $form_fields = array();

         $form_fields[] = array(
            'name'  => 'page',
            'value' => $_GET['page'],
            'type'  => 'hidden',
        );

        $form_fields[] = array(
            'label' => "Date From",
            'name'  => "from",
            'value' => @$_GET['from'],
            'type'  => 'text',
            'class' => 'form-control from',
            'required' => 'true'
        );
        $form_fields[] = array(
            'label' => "Date To",
            'name'  => "to",
            'value' => @$_GET['to'],
            'type'  => 'text',
            'class' => 'form-control to',
            'required' => 'true'
        );

        $form_fields[] = array(
            'label' => "Select Practice",
            'name'  => "pId",
            'option' => $this->allPractice(@$_GET['pId']),
            'type'  => 'select',
            'class' => 'form-control',
            'required' => 'true'
        );

        $form_fields[]  = array(
            'label' => "",
            "name"  => 'submit',
            'class' => 'btn btn-primary',
            'type'  => 'submit',
            'value' => "Submit",
        );

        $form_fields['form']  = array(
            'type'     => 'form',
            'class'    => "form-horizontal",
            'action'   => '-rota?',
            'method'   => 'get',
            'format'   => '{{form}}'
        );


        $format = '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">{{label}}</label>
                        <div class="col-sm-10  col-md-9">
                            {{form}}
                        </div>
                    </div>';

        $this->functions->print_form($form_fields,$format);
    }

    public function rotaPrint(){
        $branchId   = '0';
        $from       = $_GET['from'];
        $to         = $_GET['to'];
        $pId         = $_GET['pId'];

        // $sql        = "SELECT hour as cnt,rotaOff,timeFrom,timeTo,userId,branch,date,
        //                 (SELECT acc_name FROM accounts_user as b WHERE b.acc_id=a.userId) as user
        //                  FROM record as a WHERE branch = '$branchId'  AND a.date BETWEEN '$from' AND '$to' ORDER BY date ASC";
        $sql        = "SELECT `hour` as `cnt`,
        `rotaOff`,
        `timeFrom`,
        `timeTo`,
        `breakTime`,`dentist_id`,`rotaComment`,`userId`,
        `branch`,`date`,
            (SELECT `acc_name` FROM `accounts_user` as `b` 
            WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
            (SELECT `acc_image` FROM `accounts_user` as `b` 
            WHERE `b`.`acc_id`=`a`.`userId`) as `image` 
            FROM `record` as `a` 
            WHERE `branch` = '$branchId'  
            AND `a`.`date` BETWEEN '$from' AND '$to'
            AND  (`a`.`userId` ='$pId' OR `a`.`userId` IN 
                (SELECT `id_user` FROM `accounts_user_detail` 
                WHERE `setting_val`='$pId')) 
                ORDER BY `a`.`userId`,`date` ASC";
        $data = $this->dbF->getRows($sql);

        //get all dates
        $dates = array();
        $total = array();
        $staffs = array();
        foreach($data as $val){
            $dates[$val['date']] = $val['date'];
            $total[$val['date']] = 0;
        }
        foreach ( $data as $val ) {
            $staffs[$val['userId']] = $data;
        }

        echo '<div class="table-responsive">
                <table class="table table-hover dTable2 tableIBMS">
                    <thead>
                        <th>SNO</th>
                        <th>NAME</th>';

        foreach ($dates as $val2) {
            $day = date('l',strtotime($val2));
            $val2 = date("d-M-Y",strtotime($val2));
            echo "<th>$val2 <br> $day</th>";
        }

        echo '<th>Delete</th></thead>
                <tbody>';
        $i  = 0;
        foreach($staffs as $key=>$val) {
            $i++;
            $userId = $key;
            $name   = $this->staffArrayByDate($val,$userId,'','user');

            echo "<tr>
                    <td>$i</td>
                    <td>$name</td>";

            foreach ( $dates as $val2 ) {
                $date  = $val2;
                $hours = $this->staffArrayByDate($val,$userId,$date,'cnt');
                $time = $this->staffArrayByDate($val,$userId,$date,'timeFrom');
                $timeFrom =  !empty($time) ? $time : "00:00";
                $time = $this->staffArrayByDate($val,$userId,$date,'timeTo');
                $timeTo   =  !empty($time) ? $time: "00:00";
                $holiday = $this->staffArrayByDate($val,$userId,$date,'rotaOff');
                if(!empty($holiday)){
                    $holiday = "<div class='btn btn-danger btn-xs no-wrap'>$holiday</div>";
                }else{
                    $holiday = ' &nbsp; ' ;
                }

                $tempT = "<div class='no-wrap clearfix padding-0'>
                              $holiday
                          </div>
                          <div class='no-wrap col-xs-12 padding-0'>
                               <div class='btn btn-default btn-xs no-wrap' style='width:43px;'>$timeFrom</div>
                               -
                               <div class='btn btn-default btn-xs no-wrap' style='width:43px;'>$timeTo</div>
                          </div>
                          <br>
                          <div class='btn btn-default btn-xs no-wrap margin-5' style='width:90px;'>$hours</div>";

                echo "<td>$tempT</td>";
            }

            echo "<td>
                    <div class='btn-group btn-group-sm'>
                        <a data-id='$userId' data-from='$from' data-to='$to' onclick='deleterota(this);' class='btn'>
                            <i class='glyphicon glyphicon-trash trash'></i>
                            <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                        </a>
                    </div>
                </td></tr>";
        }

                echo "</tr>
                    </tbody>
                </table>
            </div> <!-- .table-responsive End -->";
    }

    public function Dentist($id){
        $sql = "SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val` IN ('Dentist','Dental Hygienist and Dental Therapist')) AND acc_type='1'";
        $data = $this->dbF->getRows($sql);
        $op = "";
        foreach ($data as $key => $value) {
            $name = $this->functions->UserName($value['acc_id']);
            if($value['acc_id'] == $id){
                $op .= "<option selected value='$value[acc_id]'>$name</option>";             
            }
            else{
                $op .= "<option value='$value[acc_id]'>$name</option>";
            }
        }
        return $op;
    }

    public function shiftNew(){
        global $_e;
        $this->shiftEdit(true);
    }

    public function shiftEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newShift',false);
        }else {
            $id = $_GET['shiftId'];
            $sql = "SELECT * FROM shift where id = '$id' ";
            $data = $this->dbF->getRow($sql);
            @$shift_name = $data['shift_name'];
            @$timefrom   = $data['timefrom'];
            @$timeto     = $data['timeto'];
            @$break      = $data['break'];
            @$dentist_id = $data['dentist_id'];
            @$color      = $data['color'];
            @$publish    = $data['publish'];

            $token = $this->functions->setFormToken('editShift', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
        }

        echo '<form method="post" action="-rota?page=addshift" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

        echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Shift Name']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="text" name="shift_name" class="form-control" value="'.@$shift_name.'">
                        </div>
                    </div>';

        echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Dentist Name']) .'</label>
                        <div class="col-sm-10  col-md-9">
                        <select name="dentist_name" class="form-control">
                            '.$this->Dentist(@$dentist_id).'
                        </select>
                        </div>
                    </div>';

        echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Time From']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="time" name="timefrom" class="form-control" value="'.@$timefrom.'">
                        </div>
                    </div>';

        echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Time To']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="time" name="timeto" class="form-control" value="'.@$timeto.'">
                        </div>
                    </div>';

        echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Break']) .'</label>
                        <div class="col-sm-10  col-md-9">
                            <input type="time" name="break" class="form-control" value="'.@$break.'">
                        </div>
                    </div>';

         echo '<div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Color']) .'</label>
                        <div class="col-sm-10  col-md-1">
                            <input type="color" name="color" class="form-control" value="'.@$color.'">
                        </div>
                    </div>';                
        // Approved
        $checked = "";
        if(@$publish=='1'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">'. _uc($_e['Publish']) .'</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Yes']) .'" data-off-label="'. _uc($_e['No']) .'">
                            <input type="checkbox" name="publish" value="1" '.$checked.'>
                        </div>
                    </div>
               </div>';

        echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _uc($_e['SAVE']) .'</button>';

        echo "</div>
             </form>";
    }

 public function newshiftAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newShift')){return false;}

            $shift_name      = empty($_POST['shift_name'])     ? ""    : $_POST['shift_name'];
            $timefrom  = empty($_POST['timefrom']) ? ""    : $_POST['timefrom'];
            $timeto    = empty($_POST['timeto'])   ? ""    : $_POST['timeto'];
            $break     = empty($_POST['break'])    ? ""    : $_POST['break'];
            $dentist_name     = empty($_POST['dentist_name'])    ? ""    : $_POST['dentist_name'];
            $color     = empty($_POST['color'])    ? ""    : $_POST['color'];
            $publish   = empty($_POST['publish'])  ? "0"   : $_POST['publish'];
            try{
                $this->db->beginTransaction();

                $sql      =   "INSERT INTO `shift`(`shift_name`,`dentist_id`,`timefrom`,`timeto`,`break`,`color`,`publish`) VALUES (?,?,?,?,?,?,?)";

                $array   = array($shift_name,$dentist_name,$timefrom,$timeto,$break,$color,$publish);
                $this->dbF->setRow($sql,$array,false);
                $lastId = $this->dbF->rowLastId;

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Shift']),($_e['Shift Add Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Added']),_uc($_e['Shift']),$lastId,($_e['Shift Add Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Shift']),($_e['Shift Add Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Shift']),($_e['Shift Add Failed']),'btn-danger');
            }
        } // If end
    }

 public function shiftEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('editShift')){return false;}

            $shift_name       = empty($_POST['shift_name'])     ? ""    : $_POST['shift_name'];
            $dentist_name     = empty($_POST['dentist_name'])    ? ""    : $_POST['dentist_name'];
            $timefrom  = empty($_POST['timefrom']) ? ""    : $_POST['timefrom'];
            $timeto    = empty($_POST['timeto'])   ? ""    : $_POST['timeto'];
            $break     = empty($_POST['break'])    ? ""    : $_POST['break'];
            $color     = empty($_POST['color'])    ? ""    : $_POST['color'];
            $publish   = empty($_POST['publish'])  ? "0"   : $_POST['publish'];
                
            try{
                $this->db->beginTransaction();
                $lastId   =   $_POST['editId'];

                $sql    =  "UPDATE `shift` SET
                                    `shift_name`=?,
                                    `dentist_id`=?,
                                    `timefrom`=?,
                                    `timeto`=?,
                                    `break`=?,
                                    `color`=?,
                                    `publish`=?
                                    WHERE id = '$lastId'
                                ";

                $array   = array($shift_name,$dentist_name,$timefrom,$timeto,$break,$color,$publish);
                $this->dbF->setRow($sql,$array,false);

                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Shift']),($_e['Shift Update Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Update']),_uc($_e['Shift']),$lastId,($_e['Shift Update Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Shift']),($_e['Shift Update Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Shift']),($_e['Shift Update Failed']),'btn-danger');
            }

        }
    }

}
?>
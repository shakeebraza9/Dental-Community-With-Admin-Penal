<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class eventForm extends object_class{
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
        $_w['Event Forms'] = '' ;
        //filesManagerEdit.php
        $_w['Manage Event Forms'] = '' ;

        //filesManager.php
        $_w['Active Event'] = '' ;
        $_w['Draft Event Forms'] = '' ;
        $_w['Add New Event Forms'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;
        $_w['There is an error, Please Refresh Page and Try Again'] = '' ;
        $_w['SNO'] = '' ;
        $_w['Event Title'] = '' ;
        $_w['IMAGE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Image Event Forms  Error'] = '' ;
        $_w['Image Not Found'] = '' ;
        $_w['Event Forms'] = '' ;
        $_w['Added'] = '' ;
        $_w['Event Forms Add Successfully'] = '' ;
        $_w['Event Forms Add Failed'] = '' ;
        $_w['Event Forms Update Failed'] = '' ;
        $_w['Event Forms Update Successfully'] = '' ;
        $_w['Update'] = '' ;
        $_w['File'] = '' ;
        $_w['Short Desc'] = '' ;
        $_w['Image Recommended Size : {{size}}'] = '' ;
        $_w['Publish'] = '' ;
        $_w['Layer'] = '' ;
        $_w['User'] = '' ;
        $_w['Select'] = '' ;
        $_w['SAVE'] = '' ;
        $_w['Old Event Forms Image'] = '' ;
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
        $_w['Active Event Forms'] = '' ;
        $_w['Completion Date'] = '' ;
        $_w['Expiry Date'] = '' ;
        $_w['Training'] = '' ;
        $_w['Documents'] = '' ;
        $_w['Type'] = '' ;
        $_w['Add Event Forms'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin eventForm');

    }

 public function eventFormView(){
        $sql  = "SELECT * FROM eventForms WHERE publish='1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $href = 'eventForm/eventForm_ajax.php?page=active_eventForm';
        $this->eventFormPrint($data,$href);
    }

    public function eventFormDraft(){
        $sql  = "SELECT * FROM eventForms WHERE publish='0' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
         $href = 'eventForm/eventForm_ajax.php?page=draft_eventForm';
        $this->eventFormPrint($data,$href);
    }

    public function titleName($id){
        $sql  = "SELECT title FROM eventmanagement WHERE id= ? ";
        $data =  $this->dbF->getRow($sql,array($id));
        return $data[0];
    }
      
    public function eventFormPrint($data,$href){
        global $_e;
       $uniq=uniqid('id');
        global $_e;
       $uniq=uniqid('id');
       
         echo  '
            <div class="table-responsive">
            <table class="table table-hover tableIBMS  dTable_ajax " data-href="'.$href.'" data-uniq="'.$uniq.'">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['Event Title']) .'</th>
                        <th>CATEGORY</th>
                        <th>QUESTION</th>
                        <th>RADIO</th>
                        <th>DATE</th>
                        <th>TIME</th>
                        <th>FIELDS</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        // foreach($data as $val){
        //     $i++;
        //     $id = $val['id'];
        //     $download = '';
        //     echo "<tr>
        //             <td>$i</td>
        //             <td>".$this->titleName($val['title_id'])."</td>
        //             <td>$val[category]</td>
        //             <td>$val[question]</td>
        //             <td>$val[radio]</td>
        //             <td>$val[date]</td>
        //             <td>$val[time]</td>
        //             <td>$val[field1],$val[field2]</td>
        //             <td>
        //                 <div class='btn-group btn-group-sm'>
        //                     <a data-id='$id' href='-eventForm?page=edit&eventId=$id' class='btn'>
        //                         <i class='glyphicon glyphicon-edit'></i>
        //                     </a>
        //                     <a data-id='$id' onclick='deleteeventForm(this);' class='btn'>
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
        $sql  = "SELECT * FROM eventmanagement ORDER BY title";
        $data = $this->dbF->getRows($sql);
        $opt  = '';
        foreach ($data as $val){
            $opt .= '<option value="'.$val["id"].'">'.$val["title"].' -- '._uc($val["type"]).'</option>';
        }
        return $opt;
    }

     public function eventFormNew(){
        global $_e;
        $this->eventFormEdit(true);
    }

    public function eventFormEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newusertraining',false);
            $date = date('Y-m-d');
        }else {
            $id = $_GET['eventId'];
            $sql = "SELECT * FROM eventForms where id =  ? ";
            $data = $this->dbF->getRow($sql,array($id));
            @$title_id  = $data['title_id'];
            @$question  = $data['question'];
            @$category  = $data['category'];
            @$radio     = $data['radio'];
            @$publish   = $data['publish'];
            @$field1    = $data['field1'];
            @$field2    = $data['field2'];
            @$date      = $data['date'];
            @$time      = $data['time'];

            $token = $this->functions->setFormToken('editusertraining', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
        }

        $size = $this->functions->developer_setting('file_size');
        //No need to remove any thing,, go in developer setting table and set 0

        echo '<form method="post" action="-eventForm?page=eventForm" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

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
            
            //Category
            echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Category</label>
                    <div class="col-sm-10  col-md-9">
                        <input name="category" class="form-control" placeholder="Category" value="'.@$category.'">
                    </div>
                </div>';

            //Question
            echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Question</label>
                    <div class="col-sm-10  col-md-9">
                        <textarea name="question" class="form-control" placeholder="Question">'.@$question.'</textarea>
                    </div>
                </div>';

        //Radio
        $checked = "";
        if(@$radio=='Radio'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">Radio</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Yes']) .'" data-off-label="'. _uc($_e['No']) .'">
                            <input type="checkbox" name="radio" value="Radio" '.$checked.'>
                        </div>
                    </div>
               </div>';

       //Date
        $checked = "";
        if(@$date=='Date'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">Date</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Yes']) .'" data-off-label="'. _uc($_e['No']) .'">
                            <input type="checkbox" name="date" value="Date" '.$checked.'>
                        </div>
                    </div>
               </div>';

        //Time
        $checked = "";
        if(@$time=='Time'){$checked='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">Time</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Yes']) .'" data-off-label="'. _uc($_e['No']) .'">
                            <input type="checkbox" name="time" value="Time" '.$checked.'>
                        </div>
                    </div>
               </div>';

        echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Field 1</label>
                    <div class="col-sm-10  col-md-9">
                            <input type="text"  name="field1" class="form-control" value="'.@$field1.'" placeholder="eg: Comments,Actions">
                    </div>
                </div>';

        echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Field 2</label>
                    <div class="col-sm-10  col-md-9">
                            <input type="text"  name="field2" class="form-control" value="'.@$field2.'" placeholder="eg: Temperature">
                    </div>
                </div>';

        //Approved
        $checked2 = "";
        if(@$publish=='1'){$checked2='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">Publish</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Yes']) .'" data-off-label="'. _uc($_e['No']) .'">
                            <input type="checkbox" name="publish" value="1" '.$checked2.'>
                        </div>
                    </div>
               </div>';

        echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _uc($_e['SAVE']) .'</button>';

        echo "</div>
             </form>";
    }

 public function neweventFormAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newusertraining')){return false;}

            $title_id = empty($_POST['title_id'])  ? ""     : $_POST['title_id'];
            $question = empty($_POST['question'])  ? ""     : $_POST['question'];
            $category = empty($_POST['category'])  ? ""     : $_POST['category'];
            $radio    = empty($_POST['radio'])     ? "Not"  : $_POST['radio'];
            $date     = empty($_POST['date'])      ? "Not"  : $_POST['date'];
            $time     = empty($_POST['time'])      ? "Not"  : $_POST['time'];
            $field1   = empty($_POST['field1'])    ? ""     : $_POST['field1'];
            $field2   = empty($_POST['field2'])    ? ""     : $_POST['field2'];
            $publish  = empty($_POST['publish'])   ? "0"    : $_POST['publish'];
            
intval($title_id);
htmlspecialchars($question);
htmlspecialchars($category);
htmlspecialchars($radio);
htmlspecialchars($date);
htmlspecialchars($time);
htmlspecialchars($field1);
htmlspecialchars($field2);
intval($publish);

            try{
                $this->db->beginTransaction();

                $sql = "INSERT INTO `eventForms`(`title_id`,`question`,`category`,`radio`,`date`,`time`,`field1`,`field2`,`publish`) VALUES (?,?,?,?,?,?,?,?,?)";

                $array   = array($title_id,$question,$category,$radio,$date,$time,$field1,$field2,$publish);
                $this->dbF->setRow($sql,$array,false);
                $lastId = $this->dbF->rowLastId;


                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Event Forms']),($_e['Event Forms Add Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Added']),_uc($_e['Event Forms']),$lastId,($_e['Event Forms Add Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Event Forms']),($_e['Event Forms Add Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Event Forms']),($_e['Event Forms Add Failed']),'btn-danger');
            }
        } // If end
    }
 

 public function eventFormEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('editusertraining')){return false;}

            $title_id = empty($_POST['title_id'])  ? ""    : $_POST['title_id'];
            $question = empty($_POST['question'])  ? ""    : $_POST['question'];
            $category = empty($_POST['category'])  ? ""     : $_POST['category'];
            $radio    = empty($_POST['radio'])     ? "Not"  : $_POST['radio'];
            $date     = empty($_POST['date'])      ? "Not"  : $_POST['date'];
            $time     = empty($_POST['time'])      ? "Not"  : $_POST['time'];
            $field1   = empty($_POST['field1'])    ? ""     : $_POST['field1'];
            $field2   = empty($_POST['field2'])    ? ""     : $_POST['field2'];
            $publish  = empty($_POST['publish'])   ? "0"    : $_POST['publish'];

intval($title_id);
htmlspecialchars($question);
htmlspecialchars($category);
htmlspecialchars($radio);
htmlspecialchars($date);
htmlspecialchars($time);
htmlspecialchars($field1);
htmlspecialchars($field2);
intval($publish);

            try{
                $this->db->beginTransaction();
                $lastId   =   $_POST['editId'];

                $sql    =  "UPDATE `eventForms` SET
                                    `title_id`=?,
                                    `question`=?,
                                    `category`=?,
                                    `radio`=?,
                                    `field1`=?,
                                    `field2`=?,
                                    `date`=?,
                                    `time`=?,
                                    `publish`=?
                                    WHERE id = '$lastId'
                                ";

                $array   = array($title_id,$question,$category,$radio,$field1,$field2,$date,$time,$publish);
                $this->dbF->setRow($sql,$array,false);


                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Event Forms']),($_e['Event Forms Update Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Update']),_uc($_e['Event Forms']),$lastId,($_e['Event Forms Update Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Event Forms']),($_e['Event Forms Update Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Event Forms']),($_e['Event Forms Update Failed']),'btn-danger');
            }

        }
    }

}
?>
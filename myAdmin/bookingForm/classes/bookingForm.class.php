<?php
require_once (__DIR__."/../../global.php"); //connection setting db
class bookingForm extends object_class{
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
        $_w['Bookings'] = '' ;
        //filesManagerEdit.php
        $_w['Manage Bookings'] = '' ;

        //filesManager.php
        $_w['Active Bookings'] = '' ;
        $_w['Draft Bookings'] = '' ;
        $_w['Add New Booking'] = '' ;
        $_w['Delete Fail Please Try Again.'] = '' ;
        $_w['There is an error, Please Refresh Page and Try Again'] = '' ;
        $_w['SNO'] = '' ;
        $_w['Event Title'] = '' ;
        $_w['IMAGE'] = '' ;
        $_w['ACTION'] = '' ;
        $_w['Image Booking  Error'] = '' ;
        $_w['Image Not Found'] = '' ;
        $_w['Booking'] = '' ;
        $_w['Added'] = '' ;
        $_w['Booking Add Successfully'] = '' ;
        $_w['Booking Add Failed'] = '' ;
        $_w['Booking Update Failed'] = '' ;
        $_w['Booking Update Successfully'] = '' ;
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
        $_w['Active Bookings'] = '' ;
        $_w['Completion Date'] = '' ;
        $_w['Expiry Date'] = '' ;
        $_w['Training'] = '' ;
        $_w['Documents'] = '' ;
        $_w['Type'] = '' ;
        $_w['Manage Lunch And Learn'] = '' ;
      

         $_w['Active Lunch And Learn'] = '' ;
         $_w['Draft Lunch And Learn'] = '' ;
         $_w['Add New Lunch And Learn'] = '' ;
         $_w['Active Lunch And Learn'] = '' ;
         $_w['Draft Lunch And Learn'] = '' ;
         $_w['Add New Lunch And Learn'] = '' ;

        $_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin eventForm');

    }


    public function bookingFormView(){
        $sql  = "SELECT * FROM bookingForm WHERE publish='1' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->bookingFormPrint($data);
    }

    public function bookingFormDraft(){
        $sql  = "SELECT * FROM bookingForm WHERE publish='0' ORDER BY ID DESC";
        $data =  $this->dbF->getRows($sql);
        $this->bookingFormPrint($data);
    }

    public function titleName($id){
        $sql  = "SELECT title FROM eventmanagement WHERE id= ? ";
        $data =  $this->dbF->getRow($sql,array($id));
        return $data[0];
    }
      
    public function bookingFormPrint($data){
        global $_e;
        echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        <th>'. _u($_e['Event Title']) .'</th>
                        <th>TITLE</th>
                        <th>'. _u($_e['ACTION']) .'</th>
                    </thead>
                <tbody>';

        $i = 0;
        foreach($data as $val){
            $i++;
            $id = $val['id'];
            echo "<tr>
                    <td>$i</td>
                    <td>".$this->titleName($val['event_id'])."</td>
                    <td>$val[title]</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-id='$id' href='-bookingForm?page=edit&eventId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>
                            <a data-id='$id' onclick='deletebookingForm(this);' class='btn'>
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
    public function event(){
        $sql  = "SELECT * FROM eventmanagement ORDER BY title";
        $data = $this->dbF->getRows($sql);
        $opt  = '';
        foreach ($data as $val){
            $opt .= '<option value="'.$val["id"].'">'.$val["title"].' -- '._uc($val["type"]).'</option>';
        }
        return $opt;
    }

     public function bookingFormNew(){
        global $_e;
        $this->bookingFormEdit(true);
    }

    public function bookingFormEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newbookingform',false);
            $date = date('Y-m-d');
        }else {
            $id = $_GET['eventId'];
            $sql = "SELECT * FROM bookingForm where id = ? ";
            $data = $this->dbF->getRow($sql,array($id));
            @$event_id  = $data['event_id'];
            @$image   = $data['image'];
            @$publish   = $data['publish'];
            @$title     = $data['title'];

            $token = $this->functions->setFormToken('editbookingform', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
        }

        echo '<form method="post" action="-bookingForm?page=bookingForm" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

            //Title
            $option = $this->event();
            // select category
            echo '<div class="form-group" >
            <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['Event Title']) .'</label>
                <div class="col-sm-10  col-md-9">
                    <select name="event_id" class="form-control event" required>
                    '.$option.'
                    </select>
                </div>
            </div>
            <script>$(".event").val("'.@$event_id.'").change();</script>';
        

        echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Title</label>
                    <div class="col-sm-10  col-md-9">
                            <input type="text"  name="title" class="form-control" value="'.@$title.'" placeholder="Title">
                    </div>
                </div>';

        echo '<div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">Image</label>
            <div class="col-sm-10  col-md-9">
            <div class="input-group">
            <input type="url"  name="image" value="'.@$image.'" class="layer0 form-control" placeholder="">
            <div class="input-group-addon pointer " onclick="'."openKCFinderImageWithImg('layer0')".'"><i class="glyphicon glyphicon-picture"></i></div>
            </div>
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

 public function newbookingFormAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newbookingform')){return false;}

            $event_id = empty($_POST['event_id'])  ? ""     : $_POST['event_id'];
            $title    = empty($_POST['title'])     ? ""     : $_POST['title'];
            $image    = empty($_POST['image'])     ? ""     : $_POST['image'];
            $publish  = empty($_POST['publish'])   ? "0"    : $_POST['publish'];
            
            try{
                $this->db->beginTransaction();

                $sql = "INSERT INTO `bookingForm`(`event_id`,`title`,`image`,`publish`) VALUES (?,?,?,?)";

                $array   = array($event_id,$title,$image,$publish);
                $this->dbF->setRow($sql,$array,false);
                $lastId = $this->dbF->rowLastId;


                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Booking']),($_e['Booking Add Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Added']),_uc($_e['Booking']),$lastId,($_e['Booking Add Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Booking']),($_e['Booking Add Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Booking']),($_e['Booking Add Failed']),'btn-danger');
            }
        } // If end
    }
 

 public function bookingFormEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('editbookingform')){return false;}

            $event_id = empty($_POST['event_id'])  ? ""     : $_POST['event_id'];
            $title    = empty($_POST['title'])     ? ""     : $_POST['title'];
            $image    = empty($_POST['image'])     ? ""     : $_POST['image'];
            $publish  = empty($_POST['publish'])   ? "0"    : $_POST['publish'];

            try{
                $this->db->beginTransaction();
                $lastId   =   $_POST['editId'];

                $sql    =  "UPDATE `bookingForm` SET
                                    `event_id`=?,
                                    `title`=?,
                                    `image`=?,
                                    `publish`=?
                                    WHERE id = '$lastId'
                                ";

                $array   = array($event_id,$title,$image,$publish);
                $this->dbF->setRow($sql,$array,false);


                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc($_e['Booking']),($_e['Booking Update Successfully']),'btn-success');
                    $this->functions->setlog(_uc($_e['Update']),_uc($_e['Booking']),$lastId,($_e['Booking Update Successfully']));
                }else{
                    $this->functions->notificationError(_uc($_e['Booking']),($_e['Booking Update Failed']),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc($_e['Booking']),($_e['Booking Update Failed']),'btn-danger');
            }

        }
    }
//==========================================================================================================================
    public function lunchandlearnFormView(){
        $sql  = "SELECT * FROM lunchandlearn  WHERE Approved = '1' ORDER BY id DESC";
        $data =  $this->dbF->getRows($sql);
        $this->lunchandlearnFormPrint($data);
    }

    public function lunchandlearnFormDraft(){
        $sql  = "SELECT * FROM lunchandlearn WHERE Approved = '0'  ORDER BY id DESC";
        $data =  $this->dbF->getRows($sql);
        $this->lunchandlearnFormPrint($data);
    }

      
    public function lunchandlearnFormPrint($data){
        global $_e;
        echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                        <th>'. _u($_e['SNO']) .'</th>
                        
                       <th>Number Of Delegates</th>
                       <th>Best Day</th>
                       <th>Name Of Practice</th>
                       <th>Name Of Practice Manager</th>
                       <th>Practice Address</th>
                       <th>Practice Contact</th>
                       <th>Email</th>
                       <th>Lunch Comment</th>
                       <th>Is There A Plain Wall</th>
                       <th>Would You Like A FREE Mock Audit</th>
                       <th>Action</th>
                    </thead>
                <tbody>';

        $i = 0;
        foreach($data as $val){
            $i++;
            $id = $val['id'];
           if($val['Is_there_a_plain_wall'] ==  "false"){
            $Is_there_a_plain_wall = "NO";
                }
                else{
            $Is_there_a_plain_wall = "YES";

                }
            echo "<tr>
                    <td>$i</td>
                    <td>".$val['number_of_delegates']."</td>
                    <td>".$val['best_day']."</td>
                    <td>".$val['name_of_practice']."</td>
                    <td>".$val['name_of_practice_manager']."</td>
                    <td>".$val['practice_address']."</td>
                    <td>".$val['practice_contact']."</td>
                    <td>".$val['email']."</td>
                    <td>".$val['lunch_comment']."</td>
                    <td>".$Is_there_a_plain_wall."</td>
                    <td>".$val['would_you_like_a_free_mock_audit']."</td>


                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-id='$id' href='-bookingForm?page=lunchandlearnedit&eventId=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>
                            <a data-id='$id' onclick='deletelunchandlearnForm(this);' class='btn'>
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
 
     public function lunchandlearnFormNew(){
        global $_e;
        $this->lunchandlearnFormEdit(true);
    }

    public function lunchandlearnFormEdit($new=false){
        global $_e;
        if($new){
            $token       = $this->functions->setFormToken('newlunchandlearnform',false);
            $date = date('Y-m-d');
        }else {
            $id = $_GET['eventId'];
            $sql = "SELECT * FROM lunchandlearn where id = ? ";
            $data = $this->dbF->getRow($sql,array($id));
             if($data['Is_there_a_plain_wall'] ==  "No" || $data['Is_there_a_plain_wall'] ==  "false" ||$data['Is_there_a_plain_wall'] ==  "0"){
            $Is_there_a_plain_wall = "NO";
                }
                else{
            $Is_there_a_plain_wall = "YES";

                }  

        if($data['would_you_like_a_free_mock_audit'] ==  "No" || $data['would_you_like_a_free_mock_audit'] ==  "false" || $data['would_you_like_a_free_mock_audit'] ==  "0"){
            $would_you_like_a_free_mock_audit = "NO";
                }
                else{
            $would_you_like_a_free_mock_audit = "YES";

                }
        if($data['Are_you_currently_using_a_compliance_software'] ==  "No" ){
            $Are_you_currently_using_a_compliance_software = "NO";
                }
                else{
            $Are_you_currently_using_a_compliance_software = "YES";

                }        
             @$best_day = $data['best_day'];
             @$best_time = $data['best_time'];
             @$number_of_delegates = $data['number_of_delegates'];
             @$name_of_practice = $data['name_of_practice'];
             @$name_of_practice_manager = $data['name_of_practice_manager'];
             @$practice_address = $data['practice_address'];
             @$practice_contact = $data['practice_contact'];
             @$email = $data['email'];
             @$lunch_comment = $data['lunch_comment'];
           
            @$publish = $data['approved'];

            @$Is_there_a_plain_wall;
            @$would_you_like_a_free_mock_audit;

            $token = $this->functions->setFormToken('editlunchandlearnform', false);
            $token .= '<input type="hidden" name="editId" value="'.$id.'"/>';
        }
//-bookingForm?page=lunchandlearn
        echo '<form method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">'.
            $token.
            '
            <div class="form-horizontal">';

            //Title
                 echo '<div class="form-group">

                    <label class="col-sm-2 col-md-3  control-label">Number Of Delegates</label>
                    <div class="col-sm-10  col-md-9">
                            <input type="text"  name="number_of_delegates" class="form-control" value="'.@$number_of_delegates.'" placeholder="">
                    </div>
                </div>';
        
                
                 echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Best Day To Host a Lunch & Learn</label>
                    <div class="col-sm-10  col-md-9">
                            <input type="date"  name="best_day" class="datepickerr form-control" value="'.@$best_day.'" placeholder="Best Day To Host a Lunch & Learn">
                    </div>
                </div>';
                echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Best Time For Lunch & Learn</label>
                    <div class="col-sm-10  col-md-9">
                            <input type="time"  name="best_time" class="form-control" value="'.@$best_time.'" placeholder="Best Time For Lunch & Learn">
                    </div>
                </div>';
              echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Name Of Practice</label>
                    <div class="col-sm-10  col-md-9">
                            <input type="text"  name="name_of_practice" class="form-control" value="'.@$name_of_practice.'" placeholder="">
                    </div>
                </div>';

               echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Name Of Practice Manager</label>
                    <div class="col-sm-10  col-md-9">
                            <input type="text"  name="name_of_practice_manager" class="form-control" value="'.@$name_of_practice_manager.'" placeholder="">
                    </div>
                </div>';
                echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Practice Address</label>
                    <div class="col-sm-10  col-md-9">
                            <input type="text"  name="practice_address" class="form-control" value="'.@$practice_address.'" placeholder="">
                    </div>
                </div>';
                echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Practice Contact</label>
                    <div class="col-sm-10  col-md-9">
                            <input type="text"  name="practice_contact" class="form-control" value="'.@$practice_contact.'" placeholder="">
                    </div>
                </div>';
                echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Email</label>
                    <div class="col-sm-10  col-md-9">
                            <input type="text"  name="email" class="form-control" value="'.@$email.'" placeholder="">
                    </div>
                </div>';

              

                echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">Dietary Requirements</label>
                    <div class="col-sm-10  col-md-9">
                       <textarea name="lunch_comment" class="form-control" placeholder="">'.@$lunch_comment.'</textarea>
                           
                    </div>
                </div>';

        //Approved
        $Is_there_a_plain_wall2 = "";
        if(@$Is_there_a_plain_wall=='YES'){$Is_there_a_plain_wall2='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">Is There A Plain Wall</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Yes']) .'" data-off-label="'. _uc($_e['No']) .'">
                            <input type="checkbox" name="Is_there_a_plain_wall" value="Yes" '.$Is_there_a_plain_wall2.'>
                        </div>
                    </div>
               </div>';
        //Approved
        $would_you_like_a_free_mock_audit2 = "";
        if(@$would_you_like_a_free_mock_audit=='YES'){$would_you_like_a_free_mock_audit2='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">Would You Like A Free Mock Audit</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Yes']) .'" data-off-label="'. _uc($_e['No']) .'">
                            <input type="checkbox" name="would_you_like_a_free_mock_audit" value="Yes" '.$would_you_like_a_free_mock_audit2.'>
                        </div>
                    </div>
               </div>';

        //Approved
        $Are_you_currently_using_a_compliance_software2 = "";
        if(@$Are_you_currently_using_a_compliance_software =='YES'){$Are_you_currently_using_a_compliance_software2='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">Are you currently using a compliance software</label>
                    <div class="col-sm-10  col-md-9">
                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="'. _uc($_e['Yes']) .'" data-off-label="'. _uc($_e['No']) .'">
                            <input type="checkbox" name="Are_you_currently_using_a_compliance_software" value="Yes" '.$Are_you_currently_using_a_compliance_software2.'>
                        </div>
                    </div>
               </div>';
       
               //Approved
        $checked2 = "";

        if(@$publish=='1'){$checked2='checked';}
        echo '<div class="form-group">
                    <label  class="col-sm-2 col-md-3  control-label">Approved</label>
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

 public function newlunchandlearnFormAdd(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('newlunchandlearnform')){return false;}
       
        $best_day = empty($_POST['best_day']) ? "" : $_POST['best_day'];
        $best_time = empty($_POST['best_time']) ? "" : $_POST['best_time'];

        $number_of_delegates = empty($_POST['number_of_delegates']) ? "" : $_POST['number_of_delegates'];
        $name_of_practice = empty($_POST['name_of_practice']) ? "" : $_POST['name_of_practice'];

    $name_of_practice_manager = empty($_POST['name_of_practice_manager']) ? "" : $_POST['name_of_practice_manager'];

        $practice_address = empty($_POST['practice_address']) ? "" : $_POST['practice_address'];

        $practice_contact = empty($_POST['practice_contact']) ? "" : $_POST['practice_contact'];

        $email = empty($_POST['email']) ? "" : $_POST['email'];

        $lunch_comment = empty($_POST['lunch_comment']) ? "" : $_POST['lunch_comment'];

    $would_you_like_a_free_mock_audit = empty($_POST['would_you_like_a_free_mock_audit']) ? "No" : $_POST['would_you_like_a_free_mock_audit'];
    $Are_you_currently_using_a_compliance_software = empty($_POST['Are_you_currently_using_a_compliance_software']) ? "No" : $_POST['Are_you_currently_using_a_compliance_software'];

        $Is_there_a_plain_wall = empty($_POST['Is_there_a_plain_wall']) ? "No" : $_POST['Is_there_a_plain_wall'];

        $publish = empty($_POST['publish']) ? "0" : $_POST['publish'];

           
            try{
                $this->db->beginTransaction();

                $sql = "INSERT INTO `lunchandlearn`(
                `number_of_delegates`,
                `best_day`,
                `best_time`,
                `name_of_practice`,
                `name_of_practice_manager`,
                `practice_address`, 
                `practice_contact`,
                `email`,
                `lunch_comment`,
                `Is_there_a_plain_wall`,
                `would_you_like_a_free_mock_audit`,
                `Are_you_currently_using_a_compliance_software`,
                `approved`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

                $array   = array($number_of_delegates,
                    $best_day,
                    $best_time,
$name_of_practice,
$name_of_practice_manager,
$practice_address,
$practice_contact,
$email,
$lunch_comment,
$Is_there_a_plain_wall,
$would_you_like_a_free_mock_audit,
$Are_you_currently_using_a_compliance_software,
$publish);
                $this->dbF->setRow($sql,$array,false);
                $lastId = $this->dbF->rowLastId;


                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc('lunchandlearn'),('lunchandlearn Add Successfully'),'btn-success');
                    $this->functions->setlog(_uc('Added'),_uc('lunchandlearn'),$lastId,('lunchandlearn Add Successfully'));
                }else{
                    $this->functions->notificationError(_uc('lunchandlearn'),('lunchandlearn Add Failed'),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc('lunchandlearn'),('lunchandlearn Add Failed'),'btn-danger');
            }
        } // If end
    }
 

 public function lunchandlearnFormEditSubmit(){
        global $_e;
        if(isset($_POST['submit'])){
            if(!$this->functions->getFormToken('editlunchandlearnform')){return false;}

        $best_day = empty($_POST['best_day']) ? "" : $_POST['best_day'];
        $best_time = empty($_POST['best_time']) ? "" : $_POST['best_time'];
        $number_of_delegates = empty($_POST['number_of_delegates']) ? "" : $_POST['number_of_delegates'];
        $name_of_practice = empty($_POST['name_of_practice']) ? "" : $_POST['name_of_practice'];

        $name_of_practice_manager = empty($_POST['name_of_practice_manager']) ? "" : $_POST['name_of_practice_manager'];

        $practice_address = empty($_POST['practice_address']) ? "" : $_POST['practice_address'];

        $practice_contact = empty($_POST['practice_contact']) ? "" : $_POST['practice_contact'];

        $email = empty($_POST['email']) ? "" : $_POST['email'];

        $lunch_comment = empty($_POST['lunch_comment']) ? "" : $_POST['lunch_comment'];

        $would_you_like_a_free_mock_audit = empty($_POST['would_you_like_a_free_mock_audit']) ? "No" : $_POST['would_you_like_a_free_mock_audit'];

        $Is_there_a_plain_wall = empty($_POST['Is_there_a_plain_wall']) ? "No" : $_POST['Is_there_a_plain_wall'];
        $Are_you_currently_using_a_compliance_software = empty($_POST['Are_you_currently_using_a_compliance_software']) ? "No" : $_POST['Are_you_currently_using_a_compliance_software'];

        $publish = empty($_POST['publish']) ? "0" : $_POST['publish'];

            try{
                $this->db->beginTransaction();
                $lastId   =   $_POST['editId'];

                $sql    =  "UPDATE `lunchandlearn` SET 
                `number_of_delegates`=?,
                `best_day`=?,
                `best_time`=?,
                `name_of_practice`=?,
                `name_of_practice_manager`=?,
                `practice_address`=?,
                `practice_contact`=?,
                `email`=?,
                `lunch_comment`=?,
                `Is_there_a_plain_wall`=?,
                `would_you_like_a_free_mock_audit`=?,
                `Are_you_currently_using_a_compliance_software`=?,
                `approved`=? 

                 WHERE id = $lastId
                                ";

               
                $array   = array($number_of_delegates,
                $best_day,
                $best_time,
                $name_of_practice,
                $name_of_practice_manager,
                $practice_address,
                $practice_contact,
                $email,
                $lunch_comment,
                $Is_there_a_plain_wall,
                $would_you_like_a_free_mock_audit,
                $Are_you_currently_using_a_compliance_software,
                $publish);

                $this->dbF->setRow($sql,$array,false);


                $this->db->commit();
                if($this->dbF->rowCount>0){
                    $this->functions->notificationError(_uc('lunchandlearn'),('lunchandlearn Update Successfully'),'btn-success');
                    $this->functions->setlog(_uc('Update'),_uc('lunchandlearn'),$lastId,('lunchandlearn Update Successfully'));
                }else{
                    $this->functions->notificationError(_uc('lunchandlearn'),('lunchandlearn Update Failed'),'btn-danger');
                }
            }catch (Exception $e){
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_uc('lunchandlearn'),('lunchandlearn Update Failed'),'btn-danger');
            }

        }
    }
}
?>
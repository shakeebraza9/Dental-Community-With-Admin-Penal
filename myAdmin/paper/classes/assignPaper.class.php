<?php

require_once (__DIR__."/../../global.php"); //connection setting db

class assignPaper extends object_class{

public $productF;

public $imageName;

public $script_js;

public function __construct(){

parent::__construct('3');



# saving script

$this->script_js = array();





/**

* MultiLanguage keys Use where echo;

* define this class words and where this class will call

* and define words of file where this class will called

**/

global $_e;

global $adminPanelLanguage;

$_w=array();//homePage.php



//homePageEdit.php

$_w['SAVE'] = '' ;

$_w['Close'] = '' ;

$_w['Delete Fail Please Try Again.'] = '' ;

$_w['Entry'] = '' ;

$_w['Added'] = '' ;

$_w['Domains'] = '' ;

$_w['ACTION'] = '' ;

$_w['PAYMENT'] = '' ;



$_w['Date'] = '' ;

$_w['Select Agent'] = '' ;

$_w['Title'] = '' ;

$_w['Payment'] = '' ;

$_w['Assign Paper'] = '' ;

$_w['View Entries'] = '' ;

$_w['Domain'] = '' ;

$_w['File Save Successfully'] = '' ;

$_w['Entry'] = '' ;

$_w['Entry Save Successfully'] = '' ;

$_w['Entry Save Failed,Please Enter Correct Values, And unique slug'] = '' ;

$_w['SNO'] = '' ;

$_w['DATE'] = '' ;

$_w['TITLE'] = '' ;

$_w['AGENT'] = '' ;

$_w['Description'] = '' ;

$_w['DESCIRPTION'] = '' ;

$_w['Update'] = '' ;

$_w['Nothing Found For Update'] = '' ;

$_w['Assign Papers'] = '' ;

$_w['All Papers'] = '' ;

$_w['User'] = '' ;

$_w['Paper Assign'] = '' ;

$_w['ASSIGN ID'] = '' ;

$_w['NAME'] = '' ;

$_w['EMAIL'] = '' ;

$_w['PAPER TITLE'] = '' ;

$_w['STATUS'] = '' ;

$_w['Rating'] = '' ;

$_w['Reflective Account'] = '' ;

$_w['FeedBack'] = '' ;

$_w[''] = '' ;

$_w[''] = '' ;

$_w[''] = '' ;

$_w[''] = '' ;

$_w[''] = '' ;

$_w[''] = '' ;

$_w[''] = '' ;

$_w[''] = '' ;





$_e    =   $this->dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin File Management');



}




public function assignView($userFor=false){



$sql  = "SELECT * FROM `assigned_paper` ORDER BY `assign_id` DESC ";

$data =  $this->dbF->getRows($sql);
 $href  = "paper/paper_ajax.php?page=Fetch_AssignedPaper";
$this->printViewTable($data,$href);

}



private function printViewTable($data,$href){

global $_e;


       $uniq=uniqid('id');
       
       
   
            echo  '
            <div class="table-responsive">
            <table class="table table-hover tableIBMS dTable_ajax " data-href="'.$href.'" data-uniq="'.$uniq.'">

<thead>

<th>'. _u($_e['SNO']) .'</th>

<th>'. _u($_e['ASSIGN ID']) .'</th>

<th>'. _u($_e['NAME']) .'</th>

<th>'. _u($_e['EMAIL']) .'</th>

<th>'. _u($_e['PAPER TITLE']) .'</th>

<th>'. _u($_e['STATUS']) .'</th>

<th>'. _u($_e['Rating']) .'</th>

<th>'. _u($_e['FeedBack']) .'</th>

<th>'. _u($_e['Reflective Account']) .'</th>

<th>'. _u($_e['DATE']) .'</th>

<th>'. _u($_e['ACTION']) .'</th>

</thead>';



$i = 0;

$defaultLang = $this->functions->AdminDefaultLanguage();

// foreach($data as $val){

// $i++;

// $id = $val['assign_id'];
// $aid = MD5($id);
// $date_timestamp = $val['date_timestamp'];

// $assign_user = $val['assign_user'];

// $assign_paper = $val['assign_paper'];

// $status = $val['status'];



// $userData = $this->getWebUser($assign_user, 'acc_name, acc_email');

// $paperData = $this->getPaperDetail($assign_paper, 'paper_title');



// if($status == 0){

//     $paperStatus = 'Unattempted';

// }elseif ($status == 1) {

//     $paperStatus = 'Attempted';

// }



// //<a data-id='$id' href='-".$this->functions->getLinkFolder()."?page=edit&AssignId=$id' class='btn'>

//             //<i class='glyphicon glyphicon-edit'></i>

//         //</a>

// // <a href=-".$this->functions->getLinkFolder()."?page=printResult&assignid=$id&user=$assign_user target='_blank' class='btn'>
// //             <i class='fa fa-file-pdf-o'></i>
// //        </a>
//                              @$feedback = $val['feedback'];
//                              @$Rating = $val['star'];
//                              @$feedback =  base64_decode($feedback);
//                              @$expload = explode("::", $feedback);
//                           @$echo0 =  $expload[0];
//                           @$echo1 =  $expload[1];
//                         //  @$echo2 =  $expload[2];
//                         //  @$echo3 =  $expload[3];
// echo "<tr>

// <td>$i</td>

// <td>$id</td>

// <td>".$userData['acc_name']."</td>

// <td>".$userData['acc_email']."</td>

// <td>".$paperData['paper_title']."</td>

// <td>$paperStatus</td>
// <td>$Rating</td>
// <td>$echo0</td>
// <td>$echo1</td>

// <td>$date_timestamp</td>



// <td>

//     <div class='btn-group btn-group-sm'>

//         <a href='../printResult.php?assignid=$aid&user=$assign_user' title='With Marks' alt='With Marks' target='_blank' class='btn'>
//             <i class='fa fa-file-pdf-o'></i>


//       <!--</a> <a href='../printResult2.php?assignid=$aid&user=$assign_user' alt='WithOut Marks' title='WithOut Marks' target='_blank' class='btn'>
//             <i class='fa fa-file-pdf-o'></i>
//       </a>-->


//       <a style='display:none' href='../marked.php?assignid=$id&user=$assign_user' alt='marked answer, question wise' title='marked answer, question wise' target='_blank' class='btn'>
//             <i class='fa fa-file-pdf-o'></i>
//       </a>


//         <a data-id='$id' onclick='deleteAssignment(this);' class='btn'>

//             <i class='glyphicon glyphicon-trash trash'></i>

//             <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

//         </a>

//     </div>

// </td>



// </tr>";

// }

echo '</tbody>

</table>

</div> <!-- .table-responsive End -->';



}





public function newAssignAdd(){

global $_e;

if(isset($_POST['web_user']) && isset($_POST['submit'])){

if(!$this->functions->getFormToken('newPaperAssign')){return false;}



// echo "<pre>"; print_r($_POST); echo "</pre>";

// exit;



$web_user   = empty($_POST['web_user'])  ? ""    : $_POST['web_user'];

$paper     	= empty($_POST['paper'])  	 ? ""    : $_POST['paper'];

htmlspecialchars($web_user);

htmlspecialchars($paper);


try{

$this->db->beginTransaction();



$sql  =  "INSERT INTO `assigned_paper`(`assign_user`,`assign_paper`) VALUES (?,?)";



$array   = array($web_user,$paper);



$this->dbF->setRow($sql,$array,false);

$lastId  =   $this->dbF->rowLastId;





$this->db->commit();

if($this->dbF->rowCount>0){

$this->functions->notificationError(_js(_uc($_e['Paper Assign'])),_js(_uc($_e['Entry Save Successfully'])),'btn-success');

$this->functions->setlog(_js(_uc($_e['Paper Assign'])),_js(_uc($_e['Entry'])),_js(_uc($_e['Entry Save Successfully'])));

}else{

$this->functions->notificationError(_js(_uc($_e['Paper Assign'])),_js(_uc($_e['Entry Save Failed,Please Enter Correct Values, And unique slug'])),'btn-danger');

}

}catch (Exception $e){

$this->db->rollBack();

$this->dbF->error_submit($e);

$this->functions->notificationError(_js(_uc($_e['Paper Assign'])),_js(_uc($_e['Entry Save Failed,Please Enter Correct Values, And unique slug'])),'btn-danger');

}

} //If end

}



public function assignEditSubmit(){

global $_e;



if(isset($_POST['web_user']) && isset($_POST['submit'])){



if(!$this->functions->getFormToken('editPaperAssign')){return false;}







$web_user   = empty($_POST['web_user'])  ? ""    : $_POST['web_user'];

$paper     = empty($_POST['paper'])     ? ""    : $_POST['paper'];

htmlspecialchars($web_user);
htmlspecialchars($paper);

try{

$this->db->beginTransaction();



$lastId   =   intval($_POST['AssignId']);



$sql  =  "UPDATE `assigned_paper` SET 

                `assign_user` = ?,

                `assign_paper` = ?

                WHERE `assign_id` = ?";



$array   = array($web_user,$paper,$lastId);



$this->dbF->setRow($sql,$array,false);

$lastId  =   $this->dbF->rowLastId;





$this->db->commit();

if($this->dbF->rowCount>0){

$this->functions->notificationError(_js(_uc($_e['Paper Assign'])),_js(_uc($_e['Entry Save Successfully'])),'btn-success');

$this->functions->setlog(_js(_uc($_e['Paper Assign'])),_js(_uc($_e['Entry'])),_js(_uc($_e['Entry Save Successfully'])));

}else{

$this->functions->notificationError(_js(_uc($_e['Paper Assign'])),_js(_uc($_e['Entry Save Failed,Please Enter Correct Values, And unique slug'])),'btn-danger');

}

}catch (Exception $e){

$this->db->rollBack();

$this->dbF->error_submit($e);

$this->functions->notificationError(_js(_uc($_e['Paper Assign'])),_js(_uc($_e['Entry Save Failed,Please Enter Correct Values, And unique slug'])),'btn-danger');

}

} //If end

}



public function assignNew(){

$this->assignEdit(true);

return '';

}



public function assignEdit($new = false){

global $_e;



$webUsersOptions = '';

$allPaperOptions = '';



$userInfo   = $this->getWebUserInfo();



$unattamp_user = $this->allUnattamptUsers();

$userNotIn = '';

foreach ($unattamp_user as $key => $value) {

    $userNotIn .= "'".$value['assign_user']."',";

}

$userNotIn = trim($userNotIn,',');

// $this->dbF->prnt($unattamp_user);



$userData   =   $this->getAllWebUser('acc_id, acc_name', $userNotIn);

// $this->dbF->prnt($userData);





$allPapers = $this->getAllPapers();









$isEdit = false;

if($new ===true){

    $token       = $this->functions->setFormToken('newPaperAssign',false);

}else{

    //For Edit Page.

    $isEdit = true;

    $token = $this->functions->setFormToken('editPaperAssign', false);

    $id = $_GET['AssignId'];

    $sql = "SELECT * FROM `assigned_paper` WHERE `assign_id` = ? ";

    $data = $this->dbF->getRow($sql,array($id));



    if($this->dbF->rowCount==0){

    echo  _uc($_e["Nothing Found For Update"]);

    return false;

    }

}



//No need to remove any thing,, go in developer setting table and set 0

echo '<form method="post" action="-paper?page=assign" class="form-horizontal" role="form" enctype="multipart/form-data">

<input type="hidden" name="AssignId" value="'.@$id.'"/>'.

$token.

'

<div class="form-horizontal">



<!-- Tab panes -->



';



if($isEdit) {

$assign_user = ($data['assign_user']);

$assign_paper = ($data['assign_paper']);

}



$lang = $this->functions->IbmsLanguages();

if($lang != false){

$lang_nonArray = implode(',', $lang);

}

echo '<input type="hidden" name="lang" value="'.$lang_nonArray.'" />';







//Title

echo '  <div class="form-group">

	        <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['User']) .'</label>

	        <div class="col-sm-10  col-md-9">

                <select name="web_user" class="form-control">

                    <option selected disabled>-- Select User --</option>';



                    foreach ($userData as $key => $value) {

                        $userId = $value['acc_id'];

                        $userName = $value['acc_name'];

                        $selectUser = ($assign_user == $userId) ? 'selected' : '';

                        echo '<option value="'.$userId.'" '.$selectUser.'>'.$userName.'</option>';

                    }



    echo '      </select>

	        </div>

	    </div>';



//All Papers

echo '  <div class="form-group">

            <label class="col-sm-2 col-md-3  control-label">'. _uc($_e['All Papers']) .'</label>

            <div class="col-sm-10  col-md-9">

                <select name="paper" class="form-control">

                    <option selected disabled>-- Select Paper to Assign --</option>';



                    foreach ($allPapers as $key => $value) {

                        $paper_id       = $value['paper_id'];

                        $paper_title    = $value['paper_title'];

                        $selectPaper = ($assign_paper == $paper_id) ? 'selected' : '';

                        echo '<option value="'.$paper_id.'" '.$selectPaper.'>'.$paper_title.'</option>';

                    }



    echo       '</select>

            </div>

        </div>';





echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">'. _u($_e['SAVE']) .'</button>';



echo "

</div> <!-- container end -->

</form>";



} //function end



public function getAllWebUser($columns=false, $exclude=false){

    $fields = "*";

    $notIn = "";

    if($columns){

        $fields = $columns;

    }

    if($exclude){

        $notIn = " AND `acc_id` NOT IN ($exclude)";

    }



    $sql    = "SELECT $fields FROM `accounts_user` WHERE 1 $notIn";

    $userData   =   $this->dbF->getRows($sql);



    return $userData;

}



public function getWebUser($id, $columns=false){

    $fields = "*";



    if($columns){

        $fields = $columns;

    }

    $sql    = "SELECT $fields FROM `accounts_user` WHERE `acc_id` = ? ";

    $userData   =   $this->dbF->getRow($sql,array($id));



    return $userData;

}



public function getWebUserInfo($id=false, $columns=false){

    $where = "";

    $fields = "*";

    if($id){

        $where = " AND `id_user` = '$id'";

    }

    if($columns){

        $fields = $columns;

    }

    $sql    = "SELECT $fields FROM accounts_user_detail WHERE 1 $where";

    $userInfo   = $this->dbF->getRows($sql);



    return $userInfo;

}



public function webUserInfoArray($data,$settingName){

    foreach($data as $val){

        if($val['setting_name']==$settingName){

            return $val['setting_val'];

        }

    }

    return "";

}



public function getAllPapers(){

    $sql        = "SELECT `paper_id`, `paper_title` FROM `paper`";

    $allPapers   = $this->dbF->getRows($sql);



    return $allPapers;



}



public function getPaperDetail($id, $column=false){

    $fields = "*";



    if($column){

        $fields = $column;

    }

    $sql            = "SELECT $fields FROM `paper` WHERE `paper_id` = ? ";

    $paperDetail    = $this->dbF->getRow($sql,array($id));



    return $paperDetail;



}



public function allUnattamptUsers(){

    $sql            = "SELECT `assign_user` FROM `assigned_paper` WHERE `status` = 0";

    $unattampDetail    = $this->dbF->getRows($sql);



    return $unattampDetail;

}



}

?>
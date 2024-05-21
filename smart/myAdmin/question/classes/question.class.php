<?php
require_once(__DIR__ . "/../../global.php"); //connection setting db
class question extends object_class {
    public $productF;
    public $imageName;
    public $script_js;
    public function __construct() {
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
        $_w                                                                            = array(); //homePage.php
        //homePageEdit.php
        $_w['SAVE']                                                                    = '';
        $_w['Close']                                                                   = '';
        $_w['Delete Fail Please Try Again.']                                           = '';
        $_w['Question Entry']                                                          = '';
        $_w['Added']                                                                   = '';
        $_w['Questions']                                                               = '';
        $_w['ACTION']                                                                  = '';
        $_w['PAYMENT']                                                                 = '';
        $_w['Date']                                                                    = '';
        $_w['Select Agent']                                                            = '';
        $_w['Question']                                                                = '';
        $_w['Payment']                                                                 = '';
        $_w['Add New']                                                                 = '';
        $_w['View Entries']                                                            = '';
        $_w['Question']                                                                = '';
        $_w['File Save Successfully']                                                  = '';
        $_w['Question Entry']                                                          = '';
        $_w['Question Entry Save Successfully']                                        = '';
        $_w['Question Entry Save Failed,Please Enter Correct Values, And unique slug'] = '';
        $_w['SNO']                                                                     = '';
        $_w['DATE']                                                                    = '';
        $_w['TITLE']                                                                   = '';
        $_w['AGENT']                                                                   = '';
        $_w['Description']                                                             = '';
        $_w['DESCIRPTION']                                                             = '';
        $_w['Update']                                                                  = '';
        $_w['Question Not Found For Update']                                           = '';
        $_w['Questions']                                                               = '';
        $_w['Options']                                                                 = '';
        $_w['QUESTION']                                                                = '';
        $_w['OPTIONS']                                                                 = '';
        $_w['ANSWER']                                                                  = '';
        $_w['Course']                                                                  = '';
        $_w['COURSE']                                                                  = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_w['']                                                                        = '';
        $_e                                                                            = $this->dbF->hardWordsMulti($_w, $adminPanelLanguage, 'Admin File Management');
    }

    public function questionView($userFor = false) {
        $sql  = "SELECT * FROM `questions` ORDER BY `question_id` DESC ";
        $data = $this->dbF->getRows($sql);
        $this->printViewTable($data);
    }

    private function printViewTable($data) {
        global $_e;
        echo '<div class="table-responsive">
<table class="table table-hover dTable tableIBMS">
<thead>
<th>' . _u($_e['SNO']) . '</th>
<th>' . _u($_e['COURSE']) . '</th>
<th>' . _u($_e['QUESTION']) . '</th>
<th>' . _u($_e['OPTIONS']) . '</th>
<th>' . _u($_e['ANSWER']) . '</th>
<th>' . _u($_e['DATE']) . '</th>
<th>' . _u($_e['ACTION']) . '</th>
</thead>';
        $i           = 0;
        $defaultLang = $this->functions->AdminDefaultLanguage();
        foreach ($data as $val) {
            $i++;
            $id             = $val['question_id'];
            $date_timestamp = $val['date_timestamp'];
            $domain         = $this->functions->getSubject($val['subject'], 'subject_title');
            $subject_name   = $domain['subject_title'];
            $title          = $val['question_title'];
            $options        = json_decode($val['options']);
            $correct_opt    = $val['correct_opt'] - 1;
            echo "<tr>
<td>$i</td>
<td>$subject_name</td>
<td>$title</td>
<td>";
            $count = 1;
            foreach ($options as $key => $value) {
                echo $count . ' - ' . $value . '<br>';
                $count++;
            }
            echo "</td>
<td>$options[$correct_opt]</td>
<td>$date_timestamp</td>
<td>
    <div class='btn-group btn-group-sm'>
        <a data-id='$id' href='-" . $this->functions->getLinkFolder() . "?page=edit&questionId=$id' class='btn'>
            <i class='glyphicon glyphicon-edit'></i>
        </a>
        <a data-id='$id' onclick='deleteQuestion(this);' class='btn'>
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
    public function newquestionAdd() {
        global $_e;
        if (isset($_POST['title']) && isset($_POST['submit'])) {
            if (!$this->functions->getFormToken('newQuestion')) {
                return false;
            }
            // echo "<pre>"; print_r($_POST); echo "</pre>";
            // exit;
            $title   = empty($_POST['title']) ? "" : $_POST['title'];
            $options = empty($_POST['options']) ? "" : json_encode($_POST['options']);
            $correct = empty($_POST['correct']) ? "" : $_POST['correct'];
            $domain  = empty($_POST['domain']) ? "" : $_POST['domain'];
            
htmlspecialchars($title);
htmlspecialchars($options);
htmlspecialchars($correct);
htmlspecialchars($domain);

            try {
                $this->db->beginTransaction();
                $sql   = "INSERT INTO `questions`(`subject`,`question_title`,`options`,`correct_opt`) VALUES (?,?,?,?)";
                $array = array(
                    $domain,
                    $title,
                    $options,
                    $correct
                );
                $this->dbF->setRow($sql, $array, false);
                $lastId = $this->dbF->rowLastId;
                $this->db->commit();
                if ($this->dbF->rowCount > 0) {
                    $this->functions->notificationError(_js(_uc($_e['Question'])), _js(_uc($_e['Question Entry Save Successfully'])), 'btn-success');
                    $this->functions->setlog(_js(_uc($_e['Question'])), _js(_uc($_e['Question Entry'])), _js(_uc($_e['Question Entry Save Successfully'])));
                } else {
                    $this->functions->notificationError(_js(_uc($_e['Question'])), _js(_uc($_e['Question Entry Save Failed,Please Enter Correct Values, And unique slug'])), 'btn-danger');
                }
            }
            catch (Exception $e) {
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_js(_uc($_e['Question'])), _js(_uc($_e['Question Entry Save Failed,Please Enter Correct Values, And unique slug'])), 'btn-danger');
            }
        } //If end
    }
    public function questionEditSubmit() {
        global $_e;
        if (isset($_POST['title']) && isset($_POST['submit'])) {
            if (!$this->functions->getFormToken('editQuestion')) {
                return false;
            }
            // echo "<pre>"; print_r($_POST); echo "</pre>";
            // exit;
            $title   = empty($_POST['title']) ? "" : $_POST['title'];
            $options = empty($_POST['options']) ? "" : json_encode($_POST['options']);
            $correct = (empty($_POST['correct']) || $_POST['correct'] ==  0) ? "" : $_POST['correct'];
            $domain  = empty($_POST['domain']) ? "" : $_POST['domain'];
           
htmlspecialchars($title);
htmlspecialchars($options);
htmlspecialchars($correct);
htmlspecialchars($domain);


            try {
                $this->db->beginTransaction();
                $lastId = $_POST['questionId'];
                $sql    = "UPDATE `questions` SET 
                    `subject` = ?,
                    `question_title` = ?,
                    `options` = ?,
                    `correct_opt` = ?
                WHERE `question_id` = ?";
                $array  = array(
                    $domain,
                    $title,
                    $options,
                    $correct,
                    $lastId
                );
                // $this->dbF->prnt($array);
                $this->dbF->setRow($sql, $array, false);
                $lastId = $this->dbF->rowLastId;
                $this->db->commit();
                if ($this->dbF->rowCount > 0) {
                    $this->functions->notificationError(_js(_uc($_e['Question'])), _js(_uc($_e['Question Entry Save Successfully'])), 'btn-success');
                    $this->functions->setlog(_js(_uc($_e['Question'])), _js(_uc($_e['Question Entry'])), _js(_uc($_e['Question Entry Save Successfully'])));
                } else {
                    $this->functions->notificationError(_js(_uc($_e['Question'])), _js(_uc($_e['Question Entry Save Failed,Please Enter Correct Values, And unique slug'])), 'btn-danger');
                }
            }
            catch (Exception $e) {
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_js(_uc($_e['Question'])), _js(_uc($_e['Question Entry Save Failed,Please Enter Correct Values, And unique slug'])), 'btn-danger');
            }
        } //If end
    }
    public function questionNew() {
        $this->questionEdit(true);
        return '';
    }
    public function courses($selected){
        $sql_domains = "SELECT * FROM `subjects` WHERE `under`='0' AND `publish`='1'";
        $res_domains = $this->dbF->getRows($sql_domains);
        foreach ($res_domains as $key => $value) {
            @$select_subject = ($selected == $value['subject_id']) ? 'selected' : '';
            echo '<option value="' . $value['subject_id'] . '" ' . $select_subject . '>' . $value['subject_title'] . '</option>';
            $sql_domains2 = "SELECT * FROM `subjects` WHERE `under`='$value[subject_id]' AND `publish`='1'";
            $res_domains2 = $this->dbF->getRows($sql_domains2);
            foreach ($res_domains2 as $key => $value2) {
                @$select_subject2 = ($selected == $value2['subject_id']) ? 'selected' : '';
                echo '<option value="' . $value2['subject_id'] . '" ' . $select_subject2 . '>-- ' . $value2['subject_title'] . '</option>';
            }
        }
    }
    public function questionEdit($new = false) {
        global $_e;
        $isEdit      = false;
        if ($new === true) {
            $token = $this->functions->setFormToken('newQuestion', false);
        } else {
            //For Edit Page.
            $isEdit = true;
            $token  = $this->functions->setFormToken('editQuestion', false);
            $id     = $_GET['questionId'];
            $sql    = "SELECT * FROM `questions` WHERE `question_id` =  ? ";
            $data   = $this->dbF->getRow($sql,array($id));
            // $this->dbF->prnt($data);
            if ($this->dbF->rowCount == 0) {
                echo _uc($_e["Question Not Found For Update"]);
                return false;
            }
        }
        //No need to remove any thing,, go in developer setting table and set 0
        echo '<form method="post" action="-question?page=question" class="form-horizontal" role="form" enctype="multipart/form-data"><input type="hidden" name="questionId" value="' . @$id . '"/>' . $token . '
<div class="form-horizontal">
<!-- Tab panes -->';
        if ($isEdit) {
            $title   = empty($data['question_title']) ? "" : $data['question_title'];
            $options = empty($data['options']) ? "" : json_decode($data['options']);
            $correct = empty($data['correct_opt']) ? "" : $data['correct_opt'];
            $subject = empty($data['subject']) ? "" : $data['subject'];
        }
        $lang = $this->functions->IbmsLanguages();
        if ($lang != false) {
            $lang_nonArray = implode(',', $lang);
        }
        echo '<input type="hidden" name="lang" value="' . $lang_nonArray . '" />';
        //Title
        echo '  <div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">' . _uc($_e['Course']) . '</label>
            <div class="col-sm-10  col-md-9">
                <select class="form-control" name="domain" required>
                    <option selected disabled>-- Select Subject --</option>';
                $this->courses($data['subject']);
        echo '</select>
            </div>
        </div>';
        //Title
        echo '  <div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">' . _uc($_e['Question']) . '</label>
            <div class="col-sm-10  col-md-9">
                <textarea name="title" class="form-control ckeditor" placeholder="General Instructions">' . @$title . '</textarea>
            </div>
        </div>';
        echo '<div class="optionsDiv">';
        if ($isEdit) {
            $edit_count = count($options);
            $edit_count = $edit_count - 1;
            foreach ($options as $key => $value) {
                $correctIndex = $key + 1;
                $optionSelect = '';
                if ($correct == $correctIndex) {
                    $optionSelect = 'checked';
                }
                $label = '';
                if ($key == 0) {
                    $label = _uc($_e['Options']);
                }
                //Title
                echo '  <div class="form-group">
                <label class="col-sm-2 col-md-3  control-label">' . $label . '</label>
                <div class="col-sm-8  col-md-6">
                    <textarea name="options[]" class="form-control ckeditor" placeholder="">' . @$value . '</textarea>
                </div>
                <div class="col-sm-2 col-md-3">
                    <input type="radio" value="' . $correctIndex . '" name="correct" style="width: 30px;height: 30px;" ' . $optionSelect . '>
                </div>
            </div>';
            }
            echo '<input type="button" name="add_more" value="Add More" data-id="' . $edit_count . '" class="btn btn-lg btn-primary" onclick="addMoreOptions(this)" style="float: right"/> </div>';
        } else {
            //Title
            echo '  <div class="form-group">
                <label class="col-sm-2 col-md-3  control-label">' . _uc($_e['Options']) . '</label>
                <div class="col-sm-8  col-md-6">          
                    <textarea name="options[]" class="form-control ckeditor" placeholder="Options"></textarea>
                </div>
                <div class="col-sm-2 col-md-3">
                    <input type="radio" value="1" name="correct" style="width: 30px;height: 30px;">
                </div>
            </div>';
            echo '<input type="button" name="add_more" value="Add More" data-id="0" class="btn btn-lg btn-primary" onclick="addMoreOptions(this)" style="float: right"/> </div>';
        }
        echo '<button type="submit" name="submit" value="SAVE" class="btn btn-lg btn-primary">' . _u($_e['SAVE']) . '</button>';
        echo "

</div> <!-- container end -->

</form>";
    } //function end
}
?>
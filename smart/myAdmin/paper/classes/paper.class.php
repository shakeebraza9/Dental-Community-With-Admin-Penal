<?php
require_once(__DIR__ . "/../../global.php"); //connection setting db
class paper extends object_class {
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
        $_w                                                                         = array(); //homePage.php
        //homePageEdit.php
        $_w['SAVE']                                                                 = '';
        $_w['Close']                                                                = '';
        $_w['Delete Fail Please Try Again.']                                        = '';
        $_w['Paper Entry']                                                          = '';
        $_w['Added']                                                                = '';
        $_w['Papers']                                                               = '';
        $_w['ACTION']                                                               = '';
        $_w['PAYMENT']                                                              = '';
        $_w['Date']                                                                 = '';
        $_w['Select Agent']                                                         = '';
        $_w['Paper']                                                                = '';
        $_w['Payment']                                                              = '';
        $_w['Add New']                                                              = '';
        $_w['View Entries']                                                         = '';
        $_w['Paper']                                                                = '';
        $_w['File Save Successfully']                                               = '';
        $_w['Paper Entry']                                                          = '';
        $_w['Paper Entry Save Successfully']                                        = '';
        $_w['Paper Entry Save Failed,Please Enter Correct Values, And unique slug'] = '';
        $_w['SNO']                                                                  = '';
        $_w['DATE']                                                                 = '';
        $_w['TITLE']                                                                = '';
        $_w['AGENT']                                                                = '';
        $_w['Description']                                                          = '';
        $_w['DESCIRPTION']                                                          = '';
        $_w['Update']                                                               = '';
        $_w['Paper Not Found For Update']                                           = '';
        $_w['Papers']                                                               = '';
        $_w['Options']                                                              = '';
        $_w['QUESTION']                                                             = '';
        $_w['OPTIONS']                                                              = '';
        $_w['ANSWER']                                                               = '';
        $_w['Course']                                                               = '';
        $_w['Draft']                                                                = '';
        $_w['Add Domains']                                                          = '';
        $_w['Allowed Time']                                                         = '';
        $_w['Allowed Time (In Minutes)']                                            = '';
        $_w['Paper Title']                                                          = '';
        $_w['Title']                                                                = '';
        $_w['COURSES']                                                              = '';
        $_w['TOTAL QUESTIONS']                                                      = '';
        $_w['ALLOWED TIME']                                                         = '';
        $_w['QUESTIONS']                                                            = '';
        $_w['General Instructions']                                                 = '';
        $_w['Pass Result Top']                                                      = '';
        $_w['Fail Result Top']                                                      = '';
        $_w['Result Bottom']                                                        = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_w['']                                                                     = '';
        $_e                                                                         = $this->dbF->hardWordsMulti($_w, $adminPanelLanguage, 'Admin File Management');
    }
    public function paperView($userFor = false) {
        $sql  = "SELECT * FROM `paper` ORDER BY `paper_id` DESC ";
        $data = $this->dbF->getRows($sql);
        $this->printViewTable($data);
    }
    private function printViewTable($data) {
        global $_e;
        echo '<div class="table-responsive">
<table class="table table-hover dTable tableIBMS">
<thead>
<th>' . _u($_e['SNO']) . '</th>
<th>' . _u($_e['TITLE']) . '</th>
<th>' . _u($_e['COURSES']) . '</th>
<th>' . _u($_e['TOTAL QUESTIONS']) . '</th>
<th>' . _u($_e['ALLOWED TIME']) . '</th>
<th>' . _u($_e['DATE']) . '</th>
<th>' . _u($_e['ACTION']) . '</th>
</thead>';
        $i           = 0;
        $defaultLang = $this->functions->AdminDefaultLanguage();
        foreach ($data as $val) {
            $i++;
            $id              = $val['paper_id'];
            $date_timestamp  = $val['date_timestamp'];
            $title           = $val['paper_title'];
            $allowed_time    = $val['allowed_time'];
            $total_questions = $val['total_questions'];
            $paper_questions = json_decode($val['paper_questions']);
            echo "<tr>
<td>$i</td>
<td>$title</td>
<td>";
            $count      = 1;
            $limitCount = 0;
            foreach ($paper_questions as $key => $value) {
                $domain_id   = $key;
                $domain_name = $this->getSubject($domain_id, 'subject_title');
                // $limit       = $domain_limit[$limitCount];
                //echo $count.' - '.$domain_name['subject_title'].'('.$limit.')<br>';
                echo $domain_name['subject_title'];
                $count++;
                $limitCount++;
            }
            echo "</td>
<td>$total_questions</td>
<td>$allowed_time Minutes</td>
<td>$date_timestamp</td>
<td>
    <div class='btn-group btn-group-sm'>
        <a data-id='$id' href='-" . $this->functions->getLinkFolder() . "?page=edit&paperId=$id' class='btn'>
            <i class='glyphicon glyphicon-edit'></i>
        </a>
        <a data-id='$id' href='-" . $this->functions->getLinkFolder() . "?page=edit&paperId=$id&copy=1'class='btn'><i class='fa fa-clipboard'></i></a>
        <a data-id='$id' onclick='deletePaper(this);' class='btn'  style='display: none'>
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
    public function newpaperAdd() {
        global $_e;
        if (isset($_POST['title']) && isset($_POST['submit'])) {
            if (!$this->functions->getFormToken('newPaper')) {
                return false;
            }
            // echo "<pre>"; print_r($_POST); echo "</pre>";
            // exit;
            $questionId    = empty($_POST['questionId']) ? "" : json_encode($_POST['questionId']);
            $allowed_time  = empty($_POST['allowed_time']) ? "" : $_POST['allowed_time'];
            $title         = empty($_POST['title']) ? "" : $_POST['title'];
            $total_quest   = empty($_POST['total_quest']) ? "" : $_POST['total_quest'];
            $instructions  = empty($_POST['instructions']) ? "" : $_POST['instructions'];
            $aim           = empty($_POST['aim']) ? "" : $_POST['aim'];
            $domain        = empty($_POST['domain']) ? "" : $_POST['domain'];
            $objectives        = empty($_POST['objectives']) ? "" : $_POST['objectives'];
            $learning_content      = empty($_POST['learning_content']) ? "" : $_POST['learning_content'];
            $development_outcomes = empty($_POST['development_outcomes']) ? "" : $_POST['development_outcomes'];
            $publish       = empty($_POST['publish']) ? "0" : $_POST['publish'];

intval($questionId);
htmlspecialchars($allowed_time);
htmlspecialchars($title);
htmlspecialchars($total_quest);
htmlspecialchars($instructions);
htmlspecialchars($aim);
htmlspecialchars($domain);
htmlspecialchars($objectives);
htmlspecialchars($learning_content);
htmlspecialchars($development_outcomes);
intval($publish);

            try {
                $this->db->beginTransaction();
                $sql   = "INSERT INTO `paper`(
                `subject_id`, 
                `paper_title`, 
                `allowed_time`, 
                `total_questions`, 
                `paper_questions`,
                `instructions`,
                `aim`,
                `objectives`,
                `learning_content`,
                `development_outcomes`,
                `publish`
                ) 

            VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                $array = array(
                    $domain,
                    $title,
                    $allowed_time,
                    $total_quest,
                    $questionId,
                    $instructions,
                    $aim,
                    $objectives,
                    $learning_content,
                    $development_outcomes,
                    $publish
                );
                $this->dbF->setRow($sql, $array, false);
                $lastId = $this->dbF->rowLastId;
                $this->db->commit();
                if ($this->dbF->rowCount > 0) {
                    $this->functions->notificationError(_js(_uc($_e['Paper'])), _js(_uc($_e['Paper Entry Save Successfully'])), 'btn-success');
                    $this->functions->setlog(_js(_uc($_e['Paper'])), _js(_uc($_e['Paper Entry'])), _js(_uc($_e['Paper Entry Save Successfully'])));
                } else {
                    $this->functions->notificationError(_js(_uc($_e['Paper'])), _js(_uc($_e['Paper Entry Save Failed,Please Enter Correct Values, And unique slug'])), 'btn-danger');
                }
            }
            catch (Exception $e) {
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_js(_uc($_e['Paper'])), _js(_uc($_e['Paper Entry Save Failed,Please Enter Correct Values, And unique slug'])), 'btn-danger');
            }
        } //If end
    }
    public function paperEditSubmit() {
        global $_e;
        if (isset($_POST['title']) && isset($_POST['submit'])) {
            if (!$this->functions->getFormToken('editPaper')) {
                return false;
            }
            $questionId    = empty($_POST['questionId']) ? "" : json_encode($_POST['questionId']);
            $allowed_time  = empty($_POST['allowed_time']) ? "" : $_POST['allowed_time'];
            $title         = empty($_POST['title']) ? "" : $_POST['title'];
            $domain        = empty($_POST['domain']) ? "" : $_POST['domain'];
            $total_quest   = empty($_POST['total_quest']) ? "" : $_POST['total_quest'];
            $instructions  = empty($_POST['instructions']) ? "" : $_POST['instructions'];
            $aim      = empty($_POST['aim']) ? "" : $_POST['aim'];
            $objectives        = empty($_POST['objectives']) ? "" : $_POST['objectives'];
            $learning_content      = empty($_POST['learning_content']) ? "" : $_POST['learning_content'];
            $development_outcomes = empty($_POST['development_outcomes']) ? "" : $_POST['development_outcomes'];
            $publish       = empty($_POST['publish']) ? "0" : $_POST['publish'];

htmlspecialchars($questionId);
htmlspecialchars($allowed_time);
htmlspecialchars($title);
htmlspecialchars($domain);
htmlspecialchars($total_quest);
htmlspecialchars($instructions);
htmlspecialchars($aim);
htmlspecialchars($objectives);
htmlspecialchars($learning_content);
htmlspecialchars($development_outcomes);
htmlspecialchars($publish);

            try {
                $this->db->beginTransaction();
                $lastId = intval($_POST['paperId']);
                if (isset($_POST['isCopy']) && $_POST['isCopy'] == '1') {
                    $sql = "INSERT INTO `paper`(
                    `subject_id`, 
                    `paper_title`, 
                    `allowed_time`, 
                    `total_questions`, 
                    `paper_questions`,
                    `instructions`,
                    `aim`,
                    `objectives`,
                    `learning_content`,
                    `development_outcomes`,
                    `publish`
                ) VALUES (?,?,?,?,?,?,?,?,?,?)";
                } else {
                    $sql = "UPDATE `paper` SET 
                    `subject_id`=?, 
                    `paper_title`=?, 
                    `allowed_time`=?, 
                    `total_questions`=?, 
                    `paper_questions`=?,
                    `instructions`=?,
                    `aim`=?,
                    `objectives`=?,
                    `learning_content`=?,
                    `development_outcomes`=?,
                    `publish`=?
                WHERE `paper_id` = $lastId";
                }
                $array = array(
                    $domain,
                    $title,
                    $allowed_time,
                    $total_quest,
                    $questionId,
                    $instructions,
                    $aim,
                    $objectives,
                    $learning_content,
                    $development_outcomes,
                    $publish
                );
                $this->dbF->setRow($sql, $array, false);
                $lastId = $this->dbF->rowLastId;
                $this->db->commit();
                if ($this->dbF->rowCount > 0) {
                    $this->functions->notificationError(_js(_uc($_e['Paper'])), _js(_uc($_e['Paper Entry Save Successfully'])), 'btn-success');
                    $this->functions->setlog(_js(_uc($_e['Paper'])), _js(_uc($_e['Paper Entry'])), _js(_uc($_e['Paper Entry Save Successfully'])));
                } else {
                    $this->functions->notificationError(_js(_uc($_e['Paper'])), _js(_uc($_e['Paper Entry Save Failed,Please Enter Correct Values, And unique slug'])), 'btn-danger');
                }
            }
            catch (Exception $e) {
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                $this->functions->notificationError(_js(_uc($_e['Paper'])), _js(_uc($_e['Paper Entry Save Failed,Please Enter Correct Values, And unique slug'])), 'btn-danger');
            }
        } //If end
    }
    public function paperNew() {
        $this->paperEdit(true);
        return '';
    }
    public function paperEdit($new = false) {
        global $_e;
        $res_domains = $this->getDomains();
        $copy        = isset($_GET['copy']) ? intval($_GET['copy']) : 0;
        $isEdit      = false;
        if ($new === true) {
            $token = $this->functions->setFormToken('newPaper', false);
        } else {
            //For Edit Page.
            $isEdit = true;
            $token  = $this->functions->setFormToken('editPaper', false);
            $id     = $_GET['paperId'];
            $sql    = "SELECT * FROM `paper` WHERE `paper_id` = ? ";
            $data   = $this->dbF->getRow($sql,array($id));
            // $this->dbF->prnt($data);
            if ($this->dbF->rowCount == 0) {
                echo _uc($_e["Paper Not Found For Update"]);
                return false;
            }
        }
        $total_questions = 0;
        if ($isEdit) {
            $title              = empty($data['paper_title'])       ? ""  : $data['paper_title'];
            $allowed_time       = empty($data['allowed_time'])      ? "0" : $data['allowed_time'];
            $total_questions    = empty($data['total_questions'])   ? "0" : $data['total_questions'];
            $paper_questions    = empty($data['paper_questions'])   ? "" : json_decode($data['paper_questions']);
            $instruct           = empty($data['instructions'])      ? "" : $data['instructions'];
            $aim                = empty($data['aim'])              ? "" : $data['aim'];
            $objectives         = empty($data['objectives'])       ? "" : $data['objectives'];
            $learning_content   = empty($data['learning_content']) ? "" : $data['learning_content'];
            $development_outcomes = empty($data['development_outcomes']) ? "" : $data['development_outcomes'];
            $publish         = empty($data['publish']) ? "0" : $data['publish'];
        }
        $lang = $this->functions->IbmsLanguages();
        if ($lang != false) {
            $lang_nonArray = implode(',', $lang);
        }
        //No need to remove any thing,, go in developer setting table and set 0
        echo '

    <form method="post" id="paperForm" action="-paper?page=paper" class="form-horizontal" role="form" enctype="multipart/form-data"><input type="hidden" name="paperId" value="' . @$id . '"/><input type="hidden" name="isCopy" value="' . @$copy . '"/>' . $token;
        echo '<input type="hidden" name="lang" value="' . $lang_nonArray . '" />';
        echo '<div class="total_div">Total Questions : <span class="totalQuestions">' . @$total_questions . '</span></div><br><br><br><br>
        <div class="form-horizontal questionPerDomain">';
        //Paper Title
        echo '<div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">' . _uc($_e['Title']) . '</label>
            <div class="col-sm-10  col-md-9">
                <input type="text" name="title" value="' . @$title . '" class="form-control" placeholder="' . _uc($_e['Paper Title']) . '"/>
            </div>
        </div>';
        //Paper Instructions
        echo '<div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">' . _uc($_e['General Instructions']) . '</label>
            <div class="col-sm-10  col-md-9">
                <textarea name="instructions" class="form-control ckeditor" placeholder="General Instructions">' . @$instruct . '</textarea>
            </div>
        </div>';
        //Aim
        echo '<div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">Aim</label>
            <div class="col-sm-10  col-md-9">
                <textarea name="aim" class="form-control ckeditor" placeholder="Aim">' . @$aim . '</textarea>
            </div>
        </div>';
        //Objectives
        echo '<div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">Objectives</label>
            <div class="col-sm-10  col-md-9">
                <textarea name="objectives" class="form-control ckeditor" placeholder="Objectives">' . @$objectives . '</textarea>
            </div>
        </div>';
        //Learning Content
        echo '<div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">' . _uc('Learning Content') . '</label>
            <div class="col-sm-10  col-md-9">
                <textarea name="learning_content" class="form-control ckeditor" placeholder="Learning Content">' . @$learning_content . '</textarea>
            </div>
        </div>';
        //Development Outcomes
        echo '<div class="form-group">
            <label class="col-sm-2 col-md-3  control-label">' . _uc('Development Outcomes') . '</label>
            <div class="col-sm-10  col-md-9">
                <textarea name="development_outcomes" class="form-control ckeditor" placeholder="Development Outcomes">' . @$development_outcomes . '</textarea>
            </div>
        </div>';
        //Allocated Time
        echo '  <div class="form-group">
                <label class="col-sm-2 col-md-3  control-label">' . _uc($_e['Allowed Time']) . '</label>
                <div class="col-sm-10  col-md-9">
                    <input type="text" name="allowed_time" value="' . @$allowed_time . '" class="form-control" placeholder="' . _uc($_e['Allowed Time (In Minutes)']) . '"/>
                </div>
            </div>';
        //Domain
        echo '  <div class="moreDomains">';
        if ($isEdit) {
            $limitCount = 0;
            foreach ($paper_questions as $keyQuest => $valueQuest) {
                // $limitDomain = $domain_limit[$limitCount];
                echo '  <div class="form-group">
                        <label class="col-sm-2 col-md-3  control-label">' . _uc($_e['Course']) . '</label>
                        <div class="col-sm-8  col-md-6">
                            <select class="form-control domain" name="domain" required readonly>
                                <option selected disabled>-- Select Subject --</option>';
                foreach ($res_domains as $key => $value) {
                    $select_domain = ($keyQuest == $value['subject_id']) ? 'selected' : '';
                    echo '<option value="' . $value['subject_id'] . '" ' . $select_domain . '>' . $value['subject_title'] . '</option>';
                    $sql_domains2 = "SELECT * FROM `subjects` WHERE `under`='$value[subject_id]' AND `publish`='1'";
                    $res_domains2 = $this->dbF->getRows($sql_domains2);
                    foreach ($res_domains2 as $key => $value2) {
                        @$select_domain = ($keyQuest == $value2['subject_id']) ? 'selected' : '';
                        echo '<option value="' . $value2['subject_id'] . '" ' . $select_domain . '>-- ' . $value2['subject_title'] . '</option>';
                    }
                }
                echo '          </select>
                        </div>
                        <div class="col-sm-2 col-md-3">
                            <input type="number" class="form-control perDomain" value="' . @$total_questions . '" id="perDomain_' . $limitCount . '" data-index="' . $limitCount . '" name="total_quest" placeholder="Total Questions"  >
                            <!--<input type="hidden" name="total_quest" id="totalQuest" value="' . @$total_questions . '" />-->
                        </div>
                    </div>';
                $limitCount++;
            }
        } else {
            echo '<div class="form-group">
                    <label class="col-sm-2 col-md-3  control-label">' . _uc($_e['Course']) . '</label>
                    <div class="col-sm-8  col-md-6">
                        <select class="form-control domain" name="domain" required>
                            <option selected disabled>-- Select Subject --</option>';
            foreach ($res_domains as $key => $value) {
                $disabled = "";
                $ids = $this->subjectid();
                if(in_array($value['subject_id'], $ids)){
                    $disabled = "disabled";
                }
                echo '<option '.$disabled.' value="' . $value['subject_id'] . '">' . $value['subject_title'] . '</option>';
                $sql_domains2 = "SELECT * FROM `subjects` WHERE `under`='$value[subject_id]' AND `publish`='1'";
                $res_domains2 = $this->dbF->getRows($sql_domains2);
                foreach ($res_domains2 as $key => $value2) {
                    $disabled = "";
                    $ids = $this->subjectid();
                    if(in_array($value2['subject_id'], $ids)){
                        $disabled = "disabled";
                    }
                    echo '<option '.$disabled.' value="' . $value2['subject_id'] . '">-- ' . $value2['subject_title'] . '</option>';
                }
            }
            echo '          </select>
                    </div>
                    <div class="col-sm-2 col-md-3">
                        <input type="number" class="form-control perDomain" value="" id="perDomain_0" name="total_quest" placeholder="Questions Per Course" >
                    </div>
                </div>';
        }
        echo '  </div>';
        echo '</div> <!-- container end -->';
        if (!$isEdit) {
            echo '<input type="button" name="add_more" value="Add Questions" data-id="0" class="btn btn-md btn-primary" onclick="addDomainQuestions(this)" />';
        }
        echo '<div class="form-horizontal chooseQuestions">';
        if ($isEdit) {
            $return = '<h1 class="mainHeading">Choose Questions</h1>
                    <div class="questionsMainDiv">';
            $return .= '<div class="chooseQuestionsEdit">';
            $domainLimitCount = 0;
            foreach ($paper_questions as $keyQuest => $valueQuest) {
                $domain_id     = $keyQuest;
                // $questionLimit = $domain_limit[$domainLimitCount];
                $subject       = $this->getSubject($domain_id, 'subject_title');
                $subject_title = $subject['subject_title'];
                $questions     = $this->getAllQuestions($domain_id);
                if (!empty($questions)) {
                    $return .= '<div class="singleDomain">

                                <div class="domainTitle"><h3>' . $subject_title . '</h3></div>

                                <div class="domainQuestions">';
                    foreach ($questions as $key => $value) {
                        $checkQuest = (in_array($value['question_id'], $valueQuest)) ? 'checked' : '';
                        $return .= '<p><input type="checkbox" class="questionCheck limitDomain_' . $domain_id . '" name="questionId[' . $domain_id . '][]" data-id="' . $domain_id . '" data-limit="' . @$questionLimit . '" value="' . $value['question_id'] . '" onclick="countQuestions(this)" ' . $checkQuest . '><span>' . $value['question_title'] . '</span></p>';
                    }
                    $return .= '</div>

                            </div>';
                }
                $domainLimitCount++;
            }
            $return .= '</div></div>';
            echo $return;
        } else {
            echo '';
        }
        echo '</div>';
        echo '<button type="submit" id="paperSubmit" name="submit" value="SAVE" class="btn btn-lg btn-primary">' . _u($_e['SAVE']) . '</button>

</form>';
    } //function end
    
    public function getDomains($id = false) {
        $where = '';
        if ($id) {
            $where = ' AND `subject_id` = $id';
        }
        $sql_domains = "SELECT * FROM `subjects` WHERE `under`='0' AND `publish` = '1' $where";
        $res_domains = $this->dbF->getRows($sql_domains);
        return $res_domains;
    }
    public function subjectid(){
        $data = $this->dbF->getRows("SELECT `subject_id` AS `cid` FROM `paper`");
        $arr = array();
        foreach ($data as $key => $value) {
            $arr[] = $value['cid'];
        }
        return $arr;
    }
    public function getSubject($id = false, $field = false) {
        $where  = "";
        $column = "*";
        if ($id) {
            $where = " AND `subject_id` = $id";
        }
        if ($field) {
            $column = $field;
        }
        $sql = "SELECT $column FROM `subjects` WHERE 1 $where";
        $res = $this->dbF->getRow($sql);
        return $res;
    }
    public function getAllQuestions($subject = false) {
        $sql = "SELECT * FROM `questions` WHERE `subject` = '$subject'";
        $res = $this->dbF->getRows($sql);
        return $res;
    }
}
?>
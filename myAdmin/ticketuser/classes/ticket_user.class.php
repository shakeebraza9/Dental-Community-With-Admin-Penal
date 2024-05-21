<?php
require_once(__DIR__ . "/../../global.php"); //connection setting db

class ticketUser extends object_class
{
    public $productF;
    public $imageName;
    public function __construct()
    {
        parent::__construct('3');

        /**
         * MultiLanguage keys Use where echo;
         * define this class words and where this class will call
         * and define words of file where this class will called
         **/
        global $_e;
        global $adminPanelLanguage;
        $_w = array();

        $_w['View Specialty'] = '';
        $_w['Add New'] = '';
        $_w['Profile Add Successfully!'] = '';
        $_w['Profile Add Failed!'] = '';
        $_w['Employee/User Add fail please try again.!'] = '';
        $_w['Duplicate Email, User Already Exist.'] = '';
        $_w['Specialty'] = '';
        $_w['TITLE'] = '';
        $_w['Manage WebUsers'] = '';
        $_w['Verify Users'] = '';
        $_w['Not Verify'] = '';
        $_w['UnVerify Users'] = '';
        $_w['SNO']  =   '';
        $_w['USER NAME'] = '';
        $_w['Account Create'] = '';
        $_w['Account Status'] = '';
        $_w['Account Type'] = '';
        $_w['ACTION'] = '';
        $_w['Active'] = '';
        $_w['Active User'] = '';
        $_w['Address'] = '';
        $_w['Admin Update with Name : {{name}}'] = '';
        $_w['Admin User Group'] = '';
        $_w['Admin Users'] = '';
        $_w['adminUser Update fail please try again.!'] = '';
        $_w['adminUser Update fail please try again.! Or Duplicate Email.'] = '';
        $_w['Are You Sure You Want TO Update?'] = '';
        $_w['Back To WebUsers'] = '';
        $_w['Back To AdminUsers'] = '';
        $_w['Back To AdminGroups'] = '';
        $_w['City'] = '';
        $_w['Country'] = '';
        $_w['Admin Panel'] = '';
        $_w['Date Of Birth'] = '';
        $_w['DeActive'] = '';
        $_w['DeActive User'] = '';
        $_w['DeActive Users'] = '';
        $_w['Delete Email'] = '';
        $_w['Delete Fail Please Try Again.'] = '';
        $_w['Delete Group'] = '';
        $_w['Delete User'] = '';
        $_w['Draft Users'] = '';
        $_w['Edit User Info'] = '';
        $_w['Email'] = '';
        $_w['Edit User Group Permissions'] = '';
        $_w['Female'] = '';
        $_w['Gender'] = '';
        $_w['Groups'] = '';
        $_w['Group add'] = '';
        $_w['Group Name'] = '';
        $_w['GROUP NAME'] = '';
        $_w['Group Update'] = '';
        $_w['Invalid Email Address! Or Some Thing Went Wrong'] = '';
        $_w['ITEMS IN CART'] = '';
        $_w['Last Update'] = '';
        $_w['Male'] = '';
        $_w['Manage AdminUsers'] = '';
        $_w['Manage Admin Groups'] = '';
        $_w['Name'] = '';
        $_w['New Admin Add with Name : {{name}}'] = '';
        $_w['New Admin User group Add with name : {{name}}'] = '';
        $_w['New AdminUser'] = '';
        $_w['New Group'] = '';
        $_w['New Group Add Failed'] = '';
        $_w['New Group Add Successfully'] = '';
        $_w['New Group Update Failed'] = '';
        $_w['New Group Update Successfully'] = '';
        $_w['Not Access'] = '';
        $_w['New Users'] = '';
        $_w['ORDER CANCEL'] = '';
        $_w['ORDER DONE'] = '';
        $_w['ORDER PENDING'] = '';
        $_w['ORDER STATUS'] = '';
        $_w['ORDER SUBMIT'] = '';
        $_w['OTHERS STATUS'] = '';
        $_w['OWNER'] = '';
        $_w['Selected SubTotal'] = '';
        $_w['User Orders'] = '';
        $_w['Password'] = '';
        $_w['Password Not Matched!'] = '';
        $_w['Password Required!'] = '';
        $_w['Permissions'] = '';
        $_w['Phone'] = '';
        $_w['Post Code'] = '';
        $_w['Profile Update Failed!'] = '';
        $_w['Profile Update Successfully!'] = '';
        $_w['Read Only'] = '';
        $_w['Read, Write and Delete'] = '';
        $_w['Retype Password'] = '';
        $_w['Save'] = '';
        $_w['This Is Owner Account Please Go Back:'] = '';
        $_w['Update'] = '';
        $_w['Update AdminUser'] = '';
        $_w['Update Fail Please Try Again.'] = '';
        $_w['USER EMAIL'] = '';
        $_w['USER FROM'] = '';
        $_w['User Group'] = '';
        $_w['Users'] = '';
        $_w['WebUsers'] = '';
        $_w['WebUser Update fail please try again.!'] = '';
        $_w['Write Only'] = '';
        $_w['Client Management'] = '';
        $_w['Page Not Found.'] = '';
        $_w['Admin User'] = '';
        $_w['Admin User group Update with name : {{name}}'] = '';
        $_w['Make Sponsor'] = '';
        $_w['DeActive Sponsor'] = '';
        $_w['Are You Sure You Want TO Change Sponsor Status?'] = '';
        $_w['Employee'] = '';
        $_w['Yes'] = '';
        $_w['No'] = '';
        $_w['Designation'] = '';
        $_w['Interests'] = '';
        $_w['Image'] = '';
        $_w['Basic'] = '';
        $_w['User Type'] = '';
        $_w['Gold'] = '';
        $_w['Platinum'] = '';
        $_w['Sort Position'] = '';
        $_w['Client Name'] = '';
        $_w['Client Practice'] = '';
        $_w['Client Email'] = '';
        $_w['Client Contact'] = '';
        $_w['Client Package'] = '';
        $_w['Client'] = '';
        $_w['Submit'] = '';
        $_w['Location'] = '';
        $_w['Priority'] = '';
        $_w['Category'] = '';
        $_w['DESCRIPTION'] = '';
        $_w['Description'] = '';
        $_w['Status'] = '';
        $_w['Date'] = '';
        $_w['DATE'] = '';
        $_w['CATEGORY'] = '';
        $_w['PRIORTY'] = '';
        $_w['PRACTICE NAME'] = '';
        $_w['EMAIL'] = '';
        $_w['PACKAGE'] = '';
        $_w['NAME'] = '';

        $_e    =   $this->dbF->hardWordsMulti($_w, $adminPanelLanguage, "Users Management");
    }

    public function userSelectOptionList()
    {
        //Payment type select box create
        $sql  = "SELECT acc_id,acc_name,acc_email FROM accounts_user WHERE acc_type = '1' ORDER BY acc_name ASC ";
        $data =  $this->dbF->getRows($sql);
        $option = '';
        foreach ($data as $key => $val) {
            $option .= "<option value='$val[acc_id]'>$val[acc_name] -- ($val[acc_email])</option>";
        }
        return $option;
    }
    public function userView()
    {
        global $_e;
        echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                        <th>' . _u($_e['SNO']) . '</th>
                        <th>' . _u($_e['NAME']) . '</th>
                        <th>' . _u($_e['PRACTICE NAME']) . '</th>
                        <th>' . _u($_e['EMAIL']) . '</th>
                        <th>' . _u('CONTACT') . '</th>
                        <th>' . _u($_e['PACKAGE']) . '</th>
                        <th>' . _u($_e['DATE']) . '</th>
                        <th>' . _u($_e['ACTION']) . '</th>
                    </thead>
                <tbody>';
        $sql  = "SELECT * FROM `clients` ORDER BY c_id DESC";
        $data =  $this->dbF->getRows($sql);
        $i  = 0;
        foreach ($data as $val) {
            $i++;
            $id = $val['c_id'];
            echo "<tr>
                    <td>$i</td>
                    <td>$val[c_name]</td>
                    <td>$val[c_practice_name]</td>
                    <td>$val[c_email]</td>
                    <td>$val[c_contact]</td>
                    <td>$val[c_package]</td>
                    <td>$val[c_acc_create]</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-id='$id' href='-ticketuser?page=edit&id=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>

                            <a data-id='$id' onclick='UserDelete(this);' class='btn'   title='" . $_e['Delete Email'] . "'>
                                <i class='glyphicon glyphicon-trash trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>
                        </div>
                    </td>
                    ";
        }
        echo '</tbody>
             </table>
            </div> <!-- .table-responsive End -->';
    }

    public function userSubmit()
    {
        global $_e;
        if (isset($_POST['Submit'])) {

            if (!$this->functions->getFormToken('UserAdd')) {
                return false;
            }
            $name     = empty($_POST['name']) ? "" : $_POST['name'];
            $pname   = empty($_POST['practice']) ? "" : $_POST['practice'];
            $email   = empty($_POST['email']) ? "" : $_POST['email'];
            $contact  = empty($_POST['contact']) ? "" : $_POST['contact'];
            $package   = empty($_POST['package']) ? "" : $_POST['package'];

            try {
                $this->db->beginTransaction();
                $date = date('Y-m-d H:i:s');
                $sql = "INSERT INTO `clients` (`c_name`, `c_practice_name`, `c_email`, `c_contact`, `c_package`, `c_acc_create`) 
                VALUES ( ?, ?, ?, ?, ?, ?)";
                $array = array($name, $pname, $email, $contact, $package, $date);
                $this->dbF->setRow($sql, $array, false);

                $this->db->commit();

                if ($this->dbF->rowCount > 0) {
                    $msg = $_e['Profile Add Successfully!'];
                } else {
                    $msg = $_e['Profile Add Failed!'];
                }
                return $msg;
            } catch (PDOException $e) {
                $msg = $_e['Employee/User Add fail please try again.!'];
                $this->db->rollBack();
                return $msg;
            }
        }
        return "";
    }

    public function webUserInfoArray($data, $settingName)
    {
        foreach ($data as $val) {
            if ($val['setting_name'] == $settingName) {
                return $val['setting_val'];
            }
        }
        return "";
    }

    public function userAdd($new = false)
    {
        global $_e;

        $token  =    $this->functions->setFormToken('UserAdd', false);

        //$employeePage = $this->functions->developer_setting('employeePage');
        echo '<form class="form-horizontal" role="form" method="post"> ' . $token . '
         <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">' . $_e['Client Name'] . '</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="user"
                        placeholder="' . $_e['Client Name'] . '" required onChange="filter(this); vali()">
                    </div>
                </div>
                <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">' . $_e['Client Practice'] . '</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="practice"
                        placeholder="' . $_e['Client Practice'] . '" required onChange="filter(this); vali()">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label" >' . $_e['Client Email'] . '</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" id="inputEmail3" placeholder="' . $_e['Client Email'] . '" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">' . $_e['Client Contact'] . '</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="contact" id="user"
                             placeholder="' . $_e['Client Contact'] . '"  required onChange="filter(this); vali()">
                    </div>
                </div>
                <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">' . $_e['Client Package'] . '</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="package" id="user"
                               placeholder="' . $_e['Client Package'] . '"  required onChange="filter(this); vali()">
                               </div>
                </div>
                ';
        echo '<div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="Submit" id="signup_btn" class="btn btn-primary defaultSpecialButton" onClick="subf()">
                               ' . $_e['Submit'] . '
                        </button>
                    </div>
                </div>
            </form>
            ';
    }
    public function userEditSubmit()
    {
        global $_e;
        if (isset($_POST['Submit'])) {


            if (!$this->functions->getFormToken('editUser')) {
                return false;
            }
            $id     = empty($_POST['oldId']) ? "" : $_POST['oldId'];
            $name     = empty($_POST['name']) ? "" : $_POST['name'];
            $pname   = empty($_POST['practice']) ? "" : $_POST['practice'];
            $email   = empty($_POST['email']) ? "" : $_POST['email'];
            $contact  = empty($_POST['contact']) ? "" : $_POST['contact'];
            $package   = empty($_POST['package']) ? "" : $_POST['package'];

            try {
                $this->db->beginTransaction();
                $date = date('Y-m-d H:i:s');
                $sql = "UPDATE `clients` SET 
                c_name = ?, c_practice_name = ?, c_email = ? , c_contact = ?, c_package = ? WHERE c_id = '$id'";
                $array = array($name, $pname, $email, $contact, $package);
                $this->dbF->setRow($sql, $array, false);

                $this->db->commit();

                if ($this->dbF->rowCount > 0) {
                    $msg = $_e['Profile Update Successfully!'];
                } else {
                    $msg = $_e['Profile Update Failed!'];
                }
                return $msg;
            } catch (PDOException $e) {
                $msg = $_e['Employee/User Add fail please try again.!'];
                $this->db->rollBack();
                return $msg;
            }
        }
        return "";
    }
    public function webUserEdit($id = '', $new = false)
    {
        global $_e;
        $token  =    $this->functions->setFormToken('editUser', false);

        if ($new == false) {
            $sql    = "SELECT * FROM clients WHERE c_id = '$id'";
            $userData   =   $this->dbF->getRow($sql);
            if (!$this->dbF->rowCount) {
                return false;
            }
        }

        $employeePage = $this->functions->developer_setting('employeePage');

        echo '<form class="form-horizontal" action="-ticketuser?page=ticket_user" role="form" method="post">' . $token . '
        <input type="hidden" name="oldId" value="' . $id . '"/>
                 <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">' . $_e['Client Name'] . '</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="user" value="' . @$userData['c_name'] . '"
                        placeholder="' . $_e['Client Name'] . '" required onChange="filter(this); vali()">
                    </div>
                </div>
                <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">' . $_e['Client Practice'] . '</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="practice" value="' . @$userData['c_practice_name'] . '"
                        placeholder="' . $_e['Client Practice'] . '" required onChange="filter(this); vali()">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label" >' . $_e['Client Email'] . '</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" id="inputEmail3" value="' . @$userData['c_email'] . '"
                        placeholder="' . $_e['Client Email'] . '" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">' . $_e['Client Contact'] . '</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="contact" id="user" value="' . @$userData['c_contact'] . '"
                             placeholder="' . $_e['Client Contact'] . '"  required onChange="filter(this); vali()">
                    </div>
                </div>
                <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">' . $_e['Client Package'] . '</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="package" id="user" value="' . @$userData['c_package'] . '"
                               placeholder="' . $_e['Client Package'] . '"  required onChange="filter(this); vali()">
                               </div>
                </div>
                ';
        echo '<div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="Submit" id="signup_btn" class="btn btn-primary defaultSpecialButton" onClick="subf()">
                               ' . $_e['Submit'] . '
                        </button>
                    </div>
                </div>
            </form>
            ';
    }
}
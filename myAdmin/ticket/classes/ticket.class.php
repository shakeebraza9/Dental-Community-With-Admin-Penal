<?php
require_once(__DIR__ . "/../../global.php"); //connection setting db

class clientUsers extends object_class
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
        $_w['Add New Client'] = '';
        
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
        $_w['Ticket Response'] = '';
        $_w['Create Ticket'] = '';
        $_w['Response'] = '';
        $_w['Message'] = '';
        $_w['Date'] = '';
        $_w['View Ticket'] = '';
        $_w['MESSAGE'] = '';
        $_w['STATUS'] = '';
        $_w['TICKET NO'] = '';
        $_w['Response By'] = '';




        $_e    =   $this->dbF->hardWordsMulti($_w, $adminPanelLanguage, "Users Management");
    }

    public function ticketView()
    {
        global $_e;
        echo '<div class="table-responsive">
                <table class="table table-hover dTable tableIBMS">
                    <thead>
                        <th>' . _u($_e['SNO']) . '</th>
                        <th>' . _u($_e['NAME']) . '</th>
                        <th>' . _u($_e['USER EMAIL']) . '</th>
                        <th>' . _u('STATUS') . '</th>
                        <th>' . _u($_e['PRIORTY']) . '</th>
                        <th>' . _u($_e['CATEGORY']) . '</th>
                        <th>' . _u($_e['DESCRIPTION']) . '</th>
                        <th>' . _u($_e['DATE']) . '</th>
                        <th>' . _u($_e['ACTION']) . '</th>
                    </thead>
                <tbody>';
        $sql  = "SELECT * FROM `ticket` ORDER BY t_num DESC";
        $data =  $this->dbF->getRows($sql);
        $i  = 0;
        foreach ($data as $val) {
            $i++;
            $id = $val['client_id'];
            $id2 = $val['t_num'];
            $sql2  = "SELECT * FROM `clients` WHERE c_id = '$id'";
            $data2 =  $this->dbF->getRow($sql2);
            echo "<tr>
                    <td>$i</td>
                    <td>$data2[c_name]</td>
                    <td>$data2[c_email]</td>
                    <td>$val[t_status]</td>
                    <td>$val[t_priority]</td>
                    <td>$val[t_category]</td>
                    <td>$val[t_desc]</td>
                    <td>$val[t_date]</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-id='$id' href='-ticket?page=edit&id=$id' class='btn'>
                                <i class='glyphicon glyphicon-edit'></i>
                            </a>

                            <a data-id='$id' onclick='ticketDelete(this);' class='btn'   title='" . $_e['Delete Email'] . "'>
                                <i class='glyphicon glyphicon-trash trash'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>
                            <a data-id='$id' href='-ticket?page=response&id=$id&t_id=$id2'  class='btn'   title='" . $_e['Response'] . "'>
                                <i class='glyphicon glyphicon-comment'></i>
                                <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>
                            </a>
                            <a data-id='$id2' href='-ticket?page=responseview&id=$id&t_id=$id2'  class='btn'   title='" . $_e['Response'] . "'>
                                <i class='glyphicon glyphicon-share'></i>
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
    
    public function submitTicket()
    {
        global $_e;
        if (isset($_POST['submit'])) {

            if (!$this->functions->getFormToken('ticketSubmit')) {
                return false;
            }


            $client    = empty($_POST['client']) ? "" : $_POST['client'];
            $status   = empty($_POST['status']) ? "" : $_POST['status'];
            $priority   = empty($_POST['priority']) ? "" : $_POST['priority'];
            $cat  = empty($_POST['category']) ? "" : $_POST['category'];
            $desc  = empty($_POST['desc']) ? "" : $_POST['desc'];
            $date = empty($_POST['calender']) ? "" : $_POST['calender'];

            // $sql2 = "SELECT c_email FROM clients where c_id = $client";
            // $to =  $this->dbF->setRow($sql2);

            // $msg = '<table border="1">';
            // foreach ($_POST['form'] as $key => $val) {
            //     $msg .= '
            //         <tr>
            //             <td>' . ucwords(str_replace("_", " ", $key)) . '</td>
            //             <td>' . $val . '</td>
            //         </tr>
            //     ';
            // }

            // $subject = $_POST['form']['subject'];

            // $msg .= '<tr>	<td>Date Time</td>	<td>' . date("D j M Y g:i a") . '</td> </tr>';
            // $msg .= '</table>';

            // $thankT = $this->dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.', false);

            // // $to = $this->functions->ibms_setting('Email');
            // if ($this->functions->send_mail($to, 'Ticket Form', $msg)) {
            //     $pMmsg = "$thankT";
            // } else {
            //     $errorT = $this->dbF->hardWords('An Error occured while sending your mail. Please Try Later', false);
            //     $pMmsg = "$errorT";
            // }


            // $nameUser =   $_POST['client'];
            // $to =   $_POST['email'];



            // if ($this->functions->send_mail($to, '', '', 'contactFormSubmit', $nameUser)) {
            //     $pMmsg = "$thankT";
            // } else {
            //     $errorT = $this->dbF->hardWords('An Error occured while sending your mail. Please Try Later', false);
            //     $pMmsg = "$errorT";
            // }
            // if ($pMmsg != '') {
            //     echo "<div class='alert alert-info'>$pMmsg</div>";
            // }

            try {
                $this->db->beginTransaction();
                $date = date('Y-m-d H:i:s');
                $sql = "INSERT INTO `ticket`(`client_id`, `t_desc`, `t_status`, `t_category`, `t_priority`, `t_date`) 
                VALUES ( ?, ?, ?, ?, ?, ?)";
                $array = array($client, $desc, $status, $cat, $priority, $date);
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

            return "";
        } //If end
    }

    public function ticketEditSubmit()
    {
        global $_e;
        if (isset($_POST['Submit'])) {

            if (!$this->functions->getFormToken('editTicket')) {
                return false;
            }
            $id     = empty($_POST['oldId']) ? "" : $_POST['oldId'];
            $status   = empty($_POST['status']) ? "" : $_POST['status'];
            $priorty   = empty($_POST['priority']) ? "" : $_POST['priority'];
            $category   = empty($_POST['category']) ? "" : $_POST['category'];
            $desc  = empty($_POST['desc']) ? "" : $_POST['desc'];
            $date  = empty($_POST['calender']) ? "" : $_POST['calender'];

            try {
                $this->db->beginTransaction();
                $date = date('Y-m-d H:i:s');
                $sql = "UPDATE `ticket` SET 
                 t_status = ?, t_priority = ?, t_category = ?, t_desc = ?, t_date = ? WHERE client_id = '$id'";
                $array = array($status, $priorty, $category, $desc, $date);
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
    
    public function ticketResponseSubmit()
    {
        global $_e;
        if (isset($_POST['Submit'])) {

            if (!$this->functions->getFormToken('responseTicket')) {
                return false;
            }
            $t_id     = empty($_POST['t_id']) ? "" : $_POST['t_id'];
            $responseby   = empty($_POST['name']) ? "" : $_POST['name'];
            $status   = empty($_POST['status']) ? "" : $_POST['status'];
            $response   = empty($_POST['msg']) ? "" : $_POST['msg'];
            $date  = empty($_POST['date']) ? "" : $_POST['date'];

            try {
                $this->db->beginTransaction();
                $date = date('Y-m-d H:i:s');
                $sql = "INSERT INTO `ticket_respond`(`ticket_num`,`status`,`response_by`, `response`,`date`) VALUES 
                (? , ? , ? , ?, ?)";
                $array = array($t_id, $status, $responseby, $response, $date);
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
    
    public function webUserInfoArray($data, $settingName)
    {
        foreach ($data as $val) {
            if ($val['setting_name'] == $settingName) {
                return $val['setting_val'];
            }
        }
        return "";
    }

    public function ticketAdd($new = false)
    {
        global $_e;
        $sql = "SELECT * FROM `clients` ORDER BY c_id DESC;";
        $employeePage = $this->functions->developer_setting('employeePage');
        $client =  $this->dbF->getRows($sql);
        $token = $this->functions->setFormToken('ticketSubmit', false);
        echo '<form action="-ticket?page=ticket" class="form-horizontal" role="form" method="post" >' . $token . '
        <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">' . $_e['Client'] . '</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="client" required>
                        <option value="" disabled selected>Select</option>';

        foreach ($client as $val) {
            echo "<option value=" . $val['c_id'] . ">" . $val['c_name'] . "</option>
            ";
        }

        echo '</select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" >' . $_e['Status'] . '</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="status" required>
                         <option value="" disabled selected>Select</option>
                         <option value="Open">Open</option>
                         <option value="Closed">Closed</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" >' . $_e['Priority'] . '</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="priority" required>
                        <option value="" disabled selected>Select</option>
                         <option value="Normal">Normal</option>
                         <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label" >' . $_e['Category'] . '</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="category" required>
                        <option value="" disabled selected>Select</option>
                         <option value="Development Issue">Development Issue</option>
                         <option value="Assistance Issue">Assistance Issue</option>
                         <option value="Request New Feature">Request New Feature</option>
                         <option value="Complaince">Complaince</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">' . $_e['Description'] . '</label>
                    <div class="col-sm-10">
                   <textarea class="form-control" name="desc" placeholder="' . $_e['Description'] . '"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="submit" id="signup_btn" class="btn btn-primary defaultSpecialButton" onClick="subf()">
                               ' . $_e['Submit'] . '
                        </button>
                        <button type="submit" name="submit" id="" class="btn btn-primary defaultSpecialButton" onClick="">
                               ' . $_e['Add New Client'] . '
                        </button>
                    </div>
                </div>
            </form>


            ';
    }

    public function ticketEdit($id = '', $new = false)
    {
        global $_e;
        $token  =    $this->functions->setFormToken('editTicket', false);

        if ($new == false) {
            $sql    = "SELECT * FROM ticket WHERE client_id = '$id'";
            $userData   =   $this->dbF->getRow($sql);
            if (!$this->dbF->rowCount) {
                return false;
            }
            $sql    = "SELECT * FROM clients WHERE c_id = ?";
            $userInfo   = $this->dbF->getRows($sql, array($id));
        }

        // $employeePage = $this->functions->developer_setting('employeePage');


        echo '<form class="form-horizontal" action="-ticket?page=ticket" role="form" method="post">' . $token . '
        <input type="hidden" name="oldId" value="' . $id . '"/>
        <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">' . $_e['Client'] . '</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="client" value="' . @$userInfo['c_name'] . ' "  required>
                    ';

        foreach ($userInfo as $val) {
            echo "<option value=" . $val['c_id'] . ">" . $val['c_name'] . "</option>
            ";
        }
        echo '</select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" >' . $_e['Status'] . '</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="status" required> ' . @$userData['t_status'] . '
                        <option value="Open">Open</option>
                         <option value="Closed">Closed</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" >' . $_e['Priority'] . '</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="priority" required>' . @$userData['t_priority'] . '
                         <option value="Normal">Normal</option>
                         <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label" >' . $_e['Category'] . '</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="category" required>' . @$userData['t_category'] . '
                         <option value="Development Issue">Development Issue</option>
                         <option value="Assistance Issue">Assistance Issue</option>
                         <option value="Request New Feature">Request New Feature</option>
                         <option value="Complaince">Complaince</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">' . $_e['Description'] . '</label>
                    <div class="col-sm-10">
                   <textarea class="form-control" name="desc" placeholder="Description">' . @$userData['t_desc'] . '</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="Submit" id="signup_btn" class="btn btn-primary defaultSpecialButton" onClick="subf()">
                               ' . $_e['Submit'] . '
                        </button>
                    </div>
                </div>
            </form>
            ';
    }
    
    public function ticketResponse($id = '', $t_id = '', $new = false)
    {
        global $_e;
        $token  =    $this->functions->setFormToken('responseTicket', false);

        if ($new == false) {
            $sql    = "SELECT * FROM ticket WHERE client_id= '$id'";
            $userData   =   $this->dbF->getRow($sql);
            if (!$this->dbF->rowCount) {
                return false;
            }
        }
        echo '<form class="form-horizontal" role="form" method="post">' . $token . '
        <input type="hidden" name="t_id" value="' . $t_id . '"/>
        <input class="form-control" type="hidden" name="name" value="' . $_SESSION['_name'] . '"/>
                <div class="form-group">
                    <label class="col-sm-2 control-label" >' . $_e['Status'] . '</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="status" required>' . @$userData['t_status'] . '
                         <option value="Open">Open</option>
                         <option value="Closed">Closed</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">' . $_e['Message'] . '</label>
                    <div class="col-sm-10">
                    <textarea class="form-control" name="msg" placeholder="' . $_e['Message'] . '" required></textarea>
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
        // $this->dbF->prnt($_SESSION['_name']);
    }
    
    public function responseView($id, $t_id)
    {
        global $_e;
        $sql  = "SELECT * FROM `ticket_respond` WHERE ticket_num = $t_id ORDER BY `date` DESC";
        $data =  $this->dbF->getRows($sql);
        $sql2  = "SELECT * FROM `ticket` WHERE t_num = $t_id";
        $data1 =  $this->dbF->getRow($sql2);
        // var_dump($data);
        echo ' <div class="container">
                <div class="row">
                <center>
                <h4><b>Ticket Issue:</b> ' . $data1['t_desc'] . ' </h4>
                </center> 
                ';
        foreach ($data as $val) {

            echo '
            <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Status: ' . $val['status'] . '</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Response By: ' . $val['response_by'] . '</h5>
                        <p class="card-text">Message: ' . $val['response'] . '</p>
                        <p class="card-text">Date: ' . $val['date'] . '</p>
                    </div>
                </div>';
        }
        echo '
            </div>
         </div>';
    }
}
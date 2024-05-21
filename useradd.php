<?php 
include_once("global.php");

global $dbF,$webClass;

$user = intval($_SESSION['currentUser']);
$id = intval($_GET['id']);
$sql = "SELECT * FROM `eventmanagement` WHERE `id`=(SELECT `title_id` FROM `userevent` WHERE `id`=?)";
$data = $dbF->getRow($sql,array($id));

$sql2 = "SELECT `due_date` FROM `userevent` WHERE `id`=?";
$data2 = $dbF->getRow($sql2,array($id));

?>
                <div class="event_details" id="myform">
                    <h3>Add Employee</h3>
                
                <div class="form_side">
                    <form method="post" action="calendar" enctype="multipart/form-data">
                        <?php echo $functions->setFormToken('newEvent',false); ?>
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Name" required>
                        <label for="Name">Name</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Email" required>
                        <label for="Email">Email</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Enrollment Number" required>
                        <label for="Enrollment Number">Enrollment Number</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Contracted Hour" required>
                        <label for="Contracted Hour">Contracted Hour</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Holiday Entitlement" required>
                        <label for="Holiday Entitlement">Holiday Entitlement</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Salary" required>
                        <label for="Salary">Salary</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Start Date" required>
                        <label for="Start Date">Start Date</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Roll" required>
                        <label for="Roll">Roll</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Date Of Birth" required>
                        <label for="Date Of Birth">Date Of Birth</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Phone" required>
                        <label for="Phone">Phone</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Interests" required>
                        <label for="Interests">Interests</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Address" required>
                        <label for="Address">Address</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Post Code" required>
                        <label for="Post Code">Post Code</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="City" required>
                        <label for="City">City</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="desc" placeholder="Country" required>
                        <label for="Country">Country</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <input type="submit" class="submit_class" value="SUBMIT INFORMATION" name="submit">
                    </form>
                </div><!-- form_side close -->
                </div><!-- event_details -->
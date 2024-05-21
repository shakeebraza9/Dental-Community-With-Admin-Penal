<?php 
include_once("global.php");
global $dbF,$webClass;

$id = htmlspecialchars($_GET['id']);
$category = htmlspecialchars($_GET['category']);

$sql = "SELECT * FROM `userdocuments` WHERE `id`= ?";
$data = $dbF->getRow($sql,array($id));

$sql2 = "SELECT title FROM `documents` WHERE `id`='$data[title_id]'";
$data2 = $dbF->getRow($sql2);

?>
                <div class="event_details" id="myform">
                    <h3><?php echo _uc($category) ?></h3>
                <div class="form_side">
                    <form method="post" action="training-and-documents?category=<?php echo $category ?>" enctype="multipart/form-data">
                        <?php echo $functions->setFormToken('TrainigDocument',false); ?>
                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                    <div class="branches_side_input branches_side_textarea">
                        <input name="title" value="<?php echo $data2['title'] ?>" readonly>
                        <label for="Title">Title</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="user" value="<?php echo $functions->UserName($data['user']) ?>" readonly>
                        <label for="user">Employee</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="c_date" type="date">
                        <label for="c_date">Completion Date</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <input name="e_date" type="date">
                        <label for="e_date">Expiry Date</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <textarea name="desc" placeholder="Description" required><?php echo $data['desc'] ?></textarea>
                        <label for="Details">Details</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="file" name="document" placeholder="File">
                        <label for="File">File</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <input type="submit" class="submit_class" value="SUBMIT" name="submit">
                    </form>
                </div><!-- form_side close -->
                </div><!-- event_details -->
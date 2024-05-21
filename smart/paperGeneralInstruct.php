<?php 

include_once('global.php');

global $dbF;



$login       =  $webClass->userLoginCheck();

if(!$login){

    //if user not login then go to login page

    header("Location: login.php");

}



?>





<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">General Instructions</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <?php 

          $test_id = md5($paper_id.':'.$user_id);

          $_SESSION['assigned_id'] = $res['assign_id'];

          $_SESSION['total_questions'] = $total_questions;

          // $_SESSION['remain_question'] = 0;

         ?>

        <form method="post" action="take_test.php?test_id=<?php echo $test_id; ?>&st=start" id="generalInsFrom">

            <?php $webClass->setFormToken('generalInstToken'); ?>

            <input type="hidden" name="paper_id" value="<?php echo @$paper_id ?>" />

            <input type="hidden" name="user_id" value="<?php echo @$user_id ?>" />

            <input type="hidden" name="allowed_time" value="<?php echo @$allowed_time ?>" />

            <input type="hidden" name="total_questions" value="<?php echo @$total_questions ?>" />

            <input type="hidden" name="assign_id" value="<?php echo @$res['assign_id'] ?>" />

            <div class="form-group">

            	<div>

            		<?php if(!empty($res)){ echo $paperDetail['instructions']; }?>

            	</div><br>

                

                <input type="checkbox" id="instCheck" name="read" required><label for="instCheck">I read it.</label> 

            </div>

        </form>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        <button type="button" class="btn btn-primary" id="submitIns">Continue</button>

      </div>

    </div>

  </div>

</div>
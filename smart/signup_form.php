<?php
global $dbF;
global $db,$functions;
$dbp = $db;
?>

<div class="newlogin_main" id="login_form">
    <form action="" role="form" method="post">
        <?php $functions->setFormToken('signInUser'); ?>
        <div class="form-group fa-envelope">
            <input type="text" name="email" placeholder="Email">
        </div>
        <div class="form-group fa-key">
            <input type="password" name="pass" placeholder="Password">
        </div>
        <div class="newtooltip">
            <input type="checkbox" id="me"><label for="me">&nbsp;&nbsp;Remember me</label>
            <a href="<?php echo WEB_URL ?>/forget-password"><?php $dbF->hardWords('Forgot Password');?></a>
        </div>
        <!-- tooltip close -->
        <input type="submit" name="submit" class="submit_class_newlogin" value="Login">
    </form>
</div>
<!-- md-card-content close -->
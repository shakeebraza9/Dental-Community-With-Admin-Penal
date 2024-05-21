<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

$option = $functions->eventCategory();

include_once('header.php');

include'dashboardheader.php'; ?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="standard">
            <div class="profile rota" style="padding-top: 50px;">
                <form method="post" action="myuploads" enctype="multipart/form-data">
                    <?php echo $functions->setFormToken('files',false); ?>
                    <input name="url" type="hidden">
                    <input name="file" type="hidden">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Title</label>
                            <input name="title" type="text">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Select Category</label>
                            <select name="category" class="categ">
                                <?php echo $option; ?>
                            </select>
                        </div>
                         <div class="form-group col-md-6">
                            <label>Sub Category</label>
                            <input name="sub_category" type="text">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Add this document to Staff HR file</label>
                            <label class="switch">
                                <input type="checkbox" name="dchk" value="1">
                                <span class="slider">Yes No</span>
                            </label>
                        </div>
                        <div class="form-group document col-md-6" style="display: none;">
                            <label>Document Category</label>
                            <select name="dcategory">
                                <option value="Training">Training</option>
                                <option value="Recruitment">Recruitment</option>
                                <option value="Signed Policies">Signed Policies</option>
                                 <option value="Minute Meeting">Minute Meeting</option>
                                <option value="MHRA">MHRA Alerts</option>
                                <option value="Additional Document">Additional Document</option>
                            </select>
                        </div>
                         <div class="form-group document col-md-6" style="display: none;">
                        <label>Document Sub Category</label>
                            <input name="sub_dcategory" type="text">
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="form-group col-12">
                        <div class="errmsg"></div>
                        <input type="submit" class="submit_class" value="Submit" id="<?php echo $_COOKIE['id'] ?>" name="submit">
                    </div>
                </div>
            </div>
        </div>
        <!-- profile rota -->
        <iframe src="<?php echo $_COOKIE['editurl'] ?>"></iframe>
    </div>
    <!-- left_right_side -->
    <style>
    .left_right_side:before {
        display: none;
    }

    iframe {
        width: 100%;
        height: 800px;
        border: none;
        margin: 20px 0;
    }
    </style>
    <script>
    $('.switch').on('change', function() {
        if ($(this).find('input').is(':checked')) {
            $('.document').slideDown(600);
        } else {
            $('.document').slideUp(600);
        }
    });

    $('.submit_class').on('click', function() {
        var id = this.id;
        var file = localStorage.getItem("url");
        $('input[name=url]').val(id);
        $('input[name=file]').val(file);
        title = $('input[name=title]').val();
        if (title == '') {
            $('.errmsg').text('All Fields Required');
        } else {
            $('.errmsg').text('');
            $('form').submit();
        }
    });
    </script>
    <?php include_once('footer.php'); ?>
<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php');

include'dashboardheader.php'; ?>
<div class="index_content mypage">
    <div class="left_right_side">
        <br>
        <button class="APIedit submit_class" id="<?php echo $_COOKIE['id'] ?>">Close Document</button>
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

        .APIedit {
            margin-top: 0;
            margin-left: auto;
            margin-right: auto
        }
    </style>
    <script>

        $('.APIedit').on('click', function() { 
            var id = this.id;
            var url = localStorage.getItem("url");
            var windowurl = localStorage.getItem("windowurl");
            var result = confirm("Are you sure you want to close?");
            if (result) {
                start_loader();
                $.ajax({
                    type: 'post',
                    data: {id:id,url:url},
                    url: 'ajax_call.php?page=deleteDoc',                
                }).done(function(data) {
                    if (data == '1') {
                        $.get("https://script.google.com/macros/s/AKfycbyuk1OhMBi_6g4HeCJ8XAnJMVPGItUgTlCAEw7sVQPohEVLYIaa/exec?id="+id);
                        $.get("https://script.google.com/macros/s/AKfycbz-TqmRVtMGL8KEf8I-cC4c0vpkU1DtaLfb3Tn-9w8ZN4p8aK8J/exec");
                        location.replace(windowurl);
                    }
                });
            }
        });
    </script>
<?php include_once('footer.php'); ?>
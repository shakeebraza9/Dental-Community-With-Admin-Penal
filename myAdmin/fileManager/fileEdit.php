<?php
ob_start();
?>
        <button class="APIedit btn btn-primary" id="<?php echo $_COOKIE['id'] ?>">Close Document</button>
        <iframe src="<?php echo $_COOKIE['editurl'] ?>"></iframe>
    
    <style>
        iframe {
            width: 100%;
            height: 800px;
            border: none;
            margin: 20px 0;
        }

        .APIedit {
            display: block;
            margin: auto;
        }
    </style>
    <script>

        $('.APIedit').on('click', function() {
            var id = this.id;
            var url = localStorage.getItem("url");
            var result = confirm("Are you sure you want to close?");
            if (result) {
                $(this).prop('disabled', true);
                $.ajax({
                    type: 'post',
                    data: {id:id,url:url},
                    url: '../ajax_call.php?page=deleteDoc',                
                }).done(function(data) {
                    if (data == '1') {
                        location.replace("<?php echo WEB_ADMIN_URL ?>/-fileManager?page=fileManager");
                    }
                });
            }
        });
    </script>
    <?php return ob_get_clean(); ?>
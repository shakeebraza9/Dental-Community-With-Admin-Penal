<?php 
ob_start();
include("global.php");
global $webClass;
//var_dump($_GET);

$pg = empty($_GET['blogId']) ? "null" : htmlspecialchars($_GET['blogId']);
$pg = empty($_GET['blog'])   ? "null" : htmlspecialchars($_GET['blog']);


// echo "<h1> HELLO  THIS IS TEST </h1>";
// exit;  

require_once(__DIR__ . '/_models/functions/webBlog_functions.php');
$blogC = new webBlog_functions();
$page = $blogC->getBlog("$pg");

// var_dump($page);
if ($seo['title'] == '' || $seo['reWriteTitle'] == '0') {
    $seo['title'] = $page['heading'];
}
if ($seo['description'] == '' || $seo['default'] == '1') {
    $seo['description'] = substr(trim(strip_tags($page['desc'])), 0, 250);
}

// include("header.php");

?>    

<?php
// $bID = empty($_GET['blog']) ? "null" : $_GET['blog'];
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
// echo "length of url : " . count($uri_segments);
//for https://smartdentalcompliance.com/new/page-blog/5   you will get 5
$bID = "";

if(count($uri_segments) == 3){
    $bID = $uri_segments[2];
    $latestBlogDetail = $blogC->latestBlogDetail($bID);
}

$functions->require_once_custom("webBlog_functions");
$blogC      = new webBlog_functions();
$blogData   = $blogC->latestBlog(500);
$latestBlog = $blogC->latestBlogOne(500);
$categories = $blogC->getBlogCategory(); 
$blogBoxes  = $blogC->blogBoxes(500);
  
if ($bID == '')
{
    
?>
        <div class="inner_content">
            <div class="col14 wow fadeInUp">
                <div class="standard">
                    <div class="blog">
                        <!-- blog box left div -->
                        <?php echo $latestBlog; ?>
                        <!-- blog_left close -->
                        <div class="blog_right">
                            <h6> MOST POPULAR </h6>
                            <ul id="news">
                            <!-- All popular blogs -->    
                            <?php $blogC->popularBlogs(500); ?>
                            <!-- All popular blog end -->
                            </ul>
                        </div>
                        <!-- blog right close -->
                        <div class="blog_main">
                            <div class="blog_fill">
                                <ul>
                                <!-- 
                                    <li data-filter="*" class="select-cat">
                                        Most Recent
                                    </li> -->
                                    
                                   <?php  
                                    foreach ($categories as $value) {
                                    $stripped = str_replace(' ', '', $value['category']);
                                    echo '<li data-filter=".'.$stripped.'" > '.$value['category'].'
                                    </li>';
                                    }

                                   ?>
                                </ul>
                            </div>
                            <!-- blog_fill close -->
                            <div class="grid">
                                <!-- print all blog boxes -->
                                     <?php echo $blogBoxes; ?> 
                                <!-- print all blog boxes -->
                            </div>
                            <!-- grid close -->
                        </div>
                        <!-- blog_main close  -->
                    </div>
                    <!-- blog close -->
                </div>
            </div>   
        </div> 
    <?php
} else {
    ?>
    <!--Inner Container Starts -->
    <div class="inner_content">
            <div class="col14 wow fadeInUp">
                <div class="standard">
                    <div class="blog">
                        <!-- blog box left div -->
                        <?php 

                            $blogC->increamentInViews($bID);
                            echo $latestBlogDetail;                         
                        
                        ?>
                        <!-- blog_left close -->
                        <div class="blog_right">
                            <h6> MOST POPULAR </h6>
                            <ul id="news">
                            <!-- All popular blogs -->    
                            <?php $blogC->popularBlogs(500); ?>
                            <!-- All popular blog end -->
                            </ul>
                        </div>
                        <!-- blog right close -->
                        <div class="blog_main">
                            <div class="blog_fill">
                                <ul>

                                   <!--  <li data-filter="*" class="select-cat">
                                        Most Recent
                                    </li> -->
                                    
                                   <?php  
                                    foreach ($categories as $value) {
                                    $stripped = str_replace(' ', '', $value['category']);
                                    echo '<li data-filter=".'.$stripped.'" > '.$value['category'].'
                                    </li>';
                                    }

                                   ?>
                                </ul>
                            </div>
                            <!-- blog_fill close -->
                           <div class="grid"> 
                                <!-- print all blog boxes -->
                                     <?php echo $blogBoxes; ?> 
                                <!-- print all blog boxes -->
                            </div>  
                            <!-- grid close -->
                        </div>
                        <!-- blog_main close  -->
                    </div>
                    <!-- blog close -->
                </div>
            </div>   
        </div> 
        <!--Inner Container Ends-->
<?php
}
?>

<?php // include("footer.php"); ?>

<?php
return ob_get_clean(); ?>
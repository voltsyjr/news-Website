<!-- // making title dytnamic -->
<?php
include  'config.php';
//checking what we get from url
// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';
// echo '<h1>'.$_SERVER['PHP_SELF'].'</h1>'; // Gives folder name also
// echo '<h1>'.basename($_SERVER['PHP_SELF']).'</h1>';  // basename function gives us propername of function;
$page=basename($_SERVER['PHP_SELF']);
switch ($page) {
    case 'single.php':
        if(isset($_GET['id'])){
            $sql_title="SELECT * FROM post where post_id={$_GET['id']}";
            $result_title=mysqli_query($conn,$sql_title) or die("Query Failed: Title");
            $row_title=mysqli_fetch_assoc($result_title);
            $page_title= $row_title['title']." News";
            // echo $page_title;
        }else{
            echo 'No Post Found';
        }
        break;
    case 'category.php':
        if(isset($_GET['cid'])){
            $sql_title="SELECT * FROM category where category_id={$_GET['cid']}";
            $result_title=mysqli_query($conn,$sql_title) or die("Query Failed: Title");
            $row_title=mysqli_fetch_assoc($result_title);
            $page_title= $row_title['category_name']." News";
            // echo $page_title;
        }else{
            echo 'No Post Found';
        }
        break;        
    case 'author.php':
        if(isset($_GET['aid'])){
            $sql_title="SELECT * FROM user where user_id={$_GET['aid']}";
            $result_title=mysqli_query($conn,$sql_title) or die("Query Failed: Title");
            $row_title=mysqli_fetch_assoc($result_title);
            $page_title= " News By".$row_title['first_name']." ".$row_title['last_name'];
            // echo $page_title;
        }else{
            echo 'No Post Found';
        }
        break; 
    case 'search.php':
        if(isset($_GET['search'])){
            $page_title= " Search For ".$_GET['search'];
            // echo $page_title;
        }else{
            echo 'No Post Found';
        }
        break; 
    default:
        $page_title= 'BEST NEWS';
        break;
}

// title designing end
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
            <?php
    include 'config.php';
    // taking data of settings from database
    $sql="SELECT * FROM settings";
    $result=mysqli_query($conn,$sql)or die("Query failed"); 
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            if($row['logo']==""){
                echo '<a href="index.php"><h1>'.$row['website_name'].'</h1></a>';
            }else{

                echo '<a href="index.php" id="logo"><img src="admin/images/'.$row['logo'].'"></a>';
            }
?>
            <?php 
            }
    }
    ?>
            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <?php
                include 'config.php';
                // select only those whose which have atleast one post
                if(isset($_GET['cid'])){
                    $cat_id=$_GET['cid'];

                } 
                $sql="SELECT * FROM category where post > 0";
                $result=mysqli_query($conn,$sql)or die("Query failed: Category");        
                if(mysqli_num_rows($result)>0){

            ?>
                <ul class='menu'>
                <li><a  href='<?php echo $hostname;?>'>Home</a></li>
                <?php 
                while($row=mysqli_fetch_assoc($result)){
                    if(isset($_GET['cid'])){
                    if($row['category_id']==$cat_id){
                        $selected='active';
                    }else{
                        $selected='';
                    }
                }else{
                    $selected='';
                }
                    ?>
                    <li><a class=" <?php echo $selected;?>" href='category.php?cid=<?php echo $row['category_id'];?>'><?php echo $row['category_name'];?></a></li>
                    <?php
                }
                ?>
                </ul>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->

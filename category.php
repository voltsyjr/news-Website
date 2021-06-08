<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                <?php
                    $cat_id=$_GET['cid'];
                $sql1="SELECT * FROM category where category_id={$cat_id}";
                $result1=mysqli_query($conn,$sql1);
                $row1 = mysqli_fetch_assoc($result1);
                ?>
                  <h2 class="page-heading"><?php echo $row1['category_name'];?></h2>
                    <div class="post-content">
                    <?php include 'config.php';

                    $limit=3;
                    if(isset($_GET['page'])){
                        $page=$_GET['page'];
                    }else{
                        $page=1;
                    }
                    $offset = ($page - 1) * $limit;

                    $sql="SELECT post.post_id, post.description, post.title, post.post_date,category.category_name, user.username,post.author, post.category, post.post_img FROM post
                    LEFT JOIN category ON post.category=category.category_id
                    LEFT JOIN user ON post.author=user.user_id
                    where category_id={$cat_id}
                    ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";
                    $result=mysqli_query($conn,$sql)or die("Query failed: POST");        
                    if(mysqli_num_rows($result)>0){
                        while($row=mysqli_fetch_assoc($result)){
                    ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?id=<?php echo $row['post_id'];?>"><img src="admin/upload/<?php echo $row['post_img'];?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href='single.php?id=<?php echo $row['post_id'];?>'><?php echo $row['title'];?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?cid=<?php echo $row['category'];?>'><?php echo $row['category_name'];?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?aid=<?php echo $row['author'];?>'><?php echo $row['username'];?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date'];?>
                                        </span>
                                    </div>
                                    <p class="description">
                                    <!-- //we want that in description only up to 150 word use ho so we use substr function -->
                                    <?php echo substr($row['description'],0,120)."...";?>
                                    </p>
                                    <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'];?>'>read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php

                        }
                    }else{
                        echo"<h1>No Record Found.</h1>";
                    }
                    ?>

                    <?php


                    $total_records= $row1['post'];
                    $total_pages= ceil($total_records/$limit);
                    echo '<ul class="pagination admin-pagination">';
                    // forward page
                    if($page>1){
                    echo '<li><a href="category.php?cid='.$cat_id.'&page='.($page-1).'">Prev</a></li>';}
                    for($i = 1; $i <= $total_pages; $i++){
                        if($page==$i){
                            $active='active';
                        }else{
                            $active='';
                        }
                        echo '<li class="'.$active.'"><a href="category.php?cid='.$cat_id.'&page='.$i.'">'.$i.'</a></li>'; 
                    }
                    // backward page
                    if($page<$total_pages){
                    echo '<li><a href="category.php?cid='.$cat_id.'&page='.($page+1).'">Next</a></li>';}

                    ?>
                    <!-- <ul class='pagination'>
                        <li class="active"><a href="">1</a></li>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                    </ul> --></div>
                </div>
                <!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>

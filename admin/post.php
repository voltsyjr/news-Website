<?php include "header.php"; ?>
<?php include 'config.php';

$limit=3;

if(isset($_GET['page'])){
    $page=$_GET['page'];
 }else{
    $page=1;
}
$offset = ($page - 1) * $limit;


// Checking if user is admin or not 
if($_SESSION['user_role']==1){ 
    //content only for admin user

    $sql="SELECT post.post_id, post.description, post.title, post.post_date,category.category_name, user.username, post.category FROM post
    LEFT JOIN category ON post.category=category.category_id
    LEFT JOIN user ON post.author=user.user_id
     ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";
    $result=mysqli_query($conn,$sql)or die("Query failed");                     
}elseif($_SESSION['user_role']==0){
    //content  for normal user

    $sql="SELECT post.post_id, post.description, post.title, post.post_date,category.category_name, user.username, post.category FROM post
    LEFT JOIN category ON post.category=category.category_id
    LEFT JOIN user ON post.author=user.user_id where post.author={$_SESSION['user_id']}
     ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";
    $result=mysqli_query($conn,$sql)or die("Query failed"); 
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php
                      if(mysqli_num_rows($result)>0){
                        //   making user see serial number not post id 
                        $serial=$offset+1;
                          while($row=mysqli_fetch_assoc($result)){
                        ?>
                          <tr>
                              <td class='id'><?php echo $serial;?></td>
                              <td><?php echo $row['title'];?></td>
                              <td><?php echo $row['category_name'];?></td>
                              <td><?php echo $row['post_date'];?></td>
                              <td><?php echo $row['username'];?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id'];?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id'];?>&catid=<?php echo $row['category'];?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php
                          $serial++;
                          }
                        }
                          ?>
                      </tbody>
                  </table>
                  <!-- <ul class='pagination admin-pagination'>
                      <li class="active"><a>1</a></li>
                      <li><a>2</a></li>
                      <li><a>3</a></li> -->
                      <!-- //pagenation -->
                      <?php 
                        $sql1="SELECT * FROM post";
                        $result1=mysqli_query($conn,$sql1);
                        $total_records= mysqli_num_rows($result1);
                        $total_pages= ceil($total_records/$limit);
                        echo '<ul class="pagination admin-pagination">';
                        // forward page
                        if($page>1){
                        echo '<li><a href="post.php?page='.($page-1).'">Prev</a></li>';}
                        for($i = 1; $i <= $total_pages; $i++){
                            if($page==$i){
                                $active='active';
                            }else{
                                $active='';
                            }
                            echo '<li class="'.$active.'"><a href="post.php?page='.$i.'">'.$i.'</a></li>'; 
                        }
                        // backward page
                        if($page<$total_pages){
                        echo '<li><a href="post.php?page='.($page+1).'">Next</a></li>';}

                        ?>
                  </ul>
                  
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>

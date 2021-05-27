<?php include "header.php";
include 'config.php';
if($_SESSION['user_role']==0){
    header("Location: {$hostname}/admin/post.php");
}
    if(isset($_POST['submit'])){
        include "config.php";
    $cat_id= mysqli_real_escape_string($conn,$_POST['cat_id']);
    echo$cat_name= mysqli_real_escape_string($conn,$_POST['cat_name']);
    $sql="UPDATE category SET category_name='{$cat_name}' WHERE category_id={$cat_id}";
    if(mysqli_query($conn, $sql)){
        header("Location: {$hostname}/admin/category.php");
        mysqli_close($conn);
    }
    }
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <?php 
              include 'config.php';
              $catid=$_GET['id'];
              $sql1="SELECT category_name FROM category WHERE category_id={$catid}";
              $result1=mysqli_query($conn,$sql1);
              if($row1=mysqli_fetch_assoc($result1)){
              ?>
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <form action="<?php $_SERVER['PHP_SELF'];?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value='<?php echo $catid;?>' placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value='<?php echo $row1["category_name"];?>'  placeholder="" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                </div>
                <?php 
              }
              ?>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>

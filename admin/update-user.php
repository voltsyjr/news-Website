<?php include "header.php";
include 'config.php';
if($_SESSION['user_role']==0){
    header("Location: {$hostname}/admin/post.php");
}

if(isset($_POST['submit'])){

    // setting up connection
    // $conn = mysqli_connect("localhost","root","","mynews")or die("Coneection failed: ". mysqli_connect_error());
    include "config.php";
    $user_id= mysqli_real_escape_string($conn,$_POST['user_id']);
    $fname= mysqli_real_escape_string($conn,$_POST['f_name']);
    $lname= mysqli_real_escape_string($conn,$_POST['l_name']);
    $user= mysqli_real_escape_string($conn,$_POST['username']);
    $role= mysqli_real_escape_string($conn,$_POST['role']);
    
    $sql = "UPDATE user SET first_name='{$fname}',last_name='{$lname}',username='{$user}',role='{$role}' WHERE user_id={$user_id}";
    if(mysqli_query($conn, $sql)){
        header("Location: {$hostname}/admin/users.php");
        mysqli_close($conn);
    }
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <?php 
                  include "config.php";
                  $user=$_GET['id'];
                  $sql="SELECT * from user where user_id='{$user}'";
                  $result=mysqli_query($conn, $sql) or die("Query failed");
                    if(mysqli_num_rows($result)>0){
                        $row=mysqli_fetch_assoc($result);
                  ?>
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF'];?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $row['user_id'];?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name'];?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name'];?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username'];?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <?php 
                          echo'<select class="form-control" name="role" value="<?php echo $row["role"]; ?>">';
                             if($row['role']==1){
                              echo '<option value="1" selected>Admin</option>
                                 <option value="0">Normal User</option>';}else{
                                    echo '<option value="1">Admin</option>
                                        <option value="0"  selected>Normal User</option>';}
                          echo"</select>";
                          ?>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->
              </div>
              <?php
                    }
                    ?>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>

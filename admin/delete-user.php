<?php
include 'config.php';
if($_SESSION['user_role']==0){
    header("Location: {$hostname}/admin/post.php");
}
// include 'config.php';
$user_id= $_GET['id'];
$sql = "DELETE FROM user where user_id={$user_id}";
if(mysqli_query($conn, $sql)){
    header("Location: {$hostname}/admin/users.php");
}else{
    echo "<p style='color: red; text-align: center; margin: 10px 0;'>Can't DELETE</p>";
}

mysqli_close($conn);



?>
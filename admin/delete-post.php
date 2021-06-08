<?php
include 'config.php';
// if($_SESSION['user_role']==0){
//     header("Location: {$hostname}/admin/post.php");
// }
include 'config.php';
$post_id= $_GET['id'];
$catid= $_GET['catid'];

//for deleting image from folder
$sql1= "SELECT * FROM post where post_id={$post_id};";
$result=mysqli_query($conn,$sql1);
//phle dekho kis name se save h by
// echo '<pre>';
// $row=mysqli_fetch_assoc($result);
// echo '</pre>';
$row=mysqli_fetch_assoc($result);
unlink("upload/".$row['post_img']); // to delete file use this function

$sql = "DELETE FROM post where post_id={$post_id};";
$sql.= "UPDATE category SET post= post-1 where category_id={$catid}";
if(mysqli_multi_query($conn, $sql)){
    header("Location: {$hostname}/admin/post.php");
}else{
    echo "<p style='color: red; text-align: center; margin: 10px 0;'>Can't DELETE</p>";
}

mysqli_close($conn);
?>
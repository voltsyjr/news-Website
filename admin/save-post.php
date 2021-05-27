<?php
include 'config.php';

// taking file details which is being uploaded by user in form
if(isset($_FILES['fileToUpload'])){
    $errors= array();
    //geting filename by using name attribute
    $file_name=$_FILES['fileToUpload']['name'];
    //geting filesize by using size attribute
    $file_size=$_FILES['fileToUpload']['size'];
    //geting filetmp by using tmp_name attribute
    $file_tmp=$_FILES['fileToUpload']['tmp_name'];
    //geting file type by using type attribute
    $file_type=$_FILES['fileToUpload']['type'];
    //geting file extension by using explode function
    $file_ext= strtolower(end(explode('.',$file_name)));
    // explode function "." ke bad ka nam de dega jaise in img.jpg m ye explode agr hm '.' pr lgate h to y '.' ke bad ka jpg chodega bo end fun hmain dega
    $extensions=array("jpeg","jpg","png");
    //Checking wheather extension is correct or not
    if(in_array($file_ext,$extensions)===false){
        $errors[]="This extension formate is not allowed, Please chose out of jpeg, jpg, png file.";
    }
    // restricting file size to be not more than 2mb
    // remember here size is in bytes so first convert size to bytes
    if($file_size>2097152){
        $errors[]="Files size must be 2mb or lower.";
    }

    // cheching if there comes any error in abobe condition  Use empty function to check if errors array is empty or not
    if(empty($errors)==true){
        //if no error than upload file
        // adding serevr time after name of image
        $new_name=time()."-".basename($file_name);
        $image_name=$new_name;
        $target="upload/".$image_name;
        move_uploaded_file($file_tmp,$target) or die("\n\nNot uploaded");
    }else{
        print_r($errors);
        die();
    }
}
$title=mysqli_real_escape_string($conn,$_POST['post_title']);
$description=mysqli_real_escape_string($conn,$_POST['postdesc']);
$category=mysqli_real_escape_string($conn,$_POST['category']);
// creating a date
$date=date("d M, Y");
//getting author of creating post by his login id usin Session
session_start();
$author=$_SESSION['user_id'];
$sql="INSERT INTO post(title, description, category,post_date,author,post_img) values('{$title}','{$description}',{$category},'{$date}','{$author}','{$image_name}');";
//Concatinte two sql commands
$sql .= "UPDATE category SET post=post+1 Where category_id={$category}";
// remember while concating query use ; in previous one inside
//run querry by other function given below if query is concatinated
if(mysqli_multi_query($conn,$sql)){
    header("Location: {$hostname}/admin/post.php");
}else{
    echo"<div class='alert alert-danger'>Query failed</div>";
}
?>
<?php
include 'config.php';
if(empty($_FILES['new-image']['name'])){
    // if user had not given new image than upload older image
    $image_name=$_POST['old_image'];
}else{
    $errors= array();
    //geting filename by using name attribute
    $file_name=$_FILES['new-image']['name'];
    //geting filesize by using size attribute
    $file_size=$_FILES['new-image']['size'];
    //geting filetmp by using tmp_name attribute
    $file_tmp=$_FILES['new-image']['tmp_name'];
    //geting file type by using type attribute
    $file_type=$_FILES['new-image']['type'];
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
        $new_name=time()."-".basename($file_name);
        $image_name=$new_name;
        $target="upload/".$image_name;
        move_uploaded_file($file_tmp,$target);
    }else{
        print_r($errors);
        die();
    }
}
$sql="UPDATE post SET title='{$_POST["post_title"]}', description='{$_POST["postdesc"]}', category={$_POST["category"]},post_img='{$image_name}' where post_id={$_POST["post_id"]};";
if($_POST['old_category'] != $_POST['category']){
    $sql.= "UPDATE category SET post= post-1 where category_id={$_POST['old_category']};";
    $sql.= "UPDATE category SET post= post+1 where category_id={$_POST['category']}";
}
if(mysqli_multi_query($conn,$sql)){
    header("Location: {$hostname}/admin/post.php");
}else{
    echo"<div class='alert alert-danger'>Query failed</div>";
}

?>
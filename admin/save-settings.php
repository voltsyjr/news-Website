<?php
include 'config.php';
if(empty($_FILES['logo']['name'])){
    // if user had not given new image than upload older image
    $file_name=$_POST['old_logo'];
}else{
    $errors= array();
    //geting filename by using name attribute
    $file_name=$_FILES['logo']['name'];
    //geting filesize by using size attribute
    $file_size=$_FILES['logo']['size'];
    //geting filetmp by using tmp_name attribute
    $file_tmp=$_FILES['logo']['tmp_name'];
    //geting file type by using type attribute
    $file_type=$_FILES['logo']['type'];
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
        move_uploaded_file($file_tmp,"images/".$file_name);
    }else{
        print_r($errors);
        die();
    }
}
echo $sql="UPDATE settings SET website_name='{$_POST["website_name"]}', footerdesc='{$_POST["footer_desc"]}',logo='{$file_name}'";
if(mysqli_query($conn,$sql)){
    header("Location: {$hostname}/admin/settings.php");
}else{
    echo"<div class='alert alert-danger'>Query failed</div>";
}

?>
<?php
session_start();
include ('server/connection.php');

// upload profile image
if (isset($_POST['upload'])){
    $targetDir="C:/inetpub/wwwroot/1808957/NewCMM004-NewProject-master/CMM004-NewProject-master/profilePhoto/";
    $username=$_SESSION["user"];
    $fileName = basename($_FILES['profileImg']['name']);
    $fileTmpName = $_FILES['profileImg']['tmp_name'];
    $folder = $targetDir.$fileName;
    move_uploaded_file($fileTmpName, $folder);
    $photosql= "UPDATE tradesman SET photo='$fileName' WHERE username='$username'";
    $result = mysqli_query($db,$photosql);
    header('location : tradeProfile.php?upload=success');
    exit();
}
?>

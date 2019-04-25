<?php
session_start();
include ('server/connection.php');

if (isset($_POST['resPassword'])) {
    $pass1 = mysqli_real_escape_string($db, $_POST['pass1']);
    $pass2 = mysqli_real_escape_string($db, $_POST['pass2']);
    if (empty($pass1) || empty($pass2)){
        header('location: mainpage.php?pas=em');
        exit();
    }else{
    if ($pass1 != $pass2) {
        array_push($errors, "Passwords do not match");
        header('location: mainpage.php?password=not_match');
        exit();
    } else {
        $password = password_hash($pass1, PASSWORD_DEFAULT);
        $username = $_SESSION['mo'];
        $up = "UPDATE login  SET password= '$password' WHERE (username='$username' OR email='$username')";
        $update = mysqli_query($db, $up);
        header('location : mainpage.php?passwordUpdated=success');
        exit();
    }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css">
</head>
<body>
<div >
    <form class="modal-content animate" method="post" action="restPass.php">
        <div class="imgcontainer">
            <a href="mainpage.php" style="text-decoration: none"> <span onclick="document.getElementById('pass').style.display='none'" class="close" title="Close Modal">&times;</span> </a>
        </div>

        <label for="username"><b>Password</b></label>
        <input class="justMo" type="password" placeholder="Password..." name="pass1">
        <label for="username"><b>Confirm Password</b></label>
        <input class="justMo" type="password" placeholder="Confirm Password.." name="pass2">
        <button class="button1" name="resPassword" type="submit">Submit</button>
        <a href="mainpage.php" style="text-decoration: none"><button type="button" name="cancel">Cancel</button></a>
    </form>
</div>
</body>
</html>
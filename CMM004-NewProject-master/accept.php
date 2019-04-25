<?php
session_start();
include ('server/connection.php');

if (isset($_POST['accepted'])){
    $event=$_SESSION['event'];
    $us=$_POST['accepted'];
    $sql= "UPDATE event SET isOpen = 0 WHERE  eventID = '$event'";
    $cke=mysqli_query($db,$sql);

    $sql1= "UPDATE bids SET accepted = 1 WHERE username = '$us' AND eventID = '$event'";
    $cke1=mysqli_query($db,$sql1);
    $_SESSION['message']= "your bids was accepted";
    $_SESSION['message_User']="message was send to the tradesman";

    header('location : user.php');
    exit();
}

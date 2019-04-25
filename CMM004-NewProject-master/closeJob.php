<?php
session_start();
include ('server/connection.php');
if (isset($_POST['closeJob'])){

    $username=$_SESSION['username'] ;
    $event=$_SESSION['event'];

    $sql= "UPDATE event SET isOpen=0 WHERE eventID = $event";
    $cke=mysqli_query($db,$sql);
    header('location: user.php');
}


   // header('location : http://csdm-webdev.rgu.ac.uk/1808234/CMM004-NewProject-master(2)/CMM004-NewProject-master/CMM004-NewProject-master/user.php');


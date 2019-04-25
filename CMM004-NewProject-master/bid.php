<?php

session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

include ('server/connection.php');

$username=$_SESSION["user"];

if (isset($_POST['newBid'])) {

    $event = mysqli_real_escape_string($db, $_POST['jobSelect']);
    $callout = mysqli_real_escape_string($db, $_POST['callout']);
    $quote = mysqli_real_escape_string($db, $_POST['quote']);
    $comments = mysqli_real_escape_string($db, $_POST['comments']);

    $sql = "INSERT INTO bids (eventID, username, callout, quote, comment, accepted, reviewed)
VALUES ('$event','$username','$callout','$quote','$comments',0,0 )";

    $result = mysqli_query($db, $sql);

    header('location : tradesmanHomepage.php');

}
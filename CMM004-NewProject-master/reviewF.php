<?php

include ('server/connection.php');
$username = $_SESSION["user"];
$errors = array();

if (isset($_POST['submit'])) {

    if (empty($_POST['rating'])) {
        array_push($errors, "You must select a rating");
    }

    else {

        $bid = mysqli_real_escape_string($db, $_POST['bidID']);
        $tradesman = mysqli_real_escape_string($db, $_POST['tradesman']);
        $rating = $_POST['rating'];
        $comments = mysqli_real_escape_string($db, $_POST['comments']);

        $query = "INSERT INTO review (user, bidID, tradesman, score, comments) VALUES ('$username', '$bid', '$tradesman','$rating','$comments' )";
        mysqli_query($db, $query);

        $query2 = "UPDATE bids SET reviewed = 1 WHERE bidID = '$bid'";
        mysqli_query($db, $query2);

        header ('location: pastJobs.php');

    }
}
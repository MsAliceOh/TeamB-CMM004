<?php
session_start();

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

include ('server/connection.php');
include ('reviewF.php');
if ( !isset( $_SESSION['user'])) {
    header('location:mainpage.php');
    exit();
}else{
    $username = $_SESSION["user"];

    $id= "SELECT isTradesman FROM login WHERE username='$username' OR email= '$username' ";
    $res= mysqli_query($db,$id);
    $check1= mysqli_num_rows($res);
    $rows = mysqli_fetch_assoc($res);

    if ($rows ['isTradesman'] != 0){

        header('location : tradesmanHomepage.php?just_be_there');
        exit();
    }
}

if(isset($_GET['id'])) {
    $bidID = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Home Page</title>
    <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="userHome.css">
</head>

<main class="grid-container">

    <section class="grid-100">

        <header  class="header1">
            <!-- logo will take a place here -->
            <div class="logo">
                <img src = "image/Logo.png">
            </div>
            <!-- header start here  -->
            <div><br><br>
                <h2 style="text-align: center;  text-decoration-color: white; text-overflow: revert" >Tradesman Aberdeen</h2>
            </div>

            <div  class="login-txt2">
                <p>You are logged in:<br>
                    <?php
                    echo  $_SESSION['user'];
                    ; ?>
                </p>
                <br><a href="logout.php" style=" text-decoration: none;color: #b90002">Log-out</a>
            </div>
        </header>
    </section>

    <section class = "grid-100"?>

        <h2><br><br><br><br><br>Tradesman Assessment</h2>

        <form action="review.php" method="post" accept-charset="utf-8">
            <fieldset>
                <legend>Review</legend>
                <?php include ('server/errors.php')?>
                <div class = "rev">
                    <label>Bid ID:</label>
                    <input name = "bidID" value = "<?php echo $bidID ?>" readonly >
                </div>
                <div class = "rev">
                    <label>Tradesman:</label>
                    <input name = "tradesman" value = "<?php
                    $tquery = "SELECT username FROM bids WHERE bidID = '$bidID' ";
                    $tres = mysqli_query($db, $tquery);
                    while ($row = $tres -> fetch_assoc()) {
                        echo $row['username'];
                    } ?>" readonly >
                </div>
                <div class = "rev">
                    <label>Rating</label><br><br>
                    <input type="radio" name="rating" value="5" /> 5
                    <input type="radio" name="rating" value="4" /> 4
                    <input type="radio" name="rating" value="3" /> 3
                    <input type="radio" name="rating" value="2" /> 2
                    <input type="radio" name="rating" value="1" /> 1
                </div>
                <div class = "rev">
                    <label>Comments</label><br><br>
                    <textarea name="comments"></textarea>
                </div>
                <div class = "rev">
                    <button type="submit" name = "submit" class = "btn">Submit Review</button>
                </div>
            </fieldset>
        </form>
    </section>

</main>
</html>
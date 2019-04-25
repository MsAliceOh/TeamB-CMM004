<?php
session_start();

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

include ('server/connection.php');
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Home Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css">
    <link rel="stylesheet" href="tradesmanHomepage.css">
    <link rel="stylesheet" href="userHome.css">
</head>

<body>

<main class="grid-container">
    <div class="grid-100">

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
    </div>

    <div id = "toReview">
        <br><br><br><br>
        <form>
            <div id="title">
                <h2 style = "text-align: center"><br>Jobs Still to Review</h2>
                <br><br>
            </div>

            <table id="tradesmenToReview" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>Bid ID</td>
                    <td>Title of Your Job</td>
                    <td>The Description</td>
                    <td>Your Tradesman</td>
                    <td>The Callout Fee</td>
                    <td>The Quote</td>
                    <td>Tradesman Comments</td>
                    <td>Select to Review</td>
                </tr>
                </thead>
                <?php

                $query = "SELECT E.eventID, E.user, E.title, E.description, B.bidID, B.eventID, B.username, B.callout, B.quote, B.comment, B.accepted, B.reviewed 
        FROM event E, bids B
        WHERE E.eventID = B.eventID and E.user = '$username' and B.accepted = 1 and B.reviewed = 0" ;

                $result = mysqli_query ($db, $query);
                $count = mysqli_num_rows($result);

                if ($count == 0) {
                    echo "You have no tradesmen to review";
                }
                else {

                    while ($row = mysqli_fetch_array($result)) {
                        echo "
            <tr>
            <td>" . $row["bidID"] . "</td>
            <td>" . $row["title"] . "</td>
            <td>" . $row["description"] . "</td>
            <td>" . $row["username"] . "</td>
            <td>" . $row["callout"] . "</td>
            <td>" . $row["quote"] . "</td>
            <td>" . $row["comment"] . "</td>" ?>
                        <td> <a href="review.php?id=<?php echo $row["bidID"]; ?>">Review</a></td>
                        </tr>
                        <?php
                        ;
                    }}
                ?>
            </table>
        </form>
    </div>

    <div id = "restOfJobs">
        <form>
        <div id="title">
            <h2 style="text-align: center"><br>Jobs Already Reviewed</h2>
            <br><br>
        </div>

        <table id="allJobs" class = "table table-striped table-bordered">
            <thead>
            <tr>
                <td>Title of Your Job</td>
                <td>The Description</td>
                <td>Your Tradesman</td>
                <td>The Callout Fee</td>
                <td>The Quote</td>
                <td>Tradesman Comments</td>
            </tr>
                </thead>
            <?php

            $query2 = "SELECT E.eventID, E.user, E.title, E.description, B.eventID, B.username, B.callout, B.quote, B.comment, B.accepted, B.reviewed 
        FROM event E, bids B
        WHERE E.eventID = B.eventID and E.user = '$username' AND B.accepted = 1 AND B.reviewed = 1 " ;

            $result2 = mysqli_query ($db, $query2);

            while ($row = mysqli_fetch_array($result2)) {
                echo "
            <tr>
            <td>" . $row["title"] . "</td>
            <td>" . $row["description"] . "</td>
            <td>" . $row["username"] . "</td>
            <td>" . $row["callout"] . "</td>
            <td>" . $row["quote"] . "</td>
            <td>" . $row["comment"] . "</td>
            </tr>
            ";
            }
            ?>
        </table>

        </form>
    </div>

</main>

</body>

</html>

<script>
    $(document).ready(function(){
        $('#tradesmenToReview').DataTable();
    });
</script>

<script>
    $(document).ready(function(){
        $('#allJobs').DataTable();
    });
</script>

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

        header('location : mainpage.php?just_be_there');
        exit();
    }
}
if (isset($_POST['myJobs'])) {

    $currentJob = $_POST['myJobs'];

    if( empty( $currentJob)){

        header('location : user.php?no_jobs');
        exit();

    }else{

        $getJobID = "SELECT eventID FROM event WHERE title = '$currentJob' AND user = '$username' AND isOpen = 1 ";
        $idRes = $db->query($getJobID );


        if (mysqli_num_rows($idRes)>0) {
            while ($row = mysqli_fetch_assoc($idRes)) {
                $_SESSION['event']= $row['eventID'] ;

            }
        }

        $event=$_SESSION['event'];

// mo staff
        $get = "SELECT * FROM event WHERE eventID = '$event'";
        $n = $db->query($get);

        while ($row = mysqli_fetch_assoc($n)) {

            $_SESSION['title']= $row['title'];
            $_SESSION['need']=$row['needs'];
            $_SESSION['des']= $row['description'];

        }



    }
}



?>







<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <title>User Home Page</title>
    <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="jobPage.css">

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
                    ?>
                </p>
                <br><a href="logout.php" style=" text-decoration: none;color: #b90002">Log-out</a>
            </div>

        </header>

     <a href="user.php" style=" text-decoration: none;color: black; float: left; margin-top: 120px">
         <button type="button" style="width: 80px; height: 30px"><-  Back</button>
     </a>

        <div id= "jobForm">
            <form class="form1" id = jButton1 method="post" action="closeJob.php">
                <button type= "submit" name = "closeJob" id = "closeJo" class="btn">Close Job</button>

            </form>
        </div>
        <div id = "jobBox">
            <div id = "whitebox">
                <h1><?php

                    echo  $_SESSION['title'];

                    ?></h1>
            </div>
            <div id = "whitebox">
                <h2><?php
                    echo "I need a " . $_SESSION['need'];
                    ?>
                </h2>
            </div>
            <div id = "whitebox">
                <p><?php

                    echo "Description of my problem: "."<br>".$_SESSION['des'];

                    ?>
                </p>
            </div>

        </div>


        <!-- <form id = "bidBox">-->

        <h2> Current bids</h2><br><br>
        <table id="bid" class="table table-striped table-bordered">
            <thead>
            <tr>
                <td>Tradesman</td>
                <td>Call-out</td>
                <td>Quote</td>
                <td>Comment</td>

            </tr>
            </thead>

            <?php

            $event=$_SESSION['event'];

            $get = "SELECT * FROM event WHERE eventID = '$event'";
            $n = $db->query($get);

            if (mysqli_num_rows($n)>0) {
                while ($row = mysqli_fetch_assoc($n)) {
                    $_SESSION['id']= $row['eventID'] ;
                }
            }
            $id=$_SESSION['id'];

            $sql_query = "SELECT * FROM bids WHERE eventID  = '$id'";
            $results = mysqli_query($db,$sql_query);

            while($row = mysqli_fetch_array($results)) {

                $_SESSION["tradesmanName"]=$row['username'];

                ?>

                <tr>
                    <td><?php  echo $row['username']; ?></td>
                    <td><?php  echo $row['callout']; ?></td>
                    <td><?php echo $row['quote']; ?></td>
                    <td><?php echo $row['comment']; ?></td>
                    <td>
                        <form action="userViewProfile.php" method="post" >
                            <button type='submit' name="pro" style='width: 100%' value="<?php echo $row['username'];?>">View Profile</button>
                        </form>
                        <?php
                        if (isset($_POST['pro'])) {
                            $username = $_POST['pro'];

                            $sqlLog = "SELECT * FROM login WHERE username = '$username' ";
                            $resultLog = $db->query($sqlLog);

                            while ($row = $resultLog->fetch_assoc()) {
                                $email = $row['email'];
                            }

                            $sqlTrade = "SELECT * FROM tradesman WHERE username = '$username' ";
                            $resultTrade = $db->query($sqlTrade);

                            while ($row = $resultTrade->fetch_assoc()) {
                                $username = $row['username'];
                                $fname = $row['firstname'];
                                $lname = $row['lastname'];
                                $add1 = $row['add1'];
                                $add2 = $row['add2'];
                                $city = $row['city'];
                                $postcode = $row['postcode'];
                                $qual = $row['qualifications'];
                                $aboutY = $row['aboutYou'];
                                $_SESSION['pic'] = $row['photo'];
                                $_SESSION['cont'] = $row['contact'];
                            }

                            // start from here



                        }?>
                    </td>
                    <td><form method="post" action="accept.php" onsubmit="return confirm('by accepting this bid  will take ' +
                         'the job out of the list and you can not see this job,\n\n Are Sure you you want to accept this BID?')">
                            <button type="submit" name="accepted"  style="width: 100%" value="<?php echo $row['username'];?>">Accept Bid</button>
                        </form></td>
                </tr>
                <?php
            }
/*
            if (isset($_POST['accepted'])){
                $us=$_POST['accepted'];
                $sql= "UPDATE event SET isOpen = 0 WHERE  eventID = '$event'";
                $cke=mysqli_query($db,$sql);

                $sql1= "UPDATE bids SET accepted = 1 WHERE username = '$us' AND eventID = '$event'";
                $cke1=mysqli_query($db,$sql1);
                $_SESSION['message']= "your bids was accepted";
                $_SESSION['message_User']="message was send to the tradesman";

                header('location : user.php');
                exit();
            }*/
            ?>
        </table>
        <!--  </form> -->
</main>
</body>
</html>

<script>
    $(document).ready(function(){
        $('#bid').DataTable();
    });
</script>
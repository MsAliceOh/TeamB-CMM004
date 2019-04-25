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

    if ($rows ['isTradesman'] != 1){

        header('location : user.php?just_be_there');
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Welcome to Tradesman Aberdeen - Tradesman Homepage</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css">
    <link rel="stylesheet" href="tradesmanHomepage.css">

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

    <div id="title">

        <h2 style="margin-top: 95px; text-align: center"><br>Welcome To Tradesman Aberdeen-Tradesman Home Page</h2>
        <a href = "tradeProfile.php">My Profile</a>
        <br><br>
    </div>


    <section class = grid-100>
        <div id = "jobsForm">
            <form>
                <h2>Your Current Jobs</h2>
                <table id="currentJobs1" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <td>User</td>
                        <td>Needs</td>
                        <td>Title</td>
                        <td>Description</td>
                        <td>Photo</td>
                    </tr>
                    </thead>
                    <?php
                    $query = "SELECT profession from trades_prof WHERE username = '$username'";
                    $result = mysqli_query($db, $query);
                    $resultset = array();

                    while ($row = mysqli_fetch_array($result)) {
                        $resultset[] = $row['profession'];
                    }

                    foreach ($resultset as $r) {
                        $query2 = "SELECT * FROM event WHERE needs = '$r' AND isOpen = true";
                        $result2 = mysqli_query($db, $query2);
                        while ($row = mysqli_fetch_array($result2)) {
                            $img = "uploadImages/" . $row["photo"];
                            ?>

                            <tr>
                                <td><?php echo $row["user"]; ?></td>
                                <td><?php echo $row["needs"]; ?></td>
                                <td><?php echo $row["title"]; ?></td>
                                <td><?php echo $row["description"]; ?></td>
                                <td><img src="<?php echo $img; ?>" width="100px" height="100px" class="mo" onclick="myFunction(this)" ></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <!--to show the images -->
                </table>
                <div class="container">
                    <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
                    <img id="expandedImg" style="width:100%">
                    <div id="imgtext"></div>
                </div>
            </form>
        </div>
    </section>


    <section class = grid-100>
        <div id = "biddingForm">
            <form method="post" action="bid.php">
                <h2>Job Bidding Section</h2>
                <div class="input">
                    <label>What would you like to bid on?</label>
                    <select  name = "jobSelect" class = prof >
                        <?php
                        $query = "SELECT profession from trades_prof WHERE username = '$username'";
                        $result = mysqli_query($db, $query);
                        $resultset = array();

                        while ($row = mysqli_fetch_array($result)) {
                            $resultset[] = $row['profession'];
                        }


                        $sql_query = "SELECT * FROM event WHERE needs = '$resultset' AND isOpen = true";
                        $results = $db -> query($sql_query);
                        foreach ($resultset as $r) {
                            $query2 = "SELECT * FROM event WHERE needs = '$r' AND isOpen = true";
                            $result2 = mysqli_query($db, $query2);
                            while ($row = mysqli_fetch_array($result2)) {
                                $id = $row ['eventID'];
                                $jobs = $row ['title'];
                                echo "<option value = '$id' >$jobs</option>";
                            }
                        }
                        ?>
                    </select>

                </div>
                <div class="input">
                    <label>Callout Fees</label>
                    <input type="text" name="callout" placeholder="£">
                </div>
                <div class="input">
                    <label>Quote</label>
                    <input type="text" name="quote" placeholder="£">
                </div>
                <div class="input">
                    <label>Comments</label>
                    <textarea type = "text" name = "comments" id="comments" placeholder = "Please put in any information you think relevant including the timeframe by which you will be able to assist. If you have not been able to quote a price, please say why and give some further information."></textarea>
                </div>
                <div class="input">
                    <button type="submit" name="newBid" class="btn">Submit</button>
                </div>
            </form>
        </div>
    </section>

    <div class="mof">
        <!--start of the view accepted bids-->
        <h2>view accepted bids</h2>
        <!--end of the view accepted bids-->

        <button  onclick="document.getElementById('id2').style.display='block'" >view bids</button>
    </div>


    <div id="id2" class="modal">

        <form class="modal-content animate" >
            <div >
                <span onclick="document.getElementById('id2').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>

                <table id="currentJobs" class="table table-striped table-bordered" style="width: 100%">
                    <thead>
                    <tr>
                        <td><h3>First Name</h3></td>
                        <td><h3>Last Name</h3></td>
                        <td><h3>Email Address</h3></td>
                        <td><h3>Contact No</h3></td>
                        <td><h3>Job</h3></td>
                        <td><h3>Your Callout</h3></td>
                        <td><h3>Your Quote</h3></td>
                    </tr>
                    </thead>
                    <?php

                    //  $tradesman= $_POST['accepted'];
                    $query = " SELECT U.username, U.firstname, U.lastname, U.contact, L.email, E.eventID, E.title, B.eventID, B.callout, B.quote 
                           FROM login L, user U , event E, bids B
                           WHERE U.username=L.username AND U.username=E.user AND E.eventID=B.eventID AND B.accepted=1";  // AND bids.username='$tradesman'
                    $result = mysqli_query($db, $query);
                    while ($row = mysqli_fetch_array($result)) {

                        ?>

                        <tr>
                            <td><?php echo $row['firstname']; ?></td>
                            <td><?php echo $row['lastname']; ?></td>
                            <td><?php echo $row['email'];; ?></td>
                            <td><?php echo $row['contact'];; ?></td>
                            <td><?php echo $row['title'];; ?></td>
                            <td><?php echo $row['callout'];; ?></td>
                            <td><?php echo $row['quote'];; ?></td>
                        </tr>
                    <?php } ?>

                </table>
            <div >
                <button type="button" onclick="document.getElementById('id2').style.display='none'" class="cancelbtn">Cancel</button>
            </div>
        </form>
    </div>


</main>

<script>
    // Get the modal
    var modal = document.getElementById('id2');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<script>
    function myFunction(imgs) {
        var expandImg = document.getElementById("expandedImg");
        var imgText = document.getElementById("imgtext");
        expandImg.src = imgs.src;
        imgText.innerHTML = imgs.alt;
        expandImg.parentElement.style.display = "block";
    }
</script>

<script>
    $(document).ready(function(){
        $('#currentJobs1').DataTable();
    });
</script>

<script>
    $(document).ready(function(){
        $('#currentJobs').DataTable();
    });
</script>

</body>
</html>
<!--display image function-->

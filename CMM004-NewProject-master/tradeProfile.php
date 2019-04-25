<?php
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
include ('server/connection.php');
$username=$_SESSION["user"];
$sqlLog = "SELECT * FROM login WHERE username = '$username' ";
$resultLog = $db->query($sqlLog);
while ($row = $resultLog->fetch_assoc()) {
    $_SESSION['email'] = $row['email'];
}
$sqlTrade = "SELECT * FROM tradesman WHERE username = '$username' ";
$resultTrade = $db->query($sqlTrade);
while ($row = $resultTrade->fetch_assoc()) {
    $_SESSION["user"] = $row['username'];
    $_SESSION['f'] = $row['firstname'];
    $_SESSION['l'] = $row['lastname'];
    $_SESSION['add1'] = $row['add1'];
    $_SESSION['add2'] = $row['add2'];
    $_SESSION['city']= $row['city'];
    $_SESSION['post'] = $row['postcode'];
    $_SESSION['q'] = $row['qualifications'];
    $_SESSION['about'] = $row['aboutYou'];
    $_SESSION['pic'] = $row['photo'];
    $_SESSION['cont']= $row['contact'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css">
    <link rel="stylesheet" href="tradeProfile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>
<body>
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
                    echo $_SESSION["user"];
                    ; ?>
                </p>
                <br><a href="logout.php" style=" text-decoration: none;color: #b90002">Log-out</a>
            </div>
        </header>
    </section>

    <div class = "profile">
        <h2>My Profile</h2>

        <!--start of upload profile image-->
        <div id="img" class="modal">
            <form class="modal-content animate" method="post" action="loading.php" enctype="multipart/form-data">
                <h2>Upload Profile Image</h2>
                <div >
                    <span onclick="document.getElementById('img').style.display='none'" class="close" title="Close Modal">&times;</span>
                </div>
                <div >
                    <input type="file" name ="profileImg">
                    <button name="upload" type="submit">Upload</button>
                </div>
                <div >
                    <button type="button" onclick="document.getElementById('img').style.display='none'" class="cancelbtn">Cancel</button>
                </div>
            </form>
        </div>


        <?php
        if (empty($_SESSION['pic'])){ ?>
            <img src="profilePhoto/profileImage.png"   style="width: 200px; height: 200px; cursor: pointer" alt="dif pic" class="profile_img" onclick="document.getElementById('img').style.display='block'">
        <?php }else{
            $image = "profilePhoto/".$_SESSION['pic'];
            ?>
            <img style="width: 200px; height: 200px;cursor: pointer" alt="upload pic" class="profile_img"  src="<?php echo $image;?>" onclick="document.getElementById('img').style.display='block'">
        <?php } ?>
        <!--end display profile image-->


        <div id = "textbox">
            <h3>Username:</h3>
            <?php
            echo  $_SESSION["user"]."<br><br>";
            ?>

                <button onclick="document.getElementById('usernme').style.display='block'" style="width:auto; float: left;">Update Username</button><br><br>
        </div>
        <div id = "textbox">
            <h3>Name:</h3>
            <?php
            echo $_SESSION['f']." ". $_SESSION['l']."<br><br>";
            ?>
            <button  onclick="document.getElementById('f_l_name').style.display='block'" style="width:auto; float: left">Update First & Last Name</button><br><br>
        </div>
        <div id = "textbox">
            <h3>Email Address:</h3>
            <?php
            echo   $_SESSION['email']."<br><br>" ;
            ?>
            <button  onclick="document.getElementById('emailA').style.display='block'" style="width:auto; float: left">Update Email</button><br><br>
        </div>

        <div id = "textbox">
            <h3>Contact Number:</h3>
            <?php
            echo   $_SESSION['cont']."<br><br>" ;
            ?>
            <button  onclick="document.getElementById('cont').style.display='block'" style="width:auto; float: left">Update Contact Number</button><br><br>
        </div>

        <div id = "textbox">
            <h3>Address:</h3>
            <?php
            echo $_SESSION['add1']."<br>".$_SESSION['add2']."<br>".$_SESSION['city']."<br>".$_SESSION['post']."<br><br>";
            ?>
            <button  onclick="document.getElementById('address').style.display='block'" style="width:auto; float: left">Update Address</button><br><br>
        </div>
        <div id = "textbox">
            <h3>About You:</h3>
            <?php
            echo $_SESSION['about']."<br><br>";
            ?>
            <button  onclick="document.getElementById('you').style.display='block'" style="width:auto; float: left">Update About You</button><br><br>
        </div>
        <div id = "textbox">
            <h3>Qualifications:</h3>
            <?php
            echo $_SESSION['q']."<br><br>";
            ?>
            <button  onclick="document.getElementById('qual').style.display='block'" style="width:auto; float: left">Update Qualifications</button><br><br>
        </div>

        <!--update user password if needed -->
        <h3>You can update your password Here: </h3>
        <button  onclick="document.getElementById('password').style.display='block'" style="width:auto; float: left">Update Password</button><br><br>
    </div>
        <!-- update username-->
        <div id="usernme" class="modal">
                <form class="modal-content animate" onsubmit="return confirm('this update will log you out,\n\n Are sure you want to CONTINUE.....')" action="updateTradesmanProfile.php" method="post">
                    <label for="uname"><b>Username</b></label>
                    <input class="justMo" type="text" placeholder="Enter Username" name="uname">
                    <button class="button1" type="submit" name="update_username">update</button>
                    <div >
                        <button type="button" onclick="document.getElementById('usernme').style.display='none'" class="cancelbtn">Cancel</button>
                    </div>
                </form>
       </div>
        <!-- update user first & last name-->
        <div id="f_l_name" class="modal">
                <form class="modal-content animate" action="updateTradesmanProfile.php" method="post">
                    <label for="first"><b>first name</b></label>
                    <input class="justMo" type="text" placeholder="First Name" name="first">
                    <label for="last"><b>last name</b></label>
                    <input class="justMo" type="text" placeholder="Last Name" name="last">
                    <button class="button1" type="submit" name="update_f_l">update</button>
                    <div>
                        <button type="button" onclick="document.getElementById('f_l_name').style.display='none'" class="cancelbtn">Cancel</button>
                    </div>
                </form>
        </div>
        <!-- update email-->
        <div id="emailA" class="modal">
                <form class="modal-content animate" action="updateTradesmanProfile.php" method="post">
                    <label for="email"><b>email</b></label>
                    <input class="justMo" type="email" placeholder="Email Address" name="email">
                    <button class="button1" type="submit" name="update_email">update</button>
                    <div >
                        <button type="button" onclick="document.getElementById('emailA').style.display='none'" class="cancelbtn">Cancel</button>
                    </div>
                </form>
        </div>
    <!-- update contact number-->
        <div id="cont" class="modal">
                <form class="modal-content animate" action="updateTradesmanProfile.php" method="post">
                <label for="contact"><b>Contact Number</b></label>
                <input class="justMo" type="number" placeholder="Contact Number" name="contact">
                    <button class="button1" type="submit" name="update_con">update</button>
                    <div >
                        <button type="button" onclick="document.getElementById('cont').style.display='none'" class="cancelbtn">Cancel</button>
                    </div>
                </form>
        </div>
                <!-- update password-->
        <div id="password" class="modal">
                <form class="modal-content animate" onsubmit="return confirm('this update will log you out and you need to use your new password,\n\n Are sure you want to CONTINUE.....')" action="updateTradesmanProfile.php" method="post">
                    <p>here you can update your password if you want</p>
                    <label for="psw1"><b>Password</b></label>
                    <input class="justMo" type="password" placeholder="Password" name="psw1">
                    <label for="psw2"><b>Confirm Password</b></label>
                    <input class="justMo" type="password" placeholder="Confirm Password" name="psw2">
                    <button class="button1" type="submit" name="update_pass">update</button>
                    <div >
                        <button type="button" onclick="document.getElementById('password').style.display='none'" class="cancelbtn">Cancel</button>
                    </div>
                </form>
        </div>
        <!-- update address-->
        <div id="address" class="modal">
                <form class="modal-content animate" action="updateTradesmanProfile.php" method="post">
                        <label >Address</label>
                        <input type="text" name="add1_tr" class="justMo" placeholder="first line"><br>
                        <input type="text" name="add2_tr" class="justMo" placeholder="second line"><br>
                        <input type="text" class="justMo" name="city_tr" placeholder=" City"><br>
                        <label for="postcode_tr">Post Code</label>
                        <input class="justMo" type="text" name="postcode_tr" placeholder="postcode">
                    <button class="button1" type="submit" name="update_add">update</button>
                    <div >
                        <button type="button" onclick="document.getElementById('address').style.display='none'" class="cancelbtn">Cancel</button>
                    </div>
                </form>
        </div>

        <div id="you" class="modal">
                <form class="modal-content animate" action="updateTradesmanProfile.php" method="post">
                    <label for="about_you">About You</label>
                    <textarea class="justMo" name = "about_you" placeholder=" Please enter a brief description of yourself and the work you do..."></textarea>
                    <button class="button1" type="submit" name="Ayou">update</button>
                    <div >
                        <button type="button" onclick="document.getElementById('you').style.display='none'" class="cancelbtn">Cancel</button>
                    </div>
                </form>
        </div>

        <div id="qual" class="modal">
            <form class="modal-content animate" action="updateTradesmanProfile.php" method="post">
                    <label for="qua">Qualifications</label>
                <h3>Please list all qualifications you have include your old one's</h3>
                    <textarea class="justMo" name="qua" placeholder=" Please list any qualifications you have here..."></textarea>
                    <button class="button1" type="submit" name="qua">update</button>
                <div >
                    <button type="button" onclick="document.getElementById('qual').style.display='none'" class="cancelbtn">Cancel</button>
                </div>
                </form>
        </div>
    <script>
        // Get the modal
        var usernme = document.getElementById('usernme');
        var f_l_name = document.getElementById('f_l_name');
        var emailA = document.getElementById('emailA');
        var cont = document.getElementById('cont');
        var password = document.getElementById('password');
        var address = document.getElementById('address');
        var you = document.getElementById('you');
        var qual = document.getElementById('qual');
        var img = document.getElementById('img');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(update) {
            if ( (update.target == img )|| (update.target == usernme )|| (update.target == f_l_name) || (update.target == emailA) || (update.target == cont) || (update.target == password )|| (update.target == address) || (update.target == you) || (update.target == qual)) {
                usernme.style.display = "none";
                f_l_name.style.display = "none";
                emailA.style.display = "none";
                cont.style.display = "none";
                password.style.display = "none";
                address.style.display = "none";
                you.style.display = "none";
                qual.style.display="none";
                img.style.display="none";
            }
        }
    </script>

    <section class = "grid-100">

        <div>

            <h2>Reviews</h2>
            <h3>Overall Score: <?php
                $av = "SELECT score FROM review WHERE tradesman = '$username'";
                $avres = mysqli_query($db, $av);
                $num = mysqli_num_rows($avres);
                $set = array();
                $tot = "";
                if($num > 0) {
                while ($row = mysqli_fetch_array($avres)) {
                    $set[] = $row['score'];
                }
                foreach ($set as $r) {
                    $tot += $r;
                }

                $res = $tot/$num;

                echo number_format((float)$res,1,'.','');

                ; ?>/5</h3>
            <table id="reviews" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>User</td>
                    <td>Comments</td>
                    <td>Score</td>
                </tr>
                </thead>
                <?php
                $getR = "SELECT * FROM review WHERE tradesman = '$username'";
                $rev = mysqli_query($db, $getR);
                while ($row = mysqli_fetch_array($rev)) {
                    echo "
        <tr>
        <td>" . $row["user"] . "</td>
        <td>" . $row["comments"] . "</td>
        <td>" . $row["score"] . "</td>"
                    ;
                }}
                else {
                    echo "No reviews yet";
                }
                ?>
            </table>
        </div>

    </section>

<script>
    $(document).ready(function(){
        $('#reviews').DataTable();
    });
</script>

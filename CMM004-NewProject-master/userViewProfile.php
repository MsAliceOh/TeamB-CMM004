<?php
session_start();

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

include ('server/connection.php');
if (isset($_POST['pro'])){
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
        $_SESSION['pic']= $row['photo'];
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
                        echo  $_SESSION['user'];
                        ; ?>
                    </p>
                    <br><a href="logout.php" style=" text-decoration: none;color: #b90002">Log-out</a>
                </div>

                <div >
                    <br>
                    <a href="jobPage.php" style=" text-decoration: none;color: blue; float: left; margin-left: 20px">
                        <button type="button" style="width: 80px; height: 30px"><-  Back</button>
                    </a>
                </div>

            </header>
        </section>


        <div class = "profile" style="/*margin-top: -20px*/">
            <h2><?php
                echo  $username;
                ?> Profile</h2>

            <?php
            if (empty($_SESSION['pic'])){ ?>
                <img src="profilePhoto/profileImage.png"   style="width: 200px; height: 200px;" alt="dif pic" class="profile_img" onclick="document.getElementById('id2').style.display='block'">
            <?php }else{
                $image = "profilePhoto/".$_SESSION['pic'];
                ?>
                <img style="width: 200px; height: 200px;" alt="upload pic" class="profile_img"  src="<?php echo $image;?>" onclick="document.getElementById('id2').style.display='block'">
            <?php } ?>

            <div id = "textbox">
                <h3>Username:</h3>
                <?php
                echo  $username;
                ?>
            </div>
            <div id = "textbox">
                <h3>Name:</h3>
                <?php
                echo $fname." ". $lname;
                ?>
            </div>
            <div id = "textbox">
                <h3>Email Address:</h3>
                <?php
                echo $email;
                ?>
            </div>
            <div id = "textbox">
                <h3>Address:</h3>
                <?php
                echo $add1."<br>".$add2."<br>".$city."<br>".$postcode;
                ?>
            </div>

            <div id = "textbox">
                <h3>Contact Number:</h3>
                <?php
                echo   $_SESSION['cont']."<br><br>" ;
                ?>
            </div>

            <div id = "textbox">
                <h3>About You:</h3>
                <?php
                echo $aboutY
                ?>
            </div>
            <div id = "textbox">
                <h3>Qualifications:</h3>
                <?php
                echo $qual;
                ?>
            </div>
        </div>

        <section class = "grid-100">

            <div>

                <h2>Reviews</h2>
                <h3>Overall Score: <?php
                    $av = "SELECT score FROM review WHERE tradesman = '$username'";
                    $avres = mysqli_query($db, $av);
                    $num = mysqli_num_rows($avres);
                    $set = array();
                    $tot = "";
                    if ($num >0){
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


    </main>
    </body>
    </html>
<?php } ?>
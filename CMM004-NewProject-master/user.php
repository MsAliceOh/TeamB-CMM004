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
    <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="userHome.css">

    <!-- load jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <!-- my JS function-->
    <!--
    <script>

        $(function(){
            $("#sub").click(function()
                                {
                                  var myData= //
                                var chosenProfession=$(myData).val();
                                var htmlCode="<option>"+chosenProfession+"</option>";
                                $("#prof1").append(htmlCode);
                               // alert("hi mo");
                                }
                            );
            }
        );

    </script>-->

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

        <h2 style="margin-top: 95px; text-align: center"><br>Welcome To Tradesman Aberdeen-User Home Page</h2>
        <br><br>
    </div>
    <section class="grid-50">

        <div id="userForm">

            <form method="post" action="userHomeP.php" enctype="multipart/form-data">

                <h3 style=" margin-top: auto;text-decoration-color: #176a5e; text-align: center;width: 100% ; height:border-box">Help Required</h3>

                <div class="input">

                    <label >Title</label>

                    <input name="tit" class="prof" id="disc" type="text" style="float: left" placeholder="Problem Title" required><br>

                </div>
                <br>
                <div class="input">
                    <label>I need a</label>
                    <select class= "prof"  id = "prof3" name="pro" required>
                        <option value = "#"selected> </option>
                        <option value = "Builder" >Builder</option>
                        <option value = "Plumber">Plumber</option>
                        <option value = "Electrician">Electrician</option>
                        <option value = "Stone Mason">Stone Mason</option>
                        <option value = "Welder">Welder</option>
                        <option value = "Carpenter">Carpenter</option>
                        <option value = "Painter/Decorator">Painter/Decorator</option>
                        <option value = "Handyman">Handyman</option>
                    </select>
                </div>
                <br>
                <div class="input" >

                    <label style="float: left">Description:</label>

                    <textarea   name="disc" datatype="text" rows="20" cols="50" id = "qualification" placeholder="Please describe what you need help with" required>

                        </textarea>

                </div>
                <br><br><br><br>
                <!--here where we calling the loadimg.php file to upload images if needed-->
                <label class="input">
                    <label>Upload Image</label>
                    <input type="file" class="inp" name="file">
                </label>
                <br><br><br><br>
                <td>&nbsp&nbsp&nbsp</td>

                <button id="sub" name="sub" type="submit" style="align-items: center; border-radius: 10px;  width: 90% ;height: 35px;"> <a class="btnA" href="#" style="text-decoration: none ;color: black">Submit</a></button>

            </form>

        </div>

    </section>

    <section class="grid-50">
        <div id="userForm">
            <form method = "post" action = "jobPage.php">

                <h3 style=" margin-top: auto;text-decoration-color: #176a5e; text-align: center;width: 100% ; height:border-box">Open Issues/View Current Bids</h3>
                <br><br>
                <select name = "myJobs" class = "prof">
                    <?php

                    $getJobs = "SELECT title FROM event WHERE user = '$username' and isOpen = 1 ";
                    $jobRes = mysqli_query($db,$getJobs);

                    while ($rows = $jobRes-> fetch_assoc()) {
                        $jobs = $rows ['title'];
                        echo "<option value = '$jobs'>$jobs</option>";
                    }
                       // $_SESSION["getJob"]= mysqli_real_escape_string($db, $_POST['myJobs']);
                    ?>
                    <!--/*

                     //   session_destroy();
                        if ( empty($_SESSION['TEST'])){
                          // $mo= $_GET($_SESSION["at"]);
                            $_SESSION["TEST"] = array();
                         //   array_shift($ju,$mo);
                        }
                        if (in_array($_SESSION['TEST'],$_SESSION["at"])){
                            array_push($_SESSION['TEST'],$_SESSION["at"]);
                        }




                        foreach ( $_SESSION['TEST'] as $k){
                            printf('<option>%s</option>',$k);

                        }
                      //  session_destroy();
                        // sort($myData,SORT_STRING);
                       /* $just= array();
                        $dat= array_push($just,$_SESSION["at"]);


                        for($x = 0; $x < 10; $x++) {
                            echo $just[$x];
                            //echo "<br>";
                        }

                        foreach ( $just as $data){
                            printf('<option>%s</option>', $data);

                        }
                      //  print_r($data);*/
                        */-->

                </select>


                <br><br><br><br>

                <button type="submit" value = "send" name ="submit" style="align-items: center; border-radius: 10px;  width: 90% ;height: 35px;"> <a class="btnA" href="#" style="text-decoration: none ;color: black" >Go To Job Page</button>
                <br><br><br>
                <!--<form method="post" action="disJobsFromList.php">
                <button name="dis" type="submit" style="align-items: center; width: 100% ;height: 35px; color: red "><a style="text-decoration: none; color: black" href="#"></a>
                    clear all options
                </button>
                </form>-->

            </form>
        </div>
        <div id="userForm">
            <form method = "post" action = "pastJobs.php">
                <h3 style=" margin-top: auto;text-decoration-color: #176a5e; text-align: center;width: 100% ; height:border-box">View All Accepted Bids & Historical Jobs</h3>
                <br><br>
                <button type="submit" value = "send" name ="submit" style="align-items: center; border-radius: 10px;  width: 90% ;height: 35px;"> <a class="btnA" href="#" style="text-decoration: none ;color: black""><a style="text-decoration: none; color: black">View</button>
                <br><br>
            </form>
        </div>

    </section>
</main>



</body>
</html>
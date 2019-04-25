<?php
session_start();
include ('server/connection.php');
//include ('server/userSignUp.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Tradesman</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css">

</head>
<body>

<main class = "grid-container">
    <form method="post" action="server/loginSystem.php" id = "loginForm">
        <div class = grid-100>
                <div class = "header1">

                    <div class = "logo">
                        <img src = "image/Logo.png">
                    </div>

                    <div class = "login" >
                        <table  >
                            <tr >
                                <td>Username or Email</td>
                                <td>Password</td>
                            </tr>
                            <tr>
                                <td><input  class="login-txt" type="text" name="username" placeholder="Email" ></td>
                                <td><input class="login-txt" type="password" name="password" placeholder="Enter Password"></td>
                                <td><input type="submit" name="login" value="Login" class="btn"></td>
                            </tr>
                            <tr>
                                <td>&nbsp</td>
                                <td><a href="resetPasswordPage.php">forgotten password!</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
    </form>

    <div id = "title"><br>
        <h1>Tradesman Aberdeen </h1>
        <h2>Connecting  tradesmen to the people who need them.</h2>
    </div>

    <section class = grid-50>
        <div id = "userForm">
            <form method="post" action="server/userSignUp.php">
                <?php //include('server/errors.php');

                if (isset($_GET['regu'])){
                    if ($_GET['regu'] == "empty"){?>
                        <div class="error"><?php echo "You have not completed all required fields";?></div>
                    <?php }

                    if ($_GET['regu'] == "notgood"){?>
                        <div class="error"><?php echo "Invalid First or Last name";?></div>
                    <?php }

                    if ($_GET['regu'] == "ken"){?>
                        <div class="error"><?php echo "Username been taken....!";?></div>
                    <?php }

                    if ($_GET['regu'] == "patch"){?>
                        <div class="error"><?php echo "Passwords do not match";?></div>
                    <?php }

                    if ($_GET['regu'] == "add"){?>
                        <div class="error"><?php echo "Please enter your full address";?></div>
                    <?php }

                    if ($_GET['regu'] == "qu"){?>
                        <div class="error"><?php echo "You cannot choose the same security question";?></div>
                    <?php }
                }
                ?>

                <h2>Create a User Account</h2>
                <h3>I need help!</h3>
                <div class="input">
                    <label>First Name</label>
                    <input type="text" name="1name" placeholder="First Name" required>
                </div>
                <div class="input">
                    <label>Last Name</label>
                    <input type="text" name="u2name" placeholder="last name" required>
                </div>
                <div class="input">
                    <label>Address</label>
                    <input type="text" name="add1" placeholder=""required><br>
                    <input type="text" name="add2" placeholder=""><br>
                    <input type="text" name="city" placeholder=""required><br>
                    <label>Post Code</label>
                    <input type="text" name="postcode" placeholder="postcode" required>
                </div>
                <div class="input">
                    <label>Contact Number</label>
                    <input type="text" name="contact" placeholder="Contact Number">
                </div>
                <div class="input">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username"required>
                </div>
                <div class="input">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="email" required>
                </div>
                <div class="input">
                    <label>Password</label>
                    <input type="password" name="password0" placeholder="password" required>
                </div>
                <div class="input">
                    <label>Confirm Password</label>
                    <input type="password" name="password1" placeholder="confirm password" required>
                </div>
                <div class="input">
                    <button onclick="document.getElementById('user').style.display='block'" type="button" name="erRej" class="btn">Register as User</button>
                </div>

                <!-- selection of the security questions for user start here-->
                <div id="user"  class="modal">
                    <div class="modal-content animate">
                        <h2>Please select and answer your security questions</h2>
                    <h3>You will be able to use these to reset your password if required</h3>

                    <label for="q1">question 1</label>
                    <select class="justMo" name = "q1">
                        <?php

                        $query = "SELECT * FROM questions";
                        $result = mysqli_query($db,$query);
                        while ($rows = $result -> fetch_assoc()) {
                            $qid = $rows['qid'];
                            $question = $rows ['question_name'];?>
                            <option value = "<?php echo $qid ?>"><?php echo $question; ?> </option>
                       <?php }?>
                    </select>
                    <label for="ans1">Answer 1</label>
                    <input class="justMo" type="text" name="ans1" placeholder="answer" required>

                    <label for="q2">question 2</label>
                    <select class="justMo" name = "q2">

                        <?php
                        $query = "SELECT * FROM questions";
                        $result = mysqli_query($db,$query);
                        while ($rows = $result -> fetch_assoc()) {
                            $qid = $rows['qid'];
                            $question = $rows ['question_name'];?>
                            <option value = "<?php echo $qid ?>"><?php echo $question; ?> </option>
                        <?php }?>

                    </select>
                    <label for="ans2">Answer 2</label>
                    <input  class="justMo" type="text" name="ans2" placeholder="answer" required>
                    <button class="button1" type="submit" name="userRej">Register</button><br><br>
                    <button type="button" onclick="document.getElementById('user').style.display='none'" class="cancelbtn">Cancel</button>
                    </div>
                </div>
                <!-- selection of the security questions for users end here-->
            </form>
        </div>
    </section>

    <section class = grid-50>
        <div id = "tradeForm">
            <form method="post" action="server/tradeSignUp.php">
                <?php //include('server/errors.php');
                if (isset($_GET['tre'])){
                    if ($_GET['tre'] == "empty"){?>
                <div class="error"><?php echo "You have not completed all required fields";?></div>
                   <?php }

                    if ($_GET['tre'] == "f_L"){?>
                        <div class="error"><?php echo "Invalid First or Last name";?></div>
                    <?php }

                    if ($_GET['tre'] == "uken"){?>
                        <div class="error"><?php echo "Username been taken....!";?></div>
                    <?php }

                    if ($_GET['tre'] == "patch"){?>
                        <div class="error"><?php echo "Passwords do not match";?></div>
                    <?php }

                    if ($_GET['tre'] == "add"){?>
                        <div class="error"><?php echo "Please enter your full address";?></div>
                    <?php }

                    if ($_GET['tre'] == "qu"){?>
                        <div class="error"><?php echo "You cannot choose the same security question";?></div>
                    <?php }

                }
                ?>
                <h2>Create a Tradesman Account</h2>
                <h3>I can help!</h3>
                <div class="input">
                    <label>First Name</label>
                    <input type="text" name="1name_tr" placeholder="First Name" required>
                </div>
                <div class="input">
                    <label>Last Name</label>
                    <input type="text" name="u2name_tr" placeholder="last name" required>
                </div>
                <div class="input">
                    <label>Address</label>
                    <input type="text" name="add1_tr" placeholder=""><br>
                    <input type="text" name="add2_tr" placeholder=""><br>
                    <input type="text" name="city_tr" placeholder=""><br>
                    <label>Post Code</label>
                    <input type="text" name="postcode_tr" placeholder="postcode">
                </div>
                <div class="input">
                    <label>Contact Number</label>
                    <input type="text" name="contact" placeholder="Contact Number">
                </div>
                <div class="input">
                    <label>Username</label>
                    <input type="text" name="username_tr" placeholder="Username" required>
                </div>
                <div class="input">
                    <label>Email</label>
                    <input type="email" name="email_tr" placeholder="email" required>
                </div>
                <div class="input">
                    <label>Password</label>
                    <input type="password" name="password_tr" placeholder="password" required>
                </div>
                <div class="input">
                    <label>Confirm Password</label>
                    <input type="password" name="password1_tr" placeholder="confirm password" required>
                </div>
                <div class="input" id = "profSelect" >
                    <div class="input">
                        <label>Profession</label>
                        <select name = "profession[]" multiple = "multiple" style = "height: 100px; width: 93%; padding: 5px 10px; font-size: 16px; border-radius: 5px; border: 1px solid gray; resize: none;">
                            <option value = "Builder">Builder</option>
                            <option value = "Plumber">Plumber</option>
                            <option value = "Electrician">Electrician</option>
                            <option value = "Stone Mason">Stone Mason</option>
                            <option value = "Welder">Welder</option>
                            <option value = "Carpenter">Carpenter</option>
                            <option value = "Painter/Decorator">Painter/Decorator</option>
                            <option value = "Handyman">Handyman</option>
                        </select>
                        <p>Press ctrl to select multiple</p>
                    </div>
                </div>
                <div class="input">
                    <label>About you</label>
                    <textarea  name="AboutYou" id="aboutYou" placeholder=" Please enter a brief description of yourself and the work you do..."></textarea>
                </div>
                <div class="input">
                    <label>Qualifications</label>
                    <textarea  name="qua" id="qualification" placeholder="Please list any qualifications you have here..."></textarea>
                </div>
                <div class="input">
                    <button type="button" onclick="document.getElementById('mo').style.display='block'" name="tradeR" value = "add" class="btn">Register as Tradesman </button>
                </div>
                <!-- selection of the security questions for tradesman start here-->
                <div id="mo"  class="modal">
                    <div class="modal-content animate">
                        <h3>Please the security questions and the answer will saved for security </h3>
                        <span onclick="document.getElementById('mo').style.display='none'" class="close" title="Close Modal">&times;</span>
                        <label for="q1">question 1</label>
                        <select class="justMo" name = "q1">
                            <?php

                            $query = "SELECT * FROM questions";
                            $result = mysqli_query($db,$query);
                            while ($rows = $result -> fetch_assoc()) {
                                $qid = $rows['qid'];
                                $question = $rows ['question_name'];?>
                                <option value = "<?php echo $qid ?>"><?php echo $question; ?> </option>
                            <?php }?>
                        </select>
                        <label for="ans1">Answer 1</label>
                        <input class="justMo" type="text" name="ans1" placeholder="answer">

                        <label for="q2">question 2</label>

                        <select class="justMo" name = "q2">

                            <?php
                            $query = "SELECT * FROM questions";
                            $result = mysqli_query($db,$query);
                            while ($rows = $result -> fetch_assoc()) {
                                $qid = $rows['qid'];
                                $question = $rows ['question_name'];?>
                                <option value = "<?php echo $qid ?>"><?php echo $question; ?> </option>
                            <?php }?>
                        </select>
                        <label for="ans2">Answer 2</label>
                        <input  class="justMo" type="text" name="ans2" placeholder="answer">

                        <button class="button1" type="submit" name="tradesRej">Register</button><br><br>
                        <button type="button" onclick="document.getElementById('mo').style.display='none'" class="cancelbtn">Cancel</button>
                    </div>
                </div>
            </form>
            <script>
                // Get the modal

                var mo = document.getElementById('mo');
                var user= document.getElementById('user');

                window.onclick = function(security) {
                    if ( (security.target == mo) || (security.target == user)) {
                        user.style.display= "none";
                        mo.style.display = "none";

                    }
                }
            </script>
        </div>
    </section>

</main>

</body>
</html>

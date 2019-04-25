<?php
session_start();
include ('server/connection.php');

if (isset($_POST['answer'])) {
    $awnr1 = mysqli_real_escape_string($db, $_POST['answer1']);
    $awnr2 = mysqli_real_escape_string($db, $_POST['answer2']);

    if (empty($awnr1) || empty($awnr2)) {
        header('location : mainpage.php?answer=empty');
        exit();
    } else {

        $anser1 = $_SESSION['n1'];
        $anser2 = $_SESSION['n2'];

        $answer1 = password_verify($awnr1, $anser1);
        $answer2 = password_verify($awnr2, $anser2);

        if (($answer1 == false) || ($answer2 == false)) {
            array_push($errors, "Was wrong Password");
            header('location: mainpage.php?ans=password_wrong_user');
            exit();
        }
        else{
            if (($answer1 == true) && ($answer2 == true)) {
                header('location: restPass.php?allGood');
                exit();
            }
        }
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="#">
    <meta charset="UTF-8">
    <title>Answer security questions</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css">
</head>
<body>

<div >
    <form class="modal-content animate" method="post" action="questionAnswer.php">
        <div class="imgcontainer">
            <a href="mainpage.php" style="text-decoration: none"> <span onclick="document.getElementById('pass').style.display='none'" class="close" title="Close Modal">&times;</span> </a>
        </div>
        <h3>Please answer the security questions...</h3><br>
        <p><?php echo $_SESSION['q12'] ; ?></p><br>
        <input class="justMo" type="text" placeholder="answer 1...." name="answer1"><br><br>
        <p><?php echo   $_SESSION['q123'] ; ?></p><br>
        <input class="justMo" type="text" placeholder="answer 2...." name="answer2"><br><br>
        <button class="button1" name="answer" type="submit">Submit</button>
        <a href="mainpage.php" style="text-decoration: none"><button type="button" name="cancel">Cancel</button></a>
    </form>
</div>

</body>
</html>
<?php
session_start();
include('server/connection.php');

if (isset($_POST['uEmail'])){

    $us= mysqli_real_escape_string($db,$_POST['username']);
    $_SESSION['mo']=$us;
    if (empty($us)){

    }else{
        $sql= "SELECT * FROM login WHERE username='$us' OR email= '$us'";
        $qur= mysqli_query($db,$sql);

        if (mysqli_num_rows($qur) == 0){
            header('location : mainpage.php?resultNotFound');
            exit();
        }else{

            while ($row = mysqli_fetch_assoc($qur)){
                $_SESSION['just']=$row['username'];
            }
            $name =  $_SESSION['just'];

            $sqln= "SELECT * FROM answers WHERE username  = '$name'";
            $qurn= mysqli_query($db,$sqln);

            if (mysqli_num_rows($qur) != 0) {
                while ($row = mysqli_fetch_assoc($qurn)) {
                    $_SESSION['q1'] = $row['qid1'];
                    $_SESSION['n1'] = $row['ans1'];
                    $_SESSION['q2'] = $row['qid2'];
                    $_SESSION['n2'] = $row['ans2'];
                }

                $q1 = $_SESSION['q1'];
                $q2 = $_SESSION['q2'];
                $sql12 = "SELECT * FROM questions WHERE  qid= '$q1'";
                $qur12 = mysqli_query($db, $sql12);

                while ($row = mysqli_fetch_assoc($qur12)) {
                    $_SESSION['q12'] = $row['question_name'];
                }


                $sql123 = "SELECT * FROM questions WHERE qid= '$q2'";
                $qur123 = mysqli_query($db, $sql123);
                while ($rows = mysqli_fetch_assoc($qur123)) {
                    $_SESSION['q123'] = $rows['question_name'];
                }


                header('location : questionAnswer.php?allGood');
                exit();
            }else{
                header('location : mainpage.php?reset=notSub');
                exit();
            }
        }

    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="">
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css">
</head>
<body>

<div  >
    <form class="modal-content animate"  method="post" action="resetPasswordPage.php">
       <div class="imgcontainer">
            <a href="mainpage.php" style="text-decoration: none"> <span onclick="document.getElementById('pass').style.display='none'" class="close" title="Close Modal">&times;</span> </a>
        </div>

        <label for="username"><b>username</b></label>
        <input class="justMo" type="text" placeholder="username/Email" name="username">
        <button class="button1" name="uEmail" type="submit">Submit</button>
        <a href="mainpage.php" style="text-decoration: none"><button type="button" name="cancel">Cancel</button></a>

    </form>
</div>


<script>
    var pass = document.getElementById('pass');
    var answerForm = document.getElementById('answerForm');
    var res = document.getElementById('res');
    window.onclick = function(update) {
        if ((update.target == pass) || (update.target == answerForm) || (update.target == res)) {
            pass.style.display = "none";
            answerForm.style.display = "none";
            res.style.display = "none";
        }
    }
</script>
</body>
</html>
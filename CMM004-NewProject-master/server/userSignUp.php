<?php
session_start();
$username = "";
$email    = "";
$errors = array();
include ('connection.php');

if (isset($_POST['userRej'])) {

    $first = mysqli_real_escape_string($db, $_POST['1name']);
    $last = mysqli_real_escape_string($db, $_POST['u2name']);
    $add1 = mysqli_real_escape_string($db, $_POST['add1']);
    $add2 = mysqli_real_escape_string($db, $_POST['add2']);
    $city = mysqli_real_escape_string($db, $_POST['city']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);
    $post_user = mysqli_real_escape_string($db, $_POST['postcode']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $pass1 = mysqli_real_escape_string($db, $_POST['password0']);
    $pass2 = mysqli_real_escape_string($db, $_POST['password1']);


    $qid1 =  mysqli_real_escape_string($db, $_POST['q1']);
    $ans1 =  mysqli_real_escape_string($db, $_POST['ans1']);
    $qid2 =  mysqli_real_escape_string($db, $_POST['q2']);
    $ans2 =  mysqli_real_escape_string($db, $_POST['ans2']);


    ////////
    if (empty($first) || empty($last) || empty($add1) || empty($city) || empty($post_user) || empty($pass1)  || empty($pass2)  || empty($username)  || empty($email)){
        header('location: ../mainpage.php?regu=empty');
        exit();
    }else {

        if (! preg_match("/^[a-zA-Z]*$/", $first) || ! preg_match("/^[a-zA-Z]*$/", $last)) {
            header('location: ../mainpage.php?regu=notgood');
            //array_push($errors,"just chechimg ");
            exit();
        } else {
            if (empty($add1) || empty($city) || empty($post_user)) {

                header('location: ../mainpage.php?regu=add');
                exit();
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    header('location: ../mainpage.php?regu=email');
                    exit();
                } else {
                    $check_user = "SELECT * FROM login WHERE username= '$username' OR email='$email' ";
                    $result = mysqli_query($db, $check_user);
                    $get = mysqli_num_rows($result);
                    if ($get != 0) {
                        header('location: ../mainpage.php?regu=ken');
                        exit();
                    }else{
                        if ($pass1 != $pass2){
                            header('location: ../mainpage.php?regu=patch');
                          //  array_push($errors,"just checking ");
                            exit();
                        }else{

                            if ($qid1==$qid2){

                                header('location : ../mainpage.php?regu=qu');
                                exit();
                            }else{
                                $password = password_hash($pass2, PASSWORD_DEFAULT);// HASH the password
                                //insert the login data into login table
                            $sql= "INSERT INTO login (username,email,password,isTradesman) VALUES ('$username','$email','$password',0)";
                            $res=mysqli_query($db,$sql);
                           // insert the tradesman data into tradesman table
                            $sql_user= "INSERT INTO user (username,firstname,lastname,add1 , add2, city, postcode,contact)                                 VALUES ('$username', '$first','$last' ,'$add1','$add2', '$city', '$post_user','$contact')";
                           mysqli_query($db,$sql_user);
                           $_SESSION['user']= $username;

                            // insert into answers tables
                            $ans1Hash = password_hash($ans1, PASSWORD_DEFAULT);
                            $ans2Hash = password_hash($ans2, PASSWORD_DEFAULT);
                            $sql_security = "INSERT INTO answers (username, qid1, ans1, qid2, ans2) VALUES ('$username','$qid1', '$ans1Hash','$qid2','$ans2Hash')";
                            mysqli_query($db, $sql_security);
                            header('location : ../user.php?allGood');
                           exit();

                            }
                        }
                    }

                }
            }
        }

    }



}else{
    header('location: ../mainpage.php');
    exit();
}
    ///////
///
///             $password = password_hash($pass2, PASSWORD_DEFAULT);// HASH the password
//                            // insert the login data into login table
//                            $sql= "INSERT INTO login (username,email,password,isTradesman) VALUES ('$username','$email','$password',0)";
//                            $res=mysqli_query($db,$sql);
//
//                            // insert the tradesman data into tradesman table
//                            $sql_user= "INSERT INTO user (username,firstname,lastname,add1 , add2, city, postcode,contact)
//                                      VALUES ('$username', '$first','$last' ,'$add1','$add2', '$city', '$post_user','$contact')";
//                            mysqli_query($db,$sql_user);
//                            $_SESSION['user']= $username;
//
//                            // insert into answers tables
//                            $ans1Hash = password_hash($ans1, PASSWORD_DEFAULT);
//                            $ans2Hash = password_hash($ans2, PASSWORD_DEFAULT);
//                            $sql_security = "INSERT INTO answers (username, qid1, ans1, qid2, ans2) VALUES ('$username','$qid1', '$ans1Hash','$qid2','$ans2Hash')";
//                            mysqli_query($db, $sql_security);
//                            header('location : ../user.php?allGood');
//                            exit();


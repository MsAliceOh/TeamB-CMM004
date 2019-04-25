<?php
session_start();

$errors = array();
include ('connection.php');

if (isset($_POST['tradesRej'])) {
    $first = mysqli_real_escape_string($db, $_POST['1name_tr']);
    $last = mysqli_real_escape_string($db, $_POST['u2name_tr']);
    $add1 = mysqli_real_escape_string($db, $_POST['add1_tr']);
    $add2 = mysqli_real_escape_string($db, $_POST['add2_tr']);
    $city = mysqli_real_escape_string($db, $_POST['city_tr']);
    $post_tr = mysqli_real_escape_string($db, $_POST['postcode_tr']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);
    $username = mysqli_real_escape_string($db, $_POST['username_tr']);
    $email = mysqli_real_escape_string($db, $_POST['email_tr']);
    $pass1 = mysqli_real_escape_string($db, $_POST['password_tr']);
    $pass2 = mysqli_real_escape_string($db, $_POST['password1_tr']);
    $prof = $_POST['profession'];
    $you = mysqli_real_escape_string($db, $_POST['AboutYou']);
    $que = mysqli_real_escape_string($db, $_POST['qua']);

    $qid1 =  mysqli_real_escape_string($db, $_POST['q1']);
    $qid2 =  mysqli_real_escape_string($db, $_POST['q2']);
    $ans1 =  mysqli_real_escape_string($db, $_POST['ans1']);
    $ans2 =  mysqli_real_escape_string($db, $_POST['ans2']);

    //to make sure all or most of the places are filled correctly
    /*
    if (empty($username)) {
        array_push($errors, "username is required");
    }
    if (empty($email)) {
        array_push($errors, "email is required");
    }
    */
   // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     //   array_push($errors, "postcode is required");
   // }



//if ($qid1 == $qid2) {
  //  array_push($errors, "You cannot choose the same security question");
//}
    /*
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    */
  //  if ($pass1 != $pass2) {
    //    array_push($errors, "the password do not match");}
  /*
    if (empty($first)) {
        array_push($errors, "First name is required");
    }
    if (empty($last)) {
        array_push($errors, "Last name is required");
    }
    if (empty($add1)) {
        array_push($errors, "the first line is required");
    }
    if (empty($city)) {
        array_push($errors, "city name is required");
    }
    if (empty($post_user)) {
        array_push($errors, "postcode is required");
    }
*/
    ////////


    // checking time lool
    if (empty($first) || empty($last) || empty($add1) || empty($city) || empty($post_tr) || empty($pass1)  || empty($pass2)  || empty($prof)  || empty($you)  || empty($que) || empty($username)  || empty($email)){
        header('location: ../mainpage.php?tre=empty');
        exit();
    }else {

        if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
            header('location: ../mainpage.php?tre=f_L');
            exit();
        } else {
            if (empty($add1) || empty($city) || empty($post_tr)) {

                header('location: ../mainpage.php?tre=add');
                exit();
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    header('location: ../mainpage.php?tre=right');
                    exit();
                } else {
                    $check_user = "SELECT * FROM login WHERE username= '$username' OR email='$email' ";
                    $result = mysqli_query($db, $check_user);
                    $get = mysqli_num_rows($result);

                    if ($get != 0) {
                        header('location: ../mainpage.php?tre=uken');
                        exit();
                    }else{
                        if ($pass1 != $pass2){
                            header('location: ../mainpage.php?tre=patch');
                            exit();
                        }else{

                            if ($qid1==$qid2){
                                header('location : ../mainpage.php?tre=qu');
                                exit();
                            }else{

                                $password=  password_hash($pass1, PASSWORD_DEFAULT);// HASH the password
                                // insert into login data in to login table
                                $sql= "INSERT INTO login (username,email,password,isTradesman) VALUES ('$username','$email','$password',1)";
                                mysqli_query($db,$sql);

                                // insert into tradesman data in to tradesman table
                                $sql_t= "INSERT INTO tradesman(username, firstname, lastname, add1, add2, city, contact, postcode, aboutYou, qualifications) VALUES ('$username', '$first','$last' ,'$add1','$add2', '$city','$contact', '$post_tr','$you','$que')";
                                mysqli_query($db,$sql_t);

                                // insert into profession data in to profession table
                                if ($prof) {
                                    foreach ($prof as $p) {
                                        mysqli_query($db, "INSERT INTO trades_prof(profession,username) VALUES ('" .
                                            mysqli_real_escape_string($db, $p) ."','".$username."')");
                                    }


                                }

                                $ans1Hash = password_hash($ans1, PASSWORD_DEFAULT);
                                $ans2Hash = password_hash($ans2, PASSWORD_DEFAULT);
                                $sql_security = "INSERT INTO answers (username, qid1, ans1, qid2, ans2) VALUES ('$username','$qid1', '$ans1Hash','$qid2','$ans2Hash')";
                                mysqli_query($db, $sql_security);
                                $_SESSION['user'] = $username;
                                header('location: ../tradesmanHomepage.php');
                                exit();
                            }
                        }
                    }

                }
            }
        }

    }



}else {
    header('location: ../mainpage.php');
    exit();
}
    ///////
  /*  if (empty($prof)) {
        array_push($errors, "You must select a profession");
    }

    else {
        $check_user = "SELECT * FROM login WHERE username= '$username' OR email='$email' ";
        $result = mysqli_query($db, $check_user);
        $get = mysqli_num_rows($result);
        if ($get != 0) {
            array_push($error, "Username or email taken");
        } else {
            $password = password_hash($pass2, PASSWORD_DEFAULT);// HASH the password

            $sql = "INSERT INTO login (username,email,password,isTradesman) VALUES ('$username','$email','$password',1)";
            mysqli_query($db, $sql);

            // insert into tradesman data in to tradesman table
            $sql_t = "INSERT INTO tradesman(username, firstname, lastname, add1, add2, city, postcode, contact, aboutYou, qualifications) VALUES ('$username', '$first','$last' ,'$add1','$add2', '$city', '$post_tr','$contact','$you','$que')";
            mysqli_query($db, $sql_t);

            // insert into profession data in to profession table
            if ($prof) {
                foreach ($prof as $p) {
                    mysqli_query($db, "INSERT INTO trades_prof(profession,username) VALUES ('" .
                        mysqli_real_escape_string($db, $p) ."','".$username."')");
                }


            }
            $ans1Hash = password_hash($ans1, PASSWORD_DEFAULT);
            $ans2Hash = password_hash($ans2, PASSWORD_DEFAULT);

            $sql_security = "INSERT INTO answers (username, qid1, ans1, qid2, ans2) VALUES ('$username','$qid1', '$ans1Hash','$qid2','$ans2Hash')";
            mysqli_query($db, $sql_security);
            $_SESSION['user'] = $username;
            header('location: ../tradesmanHomepage.php');
            exit();
        }
    }
}*/
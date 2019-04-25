<?php
session_start();
include ('server/connection.php');
    $username = $_SESSION["user"];

// update username in the two table login and tradesman
if (isset($_POST['update_username'])){
    $uname=mysqli_real_escape_string($db,$_POST['uname']);

    if (! empty($uname)){
        $user= "UPDATE login SET username='$uname' WHERE username= '$username' ";
        $user1= "UPDATE tradesman SET username='$uname' WHERE username='$username'";
        $user2= "UPDATE trades_prof SET username='$uname' WHERE username= '$username' ";
        $user3= "UPDATE bids SET username='$uname' WHERE username= '$username' ";

        $users= mysqli_query($db,$user);
        $users1= mysqli_query($db,$user1);
        $user2= mysqli_query($db,$user2);
        $user3= mysqli_query($db,$user3);
        header('location : mainpage.php?updateUsername=success');
        exit();
    }else{
        header('tradeProfile.php?error==username');
        exit();
    }
}
// update first and last name
if (isset($_POST['update_f_l'])) {
    $first=mysqli_real_escape_string($db,$_POST['first']);
    $last=mysqli_real_escape_string($db,$_POST['last']);
    if (!empty($first) || !empty($last)) {
        $user = "UPDATE tradesman SET firstname='$first',lastname='$last'  WHERE username='$username'";
        $users = mysqli_query($db, $user);
        header('location : tradeProfile.php?update_f_lName=success');
        exit();
    }else{
        header('tradeProfile.php?error=first_last');
        exit();
    }
}
//update email
if (isset($_POST['update_email'])) {
    $email=mysqli_real_escape_string($db,$_POST['email']);
    if (!empty($email)) {
        $user = "UPDATE login SET email='$email' WHERE username='$username'";
        $users = mysqli_query($db, $user);
        eader('tradeProfile.php?update=email==success');
        exit();
    }else{
        header('tradeProfile.php?error=email');
        exit();
    }
}
//update password
if (isset($_POST['update_pass'])) {
    $psw1=mysqli_real_escape_string($db,$_POST['psw1']);
    $psw2=mysqli_real_escape_string($db,$_POST['psw2']);
    if (!empty($psw1) || !empty($psw2)) {
        if ($psw1 != $psw2) {
            header('tradesmanProfile.php?password=notMatch');
            exit();
        } else {
            $password = password_hash($psw2, PASSWORD_DEFAULT);
            $user = "UPDATE login SET password='$psw2' WHERE username='$username'";
            $users = mysqli_query($db, $user);
            header('location : mainpage.php?update=success==password');
            exit();
        }
    }else{
        header('tradeProfile.php?error=password');
        exit();
    }
}

//update contact number
if (isset($_POST['update_con'])) {
    $contact=mysqli_real_escape_string($db,$_POST['contact']);
    if (!empty($contact)) {
        $user = "UPDATE tradesman SET contact='$contact' WHERE username='$username'";
        $users = mysqli_query($db, $user);
        header('location : tradeProfile.php?update_contact=success');
        exit();
    }else{
        header('tradeProfile.php?error=contact');
        exit();
    }
}

//update address
if (isset($_POST['update_add'])) {
    $add1_tr=mysqli_real_escape_string($db,$_POST['add1_tr']);
    $add2_tr=mysqli_real_escape_string($db,$_POST['add2_tr']);
    $city_tr=mysqli_real_escape_string($db,$_POST['city_tr']);
    $postcode_tr=mysqli_real_escape_string($db,$_POST['postcode_tr']);
    if (!empty($add1_tr) || !empty($city_tr) || !empty($postcode_tr)) {
        $user = "UPDATE tradesman SET add1='$add1_tr',add2='$add2_tr', city='$city_tr', postcode='$postcode_tr' WHERE username='$username'";
        $users = mysqli_query($db, $user);
        header('location : tradeProfile.php?update_add=success');
        exit();
    }else{
        header('tradeProfile.php?error=address');
        exit();
    }

}

//update bout you
if (isset($_POST['Ayou'])) {
    $about_you=mysqli_real_escape_string($db,$_POST['about_you']);
    if (!empty($about_you) ) {
        $user = "UPDATE tradesman SET aboutYou='$about_you'  WHERE username='$username'";
        $users = mysqli_query($db, $user);
        header('tradeProfile.php?update_about=success');
        exit();
    } else {
        header('tradeProfile.php?error=about');
        exit();
    }
}

//update the qualification
if (isset($_POST['qua'])) {
        $qua = mysqli_real_escape_string($db, $_POST['qua']);
      if (! empty($qua)){
         $user= "UPDATE tradesman SET aboutYou='$qua' WHERE username='$username'";
         $users= mysqli_query($db,$user);
         header('tradeProfile.php?update_qua=success');
         exit();
      } else {
        header('tradeProfile.php?error=qua');
        exit();
      }
}
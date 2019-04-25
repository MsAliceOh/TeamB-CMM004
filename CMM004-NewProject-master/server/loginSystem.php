<?php
session_start();
include ('connection.php');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

if (isset($_POST['login'])){
    $username = mysqli_real_escape_string($db,$_POST['username']);
    $password = mysqli_real_escape_string($db,$_POST['password']);
    // doing checking if the user enter the right information
    if(empty($username) || empty($password)){
        header('location: ../mainpage.php?login=wrong_empty');
        exit();
    }else{
        // $pass=md5($password);AND password= '$pass
        $sql= "SELECT * FROM login WHERE username='$username' OR email= '$username'";
        $result = mysqli_query($db,$sql);
        $check= mysqli_num_rows($result);
        //  print_r($check);
        //exit();
        if ($check !=1){
            header('location: ../mainpage.php?login=wrong_sql_NotThere');
            exit();
        }else{
            $id= "SELECT isTradesman FROM login WHERE username='$username' OR email= '$username' ";
            $res= mysqli_query($db,$id);
            $check1= mysqli_num_rows($res);
            $rows = mysqli_fetch_assoc($res);

            if ($rows ['isTradesman'] == 1){
                $row = mysqli_fetch_assoc($result);
                $password1= password_verify($password, $row['Password']);
                //print_r( $row);
                //print_r("<br>".$pass);
                //print_r("<br>".$password1);
                // print_r( $row);
                // exit();
                if ($password1=false){
                    header('location: ../mainpage.php?password_wrong');
                }elseif ($password1=true){
                    $_SESSION['user']=$row['username'];
                    header('location : ../tradesmanHomepage.php');
                    $_SESSION['allGood']= "you have logged in successfully";
                    exit();
                }


            }else{
                if ($row = mysqli_fetch_assoc($result)){
                    $password2= password_verify($password,$row['password']);
                    if ($password2==false){
                        header('location:  ../mainpage.php?password_wrong_user');
                        exit();
                    }elseif ($password2==true){
                        $_SESSION['user']=$row['username'];
                        header('location : ../user.php');
                        $_SESSION['allGood']= "you have logged in successfully";
                        exit();
                    }

                }else{
                    header('location: ../mainpage.php?userNotExist');
                    exit();
                }
            }

        }
    }
}else{
    header('location:  ../mainpage.php?login=error');
    exit();
}
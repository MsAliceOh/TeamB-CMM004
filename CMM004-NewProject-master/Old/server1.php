<?php
include('server/connection.php');


session_start();


$username= "";
$password="";
$errors= array();

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
        header('Location: mainPage.html');
       // exit()
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
        header('Location: mainPage.html');
    }

    if (count($errors) == 0) {
        //header('Location: /server1.php?empty');
      $password = md5($password);
        $query = "SELECT * FROM user_info WHERE email='$username'  AND password='$password'";
        $results = mysqli_query($db, $query);
        $user = mysqli_num_rows($results);

        if ($user== 1) {
           // $_SESSION["SUCCESS"] = "You are logged in!";
            $_SESSION['hELLO'] = "You are logged in!";
            $_SESSION["username"] = $username;

            header('location: home.php/?weDoneIt');
            echo $_SESSION["success"];

        }else {

            array_push($errors, "Wrong username/password combination");
            header('location: mainpage.php/? mo');
            }
    }
} // end of the user login checks

/**/


//register user

if(isset($_POST['userRej'])){

    $username= mysqli_real_escape_string($db,$_POST['username']);
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $password_1= mysqli_real_escape_string($db,$_POST['password']);
    $password_2 = mysqli_real_escape_string($db,$_POST['password1']);
    $f_name= mysqli_real_escape_string($db,$_POST['1name']);
    $L_name= mysqli_real_escape_string($db,$_POST['u2name']);
    $add_1= mysqli_real_escape_string($db,$_POST['add1']);
    $add_2= mysqli_real_escape_string($db,$_POST['add2']);
    $city= mysqli_real_escape_string($db,$_POST['city']);
    $postcode= mysqli_real_escape_string($db,$_POST['postcode']);
// extra staff for the tradesman  :0
    $profession= mysqli_real_escape_string($db,$_POST['profession']);
    $ab_you= mysqli_real_escape_string($db,$_POST['AboutYou']);
    $qua= mysqli_real_escape_string($db,$_POST['qua']);



    //to make sure all or most of the places are filled correctly
    if(empty($username)){ array_push($error,"username is required");}
    if(empty($email)){ array_push($error,"email is required");}
    if(empty($password_1)){ array_push($error,"Password is required");}
    if($password_1 != $password_2){array_push($error,"the password do not match");}
    if(empty($f_name)){ array_push($error,"First name is required");}
    if(empty($L_name)){ array_push($error,"Last name is required");}
    if(empty($add_1)){ array_push($error,"the first line is required");}
    if(empty($city)){ array_push($error,"city name is required");}
    if(empty($postcode)){ array_push($error,"postcode is required");}

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM user_info,tradesman_info WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
            header('Location: /server1.php?this_user_exists');
        }

        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
            header('Location: /server1.php?this_user_exists');
        }
    }

    // then, register user if there are no errors in the form
    if (empty($error)) {

        $password = md5($password_1);//encrypt the password before saving in the database

        $query = "INSERT INTO user_info (firstname,lastname,add1,add2,city,postcode,username, email, password, isTradesman) 
  			  VALUES('$f_name','$L_name','$add_1','$add_2','$city','$postcode','$username', '$email', '$password','0')";
        mysqli_query($db, $query);
        $_SESSION["username"] = $username;
        $_SESSION["success"] = "You are now logged in";
        echo $_SESSION["success"];

        echo "all good for now";

        header('Location: /server2.php?allGood_youAre_in');
    }
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        $query2 = "INSERT INTO tradesman_info (firstname,lastname,add1,add2,city,postcode,username, email, password,about_you,qualifications, isTradesman) 
  			  VALUES('$f_name','$L_name','$add_1','$add_2','$city','$postcode','$username', '$email', '$password','$ab_you','$qua','1')";
        mysqli_query($db, $query2);
        $pro= "INSERT INTO trades_prof (username,profession) VALUES ('$username','$profession')";
        mysqli_query($db,$pro);
        $_SESSION['username'] =  $username;
        $_SESSION['success'] = "You are now logged in";
        header('Location: /server1.php?allGood_youAre_in');
    }
} // end of the user registration form and starting of the trades form

/**/

// starting the tradesman registration form  ;)
/*
if(isset($_POST['tradesRej'])){

    $username= mysqli_real_escape_string($db,$_POST['username_tr']);
    $email = mysqli_real_escape_string($db,$_POST['email_tr']);
    $password_1= mysqli_real_escape_string($db,$_POST['password_tr']);
    $password_2 = mysqli_real_escape_string($db,$_POST['password1_tr']);
    $f_name= mysqli_real_escape_string($db,$_POST['1name_tr']);
    $L_name= mysqli_real_escape_string($db,$_POST['u2name_tr']);
    $add_1= mysqli_real_escape_string($db,$_POST['add1_tr']);
    $add_2= mysqli_real_escape_string($db,$_POST['add2_tr']);
    $city= mysqli_real_escape_string($db,$_POST['city_tr']);
    $postcode= mysqli_real_escape_string($db,$_POST['postcode_tr']);
    $profession= mysqli_real_escape_string($db,$_POST['profession']);
    $ab_you= mysqli_real_escape_string($db,$_POST['AboutYou']);
    $qua= mysqli_real_escape_string($db,$_POST['qua']);

    //to make sure all or most of the places are filled correctly
    if(empty($username)){ array_push($error,"username is required");}
    if(empty($email)){ array_push($error,"email is required");}
    if(empty($password_1)){ array_push($error,"Password is required");}
    if($password_1 != $password_2){array_push($error,"the password do not match");}
    if(empty($f_name)){ array_push($error,"First name is required");}
    if(empty($L_name)){ array_push($error,"Last name is required");}
    if(empty($add_1)){ array_push($error,"the first line is required");}
    if(empty($city)){ array_push($error,"city name is required");}
    if(empty($postcode)){ array_push($error,"postcode is required");}

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query1 = "SELECT * FROM user_info WHERE username='$username' OR email='$email' LIMIT 1";
    $result1 = mysqli_query($db, $user_check_query1);
    $trad = mysqli_fetch_assoc($result1);

    if ($trad) { // if user exists
        if ($trad['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($trad['email'] === $email) {
            array_push($errors, "email already exists");
        }
    }

    // then, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        $query2 = "INSERT INTO tradesman_info (firstname,lastname,add1,add2,city,postcode,username, email, password,about_you,qualifications,isTradesman)
  			  VALUES('$f_name','$L_name','$add_1','$add_2','$city','$postcode','$username', '$email', '$password','$ab_you','$qua','1';
        mysqli_query($db, $query2);
        $pro= "INSERT INTO trades_prof (profession) VALUES ('$profession')";
        mysqli_query($db,$pro);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('Location: /server1.php?allGood_youAre_in');
    }
}// end of the tradesman registration form

// all done for now see you soon

/*
<?php
session_start();
session_destroy();
location: mainpage.php/
 ?>


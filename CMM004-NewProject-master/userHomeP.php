
<?php
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
include ('server/connection.php');

//$db = mysqli_connect('CSDM-WEBDEV','1809441','1809411','db1809411_tradesman');
$error= array();
if (isset($_POST['sub'])){
    $title= mysqli_real_escape_string($db,$_POST['tit']);
    $disc= mysqli_real_escape_string($db,$_POST['disc']);
    $prof= mysqli_real_escape_string($db,$_POST['pro']);
    // $photo= mysqli_real_escape_string($db,$_POST['photo']);
    // error checking and push them to the array
    if(empty($title)){ array_push($error,"please enter a title to your problem");}
    elseif (empty($disc)){array_push($error,"please tell us what is your problem");}
    elseif (empty($prof)){array_push($error,"please choose the tradesman you need");}
    print_r(count($error));
    if (empty($error) ) {
        $pr = "SELECT profession FROM trades_prof WHERE profession='$prof'";
        $re = mysqli_query($db, $pr);
        if (mysqli_num_rows($re) != 0) {
            $row = mysqli_fetch_assoc($re);
            $pro = $row['profession'];
        }
        $username = $_SESSION['user'];

      //  $file = $_FILES['upload'];

        $targetDir="C:/inetpub/wwwroot/1808957/NewCMM004-NewProject-master/CMM004-NewProject-master/uploadImages/";
        $fileName = basename($_FILES["file"]["name"]);
       // $fileError = $_FILES["upload"]["error"];
        $fileTmpName = $_FILES["file"]["tmp_name"];

        $folder = $targetDir.$fileName;
        move_uploaded_file($fileTmpName, $folder);
    }
    //that the end of the image upload file
    $just= " INSERT INTO event(user, needs, title, description, photo, isOpen) values ('$username','$prof','$title','$disc','$fileName',1) ";
    // echo $just;
    print_r($just." insert in the table<br>");
    $sql = mysqli_query($db,$just);
    print_r($sql." my sql stat<br>");
   //print_r($error) ;
    header('location: ../CMM004-NewProject-master/user.php');
    // echo "<br>all good so far";
}
/*
$result=" SELECT title from event WHERE title='$title'";
$get= mysqli_query($db,$result);
print_r($get);
if (mysqli_num_rows($get) !=0){
    while ($row= mysqli_fetch_assoc($get)){
        $_SESSION["at"]=$row['title'];
        echo  "Hello".$_SESSION["at"];
        header('location: ../CMM004-NewProject-master/user.php');

    }
}
if (isset($_POST['dis'])){
    session_start();
    session_destroy();
    header('location : ../CMM004-NewProject-master/user.php');
    exit();
}*/











































/*


if (isset($_POST['sub'])){

    $tit= mysqli_real_escape_string($db,$_POST['tit']);
   // if (empty($tit)){
  //      array_push($error ,'please give your problem a title' );
   // }
    $prof= mysqli_real_escape_string($db,$_POST['pro']);
   // if (empty($pro)){
   //     array_push($error ,'please choose a Profession' );
 //   }
    $disc= mysqli_real_escape_string($db,$_POST['disc']);
  //  if (empty($pro)){
   //     array_push($error ,'please describe you problem' );
  //  }
   // $photo= $_POST['photo'];
    $get= "INSERT INTO jobs(title, profession, desccribe, photo, isOpe) VALUES ('$tit','$pro','$disc',null,'1') ";
echo $get;
    $sql= mysqli_query($db,$get);
echo $sql;

}*/










/*
$user =$_SESSION['username'];
$result=" SELECT title from jobs WHERE title='$tit'  AND isOpe = true";
$qu= mysqli_query($db,$result);


if (mysqli_num_rows($qu) !=0){
    while ($row= mysqli_fetch_assoc($qu)){
        $_SESSION["at"]=$row;

    }
}*/
/*
foreach ($data as $d){
  echo $_SESSION["data"] = $d;
}
 //  foreach ($just as $data){
 //      echo $data['title'];
 //  }

    // $JUST= ($_POST['job']. $qu);
//   array_push($myData,$just);

*/




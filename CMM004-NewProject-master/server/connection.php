<?php

$dbhost="CSDM-WEBDEV";
$dbusername="1809441";
$dbpassword="1809441";
$dbname="db1809441_tradesman";

$db = mysqli_connect('CSDM-WEBDEV',$dbusername,$dbpassword,$dbname);
if($db-> connect_error) {
    die('Error'.('.$db->connect_errno.'));
}


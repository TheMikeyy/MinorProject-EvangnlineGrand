<?php

 $hname = "localhost";
 $uname = "root";
 $pass = "";
 $dbname = "evangelinewebsite";

 $con = mysqli_connect($hname, $uname, $pass, $dbname);

 if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
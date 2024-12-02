<?php

session_start();

require "../connection.php";

$email = $_POST["e"];
$password = $_POST["p"];   

if (empty($email)) {
    echo "Please enter your Email Address.";
} else if (strlen($email) > 50) {
    echo "Email Address should contain less than 50 characters.";
} else if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    echo "Invalid Email Address.";
} else if (empty($password)) {
    echo "Please enter your Password.";
}

 else {

    $resultset = Database::search("SELECT * FROM `admin` WHERE `email`='".$email."' AND `password`='".$password."'");
    $n = $resultset->num_rows;

    if ($n == 1) {

        $d = $resultset->fetch_assoc();
        $_SESSION["admin"] =  $d;

        echo "Success";

    } else {
        echo "Invalid Email or Password";
    }
}

<?php

session_start();

require "../connection.php";

$email = $_POST["email"];
$password = $_POST["password"];

if (empty($email)) {
    echo "Please enter your Email Address.";
} else if (strlen($email) > 50) {
    echo "Email Address should contain less than 50 characters.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid Email Address.";
} else if (empty($password)) {
    echo "Please enter your Password.";
} else {
    $student_rs = Database::search("SELECT * FROM `student` WHERE `email`=?", [$email], "s");
    $student_num = $student_rs->num_rows;

    if ($student_num == 1) {

        $student_data = $student_rs->fetch_assoc();

        $hashedPasswordFromDb = $student_data["password"];

        if (password_verify($password, $hashedPasswordFromDb)) {
            if ($student_data['status'] == 2) {
                echo "Admin block you! Contact andmin and activate your account";
            } else {
                $_SESSION["student"] =  $student_data;
                echo "Success";
            }
        } else {
            echo "Invalid Email or Password";
        }
       
    } else {
        echo "Invalid Email or Password";
    }
}

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
    $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `email`=?", [$email], "s");
    $teacher_num = $teacher_rs->num_rows;

    if ($teacher_num == 1) {

        $teacher_data = $teacher_rs->fetch_assoc();

        $hashedPasswordFromDb = $teacher_data["password"];

        if (password_verify($password, $hashedPasswordFromDb)) {
            if ($teacher_data['status'] == 0) {
                echo "Admin didn't approve yet. wait for aprove";
            }else if ($teacher_data['status'] == 2) {
                echo "Admin block you! Contact andmin and activate your account";
            } else {
                $_SESSION["teacher"] =  $teacher_data;
                echo "Success";
            }
        } else {
            echo "Invalid Email or Password";
        }

       
    } else {
        echo "Invalid Email or Password";
    }
}

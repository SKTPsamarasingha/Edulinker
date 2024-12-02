<?php

require "../connection.php";

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$mobile = $_POST["mobile"];
$password = $_POST["password"];
$qulification = $_POST["qulification"];

if (empty($fname)) {
    echo "Please enter first name";
} else if (empty($lname)) {
    echo "Please enter last name";
} else if (empty($email)) {
    echo "Please enter email address";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address.";
} else if (empty($mobile)) {
    echo "Please enter mobile";
} else if (empty($password)) {
    echo "Please enter password";
} else if (strlen($password) < 5 || strlen($password) > 20) {
    echo "Invalid Password. should be 5-20 charactors";
} else {
    $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `email`=?", [$email], "s");
    $teacher_num = $teacher_rs->num_rows;

    if ($teacher_num == 0) {

        if (isset($_FILES["image"])) {

            $image = $_FILES["image"];

            $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
            $file_ex = $image["type"];

            if (!in_array($file_ex, $allowed_image_extentions)) {
                echo "Please select a valid image.";
            } else {

                $new_image_extention;

                if ($file_ex == "image/jpg") {
                    $new_image_extention = ".jpg";
                } else if ($file_ex == "image/jpeg") {
                    $new_image_extention = ".jpeg";
                } else if ($file_ex == "image/png") {
                    $new_image_extention = ".png";
                } else if ($file_ex == "image/svg+xml") {
                    $new_image_extention = ".svg";
                }

                $file_name = "resources//" . uniqid() . $new_image_extention;

                move_uploaded_file($image["tmp_name"], $file_name);


                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                Database::iud("INSERT INTO `teacher` (`fname`,`lname`,`email`,`mobile`,`password`,`qulification`,`profile`) VALUES (?,?,?,?,?,?,?)", [$fname, $lname, $email, $mobile, $hashedPassword, $qulification, $file_name], "sssssss");

                echo "Success";
            }
        }
    } else {
        echo "Already registered this email";
    }
}

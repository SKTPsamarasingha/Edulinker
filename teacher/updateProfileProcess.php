<?php
session_start();

require "../connection.php";

if (isset($_SESSION['teacher'])) {

    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $mobile = $_POST["mobile"];
    $qulification = $_POST["qulification"];

    if (empty($fname)) {
        echo "Please enter first name";
    } else if (empty($lname)) {
        echo "Please enter last name";
    } else if (empty($mobile)) {
        echo "Please enter mobile";
    } else {

        $query = "UPDATE `teacher` SET `fname`=?, `lname`=?, `mobile`=?, `qulification`=? ";

        $sParams = array();
        $sParams[] = $fname;
        $sParams[] = $lname;
        $sParams[] = $mobile;
        $sParams[] = $qulification;
        $sParamTypes = "ssss";

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

                $query .= " , `profile`=? ";
                $sParams[] = $file_name;
                $sParamTypes .= "s";
            }
        }

        $query .= " WHERE `id`=? ";
        $sParams[] = $_SESSION['teacher']['id'];
        $sParamTypes .= "s";

        Database::iud($query, $sParams, $sParamTypes);
        echo "Success";
    }
} else {
    header("Location: login.php");
}

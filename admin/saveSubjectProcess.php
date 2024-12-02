<?php
session_start();

require "../connection.php";

if (isset($_SESSION['admin'])) {

    $subject = $_POST['subject'];

    if (empty($subject)) {
        echo 'please enter subject name';
    } else {
        $subject_rs = Database::search("SELECT * FROM `subject` WHERE `name`=?", [$subject], "s");
        $subject_num = $subject_rs->num_rows;
        if ($subject_num > 0) {
            echo 'Subject Already exists';
        } else {
            Database::iud("INSERT INTO `subject` (`name`) VALUES (?)", [$subject], "s");
            echo 'Success';
        }
    }
} else {
    header("Location: login.php");
}

<?php
session_start();

require "../connection.php";

if (isset($_SESSION['admin'])) {

    $grade = $_POST['grade'];

    if (empty($grade)) {
        echo 'please enter grade name';
    } else {
        $grade_rs = Database::search("SELECT * FROM `grade` WHERE `name`=?", [$grade], "s");
        $grade_num = $grade_rs->num_rows;
        if ($grade_num > 0) {
            echo 'grade Already exists';
        } else {
            Database::iud("INSERT INTO `grade` (`name`) VALUES (?)", [$grade], "s");
            echo 'Success';
        }
    }
} else {
    header("Location: login.php");
}

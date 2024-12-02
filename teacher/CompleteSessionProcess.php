<?php
session_start();

require "../connection.php";

if (isset($_SESSION['teacher'])) {

    $id = $_POST['id'];

    if (empty($id)) {
        echo 'Something wrong. try again!';
    }  else {
        Database::iud("UPDATE `session` SET `status`=? WHERE `id`=? ;", ["3",   $id], "ss");
        echo "Success";
    }
} else {
    header("Location: login.php");
}

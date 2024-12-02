<?php
session_start();

require "../connection.php";

if (isset($_SESSION['teacher'])) {

    $id = $_POST['id'];
    $sNote = $_POST['sNote'];

    if (empty($id)) {
        echo 'Something wrong. try again!';
    }  else {
        Database::iud("UPDATE `session` SET `status`=?, `note`=? WHERE `id`=? ;", ["2",  $sNote, $id], "sss");
        echo "Success";
    }
} else {
    header("Location: login.php");
}

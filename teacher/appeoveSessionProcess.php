<?php
session_start();

require "../connection.php";

if (isset($_SESSION['teacher'])) {

    $id = $_POST['id'];
    $sPath = $_POST['sPath'];
    $sNote = $_POST['sNote'];

    if (empty($id)) {
        echo 'Something wrong. try again!';
    } else if (empty($sPath)) {
        echo 'Please enter Location or Link';
    } else {
        Database::iud("UPDATE `session` SET `status`=?, `path`=?, `note`=? WHERE `id`=? ;", ["1", $sPath, $sNote, $id], "ssss");
        echo "Success";
    }
} else {
    header("Location: login.php");
}

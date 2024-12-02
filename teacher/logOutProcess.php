<?php
session_start();

if (isset($_SESSION["teacher"])) {
    $_SESSION["teacher"] == null;
    session_destroy();
    echo "Success";
} else {
    header("Location: login.php");
}

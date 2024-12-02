<?php
session_start();

require "../connection.php";

if (isset($_SESSION['student'])) {

    $id = $_POST['id'];
    $cardNo = $_POST['cardNo'];
    $cardCvv = $_POST['cardCvv'];
    $cardExDate = $_POST['cardExDate'];

    if(empty($id)){
        echo 'Something missing! try again!';
    }else if(empty($cardNo)){
        echo 'Please enter card no';
    }else if(empty($cardCvv)){
        echo 'Please enter card CVV';
    }else if(empty($cardExDate)){
        echo 'Please enter card expire date';
    }else{
        Database::iud("INSERT INTO `session_payment` (`card_no`,`cvv`,`exp_date`,`session_id`) VALUE (?,?,?,?)",[$cardNo,$cardCvv,$cardExDate,$id],"ssss");
        echo "Success";
    }

} else {
    header("Location: login.php");
}
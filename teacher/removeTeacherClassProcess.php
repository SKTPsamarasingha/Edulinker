<?php
session_start();

require "../connection.php";

if(isset($_SESSION['teacher'])){

    $id=$_POST['id'];

    if(empty($id)){
        echo 'Something wrong. try again!';
    }else{

        Database::iud("DELETE FROM `teacher_has_grade_has_subject` WHERE `id`=?",[$id],"s");
        echo 'Success';

    }

}else{
    header("Location: login.php");
}
?>
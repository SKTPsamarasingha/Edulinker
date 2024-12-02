<?php
session_start();

require "../connection.php";

if (isset($_SESSION['admin'])) {

    $student_id = $_POST['id'];

    if (empty($student_id)) {
        echo 'Something missing! try Again!';
    } else {

        $student_rs = Database::search("SELECT * FROM `student` WHERE `id`=?", [$student_id], "s");
        $student_data = $student_rs->fetch_assoc();

         if($student_data['status']=='1'){
            Database::iud("UPDATE `student` SET `status`=? WHERE `id`=?", ['2',$student_id], "ss");
            echo "Success";
        }else if($student_data['status']=='2'){
            Database::iud("UPDATE `student` SET `status`=? WHERE `id`=?", ['1',$student_id], "ss");
            echo "Success";
        }
        
    }
} else {
    header("Location: login.php");
}

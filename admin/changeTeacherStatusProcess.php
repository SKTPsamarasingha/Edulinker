<?php
session_start();

require "../connection.php";

if (isset($_SESSION['admin'])) {

    $teacher_id = $_POST['id'];

    if (empty($teacher_id)) {
        echo 'Something missing! try Again!';
    } else {

        $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `id`=?", [$teacher_id], "s");
        $teacher_data = $teacher_rs->fetch_assoc();

        if($teacher_data['status']=='0'){
            Database::iud("UPDATE `teacher` SET `status`=? WHERE `id`=?", ['1',$teacher_id], "ss");
            echo "Success";
        }else if($teacher_data['status']=='1'){
            Database::iud("UPDATE `teacher` SET `status`=? WHERE `id`=?", ['2',$teacher_id], "ss");
            echo "Success";
        }else if($teacher_data['status']=='2'){
            Database::iud("UPDATE `teacher` SET `status`=? WHERE `id`=?", ['1',$teacher_id], "ss");
            echo "Success";
        }
        
    }
} else {
    header("Location: login.php");
}

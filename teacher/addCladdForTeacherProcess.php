<?php
session_start();

require "../connection.php";

if(isset($_SESSION['teacher'])){

    $grade=$_POST['grade'];
    $subject=$_POST['subject'];

    if(empty($grade)){
        echo 'Please select grade';
    }else if(empty($subject)){
        echo 'please select subject';
    }else{
        $teacher_id = $_SESSION['teacher']['id'];

        $teacherHasGradeHasSubject_rs = Database::search("SELECT * FROM `teacher_has_grade_has_subject` WHERE `grade_id`=? AND `subject_id`=? AND `teacher_id`=?",[$grade,$subject,$teacher_id],"sss");
        $teacherHasGradeHasSubject_num = $teacherHasGradeHasSubject_rs->num_rows;

        if($teacherHasGradeHasSubject_num>0){
            echo 'Already added class';
        }else{
            Database::iud("INSERT INTO `teacher_has_grade_has_subject` (`grade_id`,`subject_id`,`teacher_id`) VALUES (?,?,?)",[$grade,$subject,$teacher_id],"sss");
            echo "Success";
        }
    }

}else{
    header("Location: login.php");
}
?>
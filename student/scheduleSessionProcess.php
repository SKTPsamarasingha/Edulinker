<?php
session_start();

require "../connection.php";

if (isset($_SESSION['student'])) {

    $teacherId = $_POST['teacherId'];
    $classId = $_POST['classId'];
    $date = $_POST['date'];
    $startTime = $_POST['startTime'];
    $hours = $_POST['hours'];
    $sessionType = $_POST['sessionType'];

    if (empty($teacherId)) {
        echo 'Something missing! try again';
    } else if (empty($classId)) {
        echo "Please select a class";
    } else if (empty($date)) {
        echo "Please enter date";
    } else if (empty($startTime)) {
        echo "Please enter start time";
    } else if (empty($hours)) {
        echo "Please enter hours";
    } else if ($hours < 1) {
        echo "minimum hours is 1";
    } else if (empty($sessionType)) {
        echo "Please enter session type";
    } else {

        $startDateTime = new DateTime($startTime);
        $startDateTime->modify("+$hours hours");
        $endTime = $startDateTime->format('H:i');

        $sessions_rs = Database::search("SELECT * FROM `session` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id`=`teacher_has_grade_has_subject`.`id` WHERE `teacher_has_grade_has_subject`.`teacher_id`=? AND `session`.`session_date`=? AND (`session`.`start_time` BETWEEN ? AND ?)", [$teacherId, $date, $startTime, $endTime], "ssss");

        $sessions_num = $sessions_rs->num_rows;

        if ($sessions_num > 0) {
            echo "Time slot unavailable";
        } else {
            Database::search("INSERT INTO `session` (`student_id`,`teacher_grade_subject_id`,`session_date`,`start_time`,`hours`,`session_type_id`) VALUES (?,?,?,?,?,?)", [$_SESSION['student']['id'], $classId, $date, $startTime, $hours, $sessionType], "ssssss");

            echo "Success";
        }
    }
} else {
    header("Location: login.php");
}

<?php 
session_start();
require "../connection.php";

if (isset($_SESSION['student'])) {

    $studentId = $_SESSION['student']['id'];

    $sessionID = $_POST["sessionId"];
    $rating = $_POST["rating"];
    $feetbackTxt = $_POST["feetbackTxt"];

    if(empty($sessionID)){
        echo 'Something wrong! try again';
    }else if($rating=='0'){
        echo 'Please rate';
    }else{
        $review_rs=Database::search("SELECT * FROM `review` WHERE `session_id`=?",[$sessionID],"s");
        $review_num = $review_rs->num_rows;
        if($review_num>0){
            Database::iud("UPDATE `review` SET `rate`=? , `feedback`=? WHERE `session_id`=?",[$rating,$feetbackTxt,$sessionID],"sss");
            echo "Updated Feedback";
        }else{
            Database::iud("INSERT INTO `review`(`session_id`,`student_id`,`rate`,`feedback`) VALUES (?,?,?,?)",[$sessionID,$studentId,$rating,$feetbackTxt],"ssss");
            echo "Send Feedback";
        }
    }
    
} else {
    header("Location: login.php");
}
?>
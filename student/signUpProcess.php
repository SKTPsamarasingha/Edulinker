<?php 

require "../connection.php";

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];

if(empty($fname)){
    echo "Please enter first name";
}else if(empty($lname)){
    echo "Please enter last name";
}else if(empty($email)){
    echo "Please enter email address";
}else if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address.";
}else if(empty($password)){
    echo "Please enter password";
} else if (strlen($password) < 5 || strlen($password) > 20 ) {
    echo "Invalid Password. should be 5-20 charactors";
}else{
    $student_rs=Database::search("SELECT * FROM `student` WHERE `email`=?",[$email],"s");
    $student_num = $student_rs->num_rows;

    if($student_num==0){
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        Database::iud("INSERT INTO `student` (`fname`,`lname`,`email`,`password`) VALUES (?,?,?,?)",[$fname,$lname,$email,$hashedPassword],"ssss");

        echo "Success";
    }else{
        echo "Already registered this email";
    }
}
?>
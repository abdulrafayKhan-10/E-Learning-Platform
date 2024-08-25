<?php 
session_start();
include('./db_connection/connection.php');
$id = 0;
$user_type = "Anonymous";
if(isset($_POST['sendBtn'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $message = $_POST['message'];
// if(isset($_COOKIE['trainer_id'])){
//     $id = $_COOKIE['trainer_id'];
//     $user_type = "trainer";
//     $insert_query = "INSERT INTO `messages`(`sender_id`,`message`, `user_type`,`username`,`email`,`message_type`) VALUES ('$id','$message','$user_type','$username','$email','contact_form')";
//     $insert_query_result = mysqli_query($conn,$insert_query);
//     if($insert_query_result){
//         $_SESSION['msg'] = true;
//         header('location:./contact.php');
//     }
// }
// elseif(isset($_COOKIE['student_id'])){
//     $id = $_COOKIE['student_id'];
//     $user_type = "student";
//     $insert_query = "INSERT INTO `messages`(`sender_id`,`message`, `user_type`,`username`,`email`,`message_type`) VALUES ('$id','$message','$user_type','$username','$email','contact_form')";
//     $insert_query_result = mysqli_query($conn,$insert_query);
//     if($insert_query_result){
//         $_SESSION['msg'] = true;
//         header('location:./contact.php');
//     }
// }
// else{
    $insert_query = "INSERT INTO `messages`(`sender_id`,`message`, `user_type`,`username`,`email`,`message_type`) VALUES ('$id','$message','$user_type','$username','$email','contact_form')";
    $insert_query_result = mysqli_query($conn,$insert_query);
    if($insert_query_result){
        $_SESSION['msg'] = true;
        header('location:./contact.php');
    }
}   
// }


?>
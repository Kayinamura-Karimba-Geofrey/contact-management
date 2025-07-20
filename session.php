<?php
session_start();
 
if(!isset($_SESSION['user_id'])){
    header("location:login.php");
    exit();
}

function is_admin(){
    return isset($_SESSION['role']) && $_SESSION['role']==='admin';
}
function is_user(){
    return isset($_SESSION['role']) && $_SESSION['role']==='user';
}
?>
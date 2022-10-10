<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    require_once "DataProvider.php";
    $mysqli = DataProvider::getConnection();
    mysqli_set_charset($mysqli, "UTF8");
    

    if(isset($_POST["email"])){
        $email = $_POST["email"];
    }  

    if(isset($_POST["token"])){
        $token = $_POST["token"];
    }  

    if(isset($_POST["password"])){
        $password = md5($_POST["password"]);
    }  

    if(isset($_POST["confirm-password"])){
        $cpassword = md5($_POST["confirm-password"]);
    } 

    if($password === $cpassword){
        $sql = "update user_account set user_password = '$password', token = NULL where email = '$email'";
        DataProvider::execQuery($sql);
        echo true;
    }   
    else{
        echo false;
    }

?>
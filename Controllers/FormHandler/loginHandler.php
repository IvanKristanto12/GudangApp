<?php
session_start();
if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $result = self::$db->executeQuery("LoginAuth", ["'".$username."'","'".$password."'"]);
    if(count($result) == 0){
        $_SESSION["error"] = "Invalid Username or Password";
        header("Location: index");
    }else{
        setcookie("username",$result[0]["Nama"],time()+86400,"/");
        setcookie("userpermission",$result[0]["Permission"],time()+86400,"/");
        header("Location: stock");
    }
} else if(isset($_POST["logout"])){
    setcookie("username","",time()-3600);
    setcookie("userpermission","",time()-3600);
    header("Location: index");
}
<?php 
include_once("../Model/Auth/M_Authentication.php");

class Ctrl_Authentication{

    public function __construct(){

    }
    public function check(){
        session_start();
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            header("location: C_Nhanvien.php");
            exit;
        }
    }
    public function invoke(){
        $modelAuth = new Model_Authentication();
        if(isset($_GET['login'])){
            $this->check();
            $location = $modelAuth->login($_POST['username'],$_POST['password']);
            header("location:$location");
        }
        else if(isset($_GET['logout'])){
            session_start();
            $_SESSION = array(); 
            session_destroy();
            header('location: C_Authentication.php');
            exit;
        }
        else {
            $this->check();
            require_once("../View/Login.html");
        }
    }
};
$C_Auth = new Ctrl_Authentication();
$C_Auth->invoke();
?>
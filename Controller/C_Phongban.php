<?php
    session_start();
    
    include_once("../Model/Nhanvien/M_Nhanvien.php");
    include_once("../Model/Phongban/M_Phongban.php");
    class Ctrl_Phongban{

        public function check(){
            $check = (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true);
            if(!$check){
                header("location: C_Authentication.php");
                exit;
            }
        }

        public function ListPhongban(){
            $modelPhongban = new Model_Phongban();
            $phongbanList = $modelPhongban->getAllPhongban();
            return $phongbanList;
        }

        public function invoke(){
            $modelPhongban = new Model_Phongban();

            // update 
            if(isset($_GET['list_update'])){ 
                $this->check();
                $phongbanList = $this->ListPhongban();
                include_once("../View/PhongbanUpdate.html");
            }
            else if(isset($_GET['IDPB'])){ 
                $this->check();
                $phongban = $modelPhongban->getPhongban($_GET['IDPB']);
                include_once("../View/PhongbanFormUpdate.html");
            }
            else if(isset($_GET['update'])){ 
                $this->check();
                $modelPhongban->updatePhongban($_POST['oldIDPB'],$_POST['Tenpb'],$_POST['Mota']);
                header('location:C_Phongban.php?list_update=1');
            }

            // all 
            else {
                $phongbanList = $this->ListPhongban();
                include_once("../View/PhongbanList.html");
            }
        }
    };
    $C_Phongban = new Ctrl_Phongban();
    $C_Phongban->invoke();
?>

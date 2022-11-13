<?php
    session_start();

    include_once("../Model/Nhanvien/M_Nhanvien.php");
    class Ctrl_Nhanvien{

        public function check(){
            $check = (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true);
            if(!$check){
                header("location: C_Authentication.php");
                exit;
            }
        }

        public function ListNhanvien(){
            $modelNhanvien = new Model_Nhanvien();
            $nhanvienList = $modelNhanvien->getAllNhanvien();
            return $nhanvienList;
        }

        public function invoke(){
            $modelNhanvien = new Model_Nhanvien();

            // add 
            if(isset($_GET['form_insert'])){
                $this->check();
                include_once("../View/NhanvienAdd.html");
            }
            else if(isset($_GET['insert'])){ 
                $this->check();
                $modelNhanvien->addNhanvien($_POST['IDNV'], $_POST['Hoten'], $_POST['IDPB'], $_POST['Diachi']);
                header('location:C_Nhanvien.php?');
            }

            // Nhân viên phòng ban 
            else if(isset($_GET['IDPB'])){
                $nhanvienList = $modelNhanvien->getAllNhanvienPB($_GET['IDPB']);
                include_once("../View/NhanvienList.html");
            }

            // Search 
            else if(isset($_GET['list_search'])){
                if(empty($_POST['search'])) $_POST['search'] = '';
                $nhavien_phongban = $modelNhanvien->search($_POST['search']);
                include_once("../View/NhanvienSearch.html");
            }

            
            // delete 
            else if(isset($_GET['list_delete'])){
                $this->check();
                $nhanvienList = $this->ListNhanvien();
                include_once("../View/NhanvienDelete.html");
            }
            else if(isset($_GET['IDNV'])){
                $this->check();
                $modelNhanvien->delete($_GET['IDNV']);
                header('location:C_Nhanvien.php?list_delete=1');
            }

            // delete all 
            else if(isset($_GET['list_delete_all'])){
                $this->check();
                $nhanvienList = $this->ListNhanvien();
                include_once("../View/NhanvienDeleteALL.html");
            }
            else if(isset($_GET['delete_all'])){
                $this->check();
                $modelNhanvien->deleteAll($_POST['checkedId']);
                header('location:C_Nhanvien.php?list_delete_all=1');
            }
            else if(isset($_GET['help'])){
                require_once("../View/Help.html");
            }
            else {
                $nhanvienList = $this->ListNhanvien();
                include_once("../View/NhanvienList.html");
            }
        }
    };
    $C_Nhanvien = new Ctrl_Nhanvien();
    $C_Nhanvien->invoke();
?>
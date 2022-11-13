<?php

include_once("E_Phongban.php");
class Model_Phongban {

    public $link ;

    public function __construct(){
        $this->link = mysqli_connect("localhost","root","") or die ("Không thể kết nối đến CSDL MYSQL");
        mysqli_select_db($this->link,"dulieupb");
    }

    public function getAllPhongban(){
        $sql = "select * from phongban";
        $rs = mysqli_query($this->link, $sql);
        $phongbans = [];
        if ($rs->num_rows > 0) {
            while($row = $rs->fetch_assoc()) {
                $IDPB = $row['IDPB'];
                $Tenpb = $row['Tenpb'];
                $Mota = $row['Mota'];

                $phongban = new Entity_Phongban($IDPB,$Tenpb,$Mota); 
                array_push($phongbans,$phongban);
            }
        }
        return $phongbans;
    }

    public function getPhongban($id){
        $sql = "select * from phongban where IDPB = '$id'";
        $rs = mysqli_query($this->link, $sql);
        if ($rs->num_rows > 0) {
            $row = $rs->fetch_assoc();
            $IDPB = $row['IDPB'];
            $Tenpb = $row['Tenpb'];
            $Mota = $row['Mota'];
            $phongban = new Entity_Phongban($IDPB,$Tenpb,$Mota); 
        }
        return $phongban;
    }

    public function updatePhongban($oldIDPB,$Tenpb,$Mota){
        $sql = "UPDATE phongban SET Tenpb='$Tenpb',Mota='$Mota' WHERE IDPB='$oldIDPB'";
        $rs = mysqli_query($this->link, $sql);
    }
    
}

?>
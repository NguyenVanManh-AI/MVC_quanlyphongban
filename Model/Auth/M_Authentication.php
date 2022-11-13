<?php 
    class Model_Authentication{
        public function __construct(){

        }

        public function login($username,$password){
            // config 
            define('DB_SERVER', 'localhost'); 
            define('DB_USERNAME', 'root'); 
            define('DB_PASSWORD', ''); 
            define('DB_NAME', 'DULIEUPB'); 
            $mysql_db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
            if (!$mysql_db) {
                die("Error: Unable to connect " . $mysql_db->connect_error);
            }
            // config 

            $sql = 'SELECT username, password FROM admin WHERE username = ?';
            if ($stmt = $mysql_db->prepare($sql)) {
                $param_username = $username;
                $stmt->bind_param('s', $param_username);
                if ($stmt->execute()){
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) { 
                        $stmt->bind_result($username, $hashed_password); 
                        if ($stmt->fetch()) {
                            if (password_verify($password, $hashed_password)) {
                                session_start();
                                $_SESSION['loggedin'] = true; 
                                $_SESSION['username'] = $username; 
                                return 'C_Nhanvien.php';
                            } 
                            return 'C_Authentication.php';
                        }
                    } 
                    return 'C_Authentication.php';
                } 
                return 'C_Authentication.php';
                $stmt->close(); 
            }
            $mysql_db->close(); 
        }
    }


?>
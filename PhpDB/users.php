<?php
require_once 'db.php';

class User {
    public $id;
    public $username;
    public $password;
    public $role;

    public function __construct($username="", $password="", $role="user") {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }

    public static function login($username, $password, $conn) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
        $stmt->execute(['username'=>$username,'password'=>$password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }
}
?>

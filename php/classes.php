<?php

include_once("newdb.php");

class User{
    protected $user_id;
    protected $login_;
    protected $password_;
    protected $repeat_password;
    function __construct($login, $password, $repeat_password){
        $this->login_ = $login;
        $this->password_ = $password;
        $this->repeat_password = $repeat_password;
    }

    public function getLogin(){
        return $this->login_;
    }

    private function check(){
        $pattern = '/^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z]).{6,}$/';
        $loginPattern = '/^.{3,}$/';

        if ($this->password_ != $this->repeat_password) {
            return 'Passwords must match!';
        }
        
        $pattern = '/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{6,}$/';
        if (!preg_match($pattern, $this->password_)) {
            return "Password must be at least 6 characters long and contain at least one uppercase letter, one symbol, and one digit.";
        }
        
        $loginPattern = '/^.{3,}$/';
        if (!preg_match($loginPattern, $this->login_)) {
            return "Login must be at least 3 characters long.";
        }
        
        // Проверка на наличие схожего логина в бд

        $pdo = connect();
        $list = $pdo->prepare('SELECT * FROM users WHERE login_ = :login');
        $list->bindParam(':login', $this->login_);
        $list->execute();

        if ($list->rowCount() > 0) {
            return "This login already exists.";
        }

        return True;
    }

    function registerUser(){
        $checkResult = $this->check();

        if($checkResult === true){
            try{

                $hashedPassword = password_hash($this->password_, PASSWORD_DEFAULT);
                $pdo = connect();

                $ps = $pdo->prepare("INSERT INTO users (login_, password_) VALUES (:login, :password)");
                $ps->execute(['login' => $this->login_, 'password' => $hashedPassword]);

                return true;
            }
            catch(PDOException $e){
                $err = $e->getMessage();
                if(substr($err, 0, strrpos($err, ":")) == 'SQLSTATE[23000]: Integrity constraint violation'){
                    return 1062;
                } else {
                    return $e->getMessage();
                }
            }
        }
        else {
            return $checkResult;
        }
    }

    function loginUser(){
        try {
            $pdo = connect();
            $list = $pdo->prepare('SELECT * FROM users WHERE login_ = :login');
            $list->bindParam(':login', $this->login_);
            $list->execute();

            $user = $list->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return false;
            }

            $bd_password = $user['password_'];

            if (password_verify($this->password_, $bd_password)) {
                return true;
            } else {
                return false;
            }
        }
        catch(PDOException $e){
            $err = $e->getMessage();
            if(substr($err, 0, strrpos($err, ":")) == 'SQLSTATE[23000]: Integrity constraint violation'){
                return 1062;
            } else {
                return $e->getMessage();
            }
        }
    }

    function getLastUserId() {
        $pdo = connect();
        $list = $pdo->prepare('SELECT MAX(user_id) as max_user_id FROM users');
        $list->execute();
        $result = $list->fetch(PDO::FETCH_ASSOC);

        $this->user_id = $result['max_user_id'];
        $_SESSION['user_id'] = $this->user_id;

        return $this->user_id;

    }

}

?>
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

        if($this->password_ != $this->repeat_password){
            return 'Пароли должны совпадать';
        }

        if (!preg_match($pattern, $this->password_)) {
            return "Пароль Не соответствует требованиям.";
        }
        if(!preg_match($loginPattern, $this->login_)){
            return "Логин должен быть более 3 символов.";
        }

        // Проверка на наличие схожего логина в бд

        $pdo = connect();
        $list = $pdo->prepare('SELECT * FROM users WHERE login_ = :login');
        $list->bindParam(':login', $this->login_);
        $list->execute();

        if ($list->rowCount() > 0) {
            return "Данный логин уже занят.";
        }

        return True;
    }

    function registerUser(){
        $checkResult = $this->check();

        if($checkResult === true){
            try{
                $pdo = connect();

                $ps = $pdo->prepare("INSERT INTO users (login_, password_) VALUES (:login, :password)");
                $ps->execute(['login' => $this->login_, 'password' => $this->password_]);

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

            if ($bd_password == $this->password_) {
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

        return $this->user_id;

    }

}

?>
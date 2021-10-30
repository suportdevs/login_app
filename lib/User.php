<?php
include_once "Session.php";
include "Database.php";

class User{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }
    public function userRegistration($data){
        $name       = $data["name"];
        $username   = $data["username"];
        $email      = $data["email"];
        $password   = md5($data["password"]);

        $check_email = $this->check_email($email);

        if ($name == "" || $username == "" || $email == "" || $password == "") {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Field must be Empty.</div>";
            return $msg;
        }
        if (strlen($username) < 3) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Username is too Short.</div>";
            return $msg;
        } elseif(preg_match("/[^a-z0-9_-]+/i", $username)) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Username must only contain alphanumerical deshes underscores.</div>";
            return $msg;
        }
        if (strlen($password) < 0) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Password is too Short.</div>";
            return $msg;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> The email address is not Valid.</div>";
            return $msg;
        }
        if ($check_email == true) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> The email address is already Exists.</div>";
            return $msg;
        }
        
        $sql = "INSERT INTO tbl_user (name, username, email, password) VALUES(:name, :username, :email, :password)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":name", $name);
        $query->bindValue(":username", $username);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $result = $query->execute();
        if ($result) {
            $msg = "<div class='alert alert-success'><strong>Thank you</strong> You has been Registered.</div>";
            return $msg;
        } else {
            $msg = "<div class='alert alert-danger'><strong>Sorry !</strong> there has been problem inserting your Details.</div>";
            return $msg;
        }
    }
    public function check_email($email){
        $sql = "SELECT email FROM tbl_user WHERE email = :email";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":email", $email);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function getUserLogin($email, $password){
        $sql = "SELECT * FROM tbl_user WHERE email = :email AND password = :password";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function userLogin($data){
        $email      = $data["email"];
        $password   = md5($data["password"]);

        $check_email = $this->check_email($email);

        if ($email == "" || $password == "") {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Field must be Empty.</div>";
            return $msg;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> The email address is not Valid.</div>";
            return $msg;
        }
        if ($check_email == false) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> The email address is not Exists.</div>";
            return $msg;
        }

        $result = $this->getUserLogin($email, $password);
        if ($result) {
            Session::init();
            Session::set("login", true);
            Session::set("id", $result->id);
            Session::set("name", $result->name);
            Session::set("username", $result->username);
            Session::set("loginmsg", "<div class='alert alert-success'><strong>Success !</strong> Your are Loggined.</div>");
            header("Location: index.php");
        } else {
            $msg = "<div class='alert alert-danger'><strong>Sorry !</strong> User data not Found.</div>";
            return $msg;
        }
    }
    public function userData(){
        $sql = "SELECT * FROM tbl_user ORDER BY id DESC";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
    public function getUserbyId($id){
        $sql = "SELECT * FROM tbl_user WHERE id = :id LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function userUpdatedata($id, $data){
        $name       = $data["name"];
        $username   = $data["username"];
        $email      = $data["email"];

        if ($name == "" || $username == "" || $email == "") {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Field must be Empty.</div>";
            return $msg;
        }
        if (strlen($username) < 3) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Username is too Short.</div>";
            return $msg;
        } elseif(preg_match("/[^a-z0-9_-]+/i", $username)) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Username must only contain alphanumerical deshes underscores.</div>";
            return $msg;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> The email address is not Valid.</div>";
            return $msg;
        }
        
        $sql = "UPDATE tbl_user SET
                    name        = :name,
                    username    = :username,
                    email       = :email
                    WHERE id    = :id";

        $query = $this->db->pdo->prepare($sql);

        $query->bindValue(":name", $name);
        $query->bindValue(":username", $username);
        $query->bindValue(":email", $email);
        $query->bindValue(":id", $id);
        $result = $query->execute();
        if ($result) {
            $msg = "<div class='alert alert-success'><strong>Thank you</strong> You has been Updated.</div>";
            return $msg;
        } else {
            $msg = "<div class='alert alert-danger'><strong>Sorry !</strong> Your data not Updated.</div>";
            return $msg;
        }
    }
    private function check_password($id, $old_password){
        $password = md5($old_password);
        $sql = "SELECT * FROM tbl_user WHERE id = :id AND password = :password";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->bindValue(":password", $password);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function changePassword($id, $data){
        $old_password = $data['old_password'];
        $new_password = $data['new_password'];
        $check_password = $this->check_password($id, $old_password);

        if ($old_password == "" || $new_password == "") {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Field must be Empty.</div>";
            return $msg;
        }
        if ($check_password == false) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Old Password not Exists.</div>";
            return $msg;
        }
        if (strlen($new_password) < 4) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Password too Short.</div>";
            return $msg;
        }
        $password = md5($new_password);
        $sql = "UPDATE tbl_user SET
                    password = :password
                    WHERE id     = :id";

        $query = $this->db->pdo->prepare($sql);

        $query->bindValue(":password", $password);
        $query->bindValue(":id", $id);
        $result = $query->execute();
        if ($result) {
            $msg = "<div class='alert alert-success'><strong>Thank you</strong> New Password Updated.</div>";
            return $msg;
        } else {
            $msg = "<div class='alert alert-danger'><strong>Sorry !</strong> Password not Updated.</div>";
            return $msg;
        }
    }
}
?>
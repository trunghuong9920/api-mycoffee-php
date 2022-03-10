<?php
require 'restful_api.php';
// require(__DIR__. "restful_api.php");

class api extends restful_api {
    function __construct(){
        parent::__construct();
    }

   
    function login(){
        if ($this->method == 'POST'){
            $account = isset($_POST["account"]) ? $_POST["account"] : '';
            $password = isset($_POST["password"]) ? $_POST["password"] : '';

            $query = "SELECT id,status FROM `users` WHERE `account` = '$account' AND `password` = '$password'";
            $data_select = $this->select_list($query);
           
            $this->response(200, $data_select);
        }
    }
    function info(){
        if ($this->method == 'GET'){
            $id = isset($_GET["id"]) ? $_GET["id"] : '';

            $query = "SELECT id,account,name,phone,avata, permission FROM `users` WHERE `id` = '$id'";
            $data_select = $this->select_list($query);
            
            $this->response(200, $data_select);
        }
    }

    function search(){
        if ($this->method == 'GET'){
            $type = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            switch($type[1]){
                case "user":
                    $qsearch = isset($_GET["qsearch"]) ? $_GET["qsearch"] : '';
                    $query = "SELECT * FROM `users` WHERE `id` LIKE '%$qsearch%' OR `account` LIKE '%$qsearch%' OR `name` LIKE '%$qsearch%'";
                    $data_select = $this->select_list($query);
                    $this->response(200, $data_select);
                    break;
                case "tables":
                    $qsearch = isset($_GET["qsearch"]) ? $_GET["qsearch"] : '';
                    $query = "SELECT * FROM `tables` WHERE `id` LIKE '%$qsearch%' OR `name` LIKE '%$qsearch%'";
                    $data_select = $this->select_list($query);
                    $this->response(200, $data_select);
                    break;
                case "categorys":
                    $qsearch = isset($_GET["qsearch"]) ? $_GET["qsearch"] : '';
                    $query = "SELECT * FROM `categorys` WHERE `id` LIKE '%$qsearch%' OR `name` LIKE '%$qsearch%'";
                    $data_select = $this->select_list($query);
                    
                    $this->response(200, $data_select);
                    break;
                case "products":
                    $qsearch = isset($_GET["qsearch"]) ? $_GET["qsearch"] : '';
                    $query = "SELECT products.id,`img`,products.name,categorys.name as category,`price` FROM `products`,`categorys` WHERE products.idc = categorys.id AND (products.id LIKE '%$qsearch%' OR products.name LIKE '%$qsearch%')";
                    $data_select = $this->select_list($query);
                    $this->response(200, $data_select);
                    break;
                default:
                    $this->response(200, []);
            }
            
        }
        
    }

    function users(){
        if ($this->method == 'GET'){
            $type = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            switch($type[1]){
                case "getalldata":
                    $query = "SELECT id,account,name,phone,avata, permission, status FROM `users` ";
                    $data_select = $this->select_list($query);
                    $this->response(200, $data_select);
                    break;
                case "edituser":
                    $id = isset($_GET["id"]) ? $_GET["id"] : '';
                    $query = "SELECT `account`,`name`,`phone`,`avata`,`permission` FROM `users` WHERE `id` = '$id'";
                    $data_select = $this->select_list($query);
                    $this->response(200, $data_select);
                    break;
                case "getaccount":
                    $query = "SELECT `account` FROM `users`";
                    $data_select = $this->select_list($query);
                    $this->response(200, $data_select);
                    break;
                default:
                    $this->response(200, []);
            }
        }
        elseif($this->method == 'POST'){
            $type = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            switch($type[1]){
                case "adduser":
                    $account = isset($_POST["account"]) ? $_POST["account"] : '';
                    $name = isset($_POST["name"]) ? $_POST["name"] : '';
                    $phone = isset($_POST["phone"]) ? $_POST["phone"] : '';
                    $avata = isset($_POST["avata"]) ? $_POST["avata"] : '';
                    $permission = isset($_POST["permission"]) ? $_POST["permission"] : '';
                    $password = isset($_POST["password"]) ? $_POST["password"] : '';
        
                    $query = "INSERT INTO `users`(`id`, `account`, `name`, `phone`, `avata`, `permission`, `password`, `status`) 
                    VALUES ('','$account','$name','$phone','$avata','$permission','$password','')";
                    $data_select = $this->exec_update($query);
                    
                    $this->response(200, $data_select);
                    break;
                case "updateuser":
                    $id = isset($_POST["id"]) ? $_POST["id"] : '';
                    $account = isset($_POST["account"]) ? $_POST["account"] : '';
                    $name = isset($_POST["name"]) ? $_POST["name"] : '';
                    $phone = isset($_POST["phone"]) ? $_POST["phone"] : '';
                    $avata = isset($_POST["avata"]) ? $_POST["avata"] : '';
                    $permission = isset($_POST["permission"]) ? $_POST["permission"] : '';

                    $query = "UPDATE `users` SET `account`='$account',`name`='$name',
                    `phone`='$phone',`avata`='$avata',`permission`='$permission' WHERE `id` = '$id'";
                    $data_select = $this->exec_update($query);
                    
                    $this->response(200, $data_select);
                    break;
                case "deleteuser":
                    $id = isset($_POST["id"]) ? $_POST["id"] : '';

                    $query = "DELETE FROM `users` WHERE `id` = '$id'";
                    $data_select = $this->exec_update($query);
                    
                    $this->response(200, $data_select);
                default:
                    $this->response(200, []);
            }
           
        }
    }
    function tables(){
        if ($this->method == 'GET'){
            $type = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            switch($type[1]){
                case "getall":
                    $query = "SELECT * FROM `tables` ORDER BY status DESC ";
                    $data_select = $this->select_list($query);
                    $this->response(200, $data_select);
                    break;
                case "getone":
                    $id = isset($_GET["id"]) ? $_GET["id"] : '';
                    $query = "SELECT * FROM `tables` WHERE `id` = '$id'";
                    $data_select = $this->select_list($query);
                    $this->response(200, $data_select);
                    break;
            }
        }
        elseif($this->method == 'POST'){
            $type = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            switch($type[1]){
                case "add":
                    $name = isset($_POST["name"]) ? $_POST["name"] : '';
                    $area = isset($_POST["area"]) ? $_POST["area"] : '';

                    $query = "INSERT INTO `tables`(`id`, `name`, `status`, `area`) VALUES ('','$name','','$area')";
                    $data_select = $this->exec_update($query);
                    
                    $this->response(200, $data_select);
                    break;
                case "update":
                    $id = isset($_POST["id"]) ? $_POST["id"] : '';
                    $name = isset($_POST["name"]) ? $_POST["name"] : '';
                    $area = isset($_POST["area"]) ? $_POST["area"] : '';

                    $query = "UPDATE `tables` SET `name`='$name' ,`area`='$area' WHERE `id` = '$id'";
                    $data_select = $this->exec_update($query);
                    
                    $this->response(200, $data_select);
                    break;
                case "delete":
                    $id = isset($_POST["id"]) ? $_POST["id"] : '';
                    
                    $query = "DELETE FROM `tables` WHERE `id` = '$id' AND `status` = '0'";
                    $data_select = $this->exec_update($query);
                    
                    $this->response(200, $data_select);
                    break;
                default:
                $this->response(200, []);

            }
        }
    }
    
    function categorys(){
        if ($this->method == 'GET'){
            $type = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            switch ($type[1]){
                case "getall":
                    $query = "SELECT * FROM `categorys` ";
                    $data_select = $this->select_list($query);
                    $this->response(200, $data_select);
                    break;
                case "getone":
                    $id = isset($_GET["id"]) ? $_GET["id"] : '';

                    $query = "SELECT * FROM `categorys` WHERE `id` = '$id'";
                    $data_select = $this->select_list($query);
                    $this->response(200, $data_select);
                    break;
                default:
                    $this->response(200, []);
            }
        }
        elseif($this->method == 'POST'){
            $type = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            switch ($type[1]){
                case "add":
                    $name = isset($_POST["name"]) ? $_POST["name"] : '';
                    $query = "INSERT INTO `categorys`(`id`, `name`) VALUES ('','$name')";
                    $data_select = $this->exec_update($query);
                    $this->response(200, $data_select);
                    break;
                case "update":
                    $id = isset($_POST["id"]) ? $_POST["id"] : '';
                    $name = isset($_POST["name"]) ? $_POST["name"] : '';
                    
                    $query = "UPDATE `categorys` SET `name`='$name' WHERE `id` = '$id'";
                    $data_select = $this->exec_update($query);
                    $this->response(200, $data_select);
                    break;
                default:
                    $this->response(200, []);
            }
        }
    }
    function products(){
        if ($this->method == 'GET'){
            $query = "SELECT products.id,`img`,products.name,categorys.name as category,`price` FROM `products`,`categorys` WHERE products.idc = categorys.id";
            $data_select = $this->select_list($query);
            $this->response(200, $data_select);
        }
        elseif($this->method == 'POST'){
            $idc = isset($_POST["idc"]) ? $_POST["idc"] : '';
            $name = isset($_POST["name"]) ? $_POST["name"] : '';
            $img = isset($_POST["img"]) ? $_POST["img"] : '';
            $price = isset($_POST["price"]) ? $_POST["price"] : '';

            $query = "INSERT INTO `products`(`id`, `idc`, `name`, `img`, `price`) 
            VALUES ('','$idc','$name','$img','$price')";
            $data_select = $this->exec_update($query);
            
            $this->response(200, $data_select);
        }
    }
}
$user_api = new api();
?>
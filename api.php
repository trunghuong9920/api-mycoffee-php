<?php
require 'restful_api.php';
// require(__DIR__. "restful_api.php");

class api extends restful_api {
    function __construct(){
        parent::__construct();
    }

    function tables(){
        if ($this->method == 'GET'){
            $query = "SELECT * FROM `tables` ORDER BY status DESC ";
            $data_select = $this->select_list($query);
            $this->response(200, $data_select);
        }
        elseif($this->method == 'POST'){
            $name = isset($_POST["name"]) ? $_POST["name"] : '';
            $area = isset($_POST["area"]) ? $_POST["area"] : '';

            $query = "INSERT INTO `tables`(`id`, `name`, `status`, `area`) VALUES ('','$name','','$area')";
            $data_select = $this->exec_update($query);
            
            $this->response(200, $data_select);
        }
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
        if ($this->method == 'POST'){
            $id = isset($_POST["id"]) ? $_POST["id"] : '';

            $query = "SELECT id,account,name,phone,avata, permission FROM `users` WHERE `id` = '$id'";
            $data_select = $this->select_list($query);
            
            $this->response(200, $data_select);
        }
    }
    function users(){
        if ($this->method == 'GET'){
            $query = "SELECT id,account,name,phone,avata, permission, status FROM `users` ";
            $data_select = $this->select_list($query);
            $this->response(200, $data_select);
        }
        elseif($this->method == 'POST'){
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
        }
    }
    function getaccount(){
        if ($this->method == 'POST'){
            $account = isset($_POST["account"]) ? $_POST["account"] : '';

            $query = "SELECT `id` FROM `users` WHERE `account` = '$account'";
            $data_select = $this->select_list($query);
            $this->response(200, $data_select);
        }
    }
    function searchusers(){
        if ($this->method == 'POST'){
            $qsearch = isset($_POST["qsearch"]) ? $_POST["qsearch"] : '';

            $query = "SELECT * FROM `users` WHERE `id` LIKE '%$qsearch%' OR `account` LIKE '%$qsearch%' OR `name` LIKE '%$qsearch%'";
            $data_select = $this->select_list($query);
            
            $this->response(200, $data_select);
        }
    }
    function searchtables(){
        if ($this->method == 'POST'){
            $qsearch = isset($_POST["qsearch"]) ? $_POST["qsearch"] : '';

            $query = "SELECT * FROM `tables` WHERE `id` LIKE '%$qsearch%' OR `name` LIKE '%$qsearch%'";
            $data_select = $this->select_list($query);
            
            $this->response(200, $data_select);
        }
    }
    function searchcate(){
        if ($this->method == 'POST'){
            $qsearch = isset($_POST["qsearch"]) ? $_POST["qsearch"] : '';

            $query = "SELECT * FROM `categorys` WHERE `id` LIKE '%$qsearch%' OR `name` LIKE '%$qsearch%'";
            $data_select = $this->select_list($query);
            
            $this->response(200, $data_select);
        }
    }
    function searchproducts(){
        if ($this->method == 'POST'){
            $qsearch = isset($_POST["qsearch"]) ? $_POST["qsearch"] : '';

            $query = "SELECT products.id,`img`,products.name,categorys.name as category,`price` FROM `products`,`categorys` WHERE products.idc = categorys.id AND (products.id LIKE '%$qsearch%' OR products.name LIKE '%$qsearch%')";
            $data_select = $this->select_list($query);
            
            $this->response(200, $data_select);
        }
    }
    function categorys(){
        if ($this->method == 'GET'){
            $query = "SELECT * FROM `categorys` ";
            $data_select = $this->select_list($query);
            $this->response(200, $data_select);
        }
        elseif($this->method == 'POST'){
            $name = isset($_POST["name"]) ? $_POST["name"] : '';

            $query = "INSERT INTO `categorys`(`id`, `name`) VALUES ('','$name')";
            $data_select = $this->exec_update($query);
            
            $this->response(200, $data_select);
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
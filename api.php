<?php
require 'restful_api.php';
// require(__DIR__. "restful_api.php");

class api extends restful_api {
    function __construct(){
        parent::__construct();
    }

    function tables(){
        if ($this->method == 'GET'){
            $query = "SELECT * FROM `tables` ";
            $data_select = $this->select_list($query);
            $this->response(200, $data_select);
        }
    }
    function login(){
        if ($this->method == 'POST'){
            $data = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            $this->endpoint = array_shift($data);

            $query = "SELECT id,status FROM `users` WHERE `account` = '$data[0]' AND `password` = '$data[1]'";
            $data_select = $this->select_list($query);
            
            $this->response(200, $data_select);
        }
    }
    function info(){
        if ($this->method == 'POST'){
            $data = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            $this->endpoint = array_shift($data);

            $query = "SELECT id,account,name,phone,avata, permission FROM `users` WHERE `id` = '$data[0]'";
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
            $data = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            $this->endpoint = array_shift($data);

            if($data[3] != 'a'){
                $query = "INSERT INTO `users`(`id`, `account`, `name`, `phone`, `avata`, `permission`, `password`, `status`) 
                VALUES ('','$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','')";
                $data_select = $this->exec_update($query);
            }
            else{
                $query = "INSERT INTO `users`(`id`, `account`, `name`, `phone`, `avata`, `permission`, `password`, `status`) 
                VALUES ('','$data[0]','$data[1]','$data[2]','','$data[4]','$data[5]','')";
                $data_select = $this->exec_update($query);
            }
            
            $this->response(200, $data);
        }
    }
    function searchallaccount(){
        if ($this->method == 'POST'){
            // $data = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            // $this->endpoint = array_shift($data);
            // $data = $_POST['name'];
            // print_r($data);
            // $this->response(200, $data);
        }
    }
    function searchusers(){
        if ($this->method == 'POST'){
            $data = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            $this->endpoint = array_shift($data);

            $query = "SELECT * FROM `users` WHERE `id` LIKE '%$data[0]%' OR `account` LIKE '%$data[0]%' OR `name` LIKE '%$data[0]%' OR `phone` LIKE '%$data[0]%'";
            $data_select = $this->select_list($query);
            
            $this->response(200, $data_select);
        }
    }
    function searchtables(){
        if ($this->method == 'POST'){
            $data = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            $this->endpoint = array_shift($data);

            $query = "SELECT * FROM `tables` WHERE `id` LIKE '%$data[0]%' OR `name` LIKE '%$data[0]%'";
            $data_select = $this->select_list($query);
            
            $this->response(200, $data_select);
        }
    }
    function searchcate(){
        if ($this->method == 'POST'){
            $data = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            $this->endpoint = array_shift($data);

            $query = "SELECT * FROM `categorys` WHERE `id` LIKE '%$data[0]%' OR `name` LIKE '%$data[0]%'";
            $data_select = $this->select_list($query);
            
            $this->response(200, $data_select);
        }
    }
    function searchproducts(){
        if ($this->method == 'POST'){
            $data = explode('/', trim($_SERVER['PATH_INFO'],'/'));
            $this->endpoint = array_shift($data);

            $query = "SELECT products.id,`img`,products.name,categorys.name as category,`price` FROM `products`,`categorys` WHERE products.idc = categorys.id AND (products.id LIKE '%$data[0]%' OR products.name LIKE '%$data[0]%')";
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
    }
    function products(){
        if ($this->method == 'GET'){
            $query = "SELECT products.id,`img`,products.name,categorys.name as category,`price` FROM `products`,`categorys` WHERE products.idc = categorys.id";
            $data_select = $this->select_list($query);
            $this->response(200, $data_select);
        }
    }
}
$user_api = new api();
?>
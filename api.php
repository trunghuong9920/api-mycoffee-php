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
}
$user_api = new api();
?>
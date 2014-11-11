<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    //提供给客户，优化后的界面，并非高级配置

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

    function order_category_manage(){
        if($_POST){

        }else{
            render();
        }
    }

}
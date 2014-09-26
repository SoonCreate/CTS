<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('role_model','role');
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}

    function create(){
        if($_POST){

        }else{
            render();
        }
    }

    function update(){
        if($_POST){

        }else{
            render();
        }
    }

    //多个权限对象配置
    function profiles(){

    }

    //能访问的url
    function urls(){

    }

}
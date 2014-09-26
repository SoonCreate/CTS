<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Functions extends CI_Controller {

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
            $data['controller'] = tpost('controller');
            $data['action'] = tpost('action');
            //验证url是否可访问
            if(url_exists(site_url($data['controller'].'/'.$data['action']))){

            }
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

    //当新建一个功能时，把他发布到相关联的角色中
    function push_to_role(){

    }



}
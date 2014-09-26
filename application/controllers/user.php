<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('auth_model');
        $this->load->model('user_model');
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}

    function login(){
        if($_POST){
            $username = tpost('username');
            $password = sha1(v('password'));
            $user = $this->user->find_by(array('username'=>$username,'password'=>$password,'inactive_flag'=>0));
            if(empty($user)){
                //登录失败
                render();
            }else{
                set_sess('uid',$user['id']);
                redirect(base_url('welcome/index'));
            }
        }else{
            render();
        }
    }

    function logout(){
        clear_all_sess();
        redirect(base_url('user','login'));
    }

    function create(){
        if($_POST){
            $_POST['username'] = tpost('username');
            $_POST['password'] = sha1(v('password'));
            if($this->user->insert($_POST)){

            }else{

            }
        }else{
            render();
        }
    }

    function change_password(){
        if($_POST){
            $id = _sess('uid');
            $data['password'] = sha1(v('password'));
            if($this->user->update($id,$data)){

            }else{

            }
        }else{
            render();
        }
    }

    function update(){
        if($_POST){
            $id = tpost('user_id');
            if($this->user->update($id,$_POST)){

            }else{

            }
        }else{
            render();
        }
    }

    //选择角色
    function choose_roles(){

    }

    function forget_password(){

    }

    //前端控件权限验证
    function check_auth(){
        echo check_auth($this->input->get('type'),$this->input->get('status'),$this->input->get('category'));
    }

}
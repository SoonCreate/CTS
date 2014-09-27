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

    function register(){
        if($_POST){
            $username = tpost('username');
            $password = sha1(v('password'));
            $order_type = v('order_type');
            $user = new User_model();
            if($user->register_save($username,$password,$order_type)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
            render();
        }
    }


    function create(){
        if($_POST){
            $data['username'] = tpost('username');
            $data['password'] = sha1(v('password'));
            $data['contact'] = tpost('contact');
            $data['email'] = tpost('email');
            $data['phone_number'] = tpost('phone_number');
            $data['mobile_telephone'] = tpost('mobile_telephone');
            $data['address'] = tpost('address');
            $data['full_name'] = tpost('full_name');
            $user = new User_model();
            if($user->insert($data)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
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
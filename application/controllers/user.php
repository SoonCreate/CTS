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
            if(is_all_set($_POST,array('old_password','new_password','re_password'))
                && is_all_has_value($_POST,array('old_password','new_password','re_password'))){
                if($_POST['re_password'] != $_POST['new_password']){
                    custz_message('E',_text('message_wrong_re_password'));
                }else{
                    if( $this->kv->find_value_by_key('admin') == n($_POST['old_password'])){
                        if($this->kv->update('admin',n($_POST['new_password']))){
                            custz_message('I',_text('message_update_success'));
                        }else{
                            custz_message('E',_text('message_update_failure'));
                        }

                    }else{
                        custz_message('E',_text('message_wrong_old_password'));
                    }
                }
            }else{
                custz_message('E',_text('message_data_useless'));
            }
        }else{
            $this->load->view('_change_password');
        }
    }

    function update(){

    }

    function forget_password(){

    }

    //前端控件权限严重
    function check_auth(){
        $auth_data = json_decode($this->input->get('auth_data')) ;
        echo $this->auth_model->check_auth($auth_data['auth_object'],$auth_data['auth_items']);
    }

}
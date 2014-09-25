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
            if(is_all_set($_POST,array('username','password'))
                && is_all_has_value($_POST,array('username','password'))){
                if( n($_POST['username']) == "admin" && $this->kv->find_value_by_key(n($_POST['username'])) == n($_POST['password'])){
                    custz_message('I',_text('message_login_success'));
                    set_sess('login','X');
                }else{
                    custz_message('E',_text('message_login_failure'));
                }
            }else{
                custz_message('E',_text('message_data_useless'));
            }
        }else{
            $this->load->view('_login');
        }
    }

    function logout(){
        clear_all_sess();
        redirect(base_url('user','login'));
    }

    function create(){
        if($_POST){
            if(is_all_has_value($_POST,array('username','password','email','mobile_telephone'))){
                $data['password'] = sha1(v('password'));
                $data['username'] = _trim(v('username'));
                $data['email'] = _trim(v('email'));
                $data['phone_number'] = _trim(v('phone_number'));
                $data['mobile_telephone'] = _trim(v('mobile_telephone'));
                $data['address'] = _trim(v('address'));
                if($this->user_model->insert($data)){
                    custz_message('E','保存成功！');
                }else{
                    custz_message('E','保存成功！');
                }
            }else{
                custz_message('E',_text('message_data_useless'));
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
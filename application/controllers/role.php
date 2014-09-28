<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('role_model','role');
        $this->load->model('user_role_model','user_role');
        $this->load->model('user_model','user');
        $this->load->model('role_module_line_model');
        $this->load->model('module_line_model');
    }

	public function index()
	{
        $o = new Role_model();
        $data['roles'] = _format($o->find_all());
        $this->load->view('role/index',$data);
	}

    function create(){
        if($_POST){
            $role = new Role_model();
            $data['role_name'] = tpost('role_name');
            $data['description'] = tpost('description');
            if($role->insert($data)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
            render();
        }
    }

    function edit(){
        $role = new Role_model();
        if($_POST){
            $data['id'] = v('id');
            $data['description'] = tpost('description');
            if($role->update($data['id'],$data,true)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
            render($role->find(p('id')));
        }
    }

    //多个权限对象配置
    function profiles(){

    }

    //能访问的url
    function modules(){

    }

    //分配到用户
    function allocate_users(){
        $ur = new User_role_model();
        if($_POST){
            $ids = v('users');
            $data['role_id'] = v('role_id');

            if($ids === FALSE){
                //删除所有
                $ur->delete_by(array('role_id' => $data['role_id']));
            }else{
                //先删除已取消勾选的
                $this->db->where_not_in('user_id',$ids);
                $ur->delete_by(array('role_id' => $data['role_id']));
                //新增的部分
                $ids = array_diff($ids,$ur->find_user_ids($data['role_id']));
                foreach($ids as $id){
                    $data['user_id'] = $id;
                    $ur->insert($data);
                }
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                echo '数据库插入错误';
            }else{
                echo 'done';
            }
        }else{
            $role_id = p('role_id');
            $u = new User_model();
            $users = $u->find_all();
            for($i=0;$i<count($users) ;$i++){
                $user_role = $ur->find_by(array('user_id'=>$users[$i]['id'],'role_id'=>$role_id));
                if(!empty($user_role)){
                    $users[$i]['checked'] = 'checked';
                }else{
                    $users[$i]['checked'] = '';
                }
            }
            $data['users'] = _format($users);
            $data['role_id'] = $role_id;
            $this->load->view('role/allocate_users',$data);
        }
    }

    function choose_functions(){
        $rml = new Role_module_line_model();
        if($_POST){
            $ids = v('functions');
            $data['module_id'] = v('module_id');
            $data['sort'] = v('sort');
            if($ids === FALSE){
                //删除所有
                $rml->delete_by(array('module_id' => $data['module_id']));
            }else{
                //先删除已取消勾选的
                $this->db->where_not_in('function_id',$ids);
                $rml->delete_by(array('module_id' => $data['module_id']));
                //新增的部分
                $ids = array_diff($ids,$rml->find_function_ids($data['module_id']));
                foreach($ids as $id){
                    $data['function_id'] = $id;
                    $rml->insert($data);
                }
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                echo '数据库插入错误';
            }else{
                echo 'done';
            }
        }else{
            $role_id = p('role_id');
            $fn = new Module_line_model();
            $fns = $fn->find_all_from_view();
            for($i=0;$i<count($fns) ;$i++){
                $line = $rml->find_by(array('module_line_id'=>$fns[$i]['id']));
                if(!empty($line)){
                    $fns[$i]['checked'] = 'checked';
                }else{
                    $fns[$i]['checked'] = '';
                }
            }
            $data['objects'] = _format($fns);
            $data['role_id'] = $role_id;
            render($data);
        }
    }

}
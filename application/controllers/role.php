<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('role_model');
        $this->load->model('role_profile_model');
        $this->load->model('role_profile_line_model');
        $this->load->model('user_role_model');
        $this->load->model('user_model');
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
        $r = $role->find(v('id'));
        if(empty($r)){
            show_404();
        }else{
            if($_POST){
                $data['id'] = v('id');
                $data['description'] = tpost('description');
                if($role->update($data['id'],$data,true)){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                render($r);
            }
        }

    }

    function destroy(){
        $r = new Role_model();
        $ur = new User_role_model();
        $role_id = p('id');
        $role = $r->find($role_id);
        //判断是否已经被使用
        $user_in_use = $ur->find_by(array('role_id'=>$role_id));
        if(!empty($role) && empty($user_in_use)){
            $this->db->trans_start();
            //profiles
            $p = new Role_profile_model();
            $pl = new Role_profile_line_model();
            //profile_lines
            foreach($p->find_all_by(array('role_id'=>$role_id)) as $h){
                $pl->delete_by(array('profile_id'=>$h['id']));
            }
            $p->delete_by(array('role_id'=>$role_id));
            //module_lines
            $ml = new Role_module_line_model();
            $ml->delete_by(array('role_id'=>$role_id));
            //self
            $r->delete($role_id);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                echo '数据库删除错误';
            }else{
                echo 'done';
            }
        }else{
            echo '角色被应用到多个用户';
        }
    }

    //分配到用户
    function allocate_users(){
        $ur = new User_role_model();
        $rm = new Role_model();
        $role = $rm->find(v('role_id'));
        if(empty($role)){
            show_404();
        }else{
            if($_POST){
                $ids = v('users');
                $data['role_id'] = v('role_id');
                $this->db->trans_start();
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
                $role_id = v('role_id');
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
    }

    function choose_functions(){
        $rml = new Role_module_line_model();
        $rm = new Role_model();
        $role = $rm->find(v('role_id'));
        if(empty($role)){
            show_404();
        }else{
            if($_POST){
                $ids = v('lines');
                $data['role_id'] = v('role_id');
                $this->db->trans_start();
                if($ids === FALSE){
                    //删除所有
                    $rml->delete_by(array('role_id' => $data['role_id']));
                }else{
                    //先删除已取消勾选的
                    $this->db->where_not_in('module_line_id',$ids);
                    $rml->delete_by(array('role_id' => $data['role_id']));
                    //新增的部分
                    $ids = array_diff($ids,$rml->find_module_line_ids($data['role_id']));
                    foreach($ids as $id){
                        $data['module_line_id'] = $id;
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
                    $line = $rml->find_by(array('module_line_id'=>$fns[$i]['id'],'role_id'=>$role_id));
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

    function profiles(){
        $pl = new Role_profile_line_model();
        $role_id = p('role_id');
        $lines = $pl->find_all_from_view(array('role_id'=>$role_id));
        $data['objects'] = _format($lines);
        $data['role_id'] = $role_id;
        render($data);
    }

    function profile_add_object(){
        //选择权限对象时过滤值集以ao_开头

    }
}
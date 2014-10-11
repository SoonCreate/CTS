<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('role_model');
        $this->load->model('authority_object_model');

        $this->load->model('role_profile_model');
        $this->load->model('role_profile_line_model');
        $this->load->model('user_role_model');
        $this->load->model('role_module_line_model');
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
        $this->load->model('role_profile_model');
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

    //为了简化操作，角色可以拷贝
    function copy_from(){
        if($_POST){
            $rm = new Role_model();
            $role = $rm->find(v('from'));
            if(empty($role)){
                show_404();
            }else{
                //拷贝基础数据

                //拷贝profile和权限对象明细

                //拷贝功能模块

            }
        }else{
            render();
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
                $this->load->model('user_model');
                $role_id = $role['id'];
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
                $role_id = $role['id'];
                $this->load->model('module_line_model');
                $fn = new Module_line_model();
                $fns = $fn->find_all_by_view();
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

    function profile(){
        $rpm = new Role_profile_model();
        $rm = new Role_model();
        $role = $rm->find(v('role_id'));
        if(empty($role)){
            show_404();
        }else{
            $lines = $rpm->find_all_by_view(array('role_id'=>$role['id']));
            $data['objects'] = _format($lines);
            render($data);
        }
    }

    function profile_add_object(){
        //选择权限对象时过滤值集以ao_开头
        $rm = new Role_model();
        $r = $rm->find(v('role_id'));
        if(empty($r)){
            show_404();
        }else{
            if($_POST){
                $object_id = v('object_id');
                $this->load->model('authobj_line_model');
                $rpm = new Role_profile_model();
                $rplm = new Role_profile_line_model();
                $alm = new Authobj_line_model();
                $lines = $alm->find_all_by(array('object_id'=>$object_id));
                $this->db->trans_start();
                $profile['role_id'] = $r['id'];
                $profile['object_id'] = $object_id;
                $profile_id = $rpm->insert($profile);
                foreach($lines as $l){
                    $line['profile_id'] = $profile_id;
                    $line['object_line_id'] = $l['id'];
                    $line['auth_value'] = $l['default_value'];
                    $rplm->insert($line);
                }
                if ($this->db->trans_status() === FALSE) {
                    echo '数据库插入错误';
                }else{
                    echo 'done';
                }
            }else{
                $aom = new Authority_object_model();
                $data['objects'] = $aom->find_all();
                render($data);
            }
        }
    }

    function profile_destroy(){
        $rpm = new Role_profile_model();
        $profile = $rpm->find(v('id'));
        if(empty($profile)){
            show_404();
        }else{
            $rplm = new Role_profile_line_model();
            $this->db->trans_start();
            $rplm->delete_by(array('profile_id'=>$profile['id']));
            $rpm->delete($profile['id']);
            if ($this->db->trans_status() === FALSE) {
                echo '数据库错误';
            }else{
                echo 'done';
            }
        }
    }

    function profile_object_items(){
        $rpm = new Role_profile_model();
        $profile = $rpm->find(v('id'));
        if(empty($profile)){
            show_404();
        }else{
            $rplm = new Role_profile_line_model();
            $data['objects'] = _format($rplm->find_all_by_view(array('profile_id'=>$profile['id'])));
            render($data);
        }
    }

    //权限对象值编辑
    function profile_object_item_edit(){
        $rpm = new Role_profile_line_model();
        $line = $rpm->find(v('id'));
        if(empty($line)){
            show_404();
        }else{
            if($_POST){
                if($rpm->update($line['id'],_data('auth_value'))){
                    echo 'done';
                }else{
                    echo 'fail';
                }
            }else{
                render($line);
            }

        }
    }
}
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
        render($data);
	}

    function create(){
        if($_POST){
            $role = new Role_model();
            $data['role_name'] = tpost('role_name');
            $data['description'] = tpost('description');
            if($role->insert($data)){
                message_db_success();
            }else{
                validation_error();
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
                    message_db_success();
                }else{
                    validation_error();
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
                message_db_failure();
            }else{
                message_db_success();
            }
        }else{
            custz_message('E', '角色被应用到多个用户');
        }
    }

    //为了简化操作，角色可以拷贝
    function copy_from(){
        if($_POST){
            $rm = new Role_model();
            $from = $rm->find(v('role_from'));
            if(empty($from)){
                show_404();
            }else{
                $data = _data('role_name','description');
                if($rm->run_validation($data)){
                    $rplm = new Role_profile_line_model();
                    $rpm = new Role_profile_model();
                    $rmlm = new Role_module_line_model();
                    $this->db->trans_start();
                    //拷贝基础数据
                    $role_id = $rm->insert(_data('role_name','description'));

                    //拷贝profile和权限对象明细
                    $ps = $rpm->find_all_by(array('role_id'=>$from['id']));
                    foreach($ps as $p){
                        $profile['role_id'] = $role_id;
                        $profile['object_id'] = $p['object_id'];
                        $profile['module_line_id'] = $p['module_line_id'];
                        $pline['profile_id'] = $rpm->insert($profile);
                        $pls = $rplm->find_all_by(array('profile_id'=>$p['id']));
                        foreach($pls as $pl){
                            $pline['object_line_id'] = $pl['object_line_id'];
                            $pline['auth_value'] = $pl['auth_value'];
                            $rplm->insert($pline);
                        }
                    }

                    //拷贝功能模块
                    $mls = $rmlm->find_all_by(array('role_id'=>$from['id']));
                    foreach($mls as $ml){
                        $mline['role_id'] = $role_id;
                        $mline['module_line_id'] = $ml['module_line_id'];
                        $rmlm->insert($mline);
                    }
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE) {
                        message_db_failure();
                    }else{
                        message_db_success();
                    }
                }else{
                    validation_error();
                }

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
                    message_db_failure();
                }else{
                    redirect_to('role','index');
                    message_db_success();
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
                render($data);
            }
        }
    }

    function choose_functions(){
        $rml = new Role_module_line_model();
        $rm = new Role_model();
        $rplm = new Role_profile_line_model();
        $rpm = new Role_profile_model();
        $role = $rm->find(v('role_id'));
        if(empty($role)){
            show_404();
        }else{
            if($_POST){
                $ids = v('lines');
                $data['role_id'] = v('role_id');
                $this->db->trans_start();
                if($ids === FALSE){
                    //删除功能相关profile
                    $profiles = $rpm->find_all_by('module_line_id is not null');
                    foreach($profiles as $p){
                        $rplm->delete_by(array('profile_id'=>$p['id']));
                        $rpm->delete($p['id']);
                    }

                    //删除所有功能
                    $rml->delete_by(array('role_id' => $data['role_id']));
                }else{
                    $this->load->model('module_line_model');
                    $this->load->model('function_object_model');
                    $this->load->model('function_obj_line_model');
//                    $this->load->
                    $mlm = new Module_line_model();
                    $fom = new Function_object_model();
                    $folm = new Function_obj_line_model();
                    //先删除已取消勾选的
                    $this->db->where_not_in('module_line_id',$ids);
                    $profiles = $rpm->find_all();
                    foreach($profiles as $p){
                        $rplm->delete_by(array('profile_id'=>$p['id']));
                        $rpm->delete($p['id']);
                    }

                    $this->db->where_not_in('module_line_id',$ids);
                    $rml->delete_by(array('role_id' => $data['role_id']));
                    //新增的部分
                    $ids = array_diff($ids,$rml->find_module_line_ids($data['role_id']));
                    foreach($ids as $id){
                        $data['module_line_id'] = $id;
                        $rml->insert($data);
                        $item = $mlm->find_by_view(array('id'=>$id));
                        if(!empty($item)){
                            //获取function的权限对象为profile中的默认权限对象
                            $ps = $fom->find_all_by(array('function_id'=>$item['function_id']));
                            foreach ($ps as $p) {
                                $profile['role_id'] = $data['role_id'];
                                $profile['object_id'] = $p['object_id'];
                                $profile['module_line_id'] = $id;

                                $olms = $folm->find_all_by(array('fun_object_id'=>$p['id']));
                                $items = array();
                                //格式化参数items
                                foreach($olms as $olm){
                                    $items[$olm['object_line_id']] = $olm['default_value'];
                                }
                                //判断源profile中是否存在一样的权限对象和项目
                                if(!$rpm->object_is_exists($data['role_id'],$p['object_id'],$items)){
                                    $ml['profile_id'] = $rpm->insert($profile);
                                    foreach($olms as $olm){
                                        $ml['object_line_id'] = $olm['object_line_id'];
                                        $ml['auth_value'] = $olm['default_value'];
                                        $rplm->insert($ml);
                                    }
                                }

                            }

                        }
                    }
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    message_db_failure();
                }else{
                    go_back();
                    message_db_success();
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
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    message_db_failure();
                }else{
                    message_db_success();
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
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                message_db_failure();
            }else{
                message_db_success();
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
        $line = $rpm->find_by_view(array('id'=>v('id')));
        if(empty($line)){
            show_404();
        }else{
            if($_POST){
                $auth_value = tpost('auth_value');
                $auth_value = str_replace(',',' ',$auth_value);
                $auth_value = _trim($auth_value);
                $_POST['auth_value'] = str_replace(' ',',',$auth_value);
                if($rpm->update($line['id'],_data('auth_value'))){
                    go_back();
                    message_db_success();
                }else{
                    message_db_failure();
                }
            }else{
                $line['auth_data'] = json_encode(get_options($line['auth_item_name'],null,true));
                render($line);
            }

        }
    }
}
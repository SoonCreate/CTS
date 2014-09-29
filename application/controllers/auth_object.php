<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_object extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('authority_object_model');
        $this->load->model('authobj_line_model');
        $this->load->model('role_profile_line_model');
    }

    function index(){
        $o = new Authority_object_model();
        $data['objects'] = $o->find_all();
        render($data);
    }

    function create(){
        if($_POST){
            $data['object_name'] = tpost('object_name');
            $data['description'] = tpost('description');
            $o= new Authority_object_model();
            if($o->insert($data)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
            render();
        }
    }

    function edit(){
        $o = new Authority_object_model();
        if($_POST){
            $data['id'] = v('id');
            $data['description'] = tpost('description');
            if($o->update($data['id'],$data)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }

        }else{
            render($o->find(p('id')));
        }
    }

    function destroy(){
        $ao = new Authority_object_model();
        $aol = new Authobj_line_model();
        $rpl = new Role_profile_line_model();
        $object_id = p('id');
        $auth_obj = $ao->find($object_id);
        $role_in_use = $rpl->find_all_from_view(array('object_id'=>$object_id));
        if(!empty($auth_obj) && empty($role_in_use)){
            $this->db->trans_start();
            $aol->delete_by(array('object_id'=>$object_id));
            $ao->delete($object_id);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                echo '数据库删除错误';
            }else{
                echo 'done';
            }
        }else{
            echo '无法删除!功能正在模块或角色被使用.';
        }
    }

    function items(){
        $o = new Authobj_line_model();
        $data['items'] = $o->find_all_by_object_id_view(p('id'));
        render($data);
    }

    function item_edit(){

    }

    function item_create(){

    }

    function item_destroy(){

    }

}
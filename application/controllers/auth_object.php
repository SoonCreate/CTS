<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_object extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('authority_object_model');
        $this->load->model('authobj_line_model');
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
        $aom = new Authority_object_model();
        $ao = $aom->find(v('id'));
        if(empty($ao)){
            show_404();
        }else{
            if($_POST){
                $data['description'] = tpost('description');
                if($aom->update($ao['id'],$data)){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }

            }else{
                render($ao);
            }
        }

    }

    function destroy(){
        $this->load->model('role_profile_line_model');
        $ao = new Authority_object_model();
        $aol = new Authobj_line_model();
        $rpl = new Role_profile_line_model();
        $object_id = p('id');
        $auth_obj = $ao->find($object_id);
        $role_in_use = $rpl->find_all_by_view(array('object_id'=>$object_id));
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
        $alm = new Authobj_line_model();
        $data['items'] = $alm->find_all_by_view(array('object_id'=>v('id')));
        render($data);
    }

    function item_edit(){
        $alm = new Authobj_line_model();
        $line = $alm->find_by_view(array('id'=>v('id')));
        if(empty($line)){
            show_404();
        }else{
            if($_POST){
                if($alm->update($line['id'],_data('default_value'))){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                render($line);
            }

        }
    }

    function item_create(){
        $aom = new Authority_object_model();
        $o = $aom->find(v('object_id'));
        if(empty($o)){
            show_404();
        }else{
            if($_POST){
                $alm = new Authobj_line_model();
                if($alm->insert(_data('valuelist_id','object_id','default_value'))){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                render();
            }

        }
    }

    function item_destroy(){
        $alm = new Authobj_line_model();
        $line = $alm->find(v('id'));
        if(empty($line)){
            show_404();
        }else{
            $this->load->model('role_profile_line_model');
            //是否被使用到角色中
            $rplm = new Role_profile_line_model();
            $l = $rplm->find_by(array('object_line_id'=>$line['id']));
            if(empty($l)){
                if($alm->delete($line['id'])){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                echo '权限对象被多个角色使用，无法删除！';
            }
        }
    }

}
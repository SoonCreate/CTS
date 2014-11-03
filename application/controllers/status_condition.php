<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_condition extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('status_line_model');
    }

    function groups(){
        $this->load->model('status_condition_group_model');
        $scgm = new Status_condition_group_model();
        $data['objects'] = $scgm->find_all_by(array('status_line_id'=>v('id')));
        render($data);
    }

    function group_create(){
        $slm = new Status_line_model();
        $line = $slm->find(v('status_line_id'));
        if(empty($line)){
            show_404();
        }else{
            $this->load->model('status_condition_group_model');
            $scgm = new Status_condition_group_model();
            if($_POST){
                if($scgm->insert(_data('group_name','status_line_id'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render();
            }
        }
    }

    function group_edit(){
        $this->load->model('status_condition_group_model');
        $scgm = new Status_condition_group_model();
        $g = $scgm->find(v('id'));
        if(empty($g)){
            show_404();
        }else{
            if($_POST){
                if($scgm->update($g['id'],_data('group_name'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render($g);
            }
        }

    }

    function group_destroy(){
        $this->load->model('status_condition_group_model');
        $scgm = new Status_condition_group_model();
        $g = $scgm->find(v('id'));
        if(empty($g)){
            show_404();
        }else{
            $this->load->model('status_condition_model');
            $scm = new Status_condition_model();
            $this->db->trans_start();
            $scm->delete_by(array('group_id'=>$g['id']));
            $scgm->delete($g['id']);
            $this->db->trans_complete();
            if($this->db->trans_status() === TRUE){
                message_db_success();
            }else{
                message_db_failure();
            }
        }
    }

    function conditions(){
        $this->load->model('status_condition_model');
        $scm = new Status_condition_model();
        $group_id = v('group_id');
        $rows = $scm->find_all_by_view(array('group_id'=>$group_id));
        for($i=0;$i<count($rows);$i++){
            $table_name = $scm->table_name($rows[$i]['status_line_id']);
            $rows[$i]['and_or'] = get_label('vl_and_or',$rows[$i]['and_or']);
            $rows[$i]['field_name'] = field_comment($table_name,$rows[$i]['field_name']);
            $rows[$i]['table_name'] = table_comment($table_name);
            $rows[$i]['operation'] = get_label('vl_operations',$rows[$i]['operation']);
        }
        $data['objects'] = $rows;
        render($data);
    }

    //条件公式
    function create(){
        $this->load->model('status_condition_group_model');
        $scgm = new Status_condition_group_model();
        $g = $scgm->find(v('group_id'));
        if(empty($g)){
            show_404();
        }else{
            $this->load->model('status_condition_model');
            $scm = new Status_condition_model();
            if($_POST){
                if($scm->insert(_data('and_or','field_name','operation','target_value','group_id'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                //默认为order表，order表字段
//                $data['table_name'] = get_options('vl_tables')[0]['value'];
                $data['table_name'] = $scm->table_name($g['status_line_id']);
                $data['field_name'] = 'status';
                $data['field_options'] = field_list($data['table_name']);
                render($data);
            }
        }
    }

    function edit(){
        $this->load->model('status_condition_model');
        $scm = new Status_condition_model();
        $cline = $scm->find_by_view(array('id'=>v('id')));
        if(empty($cline)){
            show_404();
        }else{
            if($_POST){
                if($scm->update($cline['id'],_data('and_or','field_name','operation','target_value'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                $cline['field_options'] = field_list($scm->table_name($cline['status_line_id']));
                render($cline);
            }
        }
    }

    function destroy(){
        $this->load->model('status_condition_model');
        $scm = new Status_condition_model();
        $cline = $scm->find(v('id'));
        if(empty($cline)){
            show_404();
        }else{
            if($scm->delete($cline['id'])){
                message_db_success();
            }else{
                message_db_failure();
            }
        }
    }

    //涉及到的权限对象的验证
    function objects(){
        $this->load->model('status_authobject_model');
        $sam = new Status_authobject_model();
        $data['objects'] = $sam->find_all_by_view(array('group_id'=>v('group_id')));
        render($data);
    }

    //添加权限对象
    function add_object(){
        $this->load->model('status_condition_group_model');
        $scgm = new Status_condition_group_model();
        $g = $scgm->find(v('group_id'));
        if(empty($g)){
            show_404();
        }else{
            if($_POST){
                $this->load->model('status_authobject_model');
                $this->load->model('status_authobj_line_model');
                $sam = new Status_authobject_model();
                $salm = new Status_authobj_line_model();
                $this->db->trans_start();
                $data['status_obj_id'] = $sam->insert(_data('object_id','group_id'));
                $this->load->model('authobj_line_model');
                $alm = new Authobj_line_model();
                $lines = $alm->find_all_by(array('object_id'=>v('object_id')));
                foreach($lines as $l){
                    $data['authobj_line_id'] = $l['id'];
                    $data['auth_value'] = $l['default_value'];
                    $salm->insert($data);
                }
                $this->db->trans_complete();
                if($this->db->trans_status() === TRUE){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render();
            }
        }
    }

    //权限对象项目
    function object_items(){
        $this->load->model('status_authobject_model');
        $sam = new Status_authobject_model();
        $object = $sam->find(v('id'));
        if(empty($object)){
            show_404();
        }else{
            $this->load->model('status_authobj_line_model');
            $salm = new Status_authobj_line_model();
            $data['objects'] = $salm->find_all_by_view(array('status_obj_id'=>$object['id']));
            render($data);
        }
    }

    function object_item_edit(){
        $this->load->model('status_authobj_line_model');
        $salm = new Status_authobj_line_model();
        $item = $salm->find_by_view(array('id'=>v('id')));
        if(empty($item)){
            show_404();
        }else{
            if($_POST){
                if($salm->update($item['id'],array('auth_value'=>v('auth_value')))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render($item);
            }
        }
    }

    function object_destroy(){
        $this->load->model('status_authobject_model');
        $sam = new Status_authobject_model();
        $object = $sam->find(v('id'));
        if(empty($object)) {
            show_404();
        }else{
            $this->load->model('status_authobj_line_model');
            $salm = new Status_authobj_line_model();
            $this->db->trans_start();
            $salm->delete_by(array('status_obj_id'=>$object['id']));
            $sam->delete($object['id']);
            $this->db->trans_complete();
            if($this->db->trans_status() === TRUE){
                message_db_success();
            }else{
                validation_error();
            }
        }
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('status_model');
        $this->load->model('status_line_model');
    }

    public function index()
    {
        $sm = new Status_model();
        $data['objects'] = $sm->find_all();
        render($data);
    }

    function create(){
        if($_POST){
            $sm = new Status_model();
            if($sm->insert(_data('status_code','description'))){
                go_back();
                message_db_success();
            }else{
                validation_error();
            }
        }else{
            render();
        }
    }

    function edit(){
        $sm = new Status_model();
        $o = $sm->find(v('id'));
        if(empty($o)){
            show_404();
        }else{
            if($_POST){
                if($sm->update($o['id'],_data('description'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render($o);
            }
        }

    }

    function destroy(){

    }

    function items(){
        $sm = new Status_model();
        $slm = new Status_line_model();
        $o = $sm->find(v('id'));
        if(empty($o)){
            show_404();
        }else{
            $data['items'] = _format($slm->find_all_by_view(array('status_id' => $o['id'])),true);
            render($data);
        }
    }


    function item_create(){
        $sm = new Status_model();
        $slm = new Status_line_model();
        $o = $sm->find(v('status_id'));
        if(empty($o)){
            show_404();
        }else{
            if($_POST){
                $_POST['initial_flag'] = v('initial_flag');
                $_POST['auto_ending_flag'] = v('auto_ending_flag');
                $_POST['inactive_flag'] = v('inactive_flag');
                $_POST['last_step_flag'] = v('last_step_flag');
                if($slm->insert($_POST)){
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

    function item_edit(){
        $slm = new Status_line_model();
        $o = $slm->find(v('id'));
        if(empty($o)){
            show_404();
        }else{
            if($_POST){
                $_POST['initial_flag'] = v('initial_flag');
                $_POST['auto_ending_flag'] = v('auto_ending_flag');
                $_POST['inactive_flag'] = v('inactive_flag');
                $_POST['last_step_flag'] = v('last_step_flag');
                if($slm->update($o['id'],$_POST)){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render($o);
            }
        }
    }

    function conditions(){
        $this->load->model('status_condition_model');
        $scm = new Status_condition_model();
        $rows = $scm->find_all_by(array('status_line_id'=>v('id')));
        for($i=0;$i<count($rows);$i++){
            $rows[$i]['and_or'] = get_label('vl_and_or',$rows[$i]['and_or']);
            $rows[$i]['field_name'] = field_comment($rows[$i]['table_name'],$rows[$i]['field_name']);
            $rows[$i]['table_name'] = table_comment($rows[$i]['table_name']);
            $rows[$i]['operation'] = get_label('vl_operations',$rows[$i]['operation']);
        }
        $data['objects'] = $rows;
        render($data);
    }

    //条件公式
    function condition_create(){
        $slm = new Status_line_model();
        $line = $slm->find(v('status_line_id'));
        if(empty($line)){
            show_404();
        }else{
            if($_POST){
                $this->load->model('status_condition_model');
                $scm = new Status_condition_model();
                if($scm->insert(_data('and_or','table_name','field_name','operation','target_value','status_line_id'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                //默认为order表，order表字段
//                $data['table_name'] = get_options('vl_tables')[0]['value'];
                $data['table_name'] = 'ct_orders';
                $data['field_name'] = 'status';
                $data['field_options'] = field_list($data['table_name']);
                render($data);
            }
        }
    }

    function condition_edit(){
        $this->load->model('status_condition_model');
        $scm = new Status_condition_model();
        $cline = $scm->find(v('id'));
        if(empty($cline)){
            show_404();
        }else{
            if($_POST){
                if($scm->update($cline['id'],_data('and_or','table_name','field_name','operation','target_value'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                $cline['field_options'] = field_list($cline['table_name']);
                render($cline);
            }
        }
    }

    function condition_destroy(){
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

    //当前步骤包含的功能点
    function functions(){
        $this->load->model('status_function_model');
        $sfm = new Status_function_model();
        $data['objects'] = $sfm->find_all_by_view(array('status_line_id'=>v('id')));
        render($data);
    }

    function function_create(){
        $slm = new Status_line_model();
        $line = $slm->find(v('status_line_id'));
        if(empty($line)){
            show_404();
        }else{
            if($_POST){
                $this->load->model('status_function_model');
                $sfm = new Status_function_model();
                if($sfm->insert(_data('function_id','sort','label','status_line_id'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                $data['sort'] = 0;
                render($data);
            }
        }
    }

    function function_edit(){
        $this->load->model('status_function_model');
        $sfm = new Status_function_model();
        $cline = $sfm->find(v('id'));
        if(empty($cline)){
            show_404();
        }else{
            if($_POST){
                if($sfm->update($cline['id'],_data('function_id','sort','label','status_line_id'))){
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

    function function_destroy(){
        $this->load->model('status_function_model');
        $sfm = new Status_function_model();
        $cline = $sfm->find(v('id'));
        if(empty($cline)){
            show_404();
        }else{
            if($sfm->delete($cline['id'])){
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
        $data['objects'] = $sam->find_all_by_view(array('status_line_id'=>v('id')));
        render($data);
    }

    //添加权限对象
    function add_object(){
        $slm = new Status_line_model();
        $line = $slm->find(v('status_line_id'));
        if(empty($line)){
            show_404();
        }else{
            if($_POST){
                $this->load->model('status_authobject_model');
                $this->load->model('status_authobj_line_model');
                $sam = new Status_authobject_model();
                $salm = new Status_authobj_line_model();
                $this->db->trans_start();
                $data['status_obj_id'] = $sam->insert(_data('object_id','status_line_id'));
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
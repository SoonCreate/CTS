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
        $data['objects'] = $sm->find_all_by_view();
        render($data);
    }

    function create(){
        if($_POST){
            $sm = new Status_model();
            if($sm->insert(_data('status_code','description','sys_order_id'))){
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
        $sm = new Status_model();
        $o = $sm->find(v('id'));
        if(empty($o)){
            show_404();
        }else{
            //验证是否被使用到投诉单类型中
            $this->load->model('valuelist_line_model');
            $vlm = new Valuelist_line_model();
            $use_in_vl = $vlm->find_by_view(array('valuelist_name'=>'default_status','segment_value'=>$o['status_code']));
            if($use_in_vl){
                custz_message('E','状态流正在被使用，不能删除！');
            }else{
                $slm = new Status_line_model();
                if($slm->count_by(array('status_id'=>$o['id'])) > 0){
                    custz_message('E','请先清空项目！');
                }else{
                    if($sm->delete($o['id'])){
                        message_db_success();
                    }else{
                        message_db_failure();
                    }
                }
            }
        }
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

    function item_destroy(){
        $slm = new Status_line_model();
        $o = $slm->find(v('id'));
        if(empty($o)){
            show_404();
        }else{
            $this->load->model('status_condition_model');
            $this->load->model('status_function_model');
            $this->load->model('status_authobject_model');
            $this->load->model('status_authobj_line_model');
            $scm = new Status_condition_model();
            $sfm = new Status_function_model();
            $sam = new Status_authobject_model();
            $salm = new Status_authobj_line_model();
            $this->db->trans_start();
            $objects = $sam->find_all_by(array('status_line_id'=>$o['id']));
            foreach($objects as $l){
                $salm->delete_by(array('status_obj_id'=>$l['id']));
            }
            $sam->delete_by(array('status_line_id'=>$o['id']));
            $sfm->delete_by(array('status_line_id'=>$o['id']));
            $scm->delete_by(array('status_line_id'=>$o['id']));
            $slm->delete($o['id']);
            $this->db->trans_complete();
            if($this->db->trans_status() === TRUE){
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
                render($cline);
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
}
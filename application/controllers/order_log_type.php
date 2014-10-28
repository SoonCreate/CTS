<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_log_type extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('order_log_type_model');
    }

    function index(){
        $oltm = new Order_log_type_model();
        $data['objects'] = _format($oltm->find_all(),true);
        render($data);
    }

    function create(){
        if($_POST){
            $oltm = new Order_log_type_model();
            $_POST['need_reason_flag'] = v('need_reason_flag');
            if($oltm->insert($_POST)){
                go_back();
                message_db_success();
            }else{
                validation_error();
            }
        }else{
            $this->load->model('order_model');
            $om = new Order_model();
            $data['fields'] = $om->field_list();
            render($data);
        }
    }

    function edit(){
        $oltm = new Order_log_type_model();
        $l = $oltm->find(v('id'));
        if(empty($l)){
            show_404();
        }else{
            if($_POST){
                $_POST['need_reason_flag'] = v('need_reason_flag');
                if($oltm->update($l['id'],$_POST)){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                $this->load->model('order_model');
                $om = new Order_model();
                $l['fields'] = $om->field_list();
                render($l);
            }
        }
    }

    function destroy(){
        $oltm = new Order_log_type_model();
        $id = v('id');
        $o = $oltm->find($id);
        if(!empty($o)){
            $this->load->model('order_log_model');
            $olm = new Order_log_model();
            $log = $olm->find_by(array('log_type'=>$o['log_type']));
            if(empty($log)){
                if($oltm->delete($id)){
                    message_db_success();
                }else{
                    message_db_failure();
                }
            }else{
                custz_message('E','日志类型被用于多个日志中！无法删除');
            }
        }else{
            show_404();
        }
    }

    function notice_rules(){
        $oltm = new Order_log_type_model();
        $o = $oltm->find(v('id'));
        if(!empty($o)){
            $this->load->model('notice_rule_model');
            $nrm = new Notice_rule_model();
            $data['objects'] = _format($nrm->find_all_by(array('log_type_id'=>$o['id'])),true);
            render($data);
        }else{
            show_404();
        }
    }

    function notice_rule_create(){
        $oltm = new Order_log_type_model();
        $id = v('log_type_id');
        $o = $oltm->find($id);
        if(!empty($o)){
            if($_POST){
                $_POST['inactive_flag'] = v('inactive_flag');
                $_POST['notice_created_by'] = v('notice_created_by');
                $_POST['notice_manager'] = v('notice_manager');
                $_POST['notice_leader'] = v('notice_leader');
                $this->load->model('notice_rule_model');
                $nrm = new Notice_rule_model();
                if($nrm->insert($_POST)){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render($o);
            }
        }else{
            show_404();
        }
    }

    function notice_rule_edit(){
        $this->load->model('notice_rule_model');
        $nrm = new Notice_rule_model();
        $o = $nrm->find(v('id'));
        if(!empty($o)){
            if($_POST){
                $_POST['inactive_flag'] = v('inactive_flag');
                $_POST['notice_created_by'] = v('notice_created_by');
                $_POST['notice_manager'] = v('notice_manager');
                $_POST['notice_leader'] = v('notice_leader');
                if($nrm->update($o['id'],$_POST)){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render($o);
            }
        }else{
            show_404();
        }
    }

    function notice_rule_destroy(){
        $this->load->model('notice_rule_model');
        $nrm = new Notice_rule_model();
        $o = $nrm->find(v('id'));
        if(!empty($o)){
            if($nrm->delete($o['id'])){
                message_db_success();
            }else{
                message_db_failure();
            }
        }else{
            show_404();
        }
    }

}
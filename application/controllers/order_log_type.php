<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_log_type extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('order_log_type_model');
        $this->load->model('order_log_model');
        $this->load->model('order_model');
    }

    function index(){
        $oltm = new Order_log_type_model();
        $data['objects'] = _format($oltm->find_all());
        render($data);
    }

    function create(){
        if($_POST){
            $oltm = new Order_log_type_model();
            $_POST['need_reason_flag'] = v('need_reason_flag');
            $_POST['notice_flag'] = v('notice_flag');
            $data = _data('log_type', 'description', 'title','content','field_name','dll_type','need_reason_flag','notice_flag','field_valuelist_id');
            if($oltm->insert($data)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
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
                $data = _data('description', 'title','content','field_name','dll_type','need_reason_flag','notice_flag','field_valuelist_id');
                if($oltm->update(v('id'),$data)){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                render($l);
            }
        }
    }

    function destroy(){
        $oltm = new Order_log_type_model();
        $id = p('id');
        $o = $oltm->find($id);
        if(!empty($o)){
            $olm = new Order_log_model();
            $log = $olm->find_by(array('log_type'=>$o['log_type']));
            if(empty($log)){
                if($oltm->delete($id)){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                echo '日志类型被用于多个日志中！无法删除';
            }
        }else{
            show_404();
        }
    }

}
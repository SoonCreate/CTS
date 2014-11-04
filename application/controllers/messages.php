<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('message_model');
        $this->load->model('message_class_model');
    }

    function index(){
        $mcm = new Message_class_model();
        $data['objects'] = $mcm->find_all();
        render($data);
    }

    function create(){
        $mcm = new Message_class_model();
        $class = $mcm->find(v('class_id'));
        if(empty($class)){
            show_404();
        }else{
            $mm = new Message_model();
            if($_POST){
                $data = _data('message_code','content','class_id','help');
                if($this->_is_message_exists($data['message_code'],$data['class_id'])){
                    custz_message('E','消息条目已存在!') ;
                }else{
                    if($mm->insert($data)){
                        go_back();
                        message_db_success();
                    }else{
                        validation_error();
                    }
                }
            }else{
                $this->db->select_max('message_code');
                $line = $mm->find_all_by(array('class_id'=>$class['id']));
                $data['message_code'] = string_to_number($line[0]['message_code']) + 10;
                render($data);
            }
        }
    }

    function edit(){
        $mm = new Message_model();
        $message = $mm->find(v('id'));
        if(empty($message)){
            show_404();
        }else{
            if($_POST){
                $data = _data('content','help');
                if($mm->update($message['id'],$data)){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }

            }else{
                render($message);
            }
        }
    }

    function destroy(){
        $mm = new Message_model();
        $message = $mm->find(v('id'));
        if(empty($message)){
            show_404();
        }else{
            if($mm->delete($message['id'])){
                message_db_success();
            }else{
                message_db_failure();
            }
        }
    }

    function class_create(){
        $mcm = new Message_class_model();
        if($_POST){
            if($mcm->insert(_data('class_code','description'))){
                message_db_success();
            }else{
                validation_error();
            }
        }else{
            render();
        }
    }

    function class_edit(){
        $mcm = new Message_class_model();
        $class = $mcm->find(v('id'));
        if(empty($class)){
            show_404();
        }else{
            if($_POST){
                if($mcm->update($class['id'],_data('description'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render($class);
            }
        }

    }

    function class_destroy(){
        $mcm = new Message_class_model();
        $class = $mcm->find(v('id'));
        if(empty($class)){
            show_404();
        }else{
            //判断是否存在消息条目
            $mm = new Message_model();
            $m = $mm->find_by(array('class_id'=>$class['id']));
            if(empty($m)){
                if($mcm->delete($class['id'])){
                    message_db_success();
                }else{
                    message_db_failure();
                }
            }else{
                custz_message('E','请先清空消息条目，再尝试删除消息类！') ;
            }

        }
    }

    function items(){
        $mcm = new Message_class_model();
        $class = $mcm->find(v('class_id'));
        if(empty($class)){
            show_404();
        }else{
            $mm = new Message_model();
            $class['objects'] = $mm->find_all_by_view(array('class_id'=>$class['id']));
            render($class);
        }
    }

    private function _is_message_exists($message_code,$class_id){
        $mm = new Message_model();
        $message = $mm->find_by(array('message_code'=>$message_code,'class_id'=>$class_id));
        if(!empty($message)){
            return true;
        }else{
            return false;
        }
    }

}
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
                if($mm->insert(_data('message_code','content','class_id'))){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                render();
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
                if($mm->update($message['id'],_data('content'))){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
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
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }
    }

    function class_create(){
        $mcm = new Message_class_model();
        if($_POST){
            if($mcm->insert(_data('class_code','description'))){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
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
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
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
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                echo '请先清空消息条目，再尝试删除消息类！';
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

}
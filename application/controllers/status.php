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

}
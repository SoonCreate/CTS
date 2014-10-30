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
}
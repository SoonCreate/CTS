<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configs extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('config_model');
    }

    function index(){
        $cm = new Config_model();
        $data['objects'] = $cm->find_all();
        render($data);
    }

    function edit(){
        $cm = new Config_model();
        $config = $cm->find(v('id'));
        if(empty($config)){
            show_404();
        }else{
            if($config['editable_flag']){
                if($_POST){
                    if($cm->update($config['id'],_data('config_value'))){

                        //定制判断，允许重新打开，update状态表
                        if($config['config_name'] == 'allow_reopen'){
                            $v = string_to_boolean(v('config_value'));
                            $order_types = get_options('vl_order_type');
                            $this->load->model('status_line_model');
                            $slm = new Status_line_model();
                            $this->db->trans_start();
                            foreach($order_types as $t){
                                $line = $slm->find_by_view(array('status_code'=>default_value('status',$t['value']),'segment_value'=>'reopen'));
                                if(!empty($line)){
                                    $slm->update($line['id'],array('inactive_flag'=> !$v));
                                }
                            }
                            $this->db->trans_complete();
                            if($this->db->trans_status() === TRUE){
                                go_back();
                                message_db_success();
                            }else{
                                message_db_failure();
                            }
                        }else{
                            go_back();
                            message_db_success();
                        }
                    }else{
                        message_db_failure();
                    }
                }else{
                    render($config);
                }

            }else{
                show_404();
            }
        }
    }


}
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
                        go_back();
                        message_db_success();
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
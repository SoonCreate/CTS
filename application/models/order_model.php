<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('status_model','status');
        $this->load->model('auth_model','auth');
        $this->load->model('order_addfile_model','addfile');
        $this->load->model('order_content_model','content');
        $this->load->model('order_log_model','log');

        //服务端插入数据库之前验证
        $this->add_validate('order_type','required');
        $this->add_validate('status','required');
        $this->add_validate('severity','required');
        $this->add_validate('frequency','required');
        $this->add_validate('title','required|max_length[100]');

        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }

    function default_status(){
        return $this->status->default_status('order_status');
    }

    //状态本身是否允许修改
    function is_allow_next_status($current_status,$next_status){
        return $this->status->is_allow_next_status('order_status',$current_status,$next_status);
    }

    //
    function order_types(){
        return $this->auth->can_create_order_types();
    }

    function save($base_data,$content,$addfiles){
        $this->db->trans_begin();
        $order_id = $this->insert($base_data);
        if($order_id){
            //内容
            $data['order_id'] = $order_id;
            $data['content'] = $content;
            if(!$this->content->insert($data)){
                $this->rollback_and_return();
            }

            //附件
            if(!is_null($addfiles)){
                $files = json_decode($addfiles);
                if(!$this->addfile->insert($files)){
                    $this->rollback_and_return();
                }
            }

            //日志status
            $log['order_id'] = $order_id;
            $log['log_type'] = 'status';
            $log['new_value'] = $base_data['status'];
            if(!$this->log->insert($log)){
                $this->rollback_and_return();
            }

        }else{
            $this->rollback_and_return();
        }

        if ($this->db->trans_status() === FALSE) {
            $this->rollback_and_return();
        }else{
            $this->commit_and_return();
        }
    }

    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }


}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('status_model','status');
        $this->load->model('order_addfile_model','addfile');
        $this->load->model('order_content_model','content');
        $this->load->model('order_log_model','order_log');

        //服务端插入数据库之前验证
        $this->add_validate('order_type','required');
        $this->add_validate('status','required');
        $this->add_validate('severity','required');
        $this->add_validate('frequency','required');
        $this->add_validate('title','required|max_length[100]');
        $this->add_validate('contact','required|max_length[255]');
        $this->add_validate('mobile_telephone','required|max_length[255]|numeric');
        $this->add_validate('email','valid_email');
        $this->add_validate_255('phone_number','address','contact','full_name');

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

    function save($base_data,$content,$addfiles=null){
        $this->db->trans_begin();
        $order_id = $this->insert($base_data);
        if($order_id){
            //内容
            $data['order_id'] = $order_id;
            $data['content'] = $content;
            if(!$this->content->insert($data)){
                echo 'content_fail';
                $this->db->trans_rollback();
                return false;
            }

            //附件
            if(!is_null($addfiles)){
                echo 'addfile_fail';
                $files = json_decode($addfiles);
                if(!$this->addfile->insert($files)){
                    $this->db->trans_rollback();
                    return false;
                }
            }

//            //日志status
//            $log['order_id'] = $order_id;
//            $log['log_type'] = 'status';
//            $log['new_value'] = $base_data['status'];
//            if(!$this->order_log->insert($log)){
//                $this->db->trans_rollback();
//                return false;
//            }
            $this->db->trans_commit();
            return true;
        }else{
            echo 'order_fail';
            $this->db->trans_rollback();
            return false;
        }
    }

    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }


}
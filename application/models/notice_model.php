<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notice_model extends MY_Model{

    function __construct(){
        parent::__construct();

        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
        $this->after_create = array('after_create');

    }

    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }

    //插入之后激活发送邮件
    function after_create($data,$id){
        //先判断是否同时通过邮件收取通知
        $this->load->model('user_model');
        $um = new User_model();
        $user = $um->find($data['received_by']);
        if(!empty($user) && $user['email_flag'] && $user['email']){
            $data['id'] = $id;
            $content = $this->load->view('notice_mail',$data,true);
            send_mail($user['email'],$data['title'],$content);
        }
        //如果跟订单有关，则通知到具体的责任人
        if(isset($data['order_id'])){
            $this->load->model('order_model');
            $om = new Order_model();
            $order = $om->find($data['order_id']);
            if(!empty($order) && $order['manager_id'] && ($data['received_by'] != $order['manager_id'] && $data['with_manager'])){
                $data['received_by'] = $order['manager_id'];
                unset($data['id']);
                $this->insert($data);
            }
        }
    }
    

}
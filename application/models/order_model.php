<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('status_model','status');
        $this->load->model('order_addfile_model','addfile');
        $this->load->model('order_content_model','content');
        $this->load->model('order_log_model','order_log');
        $this->load->model('order_log_type_model');
        $this->load->model('valuelist_model');
        $this->load->model('notice_model');

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

    //在未开通分类管理时，默认分类
    function default_category($order_type){
        $vm = new Valuelist_model();
        $r = $vm->find_active_children_options('o_default_category',$order_type);
        if(empty($r)){
            return null;
        }else{
            return $r[0];
        }
    }

    //第一次的填写内容
    function first_content($id){
        $ocm = new Order_content_model();
        $ocm->order_by('creation_date');
        $c = $ocm->find_by(array('order_id'=>$id));
        if(empty($c)){
            return '';
        }else{
            return $c['content'];
        }
    }

    //状态本身是否允许修改
    function is_allow_next_status($current_status,$next_status){
        $sm = new Status_model();
        return $sm->is_allow_next_status('order_status',$current_status,$next_status);
    }

    function save($base_data,$content,$addfiles=null){
        $need_reason = 0;
        $change_hash = time();
        $nm = new Notice_model();
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

            $oltm = new Order_log_type_model();
            $olm = new Order_log_model();
            $log['change_hash'] = $change_hash;
            $insert_logs = $oltm->find_all_by(array('dll_type'=>'insert'));
            if(!empty($insert_logs)){
                foreach($insert_logs as $t){
                    if(isset($base_data[$t['field_name']])){

                        $need_reason = $t['need_reason_flag'];
                        $log['order_id'] = $order_id;
                        $log['new_value'] = $base_data[$t['field_name']];
                        $log['log_type'] = $t['log_type'];
                        $id = $olm->insert($log);
                        if(!$id){
                            $this->db->trans_rollback();
                            return false;
                        }else{
                            //是否同时创建通知
                            if($t['notice_flag']){
                                $n['log_id'] = $id;
                                $n['from_log'] = 1;
                                $n['title'] = $this->_format_log($log,'title');
                                $n['content'] = $this->_format_log($log,'content');
                                $n['order_id'] = $order_id;
                                if(!$nm->insert($n)){
                                    $this->db->trans_rollback();
                                    return false;
                                }
                            }
                        }
                    }
                }
            }
            //日志status
            $this->db->trans_commit();
            //如果需要填写原因，则直接跳转的原因补充页
            echo $need_reason;
            if($need_reason){
                redirect_to('order','change_reason',array('change_hash'=>$change_hash));
            }
            return true;
        }else{
            echo 'order_fail';
            $this->db->trans_rollback();
            return false;
        }
    }

    function change_status($order_id,$status){
        $order = $this->find($order_id);
    }

    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }

    function do_update($order_id,$data){
        $oltm = new Order_log_type_model();
        $olm = new Order_log_model();
        $nm = new Notice_model();
        $order = $this->find($order_id);
        $need_reason = 0;
        $change_hash = time();
        $this->db->trans_begin();
        if($this->update($order_id,$data,true)){
            $insert_logs = $oltm->find_all_by(array('dll_type'=>'update'));
            if(!empty($insert_logs)){
                $log['change_hash'] = $change_hash;
                foreach($insert_logs as $t){
                    if(isset($data[$t['field_name']])){

                        $need_reason = $t['need_reason_flag'];
                        $log['order_id'] = $order_id;
                        $log['new_value'] = $data[$t['field_name']];
                        $log['old_value'] = $order[$t['field_name']];
                        $log['log_type'] = $t['log_type'];
                        $id = $olm->insert($log);
                        if(!$id){
                            $this->db->trans_rollback();
                            return false;
                        }else{
                            //是否同时创建通知
                            if($t['notice_flag']){
                                $n['log_id'] = $id;
                                $n['from_log'] = 1;
                                $n['title'] = $this->_format_log($log,$t['title']);
                                $n['content'] = $this->_format_log($log,$t['content']);
                                $n['order_id'] = $order_id;
                                if(!$nm->insert($n)){
                                    $this->db->trans_rollback();
                                    return false;
                                }
                            }
                        }
                    }
                }
            }
            //日志status
            $this->db->trans_commit();
            //如果需要填写原因，则直接跳转的原因补充页
            if($need_reason){
                redirect_to('order','change_reason',array('change_hash'=>$change_hash));
            }
            return true;
        }else{
            echo 'order_fail';
            $this->db->trans_rollback();
            return false;
        }

    }

    function _format_log($log,$field){
        $content =  str_replace('&order_id',$log['order_id'],$field);
        $content =  str_replace('&new_value',$log['new_value'],$content);
        $content =  str_replace('&old_value',$log['old_value'],$content);
        return $content;
    }


}
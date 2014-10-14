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
    }

    function default_status(){
        $sm = new Status_model();
        return $sm->default_status('order_status');
    }

    function default_next_status($current_status){
        $sm = new Status_model();
        return $sm->default_next_status('order_status',$current_status);
    }

    //在未开通分类管理时，默认分类
    function default_category($order_type){
        $vm = new Valuelist_model();
        $r = $vm->find_active_children_options('default_category',$order_type);
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
                                $n['received_by'] = _sess('uid');
                                $n['with_manager'] = 1;
                                $n['title'] = $this->_format_log($log,'title');
                                $n['content'] = $this->_format_log($log,'content');
                                $n['order_id'] = $order_id;
                                $notice_id = $nm->insert($n);
                                if(!$notice_id){
                                    $this->db->trans_rollback();
                                    return false;
                                }else{
                                    //如果初始为空值，则第一次变更不记录原因
                                    if($log['old_value']){
                                        $need_reason = $t['need_reason_flag'];
                                    }
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
                redirect(_url('order','change_reason',array('change_hash'=>$change_hash)));
            }
            return $order_id;
        }else{
            $this->db->trans_rollback();
            return false;
        }
    }

    function change_status($order_id,$status){
        $order = $this->find($order_id);
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
                        $log['order_id'] = $order_id;
                        $log['new_value'] = $data[$t['field_name']];
                        $log['old_value'] = $order[$t['field_name']];
                        $log['log_type'] = $t['log_type'];
                        //新值和旧值相同，无变更时，不处理
                        if($log['new_value'] != $log['old_value']){
                            $id = $olm->insert($log);
                            if(!$id){
                                $this->db->trans_rollback();
                                return false;
                            }else{
                                //是否同时创建通知
                                if($t['notice_flag']){
                                    $log_v = $olm->find_by_view(array('id'=>$id));
                                    $n['log_id'] = $id;
                                    $n['from_log'] = 1;
                                    $n['received_by'] = $order['created_by'];
                                    $n['with_manager'] = 1;
                                    $n['title'] = $this->_format_log($log_v,$t['title']);
                                    $n['content'] = $this->_format_log($log_v,$t['content']);
                                    $n['order_id'] = $order_id;
                                    if(!$nm->insert($n)){
                                        $this->db->trans_rollback();
                                        return false;
                                    }else{
                                        //如果初始为空值，则第一次变更不记录原因
                                        if($log['old_value']){
                                            $need_reason = $t['need_reason_flag'];
                                        }
                                    }
                                }//if($t['
                            }//if(!$id
                        }//if($log['

                    }
                }
            }
            //日志status
            $this->db->trans_commit();
            //如果需要填写原因，则直接跳转的原因补充页
            if($need_reason){
                redirect(_url('order','change_reason',array('change_hash'=>$change_hash)));
            }
            return true;
        }else{
            echo 'order_fail';
            $this->db->trans_rollback();
            return false;
        }

    }

    function logs($order_id){
        $olm = new Order_log_model();
        $this->db->order_by('creation_date','desc');
        $logs = $olm->find_all_by_view(array('order_id'=>$order_id));
        $return = array();
        if(empty($logs)){
            return array();
        }else{
            for($i=0;$i<count($logs);$i++){
                //检查是否拥有日志类型的查看权限
                if(check_auth('log_display_control',array('ao_log_type'=>$logs[$i]['log_type']))){
                    $logs[$i]['content'] = $this->_format_log($logs[$i],$logs[$i]['content']);
                    array_push($return,$logs[$i]);
                }
//                $logs[$i]['content'] = $this->_format_log($logs[$i],$logs[$i]['content']);
            }
            return $return;
        }
    }

    function _format_log($log,$field){
        $vm = new Valuelist_model();
        $content =  str_replace('&order_id',$log['order_id'],$field);
        if(!is_null($log['field_valuelist_id'])){
            $vl = $vm->find($log['field_valuelist_id']);
            if(!empty($vl)){
                $content =  str_replace('&new_value',get_label($vl['valuelist_name'],$log['new_value']),$content);
                $content =  str_replace('&old_value',get_label($vl['valuelist_name'],$log['old_value']),$content);
            }else{
                $content =  str_replace('&new_value',_f($log['field_name'],$log['new_value']),$content);
                $content =  str_replace('&old_value',_f($log['field_name'],$log['old_value']),$content);
            }
        }else{
            $content =  str_replace('&new_value',_f($log['field_name'],$log['new_value']),$content);
            $content =  str_replace('&old_value',_f($log['field_name'],$log['old_value']),$content);
        }
        return $content;
    }

    function field_list(){
        return lazy_get_data("select COLUMN_NAME,COLUMN_COMMENT from INFORMATION_SCHEMA.COLUMNS
        where TABLE_SCHEMA = 'CTS' AND  table_name = 'CT_ORDERS'
        and COLUMN_NAME not in ('id','created_by','creation_date','last_updated_by','last_update_date')");
    }


}
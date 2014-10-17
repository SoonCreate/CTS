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
            $base_data['id'] = $order_id;
            $rs = $this->add_logs('insert',$base_data);
            if($rs){
                $this->db->trans_commit();
                return $order_id;
            }else{
                $this->db->trans_rollback();
                return false;
            }
        }else{
            $this->db->trans_rollback();
            return false;
        }
    }

    function add_logs($dll_type,$new_data,$old_data = NULL){
        $nm = new Notice_model();
        $oltm = new Order_log_type_model();
        $olm = new Order_log_model();
        $need_reason = 0;
        $change_hash = time();
        $log['change_hash'] = $change_hash;
        $ltypes = $oltm->find_all_by(array('dll_type'=>$dll_type));
        if(!empty($ltypes)){
            foreach($ltypes as $t){
                if(isset($new_data[$t['field_name']])){
                    $log['order_id'] = $new_data['id'];
                    $log['new_value'] = $new_data[$t['field_name']];
                    if(is_null($old_data)) {
                        $log['old_value'] = '';
                    }else{
                        $log['old_value'] = $old_data[$t['field_name']];
                    }
                    $log['log_type'] = $t['log_type'];
                    $id = $olm->insert($log);

                    if(!$id){
                        $this->db->trans_rollback();
                        return false;
                    }else{
                        if($t['when_new_value'] == _config('all_values')){
                            $t['when_new_value'] = $log['new_value'];
                        }

                        if($t['when_old_value'] == _config('all_values')){
                            $t['when_old_value'] = $log['old_value'];
                        }
                        //是否同时创建通知,符合条件
                        if($t['notice_flag'] && $t['when_new_value'] == $log['new_value'] && $t['when_old_value'] == $log['old_value']){

                            $log_v = $olm->find_by_view(array('id'=>$id));
                            $n['log_id'] = $id;
                            $n['from_log'] = 1;
//                            $n['received_by'] = _sess('uid');
//                            $n['with_manager'] = 1;
                            $n['title'] = $this->_format_log($log_v,$t['title'],true);
                            $n['content'] = $this->_format_log($log_v,$t['content'],true);
                            $n['order_id'] = $new_data['id'];

                            //发给创建者
                            if($t['notice_created_by']){
                                if(is_null($old_data)){
                                    $n['received_by'] = $new_data['created_by'];
                                }else{
                                    $n['received_by'] = $old_data['created_by'];
                                }
                                $notice_id = $nm->insert($n);
                                if(!$notice_id){
                                    $this->db->trans_rollback();
                                    return false;
                                }
                            }//if($t['notice_created_by']){

                            //发给责任人
                            if($t['notice_manager']){
                                //判断老责任人
                                if(!is_null($old_data)){
                                    if($old_data['manager_id']){
                                        $n['received_by'] = $old_data['manager_id'];
                                        if(!$nm->insert($n)){
                                            $this->db->trans_rollback();
                                            return false;
                                        }
                                    }
                                }
                                //判断新责任人
                                if($new_data['manager_id']){
                                    $n['received_by'] = $new_data['manager_id'];
                                    if(!$nm->insert($n)){
                                        $this->db->trans_rollback();
                                        return false;
                                    }
                                }

                            }//if($t['notice_manager']){

                            //默认发送的角色
                            if($t['default_role_id']){
                                $this->load->model('user_role_model');
                                $urm = new User_role_model();
                                $users = $urm->find_all_by_view(array('role_id'=>$t['default_role_id'],'inactive_flag'=>0));
                                foreach($users as $u){
                                    $n['received_by'] = $u['user_id'];
                                    if(!$nm->insert($n)){
                                        $this->db->trans_rollback();
                                        return false;
                                    }
                                }

                            }//if($t['default_role_id']){

                            //是否需要原因
                            if($t['need_reason_flag']){
                                $need_reason = $t['need_reason_flag'];
                            }

                        }// if($t['notice_flag'] && $t['when_new_value']
                    }//if(!$id){
                }
            }
        }
        if($need_reason){
            //如果需要填写原因，则直接跳转的原因补充页
            dialog(_url('order','change_reason',array('change_hash'=>$change_hash)),label('need_reason'));
        }
        $this->send_mails_by_change_hash($change_hash);

        return true;

    }
    //发送邮件给相关人员
    function send_mails_by_change_hash($change_hash){
        //判断是否同时通过邮件收取通知
        $this->load->model('user_model');
        $um = new User_model();
        $olm = new Order_log_model();
        $nm = new Notice_model();
        $logs = $olm->find_all_by(array('change_hash'=>$change_hash));
        if(!empty($logs)){
            foreach($logs as $log){
                $notices = $nm->find_all_by(array('log_id' =>$log['id'],'from_log'=>1));
                if(!empty($notices)){
                    foreach($notices as $n){
                        $user = $um->find_by(array('id'=>$n['received_by'],'inactive'=>0,'email_flag'=>1,'email'=>'is not null'));
                        if(!empty($user)){
                            $content = $this->load->view('notice_mail',$n,true);
                            send_mail($user['email'],$n['title'],$content);
                        }
                    }
                }
            }
        }
    }

    function do_update($order_id,$data){
        $order = $this->find($order_id);
        $this->db->trans_begin();
        if($this->update($order_id,$data,true)){
            return $this->add_logs('update',$data,$order);
        }else{
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

    function _format_log($log,$field,$full_text = FALSE){
        $vm = new Valuelist_model();
        $content =  str_replace('&order_id',$log['order_id'],$field);
        if(!is_null($log['field_valuelist_id'])){
            $vl = $vm->find($log['field_valuelist_id']);
            if(!empty($vl)){
                $content =  str_replace('&new_value',get_label($vl['valuelist_name'],$log['new_value']),$content);
                $content =  str_replace('&old_value',get_label($vl['valuelist_name'],$log['old_value']),$content);
            }else{
                $content =  str_replace('&new_value',_f($log['field_name'],$log['new_value'],$full_text),$content);
                $content =  str_replace('&old_value',_f($log['field_name'],$log['old_value'],$full_text),$content);
            }
        }else{
            $content =  str_replace('&new_value',_f($log['field_name'],$log['new_value'],$full_text),$content);
            $content =  str_replace('&old_value',_f($log['field_name'],$log['old_value'],$full_text),$content);
        }
        return $content;
    }

    function field_list(){
        return lazy_get_data("select COLUMN_NAME as value,COLUMN_COMMENT as label from INFORMATION_SCHEMA.COLUMNS
        where TABLE_SCHEMA = 'CTS' AND  table_name = 'CT_ORDERS'
        and COLUMN_NAME not in ('id','created_by','creation_date','last_updated_by','last_update_date')");
    }


}
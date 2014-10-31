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

    function find_my_orders($order_type,$title,$status,$end = null,$start = 0){
        $this->load->model('auth_model');
        $om = new Order_model();
        $sm = new Status_model();
        $olm = new Order_log_model();
        $am = new Auth_model();

        if($order_type){
            $types = array($order_type);
        }else{
            $types = $am->can_show_order_types();
        }

        $totalCnt = 0;

        //获取数据
        if($am->check_auth('only_mine_control',array('ao_true_or_false'=>'TRUE'))){
            //与自己相关的用户id字段
            $this->db->where('(created_by = '._sess('uid').' OR leader_id = '._sess('uid').' OR manager_id = '._sess('uid').')');

            //获取允许查看的订单类型
            $this->db->where_in('order_type',$types);

            //fix ：Error in Body._buildRowContent: Row is not in cache
            if($title){
                $this->db->like('title',$title);
            }
            if($status){
                $this->db->where('status',$status) ;
            }
            $totalCnt = $om->count_by();

            //分页显示
            if(!is_null($end)){
                $om->limit($end+1,$start);
            }

            $om->order_by('id','DESC');

            //与自己相关的用户id字段
            $this->db->where('(created_by = '._sess('uid').' OR leader_id = '._sess('uid').' OR manager_id = '._sess('uid').')');

            //获取允许查看的订单类型
            $this->db->where_in('order_type',$types);

            //fix ：Error in Body._buildRowContent: Row is not in cache
            if($title){
                $this->db->like('title',$title);
            }
            if($status){
                $this->db->where('status',$status) ;
            }

            $os = $om->find_all();
        }else{
            //分页显示
            if(!is_null($end)){
                $om->limit($end+1,$start);
            }

            if($title){
                $this->db->like('title',$title);
            }

            if($status){
                $this->db->where('status',$status) ;
            }

            //获取允许查看的订单类型
            $this->db->where_in('order_type',$types);
            $om->order_by('id','DESC');
            $os = $om->find_all();

            if($title){
                $this->db->like('title',$title);
            }
            if($status){
                $this->db->where('status',$status) ;
            }
            //获取允许查看的订单类型
            $this->db->where_in('order_type',$types);
            $totalCnt = $om->count_by();
        }

        $os = _format($os,true);
        for($i=0;$i<count($os);$i++){
            $os[$i]['category'] = get_label('vl_order_category',$os[$i]['category'],$os[$i]['order_type']);
            $os[$i]['status'] = $sm->get_label(default_value('status',$os[$i]['order_type']),$os[$i]['status']);
            $os[$i]['severity'] = get_label('vl_severity',$os[$i]['severity']);
            $os[$i]['content'] = word_truncate(t($om->first_content($os[$i]['id'])),10);
            $os[$i]['managed_by'] = $os[$i]['manager_id'];
            $os[$i]['delay_flag'] = 0;
            if(!is_null($os[$i]['plan_complete_date']) && $os[$i]['plan_complete_date'] < time()){
                $os[$i]['delay_flag'] = 1;
            }
            $os[$i]['plan_date_count'] = $olm->count_by_view(array('field_name'=>'plan_complete_date','dll_type'=>'update'));
            $os[$i]['order_type'] = get_label('vl_order_type',$os[$i]['order_type']);
        }

        $data["identifier"] = 'id';
        $data["label"] = 'title';
        $data['items'] = $os;
        $output['data'] = $data;
        $output['cnt'] = $totalCnt;
        return $output;
    }

    function default_status($order_type){
        $sm = new Status_model();
        return $sm->default_status(default_value('status',$order_type));
    }

    function next_status($order_type,$current_status){
        $sm = new Status_model();
        return $sm->next_status(default_value('status',$order_type),$current_status);
    }

    function do_next($order){
        $sm = new Status_model();
        $next_status = $sm->do_next($order['id'],default_value('status',$order['order_type']),$order['status']);
        if($next_status){
            echo $next_status;
//            if($this->do_update($order['id'],array('status'=>$next_status))){
//                message_db_success();
//            }else{
//                message_db_failure();
//            }
        }
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
    function is_allow_next_status($order_type,$current_status,$next_status){
        $sm = new Status_model();
        return $sm->is_allow_next_status(default_value('status',$order_type),$current_status,$next_status);
    }

    //新建
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
        $this->load->model('notice_rule_model');
        $this->load->model('function_model');
        $nrm = new Notice_rule_model();
        $nm = new Notice_model();
        $oltm = new Order_log_type_model();
        $olm = new Order_log_model();
        $fm = new Function_model();
        $need_reason = 0;
        $change_hash = time();
        $log['change_hash'] = $change_hash;
        //调优：先记录状态信息
        $this->db->order_by('id','DESC');
        $ltypes = $oltm->find_all_by(array('dll_type'=>$dll_type));
        if(!empty($ltypes)){
            foreach($ltypes as $t){
                if(isset($new_data[$t['field_name']])){
                    //如果数据无变更则无需记录
                    if(is_null($old_data) || $new_data[$t['field_name']] != $old_data[$t['field_name']]){
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
                            return false;
                        }else{
                            $rules = $nrm->find_all_by(array('log_type_id'=>$t['id'],'inactive_flag'=>0));
                            if(!empty($rules)){
                                foreach($rules as $rule){
                                    $order = $this->find($new_data['id']);

                                    //是否存在投诉单类型控制
                                    if($rule['order_type'] == _config('all_values') || $rule['order_type'] == $order['order_type']){

                                        if($rule['when_new_value'] == _config('all_values')){
                                            $rule['when_new_value'] = $log['new_value'];
                                        }

                                        if($rule['when_old_value'] == _config('all_values')){
                                            $rule['when_old_value'] = $log['old_value'];
                                        }

                                        if($rule['when_new_value'] == $log['new_value'] && $rule['when_old_value'] == $log['old_value']){

                                            $log_v = $olm->find_by_view(array('id'=>$id));
                                            $n['log_id'] = $id;
                                            $n['from_log'] = 1;
//                            $n['received_by'] = _sess('uid');
//                            $n['with_manager'] = 1;
                                            $n['title'] = $this->_format_log($log_v,$order['order_type'],$t['title'],true);
                                            $n['content'] = $this->_format_log($log_v,$order['order_type'],$t['content'],true);
                                            $n['order_id'] = $new_data['id'];

                                            //如果存在触发器的功能点，则获取功能点，参数为id=&order_id
                                            $fn = $fm->find($rule['function_id']);
                                            if(!empty($fn)){
                                                $n['direct_url'] = $fn['controller'].'/'.$fn['action'].'?id='.$new_data['id'];
                                            }

                                            //发给创建者
                                            if($rule['notice_created_by']){
                                                if(is_null($old_data)){
                                                    $n['received_by'] = $new_data['created_by'];
                                                }else{
                                                    $n['received_by'] = $old_data['created_by'];
                                                }
                                                $notice_id = $nm->insert($n);
                                                if(!$notice_id){
                                                    return false;
                                                }
                                            }//if($t['notice_created_by']){

                                            //发给责任人
                                            if($rule['notice_leader']){
                                                //判断老责任人
                                                if(!is_null($old_data)){
                                                    if(isset($old_data['leader_id'])){
                                                        $n['received_by'] = $old_data['leader_id'];
                                                        if(!$nm->insert($n)){
                                                            return false;
                                                        }
                                                    }
                                                }
                                                //判断新责任人
                                                if(isset($new_data['leader_id'])){
                                                    $n['received_by'] = $new_data['leader_id'];
                                                    if(!$nm->insert($n)){
                                                        return false;
                                                    }
                                                }

                                            }

                                            //发给处理人
                                            if($rule['notice_manager']){
                                                //判断老处理人
                                                if(!is_null($old_data)){
                                                    if(isset($old_data['manager_id'])){
                                                        $n['received_by'] = $old_data['manager_id'];
                                                        if(!$nm->insert($n)){
                                                            return false;
                                                        }
                                                    }
                                                }
                                                //判断新处理人
                                                if(isset($new_data['manager_id'])){
                                                    $n['received_by'] = $new_data['manager_id'];
                                                    if(!$nm->insert($n)){
                                                        return false;
                                                    }
                                                }

                                            }//if($t['notice_manager']){

                                            //默认发送的角色
                                            if($rule['default_role_id']){
                                                $this->load->model('user_role_model');
                                                $urm = new User_role_model();
                                                $users = $urm->find_all_by_view(array('role_id'=>$rule['default_role_id'],'inactive_flag'=>0));
                                                foreach($users as $u){
                                                    $n['received_by'] = $u['user_id'];
                                                    if(!$nm->insert($n)){
                                                        return false;
                                                    }
                                                }

                                            }//if($t['default_role_id']){
                                        }
                                    }
                                }
                            }
                            //如果初始为空值，则第一次变更不记录原因
                            if($t['need_reason_flag'] && $log['old_value']){
                                $need_reason = $t['need_reason_flag'];
                            }
                        }

                    } //判断有无变化
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
                        $receive_email = _user_config('receive_email',$n['received_by']);
                        if($receive_email){
                            $user = $um->find_by(array('id'=>$n['received_by'],'inactive_flag'=>0));
                            if(!empty($user) && !is_null($user['email']) && $user['email'] != ''){
                                $content = $this->load->view('notice_mail',$n,true);
                                send_mail($user['email'],$n['title'],$content);
                            }
                        }
                    }
                }
            }
        }
    }

    function send_mail_by_notice($notice_id){
        $this->load->model('user_model');
        $um = new User_model();
        $nm = new Notice_model();
        $notice = $nm->find($notice_id);
        if(!empty($notice)){
            $user = $um->find_by(array('id'=>$notice['received_by'],'inactive_flag'=>0,'email_flag'=>1));
            if(!empty($user) && !is_null($user['email']) && $user['email'] != ''){
                $content = $this->load->view('notice_mail',$notice,true);
                send_mail($user['email'],$notice['title'],$content);
            }
        }

    }

    //更新
    function do_update($order_id,$data){
        $order = $this->find($order_id);
        $this->db->trans_begin();
        if($this->update($order_id,$data,true)){
            $data['id'] = $order_id;
            $rs = $this->add_logs('update',$data,$order);
            if($rs){
                $this->db->trans_commit();
                return true;
            }else{
                $this->db->trans_rollback();
                return false;
            }
        }else{
            $this->db->trans_rollback();
            return false;
        }

    }

    function logs($order_id){
        $order = $this->find($order_id);
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
                    $logs[$i]['content'] = $this->_format_log($logs[$i],$order['order_type'],$logs[$i]['content']);
                    array_push($return,$logs[$i]);
                }
//                $logs[$i]['content'] = $this->_format_log($logs[$i],$logs[$i]['content']);
            }
            return $return;
        }
    }

    function _format_log($log,$order_type,$field,$full_text = FALSE){
        $vm = new Valuelist_model();
        $sm = new Status_model();
        $content =  str_replace('&order_id',$log['order_id'],$field);
        //投诉单状态根据类型不同解释不同
        if($log['field_name'] == 'status'){
            $content =  str_replace('&new_value',$sm->get_label(default_value('status',$order_type),$log['new_value']),$content);
            $content =  str_replace('&old_value',$sm->get_label(default_value('status',$order_type),$log['old_value']),$content);
        }else{
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
        }

        return $content;
    }

    function confirm($id){
        $order = $this->find($id);
        //先判断订单状态流是否允许更改,判断是否有权限更改次状态
        if(is_order_allow_next_status($order['order_type'],$order['status'],'confirmed')
            && check_order_auth($order['order_type'],'confirmed',$order['category'])){
            if($this->do_update($order['id'],array('status'=>'confirmed'))){
                message_db_success();
                if(_config('auto_leader')){
                    //判断责任人如果唯一，则直接赋值
                    $this->load->model('auth_model');
                    $am = new Auth_model();
                    $leaders = $am->can_choose_leaders($order);
                    if(count($leaders) == 1){
                        $d['leader_id'] = $leaders[0];
                        if($this->do_update($order['id'],$d)){
                            custz_message('I','已自动选择选择唯一的责任人');
                            if(_config('auto_manager')){
                                //如果处理人也只有唯一时，则投诉单直接分配
                                $managers = $am->can_choose_managers($order);
                                if(count($managers) == 1) {
                                    $dd['status'] = 'allocated';
                                    $dd['manager_id'] = $managers[0];
                                    if ($this->do_update($order['id'], $dd)) {
                                        custz_message('I', '已自动选择唯一的处理人');
                                    } else {
                                        message_db_failure();
                                    }
                                }
                            }
                        }
                    }
                }

            }else{
                message_db_failure();
            }
        }else{
            custz_message('E','不允许状态流向！');
        }
    }

    function field_list(){
        return lazy_get_data("select COLUMN_NAME as value,COLUMN_COMMENT as label from INFORMATION_SCHEMA.COLUMNS
        where TABLE_SCHEMA = 'CTS' AND  table_name = 'CT_ORDERS'
        and COLUMN_NAME not in ('id','created_by','creation_date','last_updated_by','last_update_date')");
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('status_line_model','line');
        $this->_table = 'status_header';
        $this->_view = 'status_header_v';

        $this->add_validate('status_code','required');
        $this->add_validate('description','required|max_length[255]');

        //设置钩子
        array_unshift($this->before_update,'before_update');

    }

    //获取状态默认值
    function default_status($status_code){
        $slm = new Status_line_model();
        $row = $slm->find_by_view(array('status_code'=>$status_code,'initial_flag'=>1,'inactive_flag'=>0));
        if(empty($row)){
            return null;
        }else{
            return $row['step_value'];
        }
    }

    //往下一步,返回下一步状态码
    function validate_next($order_id,$status_code,$current_status,$next_status = null){
        $slm = new Status_line_model();
        //默认下一步
        if(is_null($next_status)){
            $next_status = $this->next_status($status_code,$current_status);
        }else {
            //验证是否在下一步范围之内
            if ($this->is_allow_next_status($status_code, $current_status, $next_status)) {
                $line = $slm->find_by_view(array('status_code' => $status_code, 'step_value' => $next_status, 'inactive_flag' => 0));
                if (!empty($line)) {
                    $this->load->model('status_condition_group_model');
                    $this->load->model('auth_model');
                    $this->load->model('status_authobject_model');
                    $this->load->model('status_authobj_line_model');
                    $this->load->model('status_condition_model');
                    $scm = new Status_condition_model();
                    $scgm = new Status_condition_group_model();
                    $am = new Auth_model();
                    $sam = new Status_authobject_model();
                    $salm = new Status_authobj_line_model();
                    $groups = $scgm->find_all_by(array('status_line_id' => $line['id']));
                    $condition_pass = false;

                    foreach ($groups as $g) {
                        $pass = true;
                        //是否拥有操作权限:权限对象
                        $objects = $sam->find_all_by_view(array('group_id' => $g['id']));
                        foreach ($objects as $o) {
                            if ($pass) {
                                $ols = $salm->find_all_by_view(array('status_obj_id' => $o['id']));
                                $auth_items = null;
                                foreach ($ols as $ol) {
                                    $auth_items[$ol['auth_item_name']] = $ol['auth_value'];
                                }
                                if (!is_null($auth_items)) {
                                    if (!$am->check_auth($o['object_name'], $auth_items)) {
                                        $pass = false;
                                    }
                                }
                            } else {
                                break;
                            }
                        }
                        if (!$pass) {
                            //break foreach
                            continue;
                        } else {

                            //验证是否满足条件

                            $conditions = $scm->find_all_by(array('group_id' => $g['id']));
                            foreach ($conditions as $c) {
                                if ($c['and_or'] == 'AND') {
                                    //运算公式转换
                                    switch ($c['operation']) {
                                        case 'EQ':
                                            $this->db->where($c['field_name'], $c['target_value']);
                                            break;
                                        case 'NE':
                                            $this->db->where($c['field_name'] . ' != ', $c['target_value']);
                                            break;
                                        case 'IN' :
                                            $this->db->where_in($c['field_name'], explode(',', $c['target_value']));
                                            break;
                                        case 'NOT_IN' :
                                            $this->db->where_not_in($c['field_name'], explode(',', $c['target_value']));
                                            break;
                                        case 'GT' :
                                            $this->db->where($c['field_name'] . ' > ', $c['target_value']);
                                            break;
                                        case 'GE' :
                                            $this->db->where($c['field_name'] . ' >= ', $c['target_value']);
                                            break;
                                        case 'LT' :
                                            $this->db->where($c['field_name'] . ' < ', $c['target_value']);
                                            break;
                                        case 'LE' :
                                            $this->db->where($c['field_name'] . ' <= ', $c['target_value']);
                                            break;
                                        case 'HE' :
                                            $this->db->like($c['field_name'], $c['target_value'], 'after');
                                            break;
                                        case 'HNE' :
                                            $this->db->not_like($c['field_name'], $c['target_value'], 'after');
                                            break;
                                        case 'TE' :
                                            $this->db->like($c['field_name'], $c['target_value'], 'before');
                                            break;
                                        case 'TNE' :
                                            $this->db->not_like($c['field_name'], $c['target_value'], 'before');
                                            break;
                                        case 'LIKE' :
                                            $this->db->like($c['field_name'], $c['target_value']);
                                            break;
                                        case 'NOT_LIKE' :
                                            $this->db->not_like($c['field_name'], $c['target_value']);
                                            break;
                                    }//switch
                                } else {
                                    //运算公式转换
                                    switch ($c['operation']) {
                                        case 'EQ':
                                            $this->db->or_where($c['field_name'], $c['target_value']);
                                            break;
                                        case 'NE':
                                            $this->db->or_where($c['field_name'] . ' != ', $c['target_value']);
                                            break;
                                        case 'IN' :
                                            $this->db->or_where_in($c['field_name'], explode(',', $c['target_value']));
                                            break;
                                        case 'NOT_IN' :
                                            $this->db->or_where_not_in($c['field_name'], explode(',', $c['target_value']));
                                            break;
                                        case 'GT' :
                                            $this->db->or_where($c['field_name'] . ' > ', $c['target_value']);
                                            break;
                                        case 'GE' :
                                            $this->db->or_where($c['field_name'] . ' >= ', $c['target_value']);
                                            break;
                                        case 'LT' :
                                            $this->db->or_where($c['field_name'] . ' < ', $c['target_value']);
                                            break;
                                        case 'LE' :
                                            $this->db->or_where($c['field_name'] . ' <= ', $c['target_value']);
                                            break;
                                        case 'HE' :
                                            $this->db->or_like($c['field_name'], $c['target_value'], 'after');
                                            break;
                                        case 'HNE' :
                                            $this->db->or_not_like($c['field_name'], $c['target_value'], 'after');
                                            break;
                                        case 'TE' :
                                            $this->db->or_like($c['field_name'], $c['target_value'], 'before');
                                            break;
                                        case 'TNE' :
                                            $this->db->or_not_like($c['field_name'], $c['target_value'], 'before');
                                            break;
                                        case 'LIKE' :
                                            $this->db->or_like($c['field_name'], $c['target_value']);
                                            break;
                                        case 'NOT_LIKE' :
                                            $this->db->or_not_like($c['field_name'], $c['target_value']);
                                            break;
                                    }//switch
                                }//if

                            }//foreach
                            $this->db->where('id', $order_id);
//                    $rows = $this->db->get($line['table_name']);
//                    print_r($rows);
                            if ($this->db->count_all_results($line['table_name']) ==  0) {
                                continue;
                            }else{
                                $condition_pass = true;
                                break;
                            }
                        }

                    }//foreach

                    if($condition_pass){
                        return $next_status;
                    }else{
                        custz_message('E', '无法进行下一步！');
                    }

                } else {
                    custz_message('E', '未知错误');
                    return false;
                }
            } else {
                custz_message('W', '无法进行下一步，可能为最终步骤');
                return false;
            }
        }//if(is_null($next_status)){
    }

    //下一步
    function next_status($status_code,$current_status){
        $slm = new Status_line_model();
        $row = $slm->find_by_view(array('status_code'=>$status_code,'step_value'=>$current_status,'inactive_flag'=>0));
        if(empty($row)){
            return null;
        }else{
            //判断是否为最终步骤
            if($row['last_step_flag']){
                return null;
            }else{
                //判断是否是自动完成，如果是自动完成则下一步为ending，否则为默认下一步
                if($row['auto_ending_flag']){
                    return $this->last_status($status_code);
                }
                $l = $slm->find_by_view(array('status_code'=>$status_code,'step'=>$row['default_next_step'],'inactive_flag'=>0));
                if(empty($l)){
                    return null;
                }else{
                    //如果下一步为自动完成
                    if($row['auto_ending_flag']){
                        return $this->last_status($status_code);
                    }else{
                        return $l['step_value'];
                    }
                }
            }
        }
    }

    //最终步骤
    function last_status($status_code){
        $slm = new Status_line_model();
        $last = $slm->find_by_view(array('status_code'=>$status_code,'last_step_flag'=>1,'inactive_flag'=>0));
        if(!empty($last)){
            return $last['step_value'];
        }else{
            return null;
        }
    }

    function get_label($status_code,$value){
        $slm = new Status_line_model();
        $row = $slm->find_by_view(array('status_code'=>$status_code,'step_value'=>$value));
        if(empty($row)){
            return null;
        }else{
            return $row['step_desc'];
        }
    }

    //是否允许下一步
    function is_allow_next_status($status_code,$current_status,$next_status){
        $slm = new Status_line_model();
        $line = $slm->find_by_view(array('status_code'=>$status_code,'step_value'=>$current_status,'inactive_flag'=>0));
        $line2 = $slm->find_by_view(array('status_code'=>$status_code,'step_value'=>$next_status,'inactive_flag'=>0));
        if(!empty($line) && !empty($line2)){
            if(is_null($line['next_steps'])){
                return false;
            }else{
                $allow_status =  explode(',',$line['next_steps']);
                return in_array($line2['step'],$allow_status);
            }
        }else{
            return false;
        }
    }

    //撤销时退回至
    function callback($status_code,$segment_value){
        $slm = new Status_line_model();
        $line = $slm->find_by_view(array('status_code'=>$status_code,'step_value'=>$segment_value,'inactive_flag'=>0));
        if(empty($line)){
            return null;
        }else{
            $cb = $slm->find_by_view(array('status_code'=>$status_code,'step'=>$line['callback_step'],'inactive_flag'=>0));
            if(empty($cb)){
                return null;
            }else{
                return $cb['setp_value'];
            }

        }
    }

    //状态列表
    function options($status_codes){
        $slm = new Status_line_model();
        $this->db->distinct();
        $this->db->select('step_value as value,step_desc as label');
        $this->db->where_in('status_code',$status_codes);
        $lines = $slm->find_all_by_view(array('inactive_flag'=>0));
        return $lines;
    }

    function before_update($data){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
        return $data;
    }
}
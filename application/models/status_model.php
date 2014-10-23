<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('status_line_model','line');
    }

    //获取状态默认值
    function default_status($status_code){
        $slm = new Status_line_model();
        $row = $slm->find_by_view(array('status_code'=>$status_code,'default_flag'=>1,'inactive_flag'=>0));
        if(empty($row)){
            return null;
        }else{
            return $row['segment_value'];
        }
    }

    function next_status($status_code,$current_status){
        $slm = new Status_line_model();
        $row = $slm->find_by_view(array('status_code'=>$status_code,'segment_value'=>$current_status,'inactive_flag'=>0));
        if(empty($row)){
            return null;
        }else{
            //判断是否是自动完成，如果是自动完成则下一步为ending，否则为默认下一步
            if($row['auto_ending_flag']){
                $last = $slm->find_by_view(array('status_code'=>$status_code,'last_status_flag'=>1,'inactive_flag'=>0));
                if(!empty($last)){
                    return $last['segment_value'];
                }
            }
            $l = $slm->find_by(array('status_code'=>$status_code,'segment'=>$row['default_next_status'],'inactive_flag'=>0));
            if(empty($l)){
                return null;
            }else{
                return $l['segment_value'];
            }
        }
    }

    function get_label($status_code,$value){
        $slm = new Status_line_model();
        $row = $slm->find_by_view(array('status_code'=>$status_code,'segment_value'=>$value));
        if(empty($row)){
            return null;
        }else{
            return $row['segment_desc'];
        }
    }

    //是否允许下一步
    function is_allow_next_status($status_code,$current_status,$next_status){
        $slm = new Status_line_model();
        $line = $slm->find_by_view(array('status_code'=>$status_code,'segment_value'=>$current_status,'inactive_flag'=>0));
        $line2 = $slm->find_by_view(array('status_code'=>$status_code,'segment_value'=>$next_status,'inactive_flag'=>0));
        if(!empty($line) && !empty($line2)){
            if(is_null($line['next_status'])){
                return false;
            }else{
                $allow_status =  explode(',',$line['next_status']);
                return in_array($line2['segment'],$allow_status);
            }
        }else{
            return false;
        }
    }

    //撤销时退回至
    function callback($status_code,$segment_value){
        $slm = new Status_line_model();
        $line = $slm->find_by_view(array('status_code'=>$status_code,'segment_value'=>$segment_value,'inactive_flag'=>0));
        if(empty($line)){
            return null;
        }else{
            return $line['back_status'];
        }
    }

    //状态列表
    function options($status_codes){
        $slm = new Status_line_model();
        $this->db->distinct();
        $this->db->select('segment_value,segment_desc');
        $this->db->where_in('status_code',$status_codes);
        $lines = $slm->find_all_by_view(array('inactive_flag'=>0));
        return $lines;
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('status_line_model','line');
    }

    //获取状态默认值
    function default_status($status_code){
        $row = $this->line->find_by(array('status_code'=>$status_code,'default_flag'=>1));
        if(empty($row)){
            return null;
        }else{
            return $row['segment_value'];
        }
    }

    function get_label($order_status,$value){
        $line = first_row($this->db->get_where('status_lines_v',array('status_code'=>$order_status,'segment_value'=>$value)));
        if(is_null($line)){
            return null;
        }else{
            return $line['segment_desc'];
        }
    }

    //是否允许下一步
    function is_allow_next_status($status_code,$current_status,$next_status){
        $slm = new Status_line_model();
        $line = $slm->find_by(array('status_code'=>$status_code,'segment_value'=>$current_status));
        $line2 = $slm->find_by(array('status_code'=>$status_code,'segment_value'=>$next_status));
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
        $line = $this->line->find_by(array('status_code'=>$status_code,'segment_value'=>$segment_value));
        if(empty($line)){
            return null;
        }else{
            return $line['back_status'];
        }
    }
}
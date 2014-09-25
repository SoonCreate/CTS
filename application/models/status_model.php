<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function find($id){
        return $this->db->get_where('status_header',array('id'=>$id));
    }

    function find_line($id){
        return $this->db->get_where('status_lines',array('id'=>$id));
    }

    function find_by_code($status_code){
        return $this->db->get_where('status_header',array('status_code'=>$status_code));
    }

    //获取状态默认值
    function default_status($status_code){
        $header = first_row($this->find_by_code($status_code));
        if(is_null($header)){
            return null;
        }else{
            $row = first_row($this->db->get_where('status_lines',array('status_id' => $header['id'],'default_flag' => 1)));
            if(is_null($row)){
                return null;
            }else{
                return $row['segment_value'];
            }
        }
    }

    function find_status_line_by_segment_value($status_code,$segment_value){
        $header = first_row($this->find_by_code($status_code));
        if(is_null($header)){
            return null;
        }else{
            return first_row($this->db->get_where('status_lines',array('status_id' => $header['id'],'segment_value' => $segment_value)));
        }
    }

    //是否允许下一步
    function is_allow_next_status($status_code,$current_status,$next_status){
        $line = $this->find_status_line_by_segment_value($status_code,$current_status);
        $line2 = $this->find_status_line_by_segment_value($status_code,$next_status);
        if(!is_null($line) && !is_null($line2)){
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
        $line = $this->find_status_line_by_segment_value($status_code,$segment_value);
        if(is_null($line)){
            return null;
        }else{
            return $line['back_status'];
        }
    }
}
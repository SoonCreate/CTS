<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Valuelist_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table = 'valuelist_header';
        $this->load->model('valuelist_line_model','vline');
        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }

    function find_lines_by_parent_segment($valuelist_id,$parent_segment,$inactive_flag = null){
        $vlm = new Valuelist_line_model();
        if(is_null($inactive_flag)){
            return $vlm->find_all_by(array('valuelist_id' => $valuelist_id,'parent_segment_value'=>$parent_segment));
        }else{
            return $vlm->find_all_by(array('valuelist_id' => $valuelist_id,'parent_segment_value'=>$parent_segment,'inactive_flag'=>$inactive_flag));
        }

    }

    function find_active_options($valuelist_name){
        return $this->_get_options($this->find_by(array('valuelist_name'=>$valuelist_name)),0);
    }

    function find_all_options($valuelist_name){
        return $this->_get_options($this->find_by(array('valuelist_name'=>$valuelist_name)));
    }

    function find_all_children_options($child_valuelist_name,$parent_segment){
        $me = $this->find_by(array('valuelist_name'=>$child_valuelist_name));
        if(!empty($me)){
            return $this->_options($this->find_lines_by_parent_segment($me['id'],$parent_segment));
        }else{
            return array();
        }
    }

    function find_active_children_options($child_valuelist_name,$parent_segment){
        $me = $this->find_by(array('valuelist_name'=>$child_valuelist_name));
        if(!empty($me)){
            return $this->_options($this->find_lines_by_parent_segment($me['id'],$parent_segment,0));
        }else{
            return array();
        }
    }

    function _options($lines){
        $return = array();
        if(!empty($lines)){
            foreach($lines as $l){
                $o['value'] = $l['segment_value'];
                $o['label'] = $l['segment_desc'];
                array_push($return,$o);
            }
        }
        return $return;
    }

    //重构函数,return object
    function _get_options($header,$inactive_flag = null){
        $rs = null;
        if(!empty($header)){

            if($header['from_obj'] == 1){
                //由对象创建
                $this->db->select($header['value_fieldname'].' as value,'.$header['label_fieldname'].' as label');
                $this->db->from($header['source_view']);
                //如果条件不为空
                if($header['condition'] != ""){
                    $this->db->where($header['condition']);
                }
                $rs = $this->db->get();
            }else{
                //由值列表创建
                $this->db->select('segment_value as value,segment_desc as label');
                $this->db->from('valuelist_lines');
                $this->db->where('valuelist_id',$header['id']);
                if(!is_null($inactive_flag)){
                    $this->db->where('inactive_flag',$inactive_flag);
                }
                $this->db->order_by('sort');
                $rs = $this->db->get();
            }
        }
        return $rs;
    }

    function find_value_by_segment($valuelist_name,$segment){
        $row = $this->vline->find_by(array('valuelist_name'=>$valuelist_name,'segment'=>$segment));
        if(empty($row)){
            return $row['segment_value'];
        }else{
            return null;
        }
    }

    function before_insert($data){
       return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }

}
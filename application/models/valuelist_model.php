<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Valuelist_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table = 'valuelist_header';
        $this->load->model('valuelist_line_model');
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

            if($header['object_flag'] == 1){
                //由对象创建
                $this->db->select($header['value_fieldname'].' as value,'.$header['label_fieldname'].' as label,ABS(0) as inactive_flag');
                $this->db->from($header['source_view']);
                //如果条件不为空
                if($header['condition'] != ""){
                    $this->db->where($header['condition']);
                }
                $this->db->order_by('value');
                $rs = $this->db->get();
            }else{
                //由值列表创建
                $this->db->select('segment_value as value,segment_desc as label,inactive_flag');
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
        $vlm = new Valuelist_line_model();
        $row = $vlm->find_by(array('valuelist_name'=>$valuelist_name,'segment'=>$segment));
        if(empty($row)){
            return $row['segment_value'];
        }else{
            return null;
        }
    }

    //两种方式保存时验证内容不同
    function save_from_object($data){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('object_flag','required|numeric');
        $this->add_validate('label_fieldname','required|alpha_dash');
        $this->add_validate('value_fieldname','required|alpha_dash');
        $this->add_validate('source_view','required|alpha_dash');
        if(!isset($data['id'])){
            //insert
            $this->add_validate('valuelist_name','required|max_length[20]|min_length[5]|is_unique[valuelist_header.valuelist_name]|alpha_dash');
            return $this->insert($data);
        }else{
            return $this->update($data['id'],$data);
        }

    }

    function save_normal($data){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
        if(!isset($data['id'])){
            //insert
            $this->add_validate('valuelist_name','required|max_length[20]|min_length[5]|is_unique[valuelist_header.valuelist_name]|alpha_dash');
            return $this->insert($data);
        }else{
            return $this->update($data['id'],$data);
        }
    }
}
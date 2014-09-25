<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Valuelist_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function find($id){
        return $this->db->get_where('valuelist_header',array('id'=>$id));
    }

    function find_by_name($name){
        return $this->db->get_where('valuelist_header',array('valuelist_name'=>$name));
    }

    function find_line($name,$segment_value){
        $h = first_row($this->find_by_name($name));
        if(is_null($h)){
            return array();
        }else{
            return $this->db->get_where('valuelist_lines',array('valuelist_id'=>$h['id'],'segment_value'=>$segment_value));
        }
    }

    function find_lines_by_parent_line_id($valuelist_id,$parent_line_id,$inactive_flag = null){
        if(is_null($inactive_flag)){
            return $this->db->get_where('valuelist_lines',array('valuelist_id' => $valuelist_id,'parent_line_id'=>$parent_line_id));
        }else{
            return $this->db->get_where('valuelist_lines',
                array('valuelist_id' => $valuelist_id,
                    'parent_line_id'=>$parent_line_id,
                    'inactive_flag'=>$inactive_flag));
        }

    }

    function find_active_options($name){
        $header = first_row($this->db->get_where('valuelist_header',array('valuelist_name'=>$name)));
        return $this->_get_options($header,0);
    }

    function find_all_options($name){
        $header = first_row($this->db->get_where('valuelist_header',array('valuelist_name'=>$name)));
        return $this->_get_options($header);
    }

    function find_children_options($parent_name,$name,$segment_value){
        $l = first_row($this->find_line($parent_name,$segment_value));
        $me = first_row($this->find_by_name($name));
        if(!is_null($l) && !is_null($me)){
            return $this->find_lines_by_parent_line_id($me['id'],$l['parent_line_id']);
        }else{
            return array();
        }
    }

    //重构函数
    function _get_options($header,$inactive_flag = null){
        $rs = null;
        if(!is_null($header)){
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

    function insert($data){
        $data = set_creation_date($data);
        return $this->db->insert('valuelist_lines',$data);
    }
    function update($id,$data){
        $data = set_last_update($data);
        return $this->db->update('valuelist_lines', $data,array('id' => $id));
    }

}
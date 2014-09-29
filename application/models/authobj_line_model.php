<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authobj_line_model extends MY_Model{

    function __construct(){
        parent::__construct();

        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }

    function find_all_by_object_id_view($object_id){
        return $this->db->get_where($this->_table.'_v',array('object_id'=>$object_id))->result_array();
    }

    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }
    

}
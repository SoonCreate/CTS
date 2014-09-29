<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_module_line_model extends MY_Model{

    function __construct(){
        parent::__construct();

        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }

    function find_module_line_ids($role_id){
        $return = array();
        $rows = $this->find_all_by(array('role_id'=>$role_id));
        if(!empty($rows)){
            foreach($rows as $row){
                array_push($return,$row['module_line_id']);
            }
        }
        return $return;
    }

    function find_all_by_view($where){
        return $this->db->get_where($this->_table.'_v',$where)->result_array();
    }

    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }

}
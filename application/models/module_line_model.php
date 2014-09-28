<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_line_model extends MY_Model{

    function __construct(){
        parent::__construct();

        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }

    function find_function_ids($module_id){
        $return = array();
        $rows = $this->find_all_by(array('module_id'=>$module_id));
        if(!empty($rows)){
            foreach($rows as $row){
                array_push($return,$row['function_id']);
            }
        }
        return $return;
    }

    function find_module_ids($function_id){
        $return = array();
        $rows = $this->find_all_by(array('function_id'=>$function_id));
        if(!empty($rows)){
            foreach($rows as $row){
                array_push($return,$row['module_id']);
            }
        }
        return $return;
    }

    function find_all_from_view(){
        return $this->db->get('module_lines_v')->result_array();
    }


    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }
}
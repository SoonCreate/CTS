<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_line_model extends MY_Model{

    function __construct(){
        parent::__construct();
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

}
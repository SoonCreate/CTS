<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_module_line_model extends MY_Model{

    function __construct(){
        parent::__construct();
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
}
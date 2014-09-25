<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function find_value_by_name($config_name){
        $value = '';
        $row = first_row($this->db->get_where('configs',array('config_name'=>$config_name)));
        if(!is_null($row)){
            $value = $row['config_value'];
        }
        return $value;
    }

    function update($id,$data){
        $data = set_last_update($data);
        return $this->db->update('configs', $data,array('id' => $id));
    }

}
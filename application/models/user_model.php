<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }



    function insert($data){
        $data = set_creation_date($data);
        return $this->db->insert('users',$data);
    }

    function update($id,$data){
        $data = set_last_update($data);
        return $this->db->update('users', $data,array('id' => $id));
    }

}
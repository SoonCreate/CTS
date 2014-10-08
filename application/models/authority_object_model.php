<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authority_object_model extends MY_Model{

    function __construct(){
        parent::__construct();

        $this->add_validate('object_name','required|max_length[20]|is_unique[authority_objects.object_name]|alpha_dash');
        $this->add_validate('description','required|max_length[255]');

        //设置钩子
        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
        return $data;
    }


}
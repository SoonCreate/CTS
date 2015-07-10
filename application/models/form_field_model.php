<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_field_model extends MY_Model{

    function __construct(){
        parent::__construct();
        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->add_validate_255('label','default_value');
        $this->add_validate('field_size','numeric');
        return $data;
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_authobject_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_view = 'status_authobjects_v';
        $this->_table = 'status_authobjects';
    }

}
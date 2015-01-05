<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Variant_line_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->add_validate('segment_name','required');
        $this->add_validate('data_type','required');
    }

}
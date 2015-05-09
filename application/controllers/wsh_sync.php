<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wsh_sync extends CI_Controller {

	/**
	 * 微信微商户接口同步解决方案
	 */

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

    function goods_sync_job(){
        $erp_db = $this->load->database('erp',true,true);

    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
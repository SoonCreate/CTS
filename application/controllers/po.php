<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Po
 */
class Po extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->helper('saprfc');
    }

	public function me58()
	{

	}

    function me23n(){
        $po_number = v('po_number');
        if($_POST){
            $data['po_number'] = $po_number;
            redirect_to('po','me23n',$data);
        }else{
            if($po_number){
                $import['PURCHASEORDER'] = '4500043151';
                $export = array('PO_HEADER');
                $table['PO_ITEMS'] = array();
                $parameters = rfc_parameters($import,$export,$table);
                $data = callRFC("BAPI_PO_GETDETAIL",$parameters);
                print_r($data['PO_HEADER']);
                render_view('po/me23n_main',$data);
            }else{
                render_view('po/me23n_search');
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
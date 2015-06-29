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

    function test(){
        $this->load->library('sapclasses/sap');
        $sap = new SAPConnection();
        $sap->Connect(array(
            "ASHOST"=>"192.168.249.20"		// application server
        ,"SYSNR"=>"00"				// system number
        ,"CLIENT"=>"260"			// client
        ,"USER"=>"ybchenyy"			// user
        ,"PASSWD"=>"32560485617"		// password
//				,"language"=>"ZH"
//				,"own_codepage"=>"8400"
//				,"CODEPAGE"=>"1100"
//                ,"UNICODE"=>"1"
//                ,"dest"=>"phprfc_230"
//				,"partner_codepage"=>"8400"
        ))  ;
        if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
        if ($sap->GetStatus() != SAPRFC_OK ) {
            $sap->PrintStatus();
            exit;
        }

        $fce = &$sap->NewFunction ("SO_USER_LIST_READ");
        print_r($fce->GetDefinition());
        if ($fce == false ) {
            $sap->PrintStatus();
            exit;
        }

        $fce->USER_GENERIC_NAME = "*";
        $fce->Call();
        // $fce->Debug();

        if ($fce->GetStatus() == SAPRFC_OK) {
            echo "<table><tr><td>SAP-Name</td><td>User-Number</td></tr>";
            $fce->USER_DISPLAY_TAB->Reset();
            while ( $fce->USER_DISPLAY_TAB->Next() )
                echo "<tr><td>".$fce->USER_DISPLAY_TAB->row["SAPNAM"]."</td><td>".$fce->USER_DISPLAY_TAB->row["ADRNAME"]."</td></tr>";
            echo "</table>";
        } else
            $fce->PrintStatus();

        $sap->Close();
    }

    function me23n(){
        $po_number = v('po_number');
        if($_POST){
            $data['po_number'] = $po_number;
            redirect_to('po','me23n',$data);
        }else{
            if($po_number){
                $import['PURCHASEORDER'] = $po_number;
                $export = array('PO_HEADER');
                $table['PO_ITEMS'] = array();
                $parameters = rfc_parameters($import,$export,$table);
                $data = callRFC("BAPI_PO_GETDETAIL",$parameters);
//                print_r($data['PO_HEADER']);
                render_view('po/me23n_main',$data);
            }else{
                $data['po_number'] = '4500043151';
                render_view('po/me23n_search',$data);
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
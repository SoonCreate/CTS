<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');



function callRFC($func_name='',$parameters){
    $sap_connection =  array(
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
    );
    global $CI;

    $CI->load->library('Saprfc');
    $sap = new Saprfc(array("logindata"=> $sap_connection,"show_errors"=>false,"debug"=>false)) ;

    // Call-Function
    $result = $sap->callFunction($func_name, $parameters);

    // Call successfull?
    if ($sap->getStatus() != SAPRFC_OK) {
        // No, print long Version of last Error
        log_message('error',$sap->getStatusTextLong()) ;
        $result = FALSE;
        // or print your own error-message with the strings received from
        // 		$sap->getStatusText() or $sap->getStatusTextLong()
    }

    // Logoff/Close saprfc-connection LL/2001-08
    $sap->logoff();
    return $result;
}

//去除前导零
function clear_prezero($str){
    return ltrim($str,'0');
}

//补足前导零
function plus_perzero($str,$len){
    return sprintf('%0'.$len.'d',$str);
}

function rfc_parameters($import = NULL,$export = array(),$table = NULL){
    $parameters = array();
    if(!is_null($import)){
        foreach($import as $key=>$value){
            $parameters = add_import_param($parameters,$key,$value);
        }
    }

    if(!is_null($table)){
        foreach($table as $key=>$value){
            $parameters = add_table_param($parameters,$key,$value);
        }
    }
    $parameters = add_export_param($parameters,$export);
    return $parameters;
}

function add_import_param($parameters,$param_name,$value = '*'){
    array_push($parameters,array('IMPORT',$param_name,$value));
    return $parameters;
}

function add_table_param($parameters,$param_name,$value = array()){
    array_push($parameters,array('TABLE',$param_name,$value));
    return $parameters;
}

function add_export_param($parameters,$names){
    if(is_array($names)){
        foreach($names as $p){
            array_push($parameters,array('EXPORT',$p));
        }
    }elseif(is_string($names)){
        array_push($parameters,array('EXPORT',$names));
    }
    return $parameters;
}

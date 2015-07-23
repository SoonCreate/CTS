<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oracle_demo_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('oracle',true,true);
        $this->_table ='PLM_CUS_TIPART';
    }

    function call_procedure(){
        $params = array();
        $p['name'] = ':cname';
        $p['value'] = 'PPOBJECT';

        array_push($params,$p);
        $p['name'] = ':a';
        $p['value'] = 'a';
        $p['type'] = SQLT_INT;
        $p['length'] = -1;
        $this->db->stored_procedure('plm_itemext','getitemtype',$params);

    }

    function call_function_test(){
        $conn = $this->db->db_connect();
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
        }
        $query = "begin :result := plm_itemext.getitemtype(cname => :cname); end;";

        $k = 'PPOBJECT';
        $statement = oci_parse($conn,$query);
        oci_bind_by_name($statement, ":cname", $k);
        oci_bind_by_name($statement, ':result', $r, -1,SQLT_INT);
        oci_execute($statement);
        print "$r\n";
        oci_free_statement($statement);
        oci_close($conn);
    }

    function call_stored_function(){
        $p['cname'] = 'PPOBJECT';
        $r = $this->stored_function('plm_itemext','getitemtype',$p,SQLT_INT);
        print_r($r);
    }

    function stored_function($package, $fn, $params,$return_type = SQLT_CHR,$return_length = -1){
        //连接数据库
        $conn = $this->db->db_connect();
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
        }

        //判断参数是否有效
        if ($package == '' OR $fn == '' OR ! is_array($params))
        {
            if ($this->db->db_debug)
            {
                log_message('error', 'Invalid query: '.$package.'.'.$fn);
                return $this->db->display_error('db_invalid_query');
            }
            return FALSE;
        }

        // build the query string
        $sql = "begin :result := $package.$fn(";

        foreach ($params as $key=>$value)
        {
            $sql .=  $key . " => :" .$key.",";
        }
        $sql = trim($sql, ",") . "); end;";

        $statement = oci_parse($conn,$sql);

        //绑定参数
        foreach ($params as $key=>$value)
        {
            oci_bind_by_name($statement, ":".$key, $value);
        }
        //输出结果
        oci_bind_by_name($statement, ':result', $r, $return_length,$return_type);
        oci_execute($statement);

        oci_free_statement($statement);
        oci_close($conn);

        return $r;
    }
}
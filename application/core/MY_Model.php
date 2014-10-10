<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{

    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */

    /**
     * This model's default database table. Automatically
     * guessed by pluralising the model name.
     */
    protected $_table;

    /**
     * This model's default primary key or unique identifier.
     * Used by the find(), update() and delete() functions.
     */
    protected $primary_key = 'id';

    /**
     * The various callbacks available to the model. Each are
     * simple lists of method names (methods will be run on $this).
     */
    protected $before_create = array('set_creation_date');
    protected $after_create = array();
    protected $before_update = array('set_last_update');
    protected $after_update = array();
    protected $before_get = array();
    protected $after_get = array();
    protected $before_delete = array();
    protected $after_delete = array();

    /**
     * An array of validation rules. This needs to be the same format
     * as validation rules passed to the Form_validation library.
     */
    protected $validate = array();

    /**
     * Optionally skip the validation. Used in conjunction with
     * skip_validation() to skip data validation for any future calls.
     */
    protected $skip_validation = FALSE;

    /**
     * By default we return our results as objects. If we need to override
     * this, we can, or, we could use the `as_array()` and `as_object()` scopes.
     */
//    protected $return_type = 'object';
    protected $return_type = 'array';
    protected $_temporary_return_type = NULL;

    /* --------------------------------------------------------------
     * GENERIC METHODS
     * ------------------------------------------------------------ */

    /**
     * Initialise the model, tie into the CodeIgniter superobject and
     * try our best to guess the table name.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('inflector');

        $this->_fetch_table();

        $this->_temporary_return_type = $this->return_type;
    }

    /* --------------------------------------------------------------
     * CRUD INTERFACE
     * ------------------------------------------------------------ */

    /**
     * Fetch a single record based on the primary key. Returns an object.
     */
    public function find($primary_value)
    {
        $this->_run_before_callbacks('get');

        $row = $this->db->where($this->primary_key, $primary_value)
            ->get($this->_table)
            ->{$this->_return_type()}();
        $this->_temporary_return_type = $this->return_type;

        $this->_run_after_callbacks('get', array( $row ));

        return $row;
    }

    /**
     * Fetch a single record based on an arbitrary WHERE call. Can be
     * any valid value to $this->db->where().
     */
    public function find_by()
    {
        $where = func_get_args();
        $this->_set_where($where);

        $this->_run_before_callbacks('get');

        $this->limit(1);

        $row = $this->db->get($this->_table)
            ->{$this->_return_type()}();
        $this->_temporary_return_type = $this->return_type;

        $this->_run_after_callbacks('get', array( $row ));

        return $row;
    }

    //来自视图
    public function find_by_view()
    {
        $where = func_get_args();
        $this->_set_where($where);

        $this->_run_before_callbacks('get');

        $this->limit(1);

        $row = $this->db->get($this->_table.'_v')
            ->{$this->_return_type()}();
        $this->_temporary_return_type = $this->return_type;

        $this->_run_after_callbacks('get', array( $row ));

        return $row;
    }


    /**
     * Fetch an array of records based on an array of primary values.
     */
    public function find_many($values)
    {
        $this->db->where_in($this->primary_key, $values);

        return $this->find_all();
    }

    /**
     * Fetch an array of records based on an arbitrary WHERE call.
     */
    public function find_all_by()
    {
        $where = func_get_args();
        $this->_set_where($where);

        return $this->find_all();
    }

    public function find_all_by_view()
    {
        if(count(func_get_args()) > 0){
            $where = func_get_args();
            $this->_set_where($where);
        }

        $this->_run_before_callbacks('get');

        $result = $this->db->get($this->_table.'_v')
            ->{$this->_return_type(1)}();
        $this->_temporary_return_type = $this->return_type;

        foreach ($result as &$row)
        {
            $row = $this->_run_after_callbacks('get', array( $row ));
        }

        return $result;
    }

    /**
     * Fetch all the records in the table. Can be used as a generic call
     * to $this->db->get() with scoped methods.
     */
    public function find_all()
    {
        $this->_run_before_callbacks('get');

        $result = $this->db->get($this->_table)
            ->{$this->_return_type(1)}();
        $this->_temporary_return_type = $this->return_type;

        foreach ($result as &$row)
        {
            $row = $this->_run_after_callbacks('get', array( $row ));
        }

        return $result;
    }

    /**
     * Insert a new row into the table. $data should be an associative array
     * of data to be inserted. Returns newly created ID.
     */
    public function insert($data, $skip_validation = FALSE)
    {
        $valid = TRUE;

        if ($skip_validation === FALSE)
        {
            $valid = $this->_run_validation($data);
        }

        if ($valid)
        {
            $data = $this->_run_before_callbacks('create', array( $data ));

            $this->db->insert($this->_table, $data);
            $insert_id = $this->db->insert_id();

            $this->_run_after_callbacks('create', array( $data, $insert_id ));

            return $insert_id;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Insert multiple rows into the table. Returns an array of multiple IDs.
     */
    public function insert_many($data, $skip_validation = FALSE)
    {
        $ids = array();

        foreach ($data as $row)
        {
            $ids[] = $this->insert($row, $skip_validation);
        }

        return $ids;
    }

    /**
     * Updated a record based on the primary value.
     */
    public function update($primary_value, $data, $skip_validation = FALSE)
    {
        $valid = TRUE;

        $data = $this->_run_before_callbacks('update', array( $data, $primary_value ));

        if ($skip_validation === FALSE)
        {
            $valid = $this->_run_validation($data);
        }

        if ($valid)
        {
            $result = $this->db->where($this->primary_key, $primary_value)
                ->set($data)
                ->update($this->_table);
            $this->_run_after_callbacks('update', array( $data, $primary_value, $result ));
            return $result;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Update many records, based on an array of primary values.
     */
    public function update_many($primary_values, $data, $skip_validation = FALSE)
    {
        $valid = TRUE;

        $data = $this->_run_before_callbacks('update', array( $data, $primary_values ));

        if ($skip_validation === FALSE)
        {
            $valid = $this->_run_validation($data);
        }

        if ($valid)
        {
            $result = $this->db->where_in($this->primary_key, $primary_values)
                ->set($data)
                ->update($this->_table);
            $this->_run_after_callbacks('update', array( $data, $primary_values, $result ));

            return $result;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Updated a record based on an arbitrary WHERE clause.
     */
    public function update_by()
    {
        $args = func_get_args();
        $data = array_pop($args);
        $this->_set_where($args);

        $data = $this->_run_before_callbacks('update', array( $data, $args ));

        if ($this->_run_validation($data))
        {
            $result = $this->db->set($data)
                ->update($this->_table);
            $this->_run_after_callbacks('update', array( $data, $args, $result ));

            return $result;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Update all records
     */
    public function update_all($data)
    {
        $data = $this->_run_before_callbacks('update', array( $data ));
        $result = $this->db->set($data)
            ->update($this->_table);
        $this->_run_after_callbacks('update', array( $data, $result ));

        return $result;
    }

    /**
     * Delete a row from the table by the primary value
     */
    public function delete($id)
    {
        $data = $this->_run_before_callbacks('delete', array( $id ));
        $result = $this->db->where($this->primary_key, $id)
            ->delete($this->_table);
        $this->_run_after_callbacks('delete', array( $id, $result ));

        return $result;
    }

    /**
     * Delete a row from the database table by an arbitrary WHERE clause
     */
    public function delete_by()
    {
        $where = func_get_args();
        $this->_set_where($where);
        $data = $this->_run_before_callbacks('delete', array( $where ));
        $result = $this->db->delete($this->_table);
        $this->_run_after_callbacks('delete', array( $where, $result ));

        return $result;
    }

    /**
     * Delete many rows from the database table by multiple primary values
     */
    public function delete_many($primary_values)
    {
        $data = $this->_run_before_callbacks('delete', array( $primary_values ));
        $result = $this->db->where_in($this->primary_key, $primary_values)
            ->delete($this->_table);
        $this->_run_after_callbacks('delete', array( $primary_values, $result ));

        return $result;
    }

    /* --------------------------------------------------------------
     * UTILITY METHODS
     * ------------------------------------------------------------ */

    /**
     * Retrieve and generate a form_dropdown friendly array
     */
    function dropdown()
    {
        $args = func_get_args();

        if(count($args) == 2)
        {
            list($key, $value) = $args;
        }
        else
        {
            $key = $this->primary_key;
            $value = $args[0];
        }

        $this->_run_before_callbacks('get', array( $key, $value ));

        $result = $this->db->select(array($key, $value))
            ->get($this->_table)
            ->result();
        $this->_run_after_callbacks('get', array( $key, $value, $result ));

        $options = array();

        foreach ($result as $row)
        {
            $options[$row->{$key}] = $row->{$value};
        }

        return $options;
    }

    /**
     * Fetch a count of rows based on an arbitrary WHERE call.
     */
    public function count_by()
    {
        $where = func_get_args();
        $this->_set_where($where);

        return $this->db->count_all_results($this->_table);
    }

    public function count_by_view()
    {
        $where = func_get_args();
        $this->_set_where($where);

        return $this->db->count_all_results($this->_table.'_v');
    }

    /**
     * Fetch a total count of rows, disregarding any previous conditions
     */
    public function count_all()
    {
        return $this->db->count_all($this->_table);
    }

    /**
     * Tell the class to skip the insert validation
     */
    public function skip_validation()
    {
        $this->skip_validation = TRUE;
        return $this;
    }

    /**
     * Get the skip validation status
     */
    public function get_skip_validation()
    {
        return $this->skip_validation;
    }

    /**
     * Return the next auto increment of the table. Only tested on MySQL.
     */
    public function get_next_id()
    {
        return (int) $this->db->select('AUTO_INCREMENT')
            ->from('information_schema.TABLES')
            ->where('TABLE_NAME', $this->_table)
            ->where('TABLE_SCHEMA', $this->db->database)->get()->row()->AUTO_INCREMENT;
    }

    /**
     * Getter for the table name
     */
    public function table()
    {
        return $this->_table;
    }

    /* --------------------------------------------------------------
     * GLOBAL SCOPES
     * ------------------------------------------------------------ */

    /**
     * Return the next call as an array rather than an object
     */
    public function as_array()
    {
        $this->_temporary_return_type = 'array';
        return $this;
    }

    /**
     * Return the next call as an object rather than an array
     */
    public function as_object()
    {
        $this->_temporary_return_type = 'object';
        return $this;
    }

    /* --------------------------------------------------------------
     * QUERY BUILDER DIRECT ACCESS METHODS
     * ------------------------------------------------------------ */

    /**
     * A wrapper to $this->db->order_by()
     */
    public function order_by($criteria, $order = 'ASC')
    {
        if ( is_array($criteria) )
        {
            foreach ($criteria as $key => $value)
            {
                $this->db->order_by($key, $value);
            }
        }
        else
        {
            $this->db->order_by($criteria, $order);
        }
        return $this;
    }

    /**
     * A wrapper to $this->db->limit()
     */
    public function limit($limit, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this;
    }

    //验证信息
    public  function add_validate(){
        $numargs = func_num_args();
        $arg_list = func_get_args();

        if($numargs > 2){
            $r = array('field'=>$arg_list[0],'label'=>$arg_list[1],'rules'=>$arg_list[2]);
            array_push($this->validate,$r);
        }else{
            //只有两个参数的情况
            $r = array('field'=>$arg_list[0],'label'=>label($arg_list[0]),'rules'=>$arg_list[1]);
            array_push($this->validate,$r);
        }
    }

    public function add_validate_255($fields){
        if(is_array($fields)){
            foreach($fields as $f){
                $this->add_validate($f,'max_length[255]');
            }
        }else{
            $this->add_validate($fields,'max_length[255]');
        }
    }

    public function clear_validate(){
        $this->validate = array();
    }

    //设置时间戳
    public function set_last_update($data){
        $data['last_update_date'] = time();
        if(_sess('uid')){
            $data['last_updated_by'] = _sess('uid');
        }else{
            $data['last_updated_by'] =  -1;
        }
        return $data;
    }

    public function set_creation_date($data){
        $data['last_update_date'] = time();
        $data['creation_date'] = time();;
        if(_sess('uid')){
            $data['last_updated_by'] = _sess('uid');
            $data['created_by'] = _sess('uid');
        }else{
            $data['last_updated_by'] =  -1;
            $data['created_by'] =  -1;
        }
        return $data;
    }

    //获取数据库注释
    public function get_comment($column_name = null){
        if(is_null($column_name)){
            $query = $this->db->query( "select COLUMN_NAME,COLUMN_COMMENT from INFORMATION_SCHEMA.COLUMNS
        where TABLE_SCHEMA = 'CTS' AND  table_name = 'CT_{$this->_table}'" );
        }else{
            $query = $this->db->query( "select COLUMN_NAME,COLUMN_COMMENT from INFORMATION_SCHEMA.COLUMNS
        where TABLE_SCHEMA = 'CTS' AND  table_name = 'CT_{$this->_table}' and COLUMN_NAME = ".$column_name );
        }
        $result = $query->result_array();
        return $result;
    }

    /* --------------------------------------------------------------
     * INTERNAL METHODS
     * ------------------------------------------------------------ */

    /**
     * Run the before_ callbacks, each callback taking a $data
     * variable and returning it
     */
    private function _run_before_callbacks($type, $params = array())
    {
        $name = 'before_' . $type;
        $data = (isset($params[0])) ? $params[0] : FALSE;

        if (!empty($this->$name))
        {
            foreach ($this->$name as $method)
            {
                $data = call_user_func_array(array($this, $method), $params);
            }
        }

        return $data;
    }

    /**
     * Run the after_ callbacks, each callback taking a $data
     * variable and returning it
     */
    private function _run_after_callbacks($type, $params = array())
    {
        $name = 'after_' . $type;
        $data = (isset($params[0])) ? $params[0] : FALSE;

        if (!empty($this->$name))
        {
            foreach ($this->$name as $method)
            {
                $data = call_user_func_array(array($this, $method), $params);
            }
        }

        return $data;
    }

    /**
     * Run validation on the passed data
     */
    private function _run_validation($data)
    {
        if($this->skip_validation)
        {
            return TRUE;
        }

        if(!empty($this->validate))
        {
            foreach($data as $key => $val)
            {
                $_POST[$key] = $val;
            }

            $this->load->library('form_validation');

            if(is_array($this->validate))
            {
                $this->form_validation->set_rules($this->validate);
                return $this->form_validation->run();
            }
            else
            {
                return $this->form_validation->run($this->validate);
            }
        }
        else
        {
            return TRUE;
        }
    }

    /**
     * Guess the table name by pluralising the model name
     */
    private function _fetch_table()
    {
        if ($this->_table == NULL)
        {
            $this->_table = plural(preg_replace('/(_m|_model)?$/', '', strtolower(get_class($this))));
        }
    }

    /**
     * Set WHERE parameters, cleverly
     */
    private function _set_where($params)
    {
        if (count($params) == 1)
        {
            $this->db->where($params[0]);
        }
        else
        {
            $this->db->where($params[0], $params[1]);
        }
    }

    /**
     * Return the method name for the current return type
     */
    private function _return_type($multi = FALSE)
    {
        $method = ($multi) ? 'result' : 'row';
        return $this->_temporary_return_type == 'array' ? $method . '_array' : $method;
    }
}
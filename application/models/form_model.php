<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_validate();
        $this->add_validate('form_name','required|min_length[5]|max_length[45]|is_unique[forms.form_name]|alpha_dash');

        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->_validate();
        return $data;
    }

    //刷新字段列表
    function refresh_fields($id){
        $form = $this->find($id);
        if(!empty($form)){
            $this->load->model('form_field_model');
            $ffm = new Form_field_model();
            $fields = columns($form['table_name']);

            $rows = $ffm->find_all_by(array('form_id'=>$form['id']));

            $this->db->trans_start();

            //先查询是否已经存在则更新为最新的属性配置：字段类型，长度，默认值
            if(empty($rows)){
                //全新插入
                foreach($fields as $f){
                    $data = $this->_column_to_filed($f);
                    $data['form_id'] = $id;
                    $ffm->insert($data);
                }
            }else{
                //现有参数与数据库比较
                foreach($rows as $r){
                    $col = columns($form['table_name'],$r['field_name']);
                    if(empty($col)){
                        //更新成无效
                        $ffm->update($r['id'],array('inactive_flag'=>1));
                    }else{
                        $data = $this->_column_to_filed($col[0]);
                        $data['form_id'] = $id;
                        $ffm->update($r['id'],$data);
                    }
                }

                //数据库与现有参数比较
                foreach($fields as $f){
                    $field = $ffm->find_by(array('field_name'=>$f['COLUMN_NAME']));

                    if(empty($field)){
                        //直接插入
                        $data = $this->_column_to_filed($f);
                        $data['form_id'] = $id;
                        $ffm->insert($data);

                    }
                }
            }

            $this->db->trans_complete();
            return $this->db->trans_status();
        }
    }

    private function _validate(){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('table_name','required|max_length[100]');
        $this->add_validate('group_id','required');
    }

    //将数据库属性转换成平台属性
    function _column_to_filed($col){
        $data['field_name'] = $col['COLUMN_NAME'];
        $data['field_type'] = $col['DATA_TYPE'];
        switch($col['DATA_TYPE']){
            case 'int' :
                $data['field_size'] = $col['NUMERIC_PRECISION'];
                break;
            default :
                $data['field_size'] = $col['CHARACTER_MAXIMUM_LENGTH'];
                break;
        }
        $data['label'] = $col['COLUMN_COMMENT'];
        $data['default_value'] = $col['COLUMN_DEFAULT'];
        return $data;
    }
}
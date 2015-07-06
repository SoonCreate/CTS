<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('form_group_model');
        $this->load->model('form_model');
    }

    public function index()
    {
        render();
    }

    function form_tree(){
        $rows = [];
        $fgm = new Form_group_model();
        $groups = $fgm->find_all();
        $cnt = count($groups);
        $id = 1;
        if($cnt > 0){
            $fm = new Form_model();
            for($i = 0 ; $i < $cnt ; $i++){
                $row = null;
                $row['description'] =  $groups[$i]['description'] ;
                $row['name'] = $groups[$i]['name'] ;
                $row['group_id'] = $groups[$i]['id'] ;
                //唯一性标识
                $row['id'] = strval($id);
                $id ++;
                $forms = $fm->find_all_by(array('group_id'=>$row['group_id']));
                //插入子节点
                $row['children'] = [];
                for($y = 0 ; $y < count($forms) ; $y++){
                    $row_r = null;
                    $row_r['description'] = $forms[$y]['description'];
                    $row_r['name'] = $forms[$y]['form_name'];
                    $row_r['form_id'] = $forms[$y]['id'];
                    $row_r['group_id'] = $forms[$y]['group_id'];
                    //唯一性标识
                    $row_r['id'] = strval($id);
                    $id ++;
                    array_push($row['children'],$row_r);
                }
                array_push($rows,$row);
            }
        }
        $data["identifier"] = 'id';
        $data["label"] = 'description';
        $data['items'] = $rows;
        echo json_encode($data);
    }

    function create(){
        $this->load->view('form/create');
    }

    function edit(){

    }

    function destroy(){

    }

    function form_group(){

    }

    function form_group_create(){
        if($_POST){
            $fgm = new Form_group_model();
            if($fgm->insert(_data('name','description'))){
                message_db_success();
                redirect_to('form','index');
            }else{
                validation_error();
            }
        }else{
            $this->load->view('form/form_group_create');
        }

    }

    function form_group_edit(){
        $fgm = new Form_group_model();
        $data = $fgm->find(v('id'));
        if(!empty($data)){
            if($_POST){
                if($fgm->update($data['id'],_data('description'))){
                    message_db_success();
                    redirect_to('form','index');
                }else{
                    validation_error();
                }
            }else{
                $this->load->view('form/form_group_edit',$data);
            }
        }else{
            show_404();
        }
    }

    function form_group_destroy(){
        $fgm = new Form_group_model();
        $data = $fgm->find(v('id'));
        if(!empty($data)){
            //判断是否拥有表单
            $fm = new Form_model();
            $forms = $fm->count_by(array('group_id'=>$data['id']));
            if($forms > 0){
                custz_message('E','请先清空或转移分组下的表单才能删除分组！');
            }else{
                if($fgm->delete($data['id'])){
                    message_db_success();
                }else{
                    message_db_failure();
                }
            }
        }
    }

    function fields(){

    }

    function field_update(){

    }


}
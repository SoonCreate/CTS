<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Valuelist extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('valuelist_model');
        $this->load->model('valuelist_line_model');
    }

    public function index()
    {
        $vm = new Valuelist_model();
        $rows = $vm->find_all();
        for($i=0;$i<count($rows);$i++){
            $rows[$i]['parent_name'] = '';
            $rows[$i]['parent_desc'] = '';
            if($rows[$i]['parent_id']){
                $p = $vm->find($rows[$i]['parent_id']);
                if(!empty($p)){
                    $rows[$i]['parent_name'] = $p['valuelist_name'];
                    $rows[$i]['parent_desc'] = $p['description'];
                }
            }
            $rows[$i] = _format_row( $rows[$i]);
        }
        $data['objects'] = $rows;
        render($data);
    }

    function create(){
        $vm = new Valuelist_model();
        if($_POST){
            $object_flag = v('object_flag');
            //如果是来自表/视图
            if($object_flag){
                $_POST['object_flag'] = 1;
                if($vm->save_from_object(_data('valuelist_name','description','object_flag','label_fieldname','value_fieldname','source_view','condition'))){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                $_POST['object_flag'] = 0;
                if($vm->save_normal(_data('valuelist_name','description','parent_id','object_flag'))){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }
        }else{
            render();
        }
    }

    function edit(){
        $vm = new Valuelist_model();
        $v = $vm->find(v('id'));
        if(empty($v)){
            show_404();
        }else{
            if($v['editable_flag']){
                if($_POST){
                    $object_flag = v('object_flag');
                    //如果是来自表/视图
                    if($object_flag){
                        $_POST['object_flag'] = 1;
                        if($vm->save_from_object(_data('id','description','object_flag','label_fieldname','value_fieldname','source_view','condition'))){
                            echo 'done';
                        }else{
                            echo validation_errors('<div class="error">', '</div>');
                        }
                    }else{
                        $_POST['object_flag'] = 0;
                        if($vm->save_normal(_data('id','description','parent_id','object_flag'))){
                            echo 'done';
                        }else{
                            echo validation_errors('<div class="error">', '</div>');
                        }
                    }
                }else{
//                $v['fields'] = $vm->get_comment();
                    render($v);
                }
            }else{
                echo '值集为系统配置不能被编辑！';
            }

        }
    }

    //值集项目
    function items(){
        $vm = new Valuelist_model();
        $parent_segment = v('parent_segment');
        $h = $vm->find(v('id'));
        if(empty($h)){
            show_404();
        }else{
            $vlm = new Valuelist_line_model();
            if($h['parent_id']){
                if(!$parent_segment){
                    $parent_segment = $vm->find_all_options($h['']);
                }
            }
            if($parent_segment && $h['parent_id']){
                $data['parent'] = $vlm->find_by_view(array('valuelist_id'=>$h['id'],'parent_segment'=>$parent_segment));
            }
            $data['objects'] = $vlm->find_all_by_view(array('valuelist_id'=>$h['id']));
            render($data);
        }
    }

    function item_create(){

    }

    function change_item_status(){

    }


}
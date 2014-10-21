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
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                $_POST['object_flag'] = 0;
                if($vm->save_normal(_data('valuelist_name','description','parent_id','object_flag'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
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
                    $data = _data('id','description','object_flag','label_fieldname','value_fieldname','source_view','condition','parent_id');
                    //如果是来自表/视图
                    if($object_flag){
                        $data['object_flag'] = 1;
                        $data['parent_id'] = NULL;
                        if($vm->save_from_object($data)){
                            message_db_success();
                        }else{
                            validation_error();
                        }
                    }else{
                        $data['object_flag'] = 0;
                        $data['label_fieldname'] = NULL;
                        $data['value_fieldname'] = NULL;
                        $data['source_view'] = NULL;
                        $data['condition'] = NULL;
                        if($vm->save_normal($data)){
                            message_db_success();
                        }else{
                            validation_error();
                        }
                    }
                }else{
//                $v['fields'] = $vm->get_comment();
                    render($v);
                }
            }else{
                custz_message('E','值集为系统配置不能被编辑！');
            }

        }
    }

    //值集项目
    function items(){
        $vm = new Valuelist_model();
        $vlm = new Valuelist_line_model();
        $parent_segment = v('parent_segment');
        $h = $vm->find(v('id'));
        if(empty($h)){
            show_404();
        }else{
            if($h['object_flag']){
                $data['objects'] = get_options($h['valuelist_name']);
                //来自表对象则不能进行项目编辑，只能显示
                render_view('valuelist/items_from_object',$data);
            }else{
                //如果存在父值集，没有指定父值集项目的时候，默认第一项
                if($h['parent_id']){
                    $parent = $vm->find($h['parent_id']);
                    if(empty($parent)){
                        custz_message('E','父值集不存在');
                    }else{
                        $lines = $vm->find_active_options($parent['valuelist_name'])->result_array();
                        if(count($lines) > 0){
                            if(!$parent_segment){
                                $parent['segment'] = $lines[0];
                                $parent_segment = $lines[0]['value'];
                                $data['parent'] = $parent;
                                $data['lines'] = $lines;
                                $data['objects'] = $vlm->find_all_by_view(array('valuelist_id'=>$h['id'],'parent_segment'=>$parent_segment));
                                $data['objects'] = _format($data['objects']);
                                render($data);
                            }else{
                                $has = false;
                                foreach($lines as $l){
                                    if($l['value'] == $parent_segment){
                                        $has = true;
                                        break;
                                    }
                                }
                                if($has){
                                    $data['parent'] = $parent;
                                    $data['lines'] = $lines;
                                    $data['objects'] = $vlm->find_all_by_view(array('valuelist_id'=>$h['id'],'parent_segment'=>$parent_segment));
                                    $data['objects'] = _format($data['objects']);
                                    render($data);
                                }else{
                                    custz_message('E','父值集无'.$parent_segment.'项目');
                                }
                            }

                        }else{
                            custz_message('E', '父值集无项目');
                        }
                    }
                }else{
                    $data['objects'] = $vlm->find_all_by_view(array('valuelist_id'=>$h['id']));
                    $data['objects'] = _format($data['objects']);
                    render($data);
                }
            }

        }
    }

    function item_create(){
        $vm = new Valuelist_model();
        $parent_segment = v('parent_segment');
        $valuelist_id = v('id');
        $h = $vm->find($valuelist_id);
        if(empty($h)){
            show_404();
        }else{
            //如果存在父值集，没有指定父值集项目的时候，默认第一项
            if($h['parent_id']){
                $parent = $vm->find($h['parent_id']);
                if(empty($parent)){
                    custz_message('E','父值集不存在');
                }else{
                    $lines = $vm->find_all_options($parent['valuelist_name'])->result_array();
                    if(count($lines) > 0){
                        if(!$parent_segment){
                            show_404();
                        }else{
                            $has = false;
                            foreach($lines as $l){
                                if($l['value'] == $parent_segment){
                                    $has = true;
                                    break;
                                }
                            }
                            if($has){

                                $this->_item_create();
                            }else{
                                custz_message('E','父值集无'.$parent_segment.'项目');
                            }
                        }

                    }else{
                        custz_message('E', '父值集无项目');
                    }
                }
            }else{
                $this->_item_create();
            }
        }
    }

    function change_item_status(){
        $vlm = new Valuelist_line_model();
        $l = $vlm->find(v('id'));
        if(empty($l) && isset($_POST['inactive_flag'])){
            show_404();
        }else{
            $data['inactive_flag'] = v('inactive_flag');
            if($vlm->update($l['id'],$data,true)){
                message_db_success();
            }else{
                validation_error();
            }
        }
    }

    function item_edit(){
        $vlm = new Valuelist_line_model();
        $item = $vlm->find(v('id'));
        if(empty($item)){
            show_404();
        }else{
            if($_POST){
                $_POST['inactive_flag'] = v('inactive_flag');
                if($vlm->update($item['id'],_data('segment_value','segment_desc','sort','inactive_flag'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render($item);
            }
        }
    }

    private function _item_create(){
        $vlm = new Valuelist_line_model();
        $valulist_id = v('id');
        $parent_segment = v('parent_segment');
        if($_POST){
            //验证唯一性
            $line = $vlm->find_by(array('valuelist_id'=>$valulist_id,'parent_segment_value'=>$parent_segment,'segment'=>v('segment')));
            if(empty($line)){
                $_POST['valuelist_id'] = $valulist_id;
                $_POST['parent_segment_value'] = $parent_segment;
                $_POST['inactive_flag'] = v('inactive_flag');
                if($vlm->insert(_data('valuelist_id','segment','segment_value','segment_desc','sort','inactive_flag','parent_segment_value'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                custz_message('E','值已存在，请检查输入');
            }
        }else{

            //默认段值
            if($parent_segment){
                $this->db->select_max('segment');
                $line = $vlm->find_all_by(array('valuelist_id'=>$valulist_id,'parent_segment_value'=>$parent_segment));

            }else{
                $this->db->select_max('segment');
                $line = $vlm->find_all_by(array('valuelist_id'=>$valulist_id));
            }
            $data['segment'] = string_to_number($line[0]['segment']) + 10;
            $data['sort'] = 0;
            render_view('valuelist/item_create',$data);
        }
    }


}
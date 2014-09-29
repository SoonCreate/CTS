<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modules extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('module_model');
        $this->load->model('module_line_model');
        $this->load->model('role_module_line_model');
        $this->load->model('function_model');
    }

	public function index()
	{
        $m= new Module_model();
        $m->order_by('sort');
		$data['modules'] = $m->find_all();
        render($data);
	}

    function create(){
        if($_POST){
            $data['module_name'] = tpost('module_name');
            $data['description'] = tpost('description');
            $data['sort'] = tpost('sort');
            $m= new Module_model();
            if($m->insert($data)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
            render();
        }
    }

    function edit(){
        $m = new Module_model();
        if($_POST){
            $data['id'] = v('id');
            $data['description'] = tpost('description');
            $data['sort'] = tpost('sort');
            if($m->update($data['id'],$data)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }

        }else{
            render($m->find(p('id')));
        }
    }

    function destroy(){
        $m = new Module_model();
        $ml = new Module_line_model();
        $rml = new Role_module_line_model();
        $module_id = p('id');
        $module = $m->find($module_id);
        $role_in_use = $rml->find_all_by_view(array('module_id'=>$module_id));
        if(!empty($module) && empty($role_in_use)){
            $this->db->trans_start();
            $ml->delete_by(array('module_id'=>$module_id));
            $m->delete($module_id);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                echo '数据库删除错误';
            }else{
                echo 'done';
            }
        }else{
            echo '无法删除!模块正在角色被使用.';
        }
    }

    function choose_functions(){
        $ml = new Module_line_model();
        if($_POST){
            $ids = v('functions');
            $data['module_id'] = v('module_id');
            $data['sort'] = v('sort');
            if($ids === FALSE){
                //删除所有
                $ml->delete_by(array('module_id' => $data['module_id']));
            }else{
                //先删除已取消勾选的
                $this->db->where_not_in('function_id',$ids);
                $ml->delete_by(array('module_id' => $data['module_id']));
                //新增的部分
                $ids = array_diff($ids,$ml->find_function_ids($data['module_id']));
                foreach($ids as $id){
                    $data['function_id'] = $id;
                    $ml->insert($data);
                }
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                echo '数据库插入错误';
            }else{
                echo 'done';
            }
        }else{
            $module_id = p('module_id');
            $fn = new Function_model();
            $fns = $fn->find_all();
            for($i=0;$i<count($fns) ;$i++){
                $line = $ml->find_by(array('module_id'=>$module_id,'function_id'=>$fns[$i]['id']));
                if(!empty($line)){
                    $fns[$i]['checked'] = 'checked';
                }else{
                    $fns[$i]['checked'] = '';
                }
            }
            $data['functions'] = _format($fns);
            $data['module_id'] = $module_id;
            render($data);
        }
    }


}
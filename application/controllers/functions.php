<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Functions extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('function_model');
        $this->load->model('role_module_line_model');
        $this->load->model('module_line_model');
        $this->load->model('module_model');
    }

	public function index()
	{
        $fn = new Function_model();
		$data['functions'] = $fn->find_all();
        render($data);
	}

    function create(){
        if($_POST){
            $data['controller'] = tpost('controller');
            $data['action'] = tpost('action');
            //验证url是否可访问
            if(url_exists(_url($data['controller'],$data['action']))){
                $data['function_name'] = tpost('function_name');
                $data['description'] = tpost('description');
                $fn = new Function_model();
                if($fn->insert($data)){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                echo '无效的链接';
            }
        }else{
            render();
        }
    }

    function edit(){
        $fn = new Function_model();
        if($_POST){
            $data['id'] = v('id');
            $data['description'] = tpost('description');
            $data['controller'] = tpost('controller');
            $data['action'] = tpost('action');
            if(url_exists(_url($data['controller'],$data['action']))){
                if($fn->update($data['id'],$data)){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                echo '无效的链接';
            }

        }else{
            render($fn->find(p('id')));
        }
    }

    function destroy(){
        $f = new Function_model();
        $ml = new Module_line_model();
        $rml = new Role_module_line_model();
        $function_id = p('id');
        $fn = $f->find($function_id);
        $role_in_use = $rml->find_all_by_view(array('function_id'=>$function_id));
        $module_in_use = $ml->find_by(array('function_id'=>$function_id));
        if(!empty($fn) && empty($role_in_use) && empty($module_in_use)){
            if ($f->delete($function_id)) {
                echo 'done';
            }else{
                echo '数据库删除错误';
            }
        }else{
            echo '无法删除!功能正在模块或角色被使用.';
        }
    }

    function allocate_modules(){
        $ml = new Module_line_model();
        if($_POST){
            $ids = v('modules');
            $data['function_id'] = v('function_id');
            $data['sort'] = v('sort');
            $this->db->trans_start();

            if($ids === FALSE){
                //删除所有
                $ml->delete_by(array('function_id' => $data['function_id']));
            }else{
                //先删除已取消勾选的
                $this->db->where_not_in('module_id',$ids);
                $ml->delete_by(array('function_id' => $data['function_id']));
                //新增的部分
                $ids = array_diff($ids,$ml->find_module_ids($data['function_id']));
                foreach($ids as $id){
                    $data['module_id'] = $id;
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
            $function_id = p('function_id');
            $m = new Module_model();
            $ms = $m->find_all();
            for($i=0;$i<count($ms) ;$i++){
                $line = $ml->find_by(array('module_id'=>$ms[$i]['id'],'function_id'=>$function_id));
                if(!empty($line)){
                    $ms[$i]['checked'] = 'checked';
                }else{
                    $ms[$i]['checked'] = '';
                }
            }
            $data['modules'] = _format($ms);
            $data['function_id'] = $function_id;
            render($data);
        }
    }


}
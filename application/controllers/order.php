<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('order_model');
        $this->load->model('order_content_model');
        $this->load->model('order_addfile_model');
        $this->load->model('order_log_model');
        $this->load->model('order_log_type_model');
        $this->load->model('auth_model');
        $this->load->model('status_model');
    }

	public function index()
	{
        $om = new Order_model();
        $sm = new Status_model();
        $olm = new Order_log_model();
        $os = $om->find_all();
        for($i=0;$i<count($os);$i++){
            $os[$i]['order_type'] = get_label('vl_order_type',$os[$i]['order_type']);
            $os[$i]['category'] = get_label('vl_order_category',$os[$i]['category']);
            $os[$i]['status'] = $sm->get_label('order_status',$os[$i]['status']);
            $os[$i]['severity'] = get_label('vl_severity',$os[$i]['severity']);
            $os[$i]['content'] = $om->first_content($os[$i]['id']);
            $os[$i]['managed_by'] = $os[$i]['manager_id'];
            $os[$i]['delay_flag'] = 0;
            if(!is_null($os[$i]['plan_complete_date']) && $os[$i]['plan_complete_date'] < time()){
                $os[$i]['delay_flag'] = 1;
            }
            $os[$i]['plan_date_count'] = $olm->count_by_view(array('field_name'=>'plan_complete_date','dll_type'=>'update'));
        }
        $data['objects'] = _format($os);
		render($data);
	}

    //在创建之前做选择
    function choose_create(){
        $a = new Auth_model();
        //能够创建的订单列表
        $rows = $a->can_create_order_types();
        if(empty($rows)){
            //不能创建任何投诉订单，提示账号未被授权
            echo '不能创建任何投诉订单，账号未被授权';
        }elseif(count($rows) > 1){
            $data['objects'] = $rows;
            //同时拥有几种订单的创建权限，显示选择页
            render($data);

        }else{
            //一种时，直接跳转
            redirect_to('order','create',array('type'=>$rows[0]));
        }

    }

    function create(){
        $order = new Order_model();
        if($_POST){
            $data['order_type'] = tpost('order_type');
            //非分类管理，默认分类设置时可默认
            if(_config('category_control')){
                $data['category'] = tpost('category');
            }else{
                $c = $order->default_category($data['order_type']);
                if(!is_null($c)){
                    $data['category'] = $c['value'];
                }
            }

            $data['status'] = $order->default_status();

            //验证提交
            //权限
            if(check_order_auth($data['order_type'],$data['status'],$data['category'])){

                $data['severity'] = tpost('severity');
                $data['frequency'] = tpost('frequency');
                $data['title'] = tpost('title');
                $data['contact'] = tpost('contact');
                $data['phone_number'] = tpost('phone_number');
                $data['mobile_telephone'] = tpost('mobile_telephone');
                $data['address'] = tpost('address');
                $data['full_name'] = tpost('full_name');
                $content = r(v('content'));
                $addfiles = tpost('addfiles');

                if($order->save($data,$content,$addfiles)){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }


            }else{

            }
        }else{
            //获取订单类型，如果没有则跳转到chose_create
            $order_type = tget('type');
            $data['order_type'] = $order_type;
            if(_config('category_control')){
                $au = new Auth_model();
                $data['categories'] = $au->can_choose_order_categories($order_type,$order->default_status());
            }

            if(is_null($order_type)){
                redirect_to('order','choose_create');
            }else{
                render($data);
            }
        }

    }

    function show(){
        $id = p('id');
        $om = new Order_model();
        $order = $om->find($id);
        //id是否有效
        if(!empty($order)){
            //是否只能看到自己的订单
            $am = new Auth_model();
            if($am->check_auth('only_mine_control',array('ao_only_mine'=>'TRUE')) && $order['created_by'] != _sess('uid')){
                show_404();
            }else{
                $ocm = new Order_content_model();
                $oam = new Order_addfile_model();
                $ocm->order_by('creation_date');
                $order['contents'] = $ocm->find_all_by(array('order_id'=>$id));
                $oam->order_by('creation_date');
                $order['addfiles'] = $oam->find_all_by_view(array('order_id'=>$id));
                render($order);
            }
        }else{
            show_404();
        }
    }

    function log_types(){
        $oltm = new Order_log_type_model();
        $data['objects'] = _format($oltm->find_all());
        render($data);
    }

    function log_type_create(){
        $oltm = new Order_log_type_model();
        if($_POST){
            $data['log_type'] = tpost('log_type');
            $data['description'] = tpost('description');
            $data['title'] = tpost('title');
            $data['content'] = tpost('content');
            $data['field_name'] = tpost('field_name');
            $data['dll_type'] = tpost('dll_type');
            $data['need_reason_flag'] = v('need_reason_flag');
            $data['notice_flag'] = v('notice_flag');
            if($oltm->insert($data)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
            render();
        }
    }

    function log_type_destroy(){
        $oltm = new Order_log_type_model();
        $id = p('id');
        $o = $oltm->find($id);
        if(!empty($o)){
            $olm = new Order_log_model();
            $log = $olm->find_by(array('log_type'=>$o['log_type']));
            if(empty($log)){
                if($oltm->delete($id)){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                echo '日志类型被用于多个日志中！无法删除';
            }
        }else{
            show_404();
        }
    }

    function log_type_edit(){
        $oltm = new Order_log_type_model();
        if($_POST){
            $data['description'] = tpost('description');
            $data['title'] = tpost('title');
            $data['content'] = tpost('content');
            $data['field_name'] = tpost('field_name');
            $data['dll_type'] = tpost('dll_type');
            $data['need_reason_flag'] = v('need_reason_flag');
            $data['notice_flag'] = v('notice_flag');
            if($oltm->update(v('id'),$data)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
            $data = $oltm->find(p('id'));
            if(empty($data)){
                show_404();
            }else{
                render($data);
            }
        }
    }

    function change_reason(){
        $olm = new Order_log_model();
        //如果日志类型需要原因，此页面用于补充
        if($_POST){
            $change_hash = tpost('change_hash');
            $reason = tpost('reason');
            echo $reason;
            if($olm->update_by(array('change_hash'=>$change_hash),array('reason'=>$reason))){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
            $data['change_hash'] =  p('change_hash');
            if($data['change_hash']){
                render($data);
            }else{
                show_404();
            }
        }
    }

    function confirm(){
        $this->_update(p('id'),array('status'=>'confirmed'));
    }

    function upload_file(){

    }

    //分配任务，制定负责人，计划完成时间
    function dispatcher(){
        if($_POST){
            //判断 status_for_lock 是否为锁定状态
            $this->_update(p('id'),$data);
        }else{
            render();
        }
    }

    //责任人资料
    function manager_info(){
        //符合当前订单处理权限的责任人列表
        //责任人姓名、联系方式、当前待处理订单数量
    }

    function change_plan_complete_date(){
        //需要填写原因
    }

    private function _update($id,$data){
        $om = new Order_model();
        $order = $om->find($id);
        //id是否有效
        if(!empty($order)){
            //先判断订单状态流是否允许更改
            if(is_order_allow_next_status($order['status'],$data['status']) && check_order_auth($order['order_type'],$data['status'],$order['category'])){
                if($om->do_update($order['id'],array('status'=>$data))){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                echo '不允许状态流向！';
            }
            //判断是否有权限更改次状态
        }else{
            show_404();
        }
    }

}
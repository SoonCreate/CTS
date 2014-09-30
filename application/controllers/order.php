<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('order_model');
        $this->load->model('auth_model');
    }

	public function index()
	{
		$this->load->view('welcome_message');
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
            $data['category'] = tpost('category');
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
            $am->check_auth('only_mine_control',array('ao_only_mine'=>'TRUE'));
        }else{
            show_404();
        }
    }

    function change_status(){
        //先判断订单状态流是否允许更改
        //判断是否有权限更改次状态
    }

    function upload_file(){

    }

    //分配任务，制定负责人，计划完成时间
    function dispatcher(){

    }

    //责任人资料
    function manager_info(){
        //符合当前订单处理权限的责任人列表
        //责任人姓名、联系方式、当前待处理订单数量
    }

    function change_plan_complete_date(){
        //需要填写原因
    }

}
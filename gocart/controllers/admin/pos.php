<?php
error_reporting(E_ALL);
class Pos extends Admin_Controller {	
	
	private $use_inventory = false;
	function __construct()
	{		
		parent::__construct();
		remove_ssl();

		// $this->auth->check_access('Admin', true);
		
		$this->load->model('Product_model');
		$this->load->model('Common_model');
		$this->load->helper('form');
		$this->lang->load('product');
		
	}
	function index($filter = false)
	{
	
		$admin = $this->admin_session->userdata('admin');
		$data['adminstate'] = ($admin['access'] == 'Admin') ? true : false;
		$data['page_title']	= 'Purchase Orders';
		
		$data['orders'] = $this->Common_model->get('po');
		$this->load->view($this->config->item('admin_folder').'/pos', $data);
	}
	
	function request($id, $qty, $type, $sid){
		
		$save['qty'] = $qty;
		$save['spid'] = $id;
		$save['itype'] = $type;
		$save['sid'] = $sid;
		$save['status'] = 'requested';
		
		$result = $this->Common_model->add('po', $save);
		$dd['status'] = 1;
		$where['id'] = $id;
		$this->Common_model->update('products_supplier', $dd, $where);
		echo $result;
	}
	
	function changestate($id, $state){
		$where['id'] = $id;
		$save['status'] = $state;
		
		if($state == 'Completed'){
			
			$where['id'] = $id;
			$data = $this->Common_model->get_where('po', $where, 0);
			
			$dsave['itemid'] = $data->itype;
			$dsave['poid'] = $data->id;
			$dsave['qty'] = $data->qty;
			
			$this->Common_model->add('stocks', $dsave);
		}
		
		$this->Common_model->update('po',$save, $where);
		redirect('admin/pos');
	}
	
	
}

<?php
error_reporting(E_ALL);
class Spos extends Admin_Controller {	
	
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
		$data['page_title']	= 'Purchase Orders From iDesign';
		
		
		$where['spid'] = $admin['id'];
		$where2['id'] = $admin['id'];
		$data['orders'] = $this->Common_model->get('po', $where, 1);
		$this->load->view($this->config->item('admin_folder').'/spos', $data);
	}
	
	function changestate($id, $status){
		
		$where['id'] = $id;
		$save['sstatus'] = $status;
		
		$this->Common_model->update('po', $save, $where);
		redirect('admin/spos');
	}
	
	
}

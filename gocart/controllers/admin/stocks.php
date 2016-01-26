<?php
class Stocks extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		remove_ssl();

		$this->auth->check_access('Admin', true);

		$this->lang->load('tips');
		$this->load->model('Tip_model');
		$this->load->model('Common_model');
		$this->load->helper('date');
	}
		
	function index()
	{
		$where_po['status'] = 'Completed';
		$data['stocks']		= $this->Common_model->get_where('po', $where_po, 1);
		$data['page_title']	= 'Stocks';
		
		
		//debug($data['stocks'], 1);
		$this->load->view($this->config->item('admin_folder').'/stocks', $data);
	}
	
	function update(){
		$where_stock['id'] = $this->input->post('stock_id');
		$where_po['id'] = $this->input->post('id');
		
		$save['qty'] = $this->input->post('newstock');
		
		$this->Common_model->update('stocks', $save, $where_stock);
		$this->Common_model->update('po', $save, $where_po);
		
		redirect('admin/stocks');
	}
	
}
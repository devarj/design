<?php
class Items extends Admin_Controller
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
		$data['raws']		= $this->Common_model->get('raw');
		$data['page_title']	= 'Item Supplies';
		
		$this->load->view($this->config->item('admin_folder').'/items', $data);
	}
	
	function delete($id)
	{
		$where['id'] = $id;
		$this->Common_model->delete('raw', $id);
		$this->session->set_flashdata('message', 'Item Deleted!');
		redirect($this->config->item('admin_folder').'/items');
	}
	
	/********************************************************************
	this function is called by an ajax script, it re-sorts the boxes
	********************************************************************/
	function organize()
	{
		$tips = $this->input->post('tips');
		$this->Tip_model->organize($tips);
	}
	
	function reset($id){
		$save['qty'] = 0;
		$save['dispense'] = 0;
		$where['itemid'] = $id;
		$this->Common_model->update('stocks', $save, $where);
		redirect('admin/items');
	}
	
	function form($id = false)
	{
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		//set the default values
		$data	= array(	 'id'=>$id
							,'tip'=>''
							,'image'=>''
						);
		if($id)
		{
			$where['id'] = $id;
			$data				= (array) $this->Common_model->get_where('raw', $where);
		}
		$data['page_title']	= 'Item Supply';
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		
		if ($this->form_validation->run() == false)
		{
			$data['error'] = validation_errors();
			$this->load->view($this->config->item('admin_folder').'/items_form', $data);
		}
		else
		{	
			
			$save['name']			= $this->input->post('name');
			$save['status']			= $this->input->post('status');
			
			if($id){
				$where['id'] = $id;
				
				/* $where_item['itemid'] = $id;
				
				$stocks = $this->Common_model->get_where_orderby('stocks', $where_item, 1, 'qty');
				
				
				if($this->input->post('curstock') > $stocks[0]->qty){
					$save_stock['qty'] = $this->input->post('curstock');
					$where_stock['id'] = $stocks[0]->id;
					$this->Common_model->update('stocks', $save_stock, $where_stock);
				}else{
					$save_stock['qty'] = $this->input->post('curstock');
					$where_stock['id'] = $stocks[0]->id;
					debug($where_stock, 1);
				}
				
				
				$save_stock['qty'] = $this->input->post('curstock');
				$where_stock['id'] = $stocks[0]->id;
				debug($where_stock, 1);
				
				 */
				
				$this->Common_model->update('raw', $save, $where);
			}
			else{
				$this->Common_model->add('raw', $save);
			}
			
			
			$this->session->set_flashdata('message', 'Item Saved');
			
			redirect($this->config->item('admin_folder').'/items');
		}	
	}
	
}
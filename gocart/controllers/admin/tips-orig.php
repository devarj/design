<?php
class Tips extends Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		remove_ssl();

		$this->auth->check_access('Admin', true);
		$this->load->model('Page_model');
		$this->lang->load('page');
	}
		
	function index()
	{
		$data['page_title']	= 'Tip of the Day';
		$data['pages']		= $this->Page_model->get_tips();
		
		
		$this->load->view($this->config->item('admin_folder').'/tips', $data);
	}
	
	/********************************************************************
	edit page
	********************************************************************/
	function form($id = false)
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		//set the default values
		$data['id']			= '';
		$data['tip']		= '';
		
		$data['page_title']	= 'Tip Form';
		$data['pages']		= $this->Page_model->get_pages();
		
		if($id)
		{
			
			$page			= $this->Page_model->get_tip($id);

			if(!$page)
			{
				//page does not exist
				$this->session->set_flashdata('error', lang('error_page_not_found'));
				redirect($this->config->item('admin_folder').'/tips');
			}
			
			
			//set values to db values
			$data['id']				= $page->id;
			$data['tip']		= $page->tip;
		}
		
		$this->form_validation->set_rules('tip', 'lang:title', 'trim|required');
		
		// Validate the form
		if($this->form_validation->run() == false)
		{
			$this->load->view($this->config->item('admin_folder').'/tip_form', $data);
		}
		else
		{
			$this->load->helper('text');
			
			$save = array();
			$save['id']			= $id;
			$save['tip']	= $this->input->post('tip');
			
			//save the page
			$page_id	= $this->Page_model->save_tip($save);
			
			$this->session->set_flashdata('message', 'A new tip has been added.');
			
			//go back to the page list
			redirect($this->config->item('admin_folder').'/tips');
		}
	}
	/********************************************************************
	delete page
	********************************************************************/
	function delete($id)
	{
		
		$page	= $this->Page_model->get_tip($id);
		
		if($page)
		{
			$this->Page_model->delete_tip($id);
			$this->session->set_flashdata('message', lang('message_deleted_page'));
		}
		
		redirect($this->config->item('admin_folder').'/tips');
	}
}

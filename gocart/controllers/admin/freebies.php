<?php
class Freebies extends Admin_Controller
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
		$data['page_title']	= 'Freebies';
		$data['pages']		= $this->Page_model->get_freebies();
		
		
		$this->load->view($this->config->item('admin_folder').'/freebies', $data);
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
		$data['amount']		= '';
                $data['freebie']		= '';
		
		$data['page_title']	= 'Freebies Form';
//		$data['pages']		= $this->Page_model->get_pages();
		
		if($id)
		{
			
			$page			= $this->Page_model->get_freebie($id);

			if(!$page)
			{
				//page does not exist
				$this->session->set_flashdata('error', 'Freebie not found.');
				redirect($this->config->item('admin_folder').'/freebies');
			}
			
			//set values to db values
			$data['id']				= $page->id;
			$data['amount']		= $page->amount;
                        $data['freebie']		= $page->freebie;
		}
		
		$this->form_validation->set_rules('freebie', 'lang:title', 'trim|required');
		
		// Validate the form
		if($this->form_validation->run() == false)
		{
			$this->load->view($this->config->item('admin_folder').'/freebies_form', $data);
		}
		else
		{
			$this->load->helper('text');
			$page			= $this->Page_model->get_freebie($id);
                        if(!$page){
                            $valid = $this->Page_model->check_amount($this->input->post('amount'));
                            if($valid){
                                //amount already exist
                                $this->session->set_flashdata('error', 'Amount already exist.');
                                redirect($this->config->item('admin_folder').'/freebies/form');
                            }
                        }
			$save = array();
			$save['id']			= $id;
			$save['amount']	= $this->input->post('amount');
			$save['freebie']	= $this->input->post('freebie');
                        
			//save the page
			$page_id	= $this->Page_model->save_freebies($save);
			
                        $this->session->set_flashdata('message', 'A new freebie has been added.');
                        //go back to the page list
                        redirect($this->config->item('admin_folder').'/freebies');
                        
                        
		}
	}
	/********************************************************************
	delete page
	********************************************************************/
	function delete($id)
	{
		
		$page	= $this->Page_model->get_freebie($id);
		
		if($page)
		{
			$this->Page_model->delete_freebie($id);
			$this->session->set_flashdata('message', 'The freebie has been deleted.');
		}
		
		redirect($this->config->item('admin_folder').'/freebie');
	}
    
    function statusUpdate(){
        $this->Page_model->updateAJAX($this->input->post('status'),$this->input->post('id'));
    }
}

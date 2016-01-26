<?php
class Tips extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		remove_ssl();

		$this->auth->check_access('Admin', true);

		$this->lang->load('tips');
		$this->load->model('Tip_model');
		$this->load->helper('date');
	}
		
	function index()
	{
		$data['tips']		= $this->Tip_model->get_tips();
		$data['page_title']	= lang('tips');
		
		$this->load->view($this->config->item('admin_folder').'/tips', $data);
	}
	
	function delete($id)
	{
		$this->Tip_model->delete($id);
		$this->session->set_flashdata('message', lang('message_delete_tip'));
		redirect($this->config->item('admin_folder').'/tips');
	}
	
	/********************************************************************
	this function is called by an ajax script, it re-sorts the boxes
	********************************************************************/
	function organize()
	{
		$tips = $this->input->post('tips');
		$this->Tip_model->organize($tips);
	}
	
	function form($id = false)
	{
		
		$config['upload_path']		= 'uploads/tips_upload';
		$config['allowed_types']	= 'gif|jpg|png';
		$config['max_size']			= $this->config->item('size_limit');
//		$config['max_width']		= '1024';
//		$config['max_height']		= '768';
		$config['encrypt_name']		= true;
		$this->load->library('upload', $config);
		
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		//set the default values
		$data	= array(	 'id'=>$id
							,'tip'=>''
							,'image'=>''
						);
		if($id)
		{
			$data				= (array) $this->Tip_model->get_tip($id);
		}
		$data['page_title']	= lang('tip_form');
		
		$this->form_validation->set_rules('tip', 'lang:tip', 'trim|required|full_decode');
		$this->form_validation->set_rules('image', 'lang:image', 'trim');
		
		if ($this->form_validation->run() == false)
		{
			$data['error'] = validation_errors();
			$this->load->view($this->config->item('admin_folder').'/tip_form', $data);
		}
		else
		{	
			
			$uploaded	= $this->upload->do_upload('image');
			
			$save['tip']			= $this->input->post('tip');

			if ($id)
			{
				$save['id']	= $id;
				
				//delete the original file if another is uploaded
				if($uploaded)
				{
					if($data['image'] != '')
					{
						$file = 'uploads/tips_upload/'.$data['image'];
						
						//delete the existing file if needed
						if(file_exists($file))
						{
							unlink($file);
						}
					}
				}
				
			}
			else
			{
				if(!$uploaded)
				{
					$data['error']	= $this->upload->display_errors();
					$this->load->view($this->config->item('admin_folder').'/tip_form', $data);
					return; //end script here if there is an error
				}
			}
			
			if($uploaded)
			{
				$image			= $this->upload->data();
				$save['image']	= $image['file_name'];
			}
			
			$this->Tip_model->save($save);
			
			$this->session->set_flashdata('message', lang('message_tip_saved'));
			
			redirect($this->config->item('admin_folder').'/tips');
		}	
	}
	
}
<?php

class Designs extends Admin_Controller {

    
    function __construct() {
        parent::__construct();
        $this->auth->check_access('Admin', true);

        $this->lang->load('admin');
        $this->load->model('Common_model');
    }

    function index() {
        $data['page_title'] = 'Design';
        $data['designs'] = $this->Common_model->get('designs');
     
        $this->load->view($this->config->item('admin_folder') . '/designs', $data);
    }
	
	function form(){
		$data['page_title'] = 'Design';
		
		$this->load->view($this->config->item('admin_folder') . '/design_form', $data);
	}
	
	function add(){
		
		$config['upload_path'] = 'uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '1024';
		$config['encrypt_name']  = true;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('design'))
		{
			$data['errors'] = $this->upload->display_errors();
			debug($data['errors'], 1);
		}
		else
		{
			$uploaded = $this->upload->data();
			$save['name'] = $this->input->post('name');
			$save['price'] = $this->input->post('price');
			$save['design'] = $uploaded['file_name'];
		
			$this->Common_model->add('designs', $save);
			redirect('admin/designs');
		}
		
	}
	
	function delete($id){
		$this->Common_model->delete('designs', $id);
		redirect('admin/designs');
	}


}
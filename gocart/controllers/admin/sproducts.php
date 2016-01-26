<?php
error_reporting(E_ALL);
class Sproducts extends Admin_Controller {	
	
	private $use_inventory = false;
	function __construct()
	{		
		parent::__construct();
		remove_ssl();

		//$this->auth->check_access('Admin', true);
		
		$this->load->model('Product_model');
		$this->load->model('Common_model');
		$this->load->helper('form');
		$this->lang->load('product');
		
	}
	function index($filter = false)
	{
		$admin = $this->admin_session->userdata('admin');
		
		
		//debug($admin, 1);
		
		$data['page_title']	= ($admin['access'] == 'Admin') ? 'Suppliers Products' : 'My Products';
		$data['filtered']	= false;
		$data['adminstate'] = ($admin['access'] == 'Admin') ? true : false;
		$where2['status'] = 1;
		$data['raws'] = $this->Common_model->get_where('raw', $where2, 1);
		if($admin['access'] == 'Admin'){
			if($filter){
				$data['products'] = $this->Common_model->getCustom($filter);
				$data['filtered']	= true;
				//debug($data['products'], 1);
			}
			else{
				$data['products'] = $this->Common_model->get('products_supplier');
			}
		}
		else{
			$where['sid']  = $admin['id'];
			$data['products'] = $this->Common_model->get_where('products_supplier', $where, 1);
		}
		
		$this->load->view($this->config->item('admin_folder').'/sproducts', $data);
	}
	
	
	function form($id = false, $duplicate = false)
	{
		$data['page_title'] = 'Product Details';
		
		$where['status'] = 1;
		$data['raws'] = $this->Common_model->get_where('raw', $where, 1);
		$admin = $this->admin_session->userdata('admin');
		
		 if($id){
			$where2['id'] = $id;
			$result = $this->Common_model->get_where('products_supplier', $where2, 0);
			$data['id'] = $result->id;
			$data['name'] = $result->name;
			$data['price'] = $result->price;
			$data['type'] = $result->type; 
			$data['qty'] = $result->qty; 
		} 
		else{
			$data['id'] = '';
			$data['name'] = '';
			$data['price'] = '';
			$data['type'] = ''; 
			$data['qty'] = '';
		}
	
		if($this->input->post('name')){
			
			$save['sid'] = $admin['id'];
			$save['name'] = $this->input->post('name');
			$save['price'] = $this->input->post('price');
			$save['unit'] = $this->input->post('unit');
			$save['type'] = $this->input->post('type');
			$save['qty'] = $this->input->post('qty');
			
			if($id){
				$where['id'] = $id;
				$this->Common_model->update('products_supplier', $save, $where);
			}
			else{
				$this->Common_model->add('products_supplier', $save);
			}
			redirect($this->config->item('admin_folder').'/sproducts');
		}
		
		$this->load->view($this->config->item('admin_folder').'/sproduct_form', $data);
	}
	
	function product_image_form()
	{
		$data['file_name'] = false;
		$data['error']	= false;
		
		$this->load->view($this->config->item('admin_folder').'/iframe/product_image_uploader', $data);
	}
	
	function product_image_upload()
	{
		$data['file_name'] = false;
		$data['error']	= false;
		
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size']	= $this->config->item('size_limit');
		$config['upload_path'] = 'uploads/images/full';
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = true;

		$this->load->library('upload', $config);
		
		if ( $this->upload->do_upload())
		{
			$upload_data	= $this->upload->data();
			
			$this->load->library('image_lib');
			/*
			
			I find that ImageMagick is more efficient that GD2 but not everyone has it
			if your server has ImageMagick then you can change out the line
			
			$config['image_library'] = 'gd2';
			
			with
			
			$config['library_path']		= '/usr/bin/convert'; //make sure you use the correct path to ImageMagic
			$config['image_library']	= 'ImageMagick';
			*/			
			
			//this is the larger image
			$config['image_library'] = 'gd2';
			$config['source_image'] = 'uploads/images/full/'.$upload_data['file_name'];
			$config['new_image']	= 'uploads/images/medium/'.$upload_data['file_name'];
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 600;
			$config['height'] = 500;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$this->image_lib->clear();

			//small image
			$config['image_library'] = 'gd2';
			$config['source_image'] = 'uploads/images/medium/'.$upload_data['file_name'];
			$config['new_image']	= 'uploads/images/small/'.$upload_data['file_name'];
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 235;
			$config['height'] = 235;
			$this->image_lib->initialize($config); 
			$this->image_lib->resize();
			$this->image_lib->clear();

			//cropped thumbnail
			$config['image_library'] = 'gd2';
			$config['source_image'] = 'uploads/images/small/'.$upload_data['file_name'];
			$config['new_image']	= 'uploads/images/thumbnails/'.$upload_data['file_name'];
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 150;
			$config['height'] = 150;
			$this->image_lib->initialize($config); 	
			$this->image_lib->resize();	
			$this->image_lib->clear();

			$data['file_name']	= $upload_data['file_name'];
		}
		
		if($this->upload->display_errors() != '')
		{
			$data['error'] = $this->upload->display_errors();
		}
		$this->load->view($this->config->item('admin_folder').'/iframe/product_image_uploader', $data);
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$product	= $this->Product_model->get_product($id);
			//if the product does not exist, redirect them to the customer list with an error
			if (!$product)
			{
				$this->session->set_flashdata('error', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/products');
			}
			else
			{

				// remove the slug
				$this->load->model('Routes_model');
				$this->Routes_model->remove('('.$product->slug.')');

				//if the product is legit, delete them
				$this->Product_model->delete_product($id);

				$this->session->set_flashdata('message', lang('message_deleted_product'));
				redirect($this->config->item('admin_folder').'/products');
			}
		}
		else
		{
			//if they do not provide an id send them to the product list page with an error
			$this->session->set_flashdata('error', lang('error_not_found'));
			redirect($this->config->item('admin_folder').'/products');
		}
	}
}

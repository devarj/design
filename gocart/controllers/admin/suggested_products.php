<?php

Class Suggested_Products extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('suggestedproduct_model');
    }

    function index()
    {
        $data['page_title'] = 'Suggested Products';
        $data['file_list'] = $this->suggestedproduct_model->get_list();

        $this->load->view($this->config->item('admin_folder') . '/suggested_product', $data);
    }

}

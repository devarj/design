<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of form
 *
 * @author JEROME.J
 */
class Form extends Front_Controller
{

    function __construct()
    {
        parent::__construct();
//        echo 'test';
        //make sure we're not always behind ssl
        remove_ssl();
//        force_ssl();
    }

    function index()
    {
        $this->load->view('suggest', '');
    }

    function suggest($post = null)
    {
        if ($post)
        {

            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
            $this->form_validation->set_rules('personal_profile', 'Personal Profile', 'trim|required');
            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
            $this->form_validation->set_rules('product_desc', 'Product Description', 'trim|required');
            if ($this->form_validation->run() == false)
            {

                $this->load->view('suggest', '');
            }
            else
            {
                $insertdata = '';
                $insertdata['name'] = $this->input->post('name');
                $insertdata['email'] = $this->input->post('email');
                $insertdata['personal_profile'] = $this->input->post('personal_profile');
                $insertdata['product_name'] = $this->input->post('product_name');
                $insertdata['product_desc'] = $this->input->post('product_desc');
                $insertdata['date'] = date('Y-m-d H:i:s');
                $this->load->model('suggestedproduct_model');

                $insert = $this->suggestedproduct_model->insert($insertdata);
                echo '<script>alert("Thank you for your suggestion!! ");</script>';
                redirect('form/suggest', 'refresh');
            }
        }
        else
        {
//            $this->CI->session->set_userdata(array('cart_contents' => $this->_cart_contents));
            $cart = $this->session->userdata('cart_contents');
            if ($cart)
            {
                $customer = $cart['customer'];
                $data = array();
                $data['name'] = $customer['firstname'] . $customer['lastname'];
                $data['email'] = $customer['email'];
                $this->load->view('suggest', $data);
            }
        }
    }
    
    function emailsendhomepage()
    {
        
        $message = "subscriber email : <br>";
        $message .= " ".$this->input->post('email');
        $to = "marketing@carlsonphil.com";
$subject = "AKARI SUBSCRIBE";

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:' . $to . "\r\n"; // Sender's Email
//        $headers .= 'Cc:' . $email . "\r\n"; // Carbon copy to Sender
$retval = mail($to, $subject, $message, $headers);
        if($retval)
        {
              redirect(base_url(),'refresh');
        }
                else
        {
            redirect(base_url(),'refresh');
        }
    }

}

<?php

/* Single page checkout controller */

class Checkout extends Front_Controller
{

    function __construct()
    {
        parent::__construct();

        force_ssl();
	
			/* make sure the cart isnt empty */
        if ($this->go_cart->total_items() == 0)
        {
            redirect('cart/view_cart');
        }

        /* is the user required to be logged in? */
        if (config_item('require_login'))
        {
            $this->Customer_model->is_logged_in('checkout');
        }

        if (!config_item('allow_os_purchase') && config_item('inventory_enabled'))
        {
            /* double check the inventory of each item before proceeding to checkout */
            $inventory_check = $this->go_cart->check_inventory();

            if ($inventory_check)
            {
                /*
                  OOPS we have an error. someone else has gotten the scoop on our customer and bought products out from under them!
                  we need to redirect them to the view cart page and let them know that the inventory is no longer there.
                 */
                $this->session->set_flashdata('error', $inventory_check);
                redirect('cart/view_cart');
            }
        }
        $this->load->library('form_validation');
    }

    function index()
    {
        $this->step_1();
    }

    function step_1()
    {
		$customer = $this->go_cart->customer();

		$customer['bill_address']['firstname'] = $customer['firstname'];
		$customer['bill_address']['lastname'] = $customer['lastname'];
		$customer['bill_address']['email'] = $customer['email'];
		$customer['bill_address']['phone'] = $customer['phone'];
		$customer['bill_address']['address1'] = 'Marinduque';
		$customer['bill_address']['city'] = 'Boac, Marinduque';
		$customer['bill_address']['zip'] = '4900';
		$customer['bill_address']['notes'] = '';
		
		
		$this->go_cart->save_customer($customer);
		redirect('checkout/step_2');
    }

    function shipping_address()
    {
        $data['customer'] = $this->go_cart->customer();

        if (isset($data['customer']['id']))
        {
            $data['customer_addresses'] = $this->Customer_model->get_address_list($data['customer']['id']);
        }

        /* require a shipping address */
        $this->form_validation->set_rules('address_id', 'Billing Address ID', 'numeric');
        $this->form_validation->set_rules('firstname', 'lang:address_firstname', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('lastname', 'lang:address_lastname', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('email', 'lang:address_email', 'trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('phone', 'lang:address_phone', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('company', 'lang:address_company', 'trim|max_length[128]');
        $this->form_validation->set_rules('address1', 'lang:address1', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('address2', 'lang:address2', 'trim|max_length[128]');
        $this->form_validation->set_rules('city', 'lang:address_city', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('country_id', 'lang:address_country', 'trim|required|numeric');
        $this->form_validation->set_rules('zone_id', 'lang:address_state', 'trim|required|numeric');
        $this->form_validation->set_rules('deliverydate', 'lang:address_delivery_date', 'trim|required');

        /* if there is post data, get the country info and see if the zip code is required */
        if ($this->input->post('country_id'))
        {
            $country = $this->Location_model->get_country($this->input->post('country_id'));
            if ((bool) $country->postcode_required)
            {
                $this->form_validation->set_rules('zip', 'lang:address_postcode', 'trim|required|max_length[10]');
            }
        }
        else
        {
            $this->form_validation->set_rules('zip', 'lang:address_postcode', 'trim|max_length[10]');
        }

        if ($this->form_validation->run() == false)
        {
            /* show the address form but change it to be for shipping */
            $data['address_form_prefix'] = 'ship';
            $this->view('checkout/address_form', $data);
        }
        else
        {
            /* load any customer data to get their ID (if logged in) */
            $customer = $this->go_cart->customer();

            $customer['ship_address']['company'] = $this->input->post('company');
            $customer['ship_address']['firstname'] = $this->input->post('firstname');
            $customer['ship_address']['lastname'] = $this->input->post('lastname');
            $customer['ship_address']['email'] = $this->input->post('email');
            $customer['ship_address']['phone'] = $this->input->post('phone');
            $customer['ship_address']['address1'] = $this->input->post('address1');
            $customer['ship_address']['address2'] = $this->input->post('address2');
            $customer['ship_address']['city'] = $this->input->post('city');
            $customer['ship_address']['zip'] = $this->input->post('zip');
            $customer['ship_address']['deliverydate'] = $this->input->post('deliverydate');
            $customer['ship_address']['deliverytime'] = $this->input->post('deliverytime');
            $customer['ship_address']['notes'] = $this->input->post('notes');

            /* get zone / country data using the zone id submitted as state */
            $country = $this->Location_model->get_country(set_value('country_id'));
            $zone = $this->Location_model->get_zone(set_value('zone_id'));

            $customer['ship_address']['zone'] = $zone->code;
            $customer['ship_address']['country'] = $country->name;
            $customer['ship_address']['country_code'] = $country->iso_code_2;
            $customer['ship_address']['zone_id'] = $this->input->post('zone_id');
            $customer['ship_address']['country_id'] = $this->input->post('country_id');

            /* for guest customers, load the shipping address data as their base info as well */
            if (empty($customer['id']))
            {
                $customer['company'] = $customer['ship_address']['company'];
                $customer['firstname'] = $customer['ship_address']['firstname'];
                $customer['lastname'] = $customer['ship_address']['lastname'];
                $customer['phone'] = $customer['ship_address']['phone'];
                $customer['email'] = $customer['ship_address']['email'];
            }

            if (!isset($customer['group_id']))
            {
                $customer['group_id'] = 1; /* default group */
            }

            /*  save customer details */
            $this->go_cart->save_customer($customer);

            /* send to the next form */
            redirect('checkout/step_2');
        }
    }

    function step_2()
    {
        /* where to next? Shipping? */
        $shipping_methods = $this->_get_shipping_methods();

        if ($shipping_methods)
        {
            $this->shipping_form($shipping_methods);
        }
        /* now where? continue to step 3 */
        else
        {
            $this->step_3();
        }
    }

    protected function shipping_form($shipping_methods)
    {
        $data['customer'] = $this->go_cart->customer();

        /* do we have a selected shipping method already? */
        $shipping = $this->go_cart->shipping_method();
        $data['shipping_code'] = $shipping['code'];
        $data['shipping_methods'] = $shipping_methods;

        $this->form_validation->set_rules('shipping_notes', 'lang:shipping_information', 'trim|xss_clean');
        $this->form_validation->set_rules('shipping_method', 'lang:shipping_method', 'trim|callback_validate_shipping_option');

        if ($this->form_validation->run() == false)
        {
            $this->view('checkout/shipping_form', $data);
        }
        else
        {
            /* we have shipping details! */
            $this->go_cart->set_additional_detail('shipping_notes', $this->input->post('shipping_notes'));

            /* parse out the shipping information */
            $shipping_method = json_decode($this->input->post('shipping_method'));
            $shipping_code = md5($this->input->post('shipping_method'));

            /* set shipping info */
            $this->go_cart->set_shipping($shipping_method[0], $shipping_method[1]->num, $shipping_code);

            redirect('checkout/step_3');
        }
    }

    /*
      callback for shipping form
      if callback is true then it's being called for form_Validation
      In that case, set the message otherwise just return true or false
     */

    function validate_shipping_option($str, $callback = true)
    {
        $shipping_methods = $this->_get_shipping_methods();

        if ($shipping_methods)
        {
            foreach ($shipping_methods as $key => $val)
            {
                $check = json_encode(array($key, $val));
                if ($str == md5($check))
                {
                    return $check;
                }
            }
        }

        /* if we get there there is no match and they have submitted an invalid option */
        $this->form_validation->set_message('validate_shipping_option', lang('error_invalid_shipping_method'));
        return FALSE;
    }

    private function _get_shipping_methods()
    {
        $shipping_methods = array();
        /* do we need shipping? */

        if (config_item('require_shipping'))
        {
            /* do the cart contents require shipping? */
            if ($this->go_cart->requires_shipping())
            {
                /* ok so lets grab some shipping methods. If none exists, then we know that shipping isn't going to happen! */
                foreach ($this->Settings_model->get_settings('shipping_modules') as $shipping_method => $order)
                {
                    $this->load->add_package_path(APPPATH . 'packages/shipping/' . $shipping_method . '/');
                    /* eventually, we will sort by order, but I'm not concerned with that at the moment */
                    $this->load->library($shipping_method);

                    $shipping_methods = array_merge($shipping_methods, $this->$shipping_method->rates());
                }

                /*  Free shipping coupon applied ? */
                if ($this->go_cart->is_free_shipping())
                {
                    /*  add free shipping as an option, but leave other options in case they want to upgrade */
                    $shipping_methods[lang('free_shipping_basic')] = "0.00";
                }

                /*  format the values for currency display */
                foreach ($shipping_methods as &$method)
                {
                    /*  convert numeric values into an array containing numeric & formatted values */
                    $method = array('num' => $method, 'str' => format_currency($method));
                }
            }
        }
        if (!empty($shipping_methods))
        {
            /* everything says that shipping is required! */
            return $shipping_methods;
        }
        else
        {
            return false;
        }
    }

    function step_3()
    {
        /*
          Some error checking
          see if we have the billing address
         */
        $customer = $this->go_cart->customer();
        if (empty($customer['bill_address']))
        {
            redirect('checkout/step_1');
        }

        /* see if shipping is required and set. */
        if (config_item('require_shipping') && $this->go_cart->requires_shipping() && $this->_get_shipping_methods())
        {
            $code = $this->validate_shipping_option($this->go_cart->shipping_code());

            if (!$code)
            {
                redirect('checkout/step_2');
            }
        }


        //comment if payment modules enabled
//        $this->payment_form($payment_methods);
        
        //uncomment if payment modules enabled
        if ($payment_methods = $this->_get_payment_methods())
        {
            $this->payment_form($payment_methods);
        }
        /* now where? continue to step 4 */
        else
        {
            $this->step_4();
        }
    }

    protected function payment_form($payment_methods)
    {
        /* find out if we need to display the shipping */
        $data['customer'] = $this->go_cart->customer();
        $data['shipping_method'] = $this->go_cart->shipping_method();

        /* are the being bounced back? */
        $data['payment_method'] = $this->go_cart->payment_method();

        /* pass in the payment methods */
        $data['payment_methods'] = $payment_methods;

        /* require that a payment method is selected */
        $this->form_validation->set_rules('module', 'lang:payment_method', 'trim|required');

        $module = $this->input->post('module');
        
        if($module != 'pesopay' && $module != 'bankdeposit' && $module != 'otc_nonbank' && $module != 'ubiz')
        {
            $this->form_validation->set_rules('module', 'lang:payment_method', 'trim|required|xss_clean|callback_check_payment');
            $this->load->add_package_path(APPPATH . 'packages/payment/' . $module . '/');
            $this->load->library($module);
        }

        if ($this->form_validation->run() == false)
        {
            $this->view('checkout/payment_form', $data);
        }
        else
        {
            if($module == 'pesopay'){
                $this->go_cart->set_payment( $module, 'Credit Card' );
            }
            elseif($module == 'ubiz'){
                $this->go_cart->set_payment( $module, 'UBIZ' );
            }
            elseif($module == 'bankdeposit'){
                $this->go_cart->set_payment( $module, 'Bank Deposit' );
            }
            elseif($module == 'otc_nonbank'){
                $this->go_cart->set_payment( $module, 'Over-the-Counter Non-Bank' );
            }
            else
            {
                $this->go_cart->set_payment($module, $this->$module->description());
            }
            redirect('checkout/step_4');
        }
    }

    /* callback that lets the payment method return an error if invalid */

    function check_payment($module)
    {
        $check = $this->$module->checkout_check();

        if (!$check)
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('check_payment', $check);
        }
    }

    private function _get_payment_methods()
    {
        $payment_methods = array();
        if ($this->go_cart->total() != 0)
        {
            foreach ($this->Settings_model->get_settings('payment_modules') as $payment_method => $order)
            {
                $this->load->add_package_path(APPPATH . 'packages/payment/' . $payment_method . '/');
                $this->load->library($payment_method);

                $payment_form = $this->$payment_method->checkout_form();

                if (!empty($payment_form))
                {
                    $payment_methods[$payment_method] = $payment_form;
                }
            }
        }
        if (!empty($payment_methods))
        {
            return $payment_methods;
        }
        else
        {
            return false;
        }
    }

    function step_4()
    {
        /* get addresses */
        $data['customer'] = $this->go_cart->customer();

        $data['shipping_method'] = $this->go_cart->shipping_method();

        $data['payment_method'] = $this->go_cart->payment_method();

        $this->load->model('Product_model');
        $total_amount = $this->go_cart->total();
        $noted_amount = $total_amount + ($total_amount * .20);
        $data['freebie'] = $this->Product_model->get_freebie($total_amount);
        $data['noted_freebie'] = $this->Product_model->get_freebie($noted_amount);
        
        /* Confirm the sale */
        $this->view('checkout/confirm', $data);
    }

    function login()
    {
//        $this->Customer_model->is_logged_in('checkout');
        $this->Customer_model->is_logged_in('cart/view_cart');
    }

    function register()
    {
//        $this->Customer_model->is_logged_in('checkout', 'secure/register');
        $this->Customer_model->is_logged_in('cart/view_cart', 'secure/register');
    }
    
    function ubiz_checkout($order_id)
    {
        $merchant_code = $this->config->item('merchant_code');
        $api_id = $this->config->item('api_key');
        $api_secret = $this->config->item('api_secret');

        $gmt_now = gmdate("M d Y H:i:s", time());
        $gmt_now = strtotime($gmt_now);
        $api_expires = $gmt_now + 28800 + 10800; //GMT + 8 Hours (Philippine Time) + expiration time in secs (in this case 3 hours - 3600*3 = 10800)

        $api_sig = hash_hmac('sha256', $api_expires, $api_secret);

        //prepare fields to populate: see documentation #api-methods-checkouts section -------------------------------------------------------------------
        $fields = array();
        $particular_fields = array();

        $customer = $this->go_cart->customer();
        $contents = $this->go_cart->contents();

        $i = 1;
        foreach($contents as $value){
            $particular_fields['particular_name_'.$i]	  .= $value['name'];
            $particular_fields['particular_price_'.$i]    .= ($value['saleprice'] != '0.00')?$value['saleprice']:$value['price'];
            $particular_fields['particular_quantity_'.$i] .= $value['quantity'];
            $particular_fields['particular_code_'.$i]	  .= $value['sku'];
            $i++;
        }

        $fields = array_merge($fields, $particular_fields); 

        $autopopulate_fields = array('billing_first_name'        => $customer['bill_address']['firstname'],
                                     'billing_last_name'         => $customer['bill_address']['lastname'],
                                     'billing_address_1'         => $customer['bill_address']['address1'],
                                     'billing_address_2'         => $customer['bill_address']['address2'],
                                     'billing_city_municipality' => $customer['bill_address']['city'],
                                     'billing_state_province'    => $customer['bill_address']['zone'],
                                     'billing_country'           => $customer['bill_address']['country'],
                                     'billing_contact_no'        => $customer['bill_address']['phone'],
                                     'billing_email'             => $customer['bill_address']['email'],
                                     'custom_reference'          => 'eGrocery OrderID: '.$order_id
                                    ); //optional


        $fields = array_merge($fields, $autopopulate_fields);

        $fields_string = '';

        foreach($fields as $key=>$value) 
        { 
            $fields_string .= $key.'='.$value.'&'; 
        }
        $fields_string = rtrim($fields_string,"&");

        //prepare checkouts API call ---------------------------------------------------------------------------------------------------------------------
        $checkouts_url = $this->config->item('checkouts_url');

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, $checkouts_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('UNIONBANK-UBIZ-APP-ID:              '.$api_id.'', 
                                                   'UNIONBANK-UBIZ-APP-SIGNATURE:       '.$api_sig.'', 
                                                   'UNIONBANK-UBIZ-APP-MERCHANT-CODE:   '.$merchant_code.'', 
                                                   'UNIONBANK-UBIZ-REQUEST-EXPIRES:     '.$api_expires.''));
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //IMPORTANT: UNCOMMENT for PROD environment
        //Note that even if your data is sent over SSL secured site, a certificate checking is recommended as an added security,
        //by ensuring that your CURL session will not just trust any server certificate
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);                       // verify peer's certificate 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);                          // check the existence of a common name and also verify that it matches the hostname provided
        curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/path/to/file.crt");     // name of a file holding one or more certificates to verify the peer with. 
                                                                                // see documentation #before-going-live section for notes regarding certificate file.

        $result = curl_exec($ch);   

        if(curl_errno($ch))
        {
            //you can log the curl error
            $message = curl_errno($ch).': '.curl_error($ch);
        }
        else
        {
            //you can log the post information
            $info = curl_getinfo($ch);
            $message = 'POST '. $info['url'].' in '.$info['total_time'].' secs. ' . $info['http_code'] .' - '.$fields_string;

            //process returned JSON response, e.g save response
            $data = json_decode($result);
            
            if($data->meta->response_code == '200')
            {
                //redirect your customer to UBIZ payment page
//                echo 'Redirect your customer to UBIZ payment page: <br />'.$data->response->checkout_url;
                $response['redirect'] = $data->response->checkout_url;
                $explode = explode('=', $response['redirect']);
                $response['ubiz_reference_id'] = substr($explode[1], 0, -8); 
                $response['status']   = 'success';
                return $response;
            }
            else
            {
                //capture error and do necessary process
                //log error details 
//                echo 'Log error details: '.$data->meta->error_type.' | '.$data->meta->error_detail.' | '.$data->meta->error_code;
//                $response['error_type']   = $data->meta->error_type;
//                $response['error_detail'] = $data->meta->error_detail;
//                $response['error_code']   = $data->meta->error_code;
                $response['meta'] = 'Log error details: '.$data->meta->error_type.' | '.$data->meta->error_detail.' | '.$data->meta->error_code;
                $response['status']   = 'error';
                return $response;

                //to force error for testing purposes you can change expires value: $api_expires = $gmt_now - 28800 + 10800;
            }
        }    

        echo '<hr />';
        echo "CURL action: <pre>$message;</pre>";
        echo "CURL raw result: <pre>".print_r($result, true)."</pre>";     

        curl_close($ch);
    }
    
    function over_the_counter_email($order_number)
    {
        $this->load->model('Order_model');
        $data['order_id'] = $order_number;
        $data['order']	  = $this->Order_model->get_order_by_number($order_number);
        $customer = $this->go_cart->customer();
        
        // Send the user a bank deposit email
        // - get the email template
        $this->load->model('messages_model');
        $row = $this->messages_model->get_message(9);

        $row['content'] = html_entity_decode($row['content']);

        // set replacement values for subject & body
        // {site_name}
        $row['subject'] = str_replace('{site_name}', $this->config->item('company_name'), $row['subject']);
        
        // {bank_deposit}
        $row['content'] = str_replace('{bank_deposit}', $this->load->view('bankdeposit_email', $data, true), $row['content']);

        $this->load->library('email');

        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $this->email->from($this->config->item('email'), $this->config->item('company_name'));

        if ($this->Customer_model->is_logged_in(false, false))
        {
            $this->email->to($customer['email']);
        }
        else
        {
            $this->email->to($customer['ship_address']['email']);
        }

        //email the admin
        $this->email->bcc($this->config->item('email'));

        $this->email->subject($row['subject']);
        $this->email->message($row['content']);

        $this->email->send();
    }

    function place_order()
    {
        
        // retrieve the payment method
        $payment = $this->go_cart->payment_method();
        $payment_methods = $this->_get_payment_methods();

        //make sure they're logged in if the config file requires it
        if ($this->config->item('require_login'))
        {
			
			
            $this->Customer_model->is_logged_in();
        }
        
        // are we processing an empty cart?
        $contents = $this->go_cart->contents();
        if (empty($contents))
        {
            redirect('cart/view_cart');
        }
        else
        {
            //  - check to see if we have a payment method set, if we need one
            if (empty($payment) && $this->go_cart->total() > 0 && (bool) $payment_methods == true)
            {
                redirect('checkout/step_3');
            }
        }

        if (!empty($payment) && (bool) $payment_methods == true)
        {
            if($payment['module'] == 'ubiz'){
                $result = $this->ubiz_checkout();
                if ($result['status'] == 'error'){
                    $this->session->set_flashdata('error', $result['meta']);
                    redirect('checkout/step_3');
                }
            }
            //check if pesopay or ubiz
            if ($payment['module'] != 'pesopay' && $payment['module'] != 'bankdeposit' && $payment['module'] != 'otc_nonbank' && $payment['module'] != 'ubiz'){
                //load the payment module
                $this->load->add_package_path(APPPATH . 'packages/payment/' . $payment['module'] . '/');
                $this->load->library($payment['module']);

                // Is payment bypassed? (total is zero, or processed flag is set)
                if ($this->go_cart->total() > 0 && !isset($payment['confirmed']))
                {
                    //run the payment
                    $error_status = $this->$payment['module']->process_payment();
                    if ($error_status !== false)
                    {
                        // send them back to the payment page with the error
                        $this->session->set_flashdata('error', $error_status);
                        redirect('checkout/step_3');
                    }
                }
            }
        }
		
		$c = $this->go_cart->customer();
		$region = $c['bill_address']['zone'];
		$content = $this->go_cart->contents();
		
		foreach($content as $key => $value){
			$weight += $value['weight'];
		}
		
		$delivery_charge = 0;
		// if($region == 'NCR'){
			// if($weight > 3){
				// $delivery_charge = 79;
				// $add = ($weight - 3) * 30;
				// $delivery_charge += $add;
			// }
			// else{
				// $delivery_charge = 79;
			// }
		// }
		// else{
			// if($weight > 3){
				// $delivery_charge = 149;
				// $add = ($weight - 3) * 50;
				// $delivery_charge += $add;
			// }
			// else{
				// $delivery_charge = 149;
			// }
		// }
		
        // save the order
        $order_id = $this->go_cart->save_order($delivery_charge);
        
        // save the freebie
        $this->load->model('Product_model');
        $total_amount = $this->go_cart->total();
        $data['order_freebie'] = $this->Product_model->get_freebie($total_amount);
        if($data['order_freebie']){
            $save['order_id'] = $order_id;
            $save['freebie'] = $data['order_freebie']->freebie;
            $this->Product_model->order_freebies($save);
        }
    
        $data['order_id'] = $order_id;
        $data['shipping'] = $this->go_cart->shipping_method();
        $data['payment'] = $this->go_cart->payment_method();
        $data['customer'] = $this->go_cart->customer();
        $data['shipping_notes'] = $this->go_cart->get_additional_detail('shipping_notes');
        $data['referral'] = $this->go_cart->get_additional_detail('referral');

        $order_downloads = $this->go_cart->get_order_downloads();

        $data['hide_menu'] = true;

        // run the complete payment module method once order has been saved
        if (!empty($payment))
        {
            if (method_exists($this->$payment['module'], 'complete_payment'))
            {
                $this->$payment['module']->complete_payment($data);
            }
        }

//        // Send the user a confirmation email
//        // - get the email template
//        $this->load->model('messages_model');
//        $row = $this->messages_model->get_message(7);
//
//        $download_section = '';
//        if (!empty($order_downloads))
//        {
//            // get the download link segment to insert into our confirmations
//            $downlod_msg_record = $this->messages_model->get_message(8);
//
//            if (!empty($data['customer']['id']))
//            {
//                // they can access their downloads by logging in
//                $download_section = str_replace('{download_link}', anchor('secure/my_downloads', lang('download_link')), $downlod_msg_record['content']);
//            }
//            else
//            {
//                // non regs will receive a code
//                $download_section = str_replace('{download_link}', anchor('secure/my_downloads/' . $order_downloads['code'], lang('download_link')), $downlod_msg_record['content']);
//            }
//        }
//
//        $row['content'] = html_entity_decode($row['content']);
//
//        // set replacement values for subject & body
//        // {customer_name}
//        $row['subject'] = str_replace('{customer_name}', $data['customer']['firstname'] . ' ' . $data['customer']['lastname'], $row['subject']);
//        $row['content'] = str_replace('{customer_name}', $data['customer']['firstname'] . ' ' . $data['customer']['lastname'], $row['content']);
//
//        // {url}
//        $row['subject'] = str_replace('{url}', $this->config->item('base_url'), $row['subject']);
//        $row['content'] = str_replace('{url}', $this->config->item('base_url'), $row['content']);
//
//        // {site_name}
//        $row['subject'] = str_replace('{site_name}', $this->config->item('company_name'), $row['subject']);
//        $row['content'] = str_replace('{site_name}', $this->config->item('company_name'), $row['content']);
//
//        // {order_summary}
//        $row['content'] = str_replace('{order_summary}', $this->load->view('order_email', $data, true), $row['content']);
//
//        // {download_section}
//        $row['content'] = str_replace('{download_section}', $download_section, $row['content']);
//
//        $this->load->library('email');
//
//        $config['mailtype'] = 'html';
//        $this->email->initialize($config);
//
//        $this->email->from($this->config->item('email'), $this->config->item('company_name'));
//
//        if ($this->Customer_model->is_logged_in(false, false))
//        {
//            $this->email->to($data['customer']['email']);
//        }
//        else
//        {
//            $this->email->to($data['customer']['ship_address']['email']);
//        }
//
//        //email the admin
//        $this->email->bcc($this->config->item('email'));
//
//        $this->email->subject($row['subject']);
//        $this->email->message($row['content']);
//
//        $this->email->send();

        $data['page_title'] = 'Thanks for shopping with ' . $this->config->item('company_name');
        $data['gift_cards_enabled'] = $this->gift_cards_enabled;
        $data['download_section'] = $download_section;

        /*  get all cart information before destroying the cart session info */
        $delivery_charge = ($this->config->item('allow_delivery_charge')) ? $this->config->item('delivery_amount') : 0;
		
		$region = $data['customer']['bill_address']['zone'];
	
		
		foreach($content as $key => $value){
			$weights += $value['weight'];
		}
		$delivery_charge = 0;
        $data['go_cart']['group_discount'] = $this->go_cart->group_discount();
        $data['go_cart']['subtotal'] = $this->go_cart->subtotal();
        $data['go_cart']['coupon_discount'] = $this->go_cart->coupon_discount();
        $data['go_cart']['order_tax'] = $this->go_cart->order_tax();
        $data['go_cart']['discounted_subtotal'] = $this->go_cart->discounted_subtotal();
        $data['go_cart']['shipping_cost'] = $this->go_cart->shipping_cost();
        $data['go_cart']['gift_card_discount'] = $this->go_cart->gift_card_discount();
        $data['go_cart']['total'] = $this->go_cart->total() + $delivery_charge;
		$data['go_cart']['delivery_charge'] = $delivery_charge;
        $data['go_cart']['contents'] = $this->go_cart->contents();

        if($payment['module'] == 'pesopay'){
            header('Location: https://test.pesopay.com/b2cDemo/eng/payment/payForm.jsp?orderRef='.$order_id.'&amount='.$data['go_cart']['total'].'&currCode=608&lang=E&merchantId=18060614&failUrl=http://121.58.243.67/prod/nxled/cart/pesopay/fail/'.$order_id.'&successUrl=http://121.58.243.67/prod/nxled/cart/pesopay/success/'.$order_id.'&cancelUrl=http://121.58.243.67/prod/nxled/cart/pesopay/cancel/'.$order_id.'&payType=N&payMethod=ALL&remark=Asiapay nxled Order ID: '.$orderID);
//            header('Location: https://www.pesopay.com/b2c2/eng/payment/payForm.jsp?orderRef='.$order_id.'&amount='.$data['go_cart']['total'].'&currCode=608&lang=E&merchantId=18139028&failUrl=http://192.21.0.57/prod/nxled/cart/pesopay/fail/'.$order_id.'&successUrl=http://192.21.0.57/prod/nxled/cart/pesopay/success/'.$order_id.'&cancelUrl=http://192.21.0.57/prod/nxled/cart/pesopay/cancel/'.$order_id.'&payType=N&payMethod=ALL&remark=Asiapay nxled Order ID: '.$orderID);
        }
        elseif($payment['module'] == 'ubiz')
        {
            $result = $this->ubiz_checkout($order_id);
            if ($result['status'] == 'success'){
                $update['ubiz_reference_id'] = $result['ubiz_reference_id'];
                $update['order_number'] = $order_id;
                $this->Order_model->update_order($update);
                header('Location: '.$result['redirect']);
            }
        }
        elseif($payment['module'] == 'bankdeposit')
        {
            $this->over_the_counter_email($order_id);
        }
        elseif($payment['module'] == 'otc_nonbank')
        {
            $this->over_the_counter_email($order_id);
        }
                
        /* remove the cart from the session */
        $this->go_cart->destroy();

        /*  show final confirmation page */
        $this->load->view('order_placed', $data);
    }
    

}

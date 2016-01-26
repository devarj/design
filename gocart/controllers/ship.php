<?php

class Ship extends Front_Controller
{

    function __construct()
    {
        parent::__construct();
//        echo 'test';
        //make sure we're not always behind ssl
        remove_ssl();
        $this->load->model('Autoship_model');
        $this->load->model('location_model');
//        force_ssl();
    }

    function index()
    {
        redirect('ship/view_all');
    }

    function post()
    {
//        echo '<pre>';
//        var_dump($_POST);
//        echo '</pre>';
        $xcustomer = $this->go_cart->customer();
        $customer_id = $xcustomer['id'];
        $default_billing_address = $xcustomer['default_billing_address'];
        $default_shipping_address = $xcustomer['default_shipping_address'];
        $array_product_id = $this->input->post('productid');
        $array_qty = $this->input->post('qty');
        $array_total_per_item = $this->input->post('subtotal');
        $total_price = $this->input->post('total_price');
        $cron = $this->input->post('cron');
        $deliverydate = $this->input->post('deliverydate');
        if ($customer_id)
        {

            if (!$default_billing_address)
            {
                echo '<script>alert("Please select default address and shipping. To run the Auto shipment Process. Thank you ");</script>';
                redirect('secure/my_account', 'refresh');
            }
            if (!$default_shipping_address)
            {
                echo '<script>alert("Please select default address and shipping. To run the Auto shipment Process. Thank you ");</script>';
                redirect('secure/my_account', 'refresh');
            }
            if ($cron == 'Weekly')
            {
                $cron_schedule = date('Y-m-d H:i:s', strtotime("+7 day", strtotime($deliverydate)));
            }
            elseif ($cron == 'Monthly')
            {
                $cron_schedule = date('Y-m-d H:i:s', strtotime("+1 month", strtotime($deliverydate)));
            }
            $autoship = array(
                'customer_id' => $customer_id,
                'default_billing_address' => $default_billing_address,
                'default_shipping_address' => $default_shipping_address,
                'total_price' => $total_price,
                'run_every' => $cron,
                'date_start' => date('Y-m-d H:i:s', strtotime($deliverydate)),
                'date_updated' => date('Y-m-d H:i:s'), // date('Y-m-d H:i:s'),
                'cron_date' => $cron_schedule, // date('Y-m-d H:i:s'),
            );
            $ship_id = $this->Autoship_model->insert_autoship($autoship);
            if ($ship_id)
            {

                for ($x = 0; $x <= count($array_product_id) - 1; $x ++)
                {
                    $product_id = $array_product_id[$x];
                    $product_qty = $array_qty[$x];
                    $product_total = $array_total_per_item[$x];
                    $autoship_details = array(
                        'ship_id' => $ship_id,
                        'product_id' => $product_id,
                        'quantity' => $product_qty,
                        'price' => $product_total,
                    );
                    $shipdetails_id = $this->Autoship_model->insert_autoship_details($autoship_details);
                }
                echo '<script>alert("Auto Ship Item Added!");</script>';
                redirect('ship/view_all', 'refresh');
            }
        }
        else
        {
            //not login
        }
    }

    function add()
    {
        //login first
        $this->Customer_model->is_logged_in('secure/my_account/');

        $customer = $this->go_cart->customer();
        if ($customer)
        {

            $ship = $customer['ship_address'];
            $bill = $customer['bill_address'];
            if (!$ship)
            {
                echo '<script>alert("Please select default address and shipping. To run the Auto shipment Process. Thank you ");</script>';
                redirect('secure/my_account', 'refresh');
            }

            if (!$bill)
            {
                echo '<script>alert("Please select default address and shipping. To run the Auto shipment Process. Thank you ");</script>';
                redirect('secure/my_account', 'refresh');
            }
        }
        $data['products'] = $this->Product_model->get_all_products();
//        $data['products'] = $this->Product_model->get_products($data['category']->id, $config['per_page'], $page, $sort_by['by'], $sort_by['sort']);

        foreach ($data['products'] as &$p)
        {
            $p->images = (array) json_decode($p->images);
            $p->options = $this->Option_model->get_product_options($p->id);
        }

        $this->load->view('ship/add_ship', $data);
    }

    function view_all()
    {
        /*         * start run cron auto ship */
        $data = array();
        $cron_data = $this->Autoship_model->get_cron();
        $customer = $this->go_cart->customer();
        if ($cron_data && $customer)
        {
            //prepare our data for being inserted into the database
            $save = array();
            $save['status'] = 'Pending';

            $save['customer_id'] = $customer['id'];

            $ship = $customer['ship_address'];
            $bill = $customer['bill_address'];
            if (!$ship)
            {
                echo '<script>alert("Please select default address and shipping. To run the Auto shipment Process. Thank you ");</script>';
                redirect('secure/my_account', 'refresh');
            }

            if (!$bill)
            {
                echo '<script>alert("Please select default address and shipping. To run the Auto shipment Process. Thank you ");</script>';
                redirect('secure/my_account', 'refresh');
            }

            $save['company'] = $customer['company'];
            $save['firstname'] = $customer['firstname'];
            $save['lastname'] = $customer['lastname'];
            $save['phone'] = $customer['phone'];
            $save['email'] = $customer['email'];

            $save['ship_company'] = $ship['company'];
            $save['ship_firstname'] = $ship['firstname'];
            $save['ship_lastname'] = $ship['lastname'];
            $save['ship_email'] = $ship['email'];
            $save['ship_phone'] = $ship['phone'];
            $save['ship_address1'] = $ship['address1'];
            $save['ship_address2'] = $ship['address2'];
            $save['ship_city'] = $ship['city'];
            $save['ship_zip'] = $ship['zip'];
            $save['ship_zone'] = $ship['zone'];
            $save['ship_zone_id'] = $ship['zone_id'];
            $save['ship_country'] = $ship['country'];
            $save['ship_country_id'] = $ship['country_id'];

            $save['bill_company'] = $bill['company'];
            $save['bill_firstname'] = $bill['firstname'];
            $save['bill_lastname'] = $bill['lastname'];
            $save['bill_email'] = $bill['email'];
            $save['bill_phone'] = $bill['phone'];
            $save['bill_address1'] = $bill['address1'];
            $save['bill_address2'] = $bill['address2'];
            $save['bill_city'] = $bill['city'];
            $save['bill_zip'] = $bill['zip'];
            $save['bill_zone'] = $bill['zone'];
            $save['bill_zone_id'] = $bill['zone_id'];
            $save['bill_country'] = $bill['country'];
            $save['bill_country_id'] = $bill['country_id'];
            if (isset($bill['notes'])):
                $save['notes'] = $bill['notes'];
            endif;

            $deliverydate = date('Y-m-d', strtotime($cron_data[0]->cron_date));
            $deliverytime = date('H:i:s', strtotime($cron_data[0]->cron_date));
            $save['shipped_on'] = $deliverydate . ' ' . $deliverytime;
            //shipping information
            $save['shipping_method'] = 0;
            $save['shipping'] = 100;
            //add in the other charges
            $save['tax'] = 0;
            //discounts
            $save['gift_card_discount'] = 0;
            $save['coupon_discount'] = 0;
            $save['reward_points'] = 0;
            $save['subtotal'] = $cron_data[0]->total_price;
            $save['total'] = $cron_data[0]->total_price + $save['shipping'];

            //store the payment info
            $save['payment_info'] = '';
            $save['ordered_on'] = date('Y-m-d H:i:s');
            $contents = array();
            foreach ($cron_data as $key => $value)
            {
                $products = $this->Autoship_model->get_productbyShipID($value->id);
                foreach ($products as $key => $value)
                {
                    $contents[] = $value;
                }
            }

//            $order_id = $this->Autoship_model->save_order($save, $contents); comment munaw
        }


        /*         * end run cron auto ship */


        $data = array();
        $data['address'] = $this->Autoship_model->getaddress($customer['id']);
        $data['autoship'] = $this->Autoship_model->view_all();

        foreach ($data['autoship'] as $key => $value)
        {
            $data['autoship_details'][$value->id] = $this->Autoship_model->view_byShipID($value->id);
        }
        $this->load->view('ship/view_all', $data);
    }

    function add_address($id = 0)
    {
        $data = array();
        $customer = $this->go_cart->customer();

        //grab the address if it's available
        $data['id'] = false;
        $data['company'] = $customer['company'];
        $data['firstname'] = $customer['firstname'];
        $data['lastname'] = $customer['lastname'];
        $data['email'] = $customer['email'];
        $data['phone'] = $customer['phone'];
        $data['address1'] = '';
        $data['address2'] = '';
        $data['city'] = '';
        $data['country_id'] = '';
        $data['zone_id'] = '';
        $data['zip'] = '';


        if ($id != 0)
        {
            $a = $this->Customer_model->get_address($id);
            if ($a['customer_id'] == $this->customer['id'])
            {
                //notice that this is replacing all of the data array
                //if anything beyond this form data needs to be added to
                //the data array, do so after this portion of code
                $data = $a['field_data'];
                $data['id'] = $id;
            }
            else
            {
                redirect('/'); // don't allow cross-customer editing
            }

            $data['zones_menu'] = $this->location_model->get_zones_menu($data['country_id']);
        }

        //get the countries list for the dropdown
        $data['countries_menu'] = $this->location_model->get_countries_menu();

        if ($id == 0)
        {
            //if there is no set ID, the get the zones of the first country in the countries menu
            $data['zones_menu'] = $this->location_model->get_zones_menu(array_shift(array_keys($data['countries_menu'])));
        }
        else
        {
            $data['zones_menu'] = $this->location_model->get_zones_menu($data['country_id']);
        }

        $this->load->view('ship/add_address', $data);
    }

    function address_form($id = 0)
    {
        $this->load->model('location_model');
        $customer = $this->go_cart->customer();

        //grab the address if it's available
        $data['id'] = false;
        $data['company'] = $customer['company'];
        $data['firstname'] = $customer['firstname'];
        $data['lastname'] = $customer['lastname'];
        $data['email'] = $customer['email'];
        $data['phone'] = $customer['phone'];
        $data['address1'] = '';
        $data['address2'] = '';
        $data['city'] = '';
        $data['country_id'] = '';
        $data['zone_id'] = '';
        $data['zip'] = '';


        if ($id != 0)
        {
            $a = $this->Customer_model->get_address($id);
            if ($a['customer_id'] == $this->customer['id'])
            {
                //notice that this is replacing all of the data array
                //if anything beyond this form data needs to be added to
                //the data array, do so after this portion of code
                $data = $a['field_data'];
                $data['id'] = $id;
            }
            else
            {
                redirect('/'); // don't allow cross-customer editing
            }

            $data['zones_menu'] = $this->location_model->get_zones_menu($data['country_id']);
        }

        //get the countries list for the dropdown
        $data['countries_menu'] = $this->location_model->get_countries_menu();

        if ($id == 0)
        {
            //if there is no set ID, the get the zones of the first country in the countries menu
            $data['zones_menu'] = $this->location_model->get_zones_menu(array_shift(array_keys($data['countries_menu'])));
        }
        else
        {
            $data['zones_menu'] = $this->location_model->get_zones_menu($data['country_id']);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('company', 'Company', 'trim|max_length[128]');
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('address1', 'Address', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('address2', 'Address', 'trim|max_length[128]');
        $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('country_id', 'Country', 'trim|required|numeric');
        $this->form_validation->set_rules('zone_id', 'State', 'trim|required|numeric');
        $this->form_validation->set_rules('zip', 'Zip', 'trim|required|max_length[32]');


        if ($this->form_validation->run() == FALSE)
        {
            if (validation_errors() != '')
            {
                echo validation_errors();
            }
            else
            {
                $this->load->view('address_form', $data);
            }
        }
        else
        {
            $a = array();
            $a['id'] = ($id == 0) ? '' : $id;
            $a['customer_id'] = $customer['id'];
            $a['field_data']['company'] = $this->input->post('company');
            $a['field_data']['firstname'] = $this->input->post('firstname');
            $a['field_data']['lastname'] = $this->input->post('lastname');
            $a['field_data']['email'] = $this->input->post('email');
            $a['field_data']['phone'] = $this->input->post('phone');
            $a['field_data']['address1'] = $this->input->post('address1');
            $a['field_data']['address2'] = $this->input->post('address2');
            $a['field_data']['city'] = $this->input->post('city');
            $a['field_data']['zip'] = $this->input->post('zip');

            // get zone / country data using the zone id submitted as state
            $country = $this->location_model->get_country(set_value('country_id'));
            $zone = $this->location_model->get_zone(set_value('zone_id'));
            if (!empty($country))
            {
                $a['field_data']['zone'] = $zone->code;  // save the state for output formatted addresses
                $a['field_data']['country'] = $country->name; // some shipping libraries require country name
                $a['field_data']['country_code'] = $country->iso_code_2; // some shipping libraries require the code 
                $a['field_data']['country_id'] = $this->input->post('country_id');
                $a['field_data']['zone_id'] = $this->input->post('zone_id');
            }

            $this->Autoship_model->save_address($a);
            $this->session->set_flashdata('message', lang('message_address_saved'));
            echo 1;
        }
    }

    function delete($id)
    {
        $this->Autoship_model->delete($id);
        redirect('ship/view_all', 'refresh');
    }

}

<?php
class waybill extends Admin_Controller{
    function __construct()
	{
		parent::__construct();

		force_ssl();

		$this->load->library('form_validation');
	}
	public function index(){
		
	}
	public function generate_waybill($ordernumber){
        
		$this->load->model('xend_model');
		$this->load->model('email_model');
		$this->load->model('Order_model');
		$data['order_number'] = $ordernumber;
		$data['waybill_no']   = $this->generate_waybill_no();
//		$data['xend_waybill_no']=$this->generate_xend_waybill_no($ordernumber);
//		echo $ordernumber;
		foreach($this->xend_model->get_orders_by_number($ordernumber) as $rs){
			$data['address1'] = $rs->ship_address1." ".$rs->ship_city.", ".$rs->ship_zone.", ".$rs->ship_country;
			$data['address2'] = $rs->ship_address2;
			$data['city']     = $rs->ship_city;
			$data['country']  = $rs->ship_country;
			$data['fullname'] = $rs->ship_lastname." ". $rs->ship_firstname;
			$data['subtotal']   = $rs->subtotal;
			$data['amount']   = $rs->total;
			$data['company']  = $rs->ship_company;
			$data['phone']    = $rs->ship_phone;
			$data['email']    = $rs->ship_email;
			$data['currency'] = $rs->currency;
		}
        
        foreach($this->xend_model->get_pickup_address($ordernumber) as $result){
			$data['pickup_location'] = $result->pickup_address;
		}

//		$data['products_orders'] = $this->email_model->get_order_product($ordernumber);
		$data['products_orders'] = $this->Order_model->get_order_by_number($ordernumber);

		$this->load->view('admin/waybill_form',$data);
		

	}

	public function insert_waybill(){
		$this->load->model('xend_model');
        $waybill   = $this->input->post('waybillno');
        $order_num = $this->input->post('order_num');
        
        $this->form_validation->set_rules('pickUpLoc', 'Pickup Location', 'trim|required');
        $this->form_validation->set_rules('pickUpPerson', 'Pickup Person', 'trim|required');
        $this->form_validation->set_rules('pickUpContact', 'Contact Details', 'trim|required');
        $this->form_validation->set_rules('pickupDate', 'Pickup Date', 'required');
        
        if ($this->form_validation->run() == false)
		{
            $this->generate_waybill($order_num);
//			$this->load->view('admin/waybill_form',$data);
//            header("Location: ".base_url("index.php/waybill/generate_waybill/".$order_num));   
		}
		else
		{
//            $datePickup    = $this->input->post('year')."-".$this->input->post('month')."-".$this->input->post('day');
            $datePickup    = $this->input->post('pickupDate');
            $timepickup    = $this->input->post('hour').":".$this->input->post('min');
            $pickupLoc     = $this->input->post('pickUpLoc');
            $pickUpPerson  = $this->input->post('pickUpPerson');
            $pickUpContact = $this->input->post('pickUpContact');
            
            $this->xend_model->update_wayBill($order_num,$waybill,$timepickup,$datePickup,$pickupLoc,$pickUpPerson,$pickUpContact);
            //$this->xend_model->update_xend_wayBill($order_num,$waybill,$timepickup,$datePickup,$pickupLoc);
            header("Location: ".base_url("admin/orders"));   
        }
	}

	public function generate_waybill_no(){
		if (function_exists('com_create_guid') === true) {
			return trim(com_create_guid(), '{}');
		}
		return 'NXL'.sprintf('%04X%04X%04', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	public function generate_xend_waybill_no($ordernumber){
		error_reporting(E_ALL);
		//require_once('lib/nusoap.php');
		// declare variables
			$exceptionFlag = false;
		// initialize SOAP clients
			$wsdl = 'https://www.xend.com.ph/api/ShipmentService.asmx?wsdl';
			$client = new SoapClient($wsdl, array());
			$funcs = $client->__getFunctions();
		// initialize SOAP header
		/*$headerbody = array('UserToken' => '92c14d24-bebb-49a8-a7b5-8a8358fb137e');*/
		//test waybill
		//http://www.xend.com.ph/GetWaybill.aspx?no=736345530
			$headerbody = array('UserToken' => '92c14d24-bebb-49a8-a7b5-8a8358fb137e');
			$header = new SoapHeader ('https://www.xend.com.ph/api/', 'AuthHeader', $headerbody);
			$client->__setSoapHeaders($header);
		// prepare parameters
		// all orders
		$this->load->model('xend_model');
		//print_r($this->xend_model->get_orders_by_number($ordernumber));
		foreach($this->xend_model->get_orders_by_number($ordernumber) as $order){
//			if($order->ship_zone=="Metro Manila"){
//				$shipping_fee=79;
//			} else {
//				$shipping_fee=150;
//			}
            $shipping_fee = $order->shipping;
			$param = array(
				'ServiceTypeValue' => 'MetroManilaExpress', //drop
				'ShipmentTypeValue' => 'Parcel', //parcel always
				'Weight' => 0.50,
				'DimensionL' => 0.00,
				'DimensionW' => 0.00,
				'DimensionH' => 0.00,
				'DeclaredValue' => $order->total,
				'RecipientName' => $order->ship_firstname.' '.$order->ship_lastname,
				'RecipientCompanyName' => $order->ship_company,
				'RecipientAddress1' =>  $order->ship_address1,
				'RecipientAddress2' => $order->ship_address2,
				'RecipientCity' => $order->ship_city,
				'RecipientProvince' =>  $order->ship_zone, //drop
				'RecipientCountry' => $order->ship_country,
				'IsInsured' => 0,
				'SpecialInstructions' => 'Fragile',
				'Description' => 'DESCRIPTION',
				'ClientReference' => $order->order_number, //order_no
				'PurposeOfExportValue' => 'None',
				'DateCreated' => date('Y-m-d\TH\:i\:s\.u', time()),
				'DatePrinted' => date('Y-m-d\TH\:i\:s\.u', time()),
				'ShippingFee' => $shipping_fee, // 
				'InsuranceFee' => 0
			);
		}
		// execute SOAP method
		try
		{
			$result = $client->Create(array('shipment' => $param));
			//$result = $client->__soapCall("Create", array("shipment" => $param));
		}
		catch (SoapFault $soapfault)
		{
			$exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			echo "<b> Error : </b> ". $error[0][1];
			//echo $soapfault->faultcode;
		}
		if (!$exceptionFlag){
			return $result->CreateResult;
		}
	}
	
	/*START-ADD-WAYBILL PRINT (2014-03-06)*/
	public function print_waybill($ordernumber){
		$this->load->model('xend_model');
		$this->load->model('email_model');
		$data['order_number']= $ordernumber;
		
		foreach($this->xend_model->get_orders_by_number($ordernumber) as $rs){
			$data['address1']       = ucwords(strtolower($rs->ship_address1." ".$rs->ship_city.", ".$rs->ship_zone.", ".$rs->ship_country));
			$data['address2']       = ucwords(strtolower($rs->ship_address2));
			$data['city']           = $rs->ship_city;
			$data['fullname']       = ucwords(strtolower($rs->ship_lastname." ". $rs->ship_firstname));
			$data['amount']         = ($rs->currency=='dollar') ? 'USD '.number_format($rs->total_dollar,2) : 'Php '.number_format($rs->total,2);
			$data['currency']       = $rs->currency;
			$data['company']        = $rs->ship_company;
			$data['phone']          = $rs->ship_phone;
			$data['email']          = $rs->ship_email;
			$data['waybill_no']     = $rs->waybill_no;
			$data['xend_waybillno'] = $rs->xend_waybillno;
			$data['pickup_loc']     = ucwords(strtolower($rs->pickup_loc));
			$data['pickup_date']    = $rs->pickup_date;
			$data['pickup_time']    = $rs->pickup_time;
			$data['pickup_person']  = ucwords(strtolower($rs->pickup_person));
			$data['pickup_contact'] = ucwords(strtolower($rs->pickup_contact));
		}
		
		$data['products_orders'] = $this->email_model->get_order_product($ordernumber);
        
        $order_quantity = 0;
        foreach($data['products_orders'] as $rs){
            $data['weight'] = $rs->weight;
            $order_quantity = $order_quantity + $rs->order_quantity;
        }
        $data['total_weight'] = $order_quantity * $data['weight'] . ' kg';

		$this->load->view('admin/waybill_print',$data);
	}
    
    public function print_waybill2out($ordernumber){
		$this->load->model('xend_model');
		$this->load->model('email_model');
		$data['order_number']= $ordernumber;
		
		foreach($this->xend_model->get_orders_by_number($ordernumber) as $rs){
			$data['address1']       = ucwords(strtolower($rs->ship_address1." ".$rs->ship_city.", ".$rs->ship_zone.", ".$rs->ship_country));
			$data['address2']       = ucwords(strtolower($rs->ship_address2));
			$data['city']           = $rs->ship_city;
			$data['fullname']       = ucwords(strtolower($rs->ship_lastname." ". $rs->ship_firstname));
			$data['amount']         = ($rs->currency=='dollar') ? 'USD '.number_format($rs->total_dollar,2) : 'Php '.number_format($rs->total,2);
			$data['currency']       = $rs->currency;
			$data['company']        = $rs->ship_company;
			$data['phone']          = $rs->ship_phone;
			$data['email']          = $rs->ship_email;
			$data['waybill_no']     = $rs->waybill_no;
			$data['xend_waybillno'] = $rs->xend_waybillno;
			$data['pickup_loc']     = ucwords(strtolower($rs->pickup_loc));
			$data['pickup_date']    = $rs->pickup_date;
			$data['pickup_time']    = $rs->pickup_time;
			$data['pickup_person']  = ucwords(strtolower($rs->pickup_person));
			$data['pickup_contact'] = ucwords(strtolower($rs->pickup_contact));
		}
		
		$data['products_orders'] = $this->email_model->get_order_product($ordernumber);
        
        $order_quantity = 0;
        foreach($data['products_orders'] as $rs){
            $data['weight'] = $rs->weight;
            $order_quantity = $order_quantity + $rs->order_quantity;
        }
        $data['total_weight'] = $order_quantity * $data['weight'] . ' kg';

		$this->load->view('admin/waybill_print2outs',$data);
	}
	/*END-ADD-WAYBILL PRINT (2014-03-06)*/
}
?>
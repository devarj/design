<?php
class invoice extends Admin_Controller{
	public function index(){
		
	}
	public function generate_invoice($ordernumber){
		$this->load->model('xend_model');
		$this->load->model('email_model');
		$data['order_number']= $ordernumber;
		
		foreach($this->xend_model->get_orders_by_number($ordernumber) as $rs){
			$data['address1']     = $rs->ship_address1;
			$data['address2']     = $rs->ship_address2;
			$data['city']         = $rs->ship_city;
			$data['fullname']     = $rs->ship_lastname." ". $rs->ship_firstname;
			$data['lastname']     = $rs->ship_lastname;
			$data['amount']       = $rs->total;
//			$data['amount']       = ($rs->currency=='dollar') ? $rs->total_dollar :  $rs->total;
//			$data['currency']     = $rs->currency;
			$data['company']      = $rs->ship_company;
			$data['phone']        = $rs->ship_phone;
			$data['email']        = $rs->ship_email;
			$data['waybill_no']   = $rs->waybill_no;
			$data['invoice_no']   = $rs->invoice_no;
			$data['shipped_on']   = $rs->shipped_on;
//			$data['app_id']       = $rs->app_id;
//			$data['app_url']=$rs->app_url;
			$data['invoice_date'] = $rs->invoice_date;
//			$data['grandtotal']   = ($rs->grandtotal == '0.00') ? $rs->total : $rs->grandtotal;
			$data['grandtotal']   = $rs->total;
		}
//		$data['invoicenum']=$this->generate_invoice_no($data['app_id'],$data['lastname']);
		$data['invoicenum']=$this->generate_invoice_no();

		$data['products_orders']=$this->email_model->get_order_product($ordernumber);

		$this->load->view('admin/invoice_form',$data);
		

	}
	/*START-ADD-REMITTANCE OPTION (ELAINEM) 2014-03-21*/
	public function view_invoice($ordernumber){
		$this->load->model('xend_model');
		$this->load->model('email_model');
		$data['order_number']= $ordernumber;
		
		foreach($this->xend_model->get_orders_by_number($ordernumber) as $rs){
			$data['address1']=$rs->ship_address1;
			$data['address2']=$rs->ship_address2;
			$data['city']=$rs->ship_city;
			$data['fullname']=$rs->ship_lastname." ". $rs->ship_firstname;
			$data['amount']       = ($rs->currency=='dollar') ? $rs->total_dollar :  $rs->total;
			$data['currency']     = $rs->currency;
			$data['company']=$rs->ship_company;
			$data['phone']=$rs->ship_phone;
			$data['email']=$rs->ship_email;
			$data['waybill_no']=$rs->waybill_no;
			$data['invoice_no']=$rs->invoice_no;
			$data['shipped_on']=$rs->shipped_on;
			$data['app_id']=$rs->app_id;
//			$data['app_url']=$rs->app_url;
			$data['invoice_date']=$rs->invoice_date;
			$data['checkpayeename']=$rs->checkpayeename;
			$data['invoicenum']=$rs->invoice_no;
			$data['grandtotal']= ($rs->grandtotal == '0.00') ? $rs->total : $rs->grandtotal;
		}
		$data['products_orders']=$this->email_model->get_order_product($ordernumber);

		$this->load->view('admin/invoice_view',$data);
	}
	/*END-ADD-REMITTANCE OPTION (ELAINEM) 2014-03-21*/
	public function insert_invoice(){
		$this->load->model('xend_model');
		$this->load->model('email_model');
		$invoiceno= $this->input->post('invoiceno');
		$order_num=$this->input->post('order_num');
	/*START-ADD-REMITTANCE OPTION (ELAINEM) 2014-03-21*/
		$chkpayeename=$this->input->post('chkpayeename');
	/*END-ADD-REMITTANCE OPTION (ELAINEM) 2014-03-21*/
		$invoice_date = date('Y-m-d H:i:s', strtotime($this->input->post('invoicedate')));
		
	/*START-REV-REMITTANCE OPTION (ELAINEM) 2014-03-21*/
		//$this->xend_model->update_invoice($order_num,$invoiceno,$invoice_date);
		$this->xend_model->update_invoice($order_num,$invoiceno,$invoice_date,$chkpayeename);
	/*END-REV-REMITTANCE OPTION (ELAINEM) 2014-03-21*/
//		header("Location: ".base_url("index.php/invoice/thankyou_invoice"));
        $this->thankyou_invoice();
	}
	
	public function thankyou_invoice(){
		/*$this->load->model('xend_model');
		$this->load->model('email_model');
		$invoice= $this->input->post('invoiceno');
		$order_num=$this->input->post('order_num');
		$invoice_date= date('Y-m-d H:i:s', strtotime($this->input->post('invoice_date')));
		
		$this->xend_model->update_invoice($order_num,$invoice,$invoice_date);*/
		$this->load->view('admin/invoice_thankyou');
	}

//	public function generate_invoice_no($app_id,$lastname){
//		if (function_exists('com_create_guid') === true) {
//			return trim(com_create_guid(), '{}');
//		}
//		foreach($this->xend_model->get_totalorders_by_id($app_id) as $rs){
//			$data['lastname']=strtolower($rs->ship_lastname);
//			$data['totalorders']=$rs->totalorders;
//		}
//		if ($data['totalorders'] == 0){
//			$count = 1;
//		} else {
//			$count = $data['totalorders'] + 1;
//		}
//		$invoicenum = strtolower($lastname)."-".str_pad((string)$count, 5, "0", STR_PAD_LEFT);
//		//return sprintf('%04X%04X%04', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
//		return $invoicenum;
//	}
	public function generate_invoice_no(){
		if (function_exists('com_create_guid') === true) {
			return trim(com_create_guid(), '{}');
		}
//		foreach($this->xend_model->get_totalorders_by_id($app_id) as $rs){
//			$data['lastname']=strtolower($rs->ship_lastname);
//			$data['totalorders']=$rs->totalorders;
//		}
//		if ($data['totalorders'] == 0){
//			$count = 1;
//		} else {
//			$count = $data['totalorders'] + 1;
//		}
//		$invoicenum = strtolower($lastname)."-".str_pad((string)$count, 5, "0", STR_PAD_LEFT);
		return 'NXLIVN'.sprintf('%04X%04X%04', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
//		return $invoicenum;
	}
}
?>
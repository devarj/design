<?php

class Cart extends Front_Controller
{

    function __construct()
    {
        parent::__construct();
        remove_ssl();
    }

    function index()
    {
        $this->load->model(array('Banner_model', 'box_model'));
        $this->load->helper('directory');

        $data['gift_cards_enabled'] = $this->gift_cards_enabled;
        $data['banners'] = $this->Banner_model->get_homepage_banners(5);
        $data['boxes'] = $this->box_model->get_homepage_boxes(4);
        $data['featured_products'] = $this->Product_model->get_featured_products(5);
        $data['homepage'] = true;
		//grab the products using the pagination lib
        $data['products'] = $this->Product_model->get_products($data['category']->id, $config['per_page'], $page, $sort_by['by'], $sort_by['sort']);
        foreach ($data['products'] as &$p)
        {
            $p->images = (array) json_decode($p->images);
            $p->options = $this->Option_model->get_product_options($p->id);
        }
		
		$data['designs'] = $this->Common_model->get_sort('designs', 'id', 'random');
        $this->load->view('homepage', $data);

    }
	
	
	function custom_order(){
		
		$data['page_title'] = 'Custom Order';
		
		$this->load->view('custom_order', $data);
	}
	
	function open_order($id){
		
		$data['content'] = $this->Order_model->get_order($id);
		
		if($data['content']->customqty != null){
			$this->load->view('editcustomshirt', $data);
		}
		else if($data['content']->customsize != null){
			$this->load->view('editcustomtarp', $data);
		}
		else{
			$this->load->view('editorder', $data);
		}
	}
	
	function update_qty($id, $oid, $qty){
		
		
		$order = $this->Order_model->get_order($oid);
	
		
		foreach($order->contents as $oc){
			$order->contents[$id]['quantity'] = $qty;
			$order->contents[$id]['subtotal'] = $qty * $order->contents[$id]['price'];
		}
		foreach($order->contents as $oc){
			$price += $oc['subtotal'];
		}
		
		$save['id'] = $oid;
		$save['total'] = $price;
		$save['subtotal'] = $price;
		//debug($save, 1);
		//debug($order->contents, 1);
		//$result = $this->Order_model->save_order($save);
		$this->Order_model->save_order($save);
		$this->Order_model->update_content($oid, $order->contents);
		//echo $result;
		
		redirect('cart/open_order/'.$oid);
		
	}

    function save_custom($id = 0){
		if($id != 0){
			$save['id'] = $id;
		}
		
		$customer = $this->go_cart->customer();
		$save['customer_id'] = $customer['id'];
		$save['firstname'] = $customer['firstname'];
		$save['bill_firstname'] = $customer['firstname'];
		$save['lastname'] = $customer['lastname'];
		$save['bill_lastname'] = $customer['lastname'];
		$save['phone'] = $customer['phone'];
		$save['email'] = $customer['email'];
		$save['total'] = $this->input->post('qty') * $this->input->post('price');
		$save['subtotal'] = $this->input->post('qty') * $this->input->post('price');

        $save['customdata'] = $this->input->post('data');
        $save['customqty'] = $this->input->post('qty');
        $save['customobj'] = $this->input->post('count');
        $save['ordered_on'] = date('Y-m-d h:i:s');
		
		//debug($save, 1);
	
       $result = $this->Order_model->save_order($save);
	   echo $result;
    }
	
	function save_customtarp($id = 0){
		if($id != 0){
			$save['id'] = $id;
		}
		
		$customer = $this->go_cart->customer();
		$save['customer_id'] = $customer['id'];
		$save['firstname'] = $customer['firstname'];
		$save['bill_firstname'] = $customer['firstname'];
		$save['lastname'] = $customer['lastname'];
		$save['bill_lastname'] = $customer['lastname'];
		$save['phone'] = $customer['phone'];
		$save['email'] = $customer['email'];
		$save['total'] = $this->input->post('price');
		$save['subtotal'] = $this->input->post('price');

        $save['customdata'] = $this->input->post('data');
        $save['customsize'] = $this->input->post('size');
        $save['customobj'] = $this->input->post('count');
        $save['ordered_on'] = date('Y-m-d h:i:s');
		
		//debug($save, 1);
	
       $result = $this->Order_model->save_order($save);
	   echo $result;
    }
	
	function uploadimg(){
		
		
		if(isset($_FILES)){
			$target_dir = "uploads/".date('U');
			$target_file = $target_dir . basename($_FILES["file"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["file"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			
			// Allow certain file formats
			if($imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "pdf"
			&& $imageFileType != "jpg" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					echo basename( date('U').$_FILES["file"]["name"]);
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
		}
	}
	
	function uploadFile($id){
		
		
		if(isset($_FILES)){
			$target_dir = "uploads/attached".date('U');
			$target_file = $target_dir . basename($_FILES["file"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			/* if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["file"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			} */
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			
			// Allow certain file formats
			/* if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			} */
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$save['id'] = $id;
					$save['attached']  =  basename( 'attached'.date('U').$_FILES["file"]["name"]);
					$this->Order_model->save_order($save);
					echo basename( 'attached'.date('U').$_FILES["file"]["name"]);
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
		}
	}

	function customshirt(){
		
		$this->load->view('customshirt');
	}
	
	function customtarp(){
		
		$this->load->view('customtarp');
	}
	
	function loadshirt(){
		$this->load->view('loadshirt');
	}
	
	function cancel_order($id){
		if($id){
			$where['id'] = $id;
			$data['payment_status'] = 'Cancelled';
			$this->Common_model->update('orders', $data, $where);
			redirect('secure/my_account');
		}
	}
    
    function allproducts()
    {
       $segments = $this->uri->total_segments();
        $base_url = $this->uri->segment_array();

        if ($data['category']->slug == $base_url[count($base_url)])
        {
            $page = 0;
            $segments++;
        }
        else
        {
            $page = array_splice($base_url, -1, 1);
            $page = $page[0];
        }


        if ($this->session->userdata('daily_tips'))
        {
            $data['daily_tip'] = $this->session->userdata('daily_tips');
        }
        else
        {
        $today = $this->Category_model->get_tip();
        $data['daily_tip'] = $today[0];
        $this->session->set_userdata('daily_tips', $data['daily_tip']);
        }

        $this->load->model('Order_model');
        $data['best_sellers'] = $this->Order_model->get_best_sellers_home($start, $end);
        $this->load->model('Product_model');
        $data['featured_products'] = $this->Product_model->get_featured_products(5);
        
       
        $data['base_url'] = $base_url;

        $data['subcategories'] = $this->Category_model->get_categories();
        //$data['mainsubcategory'] = $this->Category_model->get_main_category();
        $data['product_columns'] = $this->config->item('product_columns');
        $data['gift_cards_enabled'] = $this->gift_cards_enabled;

        $data['meta'] = '';
        $data['seo_title'] = 'Home';
        $data['page_title'] = 'Home';

        $sort_array = array(
            'name/asc' => array('by' => 'products.name', 'sort' => 'ASC'),
            'name/desc' => array('by' => 'products.name', 'sort' => 'DESC'),
            'price/asc' => array('by' => 'products.price', 'sort' => 'ASC'),
            'price/desc' => array('by' => 'products.price', 'sort' => 'DESC'),
        );
//        $sort_by = array('by' => 'sequence', 'sort' => 'ASC');
          $sort_by = array('by' => 'products.name', 'sort' => 'ASC');

        if (isset($_GET['by']))
        {
            if (isset($sort_array[$_GET['by']]))
            {
                $sort_by = $sort_array[$_GET['by']];
            }
        }

        //set up pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('cart/allproducts');
        $config['uri_segment'] = $segments;
        $config['per_page'] = 24;
        $config['total_rows'] = $this->Product_model->count_all_products_enable();

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        //grab the products using the pagination lib
        $data['products'] = $this->Product_model->get_products_all($config['per_page'], $page, $sort_by['by'], $sort_by['sort']);

        foreach ($data['products'] as &$p)
        {
            $p->images = (array) json_decode($p->images);
            $p->options = $this->Option_model->get_product_options($p->id);
        }
        $this->load->view('category', $data);
    }

    function page($id = false)
    {
        //if there is no page id provided redirect to the homepage.
        $data['page'] = $this->Page_model->get_page($id);
        if (!$data['page'])
        {
            show_404();
        }
        $this->load->model('Page_model');
        $data['base_url'] = $this->uri->segment_array();

        $data['fb_like'] = true;

        $data['page_title'] = $data['page']->title;

        $data['meta'] = $data['page']->meta;
        $data['seo_title'] = (!empty($data['page']->seo_title)) ? $data['page']->seo_title : $data['page']->title;

        $data['gift_cards_enabled'] = $this->gift_cards_enabled;

        if ($this->session->userdata('daily_tips'))
        {
            $data['daily_tip'] = $this->session->userdata('daily_tips');
        }
        else
        {
        $today = $this->Category_model->get_tip();
//            $data['daily_tip'] = $today[0]->tip;
        $data['daily_tip'] = $today[0];
        $this->session->set_userdata('daily_tips', $data['daily_tip']);
        }
        
        $this->load->view('page', $data);
    }

    function search($code = false, $page = 0)
    {
        $this->load->model('Search_model');

        //check to see if we have a search term
        if (!$code)
        {
            //if the term is in post, save it to the db and give me a reference
            $term = $this->input->post('term', true);
            if (!$term)//for osclass portal
            {
                $term = $this->input->post('sPattern', true); //for osclass portal
            }
            $code = $this->Search_model->record_term($term);

            // no code? redirect so we can have the code in place for the sorting.
            // I know this isn't the best way...
            redirect('cart/search/' . $code . '/' . $page);
        }
        else
        {
            //if we have the md5 string, get the term
            $term = $this->Search_model->get_term($code);
        }

        if (empty($term))
        {
            //if there is still no search term throw an error
            //if there is still no search term throw an error
            $this->session->set_flashdata('error', lang('search_error'));
            redirect('cart');
        }
        $data['page_title'] = lang('search');
        $data['gift_cards_enabled'] = $this->gift_cards_enabled;

        //fix for the category view page.
        $data['base_url'] = array();

        $sort_array = array(
            'name/asc' => array('by' => 'name', 'sort' => 'ASC'),
            'name/desc' => array('by' => 'name', 'sort' => 'DESC'),
            'price/asc' => array('by' => 'price', 'sort' => 'ASC'),
            'price/desc' => array('by' => 'price', 'sort' => 'DESC'),
        );
        $sort_by = array('by' => false, 'sort' => false);

        if (isset($_GET['by']))
        {
            if (isset($sort_array[$_GET['by']]))
            {
                $sort_by = $sort_array[$_GET['by']];
            }
        }


        if (empty($term))
        {
            //if there is still no search term throw an error
            $this->load->view('search_error', $data);
        }
        else
        {

            $data['page_title'] = lang('search');
            $data['gift_cards_enabled'] = $this->gift_cards_enabled;

            //set up pagination
            $this->load->library('pagination');
            $config['base_url'] = base_url() . 'cart/search/' . $code . '/';
            $config['uri_segment'] = 4;
            $config['per_page'] = 20;

            $config['first_link'] = 'First';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';

            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $config['prev_link'] = '&laquo;';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['next_link'] = '&raquo;';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $result = $this->Product_model->search_products($term, $config['per_page'], $page, $sort_by['by'], $sort_by['sort']);
            $config['total_rows'] = $result['count'];
            $this->pagination->initialize($config);

            $data['products'] = $result['products'];
            foreach ($data['products'] as &$p)
            {
                $p->images = (array) json_decode($p->images);
                $p->options = $this->Option_model->get_product_options($p->id);
            }
            $this->load->view('category', $data);
        }
    }

    function view_tips($id = false)
    {
        $this->load->model('Tip_model');
        $data['hash'] = $id;
        $data['tips'] = $this->Tip_model->get_tips(1);
        $this->load->view('view_tips', $data);
    }

    function category($id)
    {
        //get the category
        $data['category'] = $this->Category_model->get_category($id);

        if (!$data['category'])
        {
            show_404();
        }

        //set up pagination
        $segments = $this->uri->total_segments();
        $base_url = $this->uri->segment_array();

        if ($data['category']->slug == $base_url[count($base_url)])
        {
            $page = 0;
            $segments++;
        }
        else
        {
            $page = array_splice($base_url, -1, 1);
            $page = $page[0];
        }


        if ($this->session->userdata('daily_tips'))
        {
            $data['daily_tip'] = $this->session->userdata('daily_tips');
        }
        else
        {
        $today = $this->Category_model->get_tip();
//            $data['daily_tip'] = $today[0]->tip;
        $data['daily_tip'] = $today[0];
        $this->session->set_userdata('daily_tips', $data['daily_tip']);
        }

        $this->load->model('Order_model');
        $data['best_sellers'] = $this->Order_model->get_best_sellers_home($start, $end);
        $this->load->model('Product_model');
        $data['featured_products'] = $this->Product_model->get_featured_products(5);
        
        /*
          $date = date('Y-m-d');
          $validator_tips = $this->Category_model->check_daily($date);
          if ($validator_tips[0]->numrows == 0)
          {
          $today = $this->Category_model->get_tip();
          $data['daily_tip'] = $today[0]->tip;
          $this->Category_model->insert_tip($today[0]->id);
          }
          else
          {
          $today = $this->Category_model->get_tiptoday();
          $data['daily_tip'] = $today[0];
          }
         */
        $data['base_url'] = $base_url;
        $base_url = implode('/', $base_url);

        $data['subcategories'] = $this->Category_model->get_categories($data['category']->id);
        $data['mainsubcategory'] = $this->Category_model->get_main_category($data['category']->id);
        $data['product_columns'] = $this->config->item('product_columns');
        $data['gift_cards_enabled'] = $this->gift_cards_enabled;

        $data['meta'] = $data['category']->meta;
        $data['seo_title'] = (!empty($data['category']->seo_title)) ? $data['category']->seo_title : $data['category']->name;
        $data['page_title'] = $data['category']->name;

        $sort_array = array(
            'name/asc' => array('by' => 'products.name', 'sort' => 'ASC'),
            'name/desc' => array('by' => 'products.name', 'sort' => 'DESC'),
            'price/asc' => array('by' => 'products.price', 'sort' => 'ASC'),
            'price/desc' => array('by' => 'products.price', 'sort' => 'DESC'),
        );
        $sort_by = array('by' => 'sequence', 'sort' => 'ASC');

        if (isset($_GET['by']))
        {
            if (isset($sort_array[$_GET['by']]))
            {
                $sort_by = $sort_array[$_GET['by']];
            }
        }

        //set up pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url($base_url);
        $config['uri_segment'] = $segments;
        $config['per_page'] = 24;
        $config['total_rows'] = $this->Product_model->count_products($data['category']->id);

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        //grab the products using the pagination lib
        $data['products'] = $this->Product_model->get_products($data['category']->id, $config['per_page'], $page, $sort_by['by'], $sort_by['sort']);
        foreach ($data['products'] as &$p)
        {
            $p->images = (array) json_decode($p->images);
            $p->options = $this->Option_model->get_product_options($p->id);
        }

        $this->load->view('category', $data);
    }

    function search_auto()
    {
        if (!empty($_GET['name_startsWith']))
        {
            $results	= $this->Product_model->search_autocomplete($_GET['name_startsWith'], '10');
            $return		= array();
            foreach($results as $r)
            {
                $return[$r->name]	= $r->name;
            }
            echo json_encode($return);
        }
        else 
        {
            echo json_encode('');
        }
    }

    function product($id)
    {
        //get the product
        $data['product'] = $this->Product_model->get_product($id);
		
		$data['stock'] = getStock($data['product']->stock_id);
		
		
		
        if (!$data['product'] || $data['product']->enabled == 0)
        {
            show_404();
        }

        $data['base_url'] = $this->uri->segment_array();

        // load the digital language stuff
        $this->lang->load('digital_product');

        $data['options'] = $this->Option_model->get_product_options($data['product']->id);

        $related = $data['product']->related_products;
        $data['related'] = array();

        if ($this->session->userdata('daily_tips'))
        {
            $data['daily_tip'] = $this->session->userdata('daily_tips');
        }
        else
        {
        $today = $this->Category_model->get_tip();
        $data['daily_tip'] = $today[0];
        $this->session->set_userdata('daily_tips', $data['daily_tip']);
        }

        $data['posted_options'] = $this->session->flashdata('option_values');

        $data['page_title'] = $data['product']->name;
        $data['meta'] = $data['product']->meta;
        $data['seo_title'] = (!empty($data['product']->seo_title)) ? $data['product']->seo_title : $data['product']->name;

        if ($data['product']->images == 'false')
        {
            $data['product']->images = array();
        }
        else
        {
            $data['product']->images = array_values((array) json_decode($data['product']->images));
        }

        $data['gift_cards_enabled'] = $this->gift_cards_enabled;

        $this->load->view('product', $data);
    }
	
	function supplier() {
        $this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div>', '</div>');
		
		$data['base_url'] = $this->uri->segment_array();
		$data['title'] = "I want to be a supplier";
		
		$data['fullName'] = '';
		$data['yourCompany'] = '';
		$data['contactNumber'] = '';
		$data['address'] = '';
		$data['message'] = '';

		$this->form_validation->set_rules('company', 'Company', 'trim|max_length[128]');
		$this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('fullName', 'Full Name', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('contactNumber', 'Contact Number', 'trim|required|max_length[32]|integer');
		

        if ($this->form_validation->run() == FALSE) {
            //if they have submitted the form already and it has returned with errors, reset the redirect
            if ($this->input->post('submitted')) {
                $data['redirect'] = $this->input->post('redirect');
            }

            $this->load->helper('directory');

            $this->load->view('contact', $data);
        } else {
            // success
            // echo "success";
            $save['id'] = false;
            $save['fullName'] = $this->input->post('fullName');
            $save['yourCompany'] = $this->input->post('yourCompany');
            $save['contactNumber'] = $this->input->post('contactNumber');
            $save['address'] = $this->input->post('address');
            $save['message'] = $this->input->post('message');

            $this->load->library('email');

            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;

            $this->email->initialize($config);

            $this->email->from("admin@localhost.cc", "Administrator");
            $this->email->to("johnconradl18@gmail.com");
            $this->email->subject('Email Test');
            $this->email->message($this->messageContent($save));
            // echo $this->messageContent($save);
            $this->email->send();
            // echo $this->email->print_debugger();
            $data['success'] = "Successfully sent!";
            $this->load->view('contact', $data);
        }
	}

    function messageContent($save) {
        $message = "<html><body>Full Name: " . $save['fullName'] . '<br/>' .
                   "Company: " . $save['yourCompany'] . '<br/>' .
                   "Contact Number: " . $save['contactNumber'] . '<br/>' .
                   "Address: " . $save['address'] . '<br/>' .
                   "Message: " . $save['message'] . "</body> 
                    </html> ";

        return $message;
    }
	
    function set_rewardpoints()
    {

        if ($this->go_cart->customer())
        {
            $this->load->model('Category_model');
            $cart_content = $this->session->userdata('cart_contents');
            foreach ($cart_content['items'] as $item => $value)
            {

                $product = $this->Category_model->getCategory($value['id']);
                $products = $product[0];
                $category_id = $products->id;
                $reward_price = number_format($products->reward_price);
                $reward_points = $products->reward_points;
                $item_subtotal = $value['subtotal'];
                if ($reward_price != 0 && $reward_points != 0)
                {


                    if ($this->session->userdata('cat_' . $category_id))
                    {
                        $session = $this->session->userdata('cat_' . $category_id);
                        $totalprice = number_format($item_subtotal) + number_format($session['pprice']);
                        if ($session['rprice'] <= $totalprice)
                        {

                            $newpoints1 = intval($totalprice / $session['rprice']);
                            $newpoints1 = $session['rpoints'] * $newpoints1;
                            if ($session['rprice'] == $totalprice)
                            {
                                $remainder = 0;
                            }
                            else
                            {
                                $remainder = $totalprice - ($newpoints1 * $session['rprice']);
                            }
                            $data = array('rpoints' => $session['rpoints'], 'rprice' => $session['rprice'], 'pprice' => $remainder, 'ppoints' => $newpoints1 + $session['ppoints']);
                            $this->session->set_userdata('cat_' . $category_id, $data);
                        }
                        else
                        {
                            $data = array('rpoints' => $session['rpoints'], 'rprice' => $session['rprice'], 'pprice' => $totalprice, 'ppoints' => $session['ppoints']);
                            $this->session->set_userdata('cat_' . $category_id, $data);
                        }
                    }
                    else
                    {
                        if ($reward_price <= $item_subtotal)
                        {
                            $newpoints1 = intval($item_subtotal / $reward_price);
                            $newpoints1 = $reward_points * $newpoints1;

                            if ($reward_price == $item_subtotal)
                            {
                                $remainder = 0;
                            }
                            else
                            {
                                $remainder = $item_subtotal - ($newpoints1 * $reward_price);
                            }
                            $data = array('rpoints' => $reward_points, 'rprice' => $reward_price, 'pprice' => $remainder, 'ppoints' => $newpoints1);
                            $this->session->set_userdata('cat_' . $category_id, $data);
                        }
                        else
                        {
                            $data = array('rpoints' => $reward_points, 'rprice' => $reward_price, 'pprice' => $item_subtotal, 'ppoints' => 0);
                            $this->session->set_userdata('cat_' . $category_id, $data);
                        }
                    }
                }
            }
//        print_r('<pre>');
//        print_r($this->session->userdata('cat_1'));
//        print_r('</pre>');
//
//        die();
        }
        else
        {
            return true;
        }
    }

    function ajax_cart()
    {
        // Get our inputs
        $product_id = $this->input->post('id');

//        $this->session->unset_userdata('cat_1');
//        $this->set_rewardpoints($_GET['id'], 2);
        $quantity = 1;
        $post_options = $this->input->post('option');
        // Get a cart-ready product array
        $product = $this->Product_model->get_cart_ready_product($product_id, $quantity);

        //if out of stock purchase is disabled, check to make sure there is inventory to support the cart.
        if (!$this->config->item('allow_os_purchase') && (bool) $product['track_stock'])
        {
            $stock = $this->Product_model->get_product($product_id);

            //loop through the products in the cart and make sure we don't have this in there already. If we do get those quantities as well
            $items = $this->go_cart->contents();
            $qty_count = $quantity;
            foreach ($items as $item)
            {
                if (intval($item['id']) == intval($product_id))
                {
                    $qty_count = $qty_count + $item['quantity'];
                }
            }

            if ($stock->quantity < $qty_count)
            {
                //we don't have this much in stock
                $this->session->set_flashdata('error', sprintf(lang('not_enough_stock'), $stock->name, $stock->quantity));
                $this->session->set_flashdata('quantity', $quantity);
                $this->session->set_flashdata('option_values', $post_options);

                redirect($this->Product_model->get_slug($product_id));
            }
        }

        // Validate Options 
        // this returns a status array, with product item array automatically modified and options added
        //  Warning: this method receives the product by reference
        $status = $this->Option_model->validate_product_options($product, $post_options);

        // don't add the product if we are missing required option values
        if (!$status['validated'])
        {
            $this->session->set_flashdata('quantity', $quantity);
            $this->session->set_flashdata('error', $status['message']);
            $this->session->set_flashdata('option_values', $post_options);

            redirect($this->Product_model->get_slug($product_id));
        }
        else
        {

            //Add the original option vars to the array so we can edit it later
            $product['post_options'] = $post_options;

            //is giftcard
            $product['is_gc'] = false;

            // Add the product item to the cart, also updates coupon discounts automatically
            $this->go_cart->insert($product);
            echo $this->go_cart->total_items();
            // go go gadget cart!
//            redirect('cart/view_cart');
        }
    }

    function add_to_cart()
    {
        // Get our inputs
		
        $product_id = $this->input->post('id');
        $quantity = $this->input->post('quantity');
        $post_options = $this->input->post('option');

        // Get a cart-ready product array
        $product = $this->Product_model->get_cart_ready_product($product_id, $quantity);
		
		//debug($product, 1);

        //if out of stock purchase is disabled, check to make sure there is inventory to support the cart.
        if (!$this->config->item('allow_os_purchase') && (bool) $product['track_stock'])
        {
            $stock = $this->Product_model->get_product($product_id);

            //loop through the products in the cart and make sure we don't have this in there already. If we do get those quantities as well
            $items = $this->go_cart->contents();
            $qty_count = $quantity;
            foreach ($items as $item)
            {
                if (intval($item['id']) == intval($product_id))
                {
                    $qty_count = $qty_count + $item['quantity'];
                }
            }

            if ($stock->quantity < $qty_count)
            {
                //we don't have this much in stock
                $this->session->set_flashdata('error', sprintf(lang('not_enough_stock'), $stock->name, $stock->quantity));
                $this->session->set_flashdata('quantity', $quantity);
                $this->session->set_flashdata('option_values', $post_options);

                redirect($this->Product_model->get_slug($product_id));
            }
        }

        // Validate Options 
        // this returns a status array, with product item array automatically modified and options added
        //  Warning: this method receives the product by reference
        $status = $this->Option_model->validate_product_options($product, $post_options);

        // don't add the product if we are missing required option values
        if (!$status['validated'])
        {
            $this->session->set_flashdata('quantity', $quantity);
            $this->session->set_flashdata('error', $status['message']);
            $this->session->set_flashdata('option_values', $post_options);

            redirect($this->Product_model->get_slug($product_id));
        }
        else
        {

            //Add the original option vars to the array so we can edit it later
            $product['post_options'] = $post_options;

            //is giftcard
            $product['is_gc'] = false;
			
			
            $product['stock_id'] = $this->input->post('stock_id');

            // Add the product item to the cart, also updates coupon discounts automatically
            $this->go_cart->insert($product);

            // go go gadget cart!
            redirect('cart/view_cart');
        }
    }

    function pesopay($status, $id)
    {
       
        $this->load->model('Order_model');
        switch ($status)
        {
            case 'success':
  /** Start jeromejose save reward points */
                
                   /**start save order */
                                    $save['order_number'] = $id;
                                    $save['payment_status'] = 'Paid';
                                    $this->Order_model->update_order($save);
                                    $this->session->set_flashdata('message', lang('pesopay_success'));
                                    redirect(site_url());
                /**end save order */
/*
                if (!config_item('reward_points_per_totalprice'))
                {
                    $customer = $this->go_cart->customer();
                    if ($customer)
                    {
                        if (!$this->session->userdata('click_rewards_points'))
                        {
                            $this->load->model('Category_model');
                            $countallcategories = $this->Category_model->count_categories();
                            $all_pppoints = 0;
                            for ($counter = 1; $counter <= $countallcategories; $counter ++)
                            {
                                if ($this->session->userdata('cat_' . $counter))
                                {
                                    $session = $this->session->userdata('cat_' . $counter);
                                    $all_pppoints +=$session['ppoints'];
                                }
                            }
                            if ($all_pppoints != 0)
                            {
                                $customer = $this->Customer_model->get_customer($customer['id']);
                                $array = array();
                                $array['id'] = $customer->id;
                                $array['reward_points'] = $customer->reward_points + $all_pppoints;
                                $true = $this->Customer_model->save($array);
                                if (!$true)
                                {
                                    // send them back to the payment page with the error
                                    $this->session->set_flashdata('error', 'Customer Reward Point error in insert. Please contact Administrator.');
                                    redirect(site_url());
                                }
                                else
                                {
                                    $save['order_number'] = $id;
                                    $save['payment_status'] = 'Paid';
                                    $this->Order_model->update_order($save);
                                	$this->session->set_flashdata('message', lang('pesopay_success'));
                                    redirect(site_url());
                                }
                            }
                        }
                        else
                        {
                             $this->load->model('Category_model');
                            $countallcategories = $this->Category_model->count_categories();
                            $all_pppoints = 0;
                            for ($counter = 1; $counter <= $countallcategories; $counter ++)
                            {
                                if ($this->session->userdata('cat_' . $counter))
                                {
                                    $session = $this->session->userdata('cat_' . $counter);
                                    $all_pppoints +=$session['ppoints'];
                                }
                            }
                            if ($all_pppoints != 0)
                            {
                                $customer = $this->Customer_model->get_customer($customer['id']);
                                $array = array();
                                $array['id'] = $customer->id;
                                $array['reward_points'] =  $all_pppoints;
                                $true = $this->Customer_model->save($array);
                                if (!$true)
                                {
                                    // send them back to the payment page with the error
                                    $this->session->set_flashdata('error', 'Customer Reward Point error in insert. Please contact Administrator.');
                                    redirect(site_url());
                                }
                                else
                                {
                                    $save['order_number'] = $id;
                                    $save['payment_status'] = 'Paid';
                                    $this->Order_model->update_order($save);
                                	$this->session->set_flashdata('message', lang('pesopay_success'));
                                    redirect(site_url());
                                }
                            }
                        }
                    }
                }
                else
                {

                    $customer = $this->go_cart->customer();
                                 
        
                    if ($customer)
                    {
                        $all_pppoints = 0;
     
                        if (!$this->session->userdata('click_rewards_points'))
                        {
                            $all_pppoints = $this->session->userdata('new_all_rewards_points');
          
                            if ($all_pppoints != 0)
                            {
                                $customer = $this->Customer_model->get_customer($customer['id']);
                                $array = array();
                                $array['id'] = $customer->id;
                                $array['reward_points'] = $customer->reward_points + $all_pppoints;
                                $true = $this->Customer_model->save($array);
                                if (!$true)
                                {
                                    // send them back to the payment page with the error
                                    $this->session->set_flashdata('error', 'Customer Reward Point error in insert. Please contact Administrator.');
                                    redirect(site_url());
                                }
                                else
                                {
                                    $save['order_number'] = $id;
                                    $save['payment_status'] = 'Paid';
                                    $this->Order_model->update_order($save);
                                	$this->session->set_flashdata('message', lang('pesopay_success'));
                                    redirect(site_url());
                                }
                            }
                        }
                        else
                        {
                           
                            
                            $select_points = 0;
                            $all_pppoints1 = 0;
                            $all_pppoints1 = $this->session->userdata('new_all_rewards_points');
                            $select_points = $this->session->userdata('select_rewards_points');
                              $customer = $this->Customer_model->get_customer($customer->id);
                            $all_pppoints2 = $customer->reward_points - $select_points;
                            $all_pppoints = $all_pppoints1 + $all_pppoints2;
                                                  var_dump($all_pppoints);
                            if ($all_pppoints != 0)
                            {
                             
                                $customer = $this->Customer_model->get_customer($customer->id);
                                $array = array();
                                $array['id'] = $customer->id;
                                $array['reward_points'] =  $all_pppoints;
                                $true = $this->Customer_model->save($array);
                                if (!$true)//error in saving
                                {
                                    // send them back to the payment page with the error
                                    $this->session->set_flashdata('error', 'Customer Reward Point error in insert. Please contact Administrator.');
                                    redirect(site_url());
                                }
                                else //success update order
                                {
                                    $save['order_number'] = $id;
                                    $save['payment_status'] = 'Paid';
                                    $this->Order_model->update_order($save);
                                	$this->session->set_flashdata('message', lang('pesopay_success'));
                                    redirect(site_url());
                                }
                            }

                        }
                    }

                }
*/
        /** End jeromejose save reward points */
                                
                /**start save order  //moved in the save reward points
                $save['order_number'] = $id;
                $save['payment_status'] = 'Paid';
                $this->Order_model->update_order($save);
                $this->session->set_flashdata('message', lang('pesopay_success'));
                // redirect('cart/view_cart');
				redirect(site_url());                
                 end save order */
            break;
            case 'fail':
                $save['order_number'] = $id;
                $save['payment_status'] = 'Cancelled';
                $this->Order_model->update_order($save);
                $this->session->set_flashdata('error', lang('pesopay_fail'));
//                redirect('cart/view_cart');
                redirect(site_url());
            break;
            case 'cancel':
                $save['order_number'] = $id;
                $save['payment_status'] = 'Cancelled';
                $this->Order_model->update_order($save);
                $this->session->set_flashdata('error', lang('pesopay_cancel'));
//                redirect('cart/view_cart');
                redirect(site_url());
            break;
        }
    }
    
    function ubiz($status, $ubiz_reference_id, $ubiz_uid, $payment_status)
    {
        $this->load->model('Order_model');
        $result = $this->db->where('ubiz_reference_id', $ubiz_reference_id)->get('orders');
        $row    = $result->row_array();        
        $order_number           = $row['order_number'];
        $update['order_number'] = $order_number;
        $update['ubiz_uid']     = $ubiz_uid;
        $this->Order_model->update_order($update);
        
        switch ($status)
        {
            case 'notify':
                $save['order_number']   = $order_number;
                $save['ubiz_uid']       = $ubiz_uid;
                $save['payment_status'] = $payment_status;
                $this->Order_model->update_order($save);
                $this->order_confirmation($order_number);
                $this->session->set_flashdata('message', lang('ubiz_notify'));
//                redirect('cart/view_cart');
                redirect(site_url());
            break;
            case 'return':
                $save['order_number']   = $order_number;
                $save['ubiz_uid']       = $ubiz_uid;
                $save['payment_status'] = $payment_status;
                $this->Order_model->update_order($save);
                if ($payment_status == 'Paid'){
                    $this->order_confirmation($order_number);
                    $this->session->set_flashdata('message', lang('ubiz_notify'));
                } else {
                    $this->session->set_flashdata('message', lang('ubiz_return'));
                }
//                redirect('cart/view_cart');
                redirect(site_url());
            break;
            case 'cancel':
                $save['order_number']   = $order_number;
                $save['ubiz_uid']       = $ubiz_uid;
                $save['payment_status'] = 'Cancelled';
                $this->Order_model->update_order($save);
                $this->session->set_flashdata('error', lang('ubiz_cancel'));
//                redirect('cart/view_cart');
                redirect(site_url());
            break;
        }
    }
    
    function order_confirmation($order_number)
    {
        $this->load->model('Order_model');
//        $data['customer'] = $this->go_cart->customer();
        $data['order_id'] = $order_number;
        $data['order']	  = $this->Order_model->get_order_by_number($order_number);
        
        // Send the user a confirmation email
        // - get the email template
        $this->load->model('messages_model');
        $row = $this->messages_model->get_message(7);

        $row['content'] = html_entity_decode($row['content']);

        // set replacement values for subject & body
        // {site_name}
        $row['subject'] = str_replace('{site_name}', $this->config->item('company_name'), $row['subject']);
        $row['content'] = str_replace('{site_name}', $this->load->view('order_email', $data, true), $row['content']);

//        // {customer_name}
//        $row['content'] = str_replace('{customer_name}', $this->load->view('order_email', $data, true), $row['content']);

        // {order_summary}
        $row['content'] = str_replace('{order_summary}', $this->load->view('order_email', $data, true), $row['content']);

//        print_r($row['content']); die();
        $this->load->library('email');

        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $this->email->from($this->config->item('email'), $this->config->item('company_name'));

        if ($this->Customer_model->is_logged_in(false, false))
        {
            $this->email->to($data['customer']['email']);
        }
        else
        {
            $this->email->to($data['customer']['ship_address']['email']);
        }

        //email the admin
        $this->email->bcc($this->config->item('email'));

        $this->email->subject($row['subject']);
        $this->email->message($row['content']);

        $this->email->send();
    }

    function click_reward_points($points)
    {
        $this->session->set_userdata('click_rewards_points', 'click_rewards_points');
        $this->session->set_userdata('select_rewards_points', $points);
        redirect('checkout/step_4','refresh');
    }

    function view_cart()
    {
        $total_amount = $this->go_cart->total();
        $noted_amount = $total_amount + ($total_amount * .20);
        $data['page_title'] = 'View Cart';
        $data['gift_cards_enabled'] = $this->gift_cards_enabled;
        $data['freebie'] = $this->Product_model->get_freebie($total_amount);
        $data['noted_freebie'] = $this->Product_model->get_freebie($noted_amount);
        /* start compute rewards */
        $this->load->model('Category_model');
        $countallcategories = $this->Category_model->count_categories();

        for ($counter = 1; $counter <= $countallcategories; $counter ++)
        {
            if ($this->session->userdata('cat_' . $counter))
            {
                $this->session->unset_userdata('cat_' . $counter); //unset all categories 
            }
        }

        if (!config_item('reward_points_per_totalprice'))
            {
            $this->set_rewardpoints(); //compute the rewards point for each categories using the session in cart
        $all_pppoints = 0;
        for ($counter = 1; $counter <= $countallcategories; $counter ++)
        {
            if ($this->session->userdata('cat_' . $counter))
            {
                $session = $this->session->userdata('cat_' . $counter);
                $all_pppoints +=$session['ppoints'];
            }
        }
        $customer = $this->go_cart->customer();
        $customer_reward_points = 0;
        if (isset($customer))
        {
            if ($customer && isset($customer['id']))
            {
                $custom = $this->Customer_model->get_customer($customer['id']);
                $customer_reward_points = $custom->reward_points;
            }
        }
        $data['all_rewards_points'] =  $customer_reward_points;
        }else //totalprice
        {
         $total_amount_price = $this->go_cart->total();
            $all_pppoints = 0;
            $rpoints = config_item('reward_points_rpoints');
            $rprice = config_item('reward_points_rprice');
            
            /*start Computation of rewards jerome jose 10-15-2014*/
            if ($rprice <= $total_amount_price)
            {
                    $newpoints1 = intval($total_amount_price / $rprice);
                    $all_pppoints = $rpoints * $newpoints1;
                      
            }
            /*end Computation of rewards */
            
            
             $customer = $this->go_cart->customer();
            $customer_reward_points = 0;
        if (isset($customer))
        {
            if ($customer && isset($customer['id']))
            {
                $custom = $this->Customer_model->get_customer($customer['id']);
                $customer_reward_points = $custom->reward_points;
            }
        }
        $data['all_rewards_points'] =  $customer_reward_points; 
        $data['new_all_rewards_points'] =  $all_pppoints;//$customer_reward_points; 
        }
        
        $this->session->set_userdata('all_rewards_points', $data['all_rewards_points']);
        $this->session->set_userdata('new_all_rewards_points', $all_pppoints);
        /* end */



        $this->load->view('view_cart', $data);
    }

    function remove_item($key)
    {
        //drop quantity to 0
        $this->go_cart->update_cart(array($key => 0));

        redirect('cart/view_cart');
    }

    function update_cart($redirect = false)
    {
        //if redirect isn't provided in the URL check for it in a form field
        if (!$redirect)
        {
            $redirect = $this->input->post('redirect');
        }

        // see if we have an update for the cart
        $item_keys = $this->input->post('cartkey');
        $coupon_code = $this->input->post('coupon_code');
        $gc_code = $this->input->post('gc_code');
        $rewardpoints = $this->input->post('rewardpoints');


        //get the items in the cart and test their quantities
        $items = $this->go_cart->contents();
        $new_key_list = array();
        //first find out if we're deleting any products
        foreach ($item_keys as $key => $quantity)
        {
            if (intval($quantity) === 0)
            {
                //this item is being removed we can remove it before processing quantities.
                //this will ensure that any items out of order will not throw errors based on the incorrect values of another item in the cart
                $this->go_cart->update_cart(array($key => $quantity));
            }
            else
            {
                //create a new list of relevant items
                $new_key_list[$key] = $quantity;
            }
        }
        $response = array();
        foreach ($new_key_list as $key => $quantity)
        {
            $product = $this->go_cart->item($key);
            //if out of stock purchase is disabled, check to make sure there is inventory to support the cart.
            if (!$this->config->item('allow_os_purchase') && (bool) $product['track_stock'])
            {
                $stock = $this->Product_model->get_product($product['id']);

                //loop through the new quantities and tabluate any products with the same product id
                $qty_count = $quantity;
                foreach ($new_key_list as $item_key => $item_quantity)
                {
                    if ($key != $item_key)
                    {
                        $item = $this->go_cart->item($item_key);
                        //look for other instances of the same product (this can occur if they have different options) and tabulate the total quantity
                        if ($item['id'] == $stock->id)
                        {
                            $qty_count = $qty_count + $item_quantity;
                        }
                    }
                }
                if ($stock->quantity < $qty_count)
                {
                    if (isset($response['error']))
                    {
                        $response['error'] .= '<p>' . sprintf(lang('not_enough_stock'), $stock->name, $stock->quantity) . '</p>';
                    }
                    else
                    {
                        $response['error'] = '<p>' . sprintf(lang('not_enough_stock'), $stock->name, $stock->quantity) . '</p>';
                    }
                }
                else
                {
                    //this one works, we can update it!
                    //don't update the coupons yet
                    $this->go_cart->update_cart(array($key => $quantity));
                }
            }
            else
            {
                $this->go_cart->update_cart(array($key => $quantity));
            }
        }

        //if we don't have a quantity error, run the update
        if (!isset($response['error']))
        {
            //update the coupons and gift card code
            $response = $this->go_cart->update_cart(false, $coupon_code, $gc_code, $rewardpoints);
            // set any messages that need to be displayed
        }
        else
        {
            $response['error'] = '<p>' . lang('error_updating_cart') . '</p>' . $response['error'];
        }


        //check for errors again, there could have been a new error from the update cart function
        if (isset($response['error']))
        {
            $this->session->set_flashdata('error', $response['error']);
        }
        if (isset($response['message']))
        {
            $this->session->set_flashdata('message', $response['message']);
        }

        if ($redirect)
        {
            redirect($redirect);
        }
        else
        {
            redirect('cart/view_cart');
        }
    }

    /*     * *********************************************************
      Gift Cards
      - this function handles adding gift cards to the cart
     * ********************************************************* */

    function giftcard()
    {
        if (!$this->gift_cards_enabled)
            redirect('/');

        // Load giftcard settings
        $gc_settings = $this->Settings_model->get_settings("gift_cards");

        $this->load->library('form_validation');

        $data['allow_custom_amount'] = (bool) $gc_settings['allow_custom_amount'];
        $data['preset_values'] = explode(",", $gc_settings['predefined_card_amounts']);

        if ($data['allow_custom_amount'])
        {
            $this->form_validation->set_rules('custom_amount', 'lang:custom_amount', 'numeric');
        }

        $this->form_validation->set_rules('amount', 'lang:amount', 'required');
        $this->form_validation->set_rules('preset_amount', 'lang:preset_amount', 'numeric');
        $this->form_validation->set_rules('gc_to_name', 'lang:recipient_name', 'trim|required');
        $this->form_validation->set_rules('gc_to_email', 'lang:recipient_email', 'trim|required|valid_email');
        $this->form_validation->set_rules('gc_from', 'lang:sender_email', 'trim|required');
        $this->form_validation->set_rules('message', 'lang:custom_greeting', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $data['error'] = validation_errors();
            $data['page_title'] = lang('giftcard');
            $data['gift_cards_enabled'] = $this->gift_cards_enabled;
            $this->load->view('giftcards', $data);
        }
        else
        {

            // add to cart

            $card['price'] = set_value(set_value('amount'));

            $card['id'] = -1; // just a placeholder
            $card['sku'] = lang('giftcard');
            $card['base_price'] = $card['price']; // price gets modified by options, show the baseline still...
            $card['name'] = lang('giftcard');
            $card['code'] = generate_code(); // from the string helper
            $card['excerpt'] = sprintf(lang('giftcard_excerpt'), set_value('gc_to_name'));
            $card['weight'] = 0;
            $card['quantity'] = 1;
            $card['shippable'] = false;
            $card['taxable'] = 0;
            $card['fixed_quantity'] = true;
            $card['is_gc'] = true; // !Important
            $card['track_stock'] = false; // !Imporortant

            $card['gc_info'] = array("to_name" => set_value('gc_to_name'),
                "to_email" => set_value('gc_to_email'),
                "from" => set_value('gc_from'),
                "personal_message" => set_value('message')
            );

            // add the card data like a product
            $this->go_cart->insert($card);

            redirect('cart/view_cart');
        }
    }

}

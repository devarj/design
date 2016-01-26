<?php

class Widget extends Front_Controller
{

    function __construct()
    {
        parent::__construct();
//        echo 'test';
        //make sure we're not always behind ssl
        remove_ssl();
    }

    function index()
    {
//        $result = $this->Category_model->get_category_limit();
//        redirect($result[0]->slug); // for fresh category
     /*   $this->load->model(array('Banner_model', 'box_model'));
        $this->load->helper('directory');

        $data['gift_cards_enabled'] = $this->gift_cards_enabled;
        $data['banners'] = $this->Banner_model->get_homepage_banners(5);
        $data['boxes'] = $this->box_model->get_homepage_boxes(4);
        $data['homepage'] = true;
        $this->load->view('homepage', $data);
            */
       
//           redirect('cart/allproducts');
        
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
        $this->load->view('widget', $data);
    }
    
}
?>
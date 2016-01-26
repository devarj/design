<?php

class SearchWidget extends Front_Controller
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
    	$this->load->view('search.php');
    }
}

?>

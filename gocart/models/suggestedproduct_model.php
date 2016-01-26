<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class Suggestedproduct_model extends CI_Model
{

    //this is the expiration for a non-remember session
    var $session_expire = 7200;

    function __construct()
    {
        parent::__construct();
    }

    function insert($data)
    {
        $this->db->insert('suggested_product', $data);
    }

    function get_list()
    {
        $list = $this->db->get('suggested_product')->result();
        return $list;
    }

}

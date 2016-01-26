<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


$route['default_controller'] = "cart";

//this for the admininstration console
$route['admin'] = 'admin/dashboard';
$route['admin/media/(:any)'] = 'admin/media/$1';
$route['custom-order'] = 'cart/custom_order';
$route['supplier-admin'] = 'admin/login';

<?php 
/* PHP CODE GUIDE 
 * * 
 * * Callbacks: return url 
 * * HTTP Verb: GET 
 * * Fields: 
 * * resp | 'success' or 'fail' 
 * * order_reference_id | order reference id 
 * * payment_status | current payment status 
 * * uid | unique order identifier used by UBIZ system; needs to be saved in your database for orders API method purposes 
 * * sig | HMAC-SHA256 hash wherein: 
 * * concatenated response e.g resp.order_reference_id.payment_status.uid - message to be hashed 
 * * Your UBIZ application secret key - shared secret key used for generating the HMAC 
 * * Date created: April 25, 2013 
 * * Date modified: n/a 
 */ 
include 'config.inc.php';
    //for security purposes, you can also add checking if query keys returned are allowed on your system 
    $allowed_query_keys = array('resp', 'order_reference_id', 'payment_status', 'uid', 'sig'); //if you have custom keys appended in your return url, add it here 
    $returned_query_keys = array_keys($_GET); 
    
    $final_system_allowed_query_keys = array_combine($allowed_query_keys, $allowed_query_keys); 
    $final_ubiz_returned_query_keys = array_combine($returned_query_keys, $returned_query_keys); 
    
    array_multisort($final_system_allowed_query_keys); 
    array_multisort($final_ubiz_returned_query_keys); 
    
    if($final_system_allowed_query_keys == $final_ubiz_returned_query_keys) { 
        $api_secret = APPLICATION_SECRET; 
        $resp = $_GET['resp']; 
        $order_reference_id = $_GET['order_reference_id']; 
        $payment_status = $_GET['payment_status']; 
        $uid = $_GET['uid']; 
        $ubiz_sig = $_GET['sig']; 

        //authenticate response 
        $system_sig = hash_hmac('sha256', $resp.$order_reference_id.$payment_status.$uid, $api_secret); 
        
        if($system_sig == $ubiz_sig) { 
            //process order information 
//            echo "<pre>".print_r($_GET, true)."</pre>"; 
            header('Location: '.EGROCERY_URL.'return/'.$order_reference_id.'/'.$uid.'/'.$payment_status);
        } else { 
            echo 'log both sig and response and ask for UBIZ technical support for assistance'; 
        }
    } else { 
        //investigate 
        echo 'investigate returned params';
    }
?>
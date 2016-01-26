<?php
/* PHP CODE GUIDE
 * 
 * API method: orders
 * HTTP Verb: GET
 * Fields: 
 * uid      |   required    | unique order identifier returned by UBIZ system once the payment has been processed
 * fields   |   optional    | specific fields you want to retrieve, comma-separated e.g billing_first_name,billing_last_name,payment_status
 * Description: Retrieve order information
 * Date created: April 24, 2013
 * Date modified: June 11, 2013
 */
    //prepare authentication header parameters: see documentation #authentication section ------------------------------------------------------------
    include 'config.inc.php';
    $merchant_code = MERCHANT_CODE;
    $api_id = APPLICATION_ID;
    $api_secret = APPLICATION_SECRET;

    $gmt_now = gmdate("M d Y H:i:s", time());
    $gmt_now = strtotime($gmt_now);
    $api_expires = $gmt_now + 28800 + 10800; //GMT + 8 Hours (Philippine Time) + expiration time in secs (in this case 3 hours - 3600*3 = 10800)

    $api_sig = hash_hmac('sha256', $api_expires, $api_secret);

    //prepare query string and order reference id: see documentation #api-methods-orders section -----------------------------------------------------
    $order_reference_id = '<ORDER_REFERENCE_ID_HERE>';
    
    $uid = '<ORDER_UID_HERE>';
    $fields = 'billing_first_name,billing_last_name,payment_status'; //comment if you want to return all order data
    
    $query_string = 'uid='.$uid;
    $query_string .= (empty($fields))? '' : '&fields='.$fields;
    

    //prepare checkouts API call ---------------------------------------------------------------------------------------------------------------------
    $orders_url = UBIZ_ENVIRONMENT."v1/orders/$order_reference_id.json?$query_string"; 
    
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL, $orders_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('UNIONBANK-UBIZ-APP-ID:              '.$api_id.'', 
                                               'UNIONBANK-UBIZ-APP-SIGNATURE:       '.$api_sig.'', 
                                               'UNIONBANK-UBIZ-APP-MERCHANT-CODE:   '.$merchant_code.'', 
                                               'UNIONBANK-UBIZ-REQUEST-EXPIRES:     '.$api_expires.''));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    //IMPORTANT: UNCOMMENT for PROD environment
    //Note that even if your data is sent over SSL secured site, a certificate checking is recommended as an added security,
    //by ensuring that your CURL session will not just trust any server certificate
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);                       // verify peer's certificate 
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);                          // check the existence of a common name and also verify that it matches the hostname provided
    //curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/path/to/file.crt");     // name of a file holding one or more certificates to verify the peer with. 
                                                                            // see documentation #before-going-live section for notes regarding certificate file.

    $result = curl_exec($ch);

    if(curl_errno($ch))
    {
        //you can log the curl error
        $message = curl_errno($ch).': '.curl_error($ch);
    }
    else
    {
        //you can log the get information
        $info = curl_getinfo($ch);
        $message = 'GET '. $info['url'].' in '.$info['total_time'].' secs. ' . $info['http_code'];

        //process returned JSON response, e.g save response
        $data = json_decode($result);
        
        if($data->meta->response_code == '200')
        {
            //authenticate response
            $order_info = $data->response->{$order_reference_id};
            
            $system_sig = hash_hmac('sha256', json_encode($order_info), $api_secret);
            $ubiz_sig = $data->response->sig;
            
            if($system_sig == $ubiz_sig)
            {
                //process order information
                echo "Order Info: <pre>".print_r($order_info, true)."</pre>";
            }
            else
            {
                echo 'log both sig and response and ask for UBIZ technical support for assistance';
            }    
            
        }
        else
        {
            //capture error and do necessary process
            //log error details 
            echo 'Log error details: '.$data->meta->error_type.' '.$data->meta->error_detail.' '.$data->meta->error_code;
            
            //to force error for testing purposes you can change expires value: $api_expires = $gmt_now - 28800 + 10800;
        }
    }    

    echo '<hr />';
    echo "CURL action: <pre>$message;</pre>";
    echo "CURL raw result: <pre>".print_r($result, true)."</pre>"; 
    
    curl_close($ch);

    
/* End of orders API call - PHP CODE GUIDE */
?>
<?php

class Invoice extends Admin_Controller {

    function __construct() {
        parent::__construct();

        remove_ssl();
        $this->load->model('Order_model');
        $this->load->helper(array('formatting'));
        $this->lang->load('order');
    }

    function index() {
        $data['page_title'] = "Invoice Summary";
        $data['start'] = $this->input->post('start');
		$data['end'] = $this->input->post('end');
        
        if ($this->input->post('submit') == 'export_to_csv')
        {
            $this->export_csv($data['start'], $data['end']);
        }
        $data['invoices'] = $this->Order_model->get_invoices($data['start'],$data['end']);
        
        $this->load->view($this->config->item('admin_folder') . '/invoices', $data);
    }

    function export_csv($start, $end)
    {   
        if (!empty($start) && !empty($end))
        {
            $where = "AND DATE_FORMAT(`invoice_date`, '%m/%d/%Y') BETWEEN '". $start."' AND '".$end."'";
        } else {
            $where = '';
        }
//        var_dump($where);
        $query = "SELECT invoice_date,invoice_no,order_number,ordered_on,waybill_no,subtotal,(subtotal * 0.05) as transaction_fee,(subtotal - (subtotal * 0.05)) as net_amount
                FROM orders 
                WHERE invoice_no != '' ".$where."
                ORDER BY invoice_date DESC";
        $filename = 'invoices_'.date('dMy').'.csv';
        $attachment = true;
        $headers = true;

        if ($attachment)
        {
            // send response headers to the browser
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $filename);
            $fp = fopen('php://output', 'w');
        }
        else
        {
            $fp = fopen($filename, 'w');
        }

        $result = mysql_query($query) or exit(mysql_error());

        $num_rows = mysql_num_rows($result);

        if ($num_rows)
        {
            if ($headers)
            {
                // output header row (if at least one row exists)
                $row = mysql_fetch_assoc($result);
                if ($row)
                {
                    fputcsv($fp, array_keys($row));
                    // reset pointer back to beginning
                    mysql_data_seek($result, 0);
                }
            }

            while ($row = mysql_fetch_assoc($result))
            {
                fputcsv($fp, $row);
            }

            fclose($fp);
            exit;
        }
    }
    
}
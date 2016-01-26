<?php
class Xend_model extends CI_Model{

	function get_orders_by_number($order_number){
		$query="SELECT o.total,o.ship_firstname,o.ship_lastname,o.ship_phone,o.ship_email,o.ship_company, o.ship_address1,o.ship_address2, o.ship_city, o.ship_zone,
                    o.waybill_no, o.xend_waybillno, o.pickup_loc, o.pickup_date, o.pickup_time, o.shipped_on, o.total, o.invoice_no, o.ship_country,  
                    o.invoice_date, o.checkpayeename, o.order_number, o.shipping, o.pickup_person, o.pickup_contact, o.subtotal
                FROM `orders` o
                WHERE o.order_number='$order_number'";
		$result=$this->db->query($query);
		$rs= $result->result();
		return $rs;

	}

	function update_orders_by_number($order_number, $waybillno){
		$query="UPDATE `orders` SET xend=1, xend_waybillno=$waybillno WHERE order_number=$order_number";
		$result=$this->db->query($query);
	}

	function update_wayBill($order_number,$waybillno,$time,$date,$location,$person,$contact){
		$query="UPDATE `orders` 
                SET waybill_no='".$waybillno."', pickup_loc='".$location."',pickup_time='".$time."',pickup_date='".$date."',pickup_person='".$person."',pickup_contact='".$contact."' 
                WHERE order_number='$order_number'";
		$result=$this->db->query($query);
	}
	
	function update_xend_wayBill($order_number,$waybillno,$time,$date,$location){
		$query="UPDATE `orders` SET xend=1, xend_waybillno='".$waybillno."', pickup_loc='".$location."',pickup_time='".$time."',pickup_date='".$date."' WHERE order_number=$order_number";
		$result=$this->db->query($query);
	}

	function get_totalorders_by_id($app_id){
		$query="SELECT o.ship_lastname, o.app_id, COUNT(*) as totalorders
		FROM `orders` o, `customers` c
		WHERE o.app_id=c.id AND o.invoice_no != ''
			AND o.app_id=$app_id";
		$result=$this->db->query($query);
		$rs= $result->result();
		return $rs;

	}
/*START-REV-REMITTANCE OPTION (ELAINEM) 2014-03-21*/
	/*function update_invoice($order_num,$invoiceno,$invoice_date){
		$query="UPDATE `orders` SET invoice_no='".$invoiceno."', invoice_date='".$invoice_date."' WHERE order_number=$order_num";
		$result=$this->db->query($query);
	}*/
	function update_invoice($order_num,$invoiceno,$invoice_date,$chkpayeename){
		$query="UPDATE `orders` 
					SET invoice_no='".$invoiceno."', invoice_date='".$invoice_date."', checkpayeename='".$chkpayeename."' 
				WHERE order_number='".$order_num."'";
		$result=$this->db->query($query);
	}
/*END-REV-REMITTANCE OPTION (ELAINEM) 2014-03-21*/
    
    function get_pickup_address($order_number){
		$query="SELECT * FROM `orders` o
                WHERE o.order_number='$order_number'";
		$result=$this->db->query($query);
		$rs= $result->result();
		return $rs;

	}

}

?>
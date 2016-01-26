<?php 
class Email_model extends CI_Model{

	function update_order($order_no, $payment_method){
		$query="UPDATE `orders` SET `payment_gateway`='".$payment_method."' WHERE `order_number`='".$order_no."'";
		$this->db->query($query);

	}

	function get_shop_name($app_id,$column){
		$query="SELECT * FROM customers WHERE id='".$app_id."'";

		$result=$this->db->query($query);
		$test = $result->result();
		// print_r($test);
		foreach($test as $res){
			switch ($column) {
				case $column:
				return $res->$column;
				break;

			}
			
		}
	}

	function get_order_information($order_no){
		$query="SELECT * FROM orders WHERE order_number='".$order_no."'";

		$result=$this->db->query($query);
		return $result->result();
	}

	function get_order_product($order_no){
		$query="SELECT oi.*
		FROM orders o
		INNER JOIN order_items oi ON o.id=oi.order_id 
		WHERE o.order_number='$order_no'";
		
		$result=$this->db->query($query);
		return $result->result();
	}
}

?>
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model
{
	
	public function add($table, $data)
	{
		return $this->db->insert($table, $data);
	}
	
	
	public function delete($table, $id){
		$this->db->where('id', $id);
		$this->db->delete($table);
	}
	
	public function get($table){
		return $this->db->get($table)->result();
	}
	
	public function get_sort($table, $field, $order_by = 'asc'){
		$this->db->order_by($field, $order_by);
		return $this->db->get($table)->result();
	}
	public function get_where($table, $where, $result){
		$this->db->where($where);
		if($result == 0){
			return $this->db->get($table)->row();
		}
		else{
			return $this->db->get($table)->result();
		}
	}
	
	public function get_where_orderby($table, $where, $result, $order, $by = 'ASC'){
		$this->db->order_by($order, $by);
		$this->db->where($where);
		
		if($result == 0){
			return $this->db->get($table)->row();
		}
		else{
			return $this->db->get($table)->result();
		}
	}
	
	public function actType($id){
		$this->db->where('id', $id);
		$data = $this->db->get('activites')->row();
		return $data->name;
	}
	
	public function update($tbl,$data,$id){
		$this->db->where($id);
		$this->db->update($tbl,$data);
	}

	public function get_where_order($table, $where){
		$this->db->where($where);
		$this->db->order_by('id','asc');
		return $this->db->get($table)->result_array();
	}
	
	public function getCustom($id){
			
		$this->db->where('type', $id);
		$this->db->order_by('price', 'asc');
		$this->db->limit(1);
		return $this->db->get('products_supplier')->result();
	}
	
}

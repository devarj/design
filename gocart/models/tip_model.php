<?php
Class Tip_model extends CI_Model
{
	function get_tips($limit = false)
	{
		if($limit)
		{
			$this->db->limit($limit);
            if ($limit === 1){
                $this->db->order_by('RAND()');
            }
		} else {
            $this->db->order_by('id DESC');
        }
        
		return $this->db->get('tips')->result();
	}
	
	function get_tip($id)
	{
		$this->db->where('id', $id);
		$result = $this->db->get('tips');
		$result = $result->row();
		
		if ($result)
		{
			return $result;
		}
		else
		{ 
			return array();
		}
	}
	
	function delete($id)
	{
		
		$tip	= $this->get_tip($id);
		if ($tip)
		{
			$this->db->where('id', $id);
			$this->db->delete('tips');
			
			return 'The "'.$tip->tip.'" tip has been removed.';
		}
		else
		{
			return 'The tip could not be found.';
		}
	}
	
	function get_next_sequence()
	{
		$this->db->select('id');
		$this->db->order_by('id DESC');
		$this->db->limit(1);
		$result = $this->db->get('tips');
		$result = $result->row();
		if ($result)
		{
			return $result->id + 1;
		}
		else
		{
			return 0;
		}
	}
	
	function save($data)
	{
		if(isset($data['id']))
		{
			$this->db->where('id', $data['id']);
			$this->db->update('tips', $data);
		}
		else
		{
			$data['id'] = $this->get_next_sequence();
			$this->db->insert('tips', $data);
		}
	}
	
	function organize($tips)
	{
		foreach ($tips as $sequence => $id)
		{
			$data = array('id' => $sequence);
			$this->db->where('id', $id);
			$this->db->update('tips', $data);
		}
	}
}
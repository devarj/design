<?php
Class Page_model extends CI_Model
{

	/********************************************************************
	Page functions
	********************************************************************/
	function get_pages($parent = 0)
	{
		$this->db->order_by('sequence', 'ASC');
		$this->db->where('parent_id', $parent);
		$result = $this->db->get('pages')->result();
		
		$return	= array();
		foreach($result as $page)
		{
			$return[$page->id]				= $page;
			$return[$page->id]->children	= $this->get_pages($page->id);
		}
		
		return $return;
	}
	function get_tips()
    {
		$result = $this->db->get('tips')->result();
		
		$return	= array();
		foreach($result as $page)
		{
			$return[$page->id]				= $page;
			$return[$page->id]->children	= $this->get_pages($page->id);
		}
		
		return $return;
    }
	function get_freebies()
    {
        $result = $this->db->get('freebies')->result();
		
		$return	= array();
		foreach($result as $page)
		{
			$return[$page->id]				= $page;
			$return[$page->id]->children	= $this->get_pages($page->id);
		}
		
		return $return;
    }
	function get_page($id)
	{
		$this->db->where('id', $id);
		$result = $this->db->get('pages')->row();
		
		return $result;
	}
	function get_tip($id)
    {
        $this->db->where('id', $id);
		$result = $this->db->get('tips')->row();
		
        return $result;
    }
    function get_freebie($id)
    {
        $this->db->where('id', $id);
		$result = $this->db->get('freebies')->row();
		
		return $result;
    }
    function check_amount($amount)
    {
        $this->db->where('amount', $amount);
		$result = $this->db->get('freebies')->row();
		
		return $result;
    }
	function get_slug($id)
	{
		$page = $this->get_page($id);
		if($page) 
		{
			return $page->slug;
		}
	}
	
	function save($data)
	{
		if($data['id'])
		{
			$this->db->where('id', $data['id']);
			$this->db->update('pages', $data);
			return $data['id'];
		}
		else
		{
			$this->db->insert('pages', $data);
			return $this->db->insert_id();
		}
	}
	function save_tip($data)
    {
        if($data['id'])
        {
            $this->db->where('id', $data['id']);
            $this->db->update('tips', $data);
            return $data['id'];
        }
        else
        {
            $this->db->insert('tips', $data);
            return $this->db->insert_id();
        }
    }
	function save_freebies($data)
    {
        if($data['id'])
        {
            $this->db->where('id', $data['id']);
			$this->db->update('freebies', $data);
            return $data['id'];
        }
        else
        {
            $data['status'] = 1;
            $this->db->insert('freebies', $data);
			return $this->db->insert_id();
        }
    }
	function delete_page($id)
	{
		//delete the page
		$this->db->where('id', $id);
		$this->db->delete('pages');
	
	}
	function delete_tip($id)
        {
                //delete the page
		$this->db->where('id', $id);
		$this->db->delete('tips');
        }
	function delete_freebie($id){
                //delete the freebie
		$this->db->where('id', $id);
		$this->db->delete('freebies');
        }
	function get_page_by_slug($slug)
	{
		$this->db->where('slug', $slug);
		$result = $this->db->get('pages')->row();
		
		return $result;
	}
	function updateAJAX($status, $id)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update('freebies', $data);
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	// Count data member
	function count_member()
	{										
		return $this->db->count_all_results('member');
	}
	
	// Insert data member
	function insert_member($data)
	{
		$this->db->insert('member', $data);
		return TRUE;
	}
	
	// Update data member
	function update_member($data,$id)
	{
		$this->db->where('idmember', $id);
		$this->db->update('member', $data); 
		return TRUE;
	}
	
	// Delete data member
	function delete_member($id)
	{
		$this->db->where('idmember', $id);
		$this->db->delete('member'); 
		return TRUE;
	}
	
	// Get data member
	function get_member($limit=0, $offset=0)
    {
        $this->db->select('*');
		$this->db->from('member');
		$this->db->order_by('nama_member','asc');
		$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
	
	// Get data member detail by PK
	function get_member_detail($id)
    {
        $this->db->select('*');
		$this->db->from('member');
		$this->db->where('idmember',$id);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }
	
	// Get data member detail by No Hape
	function get_member_by_hape($hape)
    {
        $this->db->select('*');
		$this->db->from('member');
		$this->db->where('hape',$hape);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }
	
	// Search member
	function search_member($keyword)
    {
        $this->db->select('*');
		$this->db->from('member');
		$this->db->like('nama_member', $keyword);
		$this->db->or_like('hape', $keyword); 
		$this->db->or_like('email', $keyword); 
		$this->db->order_by('nama_member','asc');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
	
	// Get data member yang ada balance nya
	function get_member_with_balance()
    {
        $this->db->select('idmember, balance, hutang_2012');
		$this->db->from('member');
		$this->db->where('balance !=','');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
	
	// Get hutang 2012 berdasarkan keyword pencarian
	function get_hutang_total($keyword='')
    {		
		$this->db->select_sum('hutang_2012');
		$this->db->from('member');
		if($keyword){
			$this->db->like('nama_member', $keyword);
			$this->db->or_like('hape', $keyword); 
			$this->db->or_like('email', $keyword); 
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }
}
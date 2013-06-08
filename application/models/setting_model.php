<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function insert_setting($data)
	{
		$this->db->insert('setting', $data);
		return TRUE;
	}
	
	function update_setting($data,$slug)
	{
		$this->db->where('slug', $slug);
		$this->db->update('setting', $data); 
		return TRUE;
	}
	
	function delete_setting($id)
	{
		$this->db->where('idsetting', $id);
		$this->db->delete('setting'); 
		return TRUE;
	}
	
	function get_setting()
    {
        $this->db->select('*');
		$this->db->from('setting');
		$this->db->order_by('idsetting','desc');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
	
	function get_setting_by_slug($slug)
    {
        $this->db->select('*');
		$this->db->from('setting');
		$this->db->where('slug',$slug);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }	
}
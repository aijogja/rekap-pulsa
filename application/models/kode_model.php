<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kode_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	// Count Data Kode
	function count_kode()
	{										
		return $this->db->count_all_results('kode');
	}
	
	// Insert Data Kode
	function insert_kode($data)
	{
		$this->db->insert('kode', $data);
		return TRUE;
	}
	
	// Update Data Kode
	function update_kode($data,$id)
	{
		$this->db->where('idkode', $id);
		$this->db->update('kode', $data); 
		return TRUE;
	}
	
	// Delete Data Kode
	function delete_kode($id)
	{
		$this->db->where('idkode', $id);
		$this->db->delete('kode'); 
		return TRUE;
	}
	
	// Get All Data Kode (limit)
	function get_kode($limit=0, $offset=0)
    {
        $this->db->select('*');
		$this->db->from('kode');
		$this->db->order_by('provider','asc');
		$this->db->order_by('harga','asc');
		$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
	
	// Get Data Kode Detail by PK
	function get_kode_detail($id)
    {
        $this->db->select('*');
		$this->db->from('kode');
		$this->db->where('idkode',$id);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }
	
	// Get Data Kode Detail by Kode
	function get_kode_by_kode($kode)
    {
        $this->db->select('*');
		$this->db->from('kode');
		$this->db->where('kode',$kode);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }
}
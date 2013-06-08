<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deposit_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		$bulan = explode('-',date('m-Y',strtotime($this->session->userdata('bulan'))));
		$this->start_bulan = mktime(0, 0, 0, $bulan[0], 1, 2013);
		$this->end_bulan = mktime(0, 0, 0, $bulan[0]+1, 0, 2013);
    }
	
	function count_deposit($where=array())
	{										
		if($where){
			$this->db->where($where);
		}
		
		$this->db->where('tgl >= ',$this->start_bulan);
		$this->db->where('tgl <= ',$this->end_bulan);
		return $this->db->count_all_results('deposit');
	}
	
	function insert_deposit($data)
	{
		$this->db->insert('deposit', $data);
		return TRUE;
	}
	
	function update_deposit($data,$id)
	{
		$this->db->where('iddeposit', $id);
		$this->db->update('deposit', $data); 
		return TRUE;
	}
	
	function delete_deposit($id)
	{
		$this->db->where('iddeposit', $id);
		$this->db->delete('deposit'); 
		return TRUE;
	}
	
	function get_deposit($limit=0, $offset=0,$where=array())
    {		
        $this->db->select('*');
		$this->db->from('deposit');
		$this->db->where('tgl >= ',$this->start_bulan);
		$this->db->where('tgl <= ',$this->end_bulan);
		
		if($where){
			$this->db->where($where);
		}
		
		$this->db->order_by('tgl','asc');
		$this->db->order_by('iddeposit','asc');
		$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
	
	function get_deposit_detail($id)
    {
        $this->db->select('*');
		$this->db->from('deposit');
		$this->db->where('iddeposit',$id);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }
		
	function get_jumlah_total($where=array())
    {
		$this->db->select_sum('nominal');
		$this->db->from('deposit');
		$this->db->where('tgl >= ',$this->start_bulan);
		$this->db->where('tgl <= ',$this->end_bulan);
		if($where){
			$this->db->where($where);
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }

}
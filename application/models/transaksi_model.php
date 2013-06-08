<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
				
		$bulan = explode('-',date('m-Y',strtotime($this->session->userdata('bulan'))));
		$this->start_bulan = mktime(0, 0, 0, $bulan[0], 1, 2013);
		$this->end_bulan = mktime(0, 0, 0, $bulan[0]+1, 0, 2013);
    }
	
	function count_transaksi($where=array())
	{										
		if($where){
			$this->db->where($where);
		}
		
		$this->db->where('tgl >= ',$this->start_bulan);
		$this->db->where('tgl <= ',$this->end_bulan);
		return $this->db->count_all_results('transaksi');
	}
	
	function insert_transaksi($data)
	{
		$this->db->insert('transaksi', $data);
		return TRUE;
	}
	
	function update_transaksi($data,$id)
	{
		$this->db->where('idtransaksi', $id);
		$this->db->update('transaksi', $data); 
		return TRUE;
	}
	
	function delete_transaksi($id)
	{
		$this->db->where('idtransaksi', $id);
		$this->db->delete('transaksi'); 
		return TRUE;
	}
	
	function get_transaksi($limit=0, $offset=0,$where=array())
    {
        $this->db->select('*');
		$this->db->from('transaksi');
		$this->db->join('member', 'transaksi.membernya = member.idmember');
		$this->db->join('kode', 'transaksi.kodenya = kode.idkode');
		$this->db->where('tgl >= ',$this->start_bulan);
		$this->db->where('tgl <= ',$this->end_bulan);
		
		if($where){
			$this->db->where($where);
		}
		
		$this->db->order_by('tgl','asc');
		$this->db->order_by('idtransaksi','asc');
		$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
	
	function get_transaksi_detail($id)
    {
        $this->db->select('*');
		$this->db->from('transaksi');
		$this->db->where('idtransaksi',$id);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }
	
	function get_no_tujuan()
    {
		$this->db->distinct();
        $this->db->select('no_tujuan');
		$this->db->from('transaksi');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
	
	function get_jumlah_total($where=array(),$monthly=TRUE)
    {		
		$this->db->select_sum('total');
		$this->db->from('transaksi');
		if($monthly){
			$this->db->where('tgl >= ',$this->start_bulan);
			$this->db->where('tgl <= ',$this->end_bulan);
		}
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
		
	function get_hutang_member($limit=0, $offset=0)
    {		
        $this->db->select('idmember, membernya, nama_member, (hutang_2012-balance) as hutang_lama, sum(total) as hutang');
		$this->db->from('member');
		$this->db->join('transaksi', 'transaksi.membernya = member.idmember and status = 0','left');
		$this->db->group_by('nama_member');
		$this->db->order_by('nama_member','asc');
		if(!empty($limit)){
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
	
	function get_hutang_member_detail($idmember)
    {		
        $this->db->select('*');
		$this->db->from('transaksi');
		//$this->db->join('member', 'transaksi.membernya = member.idmember');
		$this->db->join('kode', 'transaksi.kodenya = kode.idkode');
		$this->db->where('membernya',$idmember);
		$this->db->where('status','0');
		$this->db->order_by('tgl','asc');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
	
	function get_member_hutang_and_email()
    {
		$this->db->distinct();
        $this->db->select('m.*');
		$this->db->from('transaksi t');
		$this->db->join('member m', "t.membernya = m.idmember");
		$this->db->where('t.status','0');
		$this->db->where('m.email !=','');
		$this->db->order_by('m.nama_member','asc');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
}
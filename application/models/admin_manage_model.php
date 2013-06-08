<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_manage_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function admin_login($email,$pass)
    {
		$data = $this->get_admin_by_email($email);
        if($data){
			$pass = encrypt($pass,$data['salt']);
			if($pass == $data['pass']){				
				//array_splice($data,3);	
			}else{			
				$data = FALSE;
			}
		} else {
			$data = FALSE;
		}
		
		return $data;
    }
	
	function insert_admin($data)
	{
		$this->db->insert('admin', $data);
		return TRUE;
	}
	
	function update_admin($data,$id)
	{
		$this->db->where('idadmin', $id);
		$this->db->update('admin', $data); 
		return TRUE;
	}
	
	function delete_admin($id)
	{
		$this->db->where('idadmin', $id);
		$this->db->delete('admin'); 
		return TRUE;
	}
	
	function get_admin_by_email($email)
    {
        $this->db->select('*');
		$this->db->from('admin');
		$this->db->where('email',$email);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }
	
	function get_admin()
    {
        $this->db->select('*');
		$this->db->from('admin');
		$this->db->order_by('idadmin');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
    }
	
	
	function get_admin_detail($id)
    {
        $this->db->select('*');
		$this->db->from('admin');
		$this->db->where('idadmin',$id);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }
	
	function get_email_by_pass()
    {
        $this->db->select('idadmin, email');
		$this->db->from('admin');
		$this->db->where('pass');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
    }	
}
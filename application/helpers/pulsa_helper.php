<?php
/*
	Helper List :
		- restrict_admin
		- salt
		- encrypt
		- salt_encrypt
		- template_view			
		- admin_template_view 
		- flash_message	
		- get_member
		- get_kode	
		- get_no_tujuan
		- get_setting
		- format_amount
*/

if(!function_exists('restrict_admin')){
function restrict_admin()
    {       	
		$ci =& get_instance();
		$ci->load->library('session');
		
		if($ci->session->userdata('logged_in') === FALSE){
			redirect('admin');
		}	
    } 
}

if(!function_exists('salt')){
function salt()
    {
        return substr(md5(uniqid(rand(), true)), 0, 5);
    } 
}

if(!function_exists('encrypt')){
function encrypt($pass,$salt)
    {
		$pass = md5($pass);
		$encryped = sha1($salt.$pass);
        
        return $encryped;
    } 
}

if(!function_exists('salt_encrypt')){
function salt_encrypt($email,$pass)
    {
       	$key = 'aijogja';		
		$text1 = substr(md5($email),0,5);
		$text2 = substr(md5($pass),0,5);
		$encryped = md5($key.$text1.$text2);
        
        return $encryped;
    } 
}

if(!function_exists('template_view')){
function template_view($data=array())
    {
		$ci =& get_instance();		
        return $ci->load->view('template/index', $data);
    } 
}

if(!function_exists('admin_template_view')){
function admin_template_view($data=array())
    {
		$ci =& get_instance();		
        return $ci->load->view('template/admin/index', $data);
    } 
}

if(!function_exists('flash_message')){
function flash_message($jenis,$redirect='')
    {
		$ci =& get_instance();
		$ci->load->library('session');

		switch($jenis){
			case 'add' :
				$ci->session->set_flashdata('simpan', array('status' => 'success','message' => 'You successfully insert the data.'));
				break;
			case 'edit' :
				$ci->session->set_flashdata('simpan', array('status' => 'success','message' => 'You successfully update the data.'));
				break;
			case 'delete' :
				$ci->session->set_flashdata('simpan', array('status' => 'success','message' => 'You successfully delete the data.'));
				break;
			default :
				break;
		}		
		redirect($redirect);
    } 
}

if(!function_exists('get_member')){
function get_member($hanya='')
    {   
		$data = array();    	
		$ci =& get_instance();
		$ci->load->model('member_model','member_m');
		$count	= $ci->member_m->count_member();
		$member	= $ci->member_m->get_member($count);
		
		if($hanya){	
			if($member){		
				foreach($member as $dt_key=>$dt_val){
					if(array_key_exists($hanya,$dt_val)){
						$data[] = $dt_val[$hanya];
					}
				}
			}
		}else{
			$data = $member;
		}
		
		return $data;	
    } 
}

if(!function_exists('get_kode')){
function get_kode()
    {       	
		$ci =& get_instance();
		$ci->load->model('kode_model','kode_m');
		$count	= $ci->kode_m->count_kode();
		$data	= $ci->kode_m->get_kode($count);
		
		return $data;	
    } 
}

if(!function_exists('get_no_tujuan')){
function get_no_tujuan()
    {   
		$hasil = array();    	
		$ci =& get_instance();
		$ci->load->model('transaksi_model','transaksi_m');
		$data	= $ci->transaksi_m->get_no_tujuan();
		if($data){
		foreach($data as $dt){
			$hasil[] = $dt['no_tujuan'];
		}
		}
		
		return $hasil;	
    } 
}

if(!function_exists('get_setting')){
function get_setting($slug)
    {
		$ci =& get_instance();		
		$ci->load->model('setting_model','setting_m');
		$data = $ci->setting_m->get_setting_by_slug($slug);
		
        return $data['content'];
    } 
}

if(!function_exists('format_amount')){
function format_amount($harga)
    {		
		$hasil = '-';
		if($harga){
			$hasil = "Rp.<span class='ratanya'>".number_format($harga,2,',','.')."</span>";
		}
		
		return $hasil;
    } 
}


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_manage extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		restrict_admin();
		$this->load->model('admin_manage_model','admin_manage_m');
    }
	
	public function index()
	{
		$this->view();
	}
	
	public function view()
	{				
		$data_query = $this->admin_manage_m->get_admin();		
		$data = array (			
			'data_query'	=> $data_query,
		);
		$this->show($data);
	}
	
	public function add()
	{		
		if($this->input->post()){
			$this->simpan_data();
		}				
		$this->show();
	}
	
	public function edit($id=0)
	{		
		$data_detail = $this->admin_manage_m->get_admin_detail($id);
		if(!$data_detail){
			redirect('admin/admin_manage');
		}
		$this->session->set_userdata('email_change',$data_detail['email']);
		
		if($this->input->post()){
			$this->simpan_data($id);
		}		
		$data['default'] = $data_detail;
					
		$this->show($data);		
	}
	
	private function show($data=array())
	{
		$data['main_content'] = 'admin_manage';
		admin_template_view($data);
	}
	
	private function simpan_data($id=0)
	{
		$data_detail = $this->admin_manage_m->get_admin_detail($id);		
		
		$this->form_validation->set_rules('user', 'Nama admin', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
		if($this->uri->segment(3)=='add'){
			$this->form_validation->set_rules('pass', 'Password', 'required');
			$this->form_validation->set_rules('repassword', 'Re-Password', 'required|matches[pass]');
		}
		
		if ($this->form_validation->run() == TRUE){			
			$simpan_data = array(
				'user'	=> $this->input->post('user'),
				'email'	=> $this->input->post('email'),
			);			
			
			if($this->uri->segment(3)=='add'){	
				$salt = salt();		
				$simpan_data['salt'] = $salt;
				$simpan_data['pass'] = encrypt($this->input->post('pass'),$salt);
				$this->admin_manage_m->insert_admin($simpan_data);
				flash_message('add','admin/admin_manage');
			}elseif($this->uri->segment(3)=='edit'){
				$this->admin_manage_m->update_admin($simpan_data,$id);
				$this->session->unset_userdata('email_change','');
				flash_message('edit','admin/admin_manage');
			}
		}
	}
	
	public function delete($id)
	{
		$this->admin_manage_m->delete_admin($id);
		flash_message('delete','admin/admin_manage');
	}
	
	public function email_check($email)
	{
		$data_detail = $this->admin_manage_m->get_admin_by_email($email);
		$email_change = $this->session->userdata('email_change');
		if ($data_detail && $email_change != $email){
			$this->form_validation->set_message('email_check', "The email '$email' was registered");
			return FALSE;
		} else{
			return TRUE;
		}
	} 
	
	public function change_password()
	{
		$data_detail = $this->admin_manage_m->get_admin_by_email($this->session->userdata('email'));
		if($this->input->post('simpan')){			
			$this->form_validation->set_rules('user', '', '');
			$this->form_validation->set_rules('password', 'New Password', 'required|callback_pass_check');
			$this->form_validation->set_rules('repassword', 'Confirm Password', 'required|matches[password]');
					
			if ($this->form_validation->run() == TRUE){
				$simpan_data = array('pass' => encrypt($this->input->post('password'),$data_detail['salt']));
				$this->admin_manage_m->update_admin($simpan_data,$data_detail['idadmin']);
				$this->session->set_flashdata('simpan', array('status' => 'success','message' => 'You successfully change your password.'));
				$this->session->sess_destroy();
				redirect('admin/change_password');
			}
		}
		
		$data = array (
			'main_content' => 'change_password',
			
			'default'		=> $data_detail,
		);
		admin_template_view($data);
	}
	
	public function pass_check($pass)
	{
		$email = $this->session->userdata('email');
		$data_detail = $this->admin_manage_m->admin_login($email,salt_encrypt($email,$pass));
		
		if ($data_detail){
			$this->form_validation->set_message('pass_check', "Can't same with old password.");
			return FALSE;
		} else{
			return TRUE;
		}
	}
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		restrict_admin();
		$this->load->model('member_model','member_m');
		$this->limit	= $this->config->item('limit');
    }
	
	public function index()
	{
		redirect('admin/member/view');
	}
	
	public function view()
	{		
		$count = $this->member_m->count_member();	
		$uri_offset = 4;	
		$offset = $this->uri->segment($uri_offset);				
		$config['base_url'] 		= site_url('admin/member/view/');
		$config['total_rows'] 		= $count;
		$config['per_page'] 		= $this->limit;
		$config['uri_segment'] 		= $uri_offset;		
		$this->pagination->initialize($config);	
		$paging = $this->pagination->create_links();
				
		$data_query = $this->member_m->get_member($this->limit, $offset);	
		$total_hutang = $this->member_m->get_hutang_total();	
					
		if($this->input->post('cari')){
			$data_query = $this->member_m->search_member($this->input->post('cari'));
			$paging = '';
			$total_hutang = $this->member_m->get_hutang_total($this->input->post('cari'));
		}
		
		$data = array (			
			'data_query'	=> $data_query,
			'paging'		=> $paging,
			'totalnya'		=> $total_hutang
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
		$data_detail = $this->member_m->get_member_detail($id);
		if(!$data_detail){
			redirect('admin/member');
		}
		
		if($this->input->post()){
			$this->simpan_data($id);
		}		
		$data['default'] = $data_detail;
					
		$this->show($data);		
	}
	
	private function show($data=array())
	{
		$data['main_content'] = 'member';
		admin_template_view($data);
	}
	
	private function simpan_data($id=0)
	{
		$data_detail = $this->member_m->get_member_detail($id);		
		
		$this->form_validation->set_rules('nama_member', 'Nama Member', 'required');
		$this->form_validation->set_rules('hape', 'Hape', 'required|integer');
		if($this->uri->segment(3)=='add'){	
			$this->form_validation->set_rules('hape', 'Hape', 'required|integer|callback_hape_check');
		}
		$this->form_validation->set_rules('email', 'Email', 'valid_email');
		$this->form_validation->set_rules('balance', 'Balance', 'integer');
		$this->form_validation->set_rules('hutang_2012', 'Hutang 2012', 'integer');
		
		if ($this->form_validation->run() == TRUE){		
			$balance = 0;
			if($data_detail){
				$balance = $data_detail['balance'];
			}
			$balance = $balance + $this->input->post('balance');
			
			$simpan_data = array(
				'nama_member'	=> $this->input->post('nama_member'),
				'hape'			=> $this->input->post('hape'),
				'email'			=> $this->input->post('email'),
				'balance'		=> $balance,
				'hutang_2012'	=> $this->input->post('hutang_2012'),
			);
			
			if($this->uri->segment(3)=='add'){			
				$this->member_m->insert_member($simpan_data);
				flash_message('add','admin/member/view');
			}elseif($this->uri->segment(3)=='edit'){
				$this->member_m->update_member($simpan_data,$id);
				flash_message('edit','admin/member/view');
			}
		}
	}
	
	public function delete($id)
	{
		$this->member_m->delete_member($id);
		flash_message('delete','admin/member/view');
	}
	
	public function hape_check($hape)
	{
		$cek	= $this->member_m->get_member_by_hape($hape);
		if ($cek){
			$this->form_validation->set_message('hape_check', "No Hape '$hape' is exist.");
			return FALSE;
		}else{
			return TRUE;
		}
	}
}
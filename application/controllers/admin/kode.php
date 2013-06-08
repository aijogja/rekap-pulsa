<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kode extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		restrict_admin();
		$this->load->model('kode_model','kode_m');
		$this->limit	= $this->config->item('limit');
    }
	
	public function index()
	{
		$this->view();
	}
	
	public function view()
	{				
		$count = $this->kode_m->count_kode();	
		$uri_offset = 4;	
		$offset = $this->uri->segment($uri_offset);				
		$config['base_url'] 		= site_url('admin/kode/view/');
		$config['total_rows'] 		= $count;
		$config['per_page'] 		= $this->limit;
		$config['uri_segment'] 		= $uri_offset;		
		$this->pagination->initialize($config);	
				
		$data_query = $this->kode_m->get_kode($this->limit, $offset);		
		$data = array (			
			'data_query'	=> $data_query,
			'paging'		=> $this->pagination->create_links(),
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
		$data_detail = $this->kode_m->get_kode_detail($id);
		if(!$data_detail){
			redirect('admin/kode');
		}
		
		if($this->input->post()){
			$this->simpan_data($id);
		}		
		$data['default'] = $data_detail;
					
		$this->show($data);		
	}
	
	private function show($data=array())
	{
		$data['main_content'] = 'kode';
		admin_template_view($data);
	}
	
	private function simpan_data($id=0)
	{
		$data_detail = $this->kode_m->get_kode_detail($id);		
		
		$this->form_validation->set_rules('kode', 'Kode', 'required');
		if($this->uri->segment(3)=='add'){
			$this->form_validation->set_rules('kode', 'Kode', 'required|callback_kode_check');
		}
		$this->form_validation->set_rules('provider', 'Provider', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required|integer');
		
		if ($this->form_validation->run() == TRUE){			
			$simpan_data = array(
				'kode'			=> strtoupper($this->input->post('kode')),
				'provider'		=> $this->input->post('provider'),
				'harga'			=> $this->input->post('harga'),
			);
			
			if($this->uri->segment(3)=='add'){			
				$this->kode_m->insert_kode($simpan_data);
				flash_message('add','admin/kode/view');
			}elseif($this->uri->segment(3)=='edit'){
				$this->kode_m->update_kode($simpan_data,$id);
				flash_message('edit','admin/kode/view');
			}
		}
	}
	
	public function delete($id)
	{
		$this->kode_m->delete_kode($id);
		flash_message('delete','admin/kode/view');
	}
	
	public function kode_check($kode)
	{
		$kode 	= strtoupper($kode);
		$cek	= $this->kode_m->get_kode_by_kode($kode);
		if ($cek){
			$this->form_validation->set_message('kode_check', "Kode '$kode' is exist.");
			return FALSE;
		}else{
			return TRUE;
		}
	}

}
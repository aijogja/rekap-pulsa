<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deposit extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		restrict_admin();
		$this->load->model('deposit_model','deposit_m');
		$this->limit	= $this->config->item('limit');
    }
	
	public function index()
	{	
		$this->session->unset_userdata('bulan');
		redirect('admin/deposit/view');
	}
	
	public function view()
	{				
		$count = $this->deposit_m->count_deposit();	
		$uri_offset = 4;	
		$offset = $this->uri->segment($uri_offset);				
		$config['base_url'] 		= site_url('admin/deposit/view/');
		$config['total_rows'] 		= $count;
		$config['per_page'] 		= $this->limit;
		$config['uri_segment'] 		= $uri_offset;		
		$this->pagination->initialize($config);	
				
		$data_query = $this->deposit_m->get_deposit($this->limit, $offset);		
		
		$sum_as = array('terhutang'=>'0', 'lunas'=>'1', 'total'=>NULL);
		foreach($sum_as as $jenis=>$status){
			$where = array();
			if($status != NULL){
				$where = array('status' => $status);
			}
			$totalan[$jenis]=$this->deposit_m->get_jumlah_total($where);
		}
		//print_r($totalan); 		
		$data = array (			
			'data_query'	=> $data_query,
			'paging'		=> $this->pagination->create_links(),
			'totalnya'		=> $totalan
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
		$data_detail = $this->deposit_m->get_deposit_detail($id);
		if(!$data_detail){
			redirect('admin/deposit');
		}
		
		if($this->input->post()){
			$this->simpan_data($id);
		}		
		$data['default'] = $data_detail;
					
		$this->show($data);		
	}
	
	private function show($data=array())
	{
		$data['main_content'] = 'deposit';
		admin_template_view($data);
	}
	
	private function simpan_data($id=0)
	{
		$data_detail = $this->deposit_m->get_deposit_detail($id);		
		
		$this->form_validation->set_rules('nominal', 'Nominal', 'required');
		$this->form_validation->set_rules('tgl', 'Tanggal', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required|');
		
		if ($this->form_validation->run() == TRUE){	
			$tgl_bayar = NULL;
			if($this->input->post('tgl_bayar')){
				$tgl_bayar = strtotime($this->input->post('tgl_bayar'));
			}
			//$status = $this->input->post('status');
			//if($status == 1){$tgl_bayar = strtotime($this->input->post('tgl_bayar'));}
					
			$simpan_data = array(
				'nominal'	=> $this->input->post('nominal'),
				'tgl'		=> strtotime($this->input->post('tgl')),
				'status'	=> $this->input->post('status'),
				'tgl_bayar'	=> $tgl_bayar,
			);
			
			if($this->uri->segment(3)=='add'){			
				$this->deposit_m->insert_deposit($simpan_data);
				flash_message('add','admin/deposit/view');
			}elseif($this->uri->segment(3)=='edit'){
				$this->deposit_m->update_deposit($simpan_data,$id);
				flash_message('edit','admin/deposit/view');
			}
		}
	}
	
	public function delete($id)
	{
		$this->deposit_m->delete_deposit($id);
		flash_message('delete','admin/deposit/view');
	}
		
	public function get_deposit_by_month($month)
	{
		$sesion_data = array(
		   'bulan'  	=> urldecode($month),
		);
		$this->session->set_userdata($sesion_data);
		
		echo site_url('admin/deposit/view');
	}
}
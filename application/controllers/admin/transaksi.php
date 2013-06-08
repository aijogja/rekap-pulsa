<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		restrict_admin();
		$this->load->model('transaksi_model','transaksi_m');
		$this->load->model('member_model','member_m');
		$this->load->model('kode_model','kode_m');
		$this->limit	= $this->config->item('limit');
    }
	
	public function index()
	{	
		$this->session->unset_userdata('bulan');
		redirect('admin/transaksi/view');	
	}
	
	public function view()
	{				
		$count = $this->transaksi_m->count_transaksi();	
		$uri_offset = 4;	
		$offset = $this->uri->segment($uri_offset);				
		$config['base_url'] 		= site_url('admin/transaksi/view/');
		$config['total_rows'] 		= $count;
		$config['per_page'] 		= $this->limit;
		$config['uri_segment'] 		= $uri_offset;		
		$this->pagination->initialize($config);	
				
		$data_query = $this->transaksi_m->get_transaksi($this->limit, $offset);		
		$data = array (			
			'i'				=> 1+$offset,
			'data_query'	=> $data_query,
			'paging'		=> $this->pagination->create_links(),
			'totalnya'		=> $this->transaksi_m->get_jumlah_total()
		);
		$this->show($data);
	}
	
	public function cari($idmember='')
	{						
		if(!$idmember){
			$data_member = $this->member_m->search_member($this->input->post('cari'));
			if($data_member && count($data_member) == 1){
				$idmember = $data_member[0]['idmember'];				
				redirect('admin/transaksi/cari/'.$idmember);
			} else {
				redirect('admin/transaksi/view');
			}			
		}
		
		$cek_member = $this->member_m->get_member_detail($idmember);
		if(!$cek_member){
			redirect('admin/transaksi/view');
		}
		
		$where = array('membernya' => $idmember);
		$count = $this->transaksi_m->count_transaksi($where);	
		$uri_offset = 5;	
		$offset = $this->uri->segment($uri_offset);				
		$config['base_url'] 		= site_url('admin/transaksi/cari/'.$idmember.'/');
		$config['total_rows'] 		= $count;
		$config['per_page'] 		= $this->limit;
		$config['uri_segment'] 		= $uri_offset;		
		$this->pagination->initialize($config);	
				
		$data_query = $this->transaksi_m->get_transaksi($this->limit, $offset, $where);		
		$data = array (			
			'i'				=> 1+$offset,
			'data_query'	=> $data_query,
			'paging'		=> $this->pagination->create_links(),
			'totalnya'		=> $this->transaksi_m->get_jumlah_total($where)
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
		$data_detail = $this->transaksi_m->get_transaksi_detail($id);
		if(!$data_detail){
			redirect('admin/transaksi');
		}
		
		if($this->input->post()){
			$this->simpan_data($id);
		}		
		$data['default'] = $data_detail;
					
		$this->show($data);		
	}
	
	private function show($data=array())
	{
		$data['main_content'] = 'transaksi';
		admin_template_view($data);
	}
	
	private function simpan_data($id=0)
	{
		$data_detail = $this->transaksi_m->get_transaksi_detail($id);		
		
		$this->form_validation->set_rules('membernya', 'Member', 'required');
		$this->form_validation->set_rules('kodenya', 'Kode', 'required');
		$this->form_validation->set_rules('no_tujuan', 'No Tujuan', 'required|integer');
		$this->form_validation->set_rules('sn', '', '');
		$this->form_validation->set_rules('tgl', 'Tanggal', 'required');
		$this->form_validation->set_rules('total', 'Total', 'required|integer');
		$this->form_validation->set_rules('status', 'Status', 'required|');
		
		if ($this->form_validation->run() == TRUE){			
			$simpan_data = array(
				'membernya'	=> $this->input->post('membernya'),
				'kodenya'	=> $this->input->post('kodenya'),
				'no_tujuan'	=> $this->input->post('no_tujuan'),
				'sn'		=> $this->input->post('sn'),
				'tgl'		=> strtotime($this->input->post('tgl')),
				'total'		=> $this->input->post('total'),
				'status'	=> $this->input->post('status'),
			);
			
			if($this->uri->segment(3)=='add'){			
				$this->transaksi_m->insert_transaksi($simpan_data);
				flash_message('add','admin/transaksi/view');
			}elseif($this->uri->segment(3)=='edit'){
				$this->transaksi_m->update_transaksi($simpan_data,$id);
				flash_message('edit','admin/transaksi/view');
			}
		}
	}
	
	public function delete($id)
	{
		$this->transaksi_m->delete_transaksi($id);
		flash_message('delete','admin/transaksi/view');
	}
	
	public function get_harga_by_kode($id)
	{
		$data = $this->kode_m->get_kode_detail($id);
		echo $data['harga'];
	}
	
	public function get_transaksi_by_month($month)
	{
		$sesion_data = array(
		   'bulan'  	=> urldecode($month),
		);
		$this->session->set_userdata($sesion_data);
		
		echo site_url('admin/transaksi/view');
	}
	
	public function export($idmember='')
	{
		$where = array();
		if($idmember) {
			$where = array('membernya' => $idmember);
			$data['member']	= $this->member_m->get_member_detail($idmember);
		}
		$data['data_query'] = $this->transaksi_m->get_transaksi($this->transaksi_m->count_transaksi(), 0, $where);
		$data['totalnya']	= $this->transaksi_m->get_jumlah_total($where);
		
		$this->load->view('content/admin/export/export_transaksi', $data);
	}
	
}
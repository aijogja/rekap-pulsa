<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap_transaksi extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		restrict_admin();
		$this->load->model('transaksi_model','transaksi_m');
		$this->load->model('kode_model','kode_m');
		$this->limit	= $this->config->item('limit');
    }
	
	public function index()
	{	
		$this->session->unset_userdata('bulan');
		
		redirect('admin/rekap_transaksi/terhutang');
	}
	
	// Menampilkan data transaksi yang sudah lunas
	public function lunas()
	{	
		$where = array('status'=>'1');
		$this->view($where);
	}
	
	// Menampilkan data transaksi yang terhutang
	public function terhutang()
	{	
		$where = array('status'=>'0');
		$this->view($where);
	}
	
	public function view($where)
	{	
		$count = $this->transaksi_m->count_transaksi($where);	
		$uri_offset = 4;	
		$offset = $this->uri->segment($uri_offset);				
		$config['base_url'] 		= site_url('admin/rekap_transaksi/'.$this->uri->segment(3).'/');
		$config['total_rows'] 		= $count;
		$config['per_page'] 		= $this->limit;
		$config['uri_segment'] 		= $uri_offset;		
		$this->pagination->initialize($config);	
				
		$data_query = $this->transaksi_m->get_transaksi($this->limit, $offset, $where);		
		$data = array (			
			'data_query'	=> $data_query,
			'paging'		=> $this->pagination->create_links(),
			'totalnya'		=> $this->transaksi_m->get_jumlah_total($where)
		);
		$this->show($data);
	}
	
	// Private show template
	private function show($data=array())
	{
		$data['main_content'] = 'rekap_transaksi';
		admin_template_view($data);
	}
	
	// Trigger Ajax untuk menampilkan data perbulan
	public function per_month($month)
	{
		$sesion_data = array(
		   'bulan'  	=> urldecode($month),
		);
		$this->session->set_userdata($sesion_data);
		
		echo site_url('admin/rekap_transaksi/terhutang');
	}
}
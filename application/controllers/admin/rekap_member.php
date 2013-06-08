<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap_member extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		restrict_admin();
		$this->load->model('transaksi_model','transaksi_m');
		$this->load->model('member_model','member_m');
		$this->limit	= $this->config->item('limit');
    }
	
	public function index()
	{	
		$this->view();
	}
	
	// Menampilkan seluruh data member dan todal hutangnya
	public function view()
	{	
		$count = $this->member_m->count_member();
		$uri_offset = 4;	
		$offset = $this->uri->segment($uri_offset);				
		$config['base_url'] 		= site_url('admin/rekap_member/view/');
		$config['total_rows'] 		= $count;
		$config['per_page'] 		= $this->limit;
		$config['uri_segment'] 		= $uri_offset;		
		$this->pagination->initialize($config);	
				
		$data_query = $this->transaksi_m->get_hutang_member($this->limit, $offset);		
		$data = array (			
			'data_query'	=> $data_query,
			'paging'		=> $this->pagination->create_links(),
		);
		$this->show($data);
	}
	
	// Private show template
	private function show($data=array())
	{
		$data['main_content'] = 'rekap_member';
		admin_template_view($data);
	}
		
	// Menampilkan hurangnya detail dari masing-masing member
	public function hutangnya($id)
	{	
		$detail = $this->transaksi_m->get_hutang_member_detail($id);
		$where = array('status'=>'0','membernya'=>$id);
		$total_hutang = $this->transaksi_m->get_jumlah_total($where, FALSE);
		$member = $this->member_m->get_member_detail($id);
		
		$i=0;
		$dialog = "<div id='dialog'>";
		$dialog .= "<table class='table table-condensed'><thead><tr><th>No</th><th>Tanggal</th><th>Kode</th><th>No Tujuan</th><th>Total</th></tr></thead><tbody>";
		if($detail):
		foreach($detail as $dt): $i++;			
			$dialog .= "<tr><td>".$i."</td><td>".date('d/m/Y',$dt['tgl'])."</td><td>".$dt['kode']."</td><td>".$dt['no_tujuan']."</td><td>".format_amount($dt['total'])."</td></tr>";			
		endforeach; 
		endif;
		$dialog .= "</tbody><tfoot>";
		$totalnya = $total_hutang['total']+$member['hutang_2012']-$member['balance'];
		
		$dialog .= "<tr><td colspan='3'></td><td>Total</td><td style='border-top:1px solid #000'>".format_amount($total_hutang['total'])."</td></tr>";
		if($member['hutang_2012']) {
			$dialog .= "<tr><td colspan='3'></td><td>Hutang 2012</td><td>".format_amount($member['hutang_2012'])."</td></tr>";
		}
		$dialog .= "<tr><td colspan='3'></td><td>Balance</td><td style='border-bottom:1px solid #000'>".format_amount($member['balance'])."</td></tr>";
		$dialog .= "<tr><td colspan='3'></td><td>Total Hutang</td><td>".format_amount($totalnya)."</td></tr></tfoot></table></div>";
		echo $dialog;
	}
}
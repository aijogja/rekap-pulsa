<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap_member extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		restrict_admin();
		$this->load->model('transaksi_model','transaksi_m');
		$this->load->model('member_model','member_m');
		$this->load->model('admin_manage_model','admin_manage_m');
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
	public function hutangnya($id='')
	{	
		$detail = $this->transaksi_m->get_hutang_member_detail($id);						
		$where = array('status'=>'0','membernya'=>$id);
		$total_hutang = $this->transaksi_m->get_jumlah_total($where, FALSE);
		$member = $this->member_m->get_member_detail($id);		
		$totalnya = $total_hutang['total']+$member['hutang_2012']-$member['balance'];
		
		// <tbody>
			$i=0; $tbody = "";
			if($detail):
				foreach($detail as $dt): $i++;			
					$tbody .= "<tr><td>".$i."</td><td>".date('d/m/Y',$dt['tgl'])."</td><td>".$dt['kode']."</td><td>".$dt['no_tujuan']."</td><td>".format_amount($dt['total'])."</td></tr>";			
				endforeach; 
			else:
				$tbody .= "<td colspan='5' class='nodata muted'>No Data</td>";			
			endif;		
		// </tbody>
		// <tfoot>	
			$tfoot = "";	
			$tfoot .= "<tr><td colspan='3'></td><td>Total</td><td style='border-top:1px solid #000'>".format_amount($total_hutang['total'])."</td></tr>";
			if($member['hutang_2012']) {
				$tfoot .= "<tr><td colspan='3'></td><td>Hutang 2012</td><td>".format_amount($member['hutang_2012'])."</td></tr>";
			}
			$tfoot .= "<tr><td colspan='3'></td><td>Balance</td><td style='border-bottom:1px solid #000'>".format_amount($member['balance'])."</td></tr>";
			$tfoot .= "<tr><td colspan='3'></td><td>Total Hutang</td><td>".format_amount($totalnya)."</td></tr>";			
		// </tfoot>
		// button email
		$button = '';
		if(!empty($member['email'])){
			$button = "<a href='".site_url('admin/'.$this->uri->segment(2).'/send_email/'.$id)."' class='btn btn-success btn-mini send_mail pull-left' onClick='send_tagihan(); return false;'>Sent Email</a>";
		}
		
		echo json_encode(array('tbody' => $tbody, 'tfoot' => $tfoot, 'button' => $button));
	}
	
	public function send_email($idmember='')
	{				
		$detail = $this->member_m->get_member_detail($idmember);
		if(!$detail){
			redirect('');
		}				

		$superadmin = $this->admin_manage_m->get_admin_detail(0);
		$email = get_setting('email');
		$sender = ($email)? $email : $superadmin['email'];
		$from_name = get_setting('nama_celluler');
				
		$data['member'] = $detail;
		$data['tagihan'] = $this->transaksi_m->get_hutang_member_detail($detail['idmember']);
		$data['total_hutang'] = $this->transaksi_m->get_jumlah_total(array('status'=>'0','membernya'=>$detail['idmember']), FALSE);

		$this->email->clear();
		$this->email->from($sender, $from_name);
		$this->email->to($detail['email']); 
		$this->email->subject('Tagihan Pulsa');
		$this->email->message($this->load->view('content/admin/mail_tagihan',$data,TRUE));		
		if($this->email->send()){
			echo 'sukses';
		} else {
			echo 'gagal';
		}
	}
}
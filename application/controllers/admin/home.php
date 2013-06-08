<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('admin_manage_model','admin_manage_m');
		$this->load->model('member_model','member_m');
		$this->load->model('transaksi_model','transaksi_m');
		$this->load->model('setting_model','setting_m');
    }
	
	public function index()
	{
		if($this->input->post('login')){
			$email 	= $this->input->post('email');
			$pass	= $this->input->post('password');
			$login	= $this->admin_manage_m->admin_login($email,$pass);

			if($login){
				$sesion_data = array(
                   'user'  		=> $login['user'],
                   'email'  	=> $email,
                   'logged_in' 	=> TRUE
               	);

				$this->session->set_userdata($sesion_data);
			}
		}
		$data['main_content'] = 'welcome';
		admin_template_view($data);
	}
	
	public function setting()
	{		
		restrict_admin();				
		$default = array();
		if($default_data = $this->setting_m->get_setting()){
			foreach($default_data as $df){
				$default[$df['slug']] = $df['content'];
			}
		}
		
		if($post_data = $this->input->post()){
			foreach($post_data as $key=>$val){
				if($key == 'email'){
					$this->form_validation->set_rules($key, $key, 'valid_email');
				}
				$simpan[] = array(
					'slug' 		=> $key,
					'content'	=> $val
				);
			}
			
			if ($this->form_validation->run() == TRUE){
				foreach($simpan as $sav_key){	
					$data = $this->setting_m->get_setting_by_slug($sav_key['slug']);				
					if($data){
						$this->setting_m->update_setting($sav_key,$sav_key['slug']);
					}else{
						$this->setting_m->insert_setting($sav_key);
					}
				}						
				flash_message('edit',current_url());
			}
		}
		
		$data['default'] = $default;
		$data['main_content'] = 'setting';
		admin_template_view($data);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('admin');
	}	
	
	public function cron_balance_transaksi()
	{	
		// Hanya Dapat diakses dari CLI
		if (!$this->input->is_cli_request()) show_error('Direct access is not allowed');		
		$member = $this->member_m->get_member_with_balance();
		if($member){foreach($member as $mem){
			$balance = $mem['balance'];
			// nyahur hutang dulu
			if($mem['hutang_2012']){
					$hitung = $mem['hutang_2012']-$balance;	
					if($hitung < 0){
						$hutang = '';
						$balance = abs($hitung);
					} else {
						$hutang = $hitung;
						$balance = '';
					}		
					$simpan_data = array(
						'balance'		=> $balance,
						'hutang_2012'	=> $hutang,
					);			
					$this->member_m->update_member($simpan_data,$mem['idmember']);
			}
			// baru ngurangi transaksi
			if(!empty($balance)){
				$transaksi = $this->transaksi_m->get_hutang_member_detail($mem['idmember']);
				if($transaksi){
					$i=0;
					foreach($transaksi as $trx){																	
						if($trx['harga'] > $balance){
							break;
						}
						$balance = $balance-$trx['harga'];
						$update_trx = array('status'=>1);
						$this->transaksi_m->update_transaksi($update_trx, $trx['idtransaksi']);
					}
					$update_balance = array('balance'=> $balance);			
					$this->member_m->update_member($update_balance,$mem['idmember']);
				}
			}	
		}}
	}
	
	public function send_mail_tagihan()
	{				
		// Hanya Dapat diakses dari CLI
		if (!$this->input->is_cli_request()) show_error('Direct access is not allowed');						
		$superadmin = $this->admin_manage_m->get_admin_detail(0);
		$email = get_setting('email');
		$sender = ($email)? $email : $superadmin['email'];
		$from_name = get_setting('nama_celluler');
		
		$member = $this->transaksi_m->get_member_hutang_and_email();
		foreach($member as $m){
			$data['member'] = $m;
			$data['tagihan'] = $this->transaksi_m->get_hutang_member_detail($m['idmember']);
			$data['total_hutang'] = $this->transaksi_m->get_jumlah_total(array('status'=>'0','membernya'=>$m['idmember']), FALSE);
			
			$this->email->clear();
			$this->email->from($sender, $from_name);
			$this->email->to($m['email']); 
			$this->email->subject('Tagihan Pulsa');
			$this->email->message($this->load->view('content/admin/mail_tagihan',$data,TRUE));
			
			$this->email->send();
		}		
	}
	
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
    {
        parent::__construct();
    }
	
	public function index()
	{
		$data['main_content'] = 'home';
		template_view($data);
	}
	
	public function services()
	{
		if($this->input->post('nope')){
			$dialog['dialog'] = 'cek';
			$this->load->view('content/services_dialog',$dialog);
		}
		
		$data['main_content'] = 'services';
		template_view($data);
	}
}

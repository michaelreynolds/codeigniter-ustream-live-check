<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Normal extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('live_model');
		$this->load->helper('url');
	}
	//******************************************//
	public function index()
	{
		$live = $this->live_model->check_if_live();//live or not
		
		if($live == true){
			redirect('/live', 'location', 302);
		}
		else{
			$this->load->view('normal');
		}
	}
}
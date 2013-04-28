<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Live extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('live_model');
		$this->load->helper('url');
	}
	//******************************************//
	public function index()
	{
		$live = $this->live_model->check_if_live();
		
		if($live == false){
			redirect('/', 'location', 302); //stream is not live
		}
		else{
			$this->load->view('live'); //stream is live
		}
	}
	//******************************************//
	function check(){ //for ajax check
		
		$live = $this->live_model->check_if_live();//live or not
		
		if($this->input->is_ajax_request()){
			if($live == true){
				echo('{"live": true}');
			}
			else{
				echo('{"live": false}');
			}
		}else {
			redirect('/', 'location', 302);
		}
	}
}
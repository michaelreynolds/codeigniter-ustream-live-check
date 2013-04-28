<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Live_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database('');
	}
	//**************************************//
	function check_if_live(){
		//check air times from db AND live stream from ustream
		if($this->check_broadcast() == true && $this->check_schedule() == true){ 
			return true;
		}
		else {
			return false;
		}
	}
	//**************************************//
	function check_broadcast(){
		//check if stream is live
		
		//IMPORTANT: you must register and get an api key here: http://developer.ustream.tv
		$devkey = ''; //then get a key here: http://developer.ustream.tv/apikey/generate
		
		$channelname = "live-iss-stream";
		//$channelname = "nasahdtv";
		
		//ustream json pattern
		//http://api.ustream.tv/json/channel/all/search/title:eq:yourChannelName?key=yourDevkey
		//******************************************//
		
		$ustream = file_get_contents('http://api.ustream.tv/json/channel/all/search/title:eq:' . $channelname . '?key=' . $devkey );
		
		$result = json_decode($ustream);
		$live = $result->results[0]->status;
		
		if($live == "offline"){
			return false;
		}
		elseif($live == "live"){
			return true;
		}
		else {
			return false;
		}
	}
	//******************************************//
	function check_schedule(){
		//cross check db for air time
		return true;
		$now = new DateTime();
		$this->db->from('air_times');
		$this->db->order_by('air_date',  'desc');//order descending to find newest time
		$this->db->limit(1);
		$this->db->where('air_date <=', $now->format('Y-m-d H:i:s'));//find the previous_start_time before now
		
		//check for a air start time and add 2 hours -- if within that period -- system is set to live
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$previous_start_time = $row->air_date;
				$end = $row->air_date;
				$end = date('Y-m-d H:i:s', strtotime("$end + 2 hours"));
			}
			if($previous_start_time < $now->format("Y-m-d H:i:s")){//if meeting is not more then 2 hours past start time
				if($end > $now->format("Y-m-d H:i:s")){
					return true; //currently scheduled to be live
				}
				else{
					return false; //allow meetings to go on for up to 2 hours
				}
			}
		}
		else{ 
			return false; //bad query
		}
	}
}
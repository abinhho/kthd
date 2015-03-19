<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class In_home extends MX_Controller {
	public function __construct(){
       	parent::__construct();
      	
	}
	public function index()
	{
		
		$data = array(
			"questions" => $this->load->module('questions')
			//,"news" => $this->load->module('news')
			//,"albums" => $this->load->module('albums')
		);
		
		$this->load->view("in_home", @$data);
	}
}
 

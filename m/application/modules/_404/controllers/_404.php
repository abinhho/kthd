<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _404 extends MX_Controller {
	
	public function __construct(){
       	parent::__construct();
       	
	}
	public function index()
	{
		$this->config->set_item('body_layout', 'body');
		echo "<div class='page_404'>Xin lổi!. Trang này không tìm thấy hoặc đã bị xóa.</div>";
	}
	
}
 
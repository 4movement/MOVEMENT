<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movement_Index extends CI_Controller {
	public function index()
	{
		$this->load->helper('url');
		$this->load->view('movement_index');
	}
}

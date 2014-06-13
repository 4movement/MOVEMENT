<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movement extends CI_Controller {
	public function index()
	{
		$this->detail();
		$this->load->view('movement');
	}
	
	private function detail()
	{
		$this->load->model('issue');
		$id = 307;
		$issue = $this->issue->get_issue_detail($id);
		$date = explode('-',$issue->date_start);
		$date = date('n/d',mktime(0,0,0,$date[1],$date[2],$date[0]));
		$data = array(
			'intro' => $issue->intro,
			'demand' => 'none',
			'host' => $issue->host,
			'date_start' => $issue->date_start,
			'time_start' => $issue->time_start,
			'date_end' => $issue->date_end,
			'time_end' => $issue->time_end,
			'url' => $issue->url,
			'name' => $issue->name,
			'date' => $date,
			'city' => $issue->city,
			'joins' => $issue->joins,
			'support' => $issue->support,
			'donate' => $issue->donate
		);
		$this->load->vars($data);
	}
}

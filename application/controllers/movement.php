<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movement extends CI_Controller {
	public function index()
	{
		$this->load->model('issue');
		$this->load->helper('url');

		/* get data from database */
		$this->detail();
		$this->set_focus();
		$this->set_lists();

		/* load view */
		$this->load->view('movement');
		$this->load->view('lists');
	}
	
	private function detail()
	{
		$id = 178;
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

	private function set_focus(){
		$id = 178;
		$issue = $this->issue->get_issue_detail($id);
		$date = explode('-',$issue->date_start);
		$date = date('n/d',mktime(0,0,0,$date[1],$date[2],$date[0]));
		$data = array(
			'name' => $issue->name,
			'date' => $date,
			'city' => $issue->city,
		);
		$this->load->vars($data);
	}

	private function set_lists(){
		$issues = $this->issue->get_issues();
		$items = "					<li class=\"item\">\n";
		$items.= "						<img src=\"assets/img/sample.jpg\" />\n";
		$items.= "					</li>\n";
		$lists = "";
		for($i=0;$i<count($issues);$i++){
			$lists .= $items;	
		}

		$data = array(
			'lists' => $lists
		);
		$this->load->vars($data);
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movement_List extends CI_Controller {
	public function index()
	{
		$this->load->model('issue');
		$data = $this->set_focus(); 
		$data['lists'] = $this->set_lists();
		$this->load->vars($data);
		$this->load->helper('url');
		$this->load->view('lists');
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
		return $data;

	}

	private function set_lists(){
		$issues = $this->issue->get_issues();
		$items = "					<li class=\"item\">\n";
		$items.= "						<img src=\"" . $this->config->base_url("assets/img/sample.jpg") . "\" />\n";
		$items.= "					</li>\n";
		$lists = "";
		for($i=0;$i<count($issues);$i++){
			$lists .= $items;	
		}
		return $lists;
	}
}

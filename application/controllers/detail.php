<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detail extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('issue');
		$issue = $this->issue->get_issue_detail(307);	
		$date = explode('-',$issue->date_start);
		$date = date('m/d',mktime(0,0,0,$date[1],$date[2],$date[0]));
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
		$this->load->view('detail',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

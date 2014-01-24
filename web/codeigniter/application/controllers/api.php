<?php
session_start();
	class API extends CI_Controller{

	  public function __construct(){

	    parent::__construct();
	    $this->load->model('APImodel');
	  }

	  public function index(){
	    header('Content-Type: application/json; charset=utf-8');

	    $now_pass_package = $this->APImodel->now_pass_mvmt();
	    $future_package = $this->APImodel->future_mvmt();
	    
	    $this->APImodel->find_photo_url($now_pass_package);
	    $this->APImodel->find_photo_url($future_package);
	    $this->APImodel->resolve_date($now_pass_package);
	    $this->APImodel->resolve_date($future_package);
	    $this->APImodel->catg_int_to_str($now_pass_package);
	    $this->APImodel->catg_int_to_str($future_package);
	    //$this->APImodel->mem($now_pass_package);
	    //$this->APImodel->mem($future_package);

	    $full_package = array();
	    $full_package['future'] = $future_package;
	    $full_package['now_pass'] = $now_pass_package;

	    echo json_encode($full_package);
	  }

	  public function plain(){
	    header('Content-Type: text/plain; charset=utf-8');
	    $now_pass_package = $this->APImodel->now_pass_mvmt();
	    $future_package = $this->APImodel->future_mvmt();

	    $this->APImodel->find_photo_url($now_pass_package);
	    $this->APImodel->find_photo_url($future_package);

	    $this->APImodel->resolve_date($now_pass_package);
	    $this->APImodel->resolve_date($future_package);

	    $this->APImodel->catg_int_to_str($now_pass_package);
	    $this->APImodel->catg_int_to_str($future_package);
	    
	    //$this->APImodel->mem($now_pass_package);
	    //$this->APImodel->mem($future_package);
		
	    $full_package = array();
	    $full_package['future'] = $future_package;
	    $full_package['now_pass'] = $now_pass_package;

	    print_r($full_package);
	  }

	  public function lists(){
	    header('Content-type: application/json; charset=utf-8;');
	    //echo json_encode($this->APImodel->list_mvmt());
	  }

	  public function test(){
	    header('Content-type: text/plain; charset = utf-8');
	    $a = $this->APImodel->future_mvmt();

	    $this->APImodel->find_photo_url($a);

	    print_r($a);
	  }

	  public function joinmovement(){
	    header('Content-type: application/json; charset = utf-8');

		if(empty($_SESSION['No'])){
			echo json_encode(array('state'=>'unsigned'));
			return ;
		}

	    $userNo = $_SESSION['No'];
	    $movementID = $_POST['movementID'];

		echo json_encode($this->APImodel->checkjoin($userNo,$movementID));
	  }

	}

?>

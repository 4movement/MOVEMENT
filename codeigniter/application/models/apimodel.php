<?php 
	class APImodel extends CI_Model{
	
	  function __construct(){
	
	    parent::__construct();
	    $this->load->database();
	  }

	  function river(){
	    		
	  }

	  function future_mvmt(){

	    $maxResult = 10;
	    $script = 'SELECT * FROM movements 
	      WHERE TO_DAYS(date_start) - TO_DAYS(NOW()) > 0 
	      ORDER BY date_start DESC
	      LIMIT '.$maxResult;
	    $query = $this->db->query($script);
		
		/*foreach ($query->result_array() as $row){
		print_r($row);
	    }*/
	    $result = array();
	    $result = $query->result_array();
		//mem($result);
		/*
		$mem_script = 'SELECT * FROM mem_db WHERE No = $result[No]';
		
	    $query = $this->db->query($mem_script);
		
		$mem_result = array();
		$mem_result = $query->result_array();
		$result['username'] = $mem_result['username'];
		 */
	    foreach($result as &$row){

	      $this->db->select('username');
	      $query = $this->db->get_where('mem_db',array('No'=>$row['No']));
	      $uname = $query->result_array();
		$row['username']=$uname[0]['username'];
	    }
		return $result;
	  }

	  function now_pass_mvmt(){

	    $maxResult = 45;
	    $script = 'SELECT * FROM movements
	      WHERE TO_DAYS(NOW()) - TO_DAYS(date_start) >= 0
	      ORDER BY date_start DESC
	      LIMIT '.$maxResult;
	    $query = $this->db->query($script);
	    /*foreach ($query->result_array() as $row){
	      print_r($row);
	    }*/
	    $result = array();
	    $result = $query->result_array();

	    foreach($result as &$row){

	      $this->db->select('username');
	      $query = $this->db->get_where('mem_db',array('No'=>$row['No']));
	      $uname = $query->result_array();
		$row['username']=$uname[0]['username'];
	    }


	    return $result;
	  }
	  function mem(&$data){
	  	/*
		foreach($data as &$mem_data){
		  	$script = 'SELECT * FROM mem_db WHERE No = ' . $mem_data['No'];
			$query = $this->db->query($script);
			
			$mem_result = array();
			$mem_result = $query->result_array();
			$mem_data['username'] = $mem_result['username'];
	    }*/
		$query = $this->db->get_where('mem_db',array('No'=>$data['No']),1);
		$data['username'] = $query->result()->username;
		
	  }
	  
	  function find_photo_url(& $mvmt_arr){
	
	    $base_path = '/home/smart0eddie/public_html/movement_photo/';
	    $base_url = 'merry.ee.ncku.edu.tw/~smart0eddie/movement_photo/';
	    foreach($mvmt_arr as &$mvmt){ 
	      $photo_path = $base_path.$mvmt['id'].'_b.jpg';
	      if(file_exists($photo_path)){
	     	$mvmt['big_photo'] = $base_url.$mvmt['id'].'_b.jpg';
	      }else{
		$mvmt['big_photo'] = $base_url.'movement_temp.jpg';
	      }
	     

	      $photo_path_s = $base_path.$mvmt['id'].'_s.jpg';
	      if(file_exists($photo_path_s)){
	      	$mvmt['small_photo'] = $base_url.$mvmt['id'].'_s.jpg';
	      }else{
 		$mvmt['small_photo'] = $base_url.'movement_temp.jpg';	      
	      }
   	    }
	  }

	  function resolve_date(&$dat){
	    foreach($dat as &$a){
	      $dateStart = new DateTime($a['date_start']);
	      $a['dateStartYear'] = $dateStart->format('Y');
	      $a['dateStartMonth'] = $dateStart->format('m');
	      $a['dateStartDay'] = $dateStart->format('d');
	    }
	  }

	  function catg_int_to_str(&$mvmts){

	    $catg = array(	'1'=>'Anit-smoking',
	      			'2'=>'Anti-unclear energy',
				'3'=>'Anti-War',
				'4'=>'Consumer',
				'5'=>'Education',
				'6'=>'Labour',
				'7'=>'LGBT',
				'8'=>'Reform',
				'9'=>'Political',
				'10'=>'Others'
	      		);

	    foreach($mvmts as &$a){
	      $a['category'] = $catg[$a['category']];
	    }
 	  
	  }

	  function isjoin($u,$m){
		$this->db->select('id');
		$sqlObj = $this->db->get_where('join_list',array('topicID'=>$m,'userNO'=>$u));

		$obj = $sqlObj->result();

		if(empty($obj)){
			return 0;
		}else{
			return 1;
		}
		
	  }

	  function checkjoin($u,$m){

	    $isjoined = $this->isjoin($u,$m);
	    $response = array();
	    if($isjoined == '1'){
		$response['state'] = "alreadyjoined";
	    } else{
		$response['state'] = "success";
		$script = "UPDATE movements SET joins = joins + 1 where id = '".$m."'";
		$a = $this->db->query($script);
		$this->db->select('joins');
		$joinObj = $this->db->get_where('movements',array('id'=>$m));

		$joinResult = $joinObj->result();

		$response['joins'] = $joinResult[0]->joins;

		$data = array(
		  'topicID'=>$m,
		  'userNO'=>$u
		);
	
		$this->db->insert('join_list',$data);
	    }
		return $response;
 	  }

	  function list_mvmt(){
	  
	  }

	}
?>

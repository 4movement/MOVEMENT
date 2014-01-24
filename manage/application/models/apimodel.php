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
	    return $query->result_array();

	  }

	  function now_pass_mvmt(){

	    $maxResult = 15;
	    $script = 'SELECT * FROM movements
	      WHERE TO_DAYS(NOW()) - TO_DAYS(date_start) >= 0
	      ORDER BY date_start DESC
	      LIMIT '.$maxResult;
	    $query = $this->db->query($script);
	    /*foreach ($query->result_array() as $row){
	      print_r($row);
	    }*/
	    return $query->result_array();
	  }

	  function find_photo_url(& $mvmt_arr){
	
	    $base_path = '/home/wp/smart0eddie/public_html/movement_photo/';
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
	  function list_mvmt(){
	  
	  }

	}
?>

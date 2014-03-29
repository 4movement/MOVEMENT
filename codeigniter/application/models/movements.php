<?php

 class Movements extends CI_Model{
   function __construct(){
     	parent::__construct();
       	$this->load->database(); 
   }
   function show_tables(){
     	$tables = $this->db->list_tables();
   	foreach ($tables as $table){
		echo $table;
     	}
   }
   function show_all_by_datestart(){
     $this->db->order_by("date_start","desc");
	$querys = $this->db->get('movements');
	return $querys->result();
   }
   function update_all($p){
     //print_r($p);
     $this->db->where('id',$p['id']);
     $this->db->update('movements',$p);
   }
   function photo_rename($f,$event_id){
     //print_r($f);
     //header('Content-Type:image/jpeg');
     $path_to_photo = '/home/smart0eddie/public_html/movement_photo/';
     $ratio = $f['image_width']/$f['image_height'];
	if(file_exists($f['full_path'])){
	  //echo $ratio;
		$new_height_s = 200;
		$new_width_s = 200 * $ratio;
		$new_h_b = 400;
		$new_w_b = 400 * $ratio;
		
		$image_s = imagecreatetruecolor($new_width_s,$new_height_s);
		$image_b = imagecreatetruecolor($new_w_b,$new_h_b);
		$image_origin = imagecreatefromjpeg($f['full_path']);
		

		imagecopyresampled($image_s,$image_origin,0,0,0,0,$new_width_s,$new_height_s,$f['image_width'],$f['image_height']);
		imagecopyresampled($image_b,$image_origin,0,0,0,0,$new_w_b,$new_h_b,$f['image_width'],$f['image_height']);
		imagejpeg($image_s,$path_to_photo.$event_id."_s.jpg",75);
		imagejpeg($image_b,$path_to_photo.$event_id."_b.jpg",75);
		echo "ok";
	}
   }

   function del_movement($id){
	$this->db->delete('movements',array('id'=>$id));
   }

   function new_event($P){
     $data = array(
       'id'=>'default()',
       'No'=>$P['ne_No'],
       'name'=>$P['ne_name'],
       'date_start'=> $P['ne_date_start'],
       'date_end'=> $P['ne_date_end'],
       'category'=> $P['ne_category'],
       'city'=>$P['ne_city'],
       'time_start'=>$P['ne_time_start'],
       'time_end'=>$P['ne_time_end'],
       'location'=>$P['ne_location'],
       'host_account'=>'0',
       'url'=>$P['ne_url'],
       'host'=>$P['ne_host'],
       'intro'=>$P['ne_intro'],
       'joins'=>'0',
       'support'=>'0',
       'donate'=>'0'
     );

     $this->db->insert('movements',$data);

    	$this->db->select_max('id');
     $queryA = $this->db->get('movements');

     return $queryA->result();
//     $a = $this->db->get_where('movements',array('name'=>$P['ne_name'],'location'=>$P['ne_location']),1);

//     $b =  $a->result();

//     echo $b['0'];
   }
 }
?>

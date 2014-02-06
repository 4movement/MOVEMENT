<?php

class Event extends CI_Controller{

  public function __construct(){
  	parent::__construct();
	$this->load->model('Movements');
	$this->load->helper(array('form','url'));
  } 
  public function index(){
    $data['moves_query'] = $this->Movements->show_all_by_datestart();
    //$data['last_upload']='';
    $this->load->view('header');
    $this->load->view('content',$data);
  }

  public function update(){
    	$this->load->view('header');
	$this->Movements->update_all($_POST);	
  	redirect('/', 'refresh');
  }

  public function photo_upload(){
	$photo_config['upload_path'] = '/home/smart0eddie/public_html/movement_photo/';
	$photo_config['allowed_types'] = 'jpg';
	$this->load->library('upload',$photo_config);
    $this->upload->initialize($photo_config);

	if(!$this->upload->do_upload())
	{
		echo $this->upload->display_errors();
	}else
	{
	  	$file_info = $this->upload->data();
		$this->Movements->photo_rename($file_info,$_POST['id']);
		redirect('/','refresh');
	}
  }

  public function del(){
    	$this->Movements->del_movement($_POST['id']);
    	redirect('/','refresh');
  }

  public function newevent(){
    $last_entry = $this->Movements->new_event($_POST);
	$fresh_id = $last_entry[0]->id;
    if($fresh_id > 0){
	$photo_config['upload_path'] = '/home/smart0eddie/public_html/movement_photo/';
	$photo_config['allowed_types'] = 'jpg';
	$this->load->library('upload',$photo_config);
    $this->upload->initialize($photo_config);

	if(!$this->upload->do_upload())
	{
		echo $this->upload->display_errors();
	}else
	{
	  	$file_info = $this->upload->data();
		$this->Movements->photo_rename($file_info,$fresh_id);
		redirect('/','refresh');
	}
    }
  }

  public function newPost(){
    $last_entry = $this->Movements->new_event($_POST);
	$fresh_id = $last_entry[0]->id;
    if($fresh_id > 0){
	/*$photo_config['upload_path'] = '/home/smart0eddie/public_html/movement_photo/';
	$photo_config['allowed_types'] = 'jpg';
	$this->load->library('upload',$photo_config);
    $this->upload->initialize($photo_config);

	if(!$this->upload->do_upload())
	{
		echo $this->upload->display_errors();
	}else
	{
	  	$file_info = $this->upload->data();
		$this->Movements->photo_rename($file_info,$fresh_id);
		echo "success";
	}*/
	
	   $imgfile = "/home/smart0eddie/public_html/cur/".$_POST['userfile'];
       list($width, $height) = getimagesize($imgfile);
       $file_info = array(
            'full_path' =>  $imgfile,
            'image_height'=> $height,
            'image_width' => $width
       );
       $this->Movements->photo_rename($file_info,$fresh_id);
       echo "success";
    
    }
  }

}

?>

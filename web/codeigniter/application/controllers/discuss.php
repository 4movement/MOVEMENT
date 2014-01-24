<?php 
session_start();
class Discuss extends CI_Controller{
  
  public function __construct(){
   parent::__construct();
   $this->load->model('Comments');
   $this->load->helper('url');
  }

  public function index(){
    if(!empty($_SESSION['id'])){
    print_r($_SESSION['id']);
    }else{
    echo "no session";
    }
  }

  public function sendDiscussComment(){
    //$this->load->view('header');
    header('Content-Type: application/json; charset=utf-8');
    if(empty($_SESSION['No'])){
      echo json_encode(array("state"=>"unsigned"));
    }else{
      echo json_encode($this->Comments->setDiscussComment($_POST,$_SESSION));
	  }
  }

  public function getTopicById(){

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($this->Comments->pop_spec(1));

  }

  public function popDisCommentByName(){
    
    $topicName = $_POST['name'];
    //$topicName = "低碳VS.非核家園核四議題攻防";
    //$utf8TopicName = utf8_encode($topicName);
    header('Content-Type: application/json; charset=utf-8');

    echo $this->Comments->popCommentByName($topicName);

  }

  public function getDisTopic(){
    $tag = "";
    header('Content-Type: application/json; charset=utf-8');

    echo $this->Comments->getTopic($tag);
  }

  public function sendMovementComment(){
    $movementID = $_POST['movementID'];
    $comment = $_POST['comment'];
    $userID;
		
    $response = array();

    header('Content-Type: application/json; charset=utf-8');

    if(empty($_SESSION['No'])){
      $response['state'] = 'unsigned';
    }else{
      	$response['state'] = 'signedin';
	$userID = $_SESSION['No'];

	$response['f_cid'] = $this->Comments->insertMovementComment($movementID,$comment,$userID);
//	$response['f_comment'] = $comment;
	$response['f_username'] = $this->Comments->findUsername($userID);	
    }

    echo json_encode($response);
  }

  public function getMovementComment(){
    header('Content-Type: application/json; charset=utf-8');

    $movementID = $_POST['movementID'];
    $comments = $this->Comments->getMCmt($movementID);

    echo json_encode($comments);
  }

  public function newTopic(){

    header('Content-Type: application/json; charset=utf-8');

    $response = array();

    if(empty($_POST['new_topic']) or empty($_POST['first_comment']))
    {
      $response['state'] = "valuenotfound";
      echo json_encode($response);
      return;
    }

    $topic = $_POST['new_topic'];
    $comment = $_POST['first_comment'];

    if(empty($_SESSION['No'])){
      	$response['state'] = 'unsigned';
	echo json_encode($response);
	return;
    }else{
      
	$response['state'] = 'signedin';
	$response['articleID'] = $this->Comments->setTopic($topic,$_SESSION['No'],$comment);
	$response['commentID'] = $this->Comments->getDisFirstCmtID($topic,$_SESSION['No'],$comment);
	$response['state'] = 'success';
         echo json_encode($response);
    	return;
 
    }

  }
// Discuss Like
  public function dlike(){
    header('Content-Type: application/json; charset=utf-8');
	$disORmov = $_POST['dm'];//1:from discuss;0:from movement comment
    if($disORmov == 1){
      $cid = $_POST['commentID'];
    }else{
      $cid = $_POST['reply_id'];
    }
    if(empty($_SESSION['No'])){
      echo json_encode(array('state'=>"unsigned"));
    }else{
	$uid = $_SESSION['No'];
    	echo json_encode($this->Comments->dChecklike($cid,$uid,$disORmov));
    }
  }
// Discuss dislike
 public function ddislike(){
    header('Content-Type: application/json; charset=utf-8');
    $disORmov = $_POST['dm'];//1:from discuss;0:from movement comment
    if($disORmov == 1){
      $cid = $_POST['commentID'];
    }else{
      $cid = $_POST['reply_id'];
    }
    if(empty($_SESSION['No'])){
      echo json_encode(array('state'=>"unsigned"));
    }else{
	$uid = $_SESSION['No'];
    	echo json_encode($this->Comments->dCheckdislike($cid,$uid,$disORmov));
    }
 }
// Movement comment like
// Movement comment dislike
}
?>

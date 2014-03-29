<?php

class Comments extends CI_Model{
  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  function setDiscussComment($P,$S){

/*    	$this->db->select('username');
	$result = $this->db->get_where('mem_db',array('No'=>$S['No']));
$temp = $result->result();*/
	$username = $this->findUsername($S['No']);
	
/*	$this->db->select('discuss_topic_id');
	$findIDObj = $this->db->get_where('discuss_topic',array('discuss_topic_name'=>$P['title']));
	$temp2 = $findIDObj->result();
	$disID = $temp2[0]->discuss_topic_id;
 */		
	$data=array(
		'id'=>'default()',
		'topicID'=>$P['topicID'],
		'topicName'=>$P['title'],
		'userID'=>$S['No'],
		'userName'=>$username,
		'comment'=>$P['comment'],
		'like'=>'0',
		'dislike'=>'0'
	      );
	$this->db->insert('discuss',$data);


	$this->db->select('id');
	$IDObj = $this->db->get_where('discuss',array('comment'=>$P['comment'],'topicName'=>$P['title'],'userName'=>$username));
	$IDResult = $IDObj->result();
	$reply_id = $IDResult[0]->id;

	$output = array('state'=>'success','username'=>$username,'date'=>date('Y-m-d'),'reply_id'=>$reply_id);	

	return $output;
  }

  function pop_spec($TopicID){
    $objectCST = $this->db->get_where('discuss',array('topicID'=>$TopicID));
    return $comment_specific_topic = $objectCST->result();
  }

  function popCommentByName($name){
    	$this->db->select('id,userName,comment,like,dislike');
	$this->db->order_by('like desc,id desc');
	$CommentObj = $this->db->get_where('discuss',array('topicName'=>$name));

	$Comment = array();

	foreach($CommentObj->result_array() as $row){
		$Comment[] = $row;
	}
	//echo $name;
	//print_r($Comment);
	return json_encode($Comment);
  }

  function getTopic($tag){
    $this->db->select('discuss_topic_id,discuss_topic_name');
    $this->db->order_by('discuss_topic_id','desc');
	$TopicObj = $this->db->get_where('discuss_topic',array('tag'=>$tag));

	$topic = array();

	foreach($TopicObj->result_array() as $row){
//	  	if((time()-$row['upTime']) < 604800){
//			$row['isnew'] = 1;
//		}else{
//			$row['isnew'] = 0;
//		}
		$topic[] = $row;
	}

	return json_encode($topic);
  }

  function insertMovementComment($m,$c,$uID){
       	
	$data = array(
	  'topicID'=>$m,
	  'user'=>$uID,
	  'comment'=>$c,
	  'like'=>'0',
	  'dislike'=>'0'
	);

    $this->db->insert('movement_comment',$data);

    $SqlObj = $this->db->get_where('movement_comment',array('topicID'=>$m,'user'=>$uID,'comment'=>$c),1);

    $cID = $SqlObj->result_array();
    
    return $cID[0]['id'];
  }

  function getUserName($ID){
	$SQLObj = $this->db->get_where('mem_db',array('id'=>$ID),1);

	$user = $SQLObj->result()->username;

	return $user;

  }

  function setTopic($topic,$who,$comment){

    // add a new topic to discuss_topic
    $tag = '';
    $data = array(
      'category' => '2',
      'discuss_topic_name' => $topic,
      'userID'=>$who,
      'tag'=>''
    );

    $this->db->insert('discuss_topic',$data);

    // add the first comment to 

    $p = array();
    $p['title'] = $topic;
    $p['comment'] = $comment;

    $s = array();
    $s['No'] = $who;

    //
//	$this->db->select('username');
//	$result = $this->db->get_where('mem_db',array('id'=>$who));
//	$temp = $result->result();
	$username = $this->findUsername($who);//$temp[0]->username;
	
	$this->db->select('discuss_topic_id');
	$findIDObj = $this->db->get_where('discuss_topic',array('discuss_topic_name'=>$topic));
	$temp2 = $findIDObj->result();
	$disID = $temp2[0]->discuss_topic_id;
		
	$data=array(
		'id'=>'default()',
		'topicID'=>$disID,
		'topicName'=>$topic,
		'userID'=>$who,
		'userName'=>$username,
		'comment'=>$comment,
		'like'=>'0',
		'dislike'=>'0'
	      );
	$this->db->insert('discuss',$data);


	// get the lastest topic id

	$this->db->select('discuss_topic_id');
	$findid = $this->db->get_where('discuss_topic',array('discuss_topic_name'=>$topic));
	$temp3 = $findid->result();
	$topicIdLastest = $temp3[0]->discuss_topic_id;

 	return $topicIdLastest;	

  }

  function getDisFirstCmtID($topic,$who,$comment){
    $this->db->select('id');
    $findCommentID = $this->db->get_where('discuss',array('topicName'=>$topic,'userID'=>$who,'comment'=>$comment));
    $temp4 = $findCommentID->result();
    $CommentID = $temp4[0]->id;

    return $CommentID;
  }

  function findUsername($uid){
    $this->db->select('username');
    $sqlObj = $this->db->get_where('mem_db',array('No'=>$uid));
    $sqlResult = $sqlObj->result();
    $username = $sqlResult[0]->username;
    
    return $username;
  }


  function findNickname($uid){
    $this->db->select('nickname');
    $sqlObj = $this->db->get_where('mem_db',array('id'=>$uid));
    $sqlResult = $sqlObj->result();
    $nickname = $sqlResult[0]->nickname;
    
    return $nickname;
  }

  function getMCmt($id){
    $this->db->select('id,user,comment,like,dislike');
//    $this->db->order_by('like asc,id desc');
    $comments = $this->db->get_where('movement_comment',array('topicID'=>$id));

    $commentsResult = /*$comments->result_array();//*/array();

    foreach($comments->result_array() as $row){
      $row['username'] = $this->findUsername($row['user']);
      //$row['nickname'] = $this->findNickname($row['user']);
      $commentsResult[] = $row;
    }

    return $commentsResult;
  }
// Like OR DisLike
  function notLikeYet($cid,$uid,$disORmov){

    	  $response = array();
	  $data = array(
	  'liked'=>'1',
	  'disliked'=>'0',
	  'DorM'=>$disORmov,
	  'commentid'=>$cid,
	  'username'=>$uid
	);

	  $this->db->insert('likedb',$data);

	  $this->db->select('like');
	  if($disORmov == 1){
	    $isLikeObj = $this->db->get_where('discuss',array('id'=>$cid));
	  }else{
	    $isLikeObj = $this->db->get_where('movement_comment',array('id'=>$cid));
	  }
	  $isLikeResult = $isLikeObj->result();
	  $isLike = $isLikeResult[0]->like;
	  $isLike += 1;

	  $update = array(
		'like'=>$isLike,
	      );

	  $this->db->where('id',$cid);
	  if($disORmov == 1){
	  $this->db->update('discuss',$update);
	  }else{
	  $this->db->update('movement_comment',$update);
	  }
	  $response['state'] = "success";
    	  $response['likeUpdated'] = $isLike;

	  return $response;


  }

  function alreadydislike($likeid,$cid,$uid,$disORmov){
    //change dislike to like in likedb
	$response = array();
	$data = array(
	  'liked'=>'1',
	  'disliked'=>'0',
	  'DorM'=>$disORmov
	);

	$this->db->where('id',$likeid);
	$this->db->update('likedb',$data);

	//change dislike# and like# in 
//	$sqlScript = 'UPDATE discuss SET dislike = dislike - 1,like = like +1
//	 where id = "'.$cid.'"';
//	$this->db->query($sqlScript);

	$this->db->select('like,dislike');
	if($disORmov == 1){
	  $isDisLikeObj = $this->db->get_where('discuss',array('id'=>$cid));
	}else{
	  $isDisLikeObj = $this->db->get_where('movement_comment',array('id'=>$cid));
	}
	  $isDisLikeResult = $isDisLikeObj->result();
	  $isDisLike = $isDisLikeResult[0]->dislike;
	  $isLike = $isDisLikeResult[0]->like;

	  $isDisLike = $isDisLike-1;
	  $isLike = $isLike+1;

	  $likeUpdate = array(
		'like'=>$isLike,
	  	'dislike'=>$isDisLike
	      );

	  $this->db->where('id',$cid);
	  if($disORmov == 1){
	  $this->db->update('discuss',$likeUpdate);
	  }else{
	  $this->db->update('movement_comment',$likeUpdate);
	  }
	  $response['state'] = "disliketolike";
	  $response['likeUpdated'] = $isLike;
	  $response['dislikeUpdated'] = $isDisLike;

	  return $response;
  }

  function dChecklike($cid,$uid,$disORmov){
    	
	//$response['state']
	$this->db->select('id,liked');
	$sqlObj = $this->db->get_where('likedb',array('commentID'=>$cid,'username'=>$uid,'DorM'=>$disORmov));
	$sqlResult = $sqlObj->result();
	if(empty($sqlResult)){
		return ($this->notLikeYet($cid,$uid,$disORmov));
	}else{

	  $Like = $sqlResult[0]->liked;
	  if($Like == 1){
		 $response['state'] = "alreadyliked";
		 return $response;

	  }else{
	    $likeid = $sqlResult[0]->id;
		return ($this->alreadydislike($likeid,$cid,$uid,$disORmov));
	  }
	
	}
  }


function notDisLikeYet($cid,$uid,$disORmov){

    	  $response = array();
	  $data = array(
	  'liked'=>'0',
	  'disliked'=>'1',
	  'DorM'=>$disORmov,
	  'commentid'=>$cid,
	  'username'=>$uid
	);

	  $this->db->insert('likedb',$data);

	  $this->db->select('dislike');
	  if($disORmov == 1){
	    $isDisLikeObj = $this->db->get_where('discuss',array('id'=>$cid));
	  }else{
	    $isDisLikeObj = $this->db->get_where('movement_comment',array('id'=>$cid));   
	  }
	  $isDisLikeResult = $isDisLikeObj->result();
	  $isDisLike = $isDisLikeResult[0]->dislike;
	  $isDisLike += 1;

	  $update = array(
		'dislike'=>$isDisLike,
	      );

	  $this->db->where('id',$cid);
	  if($disORmov == 1){
	  $this->db->update('discuss',$update);
	  }else{
	  $this->db->update('movement_comment',$update);
	  }
	  $response['state'] = "success";
    	  $response['dislikeUpdated'] = $isDisLike;

	  return $response;
}

function alreadylike($dislikeid,$cid,$uid,$disORmov){
    //change dislike to like in likedb
	$response = array();
	$data = array(
	  'liked'=>'0',
	  'disliked'=>'1',
	  'DorM'=>$disORmov
	);

	$this->db->where('id',$dislikeid);
	$this->db->update('likedb',$data);

	//change like# and dislike# in 
//	$sqlScript = 'UPDATE discuss SET dislike = dislike + 1,like = like - 1
//	 where id = "'.$cid.'"';
//	$this->db->query($sqlScript);

	$this->db->select('like,dislike');
	if($disORmov == 1){
	  $isDisLikeObj = $this->db->get_where('discuss',array('id'=>$cid));
	}else{
	  $isDisLikeObj = $this->db->get_where('movement_comment',array('id'=>$cid));
	}
	  $isDisLikeResult = $isDisLikeObj->result();
	  $isDisLike = $isDisLikeResult[0]->dislike;
	  $isLike = $isDisLikeResult[0]->like;

	  $isDisLike = $isDisLike+1;
	  $isLike = $isLike-1;

	  $likeUpdate = array(
		'like'=>$isLike,
	  	'dislike'=>$isDisLike
	      );

	  $this->db->where('id',$cid);
	  if($disORmov == 1){
	  $this->db->update('discuss',$likeUpdate);
	  }else{
	  $this->db->update('movement_comment',$likeUpdate);
	  }
	  $response['state'] = "liketodislike";
	  $response['dislikeUpdated'] = $isDisLike;
	  $response['likeUpdated'] = $isLike;

	  return $response;
  }


  function dCheckdislike($cid,$uid,$disORmov){
    	
	//$response['state']
	$this->db->select('id,disliked');
	$sqlObj = $this->db->get_where('likedb',array('commentID'=>$cid,'username'=>$uid,'DorM'=>$disORmov));
	$sqlResult = $sqlObj->result();
	if(empty($sqlResult)){
		return ($this->notDisLikeYet($cid,$uid,$disORmov));
	}else{

	  $DisLike = $sqlResult[0]->disliked;
	  if($DisLike == 1){
		 $response['state'] = "alreadydisliked";
		 return $response;

	  }else{
	    $dislikeid = $sqlResult[0]->id;
		return ($this->alreadylike($dislikeid,$cid,$uid,$disORmov));
	  }
	
	}
 }


 }
?>

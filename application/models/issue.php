<?php
class Issue extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function get_issues(){
		$query = $this->db->get('movements');
		return $query->result();
	}

	function get_issue_detail($id){
		$query = $this->db->query('SELECT * FROM movements WHERE id='.$id);
		return $query->row();
	}
}
?>

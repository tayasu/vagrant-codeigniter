<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
	
	public function getPosts($page){
		$session_data = $this->session->userdata('logged_in');
		$userid = $session_data['userid'];
		$this->db->select('username,posts,time_of_post');
		$this->db->from('posts');
		$this->db->where('userid',$userid);
		$this->db->order_by('time_of_post','DESC');
		$this->db->limit(LENGTH,LENGTH*($page - 1));	
		
		$query = $this->db->get();
		
		if ($query->num_rows()>0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function post($userid,$username,$posts,$time_of_post){
		$this->db->set('userid',$userid);
		$this->db->set('username',$username);
		$this->db->set('posts',$posts);
		$this->db->set('time_of_post',$time_of_post);
		
		$this->db->insert('posts');
		
		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

}
?>
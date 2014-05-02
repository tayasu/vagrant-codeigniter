<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
	
	public function getPosts($page){
		$this->db->select('username,posts,time_of_post');
		$this->db->from('posts');
		$this->db->order_by('time_of_post','DESC');
		$this->db->limit(LENGTH,LENGTH*($page - 1));	
		
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			if($query->num_rows<LENGTH){
				$data = $query->result_array();
				$data['message'] = "MAX_VIEW_REACHED";
			}
			else{
				$data = $query->result_array();    //when MAX_VIEW_NOT_REACHED message is not set
			}
			return $data;
		}
		else{
			return false;
		}
	}

	public function post($username,$posts,$date){
		$this->db->set('username',$username);
		$this->db->set('posts',$posts);
		$this->db->set('time_of_post',$date);
		
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
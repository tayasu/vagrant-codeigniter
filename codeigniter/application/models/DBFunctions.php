<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DBFunctions extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
		
	public function authenticate($email,$password){
		$this -> db -> select('userID, username,email, password');
		$this -> db -> from('users');
		$this -> db -> where('email', $email);
		$this -> db -> where('password', $password);
		$this -> db -> limit(1);

		$query = $this -> db -> get();
		
		if($query -> num_rows() == 1){
			return $query->result();
		}
		else{
			return false;
		}
	}
	
	public function register($username,$email,$password){
		$this->db->set('username',$username);
		$this->db->set('email',$email);
		$this->db->set('password',$password);
		
		$this->db->insert('users');

		if($this->db->affected_rows() == 1){
			return $this->db->affected_rows();
		}else{
			return false;
		}	
	}
	
	public function posts($page){
		$length = 3;
		$num_of_rows = $this->db->get('posts')->num_rows();
	
		if($length * $page <= $num_of_rows){
			$this->db->select('username,posts,time_of_post');
			$this->db->from('posts');
			$this->db->order_by('time_of_post');
			$this->db->limit($length,$length*($page - 1));	
		
			$query = $this->db->get();
		
			if($query->num_rows()>0){
				return $query->result_array();
			}
			else{
				return false;
			}
		}
		else{
			$data = $this->db->get('posts')->result_array();
			$data['message'] = "VIEW_MAX_POST_REACHED";
			return $data;
		}
	}
}
?>
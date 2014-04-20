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
}
?>
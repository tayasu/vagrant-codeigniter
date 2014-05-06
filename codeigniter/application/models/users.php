<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
		
	public function authenticate($email,$password){
		$this -> db -> select('userid, username,email, password');
		$this -> db -> from('users');
		$this -> db -> where('email', $email);
		$this -> db -> where('password', $password);

		$query = $this -> db -> get();
		
		if($query -> num_rows() == 1){
			return $query->row_array();
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
			return true;
		}else{
			return false;
		}	
	}
}
?>
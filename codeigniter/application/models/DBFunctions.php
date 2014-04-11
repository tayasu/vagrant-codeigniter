<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DBFunctions extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
		
	public function authenticate($username,$password){
		$this -> db -> select('userID, username, password');
		$this -> db -> from('authenticate');
		$this -> db -> where('username', $username);
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
	
}
?>
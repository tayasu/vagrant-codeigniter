<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class User_model extends CI_MODEL {
		
		public function __construct() {
			parent::__construct();
			$this->load->database();		
		}

		public function getUser($mail, $password) {
			$sql = "select * from users where mail = '$mail' and password = '$password'";
			$result = $this->db->query($sql)->result_array();
			return $result[0];
		}

		public function getUserName($id) {
			$sql = "select * from users where userID = '$id'";
			$result = $this->db->query($sql);
			return $result[0]['name'];
		}

		public function setStatus($mail, $status) {
				$sql = "update users set status = '$status' where mail = '$mail'";
				$this->db->query($sql);
		}

		public function insertUser($name, $mail, $password) {
			$sql = "select mail from users where mail = '$mail'";
			$result = $this->db->query($sql)->result_array();
			if($result != NULL) {
				return FALSE;
			} else {
				$sql = "insert into users values (NULL, '$name','$mail','$password','ON')";
				$this->db->query($sql);
				return TRUE;
			}
		}
	}
?>

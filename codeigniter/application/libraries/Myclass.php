<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

public class Myclass{

	public function is_loggedIn(){
		session_start();
		
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$this->load->view('roomView', $data);
		}
		else{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
}

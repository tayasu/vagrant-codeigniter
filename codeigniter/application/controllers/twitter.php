<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Twitter extends CI_CONTROLLER {

		public function __construct() {
			//コントローラーをコンストラクタする
			parent::__construct();


			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->library('security');
			$this->load->library('javascript');
			$this->load->library('javascript/jquery', FALSE);

			//ヘルプをロードする
			$this->load->helper(array('form','url', 'email', 'date', 'html'));
		}

		public function login() {
			//ログインフォーム検証ルールを設定する
			$this->form_validation->set_rules('mail', 'メールアドレス', 'trim|required');
			$this->form_validation->set_rules('password', 'パスワード', 'trim|required|min_length[6]');

			// フォームバリデーションをチェックする
			if($this->form_validation->run() == FALSE) {
				$this->load->view('login');
			} else {
				$this->load->library('input');
				$mail = $this->input->post("mail");
				$password = $this->input->post("password");
				// $password = $this->encrypt->encode($password);

				//メールバリデーションをチェックする
				if(valid_email($mail)) {
					$this->load->model("user_model");

					// メールとパスワードを確認する
					$result = $this->user_model->getUser($mail, $password);
					

					if($result != NULL) {
						// ユーザー定義のセッションデータを追加する
						$sessiondata = array(
								'username' => $result['name'],
								'mail' => $mail,
								'id' => $result['userID']
							);

						$this->session->set_userdata($sessiondata);
						$this->user_model->setStatus($mail, 'ON');
						
						// ホームページに行く
						redirect('twitter/homepage');

					} else {
						// メールとかパスワードが違うエラーのメッセージ
						$this->session->set_flashdata('error_msg', '<div class="text-danger">メールとかパスワードが間違います！</div>');

						redirect('twitter/login');
					}
				} else {
					// メールのフォーマットが違うエラーのメッセージ
					$this->session->set_flashdata('error_msg', '<div class="text-danger">メールのフォーマットが間違います！</div>');

					redirect('twitter/login');
				}	
			}		
		}


		public function register() {
			
			//登録検証ルールを設定する
			$this->form_validation->set_rules('name', '名前', 'trim|required');
			$this->form_validation->set_rules('mail', 'メールアドレス', 'trim|required');
			$this->form_validation->set_rules('password', 'パスワード', 'trim|required|min_length[6]');

			// フォームバリデーションをチェックする
			if($this->form_validation->run() == FALSE) {
				$this->load->view('register');
			} else {
				$this->load->library('input');
				$name = $this->input->post("name");
				$mail = $this->input->post("mail");
				$password = $this->input->post("password");
				$password = $this->encrypt->encode($password);

				//メールバリデーションをチェックする
				if(valid_email($mail)) {
					$this->load->model("user_model");
					
					$result = $this->user_model->insertUser($name, $mail, $password);

					if($result) {
						// ユーザー定義のセッションデータを追加する
						$sessiondata = array(
							'username' => $name,
							'mail' => $mail,
							'id' => $result['userID']
						);

						// ホームページに行く
						$this->session->set_userdata($sessiondata);
						$this->user_model->setStatus($mail, 'ON');
						
						redirect('twitter/homepage');
					} else {
						// メールとかパスワードが違うエラーのメッセージ
						$this->session->set_flashdata('error_msg', '<div class="text-danger">メールは存在しました！</div>');

						redirect('twitter/register');
					}

				} else {
					// メールのフォーマットが違うエラーのメッセージ
					$this->session->set_flashdata('error_msg', '<div class="text-danger">メールのフォーマットが間違います！</div>');

					redirect('twitter/register');
				}							
			}
		}

		// 新しい１０件ツイートを表示する
		public function tweet($limit) {
			$this->load->model('tweet_model');

			$data['tweets'] = $this->tweet_model->getTweet($limit);
			$this->load->view('tweet', $data);
		}

		// 新しいツイートを投稿する
		public function post_tweet($tweet) {
			$this->load->model('tweet_model');

			// ツイートを投稿人の情報を取る
			$name = $this->session->userdata('username');
			$userID = $this->session->userdata('id');

			// ツイートをデータベースに入れる
			$tweet = str_replace("_", "&nbsp", $tweet);
			$tweet = $this->security->xss_clean($tweet);
			$tweet = str_replace(";", "", $tweet);

			$this->tweet_model->insertTweet($userID, $name, $tweet);

			// 新しいツイートを表示
			$data['tweets'] = $this->tweet_model->getTweet(10);
			$this->load->view('tweet', $data);
		}


		// ホームページを表示する
		public function homepage() {			

			$this->load->model("tweet_model");
			$this->load->model("user_model");

			$data['library_src'] = $this->jquery->script();
			
			// セッションが設定かどかをチェック
			// $name = $this->session->userdata('username');
			$username = $this->session->userdata('username');


			if($username == NULL) {
				// まだ設定しない
				redirect('twitter/login');
			} else {

				$data['name'] = $this->session->userdata('username');
				$userID = $this->session->userdata('id');
				$data['userID'] = $userID;
				$data['tweets'] = $this->tweet_model->getTweet(10);

				$this->form_validation->set_rules('tweet', 'ツイート', 'trim|required|max_lenght[140]');

				if($this->form_validation->run() == FALSE) {
					$this->load->view('mainpage',$data);
				}
			}
					
		}

		// セッションを破棄する、ログアウトして、ログインを戻る
		public function logout() {
			$this->load->model("user_model");

			$mail = $this->session->userdata('mail');
			$this->user_model->setStatus($mail, 'OFF');

			// セッションを破棄する
			$this->session->sess_destroy();
			redirect('twitter/login');
		}

		public function test() {
			$prefs = array (
               'show_next_prev' => TRUE,
               'next_prev_url' => 'http://vagrant-codeigniter.local/index.php/twitter/test'
             );

			$this->load->library('calendar', $prefs);

			echo $this->calendar->generate($this->uri->segment(3), $this->uri->segment(4));

			$this->load->library('table');

			$this->table->set_heading('Name', 'Color', 'Size');

			$this->table->add_row('Fred', 'Blue', 'Small');
			$this->table->add_row('Mary', 'Red', 'Large');
			$this->table->add_row('John', 'Green', 'Medium');

			echo $this->table->generate();
		}

	}

?>
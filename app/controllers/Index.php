<?php
	/**
	 * Class Index
	 */
	class Index extends Controller {
		/**
		 * Index constructor.
		 */
		public function __construct() {
		    // Import SQL commands

			//$this->userModel = $this->model('User');
		}
		
		/**
		 * views/index.php
		 */
		public function index() {
			$data = [
                'headTitle' => 'Welcome !',
				'title' => 'Hi you ! 😏'
			];

			$this->render('index', $data);
		}
	}

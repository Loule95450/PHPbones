<?php
	/* Setting the error reporting to display all errors. */
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	/**
	 * App Core Class
	 * Creates URL & loads core controller
	 * URL FORMAT - /controller/method/params
	 */

	/* It takes the URL, sanitizes it, and returns an array of the URL */
	class Core {
		/* These are the default values for the controller, method, and parameters. */
		protected $currentController = 'Index';
		protected $currentMethod = 'index';
		protected $params = [];
		
		/**
		 * If the first part of the URL is a valid controller, then load it, otherwise load the default controller. If the second
		 * part of the URL is a valid method, then load it, otherwise load the default method. If there are any other parts of
		 * the URL, then load them as parameters
		 */
		public function __construct(){
			/* Calling the getUrl() method and assigning the returned value to the $url variable. */
			$url = $this->getUrl();
			
			/* It checks if the first part of the URL is a valid controller, then load it, otherwise load the default controller. */
			if(isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]). '.class.php')){
				$this->currentController = ucwords($url[0]);
				unset($url[0]);
			} else if(isset($url[0])) {
                $data = ['headTitle' => 'Not found', 'cssFile' => 'errors', "errorCode" => 404 ];
                die(require_once("../app/views/errors.php"));
            }
			
			/* Loading the controller file. */
			require_once '../app/controllers/'. $this->currentController . '.class.php';
			
			/* Creating a new instance of the controller. */
			$this->currentController = new $this->currentController;
			
			/* It checks if the second part of the URL is a valid method, then load it, otherwise load the default method. */
			if(isset($url[1])){
				if(method_exists($this->currentController, $url[1])){
					$this->currentMethod = $url[1];
					unset($url[1]);
				}
			}
			
			/* If there are any other parts of the URL, then load them as parameters. */
			$this->params = $url ? array_values($url) : [];
			
			/* Calling the method of the controller with the parameters. */
			call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
		}
		
		/**
		 * It takes the URL, sanitizes it, and returns an array of the URL
		 *
		 * @return The url is being returned.
		 */
		public function getUrl(){
			if(isset($_GET['url'])){
				$url = rtrim($_GET['url'], '/');
				$url = filter_var($url, FILTER_SANITIZE_URL);
				$url = explode('/', $url);
				return $url;
			}
			
			return false;
		}
	}
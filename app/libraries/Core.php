<?php
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	/**
	 * App Core Class
	 * Creates URL & loads core controller
	 * URL FORMAT - /controller/method/params
	 */
	class Core {
		protected $currentController = 'Index';
		protected $currentMethod = 'index';
		protected $params = [];
		
		public function __construct(){
			$url = $this->getUrl();
			
			// Rechercher dans le BLL(Business Logic Layer) pour la première valeur
			if(isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]). '.class.php')){
				// S’il existe, défini comme controller
				$this->currentController = ucwords($url[0]);
				// Unset l'index 0
				unset($url[0]);
			} else if(isset($url[0])) {
                $data = ['headTitle' => 'Not found', 'cssFile' => 'errors', "errorCode" => 404 ];
                die(require_once("../app/views/errors.php"));
            }
			
			// Exige le contrôleur
			require_once '../app/controllers/'. $this->currentController . '.class.php';
			
			// Instancie le controller
			$this->currentController = new $this->currentController;
			
			// Vérifie la deuxième partie de l’url
			if(isset($url[1])){
				// Vérifier si la méthode existe dans le controller
				if(method_exists($this->currentController, $url[1])){
					$this->currentMethod = $url[1];
					// Unset l'index 1
					unset($url[1]);
				}
			}
			
			// Obtenir les paramètres
			$this->params = $url ? array_values($url) : [];
			
			// Appel un callback avec un tableau de paramètres
			call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
		}
		
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
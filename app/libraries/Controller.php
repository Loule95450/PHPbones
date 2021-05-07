<?php
	/**
	 * Class Controller
	 * Classe principal pour tous les contrôleurs, ici sont référencer toutes les méthodes(fonctions) communes dee nos contrôleurs
	 */
	class Controller
	{
		/**
		 * Chargement dynamiques de nos modèles(Model)
		 * @param $model
		 * @return mixed
		 */
		public function loadModel($model)
		{
			require_once '../app/models/' . $model . '.php';
			return new $model();
		}
		
		/**
		 * Chargement dynamique de nos vues
		 * @param $view
		 * @param array $data
		 */
		public function render($view, $data = [])
		{
			if (file_exists('../app/views/' . $view . '.php'))
			{
				require_once '../app/views/' . $view . '.php';
			} else {
				die("Cette vue n'existe pas !!");
			}
		}
	}
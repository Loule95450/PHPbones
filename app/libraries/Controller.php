<?php
	/**
	 * Class Controller
	 * It loads the model file and returns a new instance of the model, and it checks if the view file exists, and if it does, it requires it. If it doesn't, it renders the error page
	 */
	class Controller
	{
		/**
		 * It loads the model file and returns a new instance of the model
		 *
		 * @param model The name of the model
		 *
		 * @return A new instance of the model.
		 */
		public function loadModel($model)
		{
			require_once '../app/models/' . $model . '.php';
			return new $model();
		}

		/**
		 * It checks if the view file exists, and if it does, it requires it. If it doesn't, it renders the error page
		 *
		 * @param view The name of the view file to be rendered.
		 * @param data This is an array of data that you want to pass to the view.
		 */
		public function render($view, $data = [])
		{
			if (file_exists('../app/views/' . $view . '.php'))
			{
				require_once '../app/views/' . $view . '.php';
			} else {
				$this->renderError(424);
			}
		}

        /**
         * It renders the error page with the error code and title
         *
         * @param codeError The error code that will be displayed on the page.
         * @param titleError The title of the error page
         */
        public function renderError($codeError = 520, $titleError = "Something has gone wrong")
        {
            $data = [
                'headTitle' => $titleError,
                'cssFile' => 'errors',
                "errorCode" => $codeError
            ];
            die($this->render('errors', $data));
        }
	}
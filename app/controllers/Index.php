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

			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

				file_put_contents("../app/config/config.php", "<?php
    // Database Settings
    define('DB_HOST', '".trim($_POST['DB_HOST'])."');
    define('DB_USER', '".trim($_POST['DB_USER'])."');
    define('DB_PASS', '".trim($_POST['DB_PASS'])."');
    define('DB_NAME', '".trim($_POST['DB_NAME'])."');
    
    //define('DB_HOST', 'localhost');
    //define('DB_USER', 'root');
    //define('DB_PASS', '');
    //define('DB_NAME', 'MyDataBase');
    
    // APP ROOT
    define('APP_ROOT', dirname(dirname(__FILE__)));
    
    // URL ROOT
    define('URL_ROOT', 'http://'.$"."_SERVER['HTTP_HOST'].str_replace('public/index.php', '', $"."_SERVER['SCRIPT_NAME']));
    //define('URL_ROOT', 'https://".trim($_POST['SITE_NAME']).".com');
    
    // Nom du site
    define('SITE_NAME', '".trim($_POST['SITE_NAME'])."');");

                file_put_contents("../app/views/index.php", "<?php
	require APP_ROOT . '/views/inc/head.php';
?>
<body>
    <?php
        require APP_ROOT . '/views/inc/nav.php';
    ?>

    <header>
        <h1>Welcome to <?= SITE_NAME ?> !</h1>
        <h1>Go to 'app/views/index.php' to edit your site</h1>
    </header>

    <main>
        <!-- Generate you files on https://mvc-generator.herokuapp.com/ -->
    </main>
    <?php
        require APP_ROOT . '/views/inc/footer.php';
    ?>
</body>");

                file_put_contents("css/style.css", "html, body {
	margin: 0;
	font-family: 'Lato', sans-serif;
	color: #OOO;
}");

                file_put_contents("../app/controllers/Index.php", "<?php
	/**
	 * Class Index
	 */
	class Index extends Controller {
		/**
		 * Index constructor.
		 */
		public function __construct() {
		    // Import SQL commands

			//$"."this->userModel = $"."this->model('User');
		}
		
		/**
		 * views/index.php
		 */
		public function index() {
			$"."data = [
                'headTitle' => 'Welcome !',
				'title' => 'Hi you ! 😏'
			];
			
			$"."this->render('index', $"."data);
		}
	}
");
                header('Location: '.URL_ROOT);
			}

			$this->render('index', $data);
		}
	}

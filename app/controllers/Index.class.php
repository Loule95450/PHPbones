<?php
/**
 * Class Index
 */

/**
 * It generates a random string of characters.
 *
 * @param strength The length of the string to be generated.
 *
 * @return string A random string of characters.
 */
function generate_string($strength = 100): string
{

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $input_length = strlen($permitted_chars);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

class Index extends Controller
{
    /**
     * Index constructor.
     */
    public function __construct()
    {
        // Import SQL commands

        //$this->userModel = $this->model('User');
    }

    /**
		 * views/index.php
		 */
		public function index() {
			$data = [
                'headTitle' => 'Welcome !',
				'title' => 'Hi you ! 😏',
                'cssFile' => 'index'
			];

			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

				file_put_contents("../app/config/config.php", "<?php
    /* It's defining the database host, user, password, and name. */
    define('DB_HOST', '" . trim($_POST['DB_HOST']) . "');
    define('DB_USER', '" . trim($_POST['DB_USER']) . "');
    define('DB_PASS', '" . trim($_POST['DB_PASS']) . "');
    define('DB_NAME', '" . trim($_POST['DB_NAME']) . "');
    
    /* It's defining the database encryption. */
    define('DB_CRYPT', true);
    define('DB_CRYPT_KEY', '" . generate_string() . "');
    define('DB_CIPHER_ALGO', 'AES-128-ECB');
    
    /* It's defining the root of the application. */
    define('APP_ROOT', dirname(dirname(__FILE__)));
    
    /* It's defining the root url of the website. */
    if(strpos($"."_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($"."_SERVER['HTTP_HOST'], '127.0.0.1') !== false){
        define('URL_ROOT', 'http://'.$"."_SERVER['HTTP_HOST'].str_replace('/public/index.php', '', $"."_SERVER['SCRIPT_NAME']));
    } else {
        define('URL_ROOT', 'https://'.$"."_SERVER['HTTP_HOST'].str_replace('/public/index.php', '', $"."_SERVER['SCRIPT_NAME']));
    }
    //define('URL_ROOT', 'https://".trim($_POST['SITE_NAME']).".com');
    
    /* It's defining the name of the website. */
    define('SITE_NAME', '".trim($_POST['SITE_NAME'])."');
    
	/* It's defining the meta description and image of the website. */
    define('CARD_DESCRIPTION', '".trim($_POST['CARD_DESCRIPTION'])."');
    define('CARD_IMAGE', 'https://');");

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
        <h1>Generate you files on https://mvc-generator.herokuapp.com/</h1>
    </header>

    <main>
        <!-- Generate you files with 'php generate.php help' command -->
    </main>
    <?php
        require APP_ROOT . '/views/inc/footer.php';
    ?>
</body>");

                file_put_contents("css/global.style.css", "html, body {
	margin: 0;
	font-family: 'Lato', sans-serif;
	color: #OOO;
}");

                file_put_contents("css/index.style.css", "header {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    height: 100vh;
}");


                file_put_contents("../app/controllers/Index.class.php", "<?php
	/**
	 * Class Index
	 */
	class Index extends Controller {
		/**
		 * Index constructor.
		 */
		public function __construct() {
		    // Import SQL commands

			//$"."this->indexModel = $"."this->loadModel('IndexModel');
		}
		
		/**
		 * views/index.php
		 */
		public function index() {
			$"."data = [
                'headTitle' => 'Welcome !',
				'title' => 'Hi you ! 😏',
                'cssFile' => 'index'
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

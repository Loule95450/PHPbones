<?php
    /* It's defining the database host, user, password, and name. */
    define('DB_HOST', '=DataBaseHost=');
    define('DB_USER', '=DataBaseUser=');
    define('DB_PASS', '=DataBasePassword=');
    define('DB_NAME', '=DataBaseName=');

    /* It's defining the database encryption. */
    define('DB_CRYPT', '=DataBaseCrypt=');
    define('DB_CRYPT_KEY', '=DataBaseCryptKey=');
    define('DB_CIPHER_ALGO', '=DataBaseCipherAlgo=');
	
	/* It's defining the root of the application. */
	define('APP_ROOT', dirname(dirname(__FILE__)));
	
    /* It's defining the root url of the website. */
    if(strpos($_SERVER['HTTP_HOST'], "localhost") !== false || strpos($_SERVER['HTTP_HOST'], "127.0.0.1") !== false){
        define('URL_ROOT', "http://" . $_SERVER['HTTP_HOST'] . str_replace("public/index.php", "", $_SERVER['SCRIPT_NAME']));
    } else {
        define('URL_ROOT', "https://".$_SERVER['HTTP_HOST'].str_replace("public/index.php", "", $_SERVER['SCRIPT_NAME']));
    }
    //define('URL_ROOT', 'https://MyWebsite.com');

	/* It's defining the name of the website. */
	define('SITE_NAME', str_replace("/public/index.php", "", $_SERVER['SCRIPT_NAME']));

    /* It's defining the meta description and image of the website. */
    define('CARD_DESCRIPTION', '=WebsiteDescription=');
    define('CARD_IMAGE', '=WebsiteIMG=');

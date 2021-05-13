<?php
	// Paramètres de la BDD
    define('DB_HOST', '=DataBaseHost=');
    define('DB_USER', '=DataBaseUser=');
    define('DB_PASS', '=DataBasePassword=');
    define('DB_NAME', '=DataBaseName=');

    //define('DB_HOST', 'localhost');
    //define('DB_USER', 'root');
    //define('DB_PASS', '');
    //define('DB_NAME', 'MyDataBase');
	
	// APP ROOT
	define('APP_ROOT', dirname(dirname(__FILE__)));
	
	// URL ROOT (Liens dynamiques)
    if(strpos($_SERVER['HTTP_HOST'], "localhost") !== false || strpos($_SERVER['HTTP_HOST'], "127.0.0.1") !== false){
        define('URL_ROOT', "http://" . $_SERVER['HTTP_HOST'] . str_replace("public/index.php", "", $_SERVER['SCRIPT_NAME']));
    } else {
        define('URL_ROOT', "https://".$_SERVER['HTTP_HOST'].str_replace("public/index.php", "", $_SERVER['SCRIPT_NAME']));
    }
    //define('URL_ROOT', 'https://MyWebsite.com');

	// Nom du site
	define('SITE_NAME', str_replace("/public/index.php", "", $_SERVER['SCRIPT_NAME']));

	//Meta
    define('CARD_DESCRIPTION', '=WebsiteDescription=');
    define('CARD_IMAGE', '=WebsiteIMG=');

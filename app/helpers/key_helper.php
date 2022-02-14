<?php
	/**
	 * @return string
	 * Check si l'utilisateur est connecté via le cookie dee seession
	 */

    // Fonction qui permet d'optenir, ajouter ou supprimer une valeur dans le tableau $_GET

	function get($key, $default=false) {
      return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
    }

    // Fonction qui permet d'optenir, ajouter ou supprimer une valeur dans le tableau $_SESSION

    function session($key, $default=false) {
      return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
    }

    function add_session($key, $value) {
      $_SESSION[$key] = $value;
    }

    function delete_session($key) {
      unset($_SESSION[$key]);
    }

    // Fonction qui permet d'optenir, ajouter ou supprimer une valeur dans le tableau $_POST

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    function post($key, $default=false) {
      return array_key_exists($key, $_POST) ? $_POST[$key] : $default;
    }

    function add_post($key, $value) {
      $_POST[$key] = $value;
    }

    function delete_post($key) {
      unset($_POST[$key]);
    }

    // Fonction qui permet d'optenir, ajouter ou supprimer une valeur dans le tableau $_COOKIE

    function cookie($key, $default=false) {
      return array_key_exists($key, $_COOKIE) ? $_COOKIE[$key] : $default;
    }

    function add_cookie($key, $value) {
      $_COOKIE[$key] = $value;
    }

    function delete_cookie($key) {
      unset($_COOKIE[$key]);
    }
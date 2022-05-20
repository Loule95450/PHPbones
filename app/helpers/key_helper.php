<?php
	/**
	 * If the key exists in the $_GET array, return the value of that key, otherwise return the default value
	 *
	 * @param key The key to look for in the $_GET array.
	 * @param default The default value to return if the key doesn't exist.
	 *
	 * @return The value of the key in the $_GET array, or the default value if the key is not found.
	 */
	function get($key, $default=false) {
      return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
    }



    /**
     * If the key exists in the session, return the value of the key, otherwise return the default value
     *
     * @param key The key to look for in the session array.
     * @param default The default value to return if the key doesn't exist.
     *
     * @return The value of the key in the session array, or the default value if the key is not found.
     */
    function session($key, $default=false) {
      return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
    }

    /**
     * It adds a session to the array.
     *
     * @param key The name of the session variable.
     * @param value The value of the session variable.
     */
    function add_session($key, $value) {
      $_SESSION[$key] = $value;
    }

    /**
     * It deletes a session.
     *
     * @param key The key of the session you want to delete.
     */
    function delete_session($key) {
      unset($_SESSION[$key]);
    }



    /* Sanitizing the $_POST array. */
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    /**
     * If the key exists in the $_POST array, return the value of that key, otherwise return the default value
     *
     * @param key The key to look for in the $_POST array.
     * @param default The default value to return if the key doesn't exist.
     *
     * @return The value of the key in the $_POST array, or the default value if the key is not found.
     */
    function post($key, $default=false) {
      return array_key_exists($key, $_POST) ? $_POST[$key] : $default;
    }

    /**
     * It adds a key/value pair to the $_POST array
     *
     * @param key The name of the POST variable to add.
     * @param value The value of the POST variable.
     */
    function add_post($key, $value) {
      $_POST[$key] = $value;
    }

    /**
     * It deletes a key from the $_POST array
     *
     * @param key The key of the $_POST array you want to delete.
     */
    function delete_post($key) {
      unset($_POST[$key]);
    }



    /**
     * If the key exists in the $_COOKIE array, return the value of that key, otherwise return the default value.
     *
     * @param key The name of the cookie to retrieve.
     * @param default The default value to return if the cookie doesn't exist.
     *
     * @return The value of the key in the $_COOKIE array.
     */
    function cookie($key, $default=false) {
      return array_key_exists($key, $_COOKIE) ? $_COOKIE[$key] : $default;
    }

    /**
     * It adds a cookie to the $_COOKIE array
     *
     * @param key The name of the cookie
     * @param value The value of the cookie.
     */
    function add_cookie($key, $value) {
      $_COOKIE[$key] = $value;
    }

    /**
     * It deletes a cookie.
     *
     * @param key The name of the cookie to delete.
     */
    function delete_cookie($key) {
      unset($_COOKIE[$key]);
    }
<?php
	/* Starting a session. */
	session_start();

	/**
	 * If the user_id session variable is set, return true, otherwise return false
	 *
	 * @return a boolean value.
	 */
	function isLoggedIn() {
		if (isset($_SESSION['user_id'])) {
			return true;
		} else {
			return false;
		}
	}

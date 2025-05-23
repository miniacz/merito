<?php
	require_once 'config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ($mysqli->connect_error) {
		die("Błąd połączenia: " . $mysqli->connect_error);
	}
	// else{
	// 	echo $mysqli->connect_errno;
	// }
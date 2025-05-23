<?php
  require_once 'db_connect.php';

	if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
		$id = (int) $_GET['id'];

		echo $_SERVER['REMOTE_ADDR'];

		if ($_SERVER['REMOTE_ADDR'] !== '::1') {
			http_response_code(403);
			die('Dostęp zabroniony');
		}

		$stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		header("Location: list_users.php?deleted=1");
		exit();
	}
<?php
	$servername = "localhost";
	$db = 'social';
	$username = "root";
	$password = "";

	$conn = new mysqli($servername, $username, $password, $db);
	if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
?>
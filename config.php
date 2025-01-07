<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	mysqli_report(MYSQLI_REPORT_ERROR );


	define('DB_SERVER', getenv('DB_SERVER'));
	define('DB_USERNAME', getenv('DB_USERNAME'));
	define('DB_PASSWORD', getenv('DB_PASSWORD'));
	define('DB_NAME', getenv('DB_NAME'));
	 
	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	 
	if($link === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
?>

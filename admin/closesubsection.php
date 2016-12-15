<?
	@session_start();
	require("functions.php");
	$section= substr($_POST['section'], 4, -4 );
	$section = urlencode($section);
	
	$_SESSION['opensection'][$section]=false;
?>
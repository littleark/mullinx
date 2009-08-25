<?php

	require_once('adodb/adodb.inc.php');

	//$_CONFIG['host'] = "mysql3.000wbhost.com";
	$_CONFIG['host'] = "localhost";

	$_CONFIG['user'] = "mullinx_com";
	$_CONFIG['pass'] = "colombo1492";
	$_CONFIG['dbname'] = "mullinx_com";
	//$_CONFIG['user'] = "root";
	//$_CONFIG['pass'] = "";
	//$_CONFIG['dbname'] = "mullinx";
	
	global $db;
	
	$db = NewADOConnection('mysql');
	$db->Connect($_CONFIG['host'],$_CONFIG['user'],$_CONFIG['pass'],$_CONFIG['dbname']);
	$db->SetFetchMode(ADODB_FETCH_ASSOC);
	

?>

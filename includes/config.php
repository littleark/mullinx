<?php

	require_once('adodb/adodb.inc.php');

	//$_CONFIG['host'] = "mysql3.000wbhost.com";
	$_CONFIG['host'] = "localhost";

	$_CONFIG['user'] = "";  //DB USER
	$_CONFIG['pass'] = "";  //DB PASSWORD
	$_CONFIG['dbname'] = "";  //DB NAME

	
	global $db;
	
	$db = NewADOConnection('mysql');
	$db->Connect($_CONFIG['host'],$_CONFIG['user'],$_CONFIG['pass'],$_CONFIG['dbname']);
	$db->SetFetchMode(ADODB_FETCH_ASSOC);
	

?>

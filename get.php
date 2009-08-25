<?

//include("includes/config.php");

function registerStats() {
	global $db;
	
	$ip=$_SERVER["REMOTE_ADDR"];
	if ($ip!="88.47.33.234") {
		
		$query="INSERT INTO `mullinx_stats`(`ip`) VALUES('$ip');";
		//echo $query;
		$db->Execute($query) or die($db->ErrorMsg());
	}
}
//registerStats();

include("js/jquery-1.2.6.pack.js");
echo ";";
echo "jQuery.noConflict();";
include("js/mullinx.js");
echo ";";
echo "(function() {";
if ($_GET['th']=='bright') {
	echo "jQuery(\"a\").mullinx({
		color:\"#00ffff\",
		bgcolor:\"#fff\",
		color:\"#000\",
		hoverColor:\"#0000ff\"
	});";
} else{
	echo "jQuery(\"a\").mullinx();";
}
	
	
echo "})();"

?>

<?php
/* Funzione di preparazione campo in upload */
function myFp($campo,$max){

	global $db;

	$campo = substr(trim(strip_tags($db->qstr($campo,get_magic_quotes_gpc()))),0,$max-1);

	return $campo;
}

/* Funzione di conversione dimensioni */
function filesize_h($size,$dec=1){
    $sizes = array('B', 'KB', 'MB', 'GB');
    $count = count($sizes);
    $i = 0;
    while ($size >= 1024 && ($i < $count - 1)) {
        $size /= 1024;
        $i++;
    }
    return round($size, $dec) . ' ' . $sizes[$i];
}
function filesize_format($size){

    if( is_null($size) || $size === FALSE || $size == 0 )
    return $size;

  if( $size > 1024*1024*1024 )
    $size = sprintf( "%.1f GB", $size / (1024*1024*1024) );
  elseif( $size > 1024*1024 )
    $size = sprintf( "%.1f MB", $size / (1024*1024) );
  elseif( $size > 1024 )
    $size = sprintf( "%.1f KB", $size / 1024 );
  elseif( $size < 0 )
    $size = '&nbsp;';
  else
    $size = sprintf( "%d B", $size );

  return $size;

}
/* Cancellazione ricorsiva directory */
function rmdirr($dirname){
	//echo "recursive remove dir: $dirname<br>";
	// Simple delete for a file
	if (is_file($dirname)) {
		return unlink($dirname);
	}
	// Loop through the folder
	$dir = dir($dirname);
	while (false !== $entry = $dir->read()) {
		// Skip pointers
		if ($entry == '.' || $entry == '..') {
			continue;
		}
		// Deep delete directories
		if (is_dir("$dirname/$entry")) {
			rmdirr("$dirname/$entry");
		} else {
			//echo "deleting $dirname/$entry<br>";
			unlink("$dirname/$entry");
		}
	}
	// Clean up
	$dir->close();
	return rmdir($dirname);
}

/* Ritorna l'estensione di un file */
   function getExtensionFromFile ($filename) {
   		return strtolower(substr(strrchr($filename,"."),1));
   }
/* Corregge bug png 64*/
function fixpng($filename,$x=0,$y=0,$alt,$id=""){
$id_str="";
if ($id!="")
	$id_str="id=\"$id\" ";
$im = @imagecreatefrompng($filename);
$width="";
if ($x!=0) {
	$width="width:".$x."px";
} else {
	$width="width:".imagesx($im)."px";
}
if ($x=="none")
	$width="";
$height="";
if ($y!=0) {
	$height="height:".$y."px";
} else {
	$height="height:".imagesy($im)."px";
}
if ($y=="none")
	$height="";
$msie='/msie\s(5\.[5-9]|[6-6]\.[0-9]*).*(win)/i';
if( !isset($_SERVER['HTTP_USER_AGENT']) ||
    !preg_match($msie,$_SERVER['HTTP_USER_AGENT']) ||
    preg_match('/opera/i',$_SERVER['HTTP_USER_AGENT'])) {
    	$img_str1="<img $id_str src='";
    	$img_str2="' alt=\"".$alt."\"  style=\"$width;$height;\" border=\"0\">";
} else {
	$img_str1="<img $id_str src=\"img/spacer.png\" style=\"$width;$height;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='";
	$img_str2="', sizingMethod=scale);\" alt=\"".$alt."\" border=\"0\">";
}
return $img_str1.$filename.$img_str2;
}
function genpassword($length){

    srand((double)microtime()*1000000);

    $vowels = array("a", "e", "i", "o", "u");
    $cons = array("b", "c", "d", "g", "l", "m", "n", "p", "r", "s", "t", "u", "v", "tr",
    "cr", "br", "fr", "dr",  "gl", "st", "sp", "sv", "pr", "sl", "cl","po","lu","da");

    $num_vowels = count($vowels);
    $num_cons = count($cons);

    for($i = 0; $i < $length; $i++){
        $password .= $cons[rand(0, $num_cons - 1)] . $vowels[rand(0, $num_vowels - 1)];
    }

    return substr($password, 0, $length);
}

function sendSubscriptionEmailFromDB($id,$table,$password) {

	global $mail_iscrizione;


	require("mailer/class.phpmailer.php");
	require_once("mailer/mail/mail.tpl.php");

	// MAIL ISCRIZIONE

	$mail_iscrizione['oggetto']="Iscrizione a bellelli.com";
	$mail_iscrizione['welcome']="Benvenuto";
	$mail_iscrizione['corpo1']="<b>Sei stato registrato sul sito Bellelli.com</b><br>
				            	Da oggi potrai usufruire dei servizi offerti dal nostro sito.<br>
				            	Per accedere e modificare i tuoi dati sar&agrave; sufficiente, una volta collegato al sito, inserire il tuo nome utente e la chiave di accesso, che ti &egrave; stata assegnata automaticamente al momento della registrazione.<br>
				            	<br><br>
				            	<b><u>I dati per accedere all\'area riservata del sito sono:</u></b>
				            	<br><br>";
	$mail_iscrizione['username']="Username";
	$mail_iscrizione['password']="Password";
	$mail_iscrizione['corpo2']="Ti ricordiamo che per ogni ulteriore informazione siamo a tua pi&ugrave; completa disposizione ai riferimenti indicati di seguito.
								<br><br>
				            	Se hai ricevuto questa e-mail &egrave; perch&egrave; tu, o qualcuno per te, ha registrato un utente con il tuo indirizzo
				            	e-mail presso il sito internet <a href=\"http://www.bellelli.com\">Bellelli.com</a>
				            	<br>
				            	Questa e-mail &egrave; stata inviata in modo automatico, per qualsiasi problema contattaci all'indirizzo <a href=\"mailto:info@bellelli.com\">info@bellelli.com</a>.
				            	<br><br>";


	$query="SELECT * FROM ".$table."_moreinfo WHERE `id_utente`='$id'";
	$result=mysql_query($query);
	$r=mysql_fetch_array($result);
	$nickname=$r['nickname'];

	$query="SELECT * FROM $table WHERE `id`='$id'";
	$result=mysql_query($query);
	$r=mysql_fetch_array($result);


	$mail = new PHPMailer();

	$mail->From         = "no-reply@bellelli.com";
	$mail->FromName     = "Bellelli.com";
	$mail->AddReplyTo   = "no-reply@bellelli.com";
	$mail->Host     	= "bellelli.com";
	$mail->AddAddress($r['email']);
	$mail->Mailer       = "mail";
	$mail->ContentType  = "text/html";
	$mail->IsHTML(true);

	//$mail->AddEmbeddedImage("mailer/mail/fil.gif","fil","fil.gif",$encoding = "base64","image/gif");
	$mail->AddEmbeddedImage("mailer/mail/logo.jpg","logo","logo.jpg",$encoding = "base64","image/jpg");

	$mail->Subject  = "Benvenuto in Bellelli.com";



	$html=get_html_mail_header_nopostcard("Benvenuto in Bellelli.com");
	$html.='<b>'.nl2br(stripslashes(trim($mail_iscrizione['oggetto']))).'</b><br><br>';
	$html.=$mail_iscrizione['welcome'].', '.capitalize(stripslashes($r['name'])).' '.capitalize(stripslashes($r['surname'])).'!<br><br>';
	$html.=stripslashes($mail_iscrizione['corpo1']);
	$html.=$mail_iscrizione['username'].": <b>".$nickname."</b><br>";
	$html.=$mail_iscrizione['password'].": <b>".$password."</b><br><br>";
	$html.=$mail_iscrizione['corpo2'];
	$html.=get_html_mail_footer_nopostcard();
	$text='HTML e-mail, please use a compatible client!';


	$mail->Body    = $html;
	$mail->AltBody = $text;


		if(!$mail->Send()) {
	        return "There has been a mail error sending to " . $r['email'] . "<br>";
		} else {
			return true;
		}

}

function capitalize($string) {
	return strtoupper(substr($string,0,1)).strtolower(substr($string,1,strlen($string)));
}
function cmpOnPrevSibling($a,$b) {
	echo "prima ".$a['id']."[".$a['prev_sibling']."] di ".$b['id']."[".$b['prev_sibling']."]? ";
	if ($a['id']==$b['prev_sibling'] || !isset($a['prev_sibling'])) {
		echo "si! \n";
		return -1;
	} elseif (!isset($b['prev_sibling'])) {
		echo "no! \n";
		return 1;
	} else {
		echo "boh! \n";
		return 0 ;
	}
	/*
	//echo $a['id']." vs ".$b['id']." is ".$b['prev_sibling']." == ".$a['id']."\n";
	if (!isset($a['prev_sibling'])) { 
		//echo "NULL!!!";
		echo "1. prima ".$a['id']."[".$a['prev_sibling']."] di ".$b['id']."[".$b['prev_sibling']."]\n";
		return -1;
	}
	
	if (!isset($b['prev_sibling'])) { 
		//echo "NULL!!!";
		echo "2. prima ".$b['id']."[".$b['prev_sibling']."] di ".$a['id']."[".$a['prev_sibling']."]\n";
		return -1;
	}
	
	//return -1;
	
	
	//return ($a['id']==$b['prev_sibling'])?-1:1;
	//return ($b['prev_sibling']==$a['id'])?1:0;
	//return 0;
	
	if ($a['id']==$b['prev_sibling']) {
		echo "3. prima ".$a['id']."[".$a['prev_sibling']."] di ".$b['id']."[".$b['prev_sibling']."]\n";
		return -1;
	}
	
	return 1;
	*/
	/*
	else {
		echo "prima ".$b['id']."[".$b['prev_sibling']."] di ".$a['id']."[".$a['prev_sibling']."]\n";
		return 0;
	}
	*/
}


function is_empty($array) {
	return count($array)>0?0:1;
}
$mimetypes = array(
	'application/msword' => array('doc','doc'),
	'application/pdf' => array('pdf','pdf'),
	'application/postscript' => array('ai','svg'),
	'application/postscript' => array('eps','svg'),
	'application/postscript' => array('ps','svg'),
	'application/vnd.ms-excel' => array('xls','doc'),
	'application/vnd.ms-powerpoint' => array('ppt','doc'),
	'application/x-gtar' => array('gtar','zip'),
	'application/x-javascript' => array('js','html'),
	'application/x-latex' => array('latex','doc'),
	'application/x-shockwave-flash' => array('swf','jpg'),
	'application/x-stuffit' => array('sit','zip'),
	'application/x-tar' => array('tar','zip'),
	'application/x-tex' => array('tex','doc'),
	'application/xhtml+xml' => array('xhtml','html'),
	'application/zip' => array('zip','zip'),
	'audio/basic' => array('au','audio'),
	'audio/basic' => array('snd','audio'),
	'audio/midi' => array('mid','audio'),
	'audio/midi' => array('midi','audio'),
	'audio/midi' => array('kar','audio'),
	'audio/mpeg' => array('mpga','audio'),
	'audio/mpeg' => array('mp2','audio'),
	'audio/mpeg' => array('mp3','audio'),
	'audio/x-aiff' => array('aif','audio'),
	'audio/x-aiff' => array('aiff','audio'),
	'audio/x-aiff' => array('aifc','audio'),
	'audio/x-mpegurl' => array('m3u','audio'),
	'audio/x-pn-realaudio' => array('ram','audio'),
	'audio/x-pn-realaudio' => array('rm','audio'),
	'audio/x-realaudio' => array('ra','audio'),
	'audio/x-wav' => array('wav','audio'),
	'image/bmp' => array('bmp','jpg'),
	'image/gif' => array('gif','gif'),
	'image/ief' => array('ief','jpg'),
	'image/jpeg' => array('jpeg','jpg'),
	'image/jpeg' => array('jpg','jpg'),
	'image/jpeg' => array('jpe','jpg'),
	'image/png' => array('png','png'),
	'image/psd' => array('psd','psd'),
	'image/svg' => array('svg','svg'),
	'image/tiff' => array('tiff','jpg'),
	'image/tiff' => array('tif','jpg'),
	'image/vnd.wap.wbmp' => array('wbmp',''),
	'image/x-portable-anymap' => array('pnm',''),
	'image/x-portable-bitmap' => array('pbm',''),
	'image/x-portable-graymap' => array('pgm',''),
	'image/x-portable-pixmap' => array('ppm',''),
	'image/x-rgb' => array('rgb',''),
	'image/x-xbitmap' => array('xbm',''),
	'image/x-xpixmap' => array('xpm',''),
	'image/x-xwindowdump' => array('xwd',''),
	'model/vrml' => array('wrl','html'),
	'model/vrml' => array('vrml','html'),
	'text/css' => array('css','html'),
	'text/html' => array('html','html'),
	'text/html' => array('htm','html'),
	'text/plain' => array('asc','txt'),
	'text/plain' => array('txt','txt'),
	'text/richtext' => array('rtx','txt'),
	'text/rtf' => array('rtf','doc'),
	'text/sgml' => array('sgml','txt'),
	'text/sgml' => array('sgm','txt'),
	'text/vnd.wap.wml' => array('wml','html'),
	'text/xml' => array('xsl','txt'),
	'text/xml' => array('xml','txt'),
	'video/mpeg' => array('mpeg','video'),
	'video/mpeg' => array('mpg','video'),
	'video/mpeg' => array('mpe','video'),
	'video/quicktime' => array('qt','video'),
	'video/quicktime' => array('mov','video'),
	'video/x-msvideo' => array('avi','video'),
	'video/x-sgi-movie' => array('movie','video')
);
/* Copies a dir to another. Optionally caching the dir/file structure, used to synchronize similar destination dir (web farm).
     *
     * @param $src_dir str Source directory to copy.
     * @param $dst_dir str Destination directory to copy to.
     * @param $verbose bool Show or hide file copied messages
     * @param $use_cached_dir_trees bool Set to true to cache src/dst dir/file structure. Used to sync to web farms
     *                     (avoids loading the same dir tree in web farms; making sync much faster).
     * @return Number of files copied/updated.
     * @example
     *     To copy a dir:
     *         dircopy("c:\max\pics", "d:\backups\max\pics");
     *
     *     To sync to web farms (webfarm 2 to 4 must have same dir/file structure (run once with cache off to make sure if necessary)):
     *        dircopy("//webfarm1/wwwroot", "//webfarm2/wwwroot", false, true);
     *        dircopy("//webfarm1/wwwroot", "//webfarm3/wwwroot", false, true);
     *        dircopy("//webfarm1/wwwroot", "//webfarm4/wwwroot", false, true);
     */
    function dircopy($src_dir, $dst_dir, $verbose = false, $use_cached_dir_trees = false)
    {   
        static $cached_src_dir;
        static $src_tree;
        static $dst_tree;
        $num = 0;
		
		//echo "1. copying $src_dir to $dst_dir";
		
        if (($slash = substr($src_dir, -1)) == "\\" || $slash == "/") $src_dir = substr($src_dir, 0, strlen($src_dir) - 1);
        if (($slash = substr($dst_dir, -1)) == "\\" || $slash == "/") $dst_dir = substr($dst_dir, 0, strlen($dst_dir) - 1); 
		
		//echo "2. copying $src_dir to $dst_dir";
		
        if (!$use_cached_dir_trees || !isset($src_tree) || $cached_src_dir != $src_dir)
        {
            $src_tree = get_dir_tree($src_dir);
            $cached_src_dir = $src_dir;
            $src_changed = true; 
        }
        if (!$use_cached_dir_trees || !isset($dst_tree) || $src_changed)
            $dst_tree = get_dir_tree($dst_dir);
        if (!is_dir($dst_dir)) mkdir($dst_dir, 0777, true); 

          foreach ($src_tree as $file => $src_mtime)
        {
            if (!isset($dst_tree[$file]) && $src_mtime === false) // dir
                mkdir("$dst_dir/$file");
            elseif (!isset($dst_tree[$file]) && $src_mtime || isset($dst_tree[$file]) && $src_mtime > $dst_tree[$file])  // file
            {
                if (copy("$src_dir/$file", "$dst_dir/$file"))
                {
                    if($verbose) echo "Copied '$src_dir/$file' to '$dst_dir/$file'<br>\r\n";
                    touch("$dst_dir/$file", $src_mtime);
                    $num++;
                } else
                    echo "<font color='red'>File '$src_dir/$file' could not be copied!</font><br>\r\n";
            }       
        }

        return $num;
    }

    /* Creates a directory / file tree of a given root directory
     *
     * @param $dir str Directory or file without ending slash
     * @param $root bool Must be set to true on initial call to create new tree.
     * @return Directory & file in an associative array with file modified time as value.
     */
    function get_dir_tree($dir, $root = true)
    {
        static $tree;
        static $base_dir_length;

        if ($root)
        {
            $tree = array(); 
            $base_dir_length = strlen($dir) + 1; 
        }

        if (is_file($dir))
        {
            //if (substr($dir, -8) != "/CVS/Tag" && substr($dir, -9) != "/CVS/Root"  && substr($dir, -12) != "/CVS/Entries")
            $tree[substr($dir, $base_dir_length)] = filemtime($dir);
        } elseif (is_dir($dir) && $di = dir($dir)) // add after is_dir condition to ignore CVS folders: && substr($dir, -4) != "/CVS"
        {
            if (!$root) $tree[substr($dir, $base_dir_length)] = false; 
            while (($file = $di->read()) !== false)
                if ($file != "." && $file != "..")
                    get_dir_tree("$dir/$file", false); 
            $di->close();
        }

        if ($root)
            return $tree;    
    }
?>

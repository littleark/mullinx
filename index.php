<?
	include("includes/config.php");
	include("includes/common.php");
	//prova
	$errors=array();
	if($_POST['send_comment']) {
		if($_POST['address']!='')
			$errors['address']=1;
		if(trim($_POST['name'])=='')
			$errors['name']=1;
		if(trim($_POST['comment'])=='')
			$errors['comment']=1;
	
		if(count($errors)==0) {
			$query="INSERT INTO `comments`(`author`,`email`,`comment`) VALUES ('".addslashes($_POST['name'])."','".addslashes($_POST['email'])."','".addslashes($_POST['comment'])."')";
			//echo $query;
			$result = $db->Execute($query) or print $db->ErrorMsg()." query:".$query;
			mail("info@makinguse.com", "Messaggio da mullinx","Mittente : ".$_POST['name']."\nE-mail mittente : ".$_POST['email']."\n\nMessaggio : \n".($_POST['comment']),"From: info@makinguse.com");
			empty($_POST);
			header("Location:?p=1#comment");
		}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<title>&mu;llinx - Multi Directional Links jQuery plugin</title>
	<link rel="stylesheet" type="text/css" href="css/mullinx.css"/>
	<script src="js/jquery-1.2.6.pack.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/mullinx.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<div id="container">
	<div id="header">
		<h1>
			<a title="Multi Directional Link jQuery Plugin and Widget" href="#">&mu;llinx - Multi Directional Hperlinks for the Masses</a>
		</h1>
	</div>
	<div id="content">
		<div id="overview" class="par">
			<h2>Overview</h2><a name="overview"></a>
			<p style="color:#ffe400;font-weight:bold">
				<b>&mu;llinx</b> (mullinx) is a super simple, unobtrusive widget and jQuery plugin used to
				transform normal hyperlinks into <b>multidirectional hyperlinks</b> through the 
				flexibility of jQuery's selector.
			</p>
			<p>
				<a href="http://en.wikipedia.org/wiki/Hyperlink" rev="http://en.wikipedia.org/wiki/Links_(web_browser)|Links">HyperLinks</a> (abbreviated to "link") are considered the <i>primary navigational means of the web</i> and the 
				main essence of hypertextual technology.
				A link is a form of text typically published on websites that provides a richer functionality than simple text documents by enabling the reader to explore interesting links to other web pages linked to specific words or images within the page.
				They are often used as <i>unidirectional vectors</i>, <b>&mu;llinx</b>'s main aim is to transform
				unidirectional links to multi-headed links, without big efforts for web authors.<br/><br/>
				There are several experiments and implementations of <i>multidirectional</i> links (e.g. Xlink), but most of them
				are not so easy to use in a simple web page, with <b>&mu;llinx</b> I wanted to create something super easy
				to use.
			</p>
		</div>
		<div class="nav">
		<a href="#" rev="#overview|Overview;#example|Example;#download|Download;#howto|How to use;#extend|Extend your &mu;llinx;#contacts|Contacts;#comments|Comments">Top</a>
		</div>
		<div id="example" class="par">
			<h2>Example</h2><a name="example"></a>
			<p>
				Move over this link and see <b>&mu;llinx</b> in action: <a style="font-weight:bold;" href="http://en.wikipedia.org/wiki/Web_search_engine" rev="http://www.google.com|Google;http://www.yahoo.com|Yahoo!;http://www.yoople.net|Yoople!;http://www.cuil.com|cuil">Search Engines</a>
			</p>
			<p>
				HTML used in this example:
			</p>
			<pre><xmp>
<a href="http://en.wikipedia.org/wiki/Web_search_engine" 
   rev="http://www.google.com|Google;
        http://www.yahoo.com|Yahoo!;
        http://www.yoople.net|Yoople!;
        http://www.cuil.com|cuil">Search Engines</a></xmp></pre>
		</div>
		<div class="nav">
		<a href="#" rev="#overview|Overview;#example|Example;#download|Download;#howto|How to use;#extend|Extend your &mu;llinx;#contacts|Contacts;#comments|Comments">Top</a>
		</div>
		<div id="download" class="par">
			<h2>Download</h2><a name="download"></a>
			<p>
				<div class="sub_par">
				<h4>Option A: The widget way</h4>
				<p>
					No need to downloads! You just need to include the widget script tag in your page:
				</p>
				<pre><xmp><script src="http://mullinx.makinguse.com/get/" type="text/javascript"></script></xmp></pre>
				<!--<p>
				If you want to see the widget version in action, please visit this page: <a href="http://www.makinguse.com/" alt="MakingUse.com" target="_blank">widget playground</a>.
			</p>-->
				</div>
				<br/>
				<div class="sub_par">
				<h4>Option B: jQuery Plugin</h4>
				<p>
					Download the <b>&mu;llinx jQuery plugin</b> (Version 0.2):
				</p>
				<ul>
					<li>Uncompressed: <a href="http://code.google.com/p/mullinx/downloads/list" target="_blank">mullinx.js</a> (<?=filesize_format(filesize("js/mullinx.js"))?>)</li>
					<li>Minified: <a href="http://code.google.com/p/mullinx/downloads/list" target="_blank">mullinx.min.js</a> (<?=filesize_format(filesize("js/mullinx.min.js"))?>)</li>
				</ul>
				<p>
					You can download <b>&mu;llinx</b> jQuery Plugin from these websites as well:
				</p>
				<ul>
					<li><a href="https://github.com/littleark/mullinx" target="_blank">Github</a></li>
					<li><a href="http://plugins.jquery.com/project/mullinx" target="_blank">jQuery Plugins</a></li>
				</ul>
				</div>
			</p>
		</div>
		<div class="nav">
		<a href="#" rev="#overview|Overview;#example|Example;#download|Download;#howto|How to use;#extend|Extend your &mu;llinx;#contacts|Contacts;#comments|Comments">Top</a>
		</div>
		<div id="howto" class="par">
			<h2>How to use</h2><a name="howto"></a>
			<p>
			Using <b>&mu;llinx</b> is pretty straightforward, in a couple of steps you'll be running:
			</p>
			<h3>Step 1: Setup &mu;llinx</h3>
			<br/>
			
			<div class="sub_par">
				<h4>Option A: The widget way</h4>
				<p>
					With the <b>&mu;llinx widget</b> you don't neet to download or setup 
					scripts or libraries in your page.<br/>
					You just need to include the widget script tag at the end of your page:
				</p>
				<pre><xmp><script src="http://mullinx.makinguse.com/get/" type="text/javascript"></script></xmp></pre>
			</div>
			<br/>
			<div class="sub_par">
				<h4>Option B: The jQuery plugin way</h4>
				<p>
					If you don't want to embed the widget, you can opt for the <b>&mu;llinx jQuery plugin</b>. In order to use the plugin you need the <a href="http://www.jquery.com" rev="http://docs.jquery.com|jQuery Documentation;http://en.wikipedia.org/wiki/JQuery|jQuery on Wikipedia">jQuery Library</a> to be included in your page header:
				</p>
				<pre><xmp>
<script src="jquery.js" type="text/javascript"></script>
<script src="mullinx.min.js" type="text/javascript"></script></xmp></pre>
				<p>
				Once you have included the libraries in your header, don't forget to add these few lines of javascript code into  your page:
				</p>
				<pre>
$(function() {
	$("a").mullinx();
});</pre>
			</div>
			<br/>
			<h3>Step 2: Activate your links</h3>
			<div class="sub_par">
			<p>
			Now you need to add the additional directions to your &lt;a&gt; tags, doing it
			is pretty simple, you just need to insert the url in the <b>rev</b> attribute,
			using the <b>;</b> (semicolon) as separator:
			</p>
			<pre><xmp><a href="http://mainlink.uri" rev="second.uri;third.uri;...;last.uri">Main Site</a></xmp></pre>
			<p>
			You can also define a nicer title for each url, adding <b>|</b> (pipe character) and the title just after the url:
			</p>
			<pre><xmp>...rev="second.uri|Second Title;third.uri|Third Title;...;last.uri|Last Title"...</xmp></pre>
			<p>
			Why not using the <i>rel</i> attribute? Because "rev" is less used, "rel" could create some problem
			for is widely used for other purposes
			</p>
			</div>
		</div>
		<div class="nav">
		<a href="#" rev="#overview|Overview;#example|Example;#download|Download;#howto|How to use;#extend|Extend your &mu;llinx;#contacts|Contacts;#comments|Comments">Top</a>
		</div>
		<div id="extend" class="par">
			<h2>Extend your &mu;llinx!</h2><a name="extend"></a>
			<p>
			Customizing <b>&mu;llinx</b> depends on the version you have opted for, widget or jQuery plugin:
			</p>
			<h3>Widget</h3>
			<div class="sub_par">
				<p>
				The widget version of &mu;llinx introduces two themes: dark and bright version. , if you
				want to switch to the bright one (similar to the one you can see in this page) you just have to modify a little bit the widget script tag:
				</p>
				<pre>
<span style="color:#ffff00">dark theme:</span><xmp><script src="http://mullinx.makinguse.com/get/dark/" type="text/javascript">
</script></xmp>
<span style="color:#ffff00">bright theme:</span><xmp><script src="http://mullinx.makinguse.com/get/bright/" type="text/javascript">
</script></xmp>
</pre>
				The dark theme is the default one, so if you don't specify any theme in the script tag you'll get a dark <b>&mu;llinx</b>.
			</div>
			<br/>
			<h3>jQuery Plugin</h3>
				<div class="sub_par">
				<p>
				<b>&mu;llinx jQuery plugin</b> has some settings you can customize. The available options are:
				</p>
				<ul>
					<li><b>bgcolor</b>: defines the background color. #000 (black) is default.</li>
					<li><b>color</b>: defines the font color. #fff (white) is default.</li>
					<li><b>hoverColor</b>: defines the links color when mouse moves over.#ffff00 (yellow) is default.</li>
					<li><b>opacity</b>: defines &mu;llinx transparency, values from 0 to 1 (0 is transparent, 1 no see-through). 0.9 is default.</li>
					<li><b>fontSize</b>: defines font size. 0.8em is default.</li>
					<li><b>fontFamily</b>: defines font family. Arial is default.</li>
					<li><b>separator</b>: defines the spearator between urls in the rev attribtue. <b>;</b> (semicolon) is default.</li>
					<li><b>sub_separator</b>: defines the spearator between url and title in the rev attribtue. <b>|</b> (pipe) is default. "|",</li>
				</ul>
				<p>
					Here we go with an example:
				</p>
<pre><xmp>
$(function() {
	$("a").mullinx({
		color:"#00ffff",
		opacity:0.5,
		bgcolor:"#fff",
		color:"#000",
		hoverColor:"#0000ff",
		fontSize:"18px",
		fontFamily:"Georgia,sans-serif"
	});
});
</xmp></pre>
			</div>
		</div>
		<div class="nav">
		<a href="#" rev="#overview|Overview;#example|Example;#download|Download;#howto|How to use;#extend|Extend your &mu;llinx;#contacts|Contacts;#comments|Comments">Top</a>
		</div>
		<div id="contacts" class="par">
			<h2>Contacts</h2><a name="contacts"></a>
			<p>
			So you really want to write me?!? Uhm...let's see then...you could try at <b class="fake_link">info[at]makinguse.com</b><br/>
			<i>Please, don't write to tell me this page is a mess...</i>
			</p>
		</div>
		<div class="nav">
		<a href="#" rev="#overview|Overview;#example|Example;#download|Download;#howto|How to use;#extend|Extend your &mu;llinx;#contacts|Contacts;#comments|Comments">Top</a>
		</div>
		<div id="comments" class="par">
			<h2>Comments</h2><a name="comments"></a>
			<?
				
				$query="SELECT `author`,`email`,`comment`,`timestamp` FROM `comments` WHERE `approved`=1 ORDER BY `timestamp` DESC";
				$result = $db->Execute($query) or print $db->ErrorMsg()." query:".$query;
				
				if($result->RecordCount()>0) {
					while(!$result->EOF) {
						?>
						<div class="news">
							<b class="fake_link"><?=$result->fields['author']?></b>
							said on <?=date("l jS F Y",strtotime($result->fields['timestamp']))?> at <?=date("g:ia",strtotime($result->fields['timestamp']))?>
							<p>
							<?=strip_tags(stripslashes($result->fields['comment']),"<a>")?>
							</p>
						</div>
						<?
						$result->MoveNext();
					}
				} else {
					?><div class="news">No comments yet...and probably never!</div><?
				}
			?>
			<div class="nav">
			<a href="#" rev="#overview|Overview;#example|Example;#download|Download;#howto|How to use;#extend|Extend your &mu;llinx;#contacts|Contacts;#comments|Comments">Top</a>
			</div>
			<p>
				<h3>Your comment</h3><a name="comment"></a>
				<?if(!$_GET['p']) {?>
				<form action="#comment" method="post">
					Here you can leave a comment, would be nice if you keep it friendly, but don't worry I need to approve it before...eheh
					<br/><br/>
					<label>Name</label><?if($errors['name']) {?>&nbsp;<i class="error">pleaaaseeee....</i><?}?><br/>
					<input type="text" value="<?=stripslashes($_POST['name'])?>" name="name" size="60" maxlength="255" style="max-width:380px;"/>
					<br/>
					<label>Email</label> <i style="color:#aaa;">(not compulsory)</i><br/>
					<input type="text" value="<?=stripslashes($_POST['email'])?>" name="email" size="60" maxlength="255" style="max-width:380px;"/>
					<br/>
					<label>Comment</label><?if($errors['comment']) {?>&nbsp;<i class="error">pleaaaseeee....</i><?}?><br/>
					<textarea name="comment" cols="80" rows="10" style="max-width:520px;"><?=stripslashes($_POST['comment'])?></textarea>
					<br/>
					<i style="color:#aaa;font-size:0.8em;">Name and Comment are compulsory...just in case...</i>
					<br/><br/>
					<input type="text" class="bot" value="" name="address" />
					<input type="submit" class="send" value="Send comment &raquo;" name="send_comment" />
				</form>
				<?} else {?>
					<h4 style="color:#ffd200">Comment sent! Thank you!</h4>
				<?}?>
			</p>
		</div>
	</div>
	<div id="footer">
		<p>
		<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/us/80x15.png" /></a><br /><span xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dc:title" rel="dc:type">mullinx</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="mullinx.makinguse.com" property="cc:attributionName" rel="cc:attributionURL">Carlo Zapponi</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/us/">Creative Commons Attribution-Share Alike 3.0 License</a>.
		</p>
		<p>
		&copy; 2008 <span class="fake_link">Carlo Zapponi</span>
		</p>
	</div>
	<script type="text/javascript">
		$(function() {
			$("a").mullinx({
				color:"#00ffff",
				bgcolor:"#fff",
				color:"#000",
				hoverColor:"#0000ff"
			});
		});
	</script>
	<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	var pageTracker = _gat._getTracker("UA-364839-16");
	pageTracker._trackPageview();
	</script>
</div>
</body>
</html>

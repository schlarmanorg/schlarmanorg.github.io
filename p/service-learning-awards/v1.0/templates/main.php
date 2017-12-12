<?php
	$version = 1.0;

	$us_server = "localhost/unblockit/v1.0/";
?>
<!DOCTYPE html>
<html>
<head>


<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="author" content="Schlarman.org">
<meta name="description" content="Giving people access to a secure, fast, and uncensored internet">
<meta name="keywords" content="proxy, free, ad free, secure, fast, uncensored, unblock, it, schlarman, proxy, proxy definition, proxy server, web proxy, proxy list, proxy sites, proxy browser, hide me, unblockit, unblock, internet, free, free proxy, fast proxy, easy proxy, schlarman, .co, unblocked games, unblocked movies, unblock youtube, unblock facebook, unblock music">
<meta name="version" content="<?=$version;?>">
	<title>Unblock It | Uncensor The Internet</title>
<link rel="stylesheet" href="assets/css/main-dark.css" type="text/css">
<link rel="stylesheet" href="assets/css/master.css" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

<div id="main_wrap" align="center">
<div id="m_wrap">
<div id="container">

	<div style="text-align:center;">
		<h1 class="logo">UnBlock It<span>v0.9</span></h1>
	</div>

	<?php if(isset($error_msg)){ ?>

	<div id="error">
		<p><?php echo $error_msg; ?></p>
	</div>

	<?php } ?>


	<div id="frm">

	<!-- I wouldn't touch this part -->
		<form action="index.php" method="post" style="margin-bottom:0;">
			<input name="url" id="url" class="url_bar" type="text"  autocomplete="off" placeholder="http://" />
			<br/>
			<div id="location_select">
				<label title="Chicago" class="radio-inline">
					<input checked name="location" value="<?php echo $us_server ?>" type="radio">
					<img class="location_img" alt="American Server Icon" src="assets/imgs/US.png">
				</label>
				<label title="Belgium" class="radio-inline">
					<input name="location" value="be.unblockit.co" type="radio">
					<img class="location_img" alt="Belgium Server Icon" src="assets/imgs/Belgium.png">
				</label>
			</div>
			<br/>
			<input class="url_submit" type="submit" value="Submit" />

</form>

		<script type="text/javascript">
			document.getElementsByName("url")[0].focus();
		</script>

	<!-- [END] -->

	</div>

</div>
<div id="a_wrap">
	<div class="ad_holder">Advertise Here</div>
</div>
</div>
<div id="footer">
	<div class="footer_text">
		<a href="contact.php">Contact</a>

		<a href="update-log.txt">Update Log</a>

		<a class="more_btn" style="cursor:pointer;">More</a>
	</div>

</div>
<div id="info_wrap">
	<div class="info one">
		<div class="info_image_one">
			<img src="assets/imgs/imgs/secure.svg" width="200px" height="200px"/>
		</div>
		<div class="info_text_one">
			<h2> Secure </h2>
			<br/>
			<p> We are very serious when it comes to user security, we are firm believers in Net Netuality. Along with being able to browse whatever you want without being spyed on. We use differnt forms of encryption and many other methods to ensure that your browsing is secure and safe. </p>
		</div>
	</div>
	<div class="info two">
		<div class="info_image_two">
			<img src="assets/imgs/imgs/fast.svg" width="200px" height="200px"/>
		</div>
		<div id="info_text_two">
			<h2> Fast </h2>
			<br/>
			<p> Unblockit.co has been working hard to make sure that all their servers are fast and up to date. This way we can ensure that you are having the best experience while being secure! </p>
		</div>
	</div>
	<div class="info three">
		<div class="info_image_three">
			<img src="assets/imgs/imgs/anon.svg" width="200px" height="200px"/>
		</div>
		<div id="info_text_three">
			<h2> Anonymous </h2>
			<br/>
			<p> Our service is focused on allowing users to browse whatever they'd like without being watched. The url's that you visit are encrypted and the title of the pages are changed in order to ensure that anyone looking through your history or maybe the connection logs are only able to see you connecting to our service and nothing that you see through our service. </p>
		</div>
	</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">

function hash_param(name){

	if(window.location.hash){
		var regex = new RegExp(name + "=([^&#]*)");
		var matches = regex.exec(window.location.hash);

		if(matches){
			return matches[1];
		}
	}

	return false;
}

function rand(min, max){
	return Math.floor(Math.random() * (max - min + 1));
}

$(document).ready(function(){

	$("#url").focus();

	$(".proxy-link").click(function(){

		var text = $(this).text().toLowerCase();

		$("#url").val('http://www.'+text);
		$("form").submit();

		return false;
	});

	$("form").submit(function(e){
		var bar = $('.url_bar');
		function ValidURL(str) {
  		var pattern = new RegExp('^(https?:\/\/)?'+ // protocol
    		'((([a-z\d]([a-z\d-]*[a-z\d])*)\.)+[a-z]{2,}|'+ // domain name
    		'((\d{1,3}\.){3}\d{1,3}))'+ // OR ip (v4) address
    		'(\:\d+)?(\/[-a-z\d%_.~+]*)*'+ // port and path
    		'(\?[;&a-z\d%_.~+=-]*)?'+ // query string
    		'(\#[-a-z\d_]*)?$','i'); // fragment locater
  		if(!pattern.test(str)) {
    		alert("Please enter a valid URL.");
    		return false;
  		} else {
    		return true;
  		}
		}
		ValidURL("bar");

		var opt = $("input[type=radio][name=location]:checked");
		$(this).attr("action", "https://" + opt.val() + "/index.php");

		return true;
	});

	// select closest server
	var locations = $("input[name=location]");
	locations.eq(rand(0, locations.length-1)).attr("checked", true);

	var url = hash_param('url');
	var error = hash_param('error');

	if(error){
		error = unescape(error);

		/*
		mixpanel.track({
			error: error
		});
		*/

		alert('Error! You probably should not link to proxy pages DIRECTLY!\r\n' + error);
	}

	if(url){

		if(url.length == 11){
			url = 'https://www.youtube.com/watch?v=' + url;
		}

		$("#url").val(url);
		$("#url").css('background-color', '#d6efff');
		//$("form").submit();
	}

});
</script>
<script>
	$(document).ready(function(){
		$('.more_btn').click(function() {
			$('#more_window').slideToggle("slow");
		});
		$('.ba_close').click(function() {
			$('over_a').fadeOut('fast')
			$('#more_window').slideToggle("slow");
		});

	});
</script>

</div>
<!-- More Window -->
<div id="more_window">
	<div id="over_back"></div>
	<div id="over_a">
		Hmm, I dont see anything D:
	</div>
</div>
</body>
</html>

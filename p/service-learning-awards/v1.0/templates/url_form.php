<head>

</head>
<link rel="stylesheet" href="assets/css/url_form.css" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script>
var url_text_selected = false;

function smart_select(ele){

	ele.onblur = function(){
		url_text_selected = false;
	};

	ele.onclick = function(){
		if(url_text_selected == false){
			this.focus();
			this.select();
			url_text_selected = true;
		}
	};
}
</script>
<div id="pushdown_unblockit">
		<i class="material-icons down_unblockit">keyboard_arrow_down</i>
	</div>
<div id="top_form_unblockit">
	<div id="pushup_unblockit">
		<i class="material-icons up_unblockit">keyboard_arrow_up</i>
	</div>
	<div style="width:600px; margin:0 auto;">
		<form method="post" action="index.php" target="_top" style="margin:0; padding:0;">
			<div onclick="window.location.href='index.php'" class="home_btn_unblockit">Home</div>
			<input class="url_bar_unblockit" type="text" name="url" value="<?php echo $url; ?>" autocomplete="off">
			<input type="hidden" name="form" value="1">
			<input class="url_submit_unblockit" type="submit" value="Go">
		</form>
	</div>
</div>
<script type="text/javascript">
	smart_select(document.getElementsByName("url")[0]);
</script>
<script>

</script>
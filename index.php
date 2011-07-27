<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>TinyBBS</title>
	<link rel="stylesheet" type="text/css" href="css.css">
	<script type="text/javascript">
		document.forms[0].style.display="block";
		function reply(parent){
			var forms=parent.parentNode.getElementsByTagName("form");
			forms[0].style.display="block";parent.style.display="none";
		}
	</script>
</head>
<body>
	<div class="forum">
	<?php require_once('tinybbs.php');?>
	</div>
</body>
</html>
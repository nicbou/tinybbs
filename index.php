<?php ob_start()?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>TinyBBS</title>
	<link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
	<div class="forum">
	<?php require_once('forum.php');new Forum();?>
	</div>
</body>
</html>
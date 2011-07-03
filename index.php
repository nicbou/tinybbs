<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>TinyBBS</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="forum">
		<?php
			require_once('forum.class.php');
			$forum=new Forum();
			if(isset($_POST['message']) && isset($_POST['parent']))
				$forum->reply($_POST['message'],$_POST['parent']);

			if(isset($_GET['id']) && is_numeric($_GET['id']) && !is_float($_GET['id']) && $_GET['id']>=0)
				$id=$_GET['id'];
			else
				$id=0;
			echo($forum->makeForum($id));
		?>
		</div>
	</body>
</html>
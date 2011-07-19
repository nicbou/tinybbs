<?php
try{session_start();}catch(Exception $ex){}
function err($no,$msg,$file,$line){
	echo("<div class='err'>".htmlentities("$msg in $file ($line)")."</div>");return true;
}
function ex($ex){
	echo("<div class='ex'>".htmlentities($ex->getMessage())."</div>");return true;
}
set_error_handler('err');
set_exception_handler('ex');
require('forum.php');
new Forum();
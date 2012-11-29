<?php //error_handler.php

function myHandler($type, $msg, $file, $line, $context) 
{
	error_log("[" . date("d-M-Y h:i:s",time()) . "] $msg on line $line of $file\n",3,"debug.log");
	return false;
}

error_reporting(E_ALL);

set_error_handler("myHandler");
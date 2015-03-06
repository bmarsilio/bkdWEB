<?php  
	session_start();
	error_reporting(E_ALL^E_NOTICE^E_DEPRECATED);
	//session_destroy();
	//unset($_SESSION);
	//die(var_dump($_SESSION[logado]));
	//$_SESSION[logado] = true;
	if(!$_SESSION[logado]){
		header('Location: login');
	}
?>
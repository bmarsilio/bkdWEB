<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Logout extends Action
{

	public function index()
	{
		$log = Container::getClass("Log");

		$dataAtual = date('Y-m-d H:i:s');
		//die(var_dump($_SESSION));
		//insere log no banco
		$sql["log"]["usuarioId"] = $_SESSION["usuarioId"];
		$sql["log"]["data"] = $dataAtual;
		$sql["log"]["tipo"] = 'S';

		$log->insert($sql["log"]);
		session_start();

		unset($_SESSION);
		session_destroy();

		header('Location: login');
	}

}
<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Login extends Action
{

	public function index()
	{
		$this->render('login',false);
	}

	public function autentica()
	{
		$autentica = Container::getClass("Login");
		//var_dump($autentica);
		$dados = $autentica->autentica($_POST);

		$log = Container::getClass("Log");

		$dataAtual = date('Y-m-d H:i:s');

		if($dados){
			$_SESSION[nome] = $dados[nome];
			$_SESSION[usuarioId] = $dados[usuarioid];
			$_SESSION[login] = $dados[login];
			$_SESSION[tipoUsuarioId] = $dados[tipousuarioid];
			
			//insere log no banco
			$sql["log"]["usuarioId"] = $dados[usuarioid];
			$sql["log"]["data"] = $dataAtual;
			$sql["log"]["tipo"] = 'E';

			$log->insert($sql["log"]);

			//die(var_dump($sql["log"]));
			header('Location: /');
		}else{
			header('Location: login');
		}
	}

}
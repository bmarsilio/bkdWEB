<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Notificacoes extends Action
{

	public function index()
	{
		
		$this->render('index');
	}


}
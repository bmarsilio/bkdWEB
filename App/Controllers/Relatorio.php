<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Relatorio extends Action
{

	public function index()
	{
		
		$this->render('relatorio');
	}

}
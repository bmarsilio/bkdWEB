<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Error404 extends Action
{

	public function index()
	{
		$this->render('error404');
	}

}
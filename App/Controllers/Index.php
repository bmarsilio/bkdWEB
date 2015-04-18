<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Index extends Action
{

	public function index()
	{
            $this->render('index');
	}

	public function empresa()
	{
            $this->render('empresa');
	}

}
<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Logout extends Action
{

	public function index()
	{
		session_start();

		unset($_SESSION);
		session_destroy();

		header('Location: login');
	}

}
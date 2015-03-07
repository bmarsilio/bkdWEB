<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Pagina extends Action
{

	public function cadpagina()
	{
		
		$this->render('cadpagina');
	}
        
        public function cadjornaiseditais()
	{
		
		$this->render('cadjornaiseditais');
	}


}
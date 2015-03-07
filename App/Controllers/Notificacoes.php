<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Notificacoes extends Action
{

	public function pagina()
	{           
            $this->render('paginas');
	}
        
        public function jornalEdital(){
            $this->render('jornaisEditais');
        }


}
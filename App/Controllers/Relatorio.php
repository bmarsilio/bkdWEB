<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Relatorio extends Action
{

	public function index()
	{
		
	}

	public function relatorioLog()
	{
		$relatorio = Container::getClass('Relatorio');
		if($_POST[dtInicial] && $_POST[dtFinal]){	
			$this->view->dados = $relatorio->relatorioLogAcesso($_POST[dtInicial],$_POST[dtFinal]);
		}
		
		$this->render('relatorioLog');
	}

}
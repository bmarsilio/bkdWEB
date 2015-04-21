<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Notificacoes extends Action
{

	public function pagina()
	{
		$Notificacao = Container::getClass('Notificacao');
		if(!$_POST['dtFiltroPagina']){
			$data = date('d-m-Y');
		}else{
			$data = $_POST['dtFiltroPagina'];
		}
		$this->view->notificacoesNaoVistas = $Notificacao->buscarPorData($data,'is null','P');
		$this->view->notificacoesVistas = $Notificacao->buscarPorData($data,'is not null','P');
		
		$this->view->badgeNaoVistas = $Notificacao->buscarPorData($data,'is null','P');
		$this->view->badgeVistas = $Notificacao->buscarPorData($data,'is not null','P');
		
		$this->render('paginas');
	}

	public function atualizaDtClickNotificacao(){
		$Notificacao = Container::getClass('Notificacao');
		$Notificacao->marcarNotificacaoComoLida($_POST[notificacao]);
	}

	public function jornalEdital()
	{
		$Notificacao = Container::getClass('Notificacao');
		if(!$_POST['dtFiltroJornalEdital']){
			$data = date('d-m-Y');
		}else{
			$data = $_POST['dtFiltroJornalEdital'];
		}

		$this->view->notificacoesNaoVistas = $Notificacao->buscarPorData($data,'is null','JE');
		$this->view->notificacoesVistas = $Notificacao->buscarPorData($data,'is not null','JE');
		
		$this->view->badgeNaoVistas = $Notificacao->buscarPorData($data,'is null','JE');
		$this->view->badgeVistas = $Notificacao->buscarPorData($data,'is not null','JE');

		$this->render('jornaisEditais');
	}

}
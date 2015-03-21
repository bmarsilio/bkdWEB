<?php

namespace App;

use SON\Init\Bootstrap;

class Init extends Bootstrap
{

	public function initRoutes()
	{
		# menus principais
		$ar['home'] = array('route'=>'/','controller'=>'index','action'=>'index');
                $ar['notificacoes-paginas'] = array(
                    'route' => '/notificacoes-paginas',
                    'controller' => 'notificacoes',
                    'action' => 'pagina'
                );
                $ar['notificacoes-jornaiseditais'] = array(
                    'route' => '/notificacoes-jornais-editais',
                    'controller' => 'notificacoes',
                    'action' => 'jornaledital'
                );

		# funcionalidades de login e logout
		$ar['login'] = array('route'=>'/login','controller'=>'login','action'=>'index');
		$ar['autentica'] = array('route'=>'/autentica','controller'=>'login','action'=>'autentica');
		$ar['logout'] = array('route'=>'/logout','controller'=>'logout','action'=>'index');

		#cadastros
                $ar['pagina'] = array( 
                    'route' => '/pagina',
                    'controller' => 'Pagina',
                    'action' => 'cadpagina'
                );
                
                $ar['jornaiseditais'] = array(
                    'route' => '/jornaiseditais',
                    'controller' => 'Pagina',
                    'action' => 'cadjornaiseditais'
                );
		#baixar lancamentos
		
		#relatorio
        $ar['relatorio'] = array('route'=>'/relatorio','controller'=>'relatorio','action'=>'index');
        
		$this->setRoutes($ar);
	}

}


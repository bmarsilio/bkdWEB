<?php

namespace App;

use SON\Init\Bootstrap;

class Init extends Bootstrap
{

	public function initRoutes()
	{
		# menus principais
		$ar['home'] = array('route'=>'/','controller'=>'index','action'=>'index');
                $ar['notificacoes'] = array(
                    'route' => '/notificacoes',
                    'controller' => 'notificacoes',
                    'action' => 'index'
                );

		# funcionalidades de login e logout
		$ar['login'] = array('route'=>'/login','controller'=>'login','action'=>'index');
		$ar['autentica'] = array('route'=>'/autentica','controller'=>'login','action'=>'autentica');
		$ar['logout'] = array('route'=>'/logout','controller'=>'logout','action'=>'index');

		#cadastros
                $ar['pagina'] = array( 
                    'route' => '/pagina',
                    'controller' => 'Pagina',
                    'action' => 'index'
                );
		#baixar lancamentos
			
		$this->setRoutes($ar);
	}

	public static function getDb()
	{

		$db = new \PDO("pgsql:host=localhost;dbname=bkdwebdev","postgres","123456");

		return $db;
	}

}


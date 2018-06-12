<?php

namespace SON\Init;

abstract class Bootstrap
{

	private $routes;

	public function __construct()
	{
		$this->initRoutes();
		$this->run($this->getUrl());
	}

	abstract protected function initRoutes();

	protected function run($url)
	{
		#forma antiga de testar as rotas, estava dando problema com o Error404 - Page Not Found
		/*
		array_walk($this->routes, function($route) use($url){
			if($url == $route['route']){
				$class = "App\\Controllers\\".ucfirst($route['controller']);
				$controller = new $class;
				$controller->$route['action']();
			}
		});
		*/

		#default grava false, se encontrar a rota, troca para true
		$return = false;

		foreach ($this->routes as $key) {
			if($url == $key['route']){
				$class = "App\\Controllers\\".ucfirst($key['controller']);
                $controller = new $class;
                $action = $key['action'];
				$controller->$action();

				$return = true;

			}
		}

		# se nao tiver encontrado nenhuma rota, da erro de 'pagina nao encontrada'
		if(!$return){
			$class = "App\\Controllers\\Error404";
			$controller = new $class;
			$controller->index();
		}
	}

	protected function setRoutes(array $routes)
	{
		$this->routes = $routes;
	}

	protected function getUrl()
	{
		return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
	}

}
<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Pagina extends Action
{

	public function cadpagina()
	{
            $pagina = Container::getClass('Pagina');
            $this->paginas = $pagina->listarPaginas();
            
            $this->render('cadpagina');
	}

        
        public function cadjornaiseditais()
	{
		
		$this->render('cadjornaiseditais');
	}
        
        public function add()
        {   
            unset($_POST['pagina']['paginaid']);
            
            $pagina = Container::getClass("Pagina");
            $pagina->insert($_POST['pagina']);
            
            header("Location: /pagina");
        }
        
        public function edit()
        {
            $_POST['pagina']['id_key'] = 'paginaid';
            $_POST['pagina']['id'] = $_POST['pagina']['paginaid'];
            
            unset($_POST['pagina']['paginaid']);
            
            $pagina = Container::getClass('Pagina');
            $pagina->update($_POST['pagina']);
            
            header("Location: /pagina");
        }


}
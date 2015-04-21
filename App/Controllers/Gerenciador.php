<?php

namespace App\Controllers;

use App\Utils\Curl;
use SON\Controller\Action;
use SON\Di\Container;

class Gerenciador extends Action
{
    
    public function index()
    {
        
        if($_SESSION[tipoUsuarioId] == 1) {
            $this->view->msg = "Gerenciando alterações de páginas";
            $this->gerenciaPaginas();
        } else {
            $this->view->msg = "Você não possui autorização a este módulo";
        }
        
        $this->render('index');
    }
    
    public function gerenciaPaginas()
    {
        $paginaModel = Container::getClass('pagina');
        $curl = new Curl();
        
        $paginas = $paginaModel->listarTodos();
        
        foreach($paginas as $pagina){
            $html = $curl->coletarHTML($pagina->getLink());
            $pagina->gerenciarAlteracoes($html);
        }
    }
    
}

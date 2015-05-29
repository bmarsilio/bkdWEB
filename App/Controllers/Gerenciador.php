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
        try {
        
            $paginaModel = Container::getClass('pagina');
            $curl = new Curl();

            $paginas = $paginaModel->listarPaginasAutorizadas();

            foreach($paginas as $pagina){

                if( $pagina->getCountReload() == $pagina->getReload() ) {
                    $html = $curl->coletarHTML($pagina->getLink());
                    $pagina->gerenciarAlteracoes($html);
                    $pagina->setCountReload(0);
                } else {
                    $pagina->setCountReload( $pagina->getCountReload() + 1 );
                }

                $pagina->alterar();
            }
        } catch(Exception $e) {
            
            $this->gerenciaPaginas();
            
        }
    }
    
}

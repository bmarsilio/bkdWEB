<?php

namespace App\Controllers;

use App\Utils\Curl;
use SON\Controller\Action;
use SON\Di\Container;

class Gerenciador extends Action {

    public function index() {
        
        if ($_SESSION[tipoUsuarioId] == 1) {
            $this->view->msg = "Gerenciando alterações de páginas";
            //$this->gerenciaPaginas();
            //$this->cmdGerenciador();
        } else {
            $this->view->msg = "Você não possui autorização a este módulo";
        }

        $this->render('index');
    }

    public function gerenciaPaginas() {
        try {

            $paginaModel = Container::getClass('pagina');
            $curl = new Curl();

            $paginas = $paginaModel->listarPaginasAutorizadas();

            foreach ($paginas as $pagina) {
                sleep(0.5);
                if ($pagina->getCountReload() == $pagina->getReload()) {
                    $html = $curl->lerHTML($pagina->getLink());
                    $pagina->gerenciarAlteracoes($html);
                    $pagina->setCountReload(0);
                } else {
                    $pagina->setCountReload($pagina->getCountReload() + 1);
                }

                $pagina->alterar();
                flush();
            }
        } catch (\PDOException $e) {
            echo 'O Gerenciador Parou '.__DIR__;
            error_log('Erro: '. date('d-m-Y') .' - '. date('h:i:s') .' -> '.$e->getMessage()."\n", 3, __DIR__.'\error_'.date('d-m-Y').'.log');
        } catch (\Exception $e) {
            echo 'Erro no gerenciador';
            error_log('Erro: '. date('d-m-Y') .' - '. date('h:i:s') .' -> '.$e->getMessage()."\n", 3, __DIR__.'\error_'.date('d-m-Y').'.log');
        }
    }

    public function cmdGerenciador(){

        try{
	    
	    if (substr(php_uname(), 0, 7) == "Windows"){
            $cmd = 'start /B php '.__DIR__.'/../Commands/GerenciadorPaginas.php > BufferGerenciadorPaginas-'. date('d-m-Y') .'.txt &';
            pclose(popen($cmd,'r'));
	    }else{

            $cmd = 'killall php';
            shell_exec($cmd);

    		$cmd = 'php '.__DIR__.'/../Commands/GerenciadorPaginas.php > BufferGerenciadorPaginas-'. date('d-m-Y') .'.txt &';
    		shell_exec($cmd);

	    }

        }catch(\PDOException $e){
            echo 'O Gerenciador Parou '.__DIR__;
            error_log('Erro: '. date('d-m-Y') .' - '. date('h:i:s') .' -> '.$e->getMessage()."\n", 3, __DIR__.'\error_'.date('d-m-Y').'.log');
        }catch(\Exception $e){
            echo 'O Gerenciador Parou '.__DIR__;
            error_log('Erro: '. date('d-m-Y') .' - '. date('h:i:s') .' -> '.$e->getMessage()."\n", 3, __DIR__.'\error_'.date('d-m-Y').'.log');
        }
    }

}

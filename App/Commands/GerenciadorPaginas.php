<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

try{

    ignore_user_abort(true);
    set_time_limit(0);

    require (__DIR__.'/../../vendor/SON/Db/Table.php');
    require (__DIR__.'/../../vendor/SON/Di/Container.php');
    require (__DIR__.'/../business.php');
    require (__DIR__.'/../Models/Pagina.php');
    require (__DIR__.'/../Models/Notificacao.php');
    require (__DIR__.'/../Utils/Curl.php');


    $curl = new \App\Utils\Curl();
    $db = new \PDO("pgsql:host=192.168.33.11;dbname=bkdweb", "postgres", "123456");


    $paginaModel = new App\Models\Pagina($db);

    echo '--> '.date('d-m-Y').' - '.date('h:i:s')." Iniciando Gerenciador \n <br />";

    while(true){

    	$paginas = $paginaModel->listarPaginasAutorizadas();

		foreach ($paginas as $pagina) {

			echo '--> '.date('d-m-Y').' - '.date('h:i:s').' Verificando Página '. $pagina->getPaginaId() .' | '. $pagina->getDescricao() ." \n <br />";

        	sleep(0.5);
        	if ($pagina->getCountReload() == $pagina->getReload()) {
            		$html = $curl->lerHTML($pagina->getLink(), $pagina->getFiltrarHtml());
            		$pagina->gerenciarAlteracoes($html);
            		$pagina->setCountReload(0);
        	} else {
            		$pagina->setCountReload($pagina->getCountReload() + 1);
        	}

        	$pagina->alterar();
    	}

		flush();
		sleep(1);

    }



}catch (\PDOException $e) {
    echo 'Erro no Gerênciador:  ';
    echo ('Erro: '. date('d-m-Y') .' - '. date('h:i:s') .' -> '.$e->getMessage()." <br /> \n");
} catch (\Exception $e) {
    echo 'Erro no Gerenciador';
    echo ('Erro: '. date('d-m-Y') .' - '. date('h:i:s') .' -> '.$e->getMessage()." <br /> \n");
}


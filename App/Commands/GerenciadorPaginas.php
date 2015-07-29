<?php
session_start();

ignore_user_abort(true);
set_time_limit(26000);

require (__DIR__.'/../../Vendor/SON/Db/Table.php');
require (__DIR__.'/../../Vendor/SON/Di/Container.php');
require (__DIR__.'/../business.php');
require (__DIR__.'/../Models/Pagina.php');
require (__DIR__.'/../Models/Notificacao.php');
require (__DIR__.'/../Utils/Curl.php');


$curl = new \App\Utils\Curl();
$db = new \PDO("pgsql:host=localhost;dbname=bkdwebdev", "postgres", "123456");
//while (1) {

    $paginaModel = new App\Models\Pagina($db);
    
    
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
    }
//}

session_write_close();
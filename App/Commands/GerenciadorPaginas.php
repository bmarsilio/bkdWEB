<?php

require ('../../Vendor/SON/Db/Table.php');
require ('../../Vendor/SON/Di/Container.php');
require ('../business.php');
require ('../Models/Pagina.php');
require ('../Models/Notificacao.php');
require ('../Utils/Curl.php');


ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
//524
while (1) {



    $db = new \PDO("pgsql:host=localhost;dbname=bkdwebdev", "postgres", "123456");

    $paginaModel = new App\Models\Pagina($db);
    $curl = new \App\Utils\Curl();

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
}

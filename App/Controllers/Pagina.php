<?php

namespace App\Controllers;

use SON\Controller\Action;
use SON\Di\Container;

class Pagina extends Action {

    public function cadpagina() {
        $pagina = Container::getClass('Pagina');
        $this->view->paginas = $pagina->listarPaginas();

        if ($_GET['paginaId']) {
            $paginaSelecionada = $pagina->buscarPorId($_GET['paginaId']);
            $this->view->pagina = $paginaSelecionada;
        }

        $this->render('cadpagina');
    }

    public function cadjornaiseditais() {
        $pagina = Container::getClass('Pagina');
        $this->view->paginas = $pagina->listarJornaisEditais();

        if ($_GET['paginaId']) {
            $paginaSelecionada = $pagina->buscarPorId($_GET['paginaId']);
            $this->view->pagina = $paginaSelecionada;
        }

        $this->render('cadjornaiseditais');
    }

    public function add() {
        unset($_POST['pagina']['paginaid']);

        $pagina = Container::getClass("Pagina");
        $pagina->insert($_POST['pagina']);

        if (!$_POST['pagina']['ativo']) {
            $_POST['pagina']['ativo'] = 'f';
        }

        if ($_POST['pagina']['tipo'] == 'P') {
            header("Location: /pagina");
        } else {
            header("Location: /jornaiseditais");
        }
    }

    public function edit() {
        $_POST['pagina']['id_key'] = 'paginaid';
        $_POST['pagina']['id'] = $_POST['pagina']['paginaid'];

        unset($_POST['pagina']['paginaid']);

        if (!$_POST['pagina']['ativo']) {
            $_POST['pagina']['ativo'] = 'f';
        }

        $pagina = Container::getClass('Pagina');
        $pagina->update($_POST['pagina']);

        if ($_POST['pagina']['tipo'] == 'P') {
            header("Location: /pagina");
        } else {
            header("Location: /jornaiseditais");
        }
    }

}

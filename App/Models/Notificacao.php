<?php
namespace App\Models;

use SON\Db\Table;
use SON\Di\Container;

class Notificacao extends Table
{
    
    protected $table = "notificacao";
    
    private $notificacaoId;
    private $paginaId;
    private $data;
    private $hora;
    private $dtClick;
    private $palavraEncontrada;
    
    
    function getNotificacaoId() {
        return $this->notificacaoId;
    }

    function getPaginaId() {
        return $this->paginaId;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getDtClick() {
        return $this->dtClick;
    }

    function getPalavraEncontrada() {
        return $this->palavraEncontrada;
    }

    function setNotificacaoId($notificacaoId) {
        $this->notificacaoId = $notificacaoId;
        return $this;
    }

    function setPaginaId($paginaId) {
        $this->paginaId = $paginaId;
        return $this;
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

    function setHora($hora) {
        $this->hora = $hora;
        return $this;
    }

    function setDtClick($dtClick) {
        $this->dtClick = $dtClick;
        return $this;
    }

    function setPalavraEncontrada($palavraEncontrada) {
        $this->palavraEncontrada = $palavraEncontrada;
        return $this;
    }

    function setNotificacao($notificacao){
            $notificacaoObject = Container::getClass('notificacao');
                
            $notificacaoObject
                    ->setBusca($notificacao['busca'])
                    ->setDescricao($notificacao['descricao'])
                    ->setHtmlAtual($notificacao['html'])
                    ->setLink($notificacao['link'])
                    ->setPaginaId($notificacao['paginaid'])
                    ->setTipo($notificacao['tipo']);
            
            return $notificacaoObject;
                
    }
    
    function novaNotificacao(Pagina $pagina){
        $notificacao['paginaid'] = $pagina->getPaginaId();
        $notificacao['data'] = date('Y-m-d');
        $notificacao['hora'] = date('H:m:s');
        $notificacao['palavraencontrada'] = $pagina->getBusca();
        $this->insert($notificacao);
    }
}

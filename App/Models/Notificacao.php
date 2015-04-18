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
                    ->setNotificacaoId($notificacao['notificacaoid'])
                    ->setPaginaId($notificacao['paginaid'])
                    ->setData($notificacao['data'])
                    ->setHora($notificacao['hora'])
                    ->setDtClick($notificacao['dtclick'])
                    ->setPalavraEncontrada($notificacao['palavraencontrada']);
            
            return $notificacaoObject;
                
    }
    
    function novaNotificacao(Pagina $pagina){
        $notificacao['paginaid'] = $pagina->getPaginaId();
        $notificacao['data'] = date('Y-m-d');
        $notificacao['hora'] = date('H:m:s');
        $notificacao['palavraencontrada'] = $pagina->getBusca();
        $this->insert($notificacao);
    }
    
    public function buscarPorNotificacaoId($notificacaoId)
    {
        $sql = ' SELECT * FROM notificacao WHERE notificacaoId = '.$notificacaoId;
        return $this->db->query($sql)->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function marcarNotificacaoComoLida($notificacaoId)
    {
        $notificacao = $this->buscarPorNotificacaoId($notificacaoId);        
        $notificacao = $this->setNotificacao($notificacao);
        $notificacao->setDtClick(date('Y-m-d'));
        return $notificacao->update();
    }
    
    public function toArray()
    {
        $notificacao['notificacaoid'] = $this->notificacaoId;
        $notificacao['paginaId'] = $this->paginaId;
        $notificacao['hora'] = $this->hora;
        $notificacao['data'] = $this->data;
        $notificacao['dtclick'] = $this->dtClick;
        $notificacao['palavraencontrada'] = $this->palavraEncontrada;
        return $notificacao;
        
    }
    
    public function update(array $data=null)
    {
        $notificacao = $this->toArray();
        $data = $notificacao;
        $data['id_key'] = 'notificacaoId';
        $data['id'] = $notificacao['notificacaoid'];
        unset($data['notificacaoid']);
        
        parent::update($data);
        return $data;
    }
}

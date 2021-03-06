<?php

namespace App\Models;

use SON\Db\Table;
use SON\Di\Container;

class Notificacao extends Table {

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

    function setNotificacao($notificacao) {
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

    function novaNotificacao(Pagina $pagina, $palavraEncontrada = null) {
        if($this->checkNotificacoesVisualizadas($pagina)) {
            $notificacao['paginaid'] = $pagina->getPaginaId();
            $notificacao['data'] = date('Y-m-d');
            $notificacao['hora'] = date('H:m:s');

            if($palavraEncontrada == null){
                $notificacao['palavraencontrada'] = $pagina->getBusca();
            }else{
                $notificacao['palavraencontrada'] = $palavraEncontrada;
            }


            $this->insert($notificacao);
        }
    }

    public function checkNotificacoesVisualizadas(Pagina $pagina)
    {
        $this->connect();
        $sql = "select
                    count(*)
                from
                    notificacao
                where
                    data = current_date
                    and dtClick is null
                    and paginaId = ". $pagina->getPaginaId();

        $result = $this->db->query($sql)->fetch(\PDO::FETCH_ASSOC);
        $this->disconnect();
        if($result['count'] > 0) {
            return false;
        }

        return true;
    }

    public function buscarPorNotificacaoId($notificacaoId) {
        $this->connect();
        $sql = ' SELECT * FROM notificacao WHERE notificacaoId = ' . $notificacaoId;
        $result = $this->db->query($sql)->fetch(\PDO::FETCH_ASSOC);
        $this->disconnect();
        return $result;
    }

    public function buscarPorData($data, $dtClick, $tipo) {
        $this->connect();
        $sql = "
				SELECT 
					A.notificacaoId,
					B.descricao,
					B.link,
					A.palavraEncontrada,
					A.data,
					A.hora,
					A.dtClick,
					(
						SELECT
							count(*)
						FROM
							notificacao X
						WHERE
							X.data = A.data
							AND X.dtClick " . $dtClick . "
					) as badge
				FROM 
					notificacao A
					INNER JOIN pagina B ON (B.paginaId = A.paginaId)
        		WHERE 
        			A.data = '" . $data . "'
        			and A.dtClick " . $dtClick . "
        			and b.tipo = '" . $tipo . "'
        		ORDER BY
        			A.notificacaoid
        ";
        //print("<pre>".$sql."</pre>");
        $result = $this->db->query($sql);
        $this->disconnect();
        return $result;
    }

    public function marcarNotificacaoComoLida($notificacaoId) {
        $notificacao = $this->buscarPorNotificacaoId($notificacaoId);
        $notificacao = $this->setNotificacao($notificacao);
        $notificacao->setDtClick(date('Y-m-d'));
        return $notificacao->update();
    }

    public function toArray() {
        $notificacao['notificacaoid'] = $this->notificacaoId;
        $notificacao['paginaId'] = $this->paginaId;
        $notificacao['hora'] = $this->hora;
        $notificacao['data'] = $this->data;
        $notificacao['dtclick'] = $this->dtClick;
        $notificacao['palavraencontrada'] = $this->palavraEncontrada;
        return $notificacao;
    }

    public function update(array $data = null) {
        $notificacao = $this->toArray();
        $data = $notificacao;
        $data['id_key'] = 'notificacaoId';
        $data['id'] = $notificacao['notificacaoid'];
        unset($data['notificacaoid']);

        parent::update($data);
        return $data;
    }

}

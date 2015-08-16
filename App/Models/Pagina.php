<?php

namespace App\Models;

use SON\Db\Table;
use App\Models\Notificacao;
use SON\Di\Container;

class Pagina extends Table {

    protected $table = "pagina";
    private $paginaId;
    private $descricao;
    private $link;
    private $busca;
    private $htmlAtual;
    private $tipo;
    private $notificacoes;
    private $ativo;
    private $reload;
    private $countReload;

    function __construct() {
        //parent::__construct($db);
    }

    function getPaginaId() {
        return $this->paginaId;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getLink() {
        return $this->link;
    }

    function getBusca() {
        return $this->busca;
    }

    function getHtmlAtual() {
        return $this->htmlAtual;
    }

    function setPaginaId($paginaId) {
        $this->paginaId = $paginaId;
        return $this;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
        return $this;
    }

    function setLink($link) {
        $this->link = $link;
        return $this;
    }

    function setBusca($busca) {
        $this->busca = $busca;
        return $this;
    }

    function setHtmlAtual($htmlAtual) {
        $this->htmlAtual = $htmlAtual;
        return $this;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    function getAtivo() {
        return $this->ativo;
    }

    function setAtivo($ativo) {
        $this->ativo = $ativo;
        return $this;
    }

    function getNotificacoes() {
        return $this->notificacoes;
    }

    function setNotificacoes(array $notificacoes) {
        $this->notificacoes = $notificacoes;
        return $this;
    }

    function getCountReload() {
        return $this->countReload;
    }

    function setCountReload($countReload) {
        $this->countReload = $countReload;
        return $this;
    }

    function getReload() {
        return $this->reload;
    }

    function setReload($reload) {
        $this->reload = $reload;
        return $this;
    }

    function setPagina(array $pagina) {
        $paginaObject = Container::getClass('pagina');

        $paginaObject
                ->setBusca($pagina['busca'])
                ->setDescricao($pagina['descricao'])
                ->setHtmlAtual($pagina['htmlatual'])
                ->setLink($pagina['link'])
                ->setPaginaId($pagina['paginaid'])
                ->setTipo($pagina['tipo'])
                ->setAtivo($pagina['ativo'])
                ->setCountReload($pagina['countreload'])
                ->setReload($pagina['reload']);

        return $paginaObject;
    }

    function toArray() {
        $pagina['paginaid'] = $this->getPaginaId();
        $pagina['descricao'] = $this->getDescricao();
        $pagina['link'] = $this->getLink();
        $pagina['busca'] = $this->getBusca();
        $pagina['htmlatual'] = $this->getHtmlAtual();
        $pagina['tipo'] = $this->getTipo();
        $pagina['ativo'] = $this->getAtivo();
        $pagina['countreload'] = $this->getCountReload();
        $pagina['reload'] = $this->getReload();

        return $pagina;
    }

    function listarPaginas() {
        $this->connect();
        $sql = "SELECT * FROM pagina WHERE tipo = 'P' ORDER BY ativo DESC, paginaId";

        $result = $this->db->query($sql);
        $this->disconnect();
        return $result;
    }

    function listarJornaisEditais() {

        $this->connect();

        $sql = "SELECT * FROM pagina WHERE tipo = 'JE' ORDER BY ativo DESC ,paginaId";

        $result = $this->db->query($sql);

        $this->disconnect();

        return $result;
    }

    function listarTodos() {
        $sql = "SELECT * FROM pagina WHERE ativo is true";
        $paginas = $this->db->query($sql);

        foreach ($paginas as $pagina) {
            $paginasObjects[] = $this->setPagina($pagina);
        }

        return $paginasObjects;
    }

    public function listarPaginasAutorizadas() {
        $this->connect();
        $sql = "
                SELECT 
                    * 
                FROM 
                    pagina 
                WHERE 
                    ativo is true 
                    AND countreload = (
                        SELECT
                                min(countreload)
                        from
                                pagina
                        where
                                ativo is true
                        )
                ORDER BY
                    countReload";
        $paginas = $this->db->query($sql);

        foreach ($paginas as $pagina) {
            $paginasObjects[] = $this->setPagina($pagina);
        }
        
        $this->disconnect();
        
        return $paginasObjects;
    }

    function buscarPorId($paginaId) {
        $this->connect();
        $sql = "SELECT * FROM pagina where paginaId = $paginaId";
        return $this->db->query($sql)->fetch(\PDO::FETCH_ASSOC);
        $this->disconnect();
    }

    function compararHTML($html) {
        if (strcmp($this->htmlAtual, $html) != 0) {
            return true;
        } else {
            return false;
        }
    }

    function abrirArquivoHtmlAtual($paginaId) {
        if (file_exists(__DIR__ . '/../sites/pagina_' . $paginaId . '.txt')) {
            $html = file_get_contents(__DIR__ . '/../sites/pagina_' . $paginaId . '.txt');
            return $html;
        } else {
            $file = fopen(__DIR__ . '/../sites/pagina_' . $paginaId . '.txt', 'w+');
            fclose($file);
            $html = file_get_contents(__DIR__ . '/../sites/pagina_' . $paginaId . '.txt');
            return $html;
        }
    }

    function encontrarPalavraChave($palavraChave, $html) {
        if (strstr($html, $palavraChave)) {
            return true;
        } else {
            return false;
        }
    }

    public function atualizarHtmlAtual($html, $paginaId) {
        $file = fopen(__DIR__ . '/../sites/pagina_' . $paginaId . '.txt', 'w+');
        flock($file, LOCK_EX);
        fwrite($file, $html);
        flock($file, LOCK_UN);
        fclose($file);
    }

    public function novaNotificacao($html, $palavraChave) {
        if ($this->compararHTML($html) && $this->encontrarPalavraChave($palavraChave, $html)) {
            $notificacao = Container::getClass('notificacao');
            $notificacao->setPalavraEncontrada($palavraChave);
            $notificacao->novaNotificacao($this,$palavraChave);
            $this->atualizarHtmlAtual($html, $this->paginaId);
            return true;
        }else{
            return false;
        }
    }

    public function gerenciarAlteracoes($html) {
        $palavrasChaves = explode(';', $this->busca);
        $this->htmlAtual = $this->abrirArquivoHtmlAtual($this->paginaId);
        if (is_array($palavrasChaves)) {
            foreach ($palavrasChaves as $palavraChave) {
                if($this->novaNotificacao($html, $palavraChave) == true){
                    return;
                }
            }
        } else {
            $this->novaNotificacao($html, $this->busca);
        }
    }

    public function alterar() {
        $pagina = $this->toArray();
        $pagina['id_key'] = 'paginaid';
        $pagina['id'] = $pagina['paginaid'];
        unset($pagina['htmlatual']);
        return parent::update($pagina);
    }

}

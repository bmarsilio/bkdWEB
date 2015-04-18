<?php

namespace App\Models;

use SON\Db\Table;
use App\Models\Notificacao;
use SON\Di\Container;

class Pagina extends Table
{	
	protected $table = "pagina";
        
        private $paginaId;
        private $descricao;
        private $link;
        private $busca;
        private $htmlAtual;
        private $tipo;
        private $notificacoes;
        private $ativo;
        
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

        
        function setPagina(array $pagina){
            $paginaObject = Container::getClass('pagina');
                
            $paginaObject
                    ->setBusca($pagina['busca'])
                    ->setDescricao($pagina['descricao'])
                    ->setHtmlAtual($pagina['htmlatual'])
                    ->setLink($pagina['link'])
                    ->setPaginaId($pagina['paginaid'])
                    ->setTipo($pagina['tipo'])
                    ->setAtivo($pagina['ativo']);
            
            return $paginaObject;
                
        }
        
        function toArray(){
            $pagina['paginaid'] = $this->getPaginaId();
            $pagina['descricao'] = $this->getDescricao();
            $pagina['link'] = $this->getLink();
            $pagina['busca'] = $this->getBusca();
            $pagina['htmlatual'] = $this->getHtmlAtual();
            $pagina['tipo'] = $this->getTipo();
            $pagina['ativo'] = $this->getAtivo();
            return $pagina;
        }
                
        function listarPaginas(){

            $sql = "SELECT * FROM pagina WHERE tipo = 'P' ORDER BY ativo DESC, paginaId";

            return $this->db->query($sql);
            
        }
        
        function listarJornaisEditais(){

            $sql = "SELECT * FROM pagina WHERE tipo = 'JE' ORDER BY ativo DESC ,paginaId";

            return $this->db->query($sql);
            
        }
        
        function listarTodos(){
            $sql = "SELECT * FROM pagina WHERE ativo is true";
            $paginas = $this->db->query($sql);
            
            foreach($paginas as $pagina){
                $paginasObjects[] = $this->setPagina($pagina);
            }
            
            return $paginasObjects;
            
        }
        
        function buscarPorId($paginaId){
            $sql = "SELECT * FROM pagina where paginaId = $paginaId";
            return $this->db->query($sql)->fetch(\PDO::FETCH_ASSOC);
        }
        
        function compararHTML($html){
            if(strcmp($this->htmlAtual, $html) != 0 ) {
                return true;
            } else {
                return false;
            }
        }
        
        function abrirArquivoHtmlAtual($paginaId){
            if(file_exists(__DIR__.'/../sites/pagina_'.$paginaId.'.html')){
                $html = file_get_contents(__DIR__.'/../sites/pagina_'.$paginaId.'.html');
                return $html;
            }else{
                $file = fopen(__DIR__.'/../sites/pagina_'.$paginaId.'.html', 'a');
                fclose($file);
                $html = file_get_contents(__DIR__.'/../sites/pagina_'.$paginaId.'.html');
                return $html;
            }
            
            
        }
        
        function encontrarPalavraChave($palavraChave, $html){
            if(strstr($html, $palavraChave)) {
                return true;
            } else {
                return false;
            }
        }
        
        public function atualizarHtmlAtual($html, $paginaId){
            $file = fopen(__DIR__.'/../sites/pagina_'.$paginaId.'.html', 'r+');
            fwrite($file, $html);
            fclose($file);
        }
        
        public function novaNotificacao($html , $palavraChave){
            if($this->compararHTML($html) && $this->encontrarPalavraChave($palavraChave, $html)) {
                $notificacao = Container::getClass('notificacao');
                $notificacao->novaNotificacao($this);
                $this->atualizarHtmlAtual($html, $this->paginaId);
            }
        }
                
        public function gerenciarAlteracoes($html){
            $palavrasChaves = explode(';', $this->busca);
            $this->htmlAtual = $this->abrirArquivoHtmlAtual($this->paginaId);
            if(is_array($palavrasChaves)) {
                foreach($palavrasChaves as $palavraChave) {
                    $this->novaNotificacao($html, $palavraChave);
                }
            } else {
                $this->novaNotificacao($html, $this->busca);
            }
        }
        
}
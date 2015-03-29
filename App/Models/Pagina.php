<?php

namespace App\Models;

use SON\Db\Table;

class Pagina extends Table
{	
	protected $table = "pagina";
        
        private $paginaId;
        private $descricao;
        private $link;
        private $busca;
        private $htmlAtual;
        
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

        function listarPaginas(){

        $sql = "SELECT * FROM pagina ORDER BY paginaId";

	return $this->db->query($sql);
            
        }
        
        function buscarPorId($paginaId){
            $sql = "SELECT * FROM pagina where paginaId = $paginaId";
            return $this->db->query($sql)->fetch(\PDO::FETCH_ASSOC);
        }

}
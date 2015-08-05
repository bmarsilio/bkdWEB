<?php

namespace App\Models;

use SON\Db\Table;
use App\Models\Notificacao;
use SON\Di\Container;

class Relatorio extends Table
{	
	function relatorioLogAcesso($dtInicial,$dtFinal){

        $this->connect();

		$sql = "
			SELECT 
				B.nome,
				C.descricao as tipoUsuario,
				CASE
					WHEN A.tipo = 'E' THEN 'Entrada'
					WHEN A.tipo = 'S' THEN 'Saída'
				END as tipo,
				A.data
			FROM 
				log A
				INNER JOIN usuario B ON (B.usuarioId = A.usuarioId)
				INNER JOIN tipoUsuario C ON (C.tipoUsuarioId = B.tipoUsuarioId)
			WHERE
				A.data BETWEEN '".$dtInicial." 00:00:00' AND '".$dtFinal." 23:59:59'
			ORDER BY
				A.data
		";

        $resultado = $this->db->query($sql);

        $this->disconnect();

		return $resultado;

	}

}
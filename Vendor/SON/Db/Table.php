<?php

namespace SON\Db;

abstract class Table
{
	protected $db;
	protected $table;

	public function __construct(\PDO $db)
	{
		$this->db = $db;
	}

	public function fetchAll()
	{
		$sql = "SELECT * FROM {$this->table}";

		return $this->db->query($sql);
	}

	public function find($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE ID =: id");
		$stmt->bindParam(":id",$id);
		$stmt->execute();

		$res = $stmt->fetch();

		return $res;
	}

	public function autentica($dados)
	{
		$senha = md5($dados[senha]);
		$sql = "
				SELECT 
					A.usuarioId,
					A.nome,
					A.ativo,
					A.login,
					B.descricao as tipoUsuario,
					B.tipoUsuarioId as tipoUsuarioId
				FROM 
					{$this->table} A
					inner join tipoUsuario B on (B.tipoUsuarioId = A.tipoUsuarioId)
				WHERE
					A.login = '$dados[usuario]'
					AND A.senha = '$senha'
					AND A.ativo = '1'
		";
		/*
		print("<pre>".$sql."</pre>");
		die();
		*/
		$consulta = $this->db->prepare($sql);
		$consulta->execute();

		$resultSet = $consulta->fetch();

		return $resultSet;
	}
}
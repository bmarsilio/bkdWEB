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
		$sql = "
				SELECT 
					usuarioId,
					nome,
					ativo,
					login 
				FROM 
					{$this->table} 
				WHERE
					login = '$dados[usuario]'
					AND senha = '$dados[senha]'
					AND ativo = '1'
		";
		$consulta = $this->db->prepare($sql);
		$consulta->execute();

		$resultSet = $consulta->fetch();

		return $resultSet;
	}
}
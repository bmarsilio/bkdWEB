<?php

namespace SON\Db;

abstract class Table {

    protected $db;
    protected $table;

    public function __construct(\PDO $db) {
        //$this->db = $db;
        $this->db = null;
    }

    protected function connect() {
        $this->db = new \PDO("mysql:host=localhost;dbname=bkdwebdev", "root", "");
    }

    protected function disconnect() {
        $this->db = null;
    }

    public function fetchAll() {

        $sql = "SELECT * FROM {$this->table}";
        $this->connect();
        $result = $this->db->query($sql);
        $this->disconnect();

        return $result;
    }

    public function find($id) {
        $this->connect();
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE ID =: id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $res = $stmt->fetch();
        $this->disconnect();
        return $res;
    }

    public function insert(array $data) {
        $this->connect();
        $keysData = array_keys($data);
        $keysData = implode($keysData, ',');

        $values = implode("','", $data);

        $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$keysData}) VALUES('{$values}') ");

        $stmt->execute();
        $this->disconnect();
    }

    public function update(array $data) {

        $this->connect();
        $set = null;
        $where = "{$data['id_key']}={$data['id']}";
        unset($data['id_key']);
        unset($data['id']);

        foreach ($data as $key => $a) {

            $set .= " $key = '$a', ";
        }

        $set = substr($set, 0, strlen($set) - 2);

        $sql = "UPDATE {$this->table} SET $set WHERE $where";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $this->disconnect();
    }

    public function autentica($dados) {
        $this->connect();
        $senha = md5($dados['senha']);
        $sql = "
                            SELECT
                                    A.usuarioid,
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
        $this->disconnect();
        return $resultSet;
    }

}

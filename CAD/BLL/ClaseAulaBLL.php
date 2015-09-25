<?php

class AulaBLL {

    function insert($numeroDeAula) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("
                INSERT INTO tblAula(numeroDeAula)
                VALUES (:numeroDeAulaParam);", array(
            ":numeroDeAulaParam" => $numeroDeAula
        ));
    }

    function update($id, $numeroDeAula) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("UPDATE tblAula
                SET numeroDeAula = :numeroDeAulaParam
                WHERE id = :idParam;", array(
            ":numeroDeAulaParam" => $numeroDeAula,
            ":idParam" => $id
        ));
    }

    function delete($id) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("DELETE FROM tblAula
                WHERE id = :idParam;", array(
            ":idParam" => $id
        ));
    }

    function selectAll() {
        $claseConexion = new Connection();
        $resultado = $claseConexion->query("
                SELECT id, numeroDeAula
                FROM tblAula
                ORDER BY id ASC");
        $listaAulas = array();
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $objResultado = $this->rowToDto($row);
            $listaAulas[] = $objResultado;
        }
        return $listaAulas;
    }

    function select($id) {
        $claseConexion = new Connection();
        $resultado = $claseConexion->queryWithParams("
            SELECT id, numeroDeAula
            FROM tblAula
            WHERE id = :idParam", array(
            ":idParam" => $id
        ));
        if ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $objResultado = $this->rowToDto($row);
            return $objResultado;
        }
        return null;
    }

    function rowToDto($row) {
        $objAula = new Aula();
        $objAula->setId($row["id"]);
        $objAula->setNumeroDeAula($row["numeroDeAula"]);
        return $objAula;
    }

}

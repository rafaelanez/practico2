<?php

class AulaMateriaBLL {

    function insert($idMateria, $idAula, $hora, $dia) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("INSERT INTO tblAulaMateria(idMateria, idAula, hora, dia)"
                . " VALUES (:idMateriaParam, :idAulaParam, :horaParam, :diaParam);", array(
            ":idMateriaParam" => $idMateria,
            ":idAulaParam" => $idAula,
            ":horaParam" => $hora,
            ":diaParam" => $dia
        ));
    }

    function update($id, $idMateria, $idAula, $hora, $dia) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("UPDATE tblAulaMateria
                SET idMateria = :idMateriaParam,
                idAula = :idAulaParam,
                hora = :horaParam,
                dia = :diaParam
                WHERE id = :idParam;", array(
            ":idMateriaParam" => $idMateria,
            ":idAulaParam" => $idAula,
            ":horaParam" => $hora,
            ":diaParam" => $dia,
            ":idParam" => $id
        ));
    }

    function delete($id) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("DELETE FROM tblAulaMateria
                WHERE id = :idParam;", array(
            ":idParam" => $id
        ));
    }

    function selectAll() {
        $claseConexion = new Connection();
        $resultado = $claseConexion->query("
                SELECT id, idMateria, idAula, hora, dia
                FROM tblAulaMateria
                ORDER BY id ASC");
        $listaAulasMaterias = array();
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $objResultado = $this->rowToDto($row);
            $listaAulasMaterias[] = $objResultado;
        }
        return $listaAulasMaterias;
    }

    function select($id) {
        $claseConexion = new Connection();
        $resultado = $claseConexion->queryWithParams("
            SELECT id, idMateria, idAula, hora, dia
            FROM tblAulaMateria
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
        $objAulaMateria = new AulaMateria();
        $objAulaMateria->setId($row["id"]);
        $objAulaMateria->setIdAula($row["idAula"]);
        $objAulaMateria->setIdMateria($row["idMateria"]);
        $objAulaMateria->setDia($row["dia"]);
        $objAulaMateria->setHora($row["hora"]);
        return $objAulaMateria;
    }

}

?>
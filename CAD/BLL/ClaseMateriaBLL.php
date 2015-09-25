<?php

class MateriaBLL {

    function insert($codigo, $nombre, $semestre, $costo) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("INSERT INTO tblMateria(codigo,nombre,semestre,costo)"
                . " VALUES (:codigoParam,:nombreParam,:semestreParam, :costoParam);", array(
            ":codigoParam" => $codigo,
            ":nombreParam" => $nombre,
            ":semestreParam" => $semestre,
            ":costoParam" => $costo
        ));
    }

    function update($id, $codigo, $nombre, $semestre, $costo) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("UPDATE tblMateria
                SET codigo = :codigoParam,
                nombre = :nombreParam,
                semestre = :semestreParam,
                costo = :costoParam
                WHERE id = :idParam;", array(
            ":codigoParam" => $codigo,
            ":nombreParam" => $nombre,
            ":semestreParam" => $semestre,
            ":costoParam" => $costo,
            ":idParam" => $id
        ));
    }

    function delete($id) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("DELETE FROM tblMateria
                WHERE id = :idParam;", array(
            ":idParam" => $id
        ));
    }

    function selectAll() {
        $claseConexion = new Connection();
        $resultado = $claseConexion->query("
                SELECT id, codigo, nombre, semestre, costo
                FROM tblMateria
                ORDER BY id ASC");
        $listaMaterias = array();
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $objResultado = $this->rowToDto($row);
            $listaMaterias[] = $objResultado;
        }
        return $listaMaterias;
    }

    function select($id) {
        $claseConexion = new Connection();
        $resultado = $claseConexion->queryWithParams("
            SELECT id, codigo, nombre, semestre, costo
            FROM tblMateria
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
        $objMateria = new Materia();
        $objMateria->setId($row["id"]);
        $objMateria->setCodigo($row["codigo"]);
        $objMateria->setNombre($row["nombre"]);
        $objMateria->setSemestre($row["semestre"]);
        $objMateria->setCosto($row["costo"]);
        return $objMateria;
    }

}

?>
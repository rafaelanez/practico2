<?php

class CategoriaBLL {

    function insert($nombre, $color) {
        $claseConexion = new Connection();
        $resultado = $claseConexion->queryWithParams("CALL sp_tblCategoria_Insert(:nombreParam,:colorParam);", array(
            ":nombreParam" => $nombre,
            ":colorParam" => $color
        ));
        $rowId = $resultado->fetch(PDO::FETCH_ASSOC);
        return $rowId["lastId"];
    }

    function update($id, $nombre, $color) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("CALL sp_tblCategoria_Update(:idParam,:nombreParam,:colorParam);", array(
            ":idParam" => $id,
            ":nombreParam" => $nombre,
            ":colorParam" => $color
        ));
    }

    function delete($id) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("CALL sp_tblCategoria_Delete(:idParam)", array(
            ":idParam" => $id
        ));
    }

    function selectAll() {
        $claseConexion = new Connection();
        $resultado = $claseConexion->query("CALL sp_tblCategoria_SelectAll();");
        $listaCategorias = array();
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $objResultado = $this->rowToDto($row);
            $listaCategorias[] = $objResultado;
        }
        return $listaCategorias;
    }

    function selectById($id) {
        $claseConexion = new Connection();
        $resultado = $claseConexion->queryWithParams("CALL sp_tblCategoria_SelectById(:idParam);", array(
            ":idParam" => $id
        ));

        if ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $objResultado = $this->rowToDto($row);
            return $objResultado;
        }
        return null;
    }

    function rowToDto($row) {
        $objCategoria = new Categoria();
        $objCategoria->setId($row["id"]);
        $objCategoria->setNombre($row["nombre"]);
        $objCategoria->setColor($row["color"]);
        return $objCategoria;
    }
}

?>
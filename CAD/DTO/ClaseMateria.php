<?php

class Materia {

    private $id;
    private $codigo;
    private $nombre;
    private $semestre;
    private $costo;

    function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getSemestre() {
        return $this->semestre;
    }

    function getCosto() {
        return $this->costo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setSemestre($semestre) {
        $this->semestre = $semestre;
    }

    function setCosto($costo) {
        $this->costo = $costo;
    }

}
?>


<?php

class AulaMateria {

    private $id;
    private $idMateria;
    private $idAula;
    private $hora;
    private $dia;

    function getId() {
        return $this->id;
    }

    function getIdMateria() {
        return $this->idMateria;
    }

    function getIdAula() {
        return $this->idAula;
    }

    function getHora() {
        return $this->hora;
    }

    function getDia() {
        return $this->dia;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdMateria($idMateria) {
        $this->idMateria = $idMateria;
    }

    function setIdAula($idAula) {
        $this->idAula = $idAula;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setDia($dia) {
        $this->dia = $dia;
    }

}
?>


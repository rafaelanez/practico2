<?php

class Aula {

    private $id;
    private $numeroDeAula;

    function getId() {
        return $this->id;
    }

    function getNumeroDeAula() {
        return $this->numeroDeAula;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumeroDeAula($numeroDeAula) {
        $this->numeroDeAula = $numeroDeAula;
    }

}

?>

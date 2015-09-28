<?php

class Nota {

    public $id;
    public $fecha;
    public $titulo;
    public $nota;
    public $estado;
    public $idCategoria;

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of fecha.
     *
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Sets the value of fecha.
     *
     * @param mixed $fecha the fecha
     *
     * @return self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Gets the value of titulo.
     *
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Sets the value of titulo.
     *
     * @param mixed $titulo the titulo
     *
     * @return self
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Gets the value of nota.
     *
     * @return mixed
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Sets the value of nota.
     *
     * @param mixed $nota the nota
     *
     * @return self
     */
    public function setNota($nota)
    {
        $this->nota = $nota;

        return $this;
    }

    /**
     * Gets the value of estado.
     *
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Sets the value of estado.
     *
     * @param mixed $estado the estado
     *
     * @return self
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Gets the value of idCategoria.
     *
     * @return mixed
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    /**
     * Sets the value of idCategoria.
     *
     * @param mixed $idCategoria the id categoria
     *
     * @return self
     */
    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;

        return $this;
    }
}

?>

<?php

include_once './CAD/DAL/Connection.php';
include_once './CAD/BLL/ClaseNotaBLL.php';
include_once './CAD/DTO/ClaseNota.php';
include_once './CAD/BLL/ClaseCategoriaBLL.php';
include_once './CAD/DTO/ClaseCategoria.php';

$notaBLL = new NotaBLL();
$categoriaBLL = new CategoriaBLL();
if (isset($_REQUEST["task"])) {
    $task = $_REQUEST["task"];
} else {
    $task = "mostrar";
}
switch ($task) {
    case "insertar":
    	if (isset($_REQUEST["titulo"])) {
            $titulo = $_REQUEST["titulo"];
        }
        if (isset($_REQUEST["nota"])) {
            $nota = $_REQUEST["nota"];
        }
        if (isset($_REQUEST["idCategoria"])) {
            $idCategoria = $_REQUEST["idCategoria"];
        }
        $id = $notaBLL->insert($titulo, $nota, $idCategoria);
        $objNota = $notaBLL->selectById($id);
        $objCategoria = $categoriaBLL->selectById($idCategoria);
        echo json_encode(array(
            'nota'=>$objNota,
            'categoria'=>$objCategoria,
        ));
        break;
    case "seleccionar":
        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
        }
        $objNota = $notaBLL->select($id);
        echo json_encode($objNota);
        break;
    case "archivar":
    	if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
        }
        $notaBLL->archivar($id,0);
        $objNota = $notaBLL->selectById($id);
        $objCategoria = $categoriaBLL->selectById($objNota->getIdCategoria());
        echo json_encode(array(
            'nota'=>$objNota,
            'categoria'=>$objCategoria,
        ));
        break;
	case "desarchivar":
    	if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
        }
        $notaBLL->archivar($id,1);
        $objNota = $notaBLL->selectById($id);
        $objCategoria = $categoriaBLL->selectById($objNota->getIdCategoria());
        echo json_encode(array(
            'nota'=>$objNota,
            'categoria'=>$objCategoria,
        ));
        break;
    case "editarTitulo":
        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
        }
        if (isset($_REQUEST["titulo"])) {
            $titulo = $_REQUEST["titulo"];
        }
        $objNota = $notaBLL->selectById($id);
        $fecha = date("Y-m-d H:i:s");
        $notaBLL->update($id, $fecha, $titulo, $objNota->getNota());
        $objNota = $notaBLL->selectById($id);
        echo json_encode($objNota);
        break;
    case "editarNota":
        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
        }
        if (isset($_REQUEST["nota"])) {
            $nota = $_REQUEST["nota"];
        }
        $objNota = $notaBLL->selectById($id);
        $fecha = date("Y-m-d H:i:s");
        $notaBLL->update($id, $fecha, $objNota->getTitulo(), $nota);
        $objNota = $notaBLL->selectById($id);
        echo json_encode($objNota);
        break;
    case "cambiarCategoria":
        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
        }
        if (isset($_REQUEST["idCategoria"])) {
            $idCategoria = $_REQUEST["idCategoria"];
        }
        $objNota = $notaBLL->selectById($id);
        $objCategoriaAnterior = $categoriaBLL->selectById($objNota->getIdCategoria());
        $notaBLL->updateCategoria($id, $idCategoria);
        $objNota = $notaBLL->selectById($id);
        $objCategoria = $categoriaBLL->selectById($objNota->getIdCategoria());
        echo json_encode(array(
            'nota'=>$objNota,
            'categoria'=>$objCategoria,
            'categoriaAnterior' => $objCategoriaAnterior
        ));
        break;
    case "eliminar":
        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
        }
        $objNota = $notaBLL->selectById($id);
        $notaBLL->delete($id);
       // $objCategoria = $categoriaBLL->selectById($idCategoria);
        echo json_encode($objNota);
        break;
}
?>
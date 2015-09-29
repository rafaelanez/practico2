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
    // case "actualizar":
    //     if (isset($_REQUEST["nombres"])) {
    //         $nombres = $_REQUEST["nombres"];
    //     }
    //     if (isset($_REQUEST["apellidos"])) {
    //         $apellidos = $_REQUEST["apellidos"];
    //     }
    //     if (isset($_REQUEST["edad"])) {
    //         $edad = $_REQUEST["edad"];
    //     }
    //     if (isset($_REQUEST["id"])) {
    //         $id = $_REQUEST["id"];
    //     }
    //     $personaBLL->update($nombres, $apellidos, $edad, $id);
    //     $objPersona = $personaBLL->select($id);
    //     echo json_encode($objPersona);
    //     break;
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
<?php
include_once './cad/DAL/Connection.php';
include_once './cad/BLL/ClaseCategoriaBLL.php';
include_once './cad/DTO/ClaseCategoria.php';
include_once './cad/BLL/ClaseNotaBLL.php';
include_once './cad/DTO/ClaseNota.php';
$categoriaBLL = new CategoriaBLL();
$notaBLL = new NotaBLL();
?>
<!DOCTYPE html>
<html>

    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection" />
        <link type="text/css" rel="stylesheet" href="css/style.css" media="screen,projection" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body class="grey lighten-2">
        <header>
            <div class="row no-margin-bottom white">
                <div class="col s2">
                    <a href="#"><img class="responsive-img" src="images/logo.png"></a>
                </div>
                <div class="col s4">
                    <nav class="grey lighten-2 z-depth-0">
                        <div class="nav-wrapper">
                            <form>
                                <div class="input-field">
                                    <input id="search" type="search" required>
                                    <label for="search"><i class="tiny mdi mdi-action-search"></i></label>
                                    <i class="tiny mdi mdi-navigation-close"></i>
                                </div>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>
            <nav id="main-nav" class="amber accent-4 z-depth-0" role="navigation">
                <div class="nav-wrapper">
                    <div class="row">
                        <div class="col s12">
                            <ul id="slide-out" class="side-nav">
                                <li><a href="javascript:mostrarNotasActivas()"><i class="mdi-content-archive left"></i> Notas</a></li>
                                <li><a href="javascript:mostrarNotasArchivadas()"><i class="mdi-content-archive left"></i> Archivadas</a></li>
                            </ul>
                            <div><a href="#" data-activates="slide-out" class="button-collapse show-on-large flow-text"><i class="mdi mdi-navigation-menu"></i></a> <a id="btn-nav" href="#" data-activates="slide-out" class="button-collapse show-on-large flow-text">Notas</a></div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <div id="main-listaNotasActivas"class="container">
                <div class="row">
                    <div class="col m12 offset-l3 l6">
                        <div id="agregar-nota" class="row z-depth-1 white">
                            <div class="input-field col s12">
                                <input placeholder="Título" id="titulo" type="text">
                            </div>
                            <div class="input-field col s12">
                                <textarea placeholder="Añadir Nota" id="nota" class="materialize-textarea"></textarea>
                            </div>
                            <div id="categoria-wrapper" class="col s12 grey darken-1">
                                <a id="cambiar-categoria" href="#" class="dropdown-button btn-floating white-text grey darken-1 z-depth-0" data-activates='categorias'><i class="small mdi mdi-image-palette"></i></a>
                                <a id="agregar-nota" href="javascript:insertarNota()" class="btn-flat right white-text">Hecho</a>
                                <div id="categorias" class='dropdown-content'>
                                    <?php
                                    $listaCategorias = $categoriaBLL->selectAll();
                                    $count = 1;
                                    foreach ($listaCategorias as $objCategoria) {
                                        ?>
                                        <a href="javascript:seleccionarCategoria(<?php
                                        echo $objCategoria->getId();
                                        ?>, 0, '<?php echo $objCategoria->getColor(); ?>')" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo $objCategoria->getNombre(); ?>">
                                            <i class="mdi mdi-toggle-radio-button-off small <?php echo $objCategoria->getColor(); ?>-text text-accent-3"></i>
                                        </a>
                                        <?php
                                        if ($count % 4 == 0) {
                                            ?>
                                            <br>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        $count++;
                                    }
                                    ?>
                                </div>
                                <input type="hidden" value="1" id="categoria">
                                <input type="hidden" value="grey" id="colorActual">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="listaNotasActivas"class="row">
                    <?php
                    $listaNotas = $notaBLL->selectByEstado(1);
                    foreach ($listaNotas as $objNota) {
                        $objCategoria = $categoriaBLL->selectById($objNota->getIdCategoria());
                        $color = $objCategoria->getColor();
                        $darkerColor = $objCategoria->getColor();
                        $date = date_create($objNota->getFecha());
                        if ($color == 'grey') {
                            $color = 'white';
                        }
                        ?>
                        <div class="col s12 m6 l3">
                            <div id="nota-activa-<?php echo $objNota->getId(); ?>" class="card <?php echo $color; ?> z-depth-1 nota">
                                <div class="card-content">
                                    <h5 class="grey-text text-darken-4"><?php echo $objNota->getTitulo(); ?></h5>
                                    <p>
                                        <?php echo $objNota->getNota(); ?>
                                    </p>
                                </div>
                                <div class="card-action <?php echo $darkerColor; ?> darken-1">
                                    <a id="archivar-nota" href="#archivar<?php echo $objNota->getId(); ?>" class="modal-trigger btn-floating <?php echo $darkerColor; ?> darken-1 z-depth-0"><i class="small mdi mdi-content-archive white-text"></i></a>
                                    <a id="cambiar-categoria" href="#" class="btn-floating <?php echo $darkerColor; ?> darken-1 z-depth-0"><i class="small mdi mdi-image-palette white-text "></i></a>
                                    <a id="eliminar-nota" href="#eliminar<?php echo $objNota->getId(); ?>" class="modal-trigger btn-floating <?php echo $darkerColor; ?> darken-1 z-depth-0"><i class="small mdi mdi-navigation-close white-text"></i></a>
                                </div>
                            </div>
                            <div id="archivar<?php echo $objNota->getId(); ?>" class="modal <?php echo $color; ?>">
                                <div class="modal-content">
                                    <h4>¿Estás seguro que quieres archivar esta nota?</h4>
                                    <h5 class="grey-text text-darken-4"><?php echo $objNota->getTitulo(); ?></h5>
                                    <p>
                                        <?php echo $objNota->getNota(); ?>
                                    </p>
                                    <em class="right">Última edición: <?php echo date_format($date, 'd/m/Y'); ?></em>
                                </div>
                                <div class="modal-footer <?php echo $darkerColor; ?> darken-1">
                                    <a href="javascript:archivarNota(<?php 
                                    echo $objNota->getId(); ?>)" class=" modal-action modal-close waves-effect waves-green btn-flat">Sí</a>
                                    <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
                                </div>
                            </div>
                            <div id="eliminar<?php echo $objNota->getId(); ?>" class="modal <?php echo $color; ?>">
                                <div class="modal-content">
                                    <h4>¿Estás seguro que quieres eliminar esta nota?</h4>
                                    <h5 class="grey-text text-darken-4"><?php echo $objNota->getTitulo(); ?></h5>
                                    <p>
                                        <?php echo $objNota->getNota(); ?>
                                    </p>
                                    <em class="right">Última edición: <?php echo date_format($date, 'd/m/Y'); ?></em>
                                </div>
                                <div class="modal-footer <?php echo $darkerColor; ?> darken-1">
                                    <a href="javascript:eliminarNota(<?php 
                                    echo $objNota->getId(); ?>)" class=" modal-action modal-close waves-effect waves-green btn-flat white-text">Sí</a>
                                    <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat white-text">Cancelar</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div id="main-listaNotasArchivadas" class="container">
                <div id="listaNotasArchivadas"class="row">
                    <?php
                    $listaNotas = $notaBLL->selectByEstado(0);
                    foreach ($listaNotas as $objNota) {
                        $objCategoria = $categoriaBLL->selectById($objNota->getIdCategoria());
                        $color = $objCategoria->getColor();
                        $darkerColor = $objCategoria->getColor();
                        $date = date_create($objNota->getFecha());
                        if ($color == 'grey') {
                            $color = 'white';
                        }
                        ?>
                        <div class="col s12 m6 l3">
                            <div id="nota-archivada-<?php echo $objNota->getId(); ?>"class="card <?php echo $color; ?> z-depth-1 nota">
                                <div class="card-content">
                                    <h5 class="grey-text text-darken-4"><?php echo $objNota->getTitulo(); ?></h5>
                                    <p>
                                        <?php echo $objNota->getNota(); ?>
                                    </p>
                                </div>
                                <div class="card-action <?php echo $darkerColor; ?> darken-1">
                                    <a id="archivar-nota" href="javascript:desarchivarNota(<?php 
                                    echo $objNota->getId(); ?>)" class="btn-floating <?php echo $darkerColor; ?> darken-1 z-depth-0"><i class="small mdi mdi-content-archive white-text"></i></a>
                                    <a id="cambiar-categoria" href="#" class="btn-floating <?php echo $darkerColor; ?> darken-1 z-depth-0"><i class="small mdi mdi-image-palette white-text"></i></a>
                                    <a id="eliminar-nota" href="#eliminar<?php echo $objNota->getId(); ?>" class="modal-trigger btn-floating <?php echo $darkerColor; ?> darken-1 z-depth-0"><i class="small mdi mdi-navigation-close white-text"></i></a>
                                </div>
                            </div>
                            <div id="eliminar<?php echo $objNota->getId(); ?>" class="modal <?php echo $color; ?>">
                                <div class="modal-content">
                                    <h4>¿Estás seguro que quieres eliminar esta nota?</h4>
                                    <h5 class="grey-text text-darken-4"><?php echo $objNota->getTitulo(); ?></h5>
                                    <p>
                                        <?php echo $objNota->getNota(); ?>
                                    </p>
                                    <em class="right">Última edición: <?php echo date_format($date, 'd/m/Y'); ?></em>
                                </div>
                                <div class="modal-footer <?php echo $darkerColor; ?> darken-1">
                                    <a href="javascript:eliminarNota(<?php 
                                    echo $objNota->getId(); ?>)" class=" modal-action modal-close waves-effect waves-green btn-flat white-text">Sí</a>
                                    <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat white-text">Cancelar</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </main>
    <script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="js/materialize.min.js" type="text/javascript"></script>
    <script src="js/scripts.js" type="text/javascript"></script>
</body>

</html>

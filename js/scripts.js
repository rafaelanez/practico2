/*Scripts necesarios para hacer funcionar los plugins de la página*/
(function($) {
    $(function() {

        $('.button-collapse').sideNav({
            closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
        });
        $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrain_width: false, // Does not change width of dropdown to that of the activator
            hover: false,
            belowOrigin: false, // Displays dropdown below the button
            alignment: 'left' // Displays dropdown with edge aligned to the left of button
        });
    }); // end of document ready
})(jQuery); // end of jQuery name space
$(document).ready(function() {
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
});

/*Helpers*/
Date.createFromMysql = function(mysql_string) {
    var t, result = null;

    if (typeof mysql_string === 'string') {
        t = mysql_string.split(/[- :]/);

        //when t[3], t[4] and t[5] are missing they defaults to zero
        result = new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);
    }

    return result;
};

Date.prototype.Formato = function() {
    var yyyy = this.getFullYear();
    var mm = this.getMonth() < 9 ? "0" + (this.getMonth() + 1) : (this.getMonth() + 1); // getMonth() is zero-based
    var dd = this.getDate() < 10 ? "0" + this.getDate() : this.getDate();
    return "".concat(dd).concat("/").concat(mm).concat("/").concat(yyyy);
};

function crearNotaActiva(objNotaRespuesta, objCategoriaRespuesta) {
    var fecha = new Date.createFromMysql(objNotaRespuesta.fecha);
    var color = objCategoriaRespuesta.color == 'grey' ? 'white' : objCategoriaRespuesta.color;
    var nota =  '<div class="col s12 m6 l3">'
            +   '<div id="nota-activa-' + objNotaRespuesta.id + '" class="card ' + color + ' z-depth-1 nota">'
            +   '<div class="card-content">'
            +   '<h5 class="grey-text text-darken-4">' + objNotaRespuesta.titulo + '</h5>'
            +    '<p>' + objNotaRespuesta.nota + '</p>'
            +   '</div>'
            +   '<div class="card-action ' + objCategoriaRespuesta.color + ' darken-1">'
            +   '<a id="archivar-nota" href="#archivar' + objNotaRespuesta.id + '" class="modal-trigger btn-floating ' +  objCategoriaRespuesta.color + ' darken-1 z-depth-0"><i class="small mdi mdi-content-archive white-text"></i></a>'
            +   '<a id="cambiar-categoria" href="#" class="btn-floating ' + objCategoriaRespuesta.color + ' darken-1 z-depth-0"><i class="small mdi mdi-image-palette white-text "></i></a>'
            +   '<a id="eliminar-nota" href="#eliminar' + objNotaRespuesta.id + '" class="modal-trigger btn-floating ' + objCategoriaRespuesta.color + ' darken-1 z-depth-0"><i class="small mdi mdi-navigation-close white-text"></i></a>'
            +   '</div>'
            +   '</div>'
            +   '<div id="archivar' + objNotaRespuesta.id + '" class="modal ' + color + '">'
            +   '<div class="modal-content">'
            +   '<h4>¿Estás seguro que quieres archivar esta nota?</h4>'
            +   '<h5 class="grey-text text-darken-4">' + objNotaRespuesta.titulo + '</h5>'
            +   '<p>' + objNotaRespuesta.nota + '</p>'
            +   '<em class="right">Última edición: ' + fecha.Formato() + '</em>'
            +   '</div>'
            +   '<div class="modal-footer ' + objCategoriaRespuesta.color + ' darken-1">'
            +   '<a href="javascript:archivarNota(' + objNotaRespuesta.id + ')" class=" modal-action modal-close waves-effect waves-green btn-flat">Sí</a>'
            +   '<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>'
            +   '</div>'
            +   '</div>'
            +   '<div id="eliminar'+objNotaRespuesta.id+'" class="modal ' + color + '">'
            +   '<div class="modal-content">'
            +   '<h4>¿Estás seguro que quieres eliminar esta nota?</h4>'
            +   '<h5 class="grey-text text-darken-4">' + objNotaRespuesta.titulo + '</h5>'
            +   '<p>' + objNotaRespuesta.nota + '</p>'
            +   '<em class="right">Última edición: ' + fecha.Formato() + '</em>'
            +   '</div>'
            +   '<div class="modal-footer ' + objCategoriaRespuesta.color + ' darken-1">'
            +   '<a href="javascript:eliminarNota(' + objNotaRespuesta.id + ')" class=" modal-action modal-close waves-effect waves-green btn-flat white-text">Sí</a>'
            +   '<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat white-text">Cancelar</a>'
            +   '</div>'
            +   '</div>'
            +   '</div>'
    return nota;
}
function crearNotaArchivada(objNotaRespuesta, objCategoriaRespuesta) {
    var fecha = new Date.createFromMysql(objNotaRespuesta.fecha);
    var color = objCategoriaRespuesta.color == 'grey' ? 'white' : objCategoriaRespuesta.color;
    var nota =  '<div class="col s12 m6 l3">'
            +   '<div id="nota-archivada-' + objNotaRespuesta.id + '" class="card ' + color + ' z-depth-1 nota">'
            +   '<div class="card-content">'
            +   '<h5 class="grey-text text-darken-4">' + objNotaRespuesta.titulo + '</h5>'
            +    '<p>' + objNotaRespuesta.nota + '</p>'
            +   '</div>'
            +   '<div class="card-action ' + objCategoriaRespuesta.color + ' darken-1">'
            +   '<a id="archivar-nota" href="javascript:desarchivarNota(' + objNotaRespuesta.id + ')" class="btn-floating ' +  objCategoriaRespuesta.color + ' darken-1 z-depth-0"><i class="small mdi mdi-content-archive white-text"></i></a>'
            +   '<a id="cambiar-categoria" href="#" class="btn-floating ' + objCategoriaRespuesta.color + ' darken-1 z-depth-0"><i class="small mdi mdi-image-palette white-text "></i></a>'
            +   '<a id="eliminar-nota" href="#eliminar' + objNotaRespuesta.id + '" class="modal-trigger btn-floating ' + objCategoriaRespuesta.color + ' darken-1 z-depth-0"><i class="small mdi mdi-navigation-close white-text"></i></a>'
            +   '</div>'
            +   '</div>'
            +   '<div id="eliminar'+objNotaRespuesta.id+'" class="modal ' + color + '">'
            +   '<div class="modal-content">'
            +   '<h4>¿Estás seguro que quieres eliminar esta nota?</h4>'
            +   '<h5 class="grey-text text-darken-4">' + objNotaRespuesta.titulo + '</h5>'
            +   '<p>' + objNotaRespuesta.nota + '</p>'
            +   '<em class="right">Última edición: ' + fecha.Formato() + '</em>'
            +   '</div>'
            +   '<div class="modal-footer ' + objCategoriaRespuesta.color + ' darken-1">'
            +   '<a href="javascript:eliminarNota(' + objNotaRespuesta.id + ')" class=" modal-action modal-close waves-effect waves-green btn-flat white-text">Sí</a>'
            +   '<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat white-text">Cancelar</a>'
            +   '</div>'
            +   '</div>'
            +   '</div>'
    return nota;
}
/*Script para la navegación de la página*/
function mostrarNotasActivas() {
    var listaNotasActivas = document.getElementById("main-listaNotasActivas");
    listaNotasActivas.setAttribute("style", "display:block");
    var listaNotasArchivadas = document.getElementById("main-listaNotasArchivadas");
    listaNotasArchivadas.setAttribute("style", "display:none");
    document.getElementById("main-nav").classList.remove('blue-gray');
    document.getElementById("main-nav").classList.add('amber');
    document.getElementById("btn-nav").text = 'Notas';
}

function mostrarNotasArchivadas() {
    var listaNotasActivas = document.getElementById("main-listaNotasArchivadas");
    listaNotasActivas.setAttribute("style", "display:block");
    var listaNotasArchivadas = document.getElementById("main-listaNotasActivas");
    listaNotasArchivadas.setAttribute("style", "display:none");
    document.getElementById("main-nav").classList.remove('amber');
    document.getElementById("main-nav").classList.add('blue-grey');
    document.getElementById("btn-nav").text = 'Archivadas';
}
/*Scripts para hacer funcionar las peticiones ajax de la página*/
var peticion = new XMLHttpRequest();

/*Método que permite cambiar la categoría de la nota, así como el color que se muestra en el formulario para insertar la nota*/
function seleccionarCategoria(idCategoria, idNota, color) {
    var inputColorActual = document.getElementById("colorActual");
    if (idNota == 0) {
        document.getElementById("categoria").value = idCategoria;
        var colorActual = document.getElementById("colorActual").value;
        if (colorActual == 'grey') {
            document.getElementById("agregar-nota").classList.remove('white');
            document.getElementById("categoria-wrapper").classList.remove('grey');
            document.getElementById("cambiar-categoria").classList.remove('grey');
        } else {
            document.getElementById("agregar-nota").classList.remove(colorActual);
            document.getElementById("categoria-wrapper").classList.remove(colorActual);
            document.getElementById("cambiar-categoria").classList.remove(colorActual);
        }
        if (color == 'grey') {
            inputColorActual.value = 'grey';
            document.getElementById("agregar-nota").classList.add('white');
            document.getElementById("categoria-wrapper").classList.add('grey');
            document.getElementById("cambiar-categoria").classList.add('grey');
        } else {
            inputColorActual.value = color;
            document.getElementById("agregar-nota").classList.add(color);
            document.getElementById("categoria-wrapper").classList.add(color);
            document.getElementById("cambiar-categoria").classList.add(color);
        }
    }
}

/*Métodos necesarios para insertar una nueva nota*/
function insertarNota() {
    var tituloInput = document.getElementById("titulo");
    var notaInput = document.getElementById("nota");
    var categoriaInput = document.getElementById("categoria");

    var tituloVal = tituloInput.value;
    var notaVal = notaInput.value;
    notaVal = notaVal.replace(/\r?\n/g, '<br />');
    var categoriaVal = categoriaInput.value;

    var url = "FuncionesNota.php?titulo=" + tituloVal + "&nota=" + notaVal + "&idCategoria=" + categoriaVal + "&task=insertar";
    peticion.open("GET", url, true);

    peticion.setRequestHeader("content-type", "application/json");
    peticion.setRequestHeader("Accept", "application/json");

    peticion.onreadystatechange = llegoMetodoInsertarNota;
    peticion.send();
}

function llegoMetodoInsertarNota() {
    /*Si la petición llegó, entra aquí*/

    if (peticion.readyState == 4) {
        //Si llegó sin errores, entra acá
        var respuesta = peticion.responseText;
        var objRespuesta = JSON.parse(respuesta);
        var objNotaRespuesta = objRespuesta['nota'];
        var objCategoriaRespuesta = objRespuesta['categoria'];
        var listaNotas = document.getElementById("listaNotasActivas");

        var nota = crearNotaActiva(objNotaRespuesta, objCategoriaRespuesta);
        listaNotas.innerHTML += nota;
        //var tbody = tblDatos.children[1];
        // tbody.innerHTML += '<tr><td>' + objNotaRespuesta.id +
        //         '</td><td>' + objNotaRespuesta.nombres +
        //         '</td><td>' + objNotaRespuesta.apellidos +
        //         '</td><td>' + objNotaRespuesta.edad +
        //         '</td><td><a href="javascript:cargarPersonaActualizar(' + objNotaRespuesta.id +
        //         ')">Actualizar</a></td><td><a href="javascripteliminarPersona(' + objNotaRespuesta.id +
        //         ')">Eliminar</a></td></tr>';
        $('.modal-trigger').leanModal();
    }
}
/*Métodos necesarios para archivar una nota*/
function archivarNota(idNota) {

    var url = "FuncionesNota.php?id=" + idNota +"&task=archivar";
    peticion.open("GET", url, true);

    peticion.setRequestHeader("content-type", "application/json");
    peticion.setRequestHeader("Accept", "application/json");

    peticion.onreadystatechange = llegoMetodoArchivarNota;
    peticion.send();
}

function llegoMetodoArchivarNota() {
    /*Si la petición llegó, entra aquí*/

    if (peticion.readyState == 4) {
        //Si llegó sin errores, entra acá

        var respuesta = peticion.responseText;
        var objRespuesta = JSON.parse(respuesta);
        var objNotaRespuesta = objRespuesta['nota'];
        var objCategoriaRespuesta = objRespuesta['categoria'];
        var notaAEliminar = document.getElementById("nota-activa-" + objNotaRespuesta.id).parentNode;
        notaAEliminar.remove();
        var listaNotas = document.getElementById("listaNotasArchivadas");

        var fecha = new Date.createFromMysql(objNotaRespuesta.fecha);


        var nota = crearNotaArchivada(objNotaRespuesta, objCategoriaRespuesta);
        listaNotas.innerHTML += nota;
        Materialize.toast('Nota Archivada', 4000);
        $('.modal-trigger').leanModal();
    }
}

/*Métodos necesarios para desarchivar una nota*/
function desarchivarNota(idNota) {

    var url = "FuncionesNota.php?id=" + idNota +"&task=desarchivar";
    peticion.open("GET", url, true);

    peticion.setRequestHeader("content-type", "application/json");
    peticion.setRequestHeader("Accept", "application/json");

    peticion.onreadystatechange = llegoMetodoDesarchivarNota;
    peticion.send();
}

function llegoMetodoDesarchivarNota() {
    /*Si la petición llegó, entra aquí*/

    if (peticion.readyState == 4) {
        //Si llegó sin errores, entra acá

        var respuesta = peticion.responseText;
        var objRespuesta = JSON.parse(respuesta);
        var objNotaRespuesta = objRespuesta['nota'];
        var objCategoriaRespuesta = objRespuesta['categoria'];
        var notaAgregar = document.getElementById("nota-archivada-" + objNotaRespuesta.id).parentNode;
        notaAgregar.remove();
        var listaNotas = document.getElementById("listaNotasActivas");

        var nota = crearNotaActiva(objNotaRespuesta, objCategoriaRespuesta);
        listaNotas.innerHTML += nota;
        Materialize.toast('Nota Desarchivada', 4000)
        $('.modal-trigger').leanModal();
    }
}

/*Métodos necesarios para desarchivar una nota*/
function eliminarNota(idNota) {

    var url = "FuncionesNota.php?id=" + idNota +"&task=eliminar";
    peticion.open("GET", url, true);

    peticion.setRequestHeader("content-type", "application/json");
    peticion.setRequestHeader("Accept", "application/json");

    peticion.onreadystatechange = llegoMetodoEliminarNota;
    peticion.send();
}

function llegoMetodoEliminarNota() {
    /*Si la petición llegó, entra aquí*/

    if (peticion.readyState == 4) {
        //Si llegó sin errores, entra acá

        var respuesta = peticion.responseText;
        var objNotaRespuesta = JSON.parse(respuesta);
        var notaEliminar;

        if(objNotaRespuesta.estado == 1){
            notaEliminar = document.getElementById("nota-activa-" + objNotaRespuesta.id).parentNode;
        } else if(objNotaRespuesta.estado == 0){
            notaEliminar = document.getElementById("nota-archivada-" + objNotaRespuesta.id).parentNode;
        }
        notaEliminar.remove();
        Materialize.toast('Nota Eliminada', 4000);
    }
}
/*funciones necesarias para editar*/
function mostrarInputTitulo(idNota) {
    var inputTitulo = document.getElementById("titulo-" + idNota);
    inputTitulo.setAttribute("style", "display:block");
    var displayTitulo = document.getElementById("display-titulo-" + idNota);
    displayTitulo.setAttribute("style", "display:none");
    inputTitulo.focus();
}

function mostrarInputNota(idNota) {
    var inputNota = document.getElementById("nota-" + idNota);
    inputNota.setAttribute("style", "display:block");
    var displayNota = document.getElementById("display-nota-" + idNota);
    displayNota.setAttribute("style", "display:none");
    inputNota.focus();
}

function editarTitulo(idNota) {
    var tituloInput = document.getElementById("titulo-" + idNota);
    var tituloVal = tituloInput.value;

    var url = "FuncionesNota.php?id=" + idNota +"&titulo=" + tituloVal + "&task=editarTitulo";
    peticion.open("GET", url, true);

    peticion.setRequestHeader("content-type", "application/json");
    peticion.setRequestHeader("Accept", "application/json");

    peticion.onreadystatechange = llegoMetodoEditarTitulo;
    peticion.send();
}

function llegoMetodoEditarTitulo() {
    /*Si la petición llegó, entra aquí*/

    if (peticion.readyState == 4) {
        //Si llegó sin errores, entra acá

        var respuesta = peticion.responseText;
        var objNotaRespuesta = JSON.parse(respuesta);

        var inputTitulo = document.getElementById("titulo-" + objNotaRespuesta.id);
        inputTitulo.setAttribute("style", "display:none");
        var fechaEdicion = document.getElementById("fecha-edicion-" + objNotaRespuesta.id);
        var fecha = new Date.createFromMysql(objNotaRespuesta.fecha);
        fechaEdicion.innerHTML = 'Última edición: ' + fecha.Formato();
        var displayTitulo = document.getElementById("display-titulo-" + objNotaRespuesta.id);
        displayTitulo.innerHTML = objNotaRespuesta.titulo;
        inputTitulo.innerHTML = objNotaRespuesta.titulo;
        displayTitulo.setAttribute("style", "display:block");
        Materialize.toast('Nota Actualizada', 4000);
    }
}

function editarNota(idNota) {
    var notaInput = document.getElementById("nota-" + idNota);
    var notaVal = notaInput.value;
    notaVal = notaVal.replace(/\r?\n/g, '<br />');
    
    var url = "FuncionesNota.php?id=" + idNota +"&nota=" + notaVal + "&task=editarNota";
    peticion.open("GET", url, true);

    peticion.setRequestHeader("content-type", "application/json");
    peticion.setRequestHeader("Accept", "application/json");

    peticion.onreadystatechange = llegoMetodoEditarNota;
    peticion.send();
}

function llegoMetodoEditarNota() {
    /*Si la petición llegó, entra aquí*/

    if (peticion.readyState == 4) {
        //Si llegó sin errores, entra acá

        var respuesta = peticion.responseText;
        var objNotaRespuesta = JSON.parse(respuesta);

        var inputNota = document.getElementById("nota-" + objNotaRespuesta.id);
        inputNota.setAttribute("style", "display:none");
        var fechaEdicion = document.getElementById("fecha-edicion-" + objNotaRespuesta.id);
        var fecha = new Date.createFromMysql(objNotaRespuesta.fecha);
        fechaEdicion.innerHTML = 'Última edición: ' + fecha.Formato();
        var displayNota = document.getElementById("display-nota-" + objNotaRespuesta.id);
        displayNota.innerHTML = objNotaRespuesta.nota;
        inputNota.innerHTML = objNotaRespuesta.nota;
        displayNota.setAttribute("style", "display:block");
        Materialize.toast('Nota Actualizada', 4000);
    }
}
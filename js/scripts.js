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
}

Date.prototype.Formato = function() {
    var yyyy = this.getFullYear();
    var mm = this.getMonth() < 9 ? "0" + (this.getMonth() + 1) : (this.getMonth() + 1); // getMonth() is zero-based
    var dd = this.getDate() < 10 ? "0" + this.getDate() : this.getDate();
    return "".concat(dd).concat("/").concat(mm).concat("/").concat(yyyy);
};
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
        var objNotaRespuesta = JSON.parse(respuesta);
        var listaNotas = document.getElementById("listaNotasActivas");

        var fecha = new Date.createFromMysql(objNotaRespuesta.fecha);


        var nota = '<div class="col s12 m6 l3">'
        		  +'<div id="nota-activa-'+objNotaRespuesta.id+'" class="card white z-depth-1 nota">'
        		  +'<div class="card-content">'
        		  +'<h5 class="grey-text text-darken-4">' + objNotaRespuesta.titulo + '</h5>'
        		  +'<p>' + objNotaRespuesta.nota + '</p>'
        		  +'</div><div class="card-action grey lighten-1">'
        		  +'<a id="archivar-nota" href="javascript:archivarNota(' + objNotaRespuesta.id +')"><i class="small mdi mdi-content-archive white-text"></i></a>' 
        		  +'<a id="cambiar-categoria" href="#"><i class="small mdi mdi-image-palette white-text"></i></a>' 
        		  +'<a id="eliminar-nota" href="javascript:eliminarNota(' + objNotaRespuesta.id +')"><i class="small mdi mdi-navigation-close white-text"></i></a>' 
        		  +'<p class="right white-text">' + fecha.Formato() + '</p></div></div></div>';
        listaNotas.innerHTML += nota;
        //var tbody = tblDatos.children[1];
        // tbody.innerHTML += '<tr><td>' + objNotaRespuesta.id +
        //         '</td><td>' + objNotaRespuesta.nombres +
        //         '</td><td>' + objNotaRespuesta.apellidos +
        //         '</td><td>' + objNotaRespuesta.edad +
        //         '</td><td><a href="javascript:cargarPersonaActualizar(' + objNotaRespuesta.id +
        //         ')">Actualizar</a></td><td><a href="javascripteliminarPersona(' + objNotaRespuesta.id +
        //         ')">Eliminar</a></td></tr>';
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
        var objNotaRespuesta = JSON.parse(respuesta);
        var notaAEliminar = document.getElementById("nota-activa-" + objNotaRespuesta.id).parentNode;
        notaAEliminar.remove();
        var listaNotas = document.getElementById("listaNotasArchivadas");

        var fecha = new Date.createFromMysql(objNotaRespuesta.fecha);


        var nota = '<div class="col s12 m6 l3">'
        		  +'<div id="nota-archivada-'+objNotaRespuesta.id+'" class="card white z-depth-1 nota">'
        		  +'<div class="card-content">'
        		  +'<h5 class="grey-text text-darken-4">' + objNotaRespuesta.titulo + '</h5>'
        		  +'<p>' + objNotaRespuesta.nota + '</p>'
        		  +'</div><div class="card-action grey lighten-1">'
        		  +'<a id="archivar-nota" href="javascript:desarchivarNota(' + objNotaRespuesta.id +')"><i class="small mdi mdi-content-archive white-text"></i></a>' 
        		  +'<a id="cambiar-categoria" href="#"><i class="small mdi mdi-image-palette white-text"></i></a>' 
        		  +'<a id="eliminar-nota" href="javascript:eliminarNota(' + objNotaRespuesta.id +')"><i class="small mdi mdi-navigation-close white-text"></i></a>' 
        		  +'<p class="right white-text">' + fecha.Formato() + '</p></div></div></div>';
        listaNotas.innerHTML += nota;
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
        var objNotaRespuesta = JSON.parse(respuesta);
        var notaAgregar = document.getElementById("nota-archivada-" + objNotaRespuesta.id).parentNode;
        notaAgregar.remove();
        var listaNotas = document.getElementById("listaNotasActivas");

        var fecha = new Date.createFromMysql(objNotaRespuesta.fecha);


        var nota = '<div class="col s12 m6 l3">'
        		  +'<div id="nota-activa-'+objNotaRespuesta.id+'" class="card white z-depth-1 nota">'
        		  +'<div class="card-content">'
        		  +'<h5 class="grey-text text-darken-4">' + objNotaRespuesta.titulo + '</h5>'
        		  +'<p>' + objNotaRespuesta.nota + '</p>'
        		  +'</div><div class="card-action grey lighten-1">'
        		  +'<a id="archivar-nota" href="javascript:archivarNota(' + objNotaRespuesta.id +')"><i class="small mdi mdi-content-archive white-text"></i></a>' 
        		  +'<a id="cambiar-categoria" href="#"><i class="small mdi mdi-image-palette white-text"></i></a>' 
        		  +'<a id="eliminar-nota" href="javascript:eliminarNota(' + objNotaRespuesta.id +')"><i class="small mdi mdi-navigation-close white-text"></i></a>' 
        		  +'<p class="right white-text">' + fecha.Formato() + '</p></div></div></div>';
        listaNotas.innerHTML += nota;
    }
}

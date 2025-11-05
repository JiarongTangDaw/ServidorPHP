// funcion para añadir una fila en blanco en la lista para añadir comic
function anadirFila(){
    let listado=document.getElementById('listado');

    let lhtml=listado.innerHTML;

    let fila=`input type="text" id="titulo0" value="" required>
                <input type="text" id="autor0" value="" required>
                <select id="estado0" required>
                    <option value=""></option>
                    <option value="pendiente">Pendiente</option>
                    <option value="leyendo">Leyendo</option>
                    <option value="leido">Leido</option>
                </select>
                <select id="ubicacion0" required>
                    <option value=""></option>
                    <option value="estanteria1">Estanteria 1</option>
                    <option value="estanteria2">Estanteria 2</option>
                    <option value="mueble">Mueble</option>
                </select>
                <select name="prestado" id="prestado0" required>
                    <option value=""></option>
                    <option value="si">Si</option>
                    <option value="no">No</option>
                </select>
                <div class="botones">
                    <input type="button" id="btAdd" onclick="agregar();" value="ADD">
                </div>>`
    listado.innerHTML=lhtml+ fila;
}

//funcion para agregar el comic al listado
function agregar() {
    // sacar los valores de entrada tras rellenar los campos
    let titulo = document.getElementById('titulo0').value;
    let autor = document.getElementById('autor0').value;
    let estado = document.getElementById('estado0').value;
    let ubicacion = document.getElementById('ubicacion0').value;
    let prestado = document.getElementById('prestado0').value;

    //comprobar que no hay campos vacios
    if(titulo == "" || autor == "" || estado == "" || ubicacion == "" || prestado == ""){
        alert('No puede haber campos vacios');
    }else{
        // dar valor a los input hidden para enviarlos a PHP
        document.getElementById('titulo').value = titulo;
        document.getElementById('autor').value = autor;
        document.getElementById('estado').value = estado;
        document.getElementById('ubicacion').value = ubicacion;
        document.getElementById('prestado').value = prestado;

        //cambiamos el action del formulario añadiendo una propiedad de action con valor add
        let formulario = document.getElementById('formulario');
        formulario.action = 'funciones.php?action=add';

        formulario.submit();
    }
}

function modificar(id) {
    // sacar los valores de cada campo para la modificacion
    let titulo = document.getElementById('titulo'+ id).value;
    let autor = document.getElementById('autor' + id).value;
    let estado = document.getElementById('estado' + id).value;
    let ubicacion = document.getElementById('ubicacion' + id).value;
    let prestado = document.getElementById('prestado' + id).value;

    // dar valor a los input hidden para enviarlos a PHP
    document.getElementById('titulo').value = titulo;
    document.getElementById('autor').value = autor;
    document.getElementById('estado').value = estado;
    document.getElementById('ubicacion').value = ubicacion;
    document.getElementById('prestado').value = prestado;
    document.getElementById('id').value = id;

    //cambiamos el action del formulario añadiendo una propiedad de action con valor modificar
    let formulario = document.getElementById('formulario');
    formulario.action = 'funciones.php?action=modificar';

    formulario.submit();
}

function eliminar(id) {
   let titulo = document.getElementById('titulo'+ id).value;
   // confirmamos que el usuario quiere realizar la eliminacion
   let salida = confirm(`Va a eliminar el comic ${titulo}.¿Desea continuar?`);

   if(salida){
        // dar valor al input hidden de id porque solo necesitamos saber el valor del id para realizar el delete
        document.getElementById('id').value = id;

        //cambiamos el action del formulario añadiendo una propiedad de action con valor eliminar pasando solo el id
        let formulario = document.getElementById('formulario');
        formulario.action = 'funciones.php?action=eliminar';

        formulario.submit();
   }
    
}

function filtrar() {
    // sacar los valores de cada campo para la modificacion
    let titulo = document.getElementById('filTitulo').value;
    let autor = document.getElementById('filAutor').value;
    let estado = document.getElementById('filEstado').value;
    let ubicacion = document.getElementById('filUbicacion').value;
    let prestado = document.getElementById('filPrestado').value;

    // dar valor a los input hidden para enviarlos a PHP
    document.getElementById('titulo').value = titulo;
    document.getElementById('autor').value = autor;
    document.getElementById('estado').value = estado;
    document.getElementById('ubicacion').value = ubicacion;
    document.getElementById('prestado').value = prestado;

    //cambiamos el action del formulario añadiendo una propiedad de action con valor filtrar
    let formulario = document.getElementById('formulario');
    formulario.action = 'funciones.php?action=filtrar';

    formulario.submit();
    
}
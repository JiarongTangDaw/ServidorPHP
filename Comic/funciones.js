//funcion para agregar el comic al listado
function agregar() {
    // sacar los valores de entrada tras rellenar los campos
    let titulo0 = document.getElementById('titulo0').value;
    let autor0 = document.getElementById('autor0').value;
    let estado0 = document.getElementById('estado0').value;
    let ubicacion0 = document.getElementById('ubicacion0').value;
    let prestado0 = document.getElementById('prestado0').value;

    //comprobar que no hay campos vacios
    if(titulo0 == "" || autor0 == "" || estado0 == "" || ubicacion0 == "" || prestado0 == ""){ // si hay campos vacios
        alert('No puede haber campos vacios al añadir un comic nuevo');
    }else{// no hay campos vacios
        // dar valor a los input hidden para enviarlos a PHP
        document.getElementById('titulo').value = titulo0;
        document.getElementById('autor').value = autor0;
        document.getElementById('estado').value = estado0;
        document.getElementById('ubicacion').value = ubicacion0;
        document.getElementById('prestado').value = prestado0;        

        //cambiamos el action del formulario añadiendo una propiedad de action con valor add
        let formulario = document.getElementById('formulario');
        formulario.action = 'funciones.php?action=add';

        formulario.submit();
    }
}

//funcion para modificar valores de un comic
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

//funcion para eliminar un comic
function eliminar(id) {
   let titulo = document.getElementById('titulo'+ id).value;
   // confirmamos que el usuario quiere realizar la eliminacion
   let salida = confirm(`Va a eliminar el comic ${titulo}.¿Desea continuar?`);

   // si se acepta la eliminacion se realiza la eliminacion
   if(salida){// se confirma la eliminacion
        // dar valor al input hidden de id porque solo necesitamos saber el valor del id para realizar el delete
        document.getElementById('id').value = id;

        //cambiamos el action del formulario añadiendo una propiedad de action con valor eliminar pasando solo el id
        let formulario = document.getElementById('formulario');
        formulario.action = 'funciones.php?action=eliminar';

        formulario.submit();
   }
    
}

//funcion para filtrar comics
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
    formulario.action = 'index.php?action=filtrar';

    formulario.submit();
    
}
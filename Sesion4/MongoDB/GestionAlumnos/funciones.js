// funcion para importar los datos de los archivos de texto
function importarDatos() {
    let formulario = document.getElementById('formulario');
    formulario.action = 'funciones.php?action=importar';

    formulario.submit();
}

//funcion para agregar el alumno al listado
function agregar() {
    // sacar los valores de entrada tras rellenar los campos
    let nombre0 = document.getElementById('nombre0').value;
    let apellidos0 = document.getElementById('apellidos0').value;
    let numFila0 = document.getElementById('numFila0').value;
    let sexo0 = document.getElementById('sexo0').value;
    let esProfeSexy0 = document.getElementById('esProfeSexy0').value;

    //comprobar que no hay campos vacios
    if(nombre0 == "" || apellidos0 == "" || numFila0 == "" || sexo0 == "" || esProfeSexy0 == ""){ // si hay campos vacios
        alert('No puede haber campos vacios al añadir un alumno nuevo');

    }else{// no hay campos vacios
        // dar valor a los input hidden para enviarlos a PHP
        document.getElementById('nombre').value = nombre0;
        document.getElementById('apellidosNew').value = apellidos0;
        document.getElementById('numFilaNew').value = numFila0;
        document.getElementById('sexo').value = sexo0;
        document.getElementById('esProfeSexy').value = esProfeSexy0;

        //cambiamos el action del formulario añadiendo una propiedad de action con valor add
        let formulario = document.getElementById('formulario');
        formulario.action = 'funciones.php?action=add';

        formulario.submit();
    }
}

//funcion para modificar valores de un alumno
function modificar(apellido,numFila) {
    // sacar los valores de cada campo para la modificacion
    let ape = apellido.replaceAll(' ','_');
    let nombre = document.getElementById('nombre' + ape).value;
    let apellidosNew = document.getElementById('apellidos' + ape).value;
    let numeroFila = document.getElementById('numFila' + ape).value;
    let sexo = document.getElementById('sexo' + ape).value;
    let esProfeSexy = document.getElementById('esProfeSexy' + ape).value;
    
    
    if(nombre == "" || apellidosNew == "" || numeroFila == "" || sexo == "" || esProfeSexy == ""){ // si hay campos vacios
        alert('No puede haber campos vacios al modificar un alumno');
    }else{// no hay campos vacios
        // dar valor a los input hidden para enviarlos a PHP
        // dar valor a los input hidden para enviarlos a PHP
        document.getElementById('nombre').value = nombre;
        document.getElementById('apellidosNew').value = apellidosNew;
        document.getElementById('apellidosOld').value = apellido;
        document.getElementById('numFilaOld').value = numFila;
        document.getElementById('numFilaNew').value = numeroFila;
        document.getElementById('sexo').value = sexo;
        document.getElementById('esProfeSexy').value = esProfeSexy;


        //cambiamos el action del formulario añadiendo una propiedad de action con valor modificar
        let formulario = document.getElementById('formulario');
        formulario.action = 'funciones.php?action=modificar';

        formulario.submit();
    }

    
}

//funcion para eliminar un alumno
function eliminar(apellido,numFila) {

    let ape = apellido.replaceAll(' ','_');

   let nombre = document.getElementById('nombre' + ape).value;
    let apellidos = document.getElementById('apellidos' + ape).value;
   // confirmamos que el usuario quiere realizar la eliminacion
   let salida = confirm(`Va a eliminar el alumno ${nombre} ${apellidos}.¿Desea continuar?`);

   // si se acepta la eliminacion se realiza la eliminacion
   if(salida){// se confirma la eliminacion
        // dar valor al input hidden de id porque solo necesitamos saber el valor del id para realizar el delete
        document.getElementById('apellidosOld').value = apellido;
        document.getElementById('numFilaOld').value = numFila;

        //cambiamos el action del formulario añadiendo una propiedad de action con valor eliminar pasando solo el id
        let formulario = document.getElementById('formulario');
        formulario.action = 'funciones.php?action=eliminar';

        formulario.submit();
   }
    
}

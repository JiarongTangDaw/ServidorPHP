//funcion para agregar el comic al listado
function agregar() {
    // sacar los valores de entrada tras rellenar los campos
    let titulo0 = document.getElementById('titulo0').value;
    let anio0 = document.getElementById('anio0').value;
    let plataforma0 = document.getElementById('plataforma0').value;
    let metacritic0 = document.getElementById('metacritic0').value;

    //comprobar que no hay campos vacios
    if(titulo0 == "" || anio0 == "" || plataforma0 == "" || metacritic0 == "" ){ // si hay campos vacios
        alert('No puede haber campos vacios al añadir un videojuego nuevo');
    }else if(metacritic0 > 100 || metacritic0 < 0){
        alert('El valor de metacritic debe ser de 0 - 100');
    }else{// no hay campos vacios
        // dar valor a los input hidden para enviarlos a PHP
        document.getElementById('titulo').value = titulo0;
        document.getElementById('anio').value = anio0;
        document.getElementById('plataformaNew').value = plataforma0;
        document.getElementById('metacritic').value = metacritic0;

        //cambiamos el action del formulario añadiendo una propiedad de action con valor add
        let formulario = document.getElementById('formulario');
        formulario.action = 'funciones.php?action=add';

        formulario.submit();
    }
}

//funcion para modificar valores de un comic
function modificar(id_videojuego,plataforma) {
    // sacar los valores de cada campo para la modificacion
    let plat = plataforma.replaceAll(' ','_');
    let titulo = document.getElementById('titulo'+ id_videojuego + plat).value;
    let anio = document.getElementById('anio' + id_videojuego + plat).value;
    let plataformaNew = document.getElementById('plataforma' + id_videojuego + plat).value;
    let metacritic = document.getElementById('metacritic' + id_videojuego + plat).value;
    //! AÑADIDO DESPUES DE PRUEBA
    if(titulo == "" || anio == "" || plataformaNew == "" || metacritic == "" ){ // si hay campos vacios
        alert('No puede haber campos vacios al modificar un videojuego');
    }else if(metacritic > 100 || metacritic < 0){
        alert('El valor de metacritic es incorrecto');
    }else{// no hay campos vacios
        // dar valor a los input hidden para enviarlos a PHP
        // dar valor a los input hidden para enviarlos a PHP
        document.getElementById('titulo').value = titulo;
        document.getElementById('anio').value = anio;
        document.getElementById('plataformaOld').value = plataforma;
        document.getElementById('plataformaNew').value = plataformaNew;
        document.getElementById('metacritic').value = metacritic;
        document.getElementById('idVideojuego').value = id_videojuego;


        //cambiamos el action del formulario añadiendo una propiedad de action con valor modificar
        let formulario = document.getElementById('formulario');
        formulario.action = 'funciones.php?action=modificar';

        formulario.submit();
    }

    
}

//funcion para eliminar un comic
function eliminar(id_videojuego,plataforma) {
   let plat = plataforma.replaceAll(' ','_');
   let titulo = document.getElementById('titulo'+ id_videojuego + plat).value;
   // confirmamos que el usuario quiere realizar la eliminacion
   let salida = confirm(`Va a eliminar el videojuego ${titulo}.¿Desea continuar?`);

   // si se acepta la eliminacion se realiza la eliminacion
   if(salida){// se confirma la eliminacion
        // dar valor al input hidden de id porque solo necesitamos saber el valor del id para realizar el delete
        document.getElementById('idVideojuego').value = id_videojuego;
        document.getElementById('plataformaOld').value = plataforma;

        //cambiamos el action del formulario añadiendo una propiedad de action con valor eliminar pasando solo el id
        let formulario = document.getElementById('formulario');
        formulario.action = 'funciones.php?action=eliminar';

        formulario.submit();
   }
    
}

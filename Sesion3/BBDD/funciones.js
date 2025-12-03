//funcion para modificar valores de un comic
function modificar(id) {
    // sacar los valores de cada campo para la modificacion
    let rol = document.getElementById('rol'+ id).value;

    //! AÑADIDO DESPUES DE PRUEBA
    if(rol == ""){ // si hay campos vacios
        alert('No puede haber campos vacios al modificar un usuario');
    }else{// no hay campos vacios
        // dar valor a los input hidden para enviarlos a PHP
        document.getElementById('rol').value = rol;
        document.getElementById('id').value = id;

        //cambiamos el action del formulario añadiendo una propiedad de action con valor modificar
        let formulario = document.getElementById('listado');
        formulario.action = 'funciones.php?action=modificar';

        formulario.submit();
    }

    
}

function eliminar(id) {
   // confirmamos que el usuario quiere realizar la eliminacion
   let usuario = document.getElementById('name'+id).textContent;
   let salida = confirm(`Va a eliminar el usuario ${usuario}.¿Desea continuar?`);

   // si se acepta la eliminacion se realiza la eliminacion
   if(salida){// se confirma la eliminacion
        // dar valor al input hidden de id porque solo necesitamos saber el valor del id para realizar el delete
        document.getElementById('id').value = id;

        //cambiamos el action del formulario añadiendo una propiedad de action con valor eliminar pasando solo el id
        let formulario = document.getElementById('listado');
        formulario.action = 'funciones.php?action=eliminar';

        formulario.submit();
   }
}

let lVolver = document.getElementById('volverPerfil');
lVolver.addEventListener('click',function(){
    window.location.href = 'profile.php';
})
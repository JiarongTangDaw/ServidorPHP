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

function cerrarSesion() {
    if(confirm('¿Estás seguro de que quieres cerrar sesión?')) {
        window.location.href = 'http://localhost/Sesion3/BBDD/funciones.php?action=logout';
    }
}

function mostrarCambioPass() {
    let form = document.getElementById('cambio');
    if(form.style.display != 'none'){
        form.style.display = 'none';
    }else{
        form.style.display = 'block';
    }
}

//funcion para modificar valores de un comic
function modificarPassword(id) {
    // sacar los valores de cada campo para la modificacion
    let newPass = document.getElementById('newPassword').value;
    let newPass2 = document.getElementById('newPassword2').value;
    let oldPass = document.getElementById('oldPassword').value;

    if(oldPass == "" || newPass == "" || newPass2 == ""){ // si hay campos vacios
        alert('No puede haber campos vacios al modificar una contraseña');
    }else if(newPass != newPass2){
        alert('La confirmación de la contraseña no coincide con la nueva contraseña introducida');
    }else{// no hay campos vacios
        // dar valor a los input hidden para enviarlos a PHP
        document.getElementById('password').value = newPass;
        document.getElementById('password2').value = oldPass;
        document.getElementById('id').value = id;

        //cambiamos el action del formulario añadiendo una propiedad de action con valor modificar
        let formulario = document.getElementById('formCambioPass');
        formulario.action = 'funciones.php?action=modificarPassword';

        formulario.submit();
    }

    
}

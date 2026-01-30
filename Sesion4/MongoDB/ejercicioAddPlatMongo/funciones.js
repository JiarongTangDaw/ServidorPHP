//funcion para agregar el comic al listado
function agregar() {
    // sacar los valores de entrada tras rellenar los campos
    let plataforma0 = document.getElementById('plataforma0').value;

    //comprobar que no hay campos vacios
    if(plataforma0 == "" ){ // si hay campos vacios
        alert('No puede haber campos vacios al añadir una plataforma nueva');
    }else{// no hay campos vacios
        // dar valor a los input hidden para enviarlos a PHP
        document.getElementById('plataformaNew').value = plataforma0;

        //cambiamos el action del formulario añadiendo una propiedad de action con valor add
        let formulario = document.getElementById('formulario');
        formulario.action = 'funciones.php?action=add';

        formulario.submit();
    }
}


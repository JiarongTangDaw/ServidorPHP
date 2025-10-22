let contBotones = document.getElementById('botones');
let form = document.getElementById('formulario');

let add = document.getElementById('btAdd');
let btDelete = document.getElementById('btDelete');
let edit = document.getElementById('btEdit');

let tAdd = document.getElementById('add');
let tDelete = document.getElementById('delete');
let tEdit = document.getElementById('edit');

let btAgregar = document.getElementById('btAgregar');
let btElim = document.getElementById('btElim');
let btEditar = document.getElementById('btEditar');

let barEstado = document.getElementById('estado');
let inputTarea = document.getElementById("tarea");
let inputIdTarea = document.getElementById("idTarea");

document.addEventListener('DOMContentLoaded',function () {
    inicializar();

    add.addEventListener('click', function() {
        formulario('add');
    });
    
    btDelete.addEventListener('click', function() {
        formulario('delete');
    });
    
    edit.addEventListener('click', function() {
        formulario('edit');
    });
    
});

function inicializar() {
    let contBotones1 = document.getElementById('botones');
    let form1 = document.getElementById('formulario');

    contBotones1.style.display = "flex";
    form1.style.display = "none";

    tAdd.style.display = "none";
    tDelete.style.display = "none";
    tEdit.style.display = "none";
    btAgregar.style.display = "none";
    btElim.style.display = "none";
    btEditar.style.display = "none";
    barEstado.style.display = "none";
    inputIdTarea.style.display = "none";
    inputTarea.style.display = "none";
}

function formulario (opcion) {
    contBotones.style.display = 'none';
    form.style.display = 'block';

    switch (opcion) {
        case 'delete':
            tDelete.style.display = "block";
            tAdd.style.display = "none";
            tEdit.style.display = "none";
            btElim.style.display = "block";
            btAgregar.style.display = "none";
            btEditar.style.display = "none";
            barEstado.style.display = "none";
            inputIdTarea.style.display = "block";
            inputTarea.style.display = "none";
            break;
        
        case 'edit':
            tDelete.style.display = "none";
            tAdd.style.display = "none";
            tEdit.style.display = "block";
            btElim.style.display = "none";
            btAgregar.style.display = "none";
            btEditar.style.display = "block";
            barEstado.style.display = "none";
            inputIdTarea.style.display = "block";
            inputTarea.style.display = "none";
            break;
    
        default:
            tAdd.style.display = "block";
            tDelete.style.display = "none";
            tEdit.style.display = "none";
            btElim.style.display = "none";
            btAgregar.style.display = "block";
            btEditar.style.display = "none";
            barEstado.style.display = "block";
            inputIdTarea.style.display = "none";
            inputTarea.style.display = "block";
            break;
    }
}
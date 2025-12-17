/* * Funciones de navegación y envío de formularios.
 * La lógica general es:
 * 1. Capturar el formulario por su ID.
 * 2. Asignar la ruta (action) y parámetros GET correspondientes.
 * 3. Hacer submit del formulario.
 */

// Redirige al script de login
function login() {
    let form = document.getElementById("frmInicio");
    form.action = 'login.php';
    form.submit();
}

// Redirige a la página de registro
function registrar() {
    let form = document.getElementById("frmInicio");
    form.action = 'registrar.php?action=registrar';
    form.submit();
}

// Envía credenciales para procesar el inicio de sesión
function iniciarSesion(){
    let form = document.getElementById("formLogin");
    form.action = "funcionesUsuario.php?action=login";
    form.submit();
}

// Switch para menú de navegación principal
function navegar(destino){
    switch (destino) {
        case 'usuario':
            window.location.href = "./perfilUsuario.php";
            break;
        
        case 'cliente':
            window.location.href = "./perfilClientes.php";
            break;
        
        case 'contacto':
            window.location.href = "./perfilContactos.php";
            break;

        default:
            window.location.href = "./login.php";
            break;
    }
}

// Cierra la sesión mediante formulario oculto
function cerrarSesion() {
    let form = document.getElementById("frmEli");
    form.action = `funcionesUsuario.php?action=cerrarsesion`;
    form.submit();
}

// Añade usuario distinguiendo si viene de un listado (admin)
function addUsuario(vieneListado){
    let form = document.getElementById("formRegistrar");
    let qList = "";
    if(vieneListado){
        qList = "&listado=true";
    }
    form.action = 'funcionesUsuario.php?action=addUsuario'+ qList;
    form.submit();
}

// Prepara el formulario para Modificar Usuario (inyecta ID)
function modUsuario(id){
    let form = document.getElementById("formModificar");
    document.getElementById('idUsuario').value = id;
    form.action = 'funcionesUsuario.php?action=modificar';
    form.submit();
}

// Elimina usuario con confirmación previa (alerta JS)
function deleteUsuario(id){
    let conf = confirm(`¿Seguro que deseas eliminar este usuario, con id ${id}?`);
    if(conf){
        let form = document.getElementById("frmEli");
        document.getElementById('idUsuario').value = id;
        form.action = 'funcionesUsuario.php?action=eliminar';
        form.submit();
    }
}

// Redirecciones simples
function perfilClientes() {
    window.location.href = "./perfilClientes.php";
}

function perfilContactos() {
    window.location.href = "./perfilContactos.php";
}

// Filtra contactos por ID de cliente
function contactoCliente(idCliente) {
    window.location.href = "./perfilContactos.php?idCliente=" + idCliente;
}

// --- CLIENTES ---

function addCliente(){
    let form = document.getElementById("formRegCliente");
    form.action = 'funcionesCliente.php?action=addCliente';
    form.submit();
}

function modCliente(id){
    let form = document.getElementById("formRegCliente");
    form.action = 'funcionesCliente.php?action=modificar';
    document.getElementById('idCliente').value = id; // Inyecta ID en hidden input
    form.submit();
}

function deleteCliente(id){
    let conf = confirm(`¿Seguro que deseas eliminar este Cliente, con id ${id}?`);
    if(conf){
        let form = document.getElementById("frmEliCli");
        document.getElementById('idCliente').value = id;
        form.action = 'funcionesCliente.php?action=eliminar';
        form.submit();
    }
}

// --- CONTACTOS ---

function addContacto(){
    let form = document.getElementById("formRegContacto");
    form.action = 'funcionesContactos.php?action=addContacto';
    form.submit();
}

function modContacto(id){
    let form = document.getElementById("formRegContacto");
    form.action = 'funcionesContactos.php?action=modificar';
    document.getElementById('idContacto').value = id;
    form.submit();
}

function deleteContacto(id){
    let conf = confirm(`¿Seguro que deseas eliminar este Contacto, con id ${id}?`);
    if(conf){
        let form = document.getElementById("frmEliContacto");
        document.getElementById('idContacto').value = id;
        form.action = 'funcionesContactos.php?action=eliminar';
        form.submit();
    }
}
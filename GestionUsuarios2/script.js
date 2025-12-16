function login() {
    let form = document.getElementById("frmInicio");
    form.action = 'login.php';
    form.submit();
}

function registrar() {
    let form = document.getElementById("frmInicio");
    form.action = 'prueba.php';
    form.submit();
}

function iniciarSesion(){
    let form = document.getElementById("formLogin");
    form.action = "funcionesUsuario.php?action=login";
    form.submit();
}

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

function cerrarSesion() {
    let form = document.getElementById("frmEli");
    form.action = `funcionesUsuario.php?action=cerrarsesion`;
    form.submit();
}

function addUsuario(vieneListado){
    let form = document.getElementById("formRegistrar");
    let qList = "";
    if(vieneListado){
        qList = "&listado=true";
    }
    form.action = 'prueba.php?action=addUsuario'+ qList;
    form.submit();
}

function modUsuario(id){
    let form = document.getElementById("formModificar");
    document.getElementById('idUsuario').value = id;
    form.action = 'funcionesUsuario.php?action=modificar';
    form.submit();
}

function deleteUsuario(id){
    let conf = confirm(`¿Seguro que deseas eliminar este usuario, con id ${id}?`);
    if(conf){
        let form = document.getElementById("frmEli");
        document.getElementById('idUsuario').value = id;
        form.action = 'funcionesUsuario.php?action=eliminar';
        form.submit();
    }
    
}

function perfilClientes() {
    window.location.href = "./perfilClientes.php";
}

function perfilContactos() {
    window.location.href = "./perfilContactos.php";
}

function contactoCliente(idCliente) {
    window.location.href = "./perfilContactos.php?idCliente=" + idCliente;
}

function addCliente(){
    let form = document.getElementById("formRegCliente");
    form.action = 'funcionesCliente.php?action=addCliente';
    form.submit();
}

function modCliente(id){
    let form = document.getElementById("formRegCliente");
    form.action = 'funcionesCliente.php?action=modificar';
    document.getElementById('idCliente').value = id;
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
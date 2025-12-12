function login() {
    let form = document.getElementById("frmInicio");
    form.action = 'login.php';
    form.submit();
}

function registrar() {
    let form = document.getElementById("frmInicio");
    form.action = 'registrar.php?action=registrar';
    form.submit();
}

function iniciarSesion(){
    let form = document.getElementById("formLogin");
    form.action = "funcionesLogin.php?action=login";
    form.submit();
}

function addUsuario(){
    let form = document.getElementById("formRegistrar");
    form.action = "acceder.php?action=registrar";
    form.submit();
}

function cancelar(){
    let form = document.getElementById("formRegistrar");
    form.action = "perfilUsuario.php";
    form.submit();
}

function cerrarSesion() {
    let form = document.getElementById("frmEli");
    form.action = `funcionesLogin.php?action=cerrarsesion`;
    form.submit();
}

function addUsuario(vieneListado){
    let form = document.getElementById("formRegistrar");
    form.action = 'registrar.php?action=addUsuario';
    form.submit();
}


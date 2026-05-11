/*
 * Script adaptado al sistema actual:
 * - Usuarios (login + CRUD)
 * - Marcas
 * - TipoAccesorios
 * - Modelos
 * - Compatibilidades
 * - Buscador con autocompletado
 */

// ======================
// 🔐 LOGIN / SESIÓN
// ======================

function login() {
    window.location.href = 'login.php';
}

function iniciarSesion() {
    let form = document.getElementById("formLogin");
    form.action = "funcionesUsuario.php?action=login";
    form.submit();
}

function cerrarSesion() {
    let form = document.getElementById("frmEli");
    form.action = "funcionesUsuario.php?action=cerrarsesion";
    form.submit();
}



// ======================
// 🏷️ MARCAS
// ======================

function addMarca() {
    let form = document.getElementById("formRegMarca"); // ✅ id correcto del form
    form.action = 'funcionesMarcas.php?action=addMarca'; // ✅ nombre correcto
    form.submit();
}

function modMarca(id) {
    let form = document.getElementById("formRegMarca");
    document.getElementById('idMarca').value = id;
    form.action = 'funcionesMarcas.php?action=modificar'; // ✅
    form.submit();
}

function deleteMarca(id) {
    if (confirm(`¿Eliminar marca con id ${id}?`)) {
        let form = document.getElementById("frmEli");
        document.getElementById('idMarca').value = id;  // ✅ este es el que lee funcionesMarcas.php
        form.action = 'funcionesMarcas.php?action=eliminar';
        form.submit();
    }
}


// ======================
// 🔌 TIPO ACCESORIOS
// ======================

function addTipoAccesorio(){
    let form = document.getElementById("formRegTipo");
    let marca_id = document.getElementById("marca_id").value;
    if (marca_id === '') {
        alert('Debe seleccionar una marca');
        return;
    }
    form.action = "funcionesTipoAccesorios.php?action=addTipoAccesorio";
    form.submit();
}

function modTipoAccesorio(id){
    let form = document.getElementById("formRegTipo");
    document.getElementById("idTipoAccesorio").value = id;
    form.action = "funcionesTipoAccesorios.php?action=modificar";
    form.submit();
}

function deleteTipoAccesorio(id) {
    if (confirm(`¿Eliminar tipo accesorio con id ${id}?`)) {
        let form = document.getElementById("frmEli");
        document.getElementById('idTipoAccesorio').value = id;
        form.action = 'funcionesTipoAccesorios.php?action=eliminar';
        form.submit();
    }
}


// ======================
// 📱 MODELOS
// ======================

function addModelo(){
    let form = document.getElementById("formRegModelo");

    form.action = "funcionesModelo.php?action=addModelo";
    form.submit();
}

function modModelo(id){
    let form = document.getElementById("formRegModelo");

    document.getElementById("idModelo").value = id;

    form.action = "funcionesModelo.php?action=modificar";
    form.submit();
}

function deleteModelo(id) {
    if (confirm(`¿Eliminar modelo con id ${id}?`)) {
        let form = document.getElementById("frmEli");
        document.getElementById('idModelo').value = id;
        form.action = 'funcionesModelo.php?action=eliminar';
        form.submit();
    }
}


// ======================
// 🔗 COMPATIBILIDADES
// ======================

function addCompatibilidad(){

    let form = document.getElementById("formRegCompatibilidad");

    form.action = "funcionesCompatibilidades.php?action=addCompatibilidad";

    form.submit();
}

function deleteCompatibilidad() {
    let form = document.getElementById("formRegistrar");
    form.action = 'funcionesCompatibilidades.php?action=eliminar';
    form.submit();
}


// ======================
// 🧭 NAVEGACIÓN
// ======================

function navegar(destino) {
    switch (destino) {
        case 'usuario':
            window.location.href = "./panelAdmin.php";
            break;
        case 'marca':
            window.location.href = "./perfilMarcas.php";
            break;
        case 'tipoaccesorio':
            window.location.href = "./perfilTipoAccesorios.php";
            break;
        case 'modelo':
            window.location.href = "./perfilModelos.php";
            break;
        case 'compatibilidad':
            window.location.href = "./perfilCompatibilidades.php";
            break;
        default:
            window.location.href = "./index.php";
            break;
    }
}


// ======================
// 🔍 AUTOCOMPLETADO
// ======================

// MODELOS
document.addEventListener("DOMContentLoaded", () => {

    let modeloInput = document.getElementById("modelo1");

    if (modeloInput) {
        modeloInput.addEventListener("keyup", function () {
            let texto = this.value;

            fetch("buscar_modelos.php?q=" + texto)
                .then(res => res.json())
                .then(data => {
                    let lista = document.getElementById("sugerencias_modelo");
                    lista.innerHTML = "";

                    data.forEach(item => {
                        let li = document.createElement("li");
                        li.textContent = item.modelo;

                        li.onclick = () => {
                            modeloInput.value = item.modelo;
                            document.getElementById("modelo1_id").value = item.modelo_id;
                            lista.innerHTML = "";
                        };

                        lista.appendChild(li);
                    });
                });
        });
    }

    // TIPO ACCESORIOS
    let tipoInput = document.getElementById("tipoaccesorio");

    if (tipoInput) {
        tipoInput.addEventListener("keyup", function () {
            let texto = this.value;

            fetch("buscar_tipoaccesorios.php?q=" + texto)
                .then(res => res.json())
                .then(data => {
                    let lista = document.getElementById("sugerencias_tipo");
                    lista.innerHTML = "";

                    data.forEach(item => {
                        let li = document.createElement("li");
                        li.textContent = item.tipoaccesorio;

                        li.onclick = () => {
                            tipoInput.value = item.tipoaccesorio;
                            document.getElementById("tipoaccesorio_id").value = item.tipoaccesorio_id;
                            lista.innerHTML = "";
                        };

                        lista.appendChild(li);
                    });
                });
        });
    }

    const sel1 = document.getElementById('modelo1_id');
    const sel2 = document.getElementById('modelo2_id');

    if (sel1 && sel2) {
        function sincronizarSelects(origen, destino) {
            const valorOrigen = origen.value;

            Array.from(destino.options).forEach(opt => {
                opt.hidden = false;
                opt.disabled = false;
            });

            if (valorOrigen !== '') {
                const optAOcultar = destino.querySelector(`option[value="${valorOrigen}"]`);
                if (optAOcultar) {
                    optAOcultar.hidden = true;
                    optAOcultar.disabled = true;

                    if (destino.value === valorOrigen) {
                        destino.value = '';
                    }
                }
            }
        }

        sel1.addEventListener('change', () => sincronizarSelects(sel1, sel2));
        sel2.addEventListener('change', () => sincronizarSelects(sel2, sel1));
    }

});

// ======================
// 🔍 BÚSQUEDA PRINCIPAL
// ======================

document.addEventListener("DOMContentLoaded", () => {

    const formBusqueda = document.getElementById("formBusqueda");

    if (formBusqueda) {
        formBusqueda.addEventListener("submit", function (e) {
            e.preventDefault(); // Evita recarga de página

            const modeloTexto  = document.getElementById("modelo1").value;
            const tipoId       = document.getElementById("tipoaccesorio_id").value;
            const resultados   = document.getElementById("resultados");

            // Validación mínima
            if (!modeloTexto && !tipoId) {
                resultados.innerHTML = "<p>Por favor selecciona al menos un modelo o tipo de accesorio.</p>";
                return;
            }

            const params = new URLSearchParams();
            if (modeloTexto) params.append("q", modeloTexto);
            if (tipoId)   params.append("tipoaccesorio_id", tipoId);

            resultados.innerHTML = "<p>Buscando...</p>";

            fetch("buscarCompatibilidades.php?" + params.toString())
                .then(res => res.json())
                .then(data => {
                if (data.length === 0) {
                    resultados.innerHTML = "<p>No se encontraron compatibilidades.</p>";
                    return;
                }

                // Agrupar por marca
                const agrupado = {};
                data.forEach(item => {
                    if (!agrupado[item.marca]) {
                        agrupado[item.marca] = [];
                    }
                    agrupado[item.marca].push(item.modelo);
                });

                // Construir tabla
                let html = `
                    <table>
                        <thead>
                            <tr>
                                <th>Marca</th>
                                <th>Modelos compatibles</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                for (const marca in agrupado) {
                    const modelos = agrupado[marca].join(", ");
                    html += `
                        <tr>
                            <td>${marca}</td>
                            <td>${modelos}</td>
                        </tr>
                    `;
                }

                html += `</tbody></table>`;
                resultados.innerHTML = html;
            })
        });
    }

});
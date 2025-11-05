function anadir(){
    let tarea=document.getElementById('tarea0').value;
    let estado=document.getElementById('estado0').value;
    
    if(tarea == "" || estado == "" ){
        alert('No puede haber campos vacios');
    }else{
        document.getElementById('tarea').value=tarea;
        document.getElementById('estado').value=estado;

        let frm =document.getElementById('frm');
        frm.action='funciones.php?action=anadir';
    
        frm.submit()
    }

    // document.getElementById('tarea').value=tarea;
    // document.getElementById('estado').value=estado;

    // let frm =document.getElementById('frm');
    // frm.action='funciones.php?action=anadir';
  
    // frm.submit();

}

function anadirFila(){
    let listado=document.getElementById('listado');

    let lhtml=listado.innerHTML;

    let fila=`<div><input type="text"
                            id="tarea0"
                            value="" required/>
                    </div>
                    <div><select id="estado0" name="estado0" required>
                        <option value=""></option>
                        <option value="pendiente">pendiente</option>
                        <option value="en progreso">en progreso</option>
                        <option value="comprobada">comprobada</option>
                    </select>
                    </div>
                    <div>
                        <input type="button" id="btnAnadir" onclick="anadir();" value="ADD" />
                        
                    </div>`
    listado.innerHTML=lhtml+ fila;
}

function modificar(id){
    console.log("id",id);
    let tarea=document.getElementById('tarea'+ id).value;
    let estado=document.getElementById('estado'+ id).value;

    document.getElementById('tarea').value=tarea;
    document.getElementById('estado').value=estado;
    document.getElementById('id').value=id;

    let frm =document.getElementById('frm');
    frm.action='funciones.php?action=guardar';
    frm.submit();
}

function eliminar(id){
    let tarea=document.getElementById('tarea'+ id).value;
    let salida=confirm(`Va a eliminar la tarea ${tarea}. ¿Desea continuar?`);

    if(salida){
        document.getElementById('id').value=id;

        let frm =document.getElementById('frm');
        frm.action='funciones.php?action=eliminar';
        frm.submit();
    }
    
}

function filtrar(){
    let tarea=document.getElementById('filTarea').value;
    let estado=document.getElementById('filEstado').value;

        document.getElementById('tarea').value=tarea;
        document.getElementById('estado').value=estado;
        let frm =document.getElementById('frm');
        frm.action='index.php?action=filtrar';
        frm.submit();

}
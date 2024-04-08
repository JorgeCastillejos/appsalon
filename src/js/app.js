let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;
const cita = {
    'id': '',
    'nombre': '',
    'fecha': '',
    'hora': '',
    servicios : []
}

document.addEventListener('DOMContentLoaded',()=>{
    iniciarApp();
});

function iniciarApp(){
    tabs();
    mostrarSeccion();
    botonesPaginacion();
    botonAnterior();
    botonSiguiente();
    obtenerServicios();
    agregarFecha();
    agregarHora();
    agregarNombre();
    agregarId();
}

async function obtenerServicios(){
    try {
        const url = `${location.origin}/api/servicios`;
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        const servicios = resultado;
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios){
    
   servicios.forEach(servicio=>{
    const {id,nombre,precio} = servicio;

    const nombreServicio = document.createElement('P');
    nombreServicio.textContent = nombre;

    const precioServicio = document.createElement('P');
    precioServicio.innerHTML = `<span>$${precio}</span>`;
    
    const contenidoServicio = document.createElement('DIV');
    contenidoServicio.classList.add('servicio');
    contenidoServicio.appendChild(nombreServicio);
    contenidoServicio.appendChild(precioServicio);
    contenidoServicio.dataset.idServicio = id;
    contenidoServicio.onclick = ()=>{
        seleccionarServicio({...servicio});
    }
    
    document.querySelector('#servicios').appendChild(contenidoServicio);
   });  

   
}

function seleccionarServicio(servicio){

    //Pintar el Servicio de Azul para Simular que esta Seleccionado
    const divServicio = document.querySelector(`[data-id-servicio="${servicio.id}"]`);

    //Validar si en el Arreglo ya Exite el servicio Seleccionado
    if(cita.servicios.some(agregado => agregado.id === servicio.id)){
        //Eliminar del Arreglo para quitar Seleccion 
        cita.servicios = cita.servicios.filter(agregado => agregado.id !== servicio.id);
        divServicio.classList.remove('seleccionado');
    }else{
        cita.servicios = [...cita.servicios,servicio];
        divServicio.classList.add('seleccionado');
    }
}
    
        


function tabs(){
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach(boton=>{
        boton.addEventListener('click',(e)=>{
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginacion();
        });
    });
}

function mostrarSeccion(){
    const seccionPrevia = document.querySelector('.mostrar');
    if(seccionPrevia){
        seccionPrevia.classList.remove('mostrar');
    }

    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    //Eliminar clas Actual(Color Blanco);
    const tabsPrevio = document.querySelector('.actual');
    if(tabsPrevio){
        tabsPrevio.classList.remove('actual');
    }

    //Agrega un color Blanco a la seccion Activa
    const tabs = document.querySelector(`[data-paso="${paso}"]`);
    tabs.classList.add('actual');

    
}

function botonesPaginacion(){
    const botonAnterior = document.querySelector('#anterior');
    const botonSiguiente = document.querySelector('#siguiente');
    
    if(paso === 1){
        botonAnterior.classList.add('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }else if(paso === 3){
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else{
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }
}

function botonAnterior(){
    const botonAnterior = document.querySelector('#anterior');
    botonAnterior.addEventListener('click',()=>{
       --paso;
        if(paso < pasoInicial) return;
       mostrarSeccion();
       botonesPaginacion();
    });
}

function botonSiguiente(){
    const botonSiguiente = document.querySelector('#siguiente');
    botonSiguiente.addEventListener('click',()=>{
        ++paso;
        if(paso > pasoFinal) return;
        mostrarSeccion();
        botonesPaginacion();
    });
}

function agregarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input',(e)=>{
        const fecha = e.target.value;
        const fechaCita = new Date(fecha).getDay();
        
        if([5,6].includes(fechaCita)){
            e.target.value = '';
            mostrarAlerta('error','Fines de Semana no Disponible','.formulario');
        }else{
           cita.fecha = e.target.value;
        }
        

    });
}

function mostrarAlerta(tipo,mensaje,referencia,desaparece = true){
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia){
        alertaPrevia.remove();
    }

    const alerta = document.createElement('P');
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    alerta.textContent = mensaje;
    
    document.querySelector(referencia).appendChild(alerta);
    
    if(desaparece){
        setTimeout(() => {
            alerta.remove();
        }, 5000);
    }
}

function agregarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input',(e)=>{
        const hora = e.target.value;
        const horaCita = hora.split(':')[0];
        if(horaCita < 9 || horaCita > 17){
            e.target.value = '';
           mostrarAlerta('error','Hora no Disponible','.formulario');
        }else{
            cita.hora = e.target.value;
        }
    
    });
}

function agregarNombre(){
    const nombreUsuario = document.querySelector('#nombre').value;
    cita.nombre = nombreUsuario;
}

function agregarId(){
    cita.id = document.querySelector('#id').value;
}

function mostrarResumen(){
    //Limpiar el contenido del resumen
    const resumen = document.querySelector('.contenido-resumen');
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }


    //Validar si al Objeto le Faltan Datos
    if(Object.values(cita).includes('') || cita.servicios.length === 0){
       mostrarAlerta('error','Faltan datos o Servicios','.contenido-resumen',desaparece = false);
       return;
    }

    //Mostrando toda la informacion del Objeto CITA
    const {nombre,fecha,hora,servicios} = cita;
    
    const headingServicios = document.createElement('H2');
    headingServicios.textContent = 'Informacion de los Servicios';

    resumen.appendChild(headingServicios);

    servicios.forEach(servicio=>{
        const nombreServicio = document.createElement('P');
        nombreServicio.textContent = servicio.nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `$${servicio.precio}`;

        const contenedorServicios = document.createElement('DIV');
        contenedorServicios.appendChild(nombreServicio);
        contenedorServicios.appendChild(precioServicio);
        
        resumen.appendChild(contenedorServicios);

    });

   
    
   
    //Heading Cita
    const headingCita = document.createElement('H2');
    headingCita.textContent = 'Informacion de la Cita';

    const nombreCliente = document.createElement('p');
    nombreCliente.innerHTML = `<span>Cliente: </span> ${nombre}`;

    const fechaCita = document.createElement('p');
    fechaCita.innerHTML = `<span>Fecha: </span> ${fecha}`;

    const horaCita = document.createElement('p');
    horaCita.innerHTML = `<span>Hora: </span> ${hora} Horas`;

    const contenedorCita = document.createElement('DIV');
    contenedorCita.classList.add('servicios');

    //Boton Para guardar la Cita
    const btnGuardarCita = document.createElement('BUTTON');
    btnGuardarCita.classList.add('boton');
    btnGuardarCita.textContent = 'Guardar Cita';
   btnGuardarCita.onclick = ()=>{
        guardarCita();
   }

    resumen.appendChild(headingCita);
    contenedorCita.appendChild(nombreCliente);
    contenedorCita.appendChild(fechaCita);
    contenedorCita.appendChild(horaCita);
    resumen.appendChild(contenedorCita); 
    resumen.appendChild(btnGuardarCita); 
}

async function guardarCita(){
    const {id,fecha,hora} = cita;

    const servicios = cita.servicios.map(servicio=> servicio.id);
    
   //Enviando los Datos para guardar la Cita (fecha,hora,usuarioId);
   const datos = new FormData();
   datos.append('usuarioId',id);
   datos.append('fecha',fecha);
   datos.append('hora',hora);
   datos.append('servicios',servicios);

   
   try {
    const url = '/api/citas';
    const respuesta = await fetch(url,{
        method: 'POST',
        body: datos
    });

    const resultado = await respuesta.json();

    if(resultado.tipo === 'exito'){
        Swal.fire('Bien Hecho',resultado.mensaje,'success').then(result => {
            window.location.reload();
        })
       
        
    }
    
   } catch (error) {
    Swal.fire({
        title: 'Error',
        text: 'Ha ocurrido un error, no se pudo guardar la cita, Intente nuevamente',
        icon: 'error'
    }).then(()=>{
       location.reload();
    });
   }
}


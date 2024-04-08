let paso=1;const pasoInicial=1,pasoFinal=3,cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){tabs(),mostrarSeccion(),botonesPaginacion(),botonAnterior(),botonSiguiente(),obtenerServicios(),agregarFecha(),agregarHora(),agregarNombre(),agregarId()}async function obtenerServicios(){try{const e=location.origin+"/api/servicios",t=await fetch(e),o=await t.json();mostrarServicios(o)}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:o,precio:a}=e,n=document.createElement("P");n.textContent=o;const r=document.createElement("P");r.innerHTML=`<span>$${a}</span>`;const c=document.createElement("DIV");c.classList.add("servicio"),c.appendChild(n),c.appendChild(r),c.dataset.idServicio=t,c.onclick=()=>{seleccionarServicio({...e})},document.querySelector("#servicios").appendChild(c)})}function seleccionarServicio(e){const t=document.querySelector(`[data-id-servicio="${e.id}"]`);cita.servicios.some(t=>t.id===e.id)?(cita.servicios=cita.servicios.filter(t=>t.id!==e.id),t.classList.remove("seleccionado")):(cita.servicios=[...cita.servicios,e],t.classList.add("seleccionado"))}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",e=>{paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginacion()})})}function mostrarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");document.querySelector("#paso-"+paso).classList.add("mostrar");const t=document.querySelector(".actual");t&&t.classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function botonesPaginacion(){const e=document.querySelector("#anterior"),t=document.querySelector("#siguiente");1===paso?(e.classList.add("ocultar"),t.classList.remove("ocultar")):3===paso?(e.classList.remove("ocultar"),t.classList.add("ocultar"),mostrarResumen()):(e.classList.remove("ocultar"),t.classList.remove("ocultar"))}function botonAnterior(){document.querySelector("#anterior").addEventListener("click",()=>{--paso,paso<1||(mostrarSeccion(),botonesPaginacion())})}function botonSiguiente(){document.querySelector("#siguiente").addEventListener("click",()=>{++paso,paso>3||(mostrarSeccion(),botonesPaginacion())})}function agregarFecha(){document.querySelector("#fecha").addEventListener("input",e=>{const t=e.target.value,o=new Date(t).getDay();[5,6].includes(o)?(e.target.value="",mostrarAlerta("error","Fines de Semana no Disponible",".formulario")):cita.fecha=e.target.value})}function mostrarAlerta(e,t,o,a=!0){const n=document.querySelector(".alerta");n&&n.remove();const r=document.createElement("P");r.classList.add("alerta"),r.classList.add(e),r.textContent=t,document.querySelector(o).appendChild(r),a&&setTimeout(()=>{r.remove()},5e3)}function agregarHora(){document.querySelector("#hora").addEventListener("input",e=>{const t=e.target.value.split(":")[0];t<9||t>17?(e.target.value="",mostrarAlerta("error","Hora no Disponible",".formulario")):cita.hora=e.target.value})}function agregarNombre(){const e=document.querySelector("#nombre").value;cita.nombre=e}function agregarId(){cita.id=document.querySelector("#id").value}function mostrarResumen(){const e=document.querySelector(".contenido-resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("error","Faltan datos o Servicios",".contenido-resumen",desaparece=!1);const{nombre:t,fecha:o,hora:a,servicios:n}=cita,r=document.createElement("H2");r.textContent="Informacion de los Servicios",e.appendChild(r),n.forEach(t=>{const o=document.createElement("P");o.textContent=t.nombre;const a=document.createElement("P");a.innerHTML="$"+t.precio;const n=document.createElement("DIV");n.appendChild(o),n.appendChild(a),e.appendChild(n)});const c=document.createElement("H2");c.textContent="Informacion de la Cita";const i=document.createElement("p");i.innerHTML="<span>Cliente: </span> "+t;const s=document.createElement("p");s.innerHTML="<span>Fecha: </span> "+o;const d=document.createElement("p");d.innerHTML=`<span>Hora: </span> ${a} Horas`;const l=document.createElement("DIV");l.classList.add("servicios");const u=document.createElement("BUTTON");u.classList.add("boton"),u.textContent="Guardar Cita",u.onclick=()=>{guardarCita()},e.appendChild(c),l.appendChild(i),l.appendChild(s),l.appendChild(d),e.appendChild(l),e.appendChild(u)}async function guardarCita(){const{id:e,fecha:t,hora:o}=cita,a=cita.servicios.map(e=>e.id),n=new FormData;n.append("usuarioId",e),n.append("fecha",t),n.append("hora",o),n.append("servicios",a);try{const e="/api/citas",t=await fetch(e,{method:"POST",body:n}),o=await t.json();"exito"===o.tipo&&Swal.fire("Bien Hecho",o.mensaje,"success").then(e=>{window.location.reload()})}catch(e){Swal.fire({title:"Error",text:"Ha ocurrido un error, no se pudo guardar la cita, Intente nuevamente",icon:"error"}).then(()=>{location.reload()})}}document.addEventListener("DOMContentLoaded",()=>{iniciarApp()});
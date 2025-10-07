let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: [],
    id: ''
}


document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});


function iniciarApp() {
    
    mostrarSeccion(); // Muestra y oculta las secciones

    tabs(); // Cambia la seccion cuando se presiones los tabs

    botonesPaginador(); // Agrega o quita los botones de paginador
    paginaSiguiente();
    paginaAnterior();

    consultarAPI(); // Consulta la API en el backend de PHP

    idCliente();
    nombreCliente(); // Añade el nombre del cliente al objeto de cita
    seleccionarFecha(); // Añade la fecha de la cita en el objeto
    seleccionarHora(); // Añade la hora de la cita en el objeto
    
    mostrarResumen(); // Muestra el Resumen de la cita
}


function mostrarSeccion(e) {
    // Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');

    if(seccionAnterior) {
        seccionAnterior.classList.remove("mostrar");
    }

    // Seleccionar la seccion con el paso
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    // Quita la clase de actual al tab anterior
    const tabAnterior = document.querySelector(".actual");
    if(tabAnterior) {
        tabAnterior.classList.remove("actual");
    }

    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add("actual");
}


function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach( boton => {
        boton.addEventListener('click', function(e) {
            
            paso = parseInt( e.target.dataset.paso );            

            mostrarSeccion();
            botonesPaginador();
        });
    });
}


function botonesPaginador() {
    const paginaSiguiente = document.querySelector("#siguiente");
    const paginaAnterior = document.querySelector('#anterior');

    if(paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }else if(paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}


function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');

    paginaAnterior.addEventListener('click', function(e) {
        if(paso <= pasoInicial) return;
        paso--;

        botonesPaginador();
    });
}


function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');

    paginaSiguiente.addEventListener('click', function(e) {
        if(paso >= pasoFinal) return;
        paso++;

        botonesPaginador();
    });
}


// Para que el await funcione necesitamos que la funcion tenga el async
async function consultarAPI() {
    try {
        // location.origin = http://localhost:3000/  este atributo nos devuelve la url principal de nuestro proyecto
        //const url = `${location.origin}/api/servicios`;

        // const url = "localhost:3000/api/servicios"
        const url = '/api/servicios';
        // El await espera a que tenga todos los resultados de la api para que ejecute la siguiente linea de codigo
        const resultado = await fetch(url); // Detiene la ejecucion de la siguiente funcion hasta que no se complete
        const servicios = await resultado.json();

        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}


function mostrarServicios(servicios) {
    servicios.forEach( servicio => {
        const { id, nombre, precio   } = servicio; // Destructuring

        const nombreServicio = document.createElement("P");
        nombreServicio.classList.add("nombre-servicio");
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = "$" + precio;

        const servicioDiv = document.createElement("DIV");
        servicioDiv.classList.add("servicio");
        servicioDiv.dataset.idServicio = id; // Creando un atributo para nuestro contenedor

        servicioDiv.onclick = function() { // Evento cuando le demos click a un servicio
            seleccionarServicio(servicio);
        } 

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

       document.querySelector("#servicios").appendChild(servicioDiv);
    });
}


function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    // Identificar al elemento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya fue agregado 
    if( servicios.some( agregado => agregado.id === id ) ) { // some() nos devuelve true o false si se cumple o no una condicion
        // Eliminarlo
        cita.servicios = servicios.filter( agregado => agregado.id != id);
        divServicio.classList.remove("seleccionado");    
    }else {
        // Agregarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
}


function idCliente() {
    cita.id = document.querySelector("#id").value;
}

function nombreCliente() {
    cita.nombre = document.querySelector("#nombre").value; 
}


function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e) {
        
        const dia = new Date(e.target.value).getUTCDay(); // Nos retorna el numero del dia Ej. lunes 1, miercoes 3, sabado 6

        if( [6, 0].includes(dia) ) {
            e.target.value = '';
            mostrarAlerta("Fines de semana no permitidos", 'error', "#paso-2 p");

        }else {
            cita.fecha = e.target.value;
        }   
    });
}

function seleccionarHora() {
    const inputHora = document.querySelector("#hora");
    inputHora.addEventListener("input", function(e) {

        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];

        if(hora < 10 || hora > 18) {
            e.target.value = '';
            mostrarAlerta("Hora No Válida", "error", "#paso-2 p");
        }else {
            cita.hora = e.target.value;
        }
    });
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    // Previene que se genere mas de una alerta
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alertaPrevia.remove();
    }
 
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;

    alerta.classList.add("alerta");
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece) {
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
  
}

function mostrarResumen() {
    const resumen = document.querySelector(".contenido-resumen");

    // Limpiar el contenido de Resumen
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes("") || cita.servicios.length === 0) {
        mostrarAlerta("Faltan datos de Servicios, Fecha u Hora", "error", ".contenido-resumen", false);
        return;
    }

    // Formatear el div de resumen 
    const { nombre, fecha, hora, servicios } = cita;

    // Heading para Servicios en Resumen
    const headingServicios = document.createElement("H3");
    headingServicios.textContent = "Resumen de Servicios";
    resumen.appendChild(headingServicios);

    // Iterando y mostrando los servicios
    servicios.forEach( servicio => {
        const { id, precio, nombre } = servicio;

        const contenedorServicio = document.createElement("DIV");
        contenedorServicio.classList.add("contenedor-servicio");
    
        const textoServicio = document.createElement("p");
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement("P");
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    }); 

    // Heading para Cita en Resumen
    const headingCita = document.createElement("H3");
    headingCita.textContent = "Resumen de Cita";
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Formatear la fecha en español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date( Date.UTC(year, mes, dia) );
    
    const opciones = { weekday: "long", year: 'numeric', month: 'long', day: 'numeric' };
    const fechaFormateada = fechaUTC.toLocaleDateString("es-CO", opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;
    
    // Boton para Crear un cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add("boton");
    botonReservar.textContent = "Reservar Cita";
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);
}

async function reservarCita() {
    const { nombre, fecha, hora, servicios, id  } = cita;

    const idServicios = servicios.map( servicio => servicio.id ); // Con el map puede hacer que nos retorne un solo valor, por ejemplo en este caso nos esta retornando los id de los servicios

    // Enviar datos al servidor
    const datos = new FormData(); // FormData Es como un submit de HTML pero en JavaScript
    datos.append("usuarioId", id); // De esta manera podemos encapsular los datos en un json para luego enviarselos por medio de una API
    datos.append("fecha", fecha);
    datos.append("hora", hora); // La parte de la izquierda el nombre que va a recibir en el otro lado, en nuestra funcion de la api en php Ej. $_POST['fecha'];
    datos.append("servicios", idServicios);

    // console.log([...datos]);  De esta manera podemos ver los datos que estamos enviando por medio de FormData

    //Petición hacia la api

    try {
        const url = "/api/citas";
        const respuesta = await fetch(url, { // Cuando es un post obligatoriamente tenemos que escribir "method: 'POST'" cuando tenemos que mandar por medio de post
            method: "POST",
            body: datos // body es el cuerpo de la peticion, su valor son los datos que le vamos a enviar por medio del FormData
        });
    
        const resultado = await respuesta.json();
        
        if(resultado.resultado) {
            Swal.fire({
                icon: 'success',
                title: 'Cita Creada',
                text: 'Tu cita fue creada correctamente!',
                button: 'OK' 
            }).then( () => { // Ya cuando el usuario crea su cita se recargara la pagina
                setTimeout(() => {
                    window.location.reload();
                }, 3000)  
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardar la cita!',
        })
    }
}

const tabs = ["asignaciones", "clase", "participantes"];

this.instructorSeleccionado = null;
this.claseSeleccionada = null;
this.backgrounds = ["empty_states_students.png", "img_bookclub.jpg", "img_breakfast.jpg", "img_code.jpg", "img_graduation.jpg", "img_reachout.jpg", "img_read.jpg"];
this.backgroundsAsignados = {};



showTab = (nombreTab, idTab) => {
  if(nombreTab == "asignaciones"){
    reenderizarAsignaciones();
  }else if(nombreTab == "participantes"){
    reenderizarParticipantes();
  }

  tabs.forEach(tab => {
    document.getElementById(tab).style.display="none";
    document.getElementById('tab-' + tab).classList.remove("active");
  });

  document.getElementById(nombreTab).style.display="block";
  document.getElementById('tab-' + nombreTab).classList.add("active");
}

showClass = (idClase) => {
  reenderizarClaseSeleccionada(idClase);
  

  tabs.forEach(tab => {
    document.getElementById(tab).style.display="none";
  });
  document.getElementById('clases-principal').style.display="none";
  document.getElementById('tabs').style.display="block";
  document.getElementById('clase').style.display="block";
}

showClasses = () => {
  document.getElementById('clases-principal').style.display="block";
  document.getElementById('tabs').style.display="none";
  document.getElementById('clase').style.display="none";
}




// Registrar instructor

function registrarInstructor(){
  instructor = {
    usuario: document.getElementById("txt-usuario-instructor").value,
    password: document.getElementById("txt-contraseña-instructor").value,
    nombre: document.getElementById("txt-nombre-instructor").value,
    imagen:document.getElementById("txt-imagen-instructor").value,
    clases: []
  }

  url = `../backend/api/instructores.php`;
  axios({
    method: 'post',
    url: url,
    responseType: 'json',
    data: instructor
  }).then(res=>{
      console.log(res.data);
      reenderizarInstructores();

  }).catch(error=>{ 
      console.error(error);
  });


}


// Para los participantes

function registrarEstudiante(){
  clase = {
    id: this.claseSeleccionada.id,
    clase: this.claseSeleccionada.nombreClase,
  };

  estudiante = {
    nombre: document.getElementById("txt-nombre-estudiante").value,
    imagen: `${document.getElementById("txt-imagen-estudiante").value}`,
    clases: [clase]
  }
  url = `../backend/api/participantes.php`;
  axios({
    method: 'post',
    url: url,
    responseType: 'json',
    data: estudiante
  }).then(res=>{
      console.log(res.data);
      reenderizarParticipantes();

  }).catch(error=>{ 
      console.error(error);
  });
}

function reenderizarParticipantes(){
  url = `../backend/api/participantes.php`;
  document.getElementById("contenido-participantes").innerHTML= "";
  axios({
    method: 'GET',
    url: url,
    responseType: 'json'
  }).then(res=>{
      res.data.forEach(participante => {
        clases = participante.clases;
        clases.forEach(clase => {

          
          if(clase.id == this.claseSeleccionada.id){
          
            document.getElementById("contenido-participantes").innerHTML+= `
            <div class="col-4">
              <p class="card-text p-2">
                <img src=" img/profile-pics/${participante.imagen}" class="rounded-circle pp">
                <span class="h6">${participante.nombre}</span>
              </p>
            </div>
            `;
          }
        });
      });

  }).catch(error=>{ 
      console.error(error);
  });
}

// Para las asignaciones

function registrarAsignacion(){
  fechaActual = obtenerFechaActual();
  asignacion = {
    idClaseAsignar: this.claseSeleccionada.id,
    titulo: document.getElementById("txt-nombre-asignacion").value,
    fecha: fechaActual["fecha"],
    hora: fechaActual["hora"],
    puntos:document.getElementById("txt-puntos-asignacion").value
  }
  url = `../backend/api/clases.php`
  axios({
    method: 'PUT',
    url: url,
    responseType: 'json',
    data: asignacion
  }).then(res=>{
      console.log(res.data);
      reenderizarAsignaciones();

  }).catch(error=>{ 
      console.error(error);
  });

}
function reenderizarAsignaciones(){
  document.getElementById("contenido-asignaciones").innerHTML = "";
  this.claseSeleccionada.asignaciones.forEach(asignacion => {
    document.getElementById("contenido-asignaciones").innerHTML += `
    
    <div class="col-12">
      <p class="card-text p-2 d-flex align-items-center">
        <span class="rounded-circle icon-bg mx-2">
          <svg focusable="false" width="24" height="24" viewBox="0 0 24 24" class=" NMm5M hhikbc" fill="#ffffff"><path d="M7 15h7v2H7zm0-4h10v2H7zm0-4h10v2H7z"></path><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-.14 0-.27.01-.4.04a2.008 2.008 0 0 0-1.44 1.19c-.1.23-.16.49-.16.77v14c0 .27.06.54.16.78s.25.45.43.64c.27.27.62.47 1.01.55.13.02.26.03.4.03h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7-.25c.41 0 .75.34.75.75s-.34.75-.75.75-.75-.34-.75-.75.34-.75.75-.75zM19 19H5V5h14v14z"></path></svg>
        </span>
        <span class="h6 mx-2 mb-0">${asignacion.titulo}</span>
        <span class="small text-muted mx-2">${asignacion.fecha} | ${asignacion.hora} | ${asignacion.puntos}</span>
      </p>
    </div>    
`
  });

  

}

// Para las clases

function generarAleatorio(max, min){
  aleatorio = Math.floor((Math.random()* max - min) + min);
  
  return aleatorio;
}

function anunciar(){
  fechaActual = obtenerFechaActual();
  let anuncio = {
    idClaseAnunciar : this.claseSeleccionada.id,
    mensaje: document.getElementById("txt-anunciar").value,
    fecha: fechaActual["fecha"],
    hora: fechaActual["hora"],
    comentarios: []
  }

  url = `../backend/api/clases.php`
  axios({
    method: 'PUT',
    url: url,
    responseType: 'json',
    data: anuncio
  }).then(res=>{
      console.log(res.data);
      reenderizarClaseSeleccionada(this.claseSeleccionada.id);

  }).catch(error=>{ 
      console.error(error);
  });
}

function comentar(idAnuncio, indice){
  fechaActual = obtenerFechaActual();
  comentario = {
    idClaseComentar: this.claseSeleccionada.id,
    idAnuncio: idAnuncio,
    usuario: this.instructorSeleccionado.usuario,
    mensaje: document.getElementById(`comentario-${indice}`).value,
    fecha: fechaActual["fecha"],
    hora: fechaActual["hora"]
  }

  url = `../backend/api/clases.php`;
  axios({
    method: 'PUT',
    url: url,
    responseType: 'json',
    data: comentario
  }).then(res=>{
      console.log(res.data);
      reenderizarClaseSeleccionada(this.claseSeleccionada.id);

  }).catch(error=>{ 
      console.error(error);
  });
}

function registrarClase(){
  let indexBackground = generarAleatorio(this.backgrounds.length, 0);
  nombreClase = document.getElementById("txt-nombre-clase").value;
  clase = {
    seccion: document.getElementById("txt-seccion-clase").value,
    nombreClase: nombreClase,
    banner: this.background[indexBackground],
    descripcion: document.getElementById("txt-descripcion-clase").value,
    aula: document.getElementById("txt-aula-clase").value,
    asignaciones: [],
    anuncios: []
  }
  ur = `../backend/api/clases.php`;
  axios({
    method: 'post',
    url: url,
    responseType: 'json',
    data: clase
  }).then(res=>{
      console.log(res.data);
      if(res.data){
        asignarClaseInstructor(res.data, nombreClase);
      }
      

  }).catch(error=>{ 
      console.error(error);
  });

}

function asignarClaseInstructor(idClase, nombreClase){
  url = `../backend/api/instructores.php`
  data = {
    idClase: idClase,
    nombreClase: nombreClase,
    idInstructor: this.instructorSeleccionado.id
  };
  axios({
    method: 'PUT',
    url: url,
    responseType: 'json',
    data: data
  }).then(res=>{
      console.log(res.data);
      reenderizarClasesPrincipal();

  }).catch(error=>{ 
      console.error(error);
  });

}


function reenderizarClaseSeleccionada(idClase){
  url = `../backend/api/clases.php?idClase=${idClase}`;
  axios({
    method: 'GET',
    url: url,
    responseType: 'json'
  }).then(res=>{
      console.log(res.data);
    this.claseSeleccionada = res.data;

    background = this.backgroundsAsignados[this.claseSeleccionada.id];

    document.getElementById("contenido-clase").innerHTML= "";
    document.getElementById("contenido-clase").innerHTML+= `
    
    <div class="col-lg-12 mx-auto">
    <span class="btn btn-link" onclick="showClasses()">Ver clases</span>
    <div class="card shadow-sm mb-3">
      <div class="card-img-top w-full c-full p-5" style="background-image: url( img/backgrounds/${background});">
        <span class="h3 text-white">${this.claseSeleccionada.nombreClase}</span><br>
        <span class="small text-white">${this.claseSeleccionada.seccion}</span>
      </div>
      <div class="card-body">
        <p class="card-text">
          <span class="text-dark">Descripción: ${this.claseSeleccionada.descripcion}</span><br>
          <span class="small text-muted">Aula: ${this.claseSeleccionada.aula}</span>
        </p>
      </div>
    </div>
    <div class="row">
      <!-- Por evaluar -->
      <div class="col-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <p class="card-text">
              <span class="text-dark">Por evaluar</span><br>
              <hr>
              <ul>
                ${obtenerHTMLPorEvaluar(this.claseSeleccionada.asignaciones)}
              </ul>
            </p>
          </div>
        </div>
      </div>
      
      <div class="col-9">
        <!-- Compartir con la clase -->
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <p class="card-text">
              
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <img src=" img/profile-pics/${this.instructorSeleccionado.imagen}" class="rounded-circle pp-small">
              <div class="input-group mb-3">
                <input  type="text" class="form-control" name="" id="txt-anunciar" placeholder="Anunciar algo a tu clase">
                <button onclick="anunciar();" class="btn btn-outline-secondary" type="button" id="button-addon2">Send</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Comentarios Instructor -->
        ${obtenerHTMLAnunciosInstructor(this.claseSeleccionada.anuncios)}
        
      </div>
    </div>    
`;

  }).catch(error=>{ 
      console.error(error);
  });
}

function obtenerHTMLPorEvaluar(evaluaciones = []){
  html = "";
  evaluaciones.forEach(evaluacion => {
    html += `
    <li><span class="small text-muted">${evaluacion.titulo} (${evaluacion.fecha})</span></li>
    `
  });
  return html;
}

function obtenerHTMLAnunciosInstructor(anuncios=[]){
  html = "";
  var conta = 1;
  anuncios.forEach(anuncio => {
    html+= `
    
    <div class="card shadow-sm mb-3">
      <div class="card-body">
        <p class="card-text">
          <img src=" img/profile-pics/${this.instructorSeleccionado.imagen}" class="rounded-circle pp">
          <span class="h6">${this.instructorSeleccionado.usuario}</span>
          <span class="small text-muted">${anuncio.hora}</span>
        </p>
        <p>
          ${anuncio.mensaje}
        </p>
        <hr>
        <!-- Respuestas -->
        ${obtenerHTMLComentarios(anuncio.comentarios)}
        <div class="d-flex justify-content-between align-items-center">
          <div class="input-group mb-3">
            <input  type="text" class="form-control" name="" id="comentario-${conta}" placeholder="Nuevo comentario">
            <button onclick="comentar(${anuncio.id}, ${conta});" class="btn btn-outline-secondary" type="button" id="button-addon2">Send</button>
          </div>
        </div>
      </div>
    </div>
    `
    conta ++;
  });
  return html;
}

function obtenerHTMLComentarios(comentarios = []){
  html = "";
  comentarios.forEach(comentario => {
    html+= `
    <div class="ms-4">
      <p class="text-muted">
        <span class="h6">${comentario.usuario} </span><span class="small text-muted">${comentario.hora})</span> : ${comentario.mensaje}
      </p>
    </div>
    `
  });

  return html;

}
function reenderizarClasesPrincipal(){
  reenderizarMiniaturasClase();
  if(this.instructorSeleccionado){
    clases = this.instructorSeleccionado.clases;
    document.getElementById("clases-principal").innerHTML= "";
    clases.forEach(clase => {
     obtenerClase(clase.id).then(res =>{
          let htmlTareas = obtenerHTMLTareas(res.data.asignaciones);
          actualizacion = 0;
          if(res.data.asignaciones.length > 0){
            let ultimaAsignacion = res.data.asignaciones[res.data.asignaciones.length-1]
            actualizacion = ultimaActualizacionTarea(ultimaAsignacion.fecha, ultimaAsignacion.hora);
          }
          background = this.backgroundsAsignados[clase.id];
        
          document.getElementById("clases-principal").innerHTML+= `
          <div class="col">
            <div class="card shadow-sm">
              <div class="card-img-top w-full course-top p-2" style="background-image: url(img/backgrounds/${background});">
                <span class="h3 text-white">${clase.nombreClase}</span><br>
                <span class="small text-white">${res.data.seccion}</span>
              </div>

              <div class="card-body">
                ${htmlTareas}
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button type="button" onclick="showClass(${res.data.id})" class="btn btn-sm btn-outline-secondary">Ver</button>
                  </div>
                  <small class="text-muted">${Math.floor(actualizacion/60)} mins</small>
                </div>
              </div>
            </div>
        </div>      
      `;

        })
      
      
    });
  }
}

function ultimaActualizacionTarea(fecha, hora){
  let ultimaActualizacion = {
    fecha: fecha,
    hora: hora
  }
  difFecha = diferenciaFecha(ultimaActualizacion);
  segundos = difFecha / (1000)
  return segundos;
}

function obtenerFechaActual(){
  let fechaActual = new Date();
  horas = fechaActual.getHours();
  let ampm = horas >= 12 ? 'pm' : 'am';
  
  tiempoActual = {
    fecha: `${fechaActual.getDate()}/${fechaActual.getMonth()}/${fechaActual.getFullYear()}`,
    hora: `${fechaActual.getHours()}:${fechaActual.getMinutes()}${ampm}`
  };
  return tiempoActual;
}



function diferenciaFecha(tiempoInicial){
  año = tiempoInicial["fecha"].split("/")[2];
  mes = tiempoInicial["fecha"].split("/")[1];
  dia = tiempoInicial["fecha"].split("/")[0];

  hora = tiempoInicial["hora"].split(":")[0];
  minutos = tiempoInicial["hora"].split(":")[1];
  minutos.replace("am","");
  minutos.replace("pm","");

  fechaInicio =  new Date(parseInt(año), parseInt(mes), parseInt(dia), parseInt(hora), parseInt(minutos));

  fechaFinal =  new Date();
  difFecha = fechaFinal - fechaInicio;
  
  return difFecha;
  
}



function obtenerHTMLTareas(asignaciones = []){
  let htmlTareas = "";
  asignaciones.forEach(asignacion => {
    htmlTareas+= `
    <p class="card-text">
      <span class="text-dark">${asignacion.titulo}</span><br>
      <span class="small text-muted">${asignacion.fecha}</span>
    </p>
    `;
  });
  return htmlTareas;
}

function reenderizarMiniaturasClase(){
  if(this.instructorSeleccionado){
    document.getElementById("miniaturas-clases").innerHTML= "";
    this.backgroundsAsignados = {};
    clases = this.instructorSeleccionado.clases;
    clases.forEach(clase => {
      let indexBackground = generarAleatorio(this.backgrounds.length, 0);
      background = this.backgrounds[indexBackground];
      this.backgroundsAsignados[clase.id] = background;
      document.getElementById("miniaturas-clases").innerHTML+=`
      <div class="col-2 py-4">
        <div class="card">
          <div class="card-body course-thumb" onclick="showClass(${clase.id})" style="background-image: url(img/backgrounds/${background});">
            <h5 class="text-white">${clase.nombreClase}</h5>
          </div>
        </div>
      </div>      
`
    });
  }
}

// Para los instructores
function seleccionarInstructor(idInstructor){
  url = `../backend/api/instructores.php?idInstructor=${idInstructor}`;
  axios({
    method: 'GET',
    url: url,
    responseType: 'json'
  }).then(instructor=>{
      this.instructorSeleccionado = instructor.data;
      document.getElementById("img-perfil").innerHTML = `<img src="img/profile-pics/${instructor.data.imagen}" onclick="reenderizarInstructores();" class="rounded-circle pp-small">`
      reenderizarClasesPrincipal();
  }).catch(error=>{ 
      console.error(error);
  });
}

function reenderizarInstructores(){
  document.getElementById("instructores").innerHTML = "";
  url = `../backend/api/instructores.php`
  axios({
    method: 'GET',
    url: url,
    responseType: 'json'
  }).then(instructores=>{
    instructores.data.forEach(instructor => {
        document.getElementById("instructores").innerHTML += `
        <img onclick="seleccionarInstructor(${instructor.id});" src="img/profile-pics/${instructor.imagen}" class="rounded-circle pp-small btn-circle">  
        `
      });
      document.getElementById("instructores").innerHTML += `
      <img src="img/icons/add.png" class="rounded-circle pp-small btn-circle" data-bs-toggle="modal" data-bs-target="#modal-registro-instructores" class="btn btn-primary" title="Nuevo instructor">
      `
  }).catch(error=>{ 
      console.error(error);
  });
  
}

function obtenerClase(idClase){
  url = `../backend/api/clases.php?idClase=${idClase}`;
  let consulta = axios({
    method: 'GET',
    url: url,
    responseType: 'json'
  });

  return consulta;
}


if(this.instructorSeleccionado){
  reenderizarClasesPrincipal();
}



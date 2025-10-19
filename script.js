function mostrarSeccion(id) {
  const secciones = ['afiliacion', 'acceso', 'recuperar'];
  secciones.forEach(sec => {
    document.getElementById(sec).classList.add('oculto');
  });
  document.getElementById(id).classList.remove('oculto');
}

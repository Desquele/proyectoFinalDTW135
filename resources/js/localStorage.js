// Función para guardar en localStorage
window.saveToLocal = function(key, value) {
  try {

    // Convirtiendo el valor a cadena para almacenarlo
    localStorage.setItem(key, JSON.stringify(value));
  } catch (e) {
    // Si algo falla, indigamos por consola que hubo un error
    console.error('Error guardando en localStorage', e);
  }
};

// Función que lee valor de localStorage por su clave
window.getFromLocal = function(key) {
  try {

    // Obtenemos la cadena que se guardó
    const data = localStorage.getItem(key);

    // Si existe, la parseamos al valor original; si no, devolvemos un null
    return data ? JSON.parse(data) : null;
  } catch (e) {
    // Capturamos errores al momento de parsear
    console.error('Error leyendo de localStorage', e);
    return null;
  }
};

// Al cargar el DOM, intentamos recuperar un dato de ejemplo
document.addEventListener('DOMContentLoaded', () => {
  const valor = window.getFromLocal('miDato');
  if (valor) {
    // Si había un valor guardado, lo mostramos en consola
    console.log('Valor recuperado de localStorage:', valor);
  }
});

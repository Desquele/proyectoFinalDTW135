// Función para guardar en sessionStorage
window.saveToSession = function(key, value) {
  try {
    // Convirtiendo el valor a cadena para almacenarlo
    sessionStorage.setItem(key, JSON.stringify(value));
  } catch (e) {
    // Si algo falla, indigamos por consola que hubo un error
    console.error('Error guardando en sessionStorage', e);
  }
};

// Función que lee valor de sessionStorage por su clave
window.getFromSession = function(key) {
  try {
    // Obtenemos la cadena que se guardó
    const data = sessionStorage.getItem(key);
    // Si existe, la parseamos al valor original; si no, devolvemos un null
    return data ? JSON.parse(data) : null;
  } catch (e) {
    // Capturamos errores al momento de parsear
    console.error('Error leyendo de sessionStorage', e);
    return null;
  }
};

// Cuando la pestaña esté por cerrarse, mostramos todo lo que hay en sessionStorage
window.addEventListener('beforeunload', () => {
  console.log('Sesión va a terminar, datos en sessionStorage:', sessionStorage);
});

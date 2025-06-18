
# Proyecto Final - Aplicación Web con Laravel 12 - DTW135 GT02

Integrantes:  
- Douglas Enrique Siguenza Quele  
- Salvador Isaías Juárez Alcántara  
- Guillermo Alexander Rodríguez Cortez  

---

## Requisitos

Asegúrate de tener instalado lo siguiente:

1. **Herd** → [Descargar Herd](https://herd.laravel.com/)  
2. **Git** → [Descargar Git](https://git-scm.com/)  
3. **Node.js y npm** → [Descargar Node.js](https://nodejs.org/)  
4. **MySQL Workbench** u otro cliente de base de datos  
5. **Visual Studio Code** u otro IDE compatible  

---

## Clonación del Proyecto

```bash
git clone <URL_DEL_REPOSITORIO>
cd nombre_del_proyecto
```

---

## Instalación de Dependencias

### Dependencias PHP (Laravel)

```bash
composer install
```

### Dependencias de Node

```bash
npm install
```

---

## Configuración del Entorno

1. Crear un archivo `.env` a partir de `.env.example`
2. Configurar la base de datos:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=root
DB_PASSWORD=1234
```

3. Generar clave de la aplicación:

```bash
php artisan key:generate
```

---

## Migraciones y Datos

```bash
php artisan migrate
php artisan db:seed
```

---

## Levantar el Proyecto

Opción 1: Usar Herd (recomendado)  
Opción 2: Servidor embebido de PHP

```bash
php -S 127.0.0.1:8081 -t public
```

Luego abrir en el navegador:

```
http://127.0.0.1:8081
```

---

## Acceso al Proyecto

Puedes acceder usando:

- **Usuario:** `usuario`
- **Contraseña:** `1234`
- **Usuario:** `admin`
- **Contraseña:** `1234`

---

## Funcionalidades Implementadas

### Lista y creación de Tickets

- Creación de tickets.
- Gestión de tickets para cada usuario

![creación](https://github.com/user-attachments/assets/d46fca37-6712-4b35-ab62-92215e36b16f)


![Lista](https://github.com/user-attachments/assets/0decd8fb-3cad-421c-b6c4-c9264a03a503)


![edición](https://github.com/user-attachments/assets/9b4cdcba-9549-4c08-a132-36901b2d7a02)


---

### Visualización de tipo de cambios de monedas

- Lista que proporciona el valor de 1 USD convertido a múltiples monedas

![monedas](https://github.com/user-attachments/assets/9ab68ada-9510-465d-bd52-be37fd57099c)



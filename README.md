# 🚀 Configuración del Entorno con Docker

Este proyecto utiliza **Docker** para levantar un entorno de desarrollo con **MySQL**, **phpMyAdmin** y **PHP-Apache**.

## 📌 Requisitos

- **Docker** instalado en tu sistema.
- Archivo **`docker-compose.yml`** configurado.
- Archivos **`.env`** para la configuración de variables de entorno.

---

## 📂 Archivos necesarios

### 1️⃣ `docker-compose.yml`

Este archivo define los servicios de **MySQL** y **phpMyAdmin**

```yaml
version: '3.1'
services:
  mysql:
    image: mysql:${MYSQL_VERSION}
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
    volumes:
      - ./mysql/:/var/lib/mysql
    ports:
      - ${MYSQL_PORT}:3306
    container_name: mysql_server
    networks:
      red_interna:
        ipv4_address: 172.20.0.21

  phpmyadmin:
    image: phpmyadmin:${PHPMYADMIN_VERSION}
    restart: always
    environment:
      PMA_HOST: mysql
    ports:
      - ${PHPMYADMIN_PORT}:80
    depends_on:
      - mysql
    links:
      - mysql
    networks:
      red_interna:
        ipv4_address: 172.20.0.22

networks:
  red_interna:
    ipam:
      config:
        - subnet: 172.20.0.0/16
```

---

### 2️⃣ `.env` para MySQL y phpMyAdmin

credenciales de acceso.

```env
MYSQL_VERSION=5.7
MYSQL_ROOT_PASSWORD=12345!
MYSQL_PORT=3308
PHPMYADMIN_VERSION=5.2.1-apache
PHPMYADMIN_PORT=8080
```

---

### 3️⃣ `.env` para PHP-Apache

 variables de entorno necesarias para la conexión con MySQL.

```env
MYSQLSERVER=mysql_server
TZ=America/Argentina/Buenos_Aires
APACHE_LIST_PORT=3000
MYSQL_USER=listTask
MYSQL_PASSWORD=listcomplete
DB_NAME_LIST=listtask
RED_NOW=basededato_red_interna
PHP_IP_ADDRESS=172.20.0.21
```

---

## ▶️ Cómo ejecutar el entorno

1️⃣ Clona el repositorio y ubícate en la carpeta del proyecto.\
2️⃣ Crea los archivos `.env` con las configuraciones adecuadas.\
3️⃣ Ejecuta el siguiente comando para levantar los contenedores:

```sh
docker-compose up -d
```

4️⃣ Para ver los contenedores en ejecución:

```sh
docker ps
```

5️⃣ Accede a **phpMyAdmin** en tu navegador:

```
http://localhost:8080
```

---




5️⃣ Accede a **al proyecto** en tu navegador:

```
http://localhost:3000
```

---


## 📂 se creo la estructura mvc para nuestro proyecto que consta de una carpeta controllers(para controladores), models(modelos),views(para las vista)
## public (para los estilos, js y para la plantilla admin-lte)


# ListTask - Base de Datos

ListTask es un sistema de gestión de tareas que permite a los usuarios organizar sus pendientes de manera eficiente. A continuación, se detallan las tablas utilizadas en la base de datos y su estructura.

## Estructura de la Base de Datos

### Tabla `users`
Esta tabla almacena la información de los usuarios registrados en el sistema.

| Campo       | Tipo de Dato      | Restricciones                                      |
|------------|----------------|--------------------------------------------------|
| id         | INT             | AUTO_INCREMENT, PRIMARY KEY                      |
| name       | VARCHAR(100)    | NOT NULL                                        |
| last_name  | VARCHAR(100)    | NOT NULL                                        |
| mail       | VARCHAR(255)    | UNIQUE, NOT NULL                                |
| phone      | VARCHAR(15)     | Puede ser NULL                                  |
| status     | ENUM            | Valores: 'activo', 'inactivo'. Default: 'activo' |
| created_at | TIMESTAMP       | Default: CURRENT_TIMESTAMP                      |

### Tabla `tasks`
Esta tabla almacena las tareas creadas por los usuarios.

| Campo         | Tipo de Dato   | Restricciones                                      |
|--------------|---------------|--------------------------------------------------|
| id           | INT           | AUTO_INCREMENT, PRIMARY KEY                      |
| title        | VARCHAR(255)  | NOT NULL                                        |
| description  | TEXT          | Puede ser NULL                                  |
| priority     | ENUM          | Valores: 'baja', 'media', 'alta'. Default: 'media' |
| reminder_date| DATETIME      | Puede ser NULL                                  |
| fk_id_user   | INT           | FOREIGN KEY (users.id), ON DELETE CASCADE       |
| created_at   | TIMESTAMP     | Default: CURRENT_TIMESTAMP                      |


🚀 Mejoras y Modificaciones Recientes
🔧 Base de Datos
Se modificó la estructura de la tabla users, cambiando el campo status de tipo ENUM a TINYINT(2).
Se agregó una validación para evitar registros duplicados en la base de datos, asegurando que no se repitan correos electrónicos.

🎨 Cambios en el Diseño
Se separó el formulario de Login y Registro en dos vistas totalmente independientes, manteniendo estilos similares para coherencia visual.
Se agregó Bootstrap para mejorar la apariencia y responsividad de los formularios.

🛠️ Validaciones Implementadas
Nombre y Apellido:
Solo pueden contener letras (incluyendo caracteres acentuados y la letra ñ).
No pueden superar los 70 caracteres.
Correo Electrónico:
Se agregó validación para verificar que el formato del email sea correcto.
Se implementó una verificación para que no se repitan correos en la base de datos.

🛠️ Funcionalidad de Inicio de Sesión
Se implementó el sistema de login con validaciones para verificar si el correo y la contraseña existen en la base de datos.

🔹 Características:
Verificación de credenciales: Se consulta la base de datos para comprobar si el usuario ingresado existe.
Validación de contraseña: Se usa password_verify() para comparar la contraseña ingresada con la almacenada en la base de datos.
Gestión de sesiones: Si el usuario es válido, se almacenan en $_SESSION los datos necesarios para la autenticación.
Mensajes de error: Se muestran alertas en caso de datos incorrectos o campos vacíos.
Redirección: Si el login es exitoso, el usuario es enviado a Register.php.
📌 Ejemplo de Uso
El usuario ingresa su correo y contraseña en el formulario de login.
Se validan los datos y, si son correctos, se inicia la sesión.
Si la autenticación falla, se muestra un mensaje de error.

Se agregó una nueva tabla roles a la base de datos con las columnas id y details.
Los roles disponibles son normal y premium, ya que a futuro se planea incluir anuncios para los usuarios con la versión normal.


# 📧 Configuración de PHPMailer para Correos Automáticos

## 📌 Instalación  
```bash
composer require phpmailer/phpmailer

Se agrego al Proyecto
📁 vendor/phpmailer → Librería PHPMailer
📁 views/html → Plantillas html para enviar los correo con estilo

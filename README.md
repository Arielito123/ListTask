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

Cambios Realizados
SweetAlert Integration: Se agregó un script para manejar notificaciones y alertas personalizadas utilizando SweetAlert.
Integración con AdminLTE: Se incluyó la carpeta dist y el plugin necesario para implementar la plantilla AdminLTE.
Estructura de Módulos: Se creó una carpeta modules que contiene las partes reutilizables de la plantilla, como el head, footer y los scripts personalizados.
Gestión de Roles: Se añadió una carpeta getroles que maneja las vistas según los diferentes roles de usuario.
Punto de Control de Sesión: Se creó un archivo checkpoint que gestiona el inicio de sesión, las vistas y las redirecciones.
Cierre de Sesión: Se implementó un archivo para gestionar el cierre de sesión de los usuarios.
Carpeta de Imágenes: Se añadió una carpeta para almacenar las imágenes del proyecto.
Dashboard de Tareas: En la página principal (home), se presenta un resumen de las estadísticas de las tareas, mostrando la primera parte visual no mas:
Tareas sin asignar
Tareas en progreso
Tareas completadas

Gestión de Tareas - Integración de manageTasks

Se ha agregado la ruta en el archivo getNormal para controlar la vista de manageTasks. Esta nueva vista permite organizar las tareas en tres estados distintos:

Vista manageTasks

La vista manageTasks proporciona una interfaz con tres enlaces para organizar las tareas según su estado:

Sin asignar: Todas las tareas recién creadas aparecerán en esta categoría hasta que se les asigne un estado de progreso.

En progreso: Una vez que una tarea tenga asignado un estado de progreso, dejará de aparecer en "Sin asignar" y se moverá a esta sección.

Completadas: Aquí se listarán todas las tareas que han sido finalizadas.

✨ Gestión de Tareas - Actualización
Se ha creado la vista manageTask, junto con su controlador y modelo, para permitir la creación y visualización de tareas.

🔹 Modificación de la Base de Datos
Se añadieron dos nuevas tablas:

priority:

Contiene los niveles de prioridad de las tareas (Baja, Media, Alta).
Campos: id, detalle.
task_state:

Define el estado de la tarea (Sin asignar, En progreso, Completado).
Campos: id, detalle.
Ambas tablas están relacionadas como llaves foráneas en tasks.

📌 Nuevas Funcionalidades
✅ Se agregó la visualización de tareas sin asignar.
✅ Las tareas se muestran en formato de tarjetas, cada una con:

✏ Editar
❌ Eliminar
⏳ Mover a progreso
🔔 Notificación
Las tareas se cargan dinámicamente desde la base de datos. 🚀

🚀 Mejoras Implementadas

Se han realizado las siguientes mejoras en el sistema de gestión de tareas:

🔧 Funcionalidades Agregadas

Edición de tareas: Ahora los usuarios pueden modificar sus tareas existentes.
Eliminación de tareas: Se ha añadido la opción para eliminar tareas de manera sencilla.
Cambio de estado a 'En Progreso': Se implementó la funcionalidad para mover una tarea al estado de progreso con un solo clic.
🔔 Control de Notificaciones

Se agregó un nuevo campo task_notification en la tabla task.
Este campo permite gestionar las notificaciones de cada tarea.
Al presionar el botón "Activar Notificación", el valor de task_notification cambia de 0 a 1, activando así las notificaciones para la tarea seleccionada.
Nota: Si la notificación está activa (task_notification = 1), el botón de activar notificación se oculta, evitando que se pueda activar nuevamente.
📊 Modificación en la Consulta de Datos

Se actualizó la consulta data_task para que cada usuario solo pueda visualizar las tareas que ha creado.

se agrego un boton de prueba en unnasignedtask temporal para poder configurar los email y despues pasarlo al crontab

# Configuración del Envio Automático de Emails

Para permitir el envío automático de correos electrónicos mediante `crontab`, se ha realizado una modificación en la estructura del proyecto.

## Reubicación del Archivo `NotificationController.php`

El archivo `NotificationController.php` ha sido movido desde la carpeta `controllers/` a la misma ubicación que el `index.php`. Esto se hizo para garantizar su correcta ejecución en el entorno de Docker y facilitar su acceso desde `crontab`.

## Configuración de `crontab`

Para programar la ejecución automática del `NotificationController.php`, sigue estos pasos:

1. Abre el archivo de tareas programadas de `crontab` con permisos de superusuario:
   
   sudo crontab -e
  

2. Agrega la siguiente línea al final del archivo para ejecutar el `NotificationController.php` de manera continua:
   
   sudo docker exec -i list bash -c "cd /var/www/html && php NotificationController.php"
   

Esto asegurará que el envío de emails se realice automáticamente en segundo plano dentro del contenedor Docker.

📝 Actualización del Sistema de Tareas
🚀 Nuevas Funcionalidades
Se han agregado las siguientes mejoras en la gestión de tareas:

📌 Vista de Tareas en Progreso
Ahora es posible visualizar las tareas que están en curso.
✅ Botón para Completar una Tarea
Se ha añadido un botón que permite marcar una tarea como completada.
🔄 Botón para Devolver a "Sin Asignar"
Se incorporó una opción para devolver una tarea a estado "Sin Asignar" en caso de que sea necesario.
🛠️ Instrucciones
Accede a la nueva vista de Tareas en Progreso.



📝 Actualización del Sistema de Tareas
🚀 Nuevas Funcionalidades
Se han agregado las siguientes mejoras en la gestión de tareas:

🎯 Vista de Tareas Completadas
Ahora es posible visualizar todas las tareas que han sido marcadas como completadas.
🔄 Botón para Devolver a "Sin Asignar"
Se ha añadido un botón que permite revertir una tarea completada a estado "Sin Asignar", en caso de ser necesario.

Última Modificación en la Base de Datos
Se realizó una actualización en la tabla tasks, agregando un nuevo campo llamado send_email. Este campo tiene el siguiente comportamiento:

Valor Predeterminado: 0
Cuando se envía el correo: Se actualiza a 1 para indicar que el correo ha sido enviado y evitar que la notificación siga apareciendo después del recordatorio.
Cambios en la Interfaz
Además, se eliminaron los botones de notificación de las tareas en los estados progressTask y completedTask para simplificar la interacción y evitar redundancias en las notificaciones.

Validación de botones según la fecha de finalización de la tarea
Se implementó una validación para ocultar los botones de Editar, Pasar a Progreso, pasar a completada y a sin asignar de los siguientes archivos
unnasignedtask,progressTask y completedTask 
y Notificaciones cuando la tarea ha alcanzado su fecha de finalización. 
Esto evita modificaciones en tareas que ya han concluido y mejora la integridad del sistema.

✨ Nueva Funcionalidad: Eliminación de Tareas ✨
Ahora puedes eliminar tareas en progreso y completadas de manera sencilla con el nuevo botón de eliminación. 🔥
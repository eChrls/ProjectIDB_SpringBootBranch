## README: Despliegue de Base de Datos, Spring Boot y PHP con Docker

Esta guía describe los pasos para desplegar una base de datos MySQL, una aplicación Spring Boot y una aplicación PHP utilizando Docker. Se asume que tiene Docker instalado en su sistema.

**Este repositorio forma parte de un proyecto de prácticas del primer curso del Grado Superior de Desarrollo de Aplicaciones Web (DAW) del IES Mar de Alborán.**

### Prerrequisitos

1.  **Instalación de Docker:** Asegúrese de que Docker esté instalado y en funcionamiento en su máquina. Puede descargarlo desde el sitio web oficial de Docker: [https://www.docker.com/get-docker](https://www.docker.com/get-docker)

### Estructura del Proyecto

*   `mysql/`: Contiene los datos de la base de datos.
*   `docker-compose.yml`: Define los servicios para la base de datos, la aplicación Spring Boot y la aplicación PHP.
*   `src/main/java/com/proyecto/idb/controller/WebController.java`: Controlador de Spring Boot.
*   `src/main/java/com/proyecto/idb/service/WebService.java`: Servicio de Spring Boot.
*   `index.php`: Página de inicio de sesión de PHP.
*   `home.php`: Página de inicio de PHP para la gestión de estudiantes.
*   Otros archivos relacionados con las aplicaciones Spring Boot y PHP.

### Pasos para el Despliegue

1.  **Instalar Docker:**

    *   Si aún no lo ha hecho, instale Docker Desktop en su sistema.
2.  **Iniciar Docker Compose:**

    *   Navegue al directorio que contiene el archivo `docker-compose.yml` en su terminal.
    *   Ejecute el siguiente comando para iniciar todos los servicios definidos en el archivo `docker-compose.yml`:

        ```bash
        docker-compose up
        ```

        Este comando construirá e iniciará los contenedores para la base de datos, la aplicación Spring Boot y la aplicación PHP.
3.  **Importar Datos de la Base de Datos (MySQL):**

    *   Una vez que el contenedor MySQL esté en funcionamiento, puede importar los datos de la carpeta `mysql`. Puede hacerlo utilizando una herramienta como MySQL Workbench o el cliente de línea de comandos de MySQL.
    *   Conéctese al servidor MySQL que se ejecuta en el contenedor Docker.
    *   Ejecute los scripts SQL o importe los archivos de datos de la carpeta `mysql` para poblar su base de datos.
4.  **Acceder a las Aplicaciones:**

    *   Después de completar los pasos anteriores, su base de datos, la aplicación Spring Boot y la aplicación PHP deberían estar en funcionamiento dentro de los contenedores Docker.

### Detalles de la Aplicación Spring Boot

La aplicación Spring Boot proporciona una API RESTful para la gestión de escuelas y estudiantes.

*   **WebController.java:** Este controlador (`src/main/java/com/proyecto/idb/controller/WebController.java`) maneja las solicitudes HTTP entrantes y delega la lógica de negocio a la clase `WebService`. Define endpoints para:

    *   Crear escuelas y estudiantes (`/+sch`, `/+alu`).
    *   Eliminar escuelas y estudiantes (`/-sch/{idSchool}`, `/-alu/{idAlumn}`).
    *   Recuperar datos de escuelas y estudiantes (`/show=sch`, `/show=alu/{idAlumn}`, `/show=all`, `/show/school`).
    *   Actualizar datos de escuelas y estudiantes (`/upt=sch/{idSchool}`, `/upt=alu/{idAlumn}`).
    *   Funcionalidad de inicio de sesión (`/login`).
    *   Actualizar contraseñas (`/upt=pass`).

*   **WebService.java:** Este servicio (`src/main/java/com/proyecto/idb/service/WebService.java`) contiene la lógica de negocio para la aplicación. Interactúa con la base de datos a través de los repositorios (`SchoolsRepository`, `AlumnsRepository`).

### Detalles de la Aplicación PHP

La aplicación PHP proporciona una interfaz web sencilla para el inicio de sesión de usuarios y la gestión de estudiantes.

*   **index.php:** Este archivo proporciona un formulario de inicio de sesión. Es probable que se autentique contra el backend de Spring Boot o directamente contra la base de datos (dependiendo de su implementación específica en el `docker-compose.yml`).
*   **home.php:** Este archivo proporciona funcionalidad para administrar los registros de los estudiantes, incluyendo la visualización, la inserción y la actualización de los datos de los estudiantes. Utiliza `curl` para comunicarse con la API del backend de Spring Boot. **Tenga en cuenta la URL `http://host.docker.internal:8080/crud/` en `home.php`.** Si su aplicación Spring Boot se está ejecutando en el puerto 8080 dentro de la red Docker, esto *podría* funcionar, pero es más robusto utilizar el nombre del servicio definido en su archivo `docker-compose.yml` (por ejemplo, `http://springboot-service:8080/crud/`, asumiendo que su servicio Spring Boot se llama `springboot-service`). Es probable que necesite adaptar esta URL a la configuración específica en su `docker-compose.yml`.

### Notas

*   Asegúrese de que los detalles de la conexión de la base de datos en sus aplicaciones Spring Boot y PHP estén configurados correctamente para apuntar al servidor MySQL que se ejecuta dentro del contenedor Docker.
*   Es posible que deba ajustar las asignaciones de puertos y otras configuraciones en el archivo `docker-compose.yml` para que se adapten a su entorno específico.
*   El código PHP en `home.php` asume la existencia de un endpoint `/crud/` en su aplicación Spring Boot. Adapte las URL en `home.php` para que coincidan con los endpoints reales de su API Spring Boot. El backend de Spring Boot proporciona algunos servicios en la ruta `/idbProject`.
*   Consulte los registros de los contenedores Docker para solucionar cualquier problema durante el proceso de despliegue.
*   La anotación `@CrossOrigin("https://idbproject.netlify.app")` en `WebController.java` permite las peticiones de origen cruzado desde ese origen específico. Asegúrese de que esto esté configurado correctamente para el dominio de su frontend. La anotación `@CrossOrigin` en el método `delAlumn` no está cerrada correctamente, debería ser `@CrossOrigin(origins = "https://idbproject.netlify.app/table.html")`.

### Despliegue de la Página Web

La página web (frontend) de este proyecto se encuentra en el repositorio [ProjectIDB-JS-](https://github.com/eChrls/ProjectIDB-JS-.git). Allí encontrará el código HTML, CSS y JavaScript necesarios para desplegar la interfaz de usuario.

### Despliegue con PHP

Este repositorio incluye el código necesario para desplegar la aplicación PHP. El archivo `docker-compose.yml` debe estar configurado para incluir un servidor PHP (por ejemplo, utilizando una imagen de PHP-FPM) y servir los archivos PHP desde el directorio apropiado. Si no lo ha hecho ya, asegúrese de que su `docker-compose.yml` contiene la configuración necesaria para el servidor PHP.

Este README ahora proporciona una visión general más detallada de los componentes de Spring Boot y PHP y destaca las consideraciones importantes para la configuración de la aplicación dentro de un entorno Docker. Recuerde revisar y ajustar las configuraciones en base a la configuración específica de su proyecto.


# Simulador ICFES

El examen Saber 11, conocido comúnmente como ICFES, es una evaluación de egreso de bachillerato administrada anualmente para los estudiantes de grado 11 en Colombia.

## Funcionalidades

- Creación de docentes, administradores y estudiantes.
- Creación de institutos.
- Creación de cursos.
- Categorización.
- Generación de exámenes.
- Generación de reportes.

## Instalación

Para instalar los paquetes necesarios, ejecute el siguiente comando:

```bash
composer install
```

## Configuración

Renombre el archivo `.env.example` en la raíz del proyecto a `.env` y modifique las configuraciones según sus necesidades, incluyendo las bases de datos y los servicios SMTP.

Una vez establecida la conexión con la base de datos, ejecute los siguientes comandos para la preconfiguración:

```bash
php artisan migrate
php artisan db:seed --class=DirectorySeeder
php artisan db:seed --class=SchoolSeeder
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=DatabaseSeeder
```

## Cuentas de Usuario

| Email               | Contraseña | Perfil   |
|---------------------|------------|----------|
| manager@example.com | admin      | Manager  |
| carlosa@example.com | admin      | Admin    |
| teacher@example.com | teacher    | Teacher  |
| student@example.com | student    | Student  |

## Ventajas de Utilizar Esta Aplicación

- **Preparación Efectiva:** Esta aplicación permite a los estudiantes prepararse de manera más efectiva para el examen Saber 11, proporcionando exámenes simulados que reflejan el formato y el contenido del examen real.
- **Identificación de Falencias:** Los docentes pueden identificar las áreas de debilidad de los estudiantes y agrupar a aquellos con falencias similares para enfocarse en una preparación más dirigida y efectiva.
- **Generación de Reportes:** La aplicación genera reportes detallados que ayudan a los estudiantes a entender sus áreas de mejora y a los docentes a planificar sus clases en consecuencia.
- **Administración Centralizada:** La capacidad de crear y gestionar usuarios (docentes, administradores y estudiantes) y cursos en una sola plataforma facilita la administración y el seguimiento del progreso académico.

## Capturas de Pantalla

Registro de estudiantes:
![Registro de estudiantes](https://i.imgur.com/apxEnJ4.png)

Lista de instituciones:
![Lista de instituciones](https://i.imgur.com/yTqNCtB.png)

Lista de usuarios:
![Lista de usuarios](https://i.imgur.com/wUJ9Ovr.png)
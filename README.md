<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Simulador IFCES

"El Saber 11, popularmente conocido como ICFES, es un examen de egreso de bachillerato administrado anualmente en el grado 11 en el bachillerato colombiano.​"

Priorizaré esta tarea y la completaré tan pronto como tenga el tiempo disponible.


## Instalación

Ejecutar este comando para instalar los paquetes

`composer install`

Ejecutar 


### Configurar 

Reescribir el archivo de la raíz .env.example a .env, luego modificar a su conveniencia, temas como bases de datos
y servicios SMTP

Una vez establecida la conexión con la base de datos ejecutar los siguientes comandos.

### Preconfiguración

1. `php artisan migrate`
2. `php artisan db:seed --class=DirectorySeeder`
3. `php artisan db:seed --class=SchoolSeeder`
4. `php artisan db:seed --class=PermissionSeeder`
5. `php artisan db:seed --class=DatabaseSeeder`


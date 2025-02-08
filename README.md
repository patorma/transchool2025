<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Api de Sistema de Gestión de Transporte 
## Introducción

Esta aplicación corresponde al backend de la aplicacion de manejo de furgones realizado en Laravel 11 para ser consumido por un framework de JavaScript. Corresponde a una actualizacion de un proyecto realizado en 2016 con JEE, en esta ocasión se implemento con php 8.4. 

### Pre-requisitos
#### Que tecnologias o herramientas se necesitan?
Se necesita tener un IDE compatible con PHP versión 8.1 o superior y el framework laravel 11 en particular en este proyecto se ocupo el IDE Visual Studio. Además hay que tener instalado postman para hacer las pruebas de peticiones a la  API de este backend. A parte de lo anterior se debe instalar composer,revisar en internet requisitos para instalar laravel 11 para más detalle. Después se debe clonar el proyecto del repositorio de guthub se debe modificar el archivo .env  donde se debe configurar la conexion a la base de datos y variables de entorno según correponda. En este archivo se encuentra la llave para conectarse por token. Recordar que si no se crea o no esta en la carpeta de routes el archivo api.php  de las rutas apis y generarlo con el siguiente comando: php artisan install:api.

### Instalación 
* **1. Una vez que se descarga el proyecto se debe ejecutar en el IDE  para ello en una consola  se debe ejecutar el comando php artisan serve para echar a correr el proyecto**

* **2. Se debe ir a postman  y crear una coleccion o importar el archivo .json que se entregue con este repositorio**

* **3. A partir de la coleccion importada de postman, que se agrega a este repositorio, se empieza hacer las pruebas de los endpoints de la aplicacion.**
* **4. Hay que ir a la carpeta usuarios y ver el request de login con la direccion {{url_transchool2025_laravel}}login para loguearse y generar el token. Antes de hacer lo anterior se debe ir a la url de regsitrar usuario (modificar esto cuando se inicia ya que esto deberia estar en el modulo de admin osea verlo autenticado) la cual es: {{url_transchool2025_laravel}}register  y los datos de prueba como ejemplo para registrarse como admin es:**

 {
    "name":"Leandro",
    "last_name": "Contreras",
    "role": "admin",
    "comuna": "Los angeles",
    "telefono": "+562569874",
    "email": "leandro@mail.com ",
    "password": "leandro123456",
    "password_confirmation":"leandro123456"
 }

 * **Se debe revisar las carpetas en postman donde va mostrando los modulos para probar el consumo de la api**

 ## Construido con 

 _Herramientas utilizadas_

  *[Visual Studio Code](https://code.visualstudio.com/) - El IDE que fue usado para programar el código
 *[Laravel](https://laravel.com/) - El framework Laravel versión 11.
 *[php](https://www.php.net/) - El lenguaje es php versión 8.4.1.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

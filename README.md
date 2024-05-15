# SWAPI

Usando los datos de [swapi.dev](https://swapi.dev)

## Instrucciones de instalación

Se requiere Docker para instalar la aplicaciones con las
siguientes instrucciones.

1. Iniciar the Docker containers.

`./vendor/bin/sail up -d`

La opción `-d` es opcional. Sirve para lanzar el container en 
tarea de fondo.

2. preparar/actualizar la base de datos

` ./vendor/bin/sail artisan migrate`

3. acceder al aplicación

`http://localhost/`

4. Lanzar la suite de tests

`./vendor/bin/sail artisan test`

### Otras instrucciones

Detener el container desde terminal: 
`./vendor/bin/sail stop`

Ver las rutas API disponibles:
`./vendor/bin/sail artisan route:list --path=api`

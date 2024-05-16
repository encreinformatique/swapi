# SWAPI

Usando los datos de [swapi.dev](https://swapi.dev)

## Instrucciones de instalación

Se requiere Docker para instalar la aplicaciones con las
siguientes instrucciones.

1. Instalación

En el terminal o desde un IDE como PHPStorm

`make install`

2. acceder al aplicación

`http://localhost/`

3. Lanzar la suite de tests

`./vendor/bin/sail artisan test`

### Otras instrucciones

Detener el container desde terminal: 
`./vendor/bin/sail stop`

Ver las rutas API disponibles:
`./vendor/bin/sail artisan route:list --path=api`

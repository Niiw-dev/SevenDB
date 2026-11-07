# SevenDB

Repositorio de los artefactos de base de datos de Seven/Eco7. La aplicación Laravel de Seven proporciona el runtime para ejecutar las migraciones y los seeders.

## Contenido

- `database/migrations`: esquema y cambios incrementales de la base de datos.
- `database/seeders`: usuario inicial y divisiones territoriales de Colombia.
- `database/divipola-dane-2024.json`: catálogo DIVIPOLA 2024 de datos.gov.co, bajo licencia Creative Commons Atribución-CompartirIgual 4.0.
- `database/factories`: factory de usuarios usada por la aplicación y sus pruebas.

## Docker local

El runner necesita que Seven y SevenDB estén en carpetas hermanas y que Seven tenga instaladas sus dependencias de Composer (`vendor/`):

```text
project/
  Seven/
  SevenDB/
```

SevenDB no inicia ni almacena otra base de datos. El runner se conecta por la red Docker `develop_default` al servicio `seven-app-postgres` de Seven y lee las credenciales de `Seven/.env` (con `Seven/.env.example` como alternativa).

Si PostgreSQL de Seven aún no está iniciado, desde la raíz de Seven ejecuta:

```bash
docker compose -f .devops/docker/develop/docker-compose.yml -f .devops/docker/develop/docker-compose.override.yml up -d seven-app-postgres
```

Desde la raíz de SevenDB, construye y deja iniciado el contenedor de trabajo:

```bash
docker compose up -d --build artisan
```

Abre una shell dentro de ese contenedor:

```bash
docker compose exec artisan sh
```

Ya dentro, ejecuta los comandos de Laravel:

```bash
php artisan migrate
```

Para generar una migración nueva, usa el comando `make:migration` (no `make:migrate`):

```bash
php artisan make:migration create_nombre_tabla_table --create=nombre_tabla
```

En una base nueva o cuando necesites datos iniciales, ejecuta el seeder explícitamente:

```bash
php artisan db:seed
```

El contenedor monta el código de Seven en solo lectura y usa `SevenDB/database` con escritura habilitada para generar migraciones. Sus directorios temporales no escriben en el checkout de Seven. Para salir de la shell escribe `exit`; para detener el contenedor, ejecuta `docker compose stop artisan`. La red se puede cambiar en `.env` copiando `.env.example` y ajustando `SEVEN_DOCKER_NETWORK`.

## Advertencia de seguridad

El esquema y `UserSeeder` actuales guardan también una contraseña sin hash en `users.deciphered_password`, y el seeder crea una cuenta de demostración con credenciales conocidas. No ejecutes ese seeder en producción ni expongas esa base de datos. La eliminación de ese comportamiento requiere un cambio coordinado con el modelo y los flujos de autenticación de Seven.# SevenDB
Base de Datos para Eco7

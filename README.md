## Instalación

Clonar el repositorio

```bash
git clone https://github.com/Edkiri/animals-api <folder-name>
```

Navegar al proyecto
```bash
cd <folder-name>
```

Instalar dependencias

```bash
  composer install
```

Copiar las variables de entorno
```bash
  cp .env.example .env
```

## Base de datos

Proveer las credenciales de la base de datos en el archivo `.env`
```
...
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
...
```
## Docker
En desarrollo puedes usar docker para crear un servicio de mysql. 

```bash
docker-compose up -d
```

Este comando usará la configuración definida en el archivo `docker-compose.yml` de la raíz del proyecto.

## Migraciones

```bash
php artisan migrate
```

## Ejecución
```bash
php artisan serve
```
markdown# Pieces Service

Microservicio de gestión de piezas desarrollado con Laravel 11. Maneja proyectos, bloques y piezas con registro de fabricación.

## Descripción

Expone una API REST versionada y protegida por token Sanctum. Gestiona el CRUD completo de proyectos, bloques y piezas, incluyendo registro de fabricación con peso teórico, peso real, diferencia de peso automática y fecha de fabricación.

## Tecnologías

- PHP 8.2
- Laravel 11
- Laravel Sanctum (validación de tokens)
- MySQL

## Endpoints principales

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | /api/v1/projects | Listar proyectos |
| POST | /api/v1/projects | Crear proyecto |
| GET | /api/v1/projects/{id} | Ver proyecto |
| PUT | /api/v1/projects/{id} | Actualizar proyecto |
| DELETE | /api/v1/projects/{id} | Eliminar proyecto |
| GET | /api/v1/blocks | Listar bloques |
| POST | /api/v1/blocks | Crear bloque |
| GET | /api/v1/pieces | Listar piezas |
| POST | /api/v1/pieces | Crear pieza |
| PUT | /api/v1/pieces/{id} | Actualizar pieza |
| DELETE | /api/v1/pieces/{id} | Eliminar pieza |

Todos los endpoints requieren header: `Authorization: Bearer {token}`

### Filtros disponibles
GET /api/v1/pieces?project_id=1
GET /api/v1/pieces?estado=pendiente
GET /api/v1/blocks?project_id=1

## Variables de entorno

```env
APP_NAME=PiecesService
APP_URL=http://localhost:8002
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pieces_service_db
DB_USERNAME=root
DB_PASSWORD=
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
DB_AUTH_HOST=127.0.0.1
DB_AUTH_PORT=3306
DB_AUTH_DATABASE=auth_service_db
DB_AUTH_USERNAME=root
DB_AUTH_PASSWORD=
```

## Pasos de ejecución

```bash
# 1. Clonar el repositorio
git clone https://github.com/darril-wav/pieces-service.git
cd pieces-service

# 2. Instalar dependencias
composer install

# 3. Copiar variables de entorno
cp .env.example .env

# 4. Generar key
php artisan key:generate

# 5. Configurar .env con tus credenciales de base de datos

# 6. Crear las bases de datos en MySQL
# - pieces_service_db
# - auth_service_db (debe existir con el auth-service corriendo)

# 7. Ejecutar migraciones y seeder
php artisan migrate --seed

# 8. Levantar el servidor
php artisan serve --port=8002
```

## Decisiones técnicas

- **Versionado /api/v1** para permitir evolución de la API sin romper compatibilidad.
- **Doble conexión MySQL**: conexión principal a `pieces_service_db` para datos, conexión `mysql_auth` a `auth_service_db` para validar tokens Sanctum sin llamadas HTTP entre servicios.
- **diferencia_peso** calculada como atributo Eloquent (`$appends`) — no se persiste en BD para evitar inconsistencias.
- **fecha_fabricacion** se asigna automáticamente en el modelo cuando el estado cambia a `fabricada`.
- **Paginación** con 15 resultados por página en el listado de piezas.
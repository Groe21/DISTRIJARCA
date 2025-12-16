# 🧀 DISTRI-JARCA - Proyecto Laravel + PostgreSQL

## 📁 Estructura del Proyecto

```
DistriJarca/
├── frontend/                    # Frontend estático (actual)
│   ├── index.html
│   ├── styles.css
│   ├── script.js
│   ├── assets/
│   └── admin/
│
├── backend/
│   └── distrijarca-api/        # Laravel 10 API
│       ├── app/
│       │   ├── Http/
│       │   │   ├── Controllers/
│       │   │   │   ├── Admin/
│       │   │   │   │   ├── ProductoController.php
│       │   │   │   │   ├── CategoriaController.php
│       │   │   │   │   ├── MensajeController.php
│       │   │   │   │   └── DashboardController.php
│       │   │   │   ├── Web/
│       │   │   │   │   ├── HomeController.php
│       │   │   │   │   └── ContactoController.php
│       │   │   │   └── API/
│       │   │   │       └── ProductoApiController.php
│       │   │   └── Middleware/
│       │   ├── Models/
│       │   │   ├── Producto.php
│       │   │   ├── Categoria.php
│       │   │   ├── Mensaje.php
│       │   │   ├── Usuario.php
│       │   │   └── Newsletter.php
│       │   └── Services/
│       │       ├── ProductoService.php
│       │       └── PDFService.php
│       ├── database/
│       │   ├── migrations/
│       │   ├── seeders/
│       │   └── factories/
│       ├── resources/
│       │   └── views/
│       │       ├── layouts/
│       │       ├── admin/
│       │       ├── web/
│       │       └── pdfs/
│       ├── routes/
│       │   ├── web.php
│       │   ├── api.php
│       │   └── admin.php
│       └── public/
│
└── README-LARAVEL.md           # Este archivo
```

## 🚀 Instalación Inicial Completada

✅ Laravel 10 instalado
✅ DomPDF para generación de PDFs instalado
✅ Estructura de carpetas creada

## 🐘 Configuración de PostgreSQL

### 1. Instalar PostgreSQL
```bash
sudo apt update
sudo apt install postgresql postgresql-contrib
```

### 2. Crear base de datos
```bash
sudo -u postgres psql
```

Dentro de PostgreSQL:
```sql
CREATE DATABASE distrijarca_db;
CREATE USER distrijarca_user WITH ENCRYPTED PASSWORD 'tu_password_segura';
GRANT ALL PRIVILEGES ON DATABASE distrijarca_db TO distrijarca_user;
\q
```

### 3. Configurar .env
Edita el archivo `.env` en `backend/distrijarca-api/.env`:

```env
APP_NAME="DISTRI-JARCA"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=distrijarca_db
DB_USERNAME=distrijarca_user
DB_PASSWORD=tu_password_segura
```

## 📊 Modelos Principales (MVC)

### Productos
- `id`: bigint
- `nombre`: string
- `descripcion`: text
- `categoria_id`: foreign
- `precio`: decimal
- `stock`: integer
- `imagen`: string
- `activo`: boolean
- `timestamps`

### Categorías
- `id`: bigint
- `nombre`: string
- `descripcion`: text
- `icono`: string
- `orden`: integer
- `timestamps`

### Mensajes (Contacto)
- `id`: bigint
- `nombre`: string
- `email`: string
- `telefono`: string
- `empresa`: string (nullable)
- `asunto`: string
- `mensaje`: text
- `leido`: boolean
- `timestamps`

### Newsletter
- `id`: bigint
- `email`: string (unique)
- `activo`: boolean
- `timestamps`

## 🛠️ Comandos de Artisan

### Crear Modelos con todo
```bash
php artisan make:model Producto -mcrs
php artisan make:model Categoria -mcrs
php artisan make:model Mensaje -mcrs
php artisan make:model Newsletter -mcrs
```

### Crear Controladores
```bash
php artisan make:controller Admin/ProductoController --resource
php artisan make:controller Admin/CategoriaController --resource
php artisan make:controller Admin/MensajeController --resource
php artisan make:controller Web/HomeController
php artisan make:controller API/ProductoApiController --api
```

### Migraciones
```bash
php artisan migrate
php artisan db:seed
```

## 🎯 Rutas Organizadas

### Web (frontend)
- `GET /` - Página principal
- `GET /nosotros` - Sobre nosotros
- `GET /productos` - Catálogo
- `POST /contacto` - Enviar mensaje

### Admin
- `GET /admin/dashboard` - Panel principal
- `CRUD /admin/productos` - Gestión productos
- `CRUD /admin/categorias` - Gestión categorías
- `GET /admin/mensajes` - Ver mensajes

### API
- `GET /api/productos` - Listar productos
- `GET /api/categorias` - Listar categorías
- `POST /api/newsletter` - Suscribir email

## 📄 Generación de PDFs

```php
use Barryvdh\DomPDF\Facade\Pdf;

// En el controlador
public function generarCatalogo()
{
    $productos = Producto::with('categoria')->get();
    
    $pdf = PDF::loadView('pdfs.catalogo', [
        'productos' => $productos
    ]);
    
    return $pdf->download('catalogo-distrijarca.pdf');
}
```

## 🔐 Autenticación

Laravel Breeze para admin:
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
php artisan migrate
```

## 📱 API RESTful

### Respuestas estandarizadas
```php
return response()->json([
    'success' => true,
    'data' => $productos,
    'message' => 'Productos obtenidos exitosamente'
], 200);
```

## 🧪 Testing

```bash
php artisan test
```

## 🚀 Despliegue

### Desarrollo
```bash
php artisan serve
# http://localhost:8000
```

### Producción
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📦 Paquetes Adicionales Recomendados

```bash
# Autenticación
composer require laravel/breeze --dev

# Imágenes
composer require intervention/image

# Excel
composer require maatwebsite/excel

# Logs mejorados
composer require rap2hpoutre/laravel-log-viewer
```

## 🔄 Integración Frontend-Backend

1. **Opción 1: API REST**
   - Frontend consume API Laravel con fetch/axios
   - Backend devuelve JSON

2. **Opción 2: Blade Templates** (Recomendado)
   - Migrar HTML a vistas Blade
   - Laravel renderiza todo el sitio

## 💾 Backup Automático

```bash
php artisan backup:run
```

## 🎨 Assets (CSS/JS)

```bash
npm install
npm run dev
# o para producción
npm run build
```

## 📝 Próximos Pasos

1. ✅ Configurar PostgreSQL
2. ⬜ Crear migraciones
3. ⬜ Crear modelos y controladores
4. ⬜ Migrar vistas HTML a Blade
5. ⬜ Implementar autenticación
6. ⬜ Crear API endpoints
7. ⬜ Configurar generación de PDFs
8. ⬜ Testing
9. ⬜ Deploy

---

**Desarrollado para DISTRI-JARCA**
Distribución de Quesos y Embutidos Premium

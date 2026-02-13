# 🏠 Sistema de Secciones Destacadas para Página Principal

## ✅ Implementación Completa

Se ha creado un sistema completo para administrar las secciones de productos destacados que aparecen en la página principal de DISTRI-JARCA.

---

## 📋 Componentes Creados

### 1. Base de Datos
**Tabla:** `home_sections`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| **id** | bigint | ID único |
| **category_id** | FK | Categoría asociada |
| **titulo** | string | Título de la sección (ej: "Quesos Artesanales") |
| **subtitulo** | string | Subtítulo opcional |
| **descripcion** | text | Descripción de la sección |
| **badge_texto** | string | Texto del badge (ej: "Premium", "Selectos") |
| **badge_color** | string | Color del badge (danger, primary, warning, etc.) |
| **imagen** | string | Ruta de la imagen de la sección |
| **icono** | string | Clase de Bootstrap Icons (ej: "bi-star") |
| **orden** | integer | Orden de aparición (1, 2, 3, 4...) |
| **activo** | boolean | Si la sección está activa |
| **max_productos** | integer | Cantidad máxima de productos a mostrar |

### 2. Modelo: `HomeSection`

**Relaciones:**
- `category()` - Pertenece a una categoría
- `productosDestacados()` - Obtiene productos destacados de esa categoría

**Métodos útiles:**
```php
// Obtener secciones activas ordenadas
HomeSection::activas()->ordenadas()->get();

// Obtener productos para mostrar (con límite)
$section->getProductosParaMostrar(5);
```

### 3. Controlador Admin: `HomeSectionController`

**Rutas disponibles:**
```
GET    /admin/home-sections              # Listar secciones
GET    /admin/home-sections/create       # Formulario crear
POST   /admin/home-sections              # Guardar nueva sección
GET    /admin/home-sections/{id}         # Ver detalle
GET    /admin/home-sections/{id}/edit    # Formulario editar
PUT    /admin/home-sections/{id}         # Actualizar sección
DELETE /admin/home-sections/{id}         # Eliminar sección
PATCH  /admin/home-sections/{id}/toggle-status  # Activar/desactivar
POST   /admin/home-sections/update-orden # Actualizar orden de secciones
```

### 4. API REST Pública

**Endpoint:** `GET /api/home/sections`

**Respuesta:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "titulo": "Quesos Artesanales",
      "subtitulo": null,
      "descripcion": "Amplia variedad de quesos nacionales e importados...",
      "badge": {
        "texto": "Premium",
        "color": "danger",
        "class": "badge bg-danger"
      },
      "imagen_url": "http://localhost/storage/home-sections/quesos-artesanales.jpg",
      "icono": "bi-star",
      "icono_class": "bi bi-star",
      "categoria": {
        "id": 1,
        "nombre": "Quesos",
        "slug": "quesos"
      },
      "productos": [
        {
          "id": 3,
          "nombre": "Queso Manchego Curado",
          "marca": "La Mancha Premium",
          "descripcion": "Queso manchego curado de 12 meses...",
          "sku": "QMC-001",
          "slug": "queso-manchego-curado",
          "imagen_url": "http://localhost/storage/products/...",
          "precio_caja": "1250.00",
          "precio_unidad": "125.00",
          "precio_formateado": "$1,250.00",
          "unidades_por_caja": 10,
          "stock_estado": "disponible"
        }
      ]
    }
  ]
}
```

---

## 🔧 Datos Iniciales Creados

Se crearon **4 secciones** predeterminadas:

1. **Quesos Artesanales** (orden: 1)
   - Badge: "Premium" (rojo)
   - Icono: Estrella
   - Muestra productos destacados de la categoría "Quesos"

2. **Embutidos Selectos** (orden: 2)
   - Badge: "Selectos" (rojo)
   - Icono: Premio
   - Muestra productos destacados de la categoría "Embutidos"

3. **Jamones Premium** (orden: 3)
   - Badge: "Gourmet" (rojo)
   - Icono: Diamante
   - Muestra productos destacados de la categoría "Jamones"

4. **Productos Especiales** (orden: 4)
   - Badge: "Especial" (rojo)
   - Icono: Regalo
   - Muestra productos destacados de la categoría "Productos Especiales"

---

## 🎨 Cómo Funciona

### Lógica de Visualización

1. **El admin configura una sección:**
   - Elige una categoría (Quesos, Embutidos, Jamones, etc.)
   - Define título, descripción, badge
   - Sube una imagen representativa
   - Establece cuántos productos mostrar (max_productos)

2. **El sistema automáticamente:**
   - Obtiene los productos **destacados** (`destacado = true`) de esa categoría
   - Filtra solo los **activos** (`activo = true`)
   - Filtra los que tienen **stock disponible** (`stock > 0`)
   - Limita la cantidad según `max_productos`

3. **En la página principal:**
   - Se muestran las secciones en orden ascendente
   - Solo se muestran las secciones activas
   - Cada sección muestra sus productos destacados automáticamente

---

## 🚀 Integración con el Frontend

### Opción 1: Consumir API REST (Recomendado)

```javascript
// En frontend/script.js o donde corresponda
async function cargarSeccionesDestacadas() {
    try {
        const response = await fetch('http://localhost:8000/api/home/sections');
        const data = await response.json();
        
        if (data.success) {
            renderizarSecciones(data.data);
        }
    } catch (error) {
        console.error('Error al cargar secciones:', error);
    }
}

function renderizarSecciones(secciones) {
    const container = document.getElementById('productos-destacados');
    container.innerHTML = '';
    
    secciones.forEach(seccion => {
        const html = `
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card producto-card">
                    <img src="${seccion.imagen_url}" class="card-img-top" alt="${seccion.titulo}">
                    <span class="badge ${seccion.badge.class}">${seccion.badge.texto}</span>
                    <div class="card-body">
                        <div class="icono-producto">
                            <i class="${seccion.icono_class}"></i>
                        </div>
                        <h3>${seccion.titulo}</h3>
                        <p>${seccion.descripcion}</p>
                        <ul class="lista-productos">
                            ${seccion.productos.map(p => `
                                <li><i class="bi bi-check-circle"></i> ${p.nombre}</li>
                            `).join('')}
                        </ul>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += html;
    });
}

// Llamar al cargar la página
document.addEventListener('DOMContentLoaded', cargarSeccionesDestacadas);
```

### Opción 2: Usar Blade Templates (Laravel)

```php
// En routes/web.php
Route::get('/', function () {
    $sections = \App\Models\HomeSection::with('category')
        ->activas()
        ->ordenadas()
        ->get();
    
    return view('home', compact('sections'));
});
```

```blade
<!-- En resources/views/home.blade.php -->
<section id="productos" class="py-5">
    <div class="container">
        <div class="row">
            @foreach($sections as $section)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card producto-card">
                    <img src="{{ $section->imagen_url }}" class="card-img-top" alt="{{ $section->titulo }}">
                    <span class="{{ $section->badge_class }}">{{ $section->badge_texto }}</span>
                    <div class="card-body">
                        <div class="icono-producto">
                            <i class="{{ $section->icono_class }}"></i>
                        </div>
                        <h3>{{ $section->titulo }}</h3>
                        <p>{{ $section->descripcion }}</p>
                        <ul class="lista-productos">
                            @foreach($section->getProductosParaMostrar() as $producto)
                            <li><i class="bi bi-check-circle"></i> {{ $producto->nombre }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
```

---

## 📝 Uso del Panel de Administración

### Crear/Editar una Sección

1. **Ir a:** `/admin/home-sections`
2. **Hacer clic en:** "Nueva Sección" o "Editar" en una existente
3. **Completar el formulario:**
   - **Categoría:** Seleccionar de las categorías existentes
   - **Título:** Nombre de la sección (ej: "Quesos Artesanales")
   - **Descripción:** Texto descriptivo (máx 500 caracteres)
   - **Badge Texto:** Etiqueta (ej: "Premium", "Selectos", "Gourmet")
   - **Badge Color:** danger, primary, warning, success, etc.
   - **Ícono:** Seleccionar de Bootstrap Icons
   - **Orden:** Número de posición (1, 2, 3, 4...)
   - **Máximo de Productos:** Cuántos productos destacados mostrar
   - **Imagen:** Subir imagen representativa (JPG, PNG, WEBP)
   - **Activo:** Marcar para que aparezca en la web

4. **Guardar**

### Gestionar Productos Destacados

Para que un producto aparezca en una sección:

1. **Ir a:** `/admin/products`
2. **Editar el producto**
3. **Asegurarse de:**
   - Categoría correcta asignada
   - Marcar como "Destacado" ✓
   - Marcar como "Activo" ✓
   - Tener stock disponible

---

## 🎯 Ventajas del Sistema

✅ **Dinámico:** Las secciones se actualizan automáticamente según los productos destacados
✅ **Flexible:** Puedes crear/editar/eliminar secciones sin tocar código
✅ **Ordenable:** Cambia el orden de las secciones fácilmente
✅ **Basado en Categorías:** Se aprovechan las categorías ya creadas
✅ **API REST:** Fácil integración con cualquier frontend
✅ **Control Total:** Activa/desactiva secciones cuando quieras
✅ **Responsive:** Funciona con cualquier cantidad de secciones

---

## 📸 Notas sobre Imágenes

Las imágenes se guardan en: `storage/app/public/home-sections/`

Para acceder públicamente, asegúrate de crear el enlace simbólico:
```bash
php artisan storage:link
```

**Dimensiones recomendadas:** 800x600px (4:3)
**Formatos soportados:** JPG, PNG, WEBP
**Peso máximo:** 2MB

---

## 🔄 Flujo de Trabajo Recomendado

1. **Crear Categorías** (`/admin/categories`)
2. **Crear Productos** (`/admin/products`) y marcar los mejores como "destacados"
3. **Crear/Editar Secciones** (`/admin/home-sections`) asociadas a categorías
4. **El sistema muestra automáticamente** los productos destacados en cada sección
5. **Actualizar en cualquier momento** sin afectar el código

---

## 🧪 Pruebas

### Ver todas las secciones con productos:
```php
php artisan tinker
>>> \App\Models\HomeSection::with(['category', 'productosDestacados'])->activas()->ordenadas()->get();
```

### Probar el API:
```bash
curl http://localhost:8000/api/home/sections
```

### Ver productos de una sección:
```php
>>> $section = \App\Models\HomeSection::first();
>>> $section->getProductosParaMostrar();
```

---

## ✨ Próximas Mejoras Sugeridas

1. **Drag & Drop para ordenar** secciones en el admin
2. **Vista previa** antes de publicar
3. **Programación** de activación/desactivación por fechas
4. **Botón de enlace personalizado** en cada sección
5. **Estadísticas** de clics por sección
6. **Variantes de diseño** (tarjeta, lista, grid, etc.)

---

¡Sistema listo para usar! 🎉

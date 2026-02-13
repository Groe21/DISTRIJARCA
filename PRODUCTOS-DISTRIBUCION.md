# 📦 Sistema de Productos para Distribución Mayorista - DISTRI-JARCA

## Cambios Implementados

### ✅ Base de Datos Actualizada

Se agregaron los siguientes campos a la tabla `products`:

#### Identificación
- **sku** - Código único del producto (generado automáticamente si no se proporciona)
- **codigo_barras** - Código de barras para escáner

#### Precios Mayoristas
- **precio_caja** - Precio por caja completa (antes "precio")
- **precio_unidad** - Precio por unidad individual
- **precio_mayoreo** - Precio especial para compras en volumen

#### Empaquetado
- **unidades_por_caja** - Cantidad de unidades que contiene cada caja
- **peso_caja** - Peso total de la caja en kg
- **peso_unidad** - Peso individual del producto en kg

#### Control de Stock
- **cantidad_minima_pedido** - Cantidad mínima que se puede pedir
- **cantidad_mayoreo** - Cantidad mínima para aplicar precio mayorista
- **stock_alerta** - Nivel de stock que activa alertas

#### Información del Producto
- **marca** - Marca del producto
- **origen** - País o región de origen
- **fecha_vencimiento** - Fecha de vencimiento del lote
- **dias_caducidad** - Días de vida útil del producto
- **temperatura_almacenamiento** - Condiciones de almacenamiento (ej: "2-8°C")

---

## 🔄 Modelo Actualizado

### Nuevos Métodos del Modelo Product

#### Scopes
```php
Product::stockBajo()      // Productos con stock bajo
Product::porMarca($marca) // Filtrar por marca
```

#### Accessors (Getters)
```php
$product->precio_formateado_caja     // "$1,250.00"
$product->precio_formateado_unidad   // "$125.00"
$product->precio_formateado_mayoreo  // "$1,150.00"
$product->stock_estado               // "disponible", "stock_bajo", "sin_stock"
$product->stock_estado_color         // "success", "warning", "danger"
```

#### Métodos de Cálculo
```php
// Calcular precio total según tipo y cantidad
$product->calcularPrecioTotal(10, 'caja');     // Precio por 10 cajas
$product->calcularPrecioTotal(50, 'unidad');   // Precio por 50 unidades
$product->calcularPrecioTotal(15, 'mayoreo');  // Precio mayorista

// Otros cálculos
$product->calcularPesoTotal(5);           // Peso total de 5 cajas
$product->tieneStockDisponible(20);       // true/false
$product->cumpleMinimoPedido(3);          // true/false
```

---

## 📊 Ejemplos de Uso

### Obtener productos con stock bajo
```php
$productosStockBajo = Product::stockBajo()->get();
```

### Filtrar por marca
```php
$productosGouda = Product::porMarca('Dutch Delights')->get();
```

### Calcular precio de pedido
```php
$producto = Product::find(1);
$cantidad = 15;

// Si la cantidad supera cantidad_mayoreo, aplica precio mayorista automáticamente
$precioTotal = $producto->calcularPrecioTotal($cantidad, 'caja');
```

### Validar pedido
```php
if (!$producto->cumpleMinimoPedido($cantidad)) {
    return "La cantidad mínima es {$producto->cantidad_minima_pedido} cajas";
}

if (!$producto->tieneStockDisponible($cantidad)) {
    return "Stock insuficiente. Disponible: {$producto->stock}";
}
```

---

## 📦 Datos de Ejemplo Creados

Se crearon **10 productos** de ejemplo:

### Quesos (3 productos)
1. Queso Manchego Curado - 10 unidades/caja - $1,250/caja
2. Queso Oaxaca - 8 unidades/caja - $800/caja
3. Queso Gouda Holandés - 10 unidades/caja - $1,400/caja

### Embutidos (3 productos)
4. Salami Milano Premium - 12 unidades/caja - $2,100/caja
5. Chorizo Español Picante - 10 unidades/caja - $1,600/caja
6. Mortadela con Aceitunas - 10 unidades/caja - $950/caja

### Jamones (4 productos)
7. Jamón Serrano Reserva 18 Meses - 10 unidades/caja - $4,500/caja
8. Jamón de Pavo Ahumado - 10 unidades/caja - $1,350/caja
9. Jamón Ibérico de Bellota - 10 unidades/caja - $12,500/caja (Premium)
10. Jamón York Extra - 10 unidades/caja - $1,100/caja

---

## 🛠️ Próximos Pasos Recomendados

### 1. Actualizar la Vista Admin
Crear/actualizar el formulario de productos en el panel admin para incluir todos los nuevos campos:
- Frontend: `frontend/admin/pages/productos.html`
- Campos a agregar: SKU, precios mayoristas, unidades por caja, cantidades mínimas, etc.

### 2. API REST para Pedidos
Crear endpoints en `routes/api.php` para:
```php
GET  /api/products              // Listar productos con stock
GET  /api/products/{sku}        // Detalle por SKU
POST /api/orders                // Crear pedido
GET  /api/products/low-stock    // Productos con stock bajo
```

### 3. Sistema de Pedidos
Crear tabla `orders` y `order_items` para gestionar pedidos mayoristas:
- Información del cliente/distribuidor
- Items del pedido con cantidades
- Cálculo automático de precios según volumen
- Estados: pendiente, procesando, enviado, entregado

### 4. Reportes
- Reporte de ventas por producto
- Análisis de productos más vendidos
- Alertas de stock bajo
- Proyección de reabastecimiento

### 5. Integración Frontend-Backend
Conectar el panel admin HTML con Laravel usando:
- **Opción A**: Blade templates (nativo de Laravel)
- **Opción B**: API REST + JavaScript (fetch/axios)
- **Opción C**: Livewire (recomendado para desarrollo rápido)

---

## 🔍 Validación

Para verificar que todo funciona:

```bash
# Ver los productos creados
php artisan tinker
>>> Product::with('category')->get()

# Probar cálculos
>>> $p = Product::first()
>>> $p->calcularPrecioTotal(10, 'caja')
>>> $p->calcularPrecioTotal(20, 'caja')  # Aplicará precio mayoreo si cumple condición
>>> $p->stock_estado
>>> $p->precio_formateado_caja
```

---

## 📝 Notas Importantes

1. **Precio Mayoreo**: Se aplica automáticamente cuando la cantidad del pedido es >= `cantidad_mayoreo`
2. **SKU**: Se genera automáticamente si no se proporciona (primeras 3 letras + timestamp)
3. **Stock Alerta**: Los productos con `stock <= stock_alerta` se marcan como "stock_bajo"
4. **Backward Compatibility**: El campo `precio` fue renombrado a `precio_caja` en la migración

---

## ✨ Ventajas del Sistema Actualizado

✅ Adaptado específicamente para distribución mayorista
✅ Precios diferenciados por volumen de compra
✅ Control preciso de inventario
✅ Información completa de empaquetado
✅ Trazabilidad con SKU y códigos de barras
✅ Alertas automáticas de stock bajo
✅ Datos de almacenamiento y caducidad
✅ Métodos de cálculo integrados
✅ Datos de ejemplo listos para usar

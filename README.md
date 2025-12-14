# 🧀 DISTRI-JARCA - Sitio Web Corporativo

![DISTRI-JARCA](https://img.shields.io/badge/DISTRI--JARCA-Distribución%20Premium-DA251D?style=for-the-badge)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap_5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

## 📋 Descripción

Sitio web corporativo profesional para **DISTRI-JARCA**, empresa dedicada a la distribución de quesos y embutidos premium. Desarrollado con tecnologías web modernas y diseño responsive.

## 🎨 Paleta de Colores

| Color | Hex | Uso |
|-------|-----|-----|
| **Azul Oscuro** | `#102542` | Navbar, títulos, contraste |
| **Rojo Intenso** | `#DA251D` | Énfasis "JARCA", botones CTA |
| **Amarillo Queso** | `#F9B233` | Fondos suaves, detalles |
| **Rosa Salmón** | `#F28E80` | Embutidos, gradientes |
| **Blanco Crema** | `#FFFFFF` | Fondo principal |

## 🚀 Características

### ✨ Diseño
- ✅ 100% Responsive (Mobile-First)
- ✅ Diseño moderno y profesional
- ✅ Animaciones suaves y atractivas
- ✅ Paleta de colores corporativa
- ✅ Tipografía legible y elegante

### 🧩 Secciones
1. **Navbar** - Navegación fija con efecto scroll
2. **Hero Section** - Llamada a la acción principal
3. **Nosotros** - Historia y estadísticas de la empresa
4. **Productos** - Catálogo con tarjetas visuales
5. **Calidad** - Procesos y certificaciones
6. **Banner de Marca** - Mensaje corporativo destacado
7. **Contacto** - Formulario funcional + información
8. **Footer** - Enlaces, redes sociales y newsletter

### ⚡ Funcionalidades JavaScript
- Scroll suave entre secciones
- Navbar activo según sección visible
- Botón "scroll to top"
- Validación de formularios
- Animaciones al hacer scroll
- Contadores animados en estadísticas
- Efectos hover en tarjetas

## 📁 Estructura del Proyecto

```
DistriJarca/
│
├── index.html          # Estructura HTML principal
├── styles.css          # Estilos CSS personalizados
├── script.js           # JavaScript interactivo
├── assets/             # Carpeta para recursos
│   └── logo-distrijarca.png  # Logo de la empresa (colocar aquí)
│
└── README.md           # Este archivo
```

## 🛠️ Tecnologías Utilizadas

- **HTML5** - Estructura semántica
- **CSS3** - Estilos personalizados con variables CSS
- **Bootstrap 5.3.2** - Framework CSS responsive
- **Bootstrap Icons** - Iconografía
- **JavaScript ES6** - Interactividad

## 📦 Instalación y Uso

### Opción 1: Uso Directo
1. Descarga todos los archivos del proyecto
2. Coloca el logo de la empresa en `assets/logo-distrijarca.png`
3. Abre `index.html` en tu navegador

### Opción 2: Servidor Local
```bash
# Usando Python
python -m http.server 8000

# Usando Node.js (con npx)
npx http-server

# Usando PHP
php -S localhost:8000
```

Luego visita: `http://localhost:8000`

## 🖼️ Logo de la Empresa

**IMPORTANTE:** Debes colocar el logo de DISTRI-JARCA en la ruta:
```
assets/logo-distrijarca.png
```

**Especificaciones recomendadas:**
- Formato: PNG con fondo transparente
- Dimensiones: 200x200px o superior
- Peso: < 50KB para optimización

### Alternativa sin logo
Si no tienes el logo, puedes usar solo texto editando estas líneas en `index.html`:

```html
<!-- Navbar -->
<a class="navbar-brand d-flex align-items-center" href="#inicio">
    <!-- <img src="assets/logo-distrijarca.png" alt="Logo DISTRI-JARCA" class="logo-navbar"> -->
    <span class="brand-text ms-2">DISTRI-<span class="brand-jarca">JARCA</span></span>
</a>

<!-- Footer -->
<!-- <img src="assets/logo-distrijarca.png" alt="Logo DISTRI-JARCA" class="footer-logo mb-3"> -->
```

## 🎯 Características Técnicas

### Variables CSS
El archivo `styles.css` utiliza variables CSS para fácil personalización:

```css
:root {
    --color-azul-oscuro: #102542;
    --color-rojo-intenso: #DA251D;
    --color-amarillo-queso: #F9B233;
    --color-rosa-salmon: #F28E80;
    --color-blanco-crema: #FFFFFF;
}
```

### Clases Reutilizables
- `.section-padding` - Espaciado consistente
- `.section-title` - Títulos de sección
- `.section-label` - Etiquetas decorativas
- `.btn-cta` - Botones de llamada a la acción

### Responsive Breakpoints
- **Mobile**: < 768px
- **Tablet**: 768px - 991px
- **Desktop**: > 992px

## 🎨 Personalización

### Cambiar Colores
Edita las variables CSS en `styles.css`:

```css
:root {
    --color-azul-oscuro: #TU-COLOR;
    --color-rojo-intenso: #TU-COLOR;
    /* ... */
}
```

### Modificar Contenido
- Textos: Edita directamente en `index.html`
- Imágenes: Reemplaza las URLs de Unsplash con tus propias imágenes
- Enlaces de redes sociales: Actualiza los `href` en el footer

### Agregar Productos
Duplica el bloque de `.product-card` en la sección de Productos:

```html
<div class="col-lg-3 col-md-6">
    <div class="product-card">
        <!-- Contenido de la tarjeta -->
    </div>
</div>
```

## ✅ Checklist de Producción

- [ ] Colocar logo real de DISTRI-JARCA
- [ ] Reemplazar imágenes de Unsplash con fotografías reales
- [ ] Actualizar información de contacto (teléfonos, emails, dirección)
- [ ] Configurar formulario de contacto con backend real
- [ ] Agregar enlaces reales a redes sociales
- [ ] Optimizar imágenes (compresión, formato WebP)
- [ ] Agregar Google Analytics o similar
- [ ] Configurar meta tags para SEO
- [ ] Probar en múltiples navegadores
- [ ] Validar HTML y CSS
- [ ] Configurar favicon
- [ ] Implementar HTTPS

## 📱 Compatibilidad

- ✅ Chrome (últimas 2 versiones)
- ✅ Firefox (últimas 2 versiones)
- ✅ Safari (últimas 2 versiones)
- ✅ Edge (últimas 2 versiones)
- ✅ Dispositivos móviles iOS y Android

## 🐛 Solución de Problemas

### Las imágenes no se cargan
- Verifica que el logo esté en `assets/logo-distrijarca.png`
- Asegúrate de tener conexión a internet para las imágenes de Unsplash

### Los estilos no se aplican
- Verifica que `styles.css` esté en la misma carpeta que `index.html`
- Limpia la caché del navegador (Ctrl + F5)

### El JavaScript no funciona
- Abre la consola del navegador (F12) para ver errores
- Verifica que `script.js` esté correctamente vinculado

## 📄 Licencia

Este proyecto es de código abierto y está disponible para uso personal y comercial.

## 👨‍💻 Créditos

- **Desarrollo**: Sitio creado como ejemplo corporativo
- **Imágenes**: Unsplash (reemplazar con imágenes reales)
- **Framework**: Bootstrap 5
- **Iconos**: Bootstrap Icons

## 📞 Soporte

Para consultas sobre personalización o implementación, contacta con el desarrollador.

---

**🧀 DISTRI-JARCA** - *Calidad que llega a tu mesa*

---

## 🔧 Próximas Mejoras Sugeridas

- [ ] Implementar backend para formularios
- [ ] Agregar sección de blog/noticias
- [ ] Crear catálogo de productos interactivo con filtros
- [ ] Añadir carrito de compras (e-commerce)
- [ ] Implementar sistema de cotizaciones en línea
- [ ] Agregar mapa interactivo de ubicación
- [ ] Crear área de clientes/login
- [ ] Optimización SEO avanzada
- [ ] Implementar PWA (Progressive Web App)
- [ ] Añadir multi-idioma

---

¡Gracias por usar este template! 🚀

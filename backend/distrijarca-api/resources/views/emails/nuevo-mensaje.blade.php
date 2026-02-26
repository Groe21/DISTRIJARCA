@component('mail::message')
# Nuevo Mensaje Recibido

Se ha recibido un nuevo mensaje de contacto.

## Información del Remitente

- **Nombre:** {{ $mensaje->nombre }}
- **Email:** {{ $mensaje->email }}
- **Teléfono:** {{ $mensaje->telefono }}
@if($mensaje->empresa)
- **Empresa:** {{ $mensaje->empresa }}
@endif
- **Asunto:** {{ $mensaje->asunto }}

## Mensaje

{{ $mensaje->mensaje }}

---

@component('mail::button', ['url' => route('admin.mensajes.show', $mensaje)])
Ver en Panel Admin
@endcomponent

Gracias,
{{ config('app.name') }}
@endcomponent

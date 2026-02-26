@component('mail::message')
# Respuesta a tu Mensaje

Hola {{ $mensaje->nombre }},

Gracias por contactarnos. Aquí está nuestra respuesta a tu mensaje:

## Tu Mensaje Original

**Asunto:** {{ $mensaje->asunto }}

{{ $mensaje->mensaje }}

---

## Nuestra Respuesta

{!! nl2br(e($mensaje->respuesta)) !!}

---

Si tienes más preguntas, no dudes en contactarnos nuevamente.

Saludos cordiales,
{{ config('app.name') }}
@endcomponent

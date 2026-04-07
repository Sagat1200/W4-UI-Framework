# Forms Backend — FieldError

## Para qué sirve

Modela mensajes de error asociados a campos de formulario desde backend.

## Qué hace

- `FieldError.php`: gestiona `message`, `forField`, `code`, `hint` y estado.
- `FieldErrorComponentEvent.php`: eventos de visibilidad/actividad (`ACTIVATE`, `HIDE`, `SHOW`, etc.).
- `FieldErrorComponentState.php`: estados del componente.
- `FieldErrorInteractState.php`: flags de interacción.
- `FieldErrorStateMachine.php`: reglas de transición.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\Forms\FielError\FieldError;

$error = FieldError::make()
    ->forField('email')
    ->message('El correo es obligatorio')
    ->code('required')
    ->show();

$data = $error->toArray();
```

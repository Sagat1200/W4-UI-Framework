# UI Backend — Label

## Para qué sirve

Modela etiquetas de texto asociadas a controles de formulario.

## Qué hace

- `Label.php`: maneja `text`, `for`, `variant`, `size`, `state`.
- `LabelComponentEvent.php`: eventos de activación y visibilidad.
- `LabelComponentState.php`: estados del label.
- `LabelInteractState.php`: interacción del usuario.
- `LabelStateMachine.php`: reglas de transición.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\UI\Label\Label;

$label = Label::make()
    ->text('Correo')
    ->for('email')
    ->variant('neutral')
    ->show();
```

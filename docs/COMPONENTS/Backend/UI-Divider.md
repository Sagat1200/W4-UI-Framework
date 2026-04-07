# UI Backend — Divider

## Para qué sirve

Representa separadores visuales con orientación horizontal o vertical.

## Qué hace

- `Divider.php`: maneja `text`, `orientation`, `variant`, `size`.
- `DividerComponentEvent.php`: eventos de activación/visibilidad.
- `DividerComponentState.php`: estados disponibles.
- `DividerInteractState.php`: interacción del componente.
- `DividerStateMachine.php`: reglas de cambio de estado.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\UI\Divider\Divider;

$divider = Divider::make()
    ->text('Información')
    ->orientation('horizontal')
    ->show();
```

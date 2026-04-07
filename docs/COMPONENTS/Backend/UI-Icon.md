# UI Backend — Icon

## Para qué sirve

Modela iconos con control de animación y semántica decorativa.

## Qué hace

- `Icon.php`: maneja `icon`, `spin`, `decorative`, `variant`, `size`.
- `IconComponentEvent.php`: eventos de estado y visibilidad.
- `IconComponentState.php`: estados del icon.
- `IconInteractState.php`: interacción asociada.
- `IconStateMachine.php`: validación de transiciones.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\UI\Icon\Icon;

$icon = Icon::make()
    ->icon('refresh')
    ->spin(true)
    ->decorative(true)
    ->size('lg');
```

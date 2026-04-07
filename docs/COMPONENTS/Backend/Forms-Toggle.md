# Forms Backend — Toggle

## Para qué sirve

Modela un switch booleano (encendido/apagado) desde backend.

## Qué hace

- `Toggle.php`: gestiona `checked`, `value`, `helperText`, `errorMessage`.
- `ToggleComponentEvent.php`: eventos (`CHECK`, `UNCHECK`, `TOGGLE`, `SET_INVALID`, etc.).
- `ToggleComponentState.php`: estados del componente.
- `ToggleInteractState.php`: interacción (`focused`, `hovered`, `pressed`).
- `ToggleStateMachine.php`: reglas de transición.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\Forms\Toggle\Toggle;

$toggle = Toggle::make('Notificaciones')
    ->name('notifications')
    ->toggle()
    ->variant('primary')
    ->size('md');
```

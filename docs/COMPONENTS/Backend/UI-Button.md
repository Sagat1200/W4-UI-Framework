# UI Backend — Button

## Para qué sirve

Modela botones de acción con eventos de estado y carga.

## Qué hace

- `Button.php`: API principal (`icon`, `click`, `startLoading`, `setActive`).
- `ButtonComponentEvent.php`: eventos (`CLICK`, `DISABLE`, `START_LOADING`, etc.).
- `ButtonComponentState.php`: estados del botón.
- `ButtonInteractState.php`: flags de interacción.
- `ButtonStateMachine.php`: transición de estados.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\UI\Button\Button;

$button = Button::make('Guardar')
    ->icon('save')
    ->variant('primary')
    ->click()
    ->startLoading();
```

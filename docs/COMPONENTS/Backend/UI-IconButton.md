# UI Backend — IconButton

## Para qué sirve

Representa botones accionables basados en icono.

## Qué hace

- `IconButton.php`: API de `icon`, `click`, `setActive`, `startLoading`.
- `IconButtonComponentEvent.php`: eventos del ciclo de vida.
- `IconButtonComponentState.php`: estados del componente.
- `IconButtonInteractState.php`: flags de interacción.
- `IconButtonStateMachine.php`: transición de estados.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\UI\IconButton\IconButton;

$iconButton = IconButton::make('Editar')
    ->icon('edit')
    ->variant('primary')
    ->click();
```

# Forms Backend — Select

## Para qué sirve

Modela un selector backend con soporte de opción simple o múltiple.

## Qué hace

- `Select.php`: maneja `options`, `selected`, `multiple`, `placeholder`.
- `SelectComponentEvent.php`: eventos (`SELECT`, `CLEAR`, `SET_INVALID`, etc.).
- `SelectComponentState.php`: estados del selector.
- `SelectInteractState.php`: interacción de usuario.
- `SelectStateMachine.php`: aplica transiciones válidas.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\Forms\Select\Select;

$select = Select::make('País')
    ->name('country')
    ->addOption('mx', 'México')
    ->addOption('co', 'Colombia')
    ->select('mx');
```

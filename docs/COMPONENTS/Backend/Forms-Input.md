# Forms Backend — Input

## Para qué sirve

Modela campos de entrada de texto en backend con estado y validación.

## Qué hace

- `Input.php`: API de `type`, `value`, `placeholder`, `helperText`, `errorMessage`.
- `InputComponentEvent.php`: eventos (`SET_INVALID`, `SET_VALID`, `START_LOADING`, etc.).
- `InputComponentState.php`: estados de input.
- `InputInteractState.php`: interacción (`focused`, `hovered`, `filled`).
- `InputStateMachine.php`: reglas de transición entre estados.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\Forms\Input\Input;

$input = Input::make('Correo')
    ->name('email')
    ->type('email')
    ->placeholder('correo@dominio.com')
    ->setInvalid()
    ->errorMessage('Formato inválido');
```

# Forms Backend — Radio

## Para qué sirve

Representa opciones de selección única dentro de un grupo de radios.

## Qué hace

- `Radio.php`: gestiona `value`, `group`, `selected`, además de estado.
- `RadioComponentEvent.php`: eventos como `SELECT`, `CLEAR`, `SET_INVALID`, `RESET`.
- `RadioComponentState.php`: estados operativos del radio.
- `RadioInteractState.php`: flags de interacción.
- `RadioStateMachine.php`: controla transiciones válidas.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\Forms\Radio\Radio;

$radio = Radio::make('Tarjeta')
    ->name('payment_method')
    ->group('payment')
    ->value('card')
    ->select();
```

# Forms Backend — HelperText

## Para qué sirve

Representa texto de ayuda para inputs y controles de formulario.

## Qué hace

- `HelperText.php`: define `text`, `forField`, `icon`, `variant`, `size`, `state`.
- `HelperTextComponentEvent.php`: eventos de estado y visibilidad.
- `HelperTextComponentState.php`: estados disponibles del helper.
- `HelperTextInteractState.php`: interacción del usuario.
- `HelperTextStateMachine.php`: valida transiciones.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\Forms\HelperText\HelperText;

$helper = HelperText::make()
    ->forField('password')
    ->text('Mínimo 8 caracteres')
    ->icon('info')
    ->activate();
```

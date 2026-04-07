# Forms Backend — CheckBox

## Para qué sirve

Representa un campo checkbox en backend, con soporte de estado visual/funcional y serialización para render.

## Qué hace

- `CheckBox.php`: API principal (`checked`, `indeterminate`, `check`, `uncheck`, `toggle`).
- `CheckBoxComponentEvent.php`: eventos (`CHECK`, `UNCHECK`, `TOGGLE`, `SET_INDETERMINATE`, etc.).
- `CheckBoxComponentState.php`: estados (`enabled`, `disabled`, `readonly`, `invalid`, `valid`, `loading`).
- `CheckBoxInteractState.php`: interacción (`focused`, `hovered`, `pressed`).
- `CheckBoxStateMachine.php`: valida transiciones entre estados.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\Forms\CheckBox\CheckBox;

$checkbox = CheckBox::make('Acepto términos')
    ->name('terms')
    ->check()
    ->setValid()
    ->variant('primary');

$payload = $checkbox->toThemeContext();
```

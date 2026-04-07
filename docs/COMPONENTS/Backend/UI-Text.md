# UI Backend — Text

## Para qué sirve

Modela texto de interfaz con estilo y estado.

## Qué hace

- `Text.php`: gestiona `text`, `variant`, `size`, y `state`.
- `TextComponentEvent.php`: eventos de estado (`ACTIVATE`, `HIDE`, `SHOW`, etc.).
- `TextComponentState.php`: estados válidos.
- `TextInteractState.php`: interacción del componente.
- `TextStateMachine.php`: reglas de transición.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\UI\Text\Text;

$text = Text::make()
    ->text('Operación completada')
    ->variant('success')
    ->size('sm')
    ->show();
```

# Forms Backend — TextArea

## Para qué sirve

Representa áreas de texto multilínea con estado, validación e interacción.

## Qué hace

- `TextArea.php`: API de `value`, `placeholder`, `rows`, `cols`, `resize`.
- `TextAreaComponentEvent.php`: eventos (`INPUT`, `SET_READONLY`, `SET_INVALID`, etc.).
- `TextAreaComponentState.php`: estados del componente.
- `TextAreaInteractState.php`: flags de interacción (`focused`, `hovered`, `filled`).
- `TextAreaStateMachine.php`: valida cambios de estado.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\Forms\TextArea\TextArea;

$textArea = TextArea::make('Descripción')
    ->name('description')
    ->rows(6)
    ->resize('vertical')
    ->value('Contenido inicial')
    ->setValid();
```

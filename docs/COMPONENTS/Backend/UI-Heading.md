# UI Backend — Heading

## Para qué sirve

Modela títulos semánticos (`h1` a `h6`) con estado y estilo.

## Qué hace

- `Heading.php`: gestiona `text`, `level`, `size`, y auto-size por nivel.
- `HeadingComponentEvent.php`: eventos de estado (`ACTIVATE`, `HIDE`, etc.).
- `HeadingComponentState.php`: estados válidos del heading.
- `HeadingInteractState.php`: flags de interacción.
- `HeadingStateMachine.php`: transición de estados.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\UI\Heading\Heading;

$heading = Heading::make()
    ->text('Dashboard')
    ->level('h1')
    ->variant('primary')
    ->activate();
```

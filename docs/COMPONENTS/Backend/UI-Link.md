# UI Backend — Link

## Para qué sirve

Modela enlaces navegables con estado y opciones de destino.

## Qué hace

- `Link.php`: define `text`, `href`, `target`, `rel`, `variant`, `size`.
- `LinkComponentEvent.php`: eventos de visibilidad/actividad.
- `LinkComponentState.php`: estados del link.
- `LinkInteractState.php`: flags de interacción.
- `LinkStateMachine.php`: transición de estados.

## Ejemplo de funcionamiento

```php
use W4\UiFramework\Components\UI\Link\Link;

$link = Link::make('Documentación')
    ->href('https://w4.software')
    ->target('_blank')
    ->rel('noopener')
    ->variant('primary');
```

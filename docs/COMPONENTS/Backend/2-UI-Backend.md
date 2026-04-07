# Backend UI Components — W4-Ui-Framework

## Objetivo

Este documento describe las clases de backend ubicadas en `src/Components/UI`, para qué sirven, qué hacen y cómo usarlas.

Cada componente UI sigue la estructura:

- `Componente.php`
- `ComponenteComponentEvent.php`
- `ComponenteComponentState.php`
- `ComponenteInteractState.php`
- `ComponenteStateMachine.php`

## Button

Clases:

- `Button`
- `ButtonComponentEvent`
- `ButtonComponentState`
- `ButtonInteractState`
- `ButtonStateMachine`

Qué hacen:

- `Button` modela botón de acción (`icon`, `variant`, `size`, `state`).
- `ButtonComponentEvent` define eventos (`CLICK`, `START_LOADING`, `SET_ACTIVE`, etc.).
- `ButtonComponentState` define estados de interacción.
- `ButtonInteractState` guarda flags de interacción de usuario.
- `ButtonStateMachine` valida transiciones.

Ejemplo:

```php
use W4\UiFramework\Components\UI\Button\Button;

$button = Button::make('Guardar')
    ->icon('save')
    ->variant('primary')
    ->size('md')
    ->startLoading();
```

## Divider

Clases:

- `Divider`
- `DividerComponentEvent`
- `DividerComponentState`
- `DividerInteractState`
- `DividerStateMachine`

Qué hacen:

- `Divider` modela separador visual (`text`, `orientation`).
- `DividerComponentEvent` define eventos de estado (`ACTIVATE`, `HIDE`, `SHOW`, etc.).
- `DividerComponentState` define estados.
- `DividerInteractState` modela interacción asociada.
- `DividerStateMachine` resuelve transiciones válidas.

Ejemplo:

```php
use W4\UiFramework\Components\UI\Divider\Divider;

$divider = Divider::make()
    ->text('Sección')
    ->orientation('horizontal')
    ->variant('neutral');
```

## Heading

Clases:

- `Heading`
- `HeadingComponentEvent`
- `HeadingComponentState`
- `HeadingInteractState`
- `HeadingStateMachine`

Qué hacen:

- `Heading` modela títulos semánticos (`text`, `level`, `size`).
- `Heading` ajusta tamaño automático por nivel si no hay tamaño explícito.
- `HeadingComponentEvent` define eventos de estado.
- `HeadingComponentState` enumera estados disponibles.
- `HeadingStateMachine` controla transiciones.

Ejemplo:

```php
use W4\UiFramework\Components\UI\Heading\Heading;

$heading = Heading::make()
    ->text('Panel de control')
    ->level('h1')
    ->variant('primary')
    ->activate();
```

## Icon

Clases:

- `Icon`
- `IconComponentEvent`
- `IconComponentState`
- `IconInteractState`
- `IconStateMachine`

Qué hacen:

- `Icon` modela iconografía (`icon`, `spin`, `decorative`).
- `IconComponentEvent` define eventos de estado/visibilidad.
- `IconComponentState` define estados.
- `IconInteractState` guarda interacción.
- `IconStateMachine` aplica reglas de transición.

Ejemplo:

```php
use W4\UiFramework\Components\UI\Icon\Icon;

$icon = Icon::make()
    ->icon('refresh')
    ->spin(true)
    ->decorative(true)
    ->size('lg');
```

## IconButton

Clases:

- `IconButton`
- `IconButtonComponentEvent`
- `IconButtonComponentState`
- `IconButtonInteractState`
- `IconButtonStateMachine`

Qué hacen:

- `IconButton` combina botón + icono (`icon`, `variant`, `size`).
- `IconButtonComponentEvent` incluye eventos como `CLICK`, `SET_ACTIVE`, `START_LOADING`.
- `IconButtonComponentState` define estados operativos.
- `IconButtonInteractState` representa interacción.
- `IconButtonStateMachine` valida transiciones.

Ejemplo:

```php
use W4\UiFramework\Components\UI\IconButton\IconButton;

$iconButton = IconButton::make('Acción')
    ->icon('edit')
    ->variant('primary')
    ->click();
```

## Label

Clases:

- `Label`
- `LabelComponentEvent`
- `LabelComponentState`
- `LabelInteractState`
- `LabelStateMachine`

Qué hacen:

- `Label` modela etiqueta de texto (`text`, `for`).
- `LabelComponentEvent` gestiona activación/visibilidad.
- `LabelComponentState` define estados.
- `LabelInteractState` conserva flags de interacción.
- `LabelStateMachine` controla reglas de transición.

Ejemplo:

```php
use W4\UiFramework\Components\UI\Label\Label;

$label = Label::make()
    ->text('Correo')
    ->for('email')
    ->variant('neutral');
```

## Link

Clases:

- `Link`
- `LinkComponentEvent`
- `LinkComponentState`
- `LinkInteractState`
- `LinkStateMachine`

Qué hacen:

- `Link` modela enlace (`text`, `href`, `target`, `rel`).
- `LinkComponentEvent` define eventos de estado.
- `LinkComponentState` define estados de interacción/visibilidad.
- `LinkInteractState` modela interacción.
- `LinkStateMachine` aplica transiciones válidas.

Ejemplo:

```php
use W4\UiFramework\Components\UI\Link\Link;

$link = Link::make('Documentación')
    ->href('https://w4.software')
    ->target('_blank')
    ->rel('noopener')
    ->variant('primary');
```

## Text

Clases:

- `Text`
- `TextComponentEvent`
- `TextComponentState`
- `TextInteractState`
- `TextStateMachine`

Qué hacen:

- `Text` modela texto simple estilizable (`text`, `variant`, `size`).
- `TextComponentEvent` define eventos de visibilidad/estado (`ACTIVATE`, `HIDE`, etc.).
- `TextComponentState` enumera estados válidos.
- `TextInteractState` guarda interacción.
- `TextStateMachine` controla transiciones.

Ejemplo:

```php
use W4\UiFramework\Components\UI\Text\Text;

$text = Text::make()
    ->text('Operación completada')
    ->variant('success')
    ->size('sm')
    ->show();
```

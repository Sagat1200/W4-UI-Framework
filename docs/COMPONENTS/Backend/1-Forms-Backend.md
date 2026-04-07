# Backend Forms Components — W4-Ui-Framework

## Objetivo

Este documento describe las clases de backend ubicadas en `src/Components/Forms`, para qué sirven, qué hacen y cómo usarlas.

Cada componente de Forms sigue la misma estructura:

- `Componente.php`: API principal del componente.
- `ComponenteComponentEvent.php`: eventos de transición.
- `ComponenteComponentState.php`: estados del componente.
- `ComponenteInteractState.php`: flags de interacción de usuario.
- `ComponenteStateMachine.php`: reglas de transición de estados.

## CheckBox

Clases:

- `CheckBox`
- `CheckBoxComponentEvent`
- `CheckBoxComponentState`
- `CheckBoxInteractState`
- `CheckBoxStateMachine`

Qué hacen:

- `CheckBox` modela un checkbox con `checked`, `indeterminate`, `helperText`, `errorMessage`.
- `CheckBoxComponentEvent` define eventos como `CHECK`, `UNCHECK`, `TOGGLE`, `SET_INDETERMINATE`.
- `CheckBoxComponentState` define estados (`enabled`, `disabled`, `readonly`, `invalid`, `valid`, `loading`).
- `CheckBoxInteractState` guarda interacción (`focused`, `hovered`, `pressed`).
- `CheckBoxStateMachine` valida y ejecuta transiciones de estado.

Ejemplo:

```php
use W4\UiFramework\Components\Forms\CheckBox\CheckBox;

$checkbox = CheckBox::make('Acepto términos')
    ->name('terms')
    ->check()
    ->variant('primary')
    ->size('md')
    ->setValid();

$payload = $checkbox->toArray();
```

## FieldError

Clases:

- `FieldError`
- `FieldErrorComponentEvent`
- `FieldErrorComponentState`
- `FieldErrorInteractState`
- `FieldErrorStateMachine`

Qué hacen:

- `FieldError` modela el mensaje de error de campo (`message`, `forField`, `code`, `hint`).
- `FieldErrorComponentEvent` maneja eventos de visibilidad/actividad (`ACTIVATE`, `HIDE`, `SHOW`, etc.).
- `FieldErrorComponentState` define estados de ciclo de vida del mensaje.
- `FieldErrorInteractState` representa interacción visual.
- `FieldErrorStateMachine` controla transiciones válidas.

Ejemplo:

```php
use W4\UiFramework\Components\Forms\FielError\FieldError;

$error = FieldError::make()
    ->message('El correo es obligatorio')
    ->forField('email')
    ->code('required')
    ->setActive();

$context = $error->toThemeContext();
```

## HelperText

Clases:

- `HelperText`
- `HelperTextComponentEvent`
- `HelperTextComponentState`
- `HelperTextInteractState`
- `HelperTextStateMachine`

Qué hacen:

- `HelperText` modela texto de ayuda asociado a un campo (`text`, `forField`, `icon`).
- `HelperTextComponentEvent` define eventos de estado (`ACTIVATE`, `DISABLE`, `HIDE`, etc.).
- `HelperTextComponentState` enumera estados válidos.
- `HelperTextInteractState` conserva estado de interacción.
- `HelperTextStateMachine` aplica reglas de transición.

Ejemplo:

```php
use W4\UiFramework\Components\Forms\HelperText\HelperText;

$helper = HelperText::make()
    ->text('Usa una contraseña de al menos 8 caracteres')
    ->forField('password')
    ->icon('info')
    ->variant('neutral');
```

## Input

Clases:

- `Input`
- `InputComponentEvent`
- `InputComponentState`
- `InputInteractState`
- `InputStateMachine`

Qué hacen:

- `Input` modela un campo de entrada (`type`, `value`, `placeholder`, `helperText`, `errorMessage`).
- `InputComponentEvent` define eventos funcionales (`SET_INVALID`, `START_LOADING`, etc.).
- `InputComponentState` define estados de validación/edición.
- `InputInteractState` guarda interacción (`focused`, `hovered`, `filled`).
- `InputStateMachine` resuelve transiciones.

Ejemplo:

```php
use W4\UiFramework\Components\Forms\Input\Input;

$input = Input::make('Correo')
    ->name('email')
    ->type('email')
    ->placeholder('correo@dominio.com')
    ->setInvalid()
    ->errorMessage('Formato inválido');
```

## Radio

Clases:

- `Radio`
- `RadioComponentEvent`
- `RadioComponentState`
- `RadioInteractState`
- `RadioStateMachine`

Qué hacen:

- `Radio` modela una opción radio (`value`, `group`, `selected`).
- `RadioComponentEvent` define eventos (`SELECT`, `CLEAR`, `DISABLE`, etc.).
- `RadioComponentState` define estados operativos.
- `RadioInteractState` guarda flags de interacción.
- `RadioStateMachine` valida cambios de estado.

Ejemplo:

```php
use W4\UiFramework\Components\Forms\Radio\Radio;

$radio = Radio::make('Tarjeta')
    ->name('payment_method')
    ->group('payment')
    ->value('card')
    ->select();
```

## Select

Clases:

- `Select`
- `SelectComponentEvent`
- `SelectComponentState`
- `SelectInteractState`
- `SelectStateMachine`

Qué hacen:

- `Select` modela un selector con `options`, `selected`, `multiple`, `placeholder`.
- `SelectComponentEvent` define eventos de selección y estado (`SELECT`, `CLEAR`, `SET_INVALID`, etc.).
- `SelectComponentState` enumera estados.
- `SelectInteractState` conserva interacción de usuario.
- `SelectStateMachine` aplica reglas de transición.

Ejemplo:

```php
use W4\UiFramework\Components\Forms\Select\Select;

$select = Select::make('País')
    ->name('country')
    ->addOption('mx', 'México')
    ->addOption('co', 'Colombia')
    ->select('mx')
    ->variant('default');
```

## TextArea

Clases:

- `TextArea`
- `TextAreaComponentEvent`
- `TextAreaComponentState`
- `TextAreaInteractState`
- `TextAreaStateMachine`

Qué hacen:

- `TextArea` modela área de texto (`value`, `placeholder`, `rows`, `cols`, `resize`).
- `TextAreaComponentEvent` define eventos (`INPUT`, `SET_READONLY`, `SET_INVALID`, etc.).
- `TextAreaComponentState` define estados (`enabled`, `disabled`, `readonly`, `invalid`, `valid`, `loading`).
- `TextAreaInteractState` guarda interacción (`focused`, `hovered`, `filled`).
- `TextAreaStateMachine` valida transiciones.

Ejemplo:

```php
use W4\UiFramework\Components\Forms\TextArea\TextArea;

$textArea = TextArea::make('Descripción')
    ->name('description')
    ->rows(6)
    ->resize('vertical')
    ->value('Contenido inicial')
    ->setValid();
```

## Toggle

Clases:

- `Toggle`
- `ToggleComponentEvent`
- `ToggleComponentState`
- `ToggleInteractState`
- `ToggleStateMachine`

Qué hacen:

- `Toggle` modela un switch booleano (`checked`, `value`, `helperText`, `errorMessage`).
- `ToggleComponentEvent` define eventos de cambio (`CHECK`, `UNCHECK`, `TOGGLE`, etc.).
- `ToggleComponentState` define estados de ciclo de vida.
- `ToggleInteractState` guarda interacción (`focused`, `hovered`, `pressed`).
- `ToggleStateMachine` controla transiciones válidas.

Ejemplo:

```php
use W4\UiFramework\Components\Forms\Toggle\Toggle;

$toggle = Toggle::make('Notificaciones')
    ->name('notifications')
    ->toggle()
    ->variant('primary')
    ->size('md');
```

## Nota de implementación

El namespace actual de `FieldError` usa carpeta `FielError`, por lo que el import correcto en backend es:

```php
use W4\UiFramework\Components\Forms\FielError\FieldError;
```

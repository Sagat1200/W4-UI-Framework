<?php

namespace W4\UiFramework\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use W4\UiFramework\Contracts\ComponentInterface;
use W4\UiFramework\Support\W4UiManager;

class Render extends Component
{
    public function __construct(
        public ComponentInterface $component,
        public ?string $renderer = null
    ) {}

    public function render(): View
    {
        return view('w4-ui::components.render');
    }

    public function html(): string
    {
        return app(W4UiManager::class)->render(
            $this->component,
            $this->renderer
        );
    }
}
<?php

namespace W4\UI\Framework\Renderers;

use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\Core\AbstractRenderer;

class BladeRenderer extends AbstractRenderer
{
    public function render(ComponentInterface $component, array $resolvedTheme = []): array
    {
        $componentName = $component->componentName();
        $candidates = $this->buildViewCandidates($componentName);
        $view = collect($candidates)->first(fn(string $candidate) => view()->exists($candidate))
            ?? ('w4-ui::components.ui.' . $componentName);

        return [
            'renderer' => 'blade',
            'view' => $view,
            'component' => $componentName,
            'data' => $component->toArray(),
            'theme' => $resolvedTheme,
        ];
    }

    protected function buildViewCandidates(string $componentName): array
    {
        $dynamic = $this->discoverDynamicCandidates($componentName);
        $fallback = [
            'w4-ui::components.ui.' . $componentName,
            'w4-ui::components.forms.' . $componentName,
            'w4-ui::components.' . $componentName,
        ];

        return array_values(array_unique(array_merge($dynamic, $fallback)));
    }

    protected function discoverDynamicCandidates(string $componentName): array
    {
        $componentsPath = realpath(__DIR__ . '/../../resources/views/components');

        if (! is_string($componentsPath) || ! is_dir($componentsPath)) {
            return [];
        }

        $matches = [];
        $targetFile = $componentName . '.blade.php';

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($componentsPath, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (! $file instanceof \SplFileInfo || ! $file->isFile()) {
                continue;
            }

            if ($file->getFilename() !== $targetFile) {
                continue;
            }

            $directory = str_replace('\\', '/', (string) $file->getPath());
            $normalizedRoot = str_replace('\\', '/', $componentsPath);
            $relative = ltrim(str_replace($normalizedRoot, '', $directory), '/');
            $segments = $relative === '' ? [] : explode('/', $relative);

            if (in_array('blade', $segments, true)) {
                continue;
            }

            $view = $relative === ''
                ? 'w4-ui::components.' . $componentName
                : 'w4-ui::components.' . str_replace('/', '.', $relative) . '.' . $componentName;

            $matches[] = $view;
        }

        usort($matches, function (string $a, string $b) use ($componentName): int {
            $namespaceA = str_replace('w4-ui::components.', '', str_replace('.' . $componentName, '', $a));
            $namespaceB = str_replace('w4-ui::components.', '', str_replace('.' . $componentName, '', $b));

            $priority = [
                'ui' => 0,
                'forms' => 1,
            ];

            $scoreA = $priority[$namespaceA] ?? 2;
            $scoreB = $priority[$namespaceB] ?? 2;

            if ($scoreA !== $scoreB) {
                return $scoreA <=> $scoreB;
            }

            return $a <=> $b;
        });

        return array_values(array_unique($matches));
    }
}
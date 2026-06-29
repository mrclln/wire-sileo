<?php

declare(strict_types=1);

namespace Sileo\Notifications;

use Livewire\Component;
use Sileo\Enums\Position;

class SileoNotification
{
    protected array $options;
    protected ?Component $component;

    public function __construct(?Component $component = null, array $options = [])
    {
        $this->component = $component;
        $this->options = $options;
    }

    public function title(string $title): static
    {
        $this->options['title'] = $title;

        return $this;
    }

    public function description(string $description): static
    {
        $this->options['description'] = $description;

        return $this;
    }

    public function html(string $html): static
    {
        $this->options['html'] = $html;

        return $this;
    }

    public function position(Position|string $position = Position::TopRight): static
    {
        $this->options['position'] = $position instanceof Position ? $position->value : $position;

        return $this;
    }

    public function duration(?int $duration): static
    {
        $this->options['duration'] = $duration;

        return $this;
    }

    public function theme(string $theme): static
    {
        $this->options['theme'] = $theme;

        return $this;
    }

    public function fill(string $fill): static
    {
        $this->options['fill'] = $fill;

        return $this;
    }

    public function roundness(int $roundness): static
    {
        $this->options['roundness'] = $roundness;

        return $this;
    }

    public function styles(array $styles): static
    {
        $this->options['styles'] = array_merge($this->options['styles'] ?? [], $styles);

        return $this;
    }

    public function option(string $key, mixed $value): static
    {
        $this->options[$key] = $value;

        return $this;
    }

    public function options(array $options): static
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function type(string $type): static
    {
        $this->options['type'] = $type;

        return $this;
    }

    public function success(): static
    {
        return $this->type('success');
    }

    public function error(): static
    {
        return $this->type('error');
    }

    public function warning(): static
    {
        return $this->type('warning');
    }

    public function info(): static
    {
        return $this->type('info');
    }

    public function loading(): static
    {
        return $this->type('loading');
    }

    public function danger(): static
    {
        return $this->error();
    }

    public function action(): static
    {
        $this->options['type'] = 'action';

        return $this;
    }

    public function confirm(string $label = 'Confirm', string $event = 'sileo.confirm', array $params = []): static
    {
        return $this->button($label, $event, $params);
    }

    public function cancel(string $event = 'sileo.cancel', array $params = []): static
    {
        $this->options['dismissEvent'] = [
            'event' => $event,
            'params' => $params,
        ];

        return $this;
    }

    public function button(string $label, string $event, array $params = []): static
    {
        $this->options['button'] = [
            'title' => $label,
            'event' => $event,
            'params' => $params,
        ];

        return $this;
    }

    public function customClasses(array|string $classes): static
    {
        $this->options['className'] = is_array($classes) ? implode(' ', $classes) : $classes;

        return $this;
    }

    public function icon(string $icon): static
    {
        $this->options['icon'] = $icon;

        return $this;
    }

    public function promise(): static
    {
        $this->options['type'] = 'promise';

        return $this;
    }

    public function event(string $event): static
    {
        $this->options['event'] = $event;

        return $this;
    }

    public function loadingOptions(string|array|null $options = null): static
    {
        if (is_array($options)) {
            $this->options['loading'] = $options;
        } elseif ($options !== null) {
            $this->options['loading'] = ['title' => $options, 'description' => ''];
        } else {
            $this->options['loading'] = [];
        }

        return $this;
    }

    public function successOptions(string|array|null $options = null): static
    {
        if (is_array($options)) {
            $this->options['success'] = $options;
        } elseif ($options !== null) {
            $this->options['success'] = ['title' => $options, 'description' => ''];
        } else {
            $this->options['success'] = [];
        }

        return $this;
    }

    public function errorOptions(string|array|null $options = null): static
    {
        if (is_array($options)) {
            $this->options['error'] = $options;
        } elseif ($options !== null) {
            $this->options['error'] = ['title' => $options, 'description' => ''];
        } else {
            $this->options['error'] = [];
        }

        return $this;
    }

    public function send(): void
    {
        if (! $this->component) {
            throw new \RuntimeException('Sileo requires a Livewire component context to send notifications.');
        }

        $payload = $this->normalizePayload($this->options);
        $type = $this->options['type'] ?? 'info';

        if ($type === 'promise') {
            $this->dispatch('sileo.promise', $payload);

            return;
        }

        $this->dispatch('sileo', $payload);
    }

    public function toArray(): array
    {
        return $this->options;
    }

    protected function dispatch(string $event, array $payload): void
    {
        if (method_exists($this->component, 'dispatch')) {
            $this->component->dispatch($event, $payload);

            return;
        }

        $this->component->dispatchBrowserEvent($event, $payload);
    }

    protected function normalizePayload(array $payload): array
    {
        foreach ($payload as $key => $value) {
            if (is_null($value)) {
                unset($payload[$key]);
            }
        }

        return $payload;
    }
}

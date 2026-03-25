<?php

namespace mrclln\WireSileo;

use mrclln\WireSileo\Contracts\Alertable;
use mrclln\WireSileo\Concerns\Sileo as SileoConcern;
use Livewire\Component;

class WireSileo implements Alertable
{
    use SileoConcern;

    /**
     * The toast title.
     */
    protected ?string $title = null;

    /**
     * The toast description.
     */
    protected string|null $description = null;

    /**
     * The toast type.
     */
    protected string $type = 'info';

    /**
     * The toast position.
     */
    protected string $position = 'top-right';

    /**
     * The toast duration in milliseconds.
     */
    protected ?int $duration = 3000;

    /**
     * Whether to show the toast as a toast (non-blocking).
     */
    protected bool $toast = true;

    /**
     * Custom icon element.
     */
    protected $icon = null;

    /**
     * Custom styles for the toast.
     */
    protected array $styles = [];

    /**
     * Fill color for the toast.
     */
    protected ?string $fill = null;

    /**
     * Border radius for the toast.
     */
    protected ?int $roundness = null;

    /**
     * Toast button configuration.
     */
    protected ?array $button = null;

    /**
     * Create a new WireSileo instance.
     */
    public function __construct(protected ?Component $component)
    {
        throw_if(
            !$this->component instanceof Component,
            new \Exception('WireSileo requires a Livewire component context.')
        );

        // Load default config
        $this->position = config('wire-sileo.position', 'top-right');
        $this->duration = config('wire-sileo.duration', 3000);
        $this->fill = config('wire-sileo.fill', null);
        $this->roundness = config('wire-sileo.roundness', null);
    }

    /**
     * Set the toast title.
     */
    public function title(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set the toast description.
     */
    public function description(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set the toast type to success.
     */
    public function success(): static
    {
        $this->type = 'success';
        return $this;
    }

    /**
     * Set the toast type to error.
     */
    public function error(): static
    {
        $this->type = 'error';
        return $this;
    }

    /**
     * Set the toast type to warning.
     */
    public function warning(): static
    {
        $this->type = 'warning';
        return $this;
    }

    /**
     * Set the toast type to info.
     */
    public function info(): static
    {
        $this->type = 'info';
        return $this;
    }

    /**
     * Set the toast type to loading.
     */
    public function loading(): static
    {
        $this->type = 'loading';
        return $this;
    }

    /**
     * Set the toast type to action.
     */
    public function action(): static
    {
        $this->type = 'action';
        return $this;
    }

    /**
     * Set the toast position.
     */
    public function position(string $position): static
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Set toast position to top-left.
     */
    public function topLeft(): static
    {
        return $this->position('top-left');
    }

    /**
     * Set toast position to top-center.
     */
    public function topCenter(): static
    {
        return $this->position('top-center');
    }

    /**
     * Set toast position to top-right.
     */
    public function topRight(): static
    {
        return $this->position('top-right');
    }

    /**
     * Set toast position to bottom-left.
     */
    public function bottomLeft(): static
    {
        return $this->position('bottom-left');
    }

    /**
     * Set toast position to bottom-center.
     */
    public function bottomCenter(): static
    {
        return $this->position('bottom-center');
    }

    /**
     * Set toast position to bottom-right.
     */
    public function bottomRight(): static
    {
        return $this->position('bottom-right');
    }

    /**
     * Set the toast duration (in milliseconds).
     */
    public function duration(?int $duration): static
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * Set the toast to persist indefinitely (no auto-dismiss).
     */
    public function persistent(): static
    {
        $this->duration = null;
        return $this;
    }

    /**
     * Set a custom icon.
     */
    public function icon($icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Remove the default icon.
     */
    public function noIcon(): static
    {
        $this->icon = null;
        return $this;
    }

    /**
     * Set custom styles for the toast.
     */
    public function styles(array $styles): static
    {
        $this->styles = $styles;
        return $this;
    }

    /**
     * Set the fill color.
     */
    public function fill(string $fill): static
    {
        $this->fill = $fill;
        return $this;
    }

    /**
     * Set the border radius.
     */
    public function roundness(int $roundness): static
    {
        $this->roundness = $roundness;
        return $this;
    }

    /**
     * Add a button to the toast.
     */
    public function button(string $title, ?string $action = null): static
    {
        $this->button = [
            'title' => $title,
            'action' => $action,
        ];
        return $this;
    }

    /**
     * Show the toast.
     */
    public function show(): void
    {
        $options = $this->getOptions();
        $this->alert($options);
    }

    /**
     * Get the merged options for Sileo.
     */
    protected function getOptions(): array
    {
        return array_filter([
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'position' => $this->position,
            'duration' => $this->duration,
            'icon' => $this->icon,
            'styles' => $this->styles ?: null,
            'fill' => $this->fill,
            'roundness' => $this->roundness,
            'button' => $this->button ? [
                'title' => $this->button['title'],
                'onClick' => $this->button['action']
                    ? "function() { window.Livewire.dispatch('{$this->button['action']}') }"
                    : null,
            ] : null,
        ], fn($value) => $value !== null);
    }

    /**
     * Reset the options to defaults.
     */
    protected function reset(): void
    {
        $this->title = null;
        $this->description = null;
        $this->type = 'info';
        $this->position = config('wire-sileo.position', 'top-right');
        $this->duration = config('wire-sileo.duration', 3000);
        $this->icon = null;
        $this->styles = [];
        $this->fill = config('wire-sileo.fill', null);
        $this->roundness = config('wire-sileo.roundness', null);
        $this->button = null;
    }
}

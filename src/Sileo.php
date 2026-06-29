<?php

declare(strict_types=1);

namespace Sileo;

use Livewire\Component;
use Sileo\Enums\Position;
use Sileo\Notifications\SileoNotification;

class Sileo
{
    protected ?Component $component = null;

    public function __construct(?Component $component = null)
    {
        $this->component = $component;
    }

    public static function component(?Component $component = null): static
    {
        return new static($component);
    }

    public static function make(?Component $component = null): SileoNotification
    {
        $comp = $component;

        if (! $comp && app()->bound('livewire')) {
            $comp = app('livewire')->current();
        }

        return new SileoNotification(
            $comp,
            (new static($component))->defaultOptions()
        );
    }

    protected function resolveComponent(): ?Component
    {
        if ($this->component !== null) {
            return $this->component;
        }

        if (app()->bound('livewire')) {
            $component = app('livewire')->current();

            return $component instanceof Component ? $component : null;
        }

        return null;
    }

    public static function title(string $title): SileoNotification
    {
        return static::make()->title($title);
    }

    public static function description(string $description): SileoNotification
    {
        return static::make()->description($description);
    }

    public static function text(string $text): SileoNotification
    {
        return static::make()->description($text);
    }

    public static function html(string $html): SileoNotification
    {
        return static::make()->html($html);
    }

    public static function position(Position|string $position = Position::TopRight): SileoNotification
    {
        return static::make()->position($position);
    }

    public static function duration(?int $duration): SileoNotification
    {
        return static::make()->duration($duration);
    }

    public static function theme(string $theme): SileoNotification
    {
        return static::make()->theme($theme);
    }

    public static function fill(string $fill): SileoNotification
    {
        return static::make()->fill($fill);
    }

    public static function roundness(int $roundness): SileoNotification
    {
        return static::make()->roundness($roundness);
    }

    public static function styles(array $styles): SileoNotification
    {
        return static::make()->styles($styles);
    }

    public static function icon(string $icon): SileoNotification
    {
        return static::make()->icon($icon);
    }

    public static function option(string $key, mixed $value): SileoNotification
    {
        return static::make()->option($key, $value);
    }

    public static function options(array $options): SileoNotification
    {
        return static::make()->options($options);
    }

    public static function success(string|array|null $title = null, string $description = '', ?int $duration = null, Position|string $position = Position::TopRight): SileoNotification
    {
        $notification = static::make()->success();

        if (is_array($title)) {
            $notification->options($title);
        } elseif ($title !== null) {
            $notification->title($title)->description($description);
        }

        return $notification->duration($duration)->position($position);
    }

    public static function error(string|array|null $title = null, string $description = '', ?int $duration = null, Position|string $position = Position::TopRight): SileoNotification
    {
        $notification = static::make()->error();

        if (is_array($title)) {
            $notification->options($title);
        } elseif ($title !== null) {
            $notification->title($title)->description($description);
        }

        return $notification->duration($duration)->position($position);
    }

    public static function warning(string|array|null $title = null, string $description = '', ?int $duration = null, Position|string $position = Position::TopRight): SileoNotification
    {
        $notification = static::make()->warning();

        if (is_array($title)) {
            $notification->options($title);
        } elseif ($title !== null) {
            $notification->title($title)->description($description);
        }

        return $notification->duration($duration)->position($position);
    }

    public static function info(string|array|null $title = null, string $description = '', ?int $duration = null, Position|string $position = Position::TopRight): SileoNotification
    {
        $notification = static::make()->info();

        if (is_array($title)) {
            $notification->options($title);
        } elseif ($title !== null) {
            $notification->title($title)->description($description);
        }

        return $notification->duration($duration)->position($position);
    }

    public static function loading(string|array|null $title = null, string $description = '', ?int $duration = null, Position|string $position = Position::TopRight): SileoNotification
    {
        $notification = static::make()->loading();

        if (is_array($title)) {
            $notification->options($title);
        } elseif ($title !== null) {
            $notification->title($title)->description($description);
        }

        return $notification->duration($duration)->position($position);
    }

    public static function danger(string|array|null $title = null, string $description = '', ?int $duration = null, Position|string $position = Position::TopRight): SileoNotification
    {
        $notification = static::make()->danger();

        if (is_array($title)) {
            $notification->options($title);
        } elseif ($title !== null) {
            $notification->title($title)->description($description);
        }

        return $notification->duration($duration)->position($position);
    }

    public static function action(string|array|null $options = null): SileoNotification
    {
        $notification = static::make()->action();

        if (is_array($options)) {
            $notification->options($options);
        }

        return $notification;
    }

    public static function promise(string|array $options = []): SileoNotification
    {
        $notification = static::make()->promise();

        if (is_string($options)) {
            $notification->option('event', $options);
        } elseif (is_array($options)) {
            $notification->options($options);
        }

        return $notification;
    }

    public static function promiseResolve(string $event, array $data = []): void
    {
        $component = app('livewire')->current();

        if (! $component instanceof Component) {
            throw new \RuntimeException('Sileo requires a Livewire component context.');
        }

        if (method_exists($component, 'dispatch')) {
            $component->dispatch("sileo.resolve.{$event}", $data);
        } else {
            $component->dispatchBrowserEvent("sileo.resolve.{$event}", $data);
        }
    }

    public static function promiseReject(string $event, array $data = []): void
    {
        $component = app('livewire')->current();

        if (! $component instanceof Component) {
            throw new \RuntimeException('Sileo requires a Livewire component context.');
        }

        if (method_exists($component, 'dispatch')) {
            $component->dispatch("sileo.reject.{$event}", $data);
        } else {
            $component->dispatchBrowserEvent("sileo.reject.{$event}", $data);
        }
    }

    protected function defaultOptions(): array
    {
        return array_filter(config('wire-sileo', []), static fn ($value) => !is_null($value));
    }
}
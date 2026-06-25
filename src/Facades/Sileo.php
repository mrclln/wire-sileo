<?php

declare(strict_types=1);

namespace Sileo\Facades;

use Illuminate\Support\Facades\Facade;
use Sileo\Enums\Position;

/**
 * @method static \Sileo\Notifications\SileoNotification make(?\Livewire\Component $component = null)
 * @method static \Sileo\Notifications\SileoNotification title(string $title)
 * @method static \Sileo\Notifications\SileoNotification description(string $description)
 * @method static \Sileo\Notifications\SileoNotification text(string $text)
 * @method static \Sileo\Notifications\SileoNotification html(string $html)
 * @method static \Sileo\Notifications\SileoNotification position(Position|string $position = Position::TopRight)
 * @method static \Sileo\Notifications\SileoNotification duration(int|null $duration)
 * @method static \Sileo\Notifications\SileoNotification theme(string $theme)
 * @method static \Sileo\Notifications\SileoNotification fill(string $fill)
 * @method static \Sileo\Notifications\SileoNotification roundness(int $roundness)
 * @method static \Sileo\Notifications\SileoNotification styles(array $styles)
 * @method static \Sileo\Notifications\SileoNotification option(string $key, mixed $value)
 * @method static \Sileo\Notifications\SileoNotification options(array $options)
 * @method static \Sileo\Notifications\SileoNotification button(string $label, string $event, array $params = [])
 * @method static \Sileo\Notifications\SileoNotification success(string|array|null $title = null, string $description = '', int|null $duration = null, Position|string $position = Position::TopRight)
 * @method static \Sileo\Notifications\SileoNotification error(string|array|null $title = null, string $description = '', int|null $duration = null, Position|string $position = Position::TopRight)
 * @method static \Sileo\Notifications\SileoNotification warning(string|array|null $title = null, string $description = '', int|null $duration = null, Position|string $position = Position::TopRight)
 * @method static \Sileo\Notifications\SileoNotification info(string|array|null $title = null, string $description = '', int|null $duration = null, Position|string $position = Position::TopRight)
 * @method static \Sileo\Notifications\SileoNotification loading(string|array|null $title = null, string $description = '', int|null $duration = null, Position|string $position = Position::TopRight)
 * @method static \Sileo\Notifications\SileoNotification danger(string|array|null $title = null, string $description = '', int|null $duration = null, Position|string $position = Position::TopRight)
 * @method static \Sileo\Notifications\SileoNotification action(string|array|null $options = null)
 * @method static \Sileo\Notifications\SileoNotification promise(string|array $options)
 */
class Sileo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'sileo';
    }
}

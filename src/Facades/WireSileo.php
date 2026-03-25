<?php

namespace mrclln\WireSileo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \mrclln\WireSileo\WireSileo title(string $title)
 * @method static \mrclln\WireSileo\WireSileo description(string $description)
 * @method static \mrclln\WireSileo\WireSileo success()
 * @method static \mrclln\WireSileo\WireSileo error()
 * @method static \mrclln\WireSileo\WireSileo warning()
 * @method static \mrclln\WireSileo\WireSileo info()
 * @method static \mrclln\WireSileo\WireSileo loading()
 * @method static \mrclln\WireSileo\WireSileo action()
 * @method static \mrclln\WireSileo\WireSileo position(string $position)
 * @method static \mrclln\WireSileo\WireSileo topLeft()
 * @method static \mrclln\WireSileo\WireSileo topCenter()
 * @method static \mrclln\WireSileo\WireSileo topRight()
 * @method static \mrclln\WireSileo\WireSileo bottomLeft()
 * @method static \mrclln\WireSileo\WireSileo bottomCenter()
 * @method static \mrclln\WireSileo\WireSileo bottomRight()
 * @method static \mrclln\WireSileo\WireSileo duration(?int $duration)
 * @method static \mrclln\WireSileo\WireSileo persistent()
 * @method static \mrclln\WireSileo\WireSileo icon($icon)
 * @method static \mrclln\WireSileo\WireSileo noIcon()
 * @method static \mrclln\WireSileo\WireSileo styles(array $styles)
 * @method static \mrclln\WireSileo\WireSileo fill(string $fill)
 * @method static \mrclln\WireSileo\WireSileo roundness(int $roundness)
 * @method static \mrclln\WireSileo\WireSileo button(string $title, ?string $action = null)
 * @method static void show()
 *
 * @see \mrclln\WireSileo\WireSileo
 */
class WireSileo extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'wire-sileo';
    }
}

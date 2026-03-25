<?php

namespace mrclln\WireSileo\Concerns;

use mrclln\WireSileo\WireSileo;

trait InteractsWithSileo
{
    /**
     * Get a new WireSileo instance.
     */
    protected function sileo(): WireSileo
    {
        return new WireSileo($this);
    }

    /**
     * Show a success toast.
     */
    protected function sileoSuccess(string $title, ?string $description = null): void
    {
        $this->sileo()
            ->success()
            ->title($title)
            ->description($description ?? '')
            ->show();
    }

    /**
     * Show an error toast.
     */
    protected function sileoError(string $title, ?string $description = null): void
    {
        $this->sileo()
            ->error()
            ->title($title)
            ->description($description ?? '')
            ->show();
    }

    /**
     * Show a warning toast.
     */
    protected function sileoWarning(string $title, ?string $description = null): void
    {
        $this->sileo()
            ->warning()
            ->title($title)
            ->description($description ?? '')
            ->show();
    }

    /**
     * Show an info toast.
     */
    protected function sileoInfo(string $title, ?string $description = null): void
    {
        $this->sileo()
            ->info()
            ->title($title)
            ->description($description ?? '')
            ->show();
    }
}

<?php

namespace mrclln\WireSileo\Contracts;

interface Alertable
{
    /**
     * Set the toast title.
     */
    public function title(string $title): static;

    /**
     * Set the toast description.
     */
    public function description(string $description): static;

    /**
     * Set the toast type to success.
     */
    public function success(): static;

    /**
     * Set the toast type to error.
     */
    public function error(): static;

    /**
     * Set the toast type to warning.
     */
    public function warning(): static;

    /**
     * Set the toast type to info.
     */
    public function info(): static;

    /**
     * Set the toast type to loading.
     */
    public function loading(): static;

    /**
     * Set the toast type to action.
     */
    public function action(): static;

    /**
     * Set the toast position.
     */
    public function position(string $position): static;

    /**
     * Set toast position to top-left.
     */
    public function topLeft(): static;

    /**
     * Set toast position to top-center.
     */
    public function topCenter(): static;

    /**
     * Set toast position to top-right.
     */
    public function topRight(): static;

    /**
     * Set toast position to bottom-left.
     */
    public function bottomLeft(): static;

    /**
     * Set toast position to bottom-center.
     */
    public function bottomCenter(): static;

    /**
     * Set toast position to bottom-right.
     */
    public function bottomRight(): static;

    /**
     * Set the toast duration (in milliseconds).
     */
    public function duration(?int $duration): static;

    /**
     * Set the toast to persist indefinitely.
     */
    public function persistent(): static;

    /**
     * Set a custom icon.
     */
    public function icon($icon): static;

    /**
     * Remove the default icon.
     */
    public function noIcon(): static;

    /**
     * Set custom styles.
     */
    public function styles(array $styles): static;

    /**
     * Set the fill color.
     */
    public function fill(string $fill): static;

    /**
     * Set the border radius.
     */
    public function roundness(int $roundness): static;

    /**
     * Add a button to the toast.
     */
    public function button(string $title, ?string $action = null): static;

    /**
     * Show the toast.
     */
    public function show(): void;
}

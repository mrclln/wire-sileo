<?php

namespace mrclln\WireSileo\Concerns;

trait Sileo
{
    /**
     * Show a Sileo toast notification.
     */
    protected function alert(array $options): void
    {
        $optionsJson = json_encode($options);

        $js = <<<JS
            (function() {
                const options = {$optionsJson};

                // Handle button onClick callback
                if (options.button && options.button.onClick) {
                    options.button.onClick = eval(options.button.onClick);
                }

                // Use the appropriate Sileo method based on type
                const type = options.type || 'info';

                if (type === 'success') {
                    sileo.success(options);
                } else if (type === 'error') {
                    sileo.error(options);
                } else if (type === 'warning') {
                    sileo.warning(options);
                } else if (type === 'loading') {
                    sileo.show({ ...options, type: 'loading' });
                } else if (type === 'action') {
                    sileo.action(options);
                } else {
                    sileo.info(options);
                }
            })();
        JS;

        $this->component->js($js);
    }

    /**
     * Show a simple toast without title.
     */
    protected function toast(string $message, string $type = 'info'): void
    {
        $this->alert([
            'description' => $message,
            'type' => $type,
        ]);
    }
}

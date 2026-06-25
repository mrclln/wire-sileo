# wire-sileo

A Laravel Livewire package that brings the Sileo toast notification system to Livewire applications with a fluent, facade-first API.

## Installation

Install the package and frontend dependencies:

```bash
composer require mrclln/wire-sileo
npm install sileo react react-dom
```

Publish the configuration, JavaScript bridge, and view:

```bash
php artisan vendor:publish --tag=wire-sileo
```

## Setup

Add the Livewire toaster to your application layout:

```blade
<livewire:wire-sileo />
```

Import the published bridge in your app entrypoint:

```js
import './wire-sileo.js';
```

Then build your assets with Vite.

## Usage

Use the facade in your Livewire components:

```php
use Sileo\Facades\Sileo;

class MyComponent extends Component
{
    public function save(): void
    {
        Sileo::success('Saved successfully');

        Sileo::title('Delete record?')
            ->description('This action cannot be undone.')
            ->danger()
            ->confirm('Delete')
            ->cancel('Cancel')
            ->position('top-center')
            ->send();
    }
}
```

### Fluent API

- `Sileo::success('Saved successfully')`
- `Sileo::error('Something went wrong')`
- `Sileo::warning('Unsaved changes')`
- `Sileo::info('New update available')`

### Custom options

```php
Sileo::title('Welcome')
    ->description('You can customize every option.')
    ->position('bottom-right')
    ->duration(6000)
    ->theme('dark')
    ->fill('#1f2937')
    ->roundness(20)
    ->styles(['title' => 'text-white', 'button' => 'bg-slate-800'])
    ->send();
```

### Confirm / cancel

```php
Sileo::title('Delete record?')
    ->description('This cannot be undone.')
    ->danger()
    ->confirm('Delete')
    ->cancel('Cancel')
    ->send();
```

### Promise toasts

```php
Sileo::make()
    ->title('Saving...')
    ->loading()
    ->send();
```

For a promise pattern, dispatch a `sileo.promise` event from your component using browser events or your own helper.

## Configuration

Publish the configuration file using:

```bash
php artisan vendor:publish --tag=wire-sileo-config
```

Then update `config/wire-sileo.php` to change default position, theme, or styles.

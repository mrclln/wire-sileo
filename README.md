# wire-sileo

A Laravel Livewire package that brings beautiful toast notifications to your Livewire applications. Inspired by the elegant UI of [Sileo](https://github.com/hiaaryan/sileo) and built with the Livewire notification patterns pioneered by [Livewire Alert](https://github.com/jantinnerezo/livewire-alert).

## Features

- **Fluent PHP API** - Chain methods to build beautiful toasts
- **Multiple toast types** - Success, error, warning, info, loading, and action toasts
- **Promise support** - Show loading states that resolve/reject based on backend logic
- **Full customization** - Position, duration, theme, styles, and more
- **Livewire-native** - Works seamlessly with Livewire 3+ component lifecycle

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
    public function success(): void
    {
        Sileo::success('Saved successfully');
    }

    public function action(): void
    {
        Sileo::action()
            ->title('New sale')
            ->description('A new order was placed.')
            ->button('View', 'openOrder', ['id' => $order->id])
            ->send();
    }

    public function confirmAction(): void
    {
        Sileo::danger()
            ->title('Delete record?')
            ->description('This cannot be undone.')
            ->confirm('Delete', 'deleteRecord', ['id' => $id])
            ->cancel('recordDeleted') // Called when toast is dismissed
            ->send();
    }

    public function deleteRecord(): void
    {
        // Handle deletion
        $this->record->delete();
    }

    public function recordDeleted(): void
    {
        // Handle dismissal
    }
}
```

### Toast Types

| Method | Description |
|--------|-------------|
| `Sileo::success($title, $description)` | Green success toast |
| `Sileo::error($title, $description)` | Red error toast |
| `Sileo::warning($title, $description)` | Amber warning toast |
| `Sileo::info($title, $description)` | Blue info toast |
| `Sileo::loading($title, $description)` | Loading state toast |
| `Sileo::danger($title, $description)` | Alias for error() |

### Fluent Options

All toast methods return a chainable builder:

```php
Sileo::success()
    ->title('Success!')
    ->description('Your changes have been saved.')
    ->position('top-right') // or Position::TopRight
    ->duration(5000)
    ->theme('dark')
    ->fill('#1f2937')
    ->roundness(20)
    ->styles(['title' => 'text-white', 'description' => 'text-slate-300'])
    ->send();
```

### Array Configuration

Pass an array with all options at once:

```php
Sileo::success([
    'title' => 'Success!',
    'description' => 'Your changes have been saved.',
    'position' => 'top-right',
    'duration' => 5000,
    'theme' => 'dark',
    'fill' => '#1f2937',
    'roundness' => 20,
    'styles' => ['title' => 'text-white'],
])->send();
```

### Action Toasts

Toasts with a single interactive button:

```php
Sileo::action()
    ->title('New sale')
    ->description('A new order was placed.')
    ->button('View', 'openOrder', ['id' => $order->id])
    ->send();
```

For confirmation dialogs, use `confirm()` for the primary button and `cancel()` for dismissal handling:

```php
Sileo::danger()
    ->title('Delete record?')
    ->description('This cannot be undone.')
    ->confirm('Delete', 'deleteRecord', ['id' => $id])
    ->cancel('sileo.cancel') // Called when toast is dismissed
    ->send();
```

Note: Sileo action toasts only support a single button. The `cancel()` method sets up a dismiss handler.

### Promise Toasts

Promise toasts show a loading state that resolves or rejects based on your backend logic:

**Fluent API:**

```php
protected $listeners = ['saveRecord'];

public function triggerSave(): void
{
    Sileo::promise()
        ->event('saveRecord')
        ->loadingOptions(['title' => 'Saving...', 'description' => 'Please wait'])
        ->successOptions(['title' => 'Saved!', 'description' => 'Record updated'])
        ->errorOptions(['title' => 'Failed!', 'description' => 'Could not save'])
        ->send();
}

// In your event handler
public function saveRecord(): void
{
    try {
        $this->record->save();
        Sileo::promiseResolve('saveRecord');
    } catch (\Exception $e) {
        Sileo::promiseReject('saveRecord');
    }
}
```

**Array API:**

```php
protected $listeners = ['processData'];

public function triggerProcess(): void
{
    Sileo::promise([
        'event' => 'processData',
        'loading' => ['title' => 'Processing...', 'description' => 'Please wait'],
        'success' => ['title' => 'Done!', 'description' => 'Data processed'],
        'error' => ['title' => 'Failed!', 'description' => 'An error occurred'],
    ])->send();
}

// In your event handler
public function processData(): void
{
    try {
        // Your logic here
        Sileo::promiseResolve('processData');
    } catch (\Exception $e) {
        Sileo::promiseReject('processData');
    }
}
```

**Resolving Promises:**

```php
// Resolve with optional data payload
Sileo::promiseResolve('eventName', ['message' => 'Custom message']);

// Reject with optional error data
Sileo::promiseReject('eventName', ['error' => 'Custom error']);
```

### Custom Classes

Add custom CSS classes to toast elements:

```php
Sileo::success()
    ->title('Custom styled')
    ->customClasses(['font-bold', 'shadow-lg'])
    ->send();
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=wire-sileo-config
```

Configure defaults in `config/wire-sileo.php`:

```php
return [
    'position' => 'top-right',
    'theme' => 'system',
    'fill' => null,
    'roundness' => 16,
];
```

## Screenshots

<!-- Add screenshots in the `screenshots/` directory -->
<!-- Example: ![Success toast](screenshots/success.png) -->

## Demo

<!-- Add demo video/screencast to showcase the features -->

## Credits

- UI design inspired by [Sileo](https://github.com/hiaaryan/sileo) by Aaryan Khandekar
- Notification patterns inspired by [Livewire Alert](https://github.com/jantinnerezo/livewire-alert) by Jan Tinner

## License

MIT License

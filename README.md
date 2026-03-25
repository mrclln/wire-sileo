# WireSileo

A Laravel Livewire package for Sileo notifications with a fluent API and facade support.

## Installation

Install the package via Composer:

```bash
composer require mrclln/wire-sileo
```

Install Sileo and React via npm:

```bash
npm install sileo react react-dom @vitejs/plugin-react
```

## Configuration

Publish the configuration file (optional):

```bash
php artisan vendor:publish --tag=wire-sileo:config
```

## Frontend Setup

### 1. Create resources/js/sileo-setup.jsx

Create this file in your resources/js folder:

```jsx
import React from 'react';
import { createRoot } from 'react-dom/client';
import { sileo, Toaster } from 'sileo';
import 'sileo/styles.css';

// Make sileo available globally for Livewire
window.sileo = sileo;

// Create a container for the Toaster
const container = document.createElement('div');
container.id = 'sileo-toaster-root';
container.style.cssText = 'position: fixed; top: 0; right: 0; z-index: 9999; pointer-events: none;';
document.body.appendChild(container);

const root = createRoot(container);
root.render(
    <React.StrictMode>
        <Toaster position="top-right" />
    </React.StrictMode>
);
```

### 2. Update resources/js/app.js

```js
import './sileo-setup';
```

### 3. Update vite.config.js

Add the React plugin:

```javascript
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        react(), // Add this
    ],
});
```

### 4. Build your assets

```bash
npm run build
```

## Usage

### Using the Facade

```php
use mrclln\WireSileo\Facades\WireSileo;

class MyComponent extends \Livewire\Component
{
    public function save()
    {
        // Save logic here...

        WireSileo::success('Saved!', 'Your data has been saved successfully.');
    }
}
```

### Using the Trait

```php
use mrclln\WireSileo\Concerns\InteractsWithSileo;

class MyComponent extends \Livewire\Component
{
    use InteractsWithSileo;

    public function save()
    {
        // Save logic here...

        $this->sileo()
            ->success()
            ->title('Saved!')
            ->description('Your data has been saved successfully.')
            ->show();
    }

    // Or use the quick methods
    public function delete()
    {
        $this->sileoSuccess('Deleted!', 'Item deleted successfully.');
    }
}
```

### Fluent API

```php
WireSileo::title('Hello')
    ->description('This is a notification')
    ->success()
    ->position('top-right')
    ->duration(3000)
    ->show();
```

### Available Methods

**Toast Types:**
- `success()` - Green success toast
- `error()` - Red error toast
- `warning()` - Yellow warning toast
- `info()` - Blue info toast
- `loading()` - Loading spinner toast
- `action()` - Action toast

**Configuration:**
- `title(string)` - Set the toast title
- `description(string)` - Set the toast description
- `position(string)` - Set position (top-left, top-center, top-right, bottom-left, bottom-center, bottom-right)
- `topLeft()`, `topCenter()`, `topRight()`, `bottomLeft()`, `bottomCenter()`, `bottomRight()` - Quick position setters
- `duration(int|null)` - Set duration in milliseconds (null for persistent)
- `persistent()` - Make the toast persist until manually dismissed
- `icon($icon)` - Set a custom icon
- `noIcon()` - Remove the default icon
- `styles(array)` - Set custom styles
- `fill(string)` - Set fill color
- `roundness(int)` - Set border radius
- `button(string $title, ?string $action)` - Add a button with optional Livewire action

## License

MIT
